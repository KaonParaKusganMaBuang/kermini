@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
        <div>
            <p class="text-uppercase text-muted fw-bold small mb-1">Auto repair shop management</p>
            <h1 class="page-title mb-1">Good work starts here.</h1>
            <p class="text-muted mb-0">A clear view of your shop, jobs, and people.</p>
        </div>
        <a href="{{ route('repair-jobs.create') }}" class="btn btn-primary">+ Create repair job</a>
    </div>
    <div class="row g-3 mb-4">
        @foreach ([
            ['Customers', $customerCount, 'customers.index'],
            ['Vehicles', $vehicleCount, 'vehicles.index'],
            ['Mechanics', $mechanicCount, 'mechanics.index'],
            ['Open jobs', $openJobCount, 'repair-jobs.index'],
            ['Part records', $partCount, 'parts.index'],
        ] as [$label, $count, $route])
            <div class="col-6 col-lg">
                <a href="{{ route($route) }}" class="text-decoration-none text-reset">
                    <div class="card h-100"><div class="card-body">
                        <div class="text-muted small fw-semibold">{{ $label }}</div>
                        <div class="stat-number">{{ $count }}</div>
                    </div></div>
                </a>
            </div>
        @endforeach
    </div>
    <div class="card">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center p-4">
                <div><h2 class="h5 fw-bold mb-1">Recent repair jobs</h2><p class="text-muted small mb-0">Latest activity from the shop</p></div>
                <a href="{{ route('repair-jobs.index') }}" class="btn btn-outline-secondary btn-sm">View all</a>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light"><tr><th>Vehicle</th><th>Customer</th><th>Mechanic</th><th>Status</th><th>Opened</th><th></th></tr></thead>
                    <tbody>
                    @forelse ($recentJobs as $job)
                        <tr>
                            <td class="fw-semibold">{{ $job->vehicle->year }} {{ $job->vehicle->make }} {{ $job->vehicle->model }}</td>
                            <td>{{ $job->vehicle->customer->name }}</td>
                            <td>{{ $job->mechanic->name }}</td>
                            <td><span class="badge text-bg-{{ $job->status === 'completed' ? 'success' : ($job->status === 'in_progress' ? 'primary' : 'warning') }}">{{ str_replace('_', ' ', ucfirst($job->status)) }}</span></td>
                            <td>{{ $job->opened_at->format('M j, Y') }}</td>
                            <td><a href="{{ route('repair-jobs.show', $job) }}" class="btn btn-sm btn-outline-secondary">Details</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-5">No repair jobs yet. Create your first one to get started.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
