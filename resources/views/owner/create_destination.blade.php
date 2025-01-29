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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Consistent Button Styles */
        .btn-custom {
            background-color: #0D6EFD;
            color: #ffffff;
            border-radius: 20px;
            font-size: 0.95rem;
            padding: 8px 15px;
            transition: all 0.3s ease;
            border: none;
            animation: fadeInUp 1.5s forwards;
        }

        .btn-custom:hover {
            background-color: #0b5ed7;
            color: #ffffff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
            transform: translateY(-3px);
            animation: pulse 1s infinite alternate;
        }

        .card {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            border: none;
            border-radius: 15px;
            background-color: #ffffff;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s forwards;
        }

        .card-body {
            padding: 2rem;
        }

        label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            color: #495057;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"] {
            border-radius: 20px;
            border: 1px solid #ced4da;
            padding: 0.6rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            animation: fadeInUp 1.2s ease forwards;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="date"]:focus {
            outline: none;
            border-color: #0D6EFD;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            transform: scale(1.02);
        }

        .form-container {
            background-color: #f8f9fa;
            border-radius: 15px;
            padding: 2rem;
            margin-top: 1.5rem; /* Reduced margin */
            animation: slideIn 1.5s ease forwards;
        }

        .form-title {
            font-weight: 700;
            color: #0D6EFD;
            margin-top: 1.5rem; /* Reduced margin */
            margin-bottom: 1rem;
            font-size: 1.8rem; /* Smaller font size */
            font-family: 'Poppins', sans-serif;
            opacity: 0;
            animation: fadeInScale 1.5s forwards;
        }

        .input-group-text {
            background-color: #0D6EFD;
            color: #ffffff;
            border: none;
            border-radius: 20px 0 0 20px;
        }

        .input-group {
            margin-bottom: 1rem;
            animation: fadeInUp 1.5s ease forwards;
        }

        /* Dynamic Operating Hours Styles */
        .day-group {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 10px;
        }

        .day-group select,
        .day-group input[type="time"] {
            flex: 1;
        }

        .remove-day {
            background-color: #ff4d4d;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }

        .remove-day:hover {
            background-color: #cc0000;
        }

        /* Animation Effects */
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInScale {
            0% {
                opacity: 0;
                transform: scale(0.9);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes slideIn {
            0% {
                opacity: 0;
                transform: translateY(50px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            100% {
                transform: scale(1.05);
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        @include('owner/partials/aside')
        <div class="main p-3">
            <div class="text-center">
                <h1 class="form-title">Create Business Profile</h1>
            </div>

            <div class="row justify-content-center mt-5">
                <div class="col-sm-12 col-md-8 col-lg-10">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form action="/owner/destinations/store" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="status" value="pending">

                        <!-- First Card -->
                        <div class="card mb-4 form-container">
                            <div class="card-body">
                                <h4>Company Details</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-input-field
                                            label="Company Name"
                                            name="company_name"
                                            id="company_name"
                                            type="text"
                                            placeholder="Company Inc."
                                            :value="old('company_name')"
                                        />

                                        <x-input-field
                                            label="Company Address"
                                            name="company_address"
                                            id="company_address"
                                            type="text"
                                            placeholder="123 Street Name"
                                            :value="old('company_address')"
                                        />

                                        <x-textarea-field
                                            label="About"
                                            name="about"
                                            id="about"
                                            type="textarea"
                                            placeholder="Description of the company"
                                            :value="old('about')"
                                        />
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6">
                                                <x-input-field
                                                    label="Company Permit"
                                                    name="company_permit"
                                                    id="company_permit"
                                                    type="file"
                                                    placeholder="Permit ID"
                                                    :value="old('company_permit')"
                                                />

                                                <x-input-field
                                                    label="Location Clearance"
                                                    name="location_clearance"
                                                    id="location_clearance"
                                                    type="file"
                                                    placeholder="Location Clearance ID"
                                                    :value="old('location_clearance')"
                                                />

                                                <x-input-field
                                                    label="Barangay Clearance"
                                                    name="barangay_clearance"
                                                    id="barangay_clearance"
                                                    type="file"
                                                    placeholder="Barangay Clearance ID"
                                                    :value="old('barangay_clearance')"
                                                />

                                                <x-input-field
                                                    label="Philhealth"
                                                    name="philhealth"
                                                    id="philhealth"
                                                    type="file"
                                                    placeholder="Philhealth ID"
                                                    :value="old('philhealth')"
                                                />
                                            </div>

                                            <div class="col-sm-12 col-md-6">
                                                <x-input-field
                                                    label="Corporate Bank Account"
                                                    name="corporate_bank_account"
                                                    id="corporate_bank_account"
                                                    type="file"
                                                    placeholder="Bank Account No."
                                                    :value="old('corporate_bank_account')"
                                                />

                                                <x-input-field
                                                    label="SEC Registration"
                                                    name="sec_registration"
                                                    id="sec_registration"
                                                    type="file"
                                                    placeholder="SEC Registration No."
                                                    :value="old('sec_registration')"
                                                />

                                                <x-input-field
                                                    label="TIN"
                                                    name="tin"
                                                    id="tin"
                                                    type="file"
                                                    placeholder="TIN No."
                                                    :value="old('tin')"
                                                />

                                                <x-input-field
                                                    label="SSS"
                                                    name="sss"
                                                    id="sss"
                                                    type="file"
                                                    placeholder="SSS No."
                                                    :value="old('sss')"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Second Card -->
                        <div class="card form-container">
                            <div class="card-body">
                                <h4>Destination Details</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-input-field
                                            label="Destination Name"
                                            name="destination_name"
                                            id="destination_name"
                                            type="text"
                                            placeholder="Destination Name"
                                            :value="old('destination_name')"
                                        />

                                        <x-select-field
                                            label="Category"
                                            name="category"
                                            id="category"
                                            placeholder="Destination Category"
                                            :value="old('category')"
                                            :options="['Resort', 'Hotel', 'Park', 'Adventure', 'Sports', 'Wine & Beer', 'Restaurant', 'Fastfood', 'Church', 'Art Galleries']"
                                        />

                                        <!-- Dynamic Operating Hours Section -->
                                        <div class="mb-3">
                                            <label class="form-label">Operating Hours</label>
                                            <div id="days-container">
                                                <!-- Days will be added here dynamically -->
                                            </div>
                                            <button type="button" id="add-day" class="btn btn-secondary mt-2">Add Day</button>
                                        </div>

                                        <x-input-field
                                            label="Destination Address"
                                            name="destination_address"
                                            id="destination_address"
                                            type="text"
                                            placeholder="Ex. Panganiban Drive"
                                            :value="old('destination_address')"
                                        />

                                        <x-input-field
                                            label="Locality"
                                            name="locality"
                                            id="locality"
                                            type="text"
                                            placeholder="Ex. Naga"
                                            :value="old('Locality')"
                                        />
                                    </div>
                                    <div class="col-md-6">
                                        <x-input-field
                                            label="Nearest Landmark 1"
                                            name="nearest_landmark1"
                                            id="nearest_landmark1"
                                            type="text"
                                            placeholder="Landmark 1"
                                            :value="old('nearest_landmark1')"
                                        />

                                        <x-input-field
                                            label="Nearest Landmark 2"
                                            name="nearest_landmark2"
                                            id="nearest_landmark2"
                                            type="text"
                                            placeholder="Landmark 2"
                                            :value="old('nearest_landmark2')"
                                        />

                                        <x-input-field
                                            label="Nearest Landmark 3"
                                            name="nearest_landmark3"
                                            id="nearest_landmark3"
                                            type="text"
                                            placeholder="Landmark 3"
                                            :value="old('nearest_landmark3')"
                                        />

                                        <x-input-field
                                            label="Amenities"
                                            name="amenities"
                                            id="amenities"
                                            type="textarea"
                                            placeholder="List of amenities"
                                            :value="old('amenities')"
                                            required
                                        />
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-12">
                                        <button class="btn btn-custom w-100">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="{{ asset('script.js') }}"></script>
    <script>
        // Dynamic Operating Hours Script
        document.addEventListener('DOMContentLoaded', function () {
            const daysContainer = document.getElementById('days-container');
            const addDayButton = document.getElementById('add-day');

            addDayButton.addEventListener('click', function () {
                const dayGroup = document.createElement('div');
                dayGroup.className = 'day-group';

                const daySelect = document.createElement('select');
                daySelect.className = 'form-select';
                daySelect.name = 'operating_days[]';
                daySelect.innerHTML = `
                    <option value="mon">Monday</option>
                    <option value="tue">Tuesday</option>
                    <option value="wed">Wednesday</option>
                    <option value="thu">Thursday</option>
                    <option value="fri">Friday</option>
                    <option value="sat">Saturday</option>
                    <option value="sun">Sunday</option>
                `;

                const startTimeInput = document.createElement('input');
                startTimeInput.type = 'time';
                startTimeInput.name = 'operating_hours_start[]';
                startTimeInput.className = 'form-control';

                const endTimeInput = document.createElement('input');
                endTimeInput.type = 'time';
                endTimeInput.name = 'operating_hours_end[]';
                endTimeInput.className = 'form-control';

                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = 'remove-day';
                removeButton.textContent = 'Remove';
                removeButton.addEventListener('click', function () {
                    daysContainer.removeChild(dayGroup);
                });

                dayGroup.appendChild(daySelect);
                dayGroup.appendChild(startTimeInput);
                dayGroup.appendChild(endTimeInput);
                dayGroup.appendChild(removeButton);

                daysContainer.appendChild(dayGroup);
            });
        });

        // Locality Formatting
        document.addEventListener('DOMContentLoaded', function () {
            const localityInput = document.getElementById('locality');

            localityInput.addEventListener('blur', function (e) {
                let locality = e.target.value.trim();

                // Capitalize the first letter of each word
                locality = locality.toLowerCase().replace(/\b\w/g, char => char.toUpperCase());

                // Append "City" if it doesn't already include it
                if (!locality.toLowerCase().includes('city')) {
                    locality += ' City';
                }

                e.target.value = locality;
            });
        });
    </script>
</body>
</html>