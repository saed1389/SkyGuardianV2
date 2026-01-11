<?php

namespace App\Services;

use App\Models\SkyguardianAiAlerts;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TranslationService
{
    public function translateAnalysis($alertId, $targetLanguage = null)
    {
        $alert = SkyguardianAiAlerts::find($alertId);

        if (!$alert) {
            return null;
        }

        // If translations already exist and target language is available, return them
        if ($alert->translations && $targetLanguage) {
            $translations = json_decode($alert->translations, true);
            if (isset($translations[$targetLanguage])) {
                return $translations[$targetLanguage];
            }
        }

        // Prepare text to translate
        $textToTranslate = $this->prepareTextForTranslation($alert);

        // Get target languages
        $targetLanguages = $targetLanguage ? [$targetLanguage] : ['tr', 'et']; // Add more as needed

        $translations = [];

        foreach ($targetLanguages as $lang) {
            try {
                $translatedText = $this->callTranslationAPI($textToTranslate, $alert->source_language ?? 'en', $lang);

                if ($translatedText) {
                    $translations[$lang] = $this->parseTranslatedText($translatedText);
                }
            } catch (\Exception $e) {
                Log::error('Translation failed for alert ' . $alertId . ': ' . $e->getMessage());
            }
        }

        // Save translations
        if (!empty($translations)) {
            $existingTranslations = $alert->translations ? json_decode($alert->translations, true) : [];
            $allTranslations = array_merge($existingTranslations, $translations);

            $alert->update([
                'translations' => json_encode($allTranslations),
                'languages_available' => implode(',', array_keys($allTranslations)) . ',en'
            ]);
        }

        return $translations[$targetLanguage] ?? $translations;
    }

    private function prepareTextForTranslation($alert)
    {
        $sections = [
            'situation' => $alert->situation,
            'primary_concern' => $alert->primary_concern,
            'secondary_concerns' => $alert->secondary_concerns,
            'likely_scenario' => $alert->likely_scenario,
            'recommendations' => $alert->recommendations,
            'forecast' => $alert->forecast,
            'confidence' => $alert->confidence
        ];

        // Format as JSON for better context preservation
        return json_encode($sections, JSON_UNESCAPED_UNICODE);
    }

    private function callTranslationAPI($text, $sourceLang, $targetLang)
    {
        // Option 1: Using Google Translate API (requires API key)
        if (config('services.google_translate.api_key')) {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post('https://translation.googleapis.com/language/translate/v2', [
                'q' => $text,
                'source' => $sourceLang,
                'target' => $targetLang,
                'format' => 'text',
                'key' => config('services.google_translate.api_key')
            ]);

            if ($response->successful()) {
                return $response->json()['data']['translations'][0]['translatedText'];
            }
        }

        // Option 2: Using LibreTranslate (self-hosted)
        $libreTranslateUrl = config('services.libretranslate.url', 'http://localhost:5000');

        $response = Http::post($libreTranslateUrl . '/translate', [
            'q' => $text,
            'source' => $sourceLang,
            'target' => $targetLang,
            'format' => 'text'
        ]);

        if ($response->successful()) {
            return $response->json()['translatedText'];
        }

        // Option 3: Fallback to manual translation service
        return $this->fallbackTranslation($text, $sourceLang, $targetLang);
    }

    private function parseTranslatedText($translatedJson)
    {
        $translatedArray = json_decode($translatedJson, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            return $translatedArray;
        }

        // If not valid JSON, try to parse as plain text
        return [
            'situation' => $translatedJson,
            'primary_concern' => $translatedJson,
            'secondary_concerns' => $translatedJson,
            'likely_scenario' => $translatedJson,
            'recommendations' => $translatedJson,
            'forecast' => $translatedJson,
            'confidence' => $translatedJson
        ];
    }

    private function fallbackTranslation($text, $sourceLang, $targetLang)
    {
        // Implement a fallback translation method
        // This could be using a database of common translations
        // or a simpler regex-based approach

        $commonTranslations = [
            'en' => [
                'HIGH' => ['tr' => 'YÜKSEK', 'et' => 'KÕRGE'],
                'MEDIUM' => ['tr' => 'ORTA', 'et' => 'KESKMINE'],
                'LOW' => ['tr' => 'DÜŞÜK', 'et' => 'MADAL'],
                'threat' => ['tr' => 'tehdit', 'et' => 'oht'],
                'alert' => ['tr' => 'uyarı', 'et' => 'hoiatus']
            ]
        ];

        $translated = $text;
        foreach ($commonTranslations['en'] as $english => $translations) {
            if (isset($translations[$targetLang])) {
                $translated = str_ireplace($english, $translations[$targetLang], $translated);
            }
        }

        return $translated;
    }
}
