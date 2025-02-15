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
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            background-color: #ffffff;
        }

        .table th, .table td {
            text-align: center;
            padding: 12px;
            vertical-align: middle;
        }

        .table th {
            background-color: #0D6EFD;
            color: #ffffff;
            text-transform: uppercase;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }

        .dropdown-menu {
            min-width: auto;
        }

        .lni-more {
            cursor: pointer;
            color: #0D6EFD;
        }

        .lni-more:hover {
            color: #0b5ed7;
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

        /* Match My Applications heading with table header color */
        h1 {
            color: #0D6EFD; /* Matches the thead background color */
        }

                        /* Status Badges */
                        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            text-transform: capitalize;
        }



        .badge.bg-danger {
            background-color: #dc3545;
            color: #fff;
        }

        .badge.bg-warning {
            background-color: #ffc107;
            color: #000;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
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
    </style>
</head>
<body>
    <div class="wrapper">
        @include('owner/partials/aside')
        <div class="main p-3">
            <div class="text-center">
                <h1 class="mt-5">My Applications</h1>
            </div>
            <div class="row justify-content-center mt-5">
                <div class="col-sm-12 col-md-10 col-lg-10">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Search and Filter Form -->
                    <form action="{{ url()->current() }}" method="GET" class="search-filter-container mb-3 d-flex gap-2">
                        <div class="input-group flex-grow-1" style="max-width: 300px;">
                            <input type="search" name="search" id="searchInput" placeholder="Search..." class="form-control" value="{{ request('search') }}">
                        </div>
                        <div class="input-group flex-grow-1" style="max-width: 200px;">
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
                        <button type="submit" class="btn btn-primary" style="max-width: 100px;">Apply</button>
                    </form>

                    @php
                        // Define the helper function
                        function convertTo12HourFormat($time) {
                            if ($time === null || $time === '') {
                                return 'N/A';
                            }
                            return date('h:i A', strtotime($time));
                        }
                    @endphp

                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Company Name</th>
                                    <th>Destination</th>
                                    <th>Category</th>
                                    <th>Operating Hours</th>
                                    <th>Address</th>
                                    <th>Locality</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="myApplicationsTable">
                                @forelse ($applications as $application)
                                    <tr>
                                        <td data-label="#">{{ ($applications->currentPage() - 1) * $applications->perPage() + $loop->iteration }}</td>
                                        <td data-label="Company Name">{{ $application->company_name }}</td>
                                        <td data-label="Destination">{{ $application->destination_name }}</td>
                                        <td data-label="Category">{{ $application->category }}</td>
                                        <td data-label="Operating Hours">
                                            @if ($application->operating_hours)
                                                @php
                                                    $operatingHours = json_decode($application->operating_hours, true);
                                                    $formattedHours = [];
                                                    foreach ($operatingHours as $day => $hours) {
                                                        $formattedHours[] = ucfirst($day) . ': ' . convertTo12HourFormat($hours['start']) . ' - ' . convertTo12HourFormat($hours['end']);
                                                    }
                                                    echo implode(', ', $formattedHours); // Display all hours in a single line
                                                @endphp
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td data-label="Address">{{ $application->destination_address }}</td>
                                        <td data-label="Locality">{{ $application->locality }}</td>
                       

                                        <td>

                                @if($application->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($application->status === 'declined')
                                    <span class="badge bg-danger">Rejected</span>
                                    @else
                                    <span class="badge bg-secondary">Unknown</span>
                                @endif
                            </td>

                                        <td data-label="Actions">
                                            <i class="lni lni-more" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                <a href="/owner/applications/view/{{ $application->id }}" class="dropdown-item">View</a>
                                                <form action="/owner/applications/delete/{{ $application->id }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No data yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center mt-4">
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <!-- Previous Button -->
                                <li class="page-item {{ $applications->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $applications->appends(request()->query())->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">&laquo; Previous</span>
                                    </a>
                                </li>

                                <!-- Page Numbers -->
                                @for ($i = 1; $i <= $applications->lastPage(); $i++)
                                    <li class="page-item {{ $applications->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $applications->appends(request()->query())->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                <!-- Next Button -->
                                <li class="page-item {{ $applications->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $applications->appends(request()->query())->nextPageUrl() }}" aria-label="Next">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>

    <script>
        // Destination filter functionality
        document.addEventListener('DOMContentLoaded', function() {
            const filterDropdown = document.querySelector('[data-filter-dropdown]');
            const rows = document.querySelectorAll('#myApplicationsTable tr');

            if (filterDropdown) {
                filterDropdown.addEventListener('change', function() {
                    const filterValue = this.value.toLowerCase();
                    
                    rows.forEach(row => {
                        const categoryCell = row.children[3];
                        if (categoryCell) {
                            const categoryText = categoryCell.textContent.trim().toLowerCase();
                            if (filterValue === '' || categoryText === filterValue) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        }
                    });
                });
            }
        });
    </script>

    <script src="{{ asset('script.js') }}"></script>

    <!-- SweetAlert confirmation for Delete buttons -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForms = document.querySelectorAll("form[action*='/owner/applications/delete/']");
            
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>