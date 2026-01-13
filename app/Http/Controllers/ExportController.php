<?php

namespace App\Http\Controllers;

use App\Exports\AnalysesExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function export(Request $request, $type = 'filtered', $id = null)
    {
        if ($type === 'single' && $id) {
            $query = DB::table('skyguardian_analyses')->where('id', $id);
            $analysis = $query->first();
            $filename = 'analysis-report-' . ($analysis->analysis_id ?? $id) . '-' . date('Y-m-d-H-i-s') . '.xlsx';

            return Excel::download(
                new AnalysesExport($query, null, [], 'single'),
                $filename
            );
        } else {
            // Get filters from request
            $filters = $request->only(['time_range', 'status', 'risk', 'search']);

            $query = DB::table('skyguardian_analyses')->orderBy('analysis_time', 'desc');

            // Apply filters
            if (isset($filters['time_range']) && $filters['time_range'] !== 'all') {
                $days = match($filters['time_range']) {
                    '7days' => 7,
                    '30days' => 30,
                    '90days' => 90,
                    default => 7
                };
                $startDate = Carbon::now()->subDays($days);
                $query->where('analysis_time', '>=', $startDate);
            }

            if (isset($filters['status']) && $filters['status'] !== 'all') {
                $query->where('status', $filters['status']);
            }

            if (isset($filters['risk']) && $filters['risk'] !== 'all') {
                $query->where('overall_risk', $filters['risk']);
            }

            if (isset($filters['search']) && $filters['search']) {
                $query->where(function($q) use ($filters) {
                    $q->where('analysis_id', 'like', '%' . $filters['search'] . '%')
                        ->orWhere('status', 'like', '%' . $filters['search'] . '%')
                        ->orWhere('weather_notes', 'like', '%' . $filters['search'] . '%');
                });
            }

            $rangeText = $filters['time_range'] ?? 'all-time';
            $filename = 'analysis-history-' . $rangeText . '-' . date('Y-m-d-H-i-s') . '.xlsx';

            return Excel::download(
                new AnalysesExport($query, $filters['time_range'] ?? null, $filters, 'filtered'),
                $filename
            );
        }
    }
}
