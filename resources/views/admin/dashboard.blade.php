 @extends('admin.layout')
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

                </div>
                <!-- PAGE-HEADER END -->
                     <!-- Filter Form -->
        <form method="GET" action="{{ route('admin.dashboard') }}" class="row g-2 mb-3">
            <div class="col-md-3">
                <select name="user_id" class="form-select">
                    <option value="">All Users</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Pending</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Approved</option>
                    <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>




                <!-- Start::row-1 -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header">
                                <div class="card-title">
                                    Employee Expense list
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
                                                       <a href="{{ route('expenses.show',  md5($expense->id)) }}" class="btn btn-sm btn-info">View</a>


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








        @endsection
