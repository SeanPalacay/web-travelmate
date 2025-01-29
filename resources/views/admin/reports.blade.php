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

        /* Status Badges */
        .badge {
            padding: 0.5em 0.75em;
            border-radius: 0.25em;
            font-size: 0.875rem;
        }

        .badge.bg-success {
            background-color: #28a745;
            color: #fff;
        }

        .badge.bg-danger {
            background-color: #dc3545;
            color: #fff;
        }

        .badge.bg-warning {
            background-color: #ffc107;
            color: #000;
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

        /* Reports text styling */
        h1 {
            color: #0D6EFD; /* Make "Reports" text this color */
            margin-top: 20px; /* Add some margin on top of the "Reports" text */
        }
    </style>
</head>
<body>
    <div class="wrapper">
        @include('admin/partials/aside')
        <div class="main p-3">
            <div class="text-center">
                <h1>Reports</h1>
            </div>

            <div class="row justify-content-center mt-5">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <!-- SUCCESS ALERT -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
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
                                <select name="reason" id="filterSelect" class="form-control">
                                    <option value="">All Reports</option>
                                    <option value="False Information"  {{ request('reason') == 'False Information'  ? 'selected' : '' }}>False Information</option>
                                    <option value="Offensive Content"   {{ request('reason') == 'Offensive Content'   ? 'selected' : '' }}>Offensive Content</option>
                                    <option value="Spam"                {{ request('reason') == 'Spam'                ? 'selected' : '' }}>Spam</option>
                                    <option value="Conflicts of Interest" {{ request('reason') == 'Conflicts of Interest' ? 'selected' : '' }}>Conflicts of Interest</option>
                                    <option value="Privacy Violation"    {{ request('reason') == 'Privacy Violation'    ? 'selected' : '' }}>Privacy Violation</option>
                                    <option value="Irrelevant Content"   {{ request('reason') == 'Irrelevant Content'   ? 'selected' : '' }}>Irrelevant Content</option>
                                    <option value="Threats or Harassment" {{ request('reason') == 'Threats or Harassment' ? 'selected' : '' }}>Threats or Harassment</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Apply</button>
                            <!-- Debugging: Display the selected reason -->
                            <input type="hidden" name="debug_reason" value="{{ request('reason') }}">
                        </form>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Destination</th>
                                    <th>Report</th>
                                    <th>Reviewer</th>
                                    <th>Ratings</th>
                                    <th>Date Created</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="reportTableBody">
                                @forelse ($reports as $report)
                                    <tr>
                                        <td data-label="#">
                                            {{ ($reports->currentPage() - 1) * $reports->perPage() + $loop->iteration }}
                                        </td>
                                        <td data-label="Destination">
                                            {{ $report->review->destination->destination_name }}
                                        </td>
                                        <td data-label="Report">
                                            {{ $report->reason }}
                                        </td>
                                        <td data-label="Reviewer">
                                            {{ $report->review->user->firstname }} {{ $report->review->user->lastname }}
                                        </td>
                                        <td data-label="Ratings">
                                            {{ $report->review->rating }}
                                        </td>
                                        <td data-label="Date Created">
                                            {{ $report->formatted_created_at }}
                                        </td>
                                        <td data-label="Status">
                                            @if($report->status == 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @elseif($report->status == 'declined')
                                                <span class="badge bg-danger">Declined</span>
                                            @else
                                                <span class="badge bg-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td data-label="Actions">
                                            <i class="lni lni-more" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                <!-- VIEW PROOF -->
                                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#proofModal{{ $report->id }}">View</a>
                                                <!-- APPROVE (DELETES REVIEW) -->
                                                <form action="/admin/reports/approve/{{ $report->id }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="dropdown-item">Approve</button>
                                                </form>
                                                <!-- DECLINE -->
                                                <form action="/admin/reports/decline/{{ $report->id }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="dropdown-item">Decline</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                        
                                    <!-- Proof & Comment Modal -->
                                    <div class="modal fade" id="proofModal{{ $report->id }}" tabindex="-1" aria-labelledby="proofLabel{{ $report->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow-lg">
                                                <div class="modal-header bg-light">
                                                    <h1 class="modal-title fs-4 fw-bold text-dark" id="proofLabel{{ $report->id }}">Proof & Comment</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @if($report->review->proof)
                                                        <img class="img-fluid rounded mb-4 shadow-sm" 
                                                            src="https://travelmate-be.onrender.com/{{ $report->review->proof }}" 
                                                            alt="Proof"
                                                            onerror="this.src='{{ asset('assets/placeholder.jpg') }}'; this.onerror=null;">
                                                    @else
                                                        <p class="text-muted">No proof image available</p>
                                                    @endif
                                                    <p class="text-muted mt-3">
                                                        {{ $report->review->comment ?? 'No comment available' }}
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary w-100 fw-bold" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                <li class="page-item {{ $reports->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $reports->appends(request()->query())->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">&laquo; Previous</span>
                                    </a>
                                </li>
                                <!-- Page Numbers -->
                                @for ($i = 1; $i <= $reports->lastPage(); $i++)
                                    <li class="page-item {{ $reports->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $reports->appends(request()->query())->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <!-- Next Button -->
                                <li class="page-item {{ $reports->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $reports->appends(request()->query())->nextPageUrl() }}" aria-label="Next">
                                        <span aria-hidden="true">Next &raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <!-- Pagination Info -->
                    <div class="pagination-info">
                        Showing {{ $reports->firstItem() }} to {{ $reports->lastItem() }} of {{ $reports->total() }} results
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