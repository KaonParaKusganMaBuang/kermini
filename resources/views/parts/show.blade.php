@extends('layouts.app')

@section('title', $part->name)

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div><a href="{{ route('parts.index') }}" class="text-decoration-none">← Parts</a><h1 class="page-title mt-3 mb-1">{{ $part->name }}</h1><p class="text-muted mb-0">{{ $part->part_number ?? 'No part number' }} · Repair job <a href="{{ route('repair-jobs.show', $part->repairJob) }}">#{{ $part->repair_job_id }}</a></p></div>
        <div class="d-flex gap-2"><a href="{{ route('parts.edit', $part) }}" class="btn btn-outline-primary">Edit</a><form method="POST" action="{{ route('parts.destroy', $part) }}" onsubmit="return confirm('Delete this part record?')">@csrf @method('DELETE')<button class="btn btn-outline-danger">Delete</button></form></div>
    </div>
    <div class="card"><div class="card-body p-4">
        <h2 class="h5 fw-bold mb-3">Part record</h2>
        <dl class="row mb-0"><dt class="col-sm-4 text-muted">Repair job</dt><dd class="col-sm-8"><a href="{{ route('repair-jobs.show', $part->repairJob) }}">#{{ $part->repair_job_id }} · {{ $part->repairJob->vehicle->license_plate }}</a></dd><dt class="col-sm-4 text-muted">Quantity</dt><dd class="col-sm-8">{{ $part->quantity }}</dd><dt class="col-sm-4 text-muted">Unit price</dt><dd class="col-sm-8">${{ number_format((float) $part->unit_price, 2) }}</dd><dt class="col-sm-4 text-muted">Subtotal</dt><dd class="col-sm-8 fw-bold">${{ number_format((float) $part->unit_price * $part->quantity, 2) }}</dd></dl>
    </div></div>
@endsection
