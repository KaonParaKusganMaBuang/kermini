@extends('layouts.app')

@section('title', $mechanic->exists ? 'Edit mechanic' : 'Add mechanic')

@section('content')
    <div class="mb-4"><a href="{{ route('mechanics.index') }}" class="text-decoration-none">← Mechanics</a><h1 class="page-title mt-3 mb-1">{{ $mechanic->exists ? 'Edit mechanic' : 'Add mechanic' }}</h1><p class="text-muted mb-0">Technician details and area of expertise.</p></div>
    <div class="card"><div class="card-body p-4">
        <form method="POST" action="{{ $mechanic->exists ? route('mechanics.update', $mechanic) : route('mechanics.store') }}">
            @csrf
            @if ($mechanic->exists) @method('PUT') @endif
            <div class="row g-3">
                <div class="col-md-6"><label for="name" class="form-label">Full name *</label><input id="name" name="name" class="form-control" value="{{ old('name', $mechanic->name) }}" maxlength="255" required></div>
                <div class="col-md-6"><label for="specialty" class="form-label">Specialty *</label><input id="specialty" name="specialty" class="form-control" value="{{ old('specialty', $mechanic->specialty) }}" maxlength="255" placeholder="e.g. Engine repair" required></div>
                <div class="col-md-6"><label for="phone" class="form-label">Phone *</label><input id="phone" name="phone" class="form-control" value="{{ old('phone', $mechanic->phone) }}" maxlength="30" required></div>
                <div class="col-md-6"><label for="email" class="form-label">Email</label><input id="email" name="email" type="email" class="form-control" value="{{ old('email', $mechanic->email) }}" maxlength="255"></div>
            </div>
            <div class="d-flex gap-2 mt-4"><button class="btn btn-primary">{{ $mechanic->exists ? 'Save changes' : 'Add mechanic' }}</button><a href="{{ route('mechanics.index') }}" class="btn btn-outline-secondary">Cancel</a></div>
        </form>
    </div></div>
@endsection
