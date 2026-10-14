@extends('layouts.app')

@section('title', 'Mechanics')

@section('content')
    <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
        <div><h1 class="page-title mb-1">Mechanics</h1><p class="text-muted mb-0">Manage your technicians and specialties.</p></div>
        <a href="{{ route('mechanics.create') }}" class="btn btn-primary">+ Add mechanic</a>
    </div>
    <div class="card"><div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light"><tr><th>Name</th><th>Specialty</th><th>Contact</th><th>Repair jobs</th><th></th></tr></thead>
            <tbody>
            @forelse ($mechanics as $mechanic)
                <tr><td class="fw-semibold">{{ $mechanic->name }}</td><td>{{ $mechanic->specialty }}</td><td>{{ $mechanic->email ?? '—' }}<br><span class="small text-muted">{{ $mechanic->phone }}</span></td><td>{{ $mechanic->repair_jobs_count }}</td><td class="text-end text-nowrap"><a href="{{ route('mechanics.show', $mechanic) }}" class="btn btn-sm btn-outline-secondary">View</a> <a href="{{ route('mechanics.edit', $mechanic) }}" class="btn btn-sm btn-outline-primary">Edit</a></td></tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-5">No mechanics yet. Add a mechanic to get started.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div><div class="p-3">{{ $mechanics->links() }}</div></div>
@endsection
