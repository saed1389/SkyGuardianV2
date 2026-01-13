<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
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
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Carbon\Carbon;

class AnalysesExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle, WithEvents
{
    protected $query;
    protected $timeRange;
    protected $filters;
    protected $exportType; // 'single' or 'filtered'

    public function __construct($query, $timeRange = null, $filters = [], $exportType = 'filtered')
    {
        $this->query = $query;
        $this->timeRange = $timeRange;
        $this->filters = $filters;
        $this->exportType = $exportType;
    }

    public function query()
    {
        return $this->query->orderBy('analysis_time', 'desc');
    }

    public function headings(): array
    {
        return [
            'Analysis ID',
            'Analysis Time',
            'Total Aircraft',
            'Military Aircraft',
            'Drones',
            'Civil Aircraft',
            'NATO Aircraft',
            'High Threat Aircraft',
            'Near Sensitive Areas',
            'Potential Threats',
            'High Speed Aircraft',
            'Low Altitude Aircraft',
            'Overall Risk',
            'Severity (1-5)',
            'Anomaly Score (0-100)',
            'Composite Score (0-100)',
            'Trend Score (0-100)',
            'Confidence %',
            'Status',
            'Is Night',
            'Is Weekend',
            'Deduplication Rate',
            'Baseline',
            'Persistent Alert',
            'Weather Multiplier',
            'Weather Significant',
            'Adjusted Anomaly Score',
            'Weather Notes',
            'Map URL',
        ];
    }

