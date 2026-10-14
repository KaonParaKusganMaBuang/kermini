@extends('layouts.app')

@section('title', $mechanic->name)

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div><a href="{{ route('mechanics.index') }}" class="text-decoration-none">← Mechanics</a><h1 class="page-title mt-3 mb-1">{{ $mechanic->name }}</h1><p class="text-muted mb-0">{{ $mechanic->specialty }} · {{ $mechanic->phone }} · {{ $mechanic->email ?? 'No email' }}</p></div>
        <div class="d-flex gap-2"><a href="{{ route('mechanics.edit', $mechanic) }}" class="btn btn-outline-primary">Edit</a><form method="POST" action="{{ route('mechanics.destroy', $mechanic) }}" onsubmit="return confirm('Delete this mechanic? Mechanics assigned to jobs cannot be deleted.')">@csrf @method('DELETE')<button class="btn btn-outline-danger">Delete</button></form></div>
    </div>
    <div class="card"><div class="card-body p-4"><h2 class="h5 fw-bold mb-3">Assigned repair jobs</h2>
        @forelse ($mechanic->repairJobs as $job)
            <div class="d-flex justify-content-between align-items-center border-top py-3"><div><div class="fw-semibold">{{ $job->vehicle->year }} {{ $job->vehicle->make }} {{ $job->vehicle->model }} · {{ $job->vehicle->license_plate }}</div><div class="small text-muted">{{ $job->description }} · {{ str_replace('_', ' ', ucfirst($job->status)) }}</div></div><a href="{{ route('repair-jobs.show', $job) }}" class="btn btn-sm btn-outline-secondary">Details</a></div>
        @empty
            <p class="text-muted mb-0">No repair jobs assigned to this mechanic.</p>
        @endforelse
    </div></div>
@endsection
