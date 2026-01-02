<div class="report-section mb-4">
    <h6 class="text-muted mb-3 border-bottom pb-2 text-white">TOP COUNTRIES BY AIRCRAFT COUNT</h6>
    <div class="table-responsive">
        <table class="table table-sm">
            <thead>
            <tr>
                <th>Country</th>
                <th>Total Aircraft</th>
                <th>Military</th>
                <th>Drones</th>
                <th>Percentage</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data['top_countries'] ?? [] as $country)
                @php
                    $total = $data['aircraft_stats']->total_aircraft ?? 1;
                    $percentage = round(($country->count / $total) * 100, 1);
                @endphp
                <tr>
                    <td>{{ $country->country }}</td>
                    <td>{{ $country->count }}</td>
                    <td>{{ $country->military }}</td>
                    <td>{{ $country->drones }}</td>
                    <td>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-primary" style="width: {{ $percentage }}%"></div>
                        </div>
                        <small>{{ $percentage }}%</small>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
