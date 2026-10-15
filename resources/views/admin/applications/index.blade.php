@extends('layouts.admin')
@section('title', 'Applications')
@section('heading', 'Job Applications')

@section('content')
<div class="card">
    <div class="card-header">
        <form class="d-flex gap-2" method="GET">
            <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Name, email or phone...">
            <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-search"></i></button>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-admin table-hover mb-0">
            <thead><tr><th></th><th>Applicant</th><th>Contact</th><th>Position</th><th>Experience</th><th>Applied</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
            @forelse ($items as $a)
                <tr class="{{ $a->is_read ? '' : 'table-warning' }}">
                    <td>@unless($a->is_read)<span class="badge text-bg-primary">New</span>@endunless</td>
                    <td><a href="{{ route('admin.applications.show', $a) }}">{{ $a->name }}</a></td>
                    <td>{{ $a->phone }}<br><small class="text-secondary">{{ $a->email }}</small></td>
                    <td>{{ $a->job?->title ?? '— (job removed)' }}</td>
                    <td>{{ $a->experience }}</td>
                    <td class="text-nowrap">{{ $a->created_at->format('d M Y, h:i A') }}</td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('admin.applications.show', $a) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                        @if ($a->resume)<a href="{{ route('admin.applications.resume', $a) }}" class="btn btn-sm btn-outline-secondary" title="Download resume"><i class="bi bi-download"></i></a>@endif
                        <form class="d-inline" method="POST" action="{{ route('admin.applications.destroy', $a) }}" data-confirm="Delete this application?">@csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-secondary py-5">No applications yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if ($items->hasPages())<div class="card-footer bg-white">{{ $items->links('pagination::bootstrap-5') }}</div>@endif
</div>
@endsection
