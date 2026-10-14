@extends('layouts.app')

@section('title', $vehicle->exists ? 'Edit vehicle' : 'Add vehicle')

@section('content')
    <div class="mb-4"><a href="{{ route('vehicles.index') }}" class="text-decoration-none">← Vehicles</a><h1 class="page-title mt-3 mb-1">{{ $vehicle->exists ? 'Edit vehicle' : 'Add vehicle' }}</h1><p class="text-muted mb-0">Assign the vehicle to an existing customer.</p></div>
    <div class="card"><div class="card-body p-4">
        @if ($customers->isEmpty())<div class="alert alert-warning">Add a customer before registering a vehicle.</div><a href="{{ route('customers.create') }}" class="btn btn-primary">Add customer</a>
        @else
            <form method="POST" action="{{ $vehicle->exists ? route('vehicles.update', $vehicle) : route('vehicles.store') }}">
                @csrf
                @if ($vehicle->exists) @method('PUT') @endif
                <div class="row g-3">
                    <div class="col-md-6"><label for="customer_id" class="form-label">Customer *</label><select id="customer_id" name="customer_id" class="form-select" required><option value="">Select customer</option>@foreach ($customers as $customer)<option value="{{ $customer->id }}" @selected(old('customer_id', $vehicle->customer_id) == $customer->id)>{{ $customer->name }}</option>@endforeach</select></div>
                    <div class="col-md-3"><label for="make" class="form-label">Make *</label><input id="make" name="make" class="form-control" value="{{ old('make', $vehicle->make) }}" maxlength="100" required></div>
                    <div class="col-md-3"><label for="model" class="form-label">Model *</label><input id="model" name="model" class="form-control" value="{{ old('model', $vehicle->model) }}" maxlength="100" required></div>
                    <div class="col-md-4"><label for="year" class="form-label">Year *</label><input id="year" name="year" type="number" class="form-control" value="{{ old('year', $vehicle->year) }}" min="1886" max="{{ now()->year + 1 }}" required></div>
                    <div class="col-md-4"><label for="license_plate" class="form-label">License plate *</label><input id="license_plate" name="license_plate" class="form-control" value="{{ old('license_plate', $vehicle->license_plate) }}" maxlength="30" required></div>
                    <div class="col-md-4"><label for="vin" class="form-label">VIN</label><input id="vin" name="vin" class="form-control" value="{{ old('vin', $vehicle->vin) }}" minlength="17" maxlength="17"><div class="form-text">Optional; exactly 17 characters.</div></div>
                </div>
                <div class="d-flex gap-2 mt-4"><button class="btn btn-primary">{{ $vehicle->exists ? 'Save changes' : 'Add vehicle' }}</button><a href="{{ route('vehicles.index') }}" class="btn btn-outline-secondary">Cancel</a></div>
            </form>
        @endif
    </div></div>
@endsection
