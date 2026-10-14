@extends('layouts.app')

@section('title', 'Repair jobs')

@section('content')
    <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
        <div><h1 class="page-title mb-1">Repair jobs</h1><p class="text-muted mb-0">Track repairs from check-in through completion.</p></div>
        <a href="{{ route('repair-jobs.create') }}" class="btn btn-primary">+ Create repair job</a>
    </div>
    <div class="card"><div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light"><tr><th>Vehicle / customer</th><th>Repair</th><th>Mechanic</th><th>Status</th><th>Opened</th><th>Labor</th><th></th></tr></thead>
            <tbody>
            @forelse ($repairJobs as $repairJob)
                <tr>
                    <td class="fw-semibold">{{ $repairJob->vehicle->year }} {{ $repairJob->vehicle->make }} {{ $repairJob->vehicle->model }}<br><span class="small fw-normal text-muted">{{ $repairJob->vehicle->customer->name }} · {{ $repairJob->vehicle->license_plate }}</span></td>
                    <td>{{ \Illuminate\Support\Str::limit($repairJob->description, 55) }}</td>
                    <td>{{ $repairJob->mechanic->name }}</td>
                    <td><span class="badge text-bg-{{ $repairJob->status === 'completed' ? 'success' : ($repairJob->status === 'in_progress' ? 'primary' : 'warning') }}">{{ str_replace('_', ' ', ucfirst($repairJob->status)) }}</span></td>
                    <td>{{ $repairJob->opened_at->format('M j, Y') }}</td>
                    <td>${{ number_format((float) $repairJob->labor_cost, 2) }}</td>
                    <td class="text-end text-nowrap"><a href="{{ route('repair-jobs.show', $repairJob) }}" class="btn btn-sm btn-outline-secondary">View</a> <a href="{{ route('repair-jobs.edit', $repairJob) }}" class="btn btn-sm btn-outline-primary">Edit</a></td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-5">No repair jobs yet. Create a repair job to get started.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div><div class="p-3">{{ $repairJobs->links() }}</div></div>
@endsection
