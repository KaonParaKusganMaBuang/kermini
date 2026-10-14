@extends('layouts.app')

@section('title', $vehicle->license_plate)

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div><a href="{{ route('vehicles.index') }}" class="text-decoration-none">← Vehicles</a><h1 class="page-title mt-3 mb-1">{{ $vehicle->year }} {{ $vehicle->make }} {{ $vehicle->model }}</h1><p class="text-muted mb-0">{{ $vehicle->license_plate }} · Owned by <a href="{{ route('customers.show', $vehicle->customer) }}">{{ $vehicle->customer->name }}</a></p></div>
        <div class="d-flex gap-2"><a href="{{ route('repair-jobs.create') }}" class="btn btn-primary">+ Create repair job</a><a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-outline-primary">Edit</a><form method="POST" action="{{ route('vehicles.destroy', $vehicle) }}" onsubmit="return confirm('Delete this vehicle? Vehicles with repair history cannot be deleted.')">@csrf @method('DELETE')<button class="btn btn-outline-danger">Delete</button></form></div>
    </div>
    <div class="card"><div class="card-body p-4"><h2 class="h5 fw-bold mb-3">Repair history</h2>
        @forelse ($vehicle->repairJobs as $job)
            <div class="d-flex justify-content-between align-items-center border-top py-3"><div><div class="fw-semibold">{{ $job->description }}</div><div class="small text-muted">{{ $job->opened_at->format('M j, Y') }} · {{ $job->mechanic->name }} · {{ str_replace('_', ' ', ucfirst($job->status)) }}</div></div><a href="{{ route('repair-jobs.show', $job) }}" class="btn btn-sm btn-outline-secondary">Details</a></div>
        @empty
            <p class="text-muted mb-0">No repair jobs for this vehicle.</p>
        @endforelse
    </div></div>
@endsection