    public function map($analysis): array
    {
        return [
            $analysis->analysis_id,
            Carbon::parse($analysis->analysis_time)->format('Y-m-d H:i:s'),
            $analysis->total_aircraft,
            $analysis->military_aircraft,
            $analysis->drones,
            $analysis->civil_aircraft,
            $analysis->nato_aircraft,
            $analysis->high_threat_aircraft,
            $analysis->near_sensitive,
            $analysis->potential_threats,
            $analysis->high_speed,
            $analysis->low_altitude,
            $analysis->overall_risk,
            $analysis->severity,
            $analysis->anomaly_score,
            $analysis->composite_score,
            $analysis->trend_score,
            round($analysis->confidence * 100, 2) . '%',
            $analysis->status,
            $analysis->is_night ? 'Yes' : 'No',
            $analysis->is_weekend ? 'Yes' : 'No',
            $analysis->deduplication_rate . '%',
            $analysis->baseline,
            $analysis->persistent_alert ? 'Yes' : 'No',
            $analysis->weather_multiplier,
            $analysis->weather_significant ? 'Yes' : 'No',
            $analysis->adjusted_anomaly_score,
            $analysis->weather_notes,
            $analysis->map_url,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Get the highest row and column
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        // Style for header row (A1 to the last column in row 1)
        $sheet->getStyle('A1:' . $highestColumn . '1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => '2C3E50']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ]
        ]);

        // Style for all data cells (A2 to the last cell)
        if ($highestRow > 1) {
            $sheet->getStyle('A2:' . $highestColumn . $highestRow)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'CCCCCC'],
                    ],
                ],
                'alignment' => [
                    'wrapText' => true,
                    'vertical' => Alignment::VERTICAL_TOP
                ]
            ]);
        }

        // Auto-wrap text for specific columns (Weather Notes and Map URL)
        $columnsToWrap = ['AB', 'AC'];
        foreach ($columnsToWrap as $col) {
            if ($highestRow > 1) {
                $sheet->getStyle($col . '2:' . $col . $highestRow)->getAlignment()->setWrapText(true);
            }
        }

        // Set background colors for risk levels (Column M = Overall Risk)
        if ($highestRow > 1) {
            for ($row = 2; $row <= $highestRow; $row++) {
                $cellValue = $sheet->getCell('M' . $row)->getValue();
                $fillColor = 'FFFFFF'; // Default white

                if ($cellValue === 'HIGH') {
                    $fillColor = 'FFCCCC'; // Light red
                } elseif ($cellValue === 'MEDIUM') {
                    $fillColor = 'FFFFCC'; // Light yellow
                } elseif ($cellValue === 'LOW') {
                    $fillColor = 'CCFFCC'; // Light green
                }

                $sheet->getStyle('M' . $row)->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'color' => ['rgb' => $fillColor]
                    ]
                ]);
            }
        }

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20, // Analysis ID
            'B' => 20, // Analysis Time
            'C' => 12, // Total Aircraft
            'D' => 12, // Military Aircraft
            'E' => 10, // Drones
            'F' => 12, // Civil Aircraft
            'G' => 12, // NATO Aircraft
            'H' => 15, // High Threat Aircraft
            'I' => 15, // Near Sensitive Areas
            'J' => 15, // Potential Threats
            'K' => 15, // High Speed
            'L' => 15, // Low Altitude
            'M' => 12, // Overall Risk
            'N' => 15, // Severity
            'O' => 20, // Anomaly Score
            'P' => 20, // Composite Score
            'Q' => 15, // Trend Score
            'R' => 15, // Confidence
            'S' => 10, // Status
            'T' => 10, // Is Night
            'U' => 10, // Is Weekend
            'V' => 18, // Deduplication Rate
            'W' => 12, // Baseline
            'X' => 15, // Persistent Alert
            'Y' => 15, // Weather Multiplier
            'Z' => 15, // Weather Significant
            'AA' => 20, // Adjusted Score
            'AB' => 30, // Weather Notes
            'AC' => 40, // Map URL
        ];
    }

    public function title(): string
    {
        if ($this->exportType === 'single') {
            return 'Analysis Report';
        }

        $title = 'Analysis History Report';
        if ($this->timeRange && $this->timeRange !== 'all') {
            $rangeText = match($this->timeRange) {
                '7days' => 'Last 7 Days',
                '30days' => 'Last 30 Days',
                '90days' => 'Last 90 Days',
                default => ''
            };
            $title .= ' - ' . $rangeText;
        }

        return substr($title, 0, 31); // Excel sheet name max 31 chars
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Get the worksheet
                $sheet = $event->sheet->getDelegate();

                // Auto-size all columns
                $highestColumn = $sheet->getHighestColumn();
                $columnCount = Coordinate::columnIndexFromString($highestColumn);

                for ($col = 1; $col <= $columnCount; $col++) {
                    $columnLetter = Coordinate::stringFromColumnIndex($col);
                    $sheet->getColumnDimension($columnLetter)->setAutoSize(true);
                }

                // Freeze header row
                $sheet->freezePane('A2');

                // Add filter to header row
                $sheet->setAutoFilter('A1:' . $highestColumn . '1');

                // Add summary row
                $highestRow = $sheet->getHighestRow();
                $summaryRow = $highestRow + 2;

                // Add summary information
                $sheet->setCellValue('A' . $summaryRow, 'Export Summary:');
                $sheet->setCellValue('A' . ($summaryRow + 1), 'Total Records:');
                $sheet->setCellValue('B' . ($summaryRow + 1), $highestRow - 1);
                $sheet->setCellValue('A' . ($summaryRow + 2), 'Export Date:');
                $sheet->setCellValue('B' . ($summaryRow + 2), now()->format('Y-m-d H:i:s'));

                $currentRow = $summaryRow + 3;

                if (!empty($this->filters)) {
                    $sheet->setCellValue('A' . $currentRow, 'Applied Filters:');
                    $currentRow++;

                    foreach ($this->filters as $key => $value) {
                        if ($value && $value !== 'all') {
                            $filterLabel = ucfirst(str_replace('_', ' ', $key));
                            $sheet->setCellValue('A' . $currentRow, $filterLabel . ':');
                            $sheet->setCellValue('B' . $currentRow, $value);
                            $currentRow++;
                        }
                    }
                }

                // Style summary section if we added any summary rows
                if ($currentRow > ($summaryRow + 2)) {
                    $endRow = $currentRow - 1;
                    $sheet->getStyle('A' . $summaryRow . ':B' . $endRow)->applyFromArray([
                        'font' => ['bold' => true],
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'color' => ['rgb' => 'F0F0F0']
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['rgb' => 'DDDDDD'],
                            ],
                        ],
                    ]);
                }
            },
        ];
    }
}
