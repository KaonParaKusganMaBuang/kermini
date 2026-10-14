@extends('layouts.app')

@section('title', $customer->exists ? 'Edit customer' : 'Add customer')

@section('content')
    <div class="mb-4"><a href="{{ route('customers.index') }}" class="text-decoration-none">← Customers</a><h1 class="page-title mt-3 mb-1">{{ $customer->exists ? 'Edit customer' : 'Add customer' }}</h1><p class="text-muted mb-0">Customer contact information.</p></div>
    <div class="card"><div class="card-body p-4">
        <form method="POST" action="{{ $customer->exists ? route('customers.update', $customer) : route('customers.store') }}">
            @csrf
            @if ($customer->exists) @method('PUT') @endif
            <div class="row g-3">
                <div class="col-md-6"><label for="name" class="form-label">Full name *</label><input id="name" name="name" class="form-control" value="{{ old('name', $customer->name) }}" required maxlength="255"></div>
                <div class="col-md-6"><label for="phone" class="form-label">Phone *</label><input id="phone" name="phone" class="form-control" value="{{ old('phone', $customer->phone) }}" required maxlength="30"></div>
                <div class="col-md-6"><label for="email" class="form-label">Email</label><input id="email" name="email" type="email" class="form-control" value="{{ old('email', $customer->email) }}" maxlength="255"><div class="form-text">Optional; if provided, it must be unique.</div></div>
                <div class="col-12"><label for="address" class="form-label">Address</label><textarea id="address" name="address" class="form-control" rows="3" maxlength="2000">{{ old('address', $customer->address) }}</textarea></div>
            </div>
            <div class="d-flex gap-2 mt-4"><button class="btn btn-primary">{{ $customer->exists ? 'Save changes' : 'Add customer' }}</button><a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">Cancel</a></div>
        </form>
    </div></div>
@endsection
