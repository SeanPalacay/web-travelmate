<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link rel="icon" href="{{ asset('assets/Travel.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
    <style>
        /* Table Styles */
        .table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            background-color: #ffffff;
            margin-bottom: 20px;
        }

        .table th, .table td {
            padding: 12px;
            text-align: left;
            vertical-align: middle;
            border-bottom: 1px solid #ddd;
        }

        .table th {
            background-color: #0D6EFD;
            color: #ffffff;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.875rem;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }

        /* Pagination Styles */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            font-size: 0.875rem;
        }

        .pagination .page-item {
            margin: 0 4px;
            list-style: none;
        }

        .pagination .page-item .page-link {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            color: #0D6EFD;
            text-decoration: none;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .pagination .page-item.active .page-link {
            background-color: #0D6EFD;
            color: #fff;
            border-color: #0D6EFD;
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #f8f9fa;
            border-color: #ddd;
        }

        .pagination .page-item .page-link:hover {
            background-color: #f1f1f1;
            color: #0D6EFD;
        }

        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child .page-link {
            border-radius: 5px;
        }

        .pagination .page-item:first-child {
            margin-right: 10px;
        }

        .pagination .page-item:last-child {
            margin-left: 10px;
        }

        /* Pagination Info */
        .pagination-info {
            text-align: center;
            margin-top: 10px;
            font-size: 0.875rem;
            color: #6c757d;
        }

        /* Search and Filter Styles */
        .search-filter-container {
            display: flex;
            gap: 10px; /* Space between search and filter */
            margin-bottom: 20px;
        }

        .search-filter-container .input-group {
            flex-grow: 1; /* Make both inputs take equal space */
        }

        .search-filter-container .form-control {
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 8px 12px;
            font-size: 0.875rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .search-filter-container .form-control:focus {
            border-color: #0D6EFD;
            box-shadow: 0 0 5px rgba(13, 110, 253, 0.5);
        }

        .search-filter-container select.form-control {
            appearance: none; /* Remove default arrow */
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px;
            padding-right: 30px; /* Space for the arrow */
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .search-filter-container {
                flex-direction: column;
            }

            .search-filter-container .input-group {
                width: 100%;
            }

            .table thead {
                display: none;
            }

            .table tr {
                display: block;
                margin-bottom: 15px;
            }

            .table td {
                display: block;
                text-align: right;
                font-size: 0.875rem;
                border-bottom: 1px solid #ddd;
                padding: 8px;
            }

            .table td:before {
                content: attr(data-label);
                float: left;
                font-weight: 600;
                color: #495057;
            }

            .table td:last-child {
                border-bottom: 0;
            }

            .table-responsive {
                border: none;
            }
        }

        /* Pending Applications text styling */
        h1 {
            color: #0D6EFD; /* Make "Pending Applications" text this color */
            margin-top: 20px; /* Add some margin on top of the "Pending Applications" text */
        }
    </style>
</head>
<body>
    <div class="wrapper">
        @include('admin/partials/aside')
        <div class="main p-3">
            <div class="text-center">
                <h1>Pending Applications</h1>
            </div>

            <div class="row justify-content-center mt-5">
                <div class="col-sm-12 col-md-10 col-lg-10">
                    <!-- SUCCESS ALERT -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <!-- SweetAlert for Success -->
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: "{{ session('success') }}",
                                showConfirmButton: false,
                                timer: 2000
                            });
                        </script>
                    @endif

                    <!-- ERROR ALERT -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Search and Filter -->
                    <div class="search-filter-container mb-3 d-flex gap-2">
                        <form action="{{ url()->current() }}" method="GET" class="search-filter-container mb-3 d-flex gap-2">
                            <div class="input-group flex-grow-1">
                                <input type="search" name="search" id="searchInput" placeholder="Search..." class="form-control" value="{{ request('search') }}">
                            </div>
                            <div class="input-group flex-grow-1">
                                <select name="category" id="filterSelect" class="form-control">
                                    <option value="">All Categories</option>
                                    <option value="Resort" {{ request('category') == 'Resort' ? 'selected' : '' }}>Resort</option>
                                    <option value="Hotel" {{ request('category') == 'Hotel' ? 'selected' : '' }}>Hotel</option>
                                    <option value="Park" {{ request('category') == 'Park' ? 'selected' : '' }}>Park</option>
                                    <option value="Adventure" {{ request('category') == 'Adventure' ? 'selected' : '' }}>Adventure</option>
                                    <option value="Sports" {{ request('category') == 'Sports' ? 'selected' : '' }}>Sports</option>
                                    <option value="Wine & Beer" {{ request('category') == 'Wine & Beer' ? 'selected' : '' }}>Wine & Beer</option>
                                    <option value="Restaurant" {{ request('category') == 'Restaurant' ? 'selected' : '' }}>Restaurant</option>
                                    <option value="Fastfood" {{ request('category') == 'Fastfood' ? 'selected' : '' }}>Fastfood</option>
                                    <option value="Church" {{ request('category') == 'Church' ? 'selected' : '' }}>Church</option>
                                    <option value="Art Galleries" {{ request('category') == 'Art Galleries' ? 'selected' : '' }}>Art Galleries</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Apply</button>
                        </form>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Business Owner</th>
                                    <th>Destination</th>
                                    <th>Category</th>
                                    <th>Locality</th>
                                    <th>Address</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="applicationsTable">
                                @forelse ($applications as $application)
                                    <tr>
                                        <td data-label="#">{{ ($applications->currentPage() - 1) * $applications->perPage() + $loop->iteration }}</td>
                                        <td data-label="Business Owner">{{ $application->user->firstname }} {{ $application->user->lastname }}</td>
                                        <td data-label="Destination">{{ $application->destination_name }}</td>
                                        <td data-label="Category">{{ $application->category }}</td>
                                        <td data-label="Locality">{{ $application->locality }}</td>
                                        <td data-label="Address">{{ $application->destination_address }}</td>
                                        <td data-label="Email">{{ $application->user->email }}</td>
                                        <td data-label="Actions">
                                            <i class="lni lni-more" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                <a href="/admin/applications/view/{{ $application->id }}" class="dropdown-item">View</a>
                                                <form action="/admin/applications/delete/{{ $application->id }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No data yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <!-- Previous Button -->
                                <li class="page-item {{ $applications->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $applications->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">&laquo; Previous</span>
                                    </a>
                                </li>
                                <!-- Page Numbers -->
                                @for ($i = 1; $i <= $applications->lastPage(); $i++)
                                    <li class="page-item {{ $applications->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $applications->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <!-- Next Button -->
                                <li class="page-item {{ $applications->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $applications->nextPageUrl() }}" aria-label="Next">
                                        <span aria-hidden="true">Next &raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <!-- Pagination Info -->
                    <div class="pagination-info">
                        Showing {{ $applications->firstItem() }} to {{ $applications->lastItem() }} of {{ $applications->total() }} results
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>
</html>