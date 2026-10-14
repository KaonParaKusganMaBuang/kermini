@extends('layouts.app')

@section('title', $part->exists ? 'Edit part' : 'Record part')

@section('content')
    <div class="mb-4"><a href="{{ route('parts.index') }}" class="text-decoration-none">← Parts</a><h1 class="page-title mt-3 mb-1">{{ $part->exists ? 'Edit part record' : 'Record a part' }}</h1><p class="text-muted mb-0">Parts are tracked as line items on repair jobs.</p></div>
    <div class="card"><div class="card-body p-4">
        @if ($repairJobs->isEmpty())<div class="alert alert-warning">Create a repair job before recording parts.</div><a href="{{ route('repair-jobs.create') }}" class="btn btn-primary">Create repair job</a>
        @else
            <form method="POST" action="{{ $part->exists ? route('parts.update', $part) : route('parts.store') }}">
                @csrf
                @if ($part->exists) @method('PUT') @endif
                <div class="row g-3">
                    <div class="col-12"><label for="repair_job_id" class="form-label">Repair job *</label><select id="repair_job_id" name="repair_job_id" class="form-select" required><option value="">Select repair job</option>@foreach ($repairJobs as $repairJob)<option value="{{ $repairJob->id }}" @selected(old('repair_job_id', $part->repair_job_id) == $repairJob->id)>#{{ $repairJob->id }} · {{ $repairJob->vehicle->license_plate }} · {{ \Illuminate\Support\Str::limit($repairJob->description, 70) }}</option>@endforeach</select></div>
                    <div class="col-md-6"><label for="name" class="form-label">Part name *</label><input id="name" name="name" class="form-control" value="{{ old('name', $part->name) }}" maxlength="255" required></div>
                    <div class="col-md-6"><label for="part_number" class="form-label">Part number</label><input id="part_number" name="part_number" class="form-control" value="{{ old('part_number', $part->part_number) }}" maxlength="100"></div>
                    <div class="col-md-6"><label for="quantity" class="form-label">Quantity *</label><input id="quantity" name="quantity" type="number" class="form-control" value="{{ old('quantity', $part->quantity ?? 1) }}" min="1" max="1000000" required></div>
                    <div class="col-md-6"><label for="unit_price" class="form-label">Unit price ($) *</label><input id="unit_price" name="unit_price" type="number" class="form-control" value="{{ old('unit_price', $part->unit_price) }}" min="0" max="99999999.99" step="0.01" required></div>
                </div>
                <div class="d-flex gap-2 mt-4"><button class="btn btn-primary">{{ $part->exists ? 'Save changes' : 'Record part' }}</button><a href="{{ route('parts.index') }}" class="btn btn-outline-secondary">Cancel</a></div>
            </form>
        @endif
    </div></div>
@endsection
