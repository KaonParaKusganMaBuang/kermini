@extends('layouts.app')

@section('title', 'Parts')

@section('content')
    <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
        <div><h1 class="page-title mb-1">Parts</h1><p class="text-muted mb-0">Parts and quantities recorded against repair jobs.</p></div>
        <a href="{{ route('parts.create') }}" class="btn btn-primary">+ Record part</a>
    </div>
    <div class="card"><div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light"><tr><th>Part</th><th>Part number</th><th>Repair job</th><th>Quantity</th><th>Unit price</th><th>Total</th><th></th></tr></thead>
            <tbody>
            @forelse ($parts as $part)
                <tr><td class="fw-semibold">{{ $part->name }}</td><td>{{ $part->part_number ?? '—' }}</td><td><a href="{{ route('repair-jobs.show', $part->repairJob) }}">#{{ $part->repair_job_id }} · {{ $part->repairJob->vehicle->license_plate }}</a></td><td>{{ $part->quantity }}</td><td>${{ number_format((float) $part->unit_price, 2) }}</td><td>${{ number_format((float) $part->unit_price * $part->quantity, 2) }}</td><td class="text-end text-nowrap"><a href="{{ route('parts.show', $part) }}" class="btn btn-sm btn-outline-secondary">View</a> <a href="{{ route('parts.edit', $part) }}" class="btn btn-sm btn-outline-primary">Edit</a></td></tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-5">No parts recorded yet. Add a part to a repair job.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div><div class="p-3">{{ $parts->links() }}</div></div>
@endsection
