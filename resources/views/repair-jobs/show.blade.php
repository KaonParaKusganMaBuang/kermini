@extends('layouts.app')

@section('title', 'Repair job #'.$repairJob->id)

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div><a href="{{ route('repair-jobs.index') }}" class="text-decoration-none">← Repair jobs</a><h1 class="page-title mt-3 mb-1">Repair job #{{ $repairJob->id }}</h1><p class="text-muted mb-0">{{ $repairJob->vehicle->year }} {{ $repairJob->vehicle->make }} {{ $repairJob->vehicle->model }} · {{ $repairJob->vehicle->license_plate }}</p></div>
        <div class="d-flex gap-2"><a href="{{ route('parts.create') }}" class="btn btn-primary">+ Add part</a><a href="{{ route('repair-jobs.edit', $repairJob) }}" class="btn btn-outline-primary">Edit</a><form method="POST" action="{{ route('repair-jobs.destroy', $repairJob) }}" onsubmit="return confirm('Delete this repair job and its part records?')">@csrf @method('DELETE')<button class="btn btn-outline-danger">Delete</button></form></div>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-md-4"><div class="card h-100"><div class="card-body"><div class="small text-muted">Customer</div><a class="fw-semibold" href="{{ route('customers.show', $repairJob->vehicle->customer) }}">{{ $repairJob->vehicle->customer->name }}</a></div></div></div>
        <div class="col-md-4"><div class="card h-100"><div class="card-body"><div class="small text-muted">Assigned mechanic</div><a class="fw-semibold" href="{{ route('mechanics.show', $repairJob->mechanic) }}">{{ $repairJob->mechanic->name }}</a></div></div></div>
        <div class="col-md-4"><div class="card h-100"><div class="card-body"><div class="small text-muted">Status</div><span class="badge text-bg-{{ $repairJob->status === 'completed' ? 'success' : ($repairJob->status === 'in_progress' ? 'primary' : 'warning') }}">{{ str_replace('_', ' ', ucfirst($repairJob->status)) }}</span></div></div></div>
    </div>
    <div class="card mb-4"><div class="card-body p-4">
        <h2 class="h5 fw-bold mb-3">Work details</h2><p>{{ $repairJob->description }}</p>
        <div class="row g-3"><div class="col-sm-4"><span class="text-muted">Opened:</span> {{ $repairJob->opened_at->format('M j, Y') }}</div><div class="col-sm-4"><span class="text-muted">Completed:</span> {{ $repairJob->completed_at?->format('M j, Y') ?? 'Not completed' }}</div><div class="col-sm-4"><span class="text-muted">Labor:</span> ${{ number_format((float) $repairJob->labor_cost, 2) }}</div></div>
    </div></div>
    <div class="card"><div class="card-body p-0">
        <div class="p-4"><h2 class="h5 fw-bold mb-0">Parts used</h2></div>
        <div class="table-responsive"><table class="table align-middle mb-0"><thead class="table-light"><tr><th>Part</th><th>Part number</th><th>Quantity</th><th>Unit price</th><th>Subtotal</th><th></th></tr></thead><tbody>
            @forelse ($repairJob->parts as $part)
                <tr><td class="fw-semibold">{{ $part->name }}</td><td>{{ $part->part_number ?? '—' }}</td><td>{{ $part->quantity }}</td><td>${{ number_format((float) $part->unit_price, 2) }}</td><td>${{ number_format((float) $part->unit_price * $part->quantity, 2) }}</td><td><a href="{{ route('parts.show', $part) }}" class="btn btn-sm btn-outline-secondary">Details</a></td></tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No parts recorded for this repair job.</td></tr>
            @endforelse
        </tbody></table></div>
    </div></div>
@endsection
