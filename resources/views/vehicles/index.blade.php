@extends('layouts.app')

@section('title', 'Vehicles')

@section('content')
    <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
        <div><h1 class="page-title mb-1">Vehicles</h1><p class="text-muted mb-0">Vehicles registered by your customers.</p></div>
        <a href="{{ route('vehicles.create') }}" class="btn btn-primary">+ Add vehicle</a>
    </div>
    <div class="card"><div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light"><tr><th>Vehicle</th><th>Plate</th><th>Owner</th><th>VIN</th><th></th></tr></thead>
            <tbody>
            @forelse ($vehicles as $vehicle)
                <tr><td class="fw-semibold">{{ $vehicle->year }} {{ $vehicle->make }} {{ $vehicle->model }}</td><td>{{ $vehicle->license_plate }}</td><td><a href="{{ route('customers.show', $vehicle->customer) }}">{{ $vehicle->customer->name }}</a></td><td>{{ $vehicle->vin ?? '—' }}</td><td class="text-end text-nowrap"><a href="{{ route('vehicles.show', $vehicle) }}" class="btn btn-sm btn-outline-secondary">View</a> <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-sm btn-outline-primary">Edit</a></td></tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-5">No vehicles yet. Add a vehicle to get started.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div><div class="p-3">{{ $vehicles->links() }}</div></div>
@endsection
