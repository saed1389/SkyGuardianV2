<?php

namespace App\Exports;

use App\Models\SkyguardianAiAlerts;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class AlertsExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle, WithEvents
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Analysis ID',
            'Timestamp',
            'Threat Level',
            'Trigger Level',
            'AI Confidence %',
            'Situation Summary',
            'Primary Concern',
            'Secondary Concerns',
            'Likely Scenario',
            'Forecast',
            'Recommendations',
            'Confidence',
            'Response Length',
            'Raw Analysis Preview',
        ];
    }

    public function map($alert): array
    {
        return [
            $alert->id,
            $alert->analysis_id,
            $alert->ai_timestamp->format('Y-m-d H:i:s'),
            $alert->threat_level,
            $alert->trigger_level,
            $alert->confidence_percentage . '%',
            $alert->situation,
            $alert->primary_concern,
            $alert->secondary_concerns,
            $alert->likely_scenario,
            $alert->forecast,
            $alert->recommendations,
            $alert->confidence,
            $alert->ai_response_length,
            substr($alert->ai_analysis_raw ?? '', 0, 200) . '...',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $count = $this->query->count() + 1;

        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => ['rgb' => '2C3E50']
                ],
                'alignment' => [
                    'horizontal' => 'center',
                    'vertical' => 'center'
                ]
            ],
            'A2:O' . $count => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'CCCCCC'],
                    ],
                ],
                'alignment' => [
                    'wrapText' => true,
                    'vertical' => 'top'
                ]
            ],
            'G2:G' . $count => ['alignment' => ['wrapText' => true]],
            'H2:H' . $count => ['alignment' => ['wrapText' => true]],
            'L2:L' . $count => ['alignment' => ['wrapText' => true]],
            'O2:O' . $count => ['alignment' => ['wrapText' => true]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 15,
            'C' => 20,
            'D' => 12,
            'E' => 12,
            'F' => 15,
            'G' => 40,
            'H' => 30,
            'I' => 30,
            'J' => 25,
            'K' => 30,
            'L' => 40,
            'M' => 12,
            'N' => 15,
            'O' => 30,
        ];
    }

    public function title(): string
    {
        return 'Threat Analysis Report';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getStyle('A1:O1')->getAlignment()->setHorizontal('center');

                foreach (range('A', 'O') as $column) {
                    $event->sheet->getColumnDimension($column)->setAutoSize(true);
                }

                $event->sheet->freezePane('A2');
            },
        ];
    }
}
