@extends('layouts.app')

@section('title', 'All Gatepasses')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">All Gatepasses</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('security.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="row mb-4">
        <div class="col-12">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('security.gatepasses.pending') }}">
                        <i class="fas fa-clock"></i> Pending
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('security.gatepasses.approved') }}">
                        <i class="fas fa-check-circle"></i> Approved
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('security.gatepasses.rejected') }}">
                        <i class="fas fa-times-circle"></i> Rejected
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('security.gatepasses') }}">
                        <i class="fas fa-list"></i> All Gatepasses
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Gatepasses Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">All Gatepasses</h6>
                    <span class="badge bg-info">{{ $gatepasses->total() }} Records</span>
                </div>
                <div class="card-body">
                    @if($gatepasses->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Student Name</th>
                                        <th>Register No.</th>
                                        <th>Date</th>
                                        <th>Out Time</th>
                                        <th>In Time</th>
                                        <th>Reason</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($gatepasses as $gatepass)
                                    <tr>
                                        <td>{{ $gatepass->id }}</td>
                                        <td>{{ $gatepass->student->name ?? 'N/A' }}</td>
                                        <td>{{ $gatepass->student->register_number ?? 'N/A' }}</td>
                                        <td>{{ $gatepass->gatepass_date }}</td>
                                        <td>{{ $gatepass->out_time }}</td>
                                        <td>{{ $gatepass->in_time }}</td>
                                        <td>{{ Str::limit($gatepass->reason, 30) }}</td>
                                        <td>
                                            @switch($gatepass->status)
                                                @case('pending')
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                    @break
                                                @case('staff_approved')
                                                    <span class="badge bg-info">Staff Approved</span>
                                                    @break
                                                @case('staff_rejected')
                                                    <span class="badge bg-danger">Staff Rejected</span>
                                                    @break
                                                @case('hod_approved')
                                                    <span class="badge bg-primary">HOD Approved</span>
                                                    @break
                                                @case('hod_rejected')
                                                    <span class="badge bg-danger">HOD Rejected</span>
                                                    @break
                                                @case('warden_approved')
                                                    <span class="badge bg-success">Warden Approved</span>
                                                    @break
                                                @case('warden_rejected')
                                                    <span class="badge bg-danger">Warden Rejected</span>
                                                    @break
                                                @case('final_approved')
                                                    <span class="badge bg-success">Final Approved</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-secondary">{{ $gatepass->status }}</span>
                                            @endswitch
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-primary" onclick="viewDetails({{ $gatepass->id }})">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                @if($gatepass->status === 'final_approved')
                                                    <button class="btn btn-sm btn-danger" onclick="quickExit({{ $gatepass->id }})">
                                                        <i class="fas fa-sign-out-alt"></i> Exit
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Showing {{ $gatepasses->firstItem() }} to {{ $gatepasses->lastItem() }} of {{ $gatepasses->total() }} entries
                            </div>
                            {{ $gatepasses->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                            <h5 class="text-gray-500">No gatepasses found</h5>
                            <p class="text-gray-400">No gatepasses have been created yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function viewDetails(gatepassId) {
    // You can implement a modal or redirect to detailed view
    window.open(`/security/gatepasses/${gatepassId}`, '_blank');
}

function quickExit(gatepassId) {
    if (confirm('Are you sure you want to mark exit for this gatepass?')) {
        fetch('{{ route("security.mark.exit") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ gatepass_id: gatepassId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Exit marked successfully!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error marking exit. Please try again.');
        });
    }
}
</script>
@endpush
