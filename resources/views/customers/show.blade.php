@extends('layouts.app')

@section('title', $customer->name)

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div><a href="{{ route('customers.index') }}" class="text-decoration-none">← Customers</a><h1 class="page-title mt-3 mb-1">{{ $customer->name }}</h1><p class="text-muted mb-0">{{ $customer->email ?? 'No email' }} · {{ $customer->phone }}</p></div>
        <div class="d-flex gap-2"><a href="{{ route('customers.edit', $customer) }}" class="btn btn-outline-primary">Edit</a>
            <form method="POST" action="{{ route('customers.destroy', $customer) }}" onsubmit="return confirm('Delete this customer? Customers with vehicles cannot be deleted.')">@csrf @method('DELETE')<button class="btn btn-outline-danger">Delete</button></form>
        </div>
    </div>
    <div class="card"><div class="card-body p-4">
        <h2 class="h5 fw-bold mb-3">Registered vehicles <a href="{{ route('vehicles.create') }}" class="btn btn-sm btn-primary ms-2">Add vehicle</a></h2>
        @forelse ($customer->vehicles as $vehicle)
            <div class="d-flex justify-content-between align-items-center border-top py-3">
                <div><div class="fw-semibold">{{ $vehicle->year }} {{ $vehicle->make }} {{ $vehicle->model }}</div><div class="small text-muted">{{ $vehicle->license_plate }} · {{ $vehicle->repairJobs->count() }} repair jobs</div></div>
                <a href="{{ route('vehicles.show', $vehicle) }}" class="btn btn-sm btn-outline-secondary">View</a>
            </div>
        @empty
            <p class="text-muted mb-0">No vehicles registered to this customer.</p>
        @endforelse
    </div></div>
@endsection
