@extends('admin.layout')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Expense Details</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Expenses</a></li>
                <li class="breadcrumb-item active" aria-current="page">Details</li>
            </ol>
        </div>

        <!-- Start:: row -->
        <div class="row" id="expense-profile">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <!-- User + Expense Header -->
                        <div class="wideget-user">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="wideget-user-desc d-flex">
                                        <div class="wideget-user-img">
                                            <img src="{{ asset('assets/images/users/10.jpg') }}" alt="user-img">
                                        </div>
                                        <div class="user-wrap">
                                            <h4 class="fw-normal">{{ $expense->user->name ?? 'Unknown User' }}</h4>
                                            <h6 class="text-muted mb-3 fw-normal">Submitted: {{ $expense->created_at->format('M d, Y') }}</h6>
                                            <span class="badge
                                                @if($expense->status == 1) bg-success
                                                @elseif($expense->status == 2) bg-danger
                                                @else bg-warning @endif">
                                                {{ $expense->status == 1 ? 'Approved' : ($expense->status == 2 ? 'Rejected' : 'Pending') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 text-end">
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                        <i class="fa fa-arrow-left"></i> Back
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Tabs -->
                    <div class="border-top">
                        <div class="wideget-user-tab">
                            <div class="tab-menu-heading border-0">
                                <div class="tabs-menu1">
                                    <ul class="nav">
                                        <li><a href="#tab-profile" class="active show" data-bs-toggle="tab">User Info</a></li>
                                        <li><a href="#tab-expense" data-bs-toggle="tab">Expense Info</a></li>
                                        <li><a href="#tab-attachment" data-bs-toggle="tab">Attachment</a></li>
                                        <li><a href="#tab-actions" data-bs-toggle="tab">Actions</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Tab Content -->
                <div class="tab-content mt-3">

                    <!-- User Info -->
                    <div class="tab-pane p-3 active show" id="tab-profile">
                        <div class="card">
                            <div class="card-body">
                                <h5><strong>User Information</strong></h5>
                                <table class="table table-borderless">
                                    <tr><td><strong>Name:</strong> {{ $expense->user->name ?? '-' }}</td></tr>
                                    <tr><td><strong>Email:</strong> {{ $expense->user->email ?? '-' }}</td></tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Expense Info -->
                    <div class="tab-pane p-3" id="tab-expense">
                        <div class="card">
                            <div class="card-body">
                                <h5><strong>Expense Information</strong></h5>
                                <p><strong>Title:</strong> {{ $expense->title }}</p>
                                <p><strong>Amount:</strong> {{ number_format($expense->amount, 2) }} {{ $expense->currency ?? '' }}</p>
                                <p><strong>Description:</strong> {{ $expense->description ?? '-' }}</p>
                                <p><strong>Status:</strong>
                                    <span class="badge
                                        @if($expense->status == 1) bg-success
                                        @elseif($expense->status == 2) bg-danger
                                        @else bg-warning @endif">
                                        {{ $expense->status == 1 ? 'Approved' : ($expense->status == 2 ? 'Rejected' : 'Pending') }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Attachment -->
                    <div class="tab-pane p-3" id="tab-attachment">
                        <div class="card">
                            <div class="card-body">
                                <h5><strong>Attachment</strong></h5>
                                @if($expense->file_path)
                                    <a href="{{ asset('storage/'.$expense->file_path) }}" target="_blank" class="btn btn-primary">
                                        <i class="fa fa-file"></i> View File
                                    </a>
                                @else
                                    <p>No file uploaded</p>
                                @endif
                            </div>
                        </div>
                    </div>


                    <div class="tab-pane p-3" id="tab-actions">
                        <div class="card">
                            <div class="card-body">
                                {{-- <h5><strong>Actions</strong></h5> --}}
                                <div class="d-flex gap-2">

                                    @if($expense->status == 0)
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveModal">
                                            Approve
                                        </button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                            Reject
                                        </button>
                                    @elseif($expense->status == 1)
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($expense->status == 2)
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>


                </div><!-- tab-content -->

            </div>
        </div>
        <!-- End:: row -->

    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('expenses.approve', $expense->id) }}" method="POST">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="approveModalLabel">Approve Expense</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to approve this expense?</p>
          <div class="mb-3">
            <label for="approveRemark" class="form-label">Remark (optional)</label>
            <textarea class="form-control" id="approveRemark" name="remark" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Approve</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('expenses.reject', $expense->id) }}" method="POST">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="rejectModalLabel">Reject Expense</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to reject this expense?</p>
          <div class="mb-3">
            <label for="rejectRemark" class="form-label">Remark (optional)</label>
            <textarea class="form-control" id="rejectRemark" name="remark" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Reject</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
