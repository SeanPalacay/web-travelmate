<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link rel="icon" href="{{ asset('assets/Travel.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

        /* Reviews text styling */
        h1 {
            color: #0D6EFD; /* Make "Reviews" text this color */
            margin-top: 20px; /* Add some margin on top of the "Reviews" text */
        }
    </style>
</head>
<body>
    <div class="wrapper">
        @include('owner/partials/aside')
        <div class="main p-3">
            <div class="text-center">
                <h1>Reviews</h1>
            </div>
            <div class="row justify-content-center mt-5">
                <div class="col-sm-12 col-md-12 col-lg-12">
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
                        <div class="input-group flex-grow-1">
                            <input type="search" name="search" id="searchInput" placeholder="Search..." class="form-control" value="{{ request('search') }}">
                        </div>
                        <div class="input-group flex-grow-1">
                            <select name="rating" id="ratingFilter" class="form-control">
                                <option value="">All Ratings</option>
                                <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1</option>
                                <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2</option>
                                <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3</option>
                                <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4</option>
                                <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Apply</button>
                    </form>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Company Name</th>
                                    <th>Destination</th>
                                    <th>Review Title</th>
                                    <th>Reviewer</th>
                                    <th>Ratings</th>
                                    <th>Date Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="reviewsTable">
                                @forelse ($reviews as $review)
                                    <tr>
                                        <td data-label="#">{{ ($reviews->currentPage() - 1) * $reviews->perPage() + $loop->iteration }}</td>
                                        <td data-label="Company Name">{{ $review->destination->company_name }}</td>
                                        <td data-label="Destination">{{ $review->destination->destination_name }}</td>
                                        <td data-label="Review Title">{{ $review->review_title }}</td>
                                        <td data-label="Reviewer">{{ $review->user->firstname }} {{ $review->user->lastname }}</td>
                                        <td data-label="Ratings">{{ $review->rating }}</td>
                                        <td data-label="Date Created">{{ $review->formatted_created_at }}</td>
                                        <td data-label="Actions">
                                            <i class="lni lni-more" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#proofModal{{ $review->_id }}">View</a>
                                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#reportModal{{ $review->_id }}">Report</a>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal for Proof & Comment (Unique per Review) -->
                                    <div class="modal fade" id="proofModal{{ $review->_id }}" tabindex="-1" aria-labelledby="proofLabel{{ $review->_id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow-lg">
                                                <div class="modal-header bg-light">
                                                    <h1 class="modal-title fs-4 fw-bold text-dark" id="proofLabel{{ $review->_id }}">Proof & Comment</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @if($review->proof)
                                                        <img class="img-fluid rounded mb-4 shadow-sm" 
                                                             src="https://travelmate-be.onrender.com/{{ $review->proof }}" 
                                                             alt="Proof"
                                                             onerror="this.src='{{ asset('assets/placeholder.jpg') }}'; this.onerror=null;">
                                                    @else
                                                        <p class="text-muted">No proof image available</p>
                                                    @endif
                                                    <p class="text-muted mt-3">{{ $review->comment ?? 'No comment available' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Report Modal (Unique per Review) -->
                                    <div class="modal fade" id="reportModal{{ $review->_id }}" tabindex="-1" aria-labelledby="reportLabel{{ $review->_id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow-lg">
                                                <div class="modal-header bg-light">
                                                    <h1 class="modal-title fs-4 fw-bold text-dark" id="reportLabel{{ $review->_id }}">Report Review</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form id="reportForm-{{ $review->_id }}" action="/owner/reports/store" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        @if ($errors->any())
                                                            <div class="alert alert-danger">
                                                                <ul class="mb-0">
                                                                    @foreach ($errors->all() as $error)
                                                                        <li>{{ $error }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endif
                                                        <input type="hidden" value="{{ $review->id }}" name="review_id" id="review_id">
                                                        <input type="hidden" value="{{ $review->destination_id }}" name="destination_id" id="destination_id">
                                                        <input type="hidden" name="reason" id="reasonHidden-{{ $review->_id }}">

                                                        @php
                                                            // Updated: add 'others' as a separate radio option
                                                            $reportOptions = [
                                                                ['name' => 'radio_temp', 'value' => 'False information', 'label' => 'False information'],
                                                                ['name' => 'radio_temp', 'value' => 'Offensive language', 'label' => 'Offensive language'],
                                                                ['name' => 'radio_temp', 'value' => 'Spam', 'label' => 'Spam'],
                                                                ['name' => 'radio_temp', 'value' => 'Conflict of interest', 'label' => 'Conflict of interest'],
                                                                ['name' => 'radio_temp', 'value' => 'Privacy violation', 'label' => 'Privacy violation'],
                                                                ['name' => 'radio_temp', 'value' => 'Irrelevant content', 'label' => 'Irrelevant content'],
                                                                ['name' => 'radio_temp', 'value' => 'Threats', 'label' => 'Threats'],
                                                                ['name' => 'radio_temp', 'value' => 'others', 'label' => 'Others (please specify)'],
                                                            ];
                                                        @endphp

                                                        @foreach($reportOptions as $option)
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input"
                                                                       type="radio"
                                                                       name="radio_temp"
                                                                       id="report_{{ $option['value'] }}_{{ $review->_id }}"
                                                                       value="{{ $option['value'] }}">
                                                                <label class="form-check-label" for="report_{{ $option['value'] }}_{{ $review->_id }}">
                                                                    {{ $option['label'] }}
                                                                </label>
                                                            </div>
                                                        @endforeach

                                                        <label for="others-{{ $review->_id }}" class="mt-3 fw-bold">Explain:</label>
                                                        <!-- Disabled by default; only required if "others" is chosen -->
                                                        <textarea class="form-control mt-1"
                                                                  name="others"
                                                                  id="others-{{ $review->_id }}"
                                                                  placeholder="Specify your reason here..."
                                                                  rows="3"
                                                                  disabled></textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-primary w-100 fw-bold" type="submit">Submit Report</button>
                                                    </div>
                                                </form>
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

                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center mt-4">
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <!-- Previous Button -->
                                <li class="page-item {{ $reviews->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $reviews->appends(request()->query())->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">&laquo; Previous</span>
                                    </a>
                                </li>

                                <!-- Page Numbers -->
                                @for ($i = 1; $i <= $reviews->lastPage(); $i++)
                                    <li class="page-item {{ $reviews->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $reviews->appends(request()->query())->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                <!-- Next Button -->
                                <li class="page-item {{ $reviews->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $reviews->appends(request()->query())->nextPageUrl() }}" aria-label="Next">
                                        <span aria-hidden="true">Next &raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <!-- Pagination Info -->
                    <div class="pagination-info">
                        Showing {{ $reviews->firstItem() }} to {{ $reviews->lastItem() }} of {{ $reviews->total() }} results
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript logic -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @foreach($reviews as $review)
            (function() {
                const form = document.getElementById('reportForm-{{ $review->_id }}');
                const reasonHidden = document.getElementById('reasonHidden-{{ $review->_id }}');
                const radioButtons = form.querySelectorAll('input[name="radio_temp"]');
                const othersField = document.getElementById('others-{{ $review->_id }}');

                // Listen for changes on all radio buttons
                radioButtons.forEach(radio => {
                    radio.addEventListener('change', function() {
                        if (radio.value === 'others' && radio.checked) {
                            // Enable + require the textarea
                            othersField.disabled = false;
                            othersField.required = true;
                        } else {
                            // Disable + not required + clear if any other radio is chosen
                            othersField.disabled = true;
                            othersField.required = false;
                            othersField.value = '';
                        }
                    });
                });

                // On form submit, set the hidden "reason" input
                form.addEventListener('submit', function(e) {
                    // find which radio is checked
                    let selectedRadio = Array.from(radioButtons).find(r => r.checked);

                    if (selectedRadio) {
                        // if "others," reason = the text area
                        if (selectedRadio.value === 'others') {
                            reasonHidden.value = othersField.value.trim();
                        } else {
                            // otherwise, reason = radio's value
                            reasonHidden.value = selectedRadio.value;
                        }
                    } else {
                        // If no radio is selected, see if user typed in the text area
                        let othersText = othersField.value.trim();
                        if (othersText.length > 0) {
                            reasonHidden.value = othersText;
                        }
                        // else let server handle validation
                    }
                });
            })();
            @endforeach
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>
</html>