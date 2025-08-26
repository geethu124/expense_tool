 @extends('Employees.layout')
 @section('content')
 <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">
                 <!-- Alerts -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <!-- Alerts End -->


                <!-- PAGE-HEADER -->
                <div class="page-header">
                    <h1 class="page-title">Expense List</h1>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
                        <i class="bi bi-plus-circle"></i> Add Expense
                    </button>
                </div>
                <!-- PAGE-HEADER END -->

                <!-- Add Expense Modal -->
                <!-- Add Expense Modal -->
                <div class="modal fade" id="addExpenseModal" tabindex="-1" aria-labelledby="addExpenseModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="{{ route('expenses.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addExpenseModalLabel">Add New Expense</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" name="title" class="form-control" id="title" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="amount" class="form-label">Amount</label>
                                        <input type="number" step="0.01" name="amount" class="form-control" id="amount" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="file_path" class="form-label">File Upload</label>
                                        <input type="file" name="file_path" class="form-control" id="file_path" required>
                                    </div>


                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Add Expense</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>



                <!-- Start::row-1 -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header">
                                <div class="card-title">
                                     Expense List
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable-basic" class="table table-bordered text-nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Title</th>
                                                <th>Amount</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th>Attachment</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($expenses as $expense)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $expense->title }}</td>
                                                    <td>{{ $expense->amount }}</td>
                                                    <td>{{ $expense->description }}</td>
                                                    <td>
                                                        @if($expense->status == 1)
                                                            <span class="badge bg-success">Approved</span>
                                                        @elseif($expense->status == 2)
                                                            <span class="badge bg-danger">Rejected</span>
                                                        @else
                                                            <span class="badge bg-warning">Pending</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $expense->created_at->format('Y-m-d') }}</td>
                                                    <td>
                                                        @if($expense->file_path)
                                                            <a href="{{ asset('storage/'.$expense->file_path) }}" target="_blank">View</a>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-primary editBtn"
                                                            data-id="{{ $expense->id }}"
                                                            data-title="{{ $expense->title }}"
                                                            data-amount="{{ $expense->amount }}"
                                                            data-description="{{ $expense->description }}"
                                                            data-file="{{ $expense->file_path }}"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editExpenseModal">
                                                            Edit
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>


                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End::row-1 -->



            </div>
        </div>
        <!-- End::app-content -->
        <div class="modal fade" id="editExpenseModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <form id="editExpenseForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                <h5 class="modal-title">Edit Expense</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editExpenseId" name="id">

                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" id="editTitle" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Amount</label>
                        <input type="number" name="amount" id="editAmount" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="editDescription" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Attachment</label>
                        <input type="file" name="file_path" class="form-control">
                        <small id="currentFile"></small>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
            </div>
        </div>
        </div>


        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function() {
    // Open modal and fill fields
    $(".editBtn").on("click", function() {
        let id = $(this).data("id");
        let title = $(this).data("title");
        let amount = $(this).data("amount");
        let description = $(this).data("description");
        let file = $(this).data("file");

        $("#editExpenseId").val(id);
        $("#editTitle").val(title);
        $("#editAmount").val(amount);
        $("#editDescription").val(description);
        $("#currentFile").html(file ? `<a href="/storage/${file}" target="_blank">View Current File</a>` : "No file uploaded");
    });

    // Submit update via AJAX
    $("#editExpenseForm").on("submit", function(e) {
        e.preventDefault();

        let id = $("#editExpenseId").val();
        let formData = new FormData(this);

        $.ajax({
            url: `/expenses/${id}`,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {

                $("#editExpenseModal").modal("hide");


                Swal.fire({
                    icon: 'success',
                    title: 'Updated!',
                    text: response.message,
                    confirmButtonText: 'OK'
                }).then(() => {

                    location.reload();
                });


            },
           error: function(xhr) {
            let errorMessage = "Something went wrong!";

            if (xhr.responseJSON) {
                if (xhr.responseJSON.errors) {

                    errorMessage = Object.values(xhr.responseJSON.errors)
                        .flat()
                        .join("\n");
                } else if (xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
            } else if (xhr.responseText) {
                errorMessage = xhr.responseText;
            }

            Swal.fire({
                icon: "error",
                title: "Error",
                text: errorMessage
            });
        }
        });
    });
});
</script>

        @endsection
