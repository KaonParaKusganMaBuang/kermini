@extends('layouts.app')

@section('title', 'Customers')

@section('content')
    <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
        <div><h1 class="page-title mb-1">Customers</h1><p class="text-muted mb-0">Manage your customer directory.</p></div>
        <a href="{{ route('customers.create') }}" class="btn btn-primary">+ Add customer</a>
    </div>
    <div class="card"><div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light"><tr><th>Name</th><th>Contact</th><th>Vehicles</th><th>Address</th><th></th></tr></thead>
            <tbody>
            @forelse ($customers as $customer)
                <tr>
                    <td class="fw-semibold">{{ $customer->name }}</td>
                    <td>{{ $customer->email ?? '—' }}<br><span class="small text-muted">{{ $customer->phone }}</span></td>
                    <td>{{ $customer->vehicles_count }}</td>
                    <td>{{ $customer->address ?: '—' }}</td>
                    <td class="text-end text-nowrap"><a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-outline-secondary">View</a> <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-outline-primary">Edit</a></td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-5">No customers yet. Add a customer to get started.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div><div class="p-3">{{ $customers->links() }}</div></div>
@endsection
