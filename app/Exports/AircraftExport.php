<?php

namespace App\Exports;

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
use Carbon\Carbon;

class AircraftExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle, WithEvents
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
            'Hex Code',
            'Callsign',
            'Registration',
            'Type',
            'Model Name',
            'Country',
            'Category',
            'Role',
            'Military',
            'Drone',
            'NATO',
            'Threat Level',
            'Last Seen',
            'Latitude',
            'Longitude',
            'Altitude (m)',
            'Speed (km/h)',
            'Heading',
            'In Estonia'
        ];
    }

    public function map($aircraft): array
    {
        return [
            $aircraft->hex,
            $aircraft->callsign,
            $aircraft->registration,
            $aircraft->type,
            $aircraft->aircraft_name,
            $aircraft->country,
            $aircraft->category,
            $aircraft->role,
            $aircraft->is_military ? 'Yes' : 'No',
            $aircraft->is_drone ? 'Yes' : 'No',
            $aircraft->is_nato ? 'Yes' : 'No',
            $aircraft->threat_level,
            $aircraft->last_seen ? Carbon::parse($aircraft->last_seen)->format('Y-m-d H:i:s') : 'N/A',
            $aircraft->latitude ?? 'N/A',
            $aircraft->longitude ?? 'N/A',
            $aircraft->altitude ?? 'N/A',
            $aircraft->speed ?? 'N/A',
            $aircraft->heading ?? 'N/A',
            isset($aircraft->in_estonia) && $aircraft->in_estonia ? 'Yes' : 'No',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $count = $this->query->count() + 1;

        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '0d6efd']], // Primary Blue
                'alignment' => ['horizontal' => 'center', 'vertical' => 'center']
            ],
            'A2:S' . $count => [
                'borders' => [
                    'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']],
                ],
                'alignment' => ['vertical' => 'top']
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10, // Hex
            'B' => 12, // Callsign
            'C' => 12, // Reg
            'D' => 10, // Type
            'E' => 30, // Name
            'F' => 20, // Country
            'G' => 15, // Category
            'H' => 15, // Role
            'I' => 10, // Mil
            'J' => 10, // Drone
            'K' => 10, // NATO
            'L' => 10, // Threat
            'M' => 20, // Last Seen
            'N' => 12, // Lat
            'O' => 12, // Lon
            'P' => 12, // Alt
            'Q' => 12, // Speed
            'R' => 10, // Heading
            'S' => 12, // Estonia
        ];
    }

    public function title(): string
    {
        return 'Aircraft Database';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->freezePane('A2');
                $event->sheet->setAutoFilter('A1:S1');
            },
        ];
    }
}
