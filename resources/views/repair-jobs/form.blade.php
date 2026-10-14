@extends('layouts.app')

@section('title', $repairJob->exists ? 'Edit repair job' : 'Create repair job')

@section('content')
    <div class="mb-4"><a href="{{ route('repair-jobs.index') }}" class="text-decoration-none">← Repair jobs</a><h1 class="page-title mt-3 mb-1">{{ $repairJob->exists ? 'Edit repair job' : 'Create repair job' }}</h1><p class="text-muted mb-0">Record the vehicle, assigned mechanic, work, and status.</p></div>
    <div class="card"><div class="card-body p-4">
        @if ($vehicles->isEmpty() || $mechanics->isEmpty())
            <div class="alert alert-warning">You need at least one vehicle and one mechanic before creating a repair job.</div>
            <div class="d-flex flex-wrap gap-2">@if ($vehicles->isEmpty())<a href="{{ route('vehicles.create') }}" class="btn btn-primary">Add vehicle</a>@endif @if ($mechanics->isEmpty())<a href="{{ route('mechanics.create') }}" class="btn btn-outline-primary">Add mechanic</a>@endif</div>
        @else
            <form method="POST" action="{{ $repairJob->exists ? route('repair-jobs.update', $repairJob) : route('repair-jobs.store') }}">
                @csrf
                @if ($repairJob->exists) @method('PUT') @endif
                <div class="row g-3">
                    <div class="col-md-6"><label for="vehicle_id" class="form-label">Vehicle *</label><select id="vehicle_id" name="vehicle_id" class="form-select" required><option value="">Select vehicle</option>@foreach ($vehicles as $vehicle)<option value="{{ $vehicle->id }}" @selected(old('vehicle_id', $repairJob->vehicle_id) == $vehicle->id)>{{ $vehicle->year }} {{ $vehicle->make }} {{ $vehicle->model }} · {{ $vehicle->license_plate }} ({{ $vehicle->customer->name }})</option>@endforeach</select></div>
                    <div class="col-md-6"><label for="mechanic_id" class="form-label">Mechanic *</label><select id="mechanic_id" name="mechanic_id" class="form-select" required><option value="">Select mechanic</option>@foreach ($mechanics as $mechanic)<option value="{{ $mechanic->id }}" @selected(old('mechanic_id', $repairJob->mechanic_id) == $mechanic->id)>{{ $mechanic->name }} · {{ $mechanic->specialty }}</option>@endforeach</select></div>
                    <div class="col-12"><label for="description" class="form-label">Repair description *</label><textarea id="description" name="description" class="form-control" rows="3" maxlength="5000" required>{{ old('description', $repairJob->description) }}</textarea></div>
                    <div class="col-md-3"><label for="status" class="form-label">Status *</label><select id="status" name="status" class="form-select" required>@foreach (['pending' => 'Pending', 'in_progress' => 'In progress', 'completed' => 'Completed'] as $value => $label)<option value="{{ $value }}" @selected(old('status', $repairJob->status) === $value)>{{ $label }}</option>@endforeach</select></div>
                    <div class="col-md-3"><label for="labor_cost" class="form-label">Labor cost ($) *</label><input id="labor_cost" name="labor_cost" type="number" class="form-control" value="{{ old('labor_cost', $repairJob->labor_cost ?? '0.00') }}" min="0" max="99999999.99" step="0.01" required></div>
                    <div class="col-md-3"><label for="opened_at" class="form-label">Date opened *</label><input id="opened_at" name="opened_at" type="date" class="form-control" value="{{ old('opened_at', $repairJob->opened_at instanceof \DateTimeInterface ? $repairJob->opened_at->format('Y-m-d') : $repairJob->opened_at) }}" required></div>
                    <div class="col-md-3"><label for="completed_at" class="form-label">Date completed</label><input id="completed_at" name="completed_at" type="date" class="form-control" value="{{ old('completed_at', $repairJob->completed_at instanceof \DateTimeInterface ? $repairJob->completed_at->format('Y-m-d') : $repairJob->completed_at) }}"><div class="form-text">Required when status is completed.</div></div>
                </div>
                <div class="d-flex gap-2 mt-4"><button class="btn btn-primary">{{ $repairJob->exists ? 'Save changes' : 'Create repair job' }}</button><a href="{{ route('repair-jobs.index') }}" class="btn btn-outline-secondary">Cancel</a></div>
            </form>
        @endif
    </div></div>
@endsection
