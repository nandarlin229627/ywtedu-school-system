@extends('layouts.admin')

@section('content')
<!-- CUSTOM UI/UX STYLES -->
<style>
    .card-custom {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid rgba(0, 0, 0, 0.08);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.05) !important;
    }
    .hover-bg-light {
        transition: all 0.2s ease;
    }
    .hover-bg-light:hover {
        background-color: #f8f9fa;
        color: #212529 !important;
    }
    .btn-danger.hover-bg-light:hover {
        background-color: #fff5f5;
        color: #dc3545 !important;
    }
    .table-responsive {
        border-radius: 12px;
    }
</style>

<!-- TOP BAR -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0 text-dark">Subjects Management</h4>
        <p class="text-muted small mb-0 d-none d-sm-block">Quick overview of your current academic curriculum</p>
    </div>
    <a href="{{ route('admin.subjects.create') }}" class="btn btn-success btn-sm px-3 py-2 rounded-pill shadow-sm fw-semibold d-inline-flex align-items-center">
        <i class="bi bi-plus-lg me-1"></i> Add Subject
    </a>
</div>

<!-- STATS CARDS -->
<div class="row g-3 mb-4">
    <div class="col-md-4 col-sm-6 col-12">
        <div class="card-custom stat-card py-3 px-3 text-center shadow-sm">
            <span class="text-muted small d-block mb-1 text-truncate fw-medium">Total Subjects</span>
            <h3 class="fw-bold mb-0 text-dark">{{ $subjects->count() }}</h3>
        </div>
    </div>
</div>

<!-- COMPACT DATA TABLE CARD -->
<div class="card-custom p-0 overflow-hidden shadow-sm border mb-5">
    <div class="table-responsive">
        <table class="table table-sm table-hover align-middle mb-0">
            <thead class="bg-light border-bottom">
                <tr class="text-secondary small fw-bold text-uppercase">
                    <th class="ps-3 py-3" style="width: 15%;">ID</th>
                    <th class="py-3" style="width: 65%;">Subject Name</th>
                    <th class="text-end pe-4 py-3" style="width: 20%;">Action</th>
                </tr>
            </thead>
            <tbody class="small text-dark">
            @forelse($subjects as $subject)
                <tr>
                    <td class="ps-3 text-muted font-monospace py-2">#{{ $subject->id }}</td>
                    <td class="py-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-primary d-inline-flex align-items-center justify-content-center bg-light border rounded-3" style="width: 28px; height: 28px; font-size: 0.85rem;">
                                <i class="bi bi-book-half"></i>
                            </span>
                            <span class="fw-semibold text-dark-emphasis">{{ $subject->subject_name }}</span>
                        </div>
                    </td>
                    <td class="text-end pe-3 py-2">
                        <div class="d-inline-flex gap-1">
                            <a href="{{ route('admin.subjects.edit', $subject->id) }}"
                               class="btn btn-sm p-2 text-secondary hover-bg-light rounded-3" 
                               title="Edit Subject">
                                <i class="bi bi-pencil-square fs-6"></i>
                            </a>
                            
                            <!-- Simple Native Confirmation Form -->
                            <form action="{{ route('admin.subjects.destroy', $subject->id) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete \'{{ $subject->subject_name }}\'?');"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm p-2 text-danger hover-bg-light rounded-3" title="Delete Subject">
                                    <i class="bi bi-trash3 fs-6"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center py-5 text-muted small">
                        <div class="py-3">
                            <i class="bi bi-inbox mb-2 d-block text-muted opacity-50" style="font-size: 2.5rem;"></i>
                            <p class="mb-1 fw-semibold">No Subjects Match Your Query</p>
                            <p class="text-muted text-xs mb-0">Try checking your spelling or clear the filter to view all listings.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection