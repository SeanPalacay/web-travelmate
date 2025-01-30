<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title }}</title>
  <link rel="icon" href="{{ asset('assets/Travel.png') }}" type="image/x-icon">
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous"
  >
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('styles.css') }}">
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap"
    rel="stylesheet"
  >
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
    }

    .card {
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
      border: none;
      border-radius: 15px;
      background-color: #ffffff;
      margin-bottom: 1.5rem;
    }

    .card-body {
      padding: 2rem;
    }

    .form-title {
      font-weight: 700;
      color: #0D6EFD;
      margin-top: 1.5rem;
      margin-bottom: 1rem;
      font-size: 1.8rem;
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
    input[type="date"],
    textarea,
    select {
      border-radius: 10px;
      border: 1px solid #ced4da;
      padding: 0.6rem 1rem;
      font-size: 0.95rem;
      transition: all 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus,
    input[type="date"]:focus,
    textarea:focus,
    select:focus {
      outline: none;
      border-color: #0D6EFD;
      box-shadow: 0 0 5px rgba(13, 110, 253, 0.3);
    }

    .form-container {
      background-color: #ffffff;
      border-radius: 15px;
      padding: 2rem;
      margin-top: 1.5rem;
    }

    .btn-primary {
      background-color: #0D6EFD;
      border: none;
      border-radius: 10px;
      padding: 0.75rem 1.5rem;
      font-size: 1rem;
      font-weight: 600;
      transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #0b5ed7;
    }

    .btn-secondary {
      background-color: #6c757d;
      border: none;
      border-radius: 10px;
      padding: 0.75rem 1.5rem;
      font-size: 1rem;
      font-weight: 600;
      transition: background-color 0.3s ease;
    }

    .btn-secondary:hover {
      background-color: #5a6268;
    }

    .day-group {
      display: flex;
      gap: 10px;
      align-items: center;
      margin-bottom: 10px;
    }

    .day-group select,
    .day-group input {
      flex: 1;
    }

    .remove-day {
      background-color: #dc3545;
      color: white;
      border: none;
      border-radius: 10px;
      padding: 0.5rem 1rem;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .remove-day:hover {
      background-color: #c82333;
    }

    .modal-content {
      border-radius: 15px;
    }

    .modal-header {
      border-bottom: none;
    }

    .modal-footer {
      border-top: none;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    @include('owner/partials/aside')
    <div class="main p-3">
      <div class="text-center">
        <h1 class="form-title">{{ $application->destination_name }}</h1>
      </div>

      <div class="row justify-content-center mt-5">
        <div class="col-sm-12 col-md-10 col-lg-10">
          @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
              ></button>
            </div>
          @endif

          <form
            action="/owner/applications/update/{{ $application->id }}"
            method="POST"
            enctype="multipart/form-data"
            id="editApplicationForm"
          >
            @csrf
            @method('PUT')

            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
            <input type="hidden" name="status" value="approved">

            <!-- First Card: Company Details -->
            <div class="card form-container">
              <div class="card-body">
                <h4 class="mb-4">Company Details</h4>
                <div class="row">
                  <div class="col-md-6">
                    <x-input-field
                      label="Company Name"
                      name="company_name"
                      id="company_name"
                      type="text"
                      placeholder="Company Inc."
                      :value="old('company_name', $application->company_name ?? '')"
                    />

                    <x-input-field
                      label="Company Address"
                      name="company_address"
                      id="company_address"
                      type="text"
                      placeholder="123 Street Name"
                      :value="old('company_address', $application->company_address ?? '')"
                    />

                    <x-textarea-field
                      label="About"
                      name="about"
                      id="about"
                      type="textarea"
                      placeholder="Description of the company"
                      :value="old('about', $application->about ?? '')"
                    />
                  </div>

                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-sm-12 col-md-6">
                        <div class="mb-3">
                          <label for="company_permit" class="form-label">Company Permit</label>
                          @if ($application->company_permit)
                            <div class="mb-2">
                              <a href="{{ asset('images/company_permit/' . $application->company_permit) }}" target="_blank">
                                View Current File
                              </a>
                            </div>
                          @endif
                          <input type="file" name="company_permit" id="company_permit" class="form-control">
                        </div>

                        <div class="mb-3">
                          <label for="location_clearance" class="form-label">Location Clearance</label>
                          @if ($application->location_clearance)
                            <div class="mb-2">
                              <a href="{{ asset('images/location_clearance/' . $application->location_clearance) }}" target="_blank">
                                View Current File
                              </a>
                            </div>
                          @endif
                          <input type="file" name="location_clearance" id="location_clearance" class="form-control">
                        </div>

                        <div class="mb-3">
                          <label for="barangay_clearance" class="form-label">Barangay Clearance</label>
                          @if ($application->barangay_clearance)
                            <div class="mb-2">
                              <a href="{{ asset('images/barangay_clearance/' . $application->barangay_clearance) }}" target="_blank">
                                View Current File
                              </a>
                            </div>
                          @endif
                          <input type="file" name="barangay_clearance" id="barangay_clearance" class="form-control">
                        </div>

                        <div class="mb-3">
                          <label for="philhealth" class="form-label">Philhealth</label>
                          @if ($application->philhealth)
                            <div class="mb-2">
                              <a href="{{ asset('images/philhealth/' . $application->philhealth) }}" target="_blank">
                                View Current File
                              </a>
                            </div>
                          @endif
                          <input type="file" name="philhealth" id="philhealth" class="form-control">
                        </div>
                      </div>

                      <div class="col-sm-12 col-md-6">
                        <div class="mb-3">
                          <label for="corporate_bank_account" class="form-label">Corporate Bank Account</label>
                          @if ($application->corporate_bank_account)
                            <div class="mb-2">
                              <a href="{{ asset('images/corporate_bank_account/' . $application->corporate_bank_account) }}" target="_blank">
                                View Current File
                              </a>
                            </div>
                          @endif
                          <input type="file" name="corporate_bank_account" id="corporate_bank_account" class="form-control">
                        </div>

                        <div class="mb-3">
                          <label for="sec_registration" class="form-label">SEC Registration</label>
                          @if ($application->sec_registration)
                            <div class="mb-2">
                              <a href="{{ asset('images/sec_registration/' . $application->sec_registration) }}" target="_blank">
                                View Current File
                              </a>
                            </div>
                          @endif
                          <input type="file" name="sec_registration" id="sec_registration" class="form-control">
                        </div>

                        <div class="mb-3">
                          <label for="tin" class="form-label">TIN</label>
                          @if ($application->tin)
                            <div class="mb-2">
                              <a href="{{ asset('images/tin/' . $application->tin) }}" target="_blank">
                                View Current File
                              </a>
                            </div>
                          @endif
                          <input type="file" name="tin" id="tin" class="form-control">
                        </div>

                        <div class="mb-3">
                          <label for="sss" class="form-label">SSS</label>
                          @if ($application->sss)
                            <div class="mb-2">
                              <a href="{{ asset('images/sss/' . $application->sss) }}" target="_blank">
                                View Current File
                              </a>
                            </div>
                          @endif
                          <input type="file" name="sss" id="sss" class="form-control">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Second Card: Destination Details -->
            <div class="card form-container mt-4">
              <div class="card-body">
                <h4 class="mb-4">Destination Details</h4>
                <div class="row">
                  <div class="col-md-6">
                    <x-input-field
                      label="Destination Name"
                      name="destination_name"
                      id="destination_name"
                      type="text"
                      placeholder="Destination Name"
                      :value="old('destination_name', $application->destination_name ?? '')"
                    />

                    <!-- Category Dropdown -->
                    <div class="mb-3">
                      <label for="category" class="form-label">Category</label>
                      <select
                        name="category"
                        id="category"
                        class="form-select"
                        aria-label="Select a Category"
                      >
                        <option value="" disabled>-- Select Category --</option>
                        <option
                          value="Resort"
                          {{ old('category', $application->category ?? '') === 'Resort' ? 'selected' : '' }}
                        >Resort</option>
                        <option
                          value="Hotel"
                          {{ old('category', $application->category ?? '') === 'Hotel' ? 'selected' : '' }}
                        >Hotel</option>
                        <option
                          value="Park"
                          {{ old('category', $application->category ?? '') === 'Park' ? 'selected' : '' }}
                        >Park</option>
                        <option
                          value="Adventure"
                          {{ old('category', $application->category ?? '') === 'Adventure' ? 'selected' : '' }}
                        >Adventure</option>
                        <option
                          value="Sports"
                          {{ old('category', $application->category ?? '') === 'Sports' ? 'selected' : '' }}
                        >Sports</option>
                        <option
                          value="Wine & Beer"
                          {{ old('category', $application->category ?? '') === 'Wine & Beer' ? 'selected' : '' }}
                        >Wine & Beer</option>
                        <option
                          value="Restaurant"
                          {{ old('category', $application->category ?? '') === 'Restaurant' ? 'selected' : '' }}
                        >Restaurant</option>
                        <option
                          value="Fastfood"
                          {{ old('category', $application->category ?? '') === 'Fastfood' ? 'selected' : '' }}
                        >Fastfood</option>
                        <option
                          value="Church"
                          {{ old('category', $application->category ?? '') === 'Church' ? 'selected' : '' }}
                        >Church</option>
                        <option
                          value="Art Galleries"
                          {{ old('category', $application->category ?? '') === 'Art Galleries' ? 'selected' : '' }}
                        >Art Galleries</option>
                      </select>
                      @error('category')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>

                    <!-- Dynamic Operating Hours Section -->
                    <div class="mb-3">
                      <label class="form-label">Operating Hours</label>
                      <div id="days-container">
                        <!-- Days will be added here dynamically -->
                        @if (isset($application->operating_hours))
                          @foreach (json_decode($application->operating_hours, true) as $day => $hours)
                            <div class="day-group">
                              <select class="form-select" name="operating_days[]">
                                <option value="mon" {{ $day === 'mon' ? 'selected' : '' }}>Monday</option>
                                <option value="tue" {{ $day === 'tue' ? 'selected' : '' }}>Tuesday</option>
                                <option value="wed" {{ $day === 'wed' ? 'selected' : '' }}>Wednesday</option>
                                <option value="thu" {{ $day === 'thu' ? 'selected' : '' }}>Thursday</option>
                                <option value="fri" {{ $day === 'fri' ? 'selected' : '' }}>Friday</option>
                                <option value="sat" {{ $day === 'sat' ? 'selected' : '' }}>Saturday</option>
                                <option value="sun" {{ $day === 'sun' ? 'selected' : '' }}>Sunday</option>
                              </select>
                              <input type="time" name="operating_hours_start[]" class="form-control" value="{{ $hours['start'] }}">
                              <input type="time" name="operating_hours_end[]" class="form-control" value="{{ $hours['end'] }}">
                              <button type="button" class="remove-day">Remove</button>
                            </div>
                          @endforeach
                        @endif
                      </div>
                      <button type="button" id="add-day" class="btn btn-secondary mt-2">Add Day</button>
                    </div>

                    <x-input-field
                      label="Destination Address"
                      name="destination_address"
                      id="destination_address"
                      type="text"
                      placeholder="Ex. Panganiban Drive"
                      :value="old('destination_address', $application->destination_address ?? '')"
                    />

                    <!-- Locality -->
                    <x-input-field
                      label="Locality"
                      name="locality"
                      id="locality"
                      type="text"
                      placeholder="Ex. Naga"
                      :value="old('locality', $application->locality ?? '')"
                    />
                  </div>

                  <div class="col-md-6">
                    <x-input-field
                      label="Nearest Landmark 1"
                      name="nearest_landmark1"
                      id="nearest_landmark1"
                      type="text"
                      placeholder="Landmark 1"
                      :value="old('nearest_landmark1', $application->nearest_landmark1 ?? '')"
                    />

                    <x-input-field
                      label="Nearest Landmark 2"
                      name="nearest_landmark2"
                      id="nearest_landmark2"
                      type="text"
                      placeholder="Landmark 2"
                      :value="old('nearest_landmark2', $application->nearest_landmark2 ?? '')"
                    />

                    <x-input-field
                      label="Nearest Landmark 3"
                      name="nearest_landmark3"
                      id="nearest_landmark3"
                      type="text"
                      placeholder="Landmark 3"
                      :value="old('nearest_landmark3', $application->nearest_landmark3 ?? '')"
                    />

                    <!-- Amenities (required) -->
                    <x-input-field
                      label="Amenities"
                      name="amenities"
                      id="amenities"
                      type="textarea"
                      placeholder="List of amenities"
                      :value="old('amenities', $application->amenities ?? '')"
                      required
                    />
                  </div>
                </div>
              </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-4">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modals -->
  <!-- Modal for Company Permit -->
  <div
    class="modal fade"
    id="companyPermitModal"
    tabindex="-1"
    aria-labelledby="companyPermitLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="companyPermitLabel">Company Permit</h1>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <img
            class="w-100"
            src="{{ asset('images/company_permit/' . $application->company_permit) }}"
            alt="Company Permit"
          >
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary w-100"
            data-bs-dismiss="modal"
          >Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal for Location Clearance -->
  <div
    class="modal fade"
    id="locationClearanceModal"
    tabindex="-1"
    aria-labelledby="locationClearanceLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="locationClearanceLabel">
            Location Clearance
          </h1>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <img
            class="w-100"
            src="{{ asset('images/location_clearance/' . $application->location_clearance) }}"
            alt="Location Clearance"
          >
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary w-100"
            data-bs-dismiss="modal"
          >Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal for Barangay Clearance -->
  <div
    class="modal fade"
    id="barangayClearanceModal"
    tabindex="-1"
    aria-labelledby="barangayClearanceLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="barangayClearanceLabel">
            Barangay Clearance
          </h1>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <img
            class="w-100"
            src="{{ asset('images/barangay_clearance/' . $application->barangay_clearance) }}"
            alt="Barangay Clearance"
          >
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary w-100"
            data-bs-dismiss="modal"
          >Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal for Philhealth -->
  <div
    class="modal fade"
    id="philhealthModal"
    tabindex="-1"
    aria-labelledby="philhealthLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="philhealthLabel">Philhealth</h1>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <img
            class="w-100"
            src="{{ asset('images/philhealth/' . $application->philhealth) }}"
            alt="Philhealth"
          >
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary w-100"
            data-bs-dismiss="modal"
          >Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal for Corporate Bank Account -->
  <div
    class="modal fade"
    id="corporateBankAccountModal"
    tabindex="-1"
    aria-labelledby="corporateBankAccountLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1
            class="modal-title fs-5"
            id="corporateBankAccountLabel"
          >Corporate Bank Account</h1>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <img
            class="w-100"
            src="{{ asset('images/corporate_bank_account/' . $application->corporate_bank_account) }}"
            alt="Corporate Bank Account"
          >
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary w-100"
            data-bs-dismiss="modal"
          >Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal for SEC Registration -->
  <div
    class="modal fade"
    id="secRegistrationModal"
    tabindex="-1"
    aria-labelledby="secRegistrationLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1
            class="modal-title fs-5"
            id="secRegistrationLabel"
          >SEC Registration</h1>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <img
            class="w-100"
            src="{{ asset('images/sec_registration/' . $application->sec_registration) }}"
            alt="SEC Registration"
          >
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary w-100"
            data-bs-dismiss="modal"
          >Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal for TIN -->
  <div
    class="modal fade"
    id="tinModal"
    tabindex="-1"
    aria-labelledby="tinLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1
            class="modal-title fs-5"
            id="tinLabel"
          >TIN</h1>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <img
            class="w-100"
            src="{{ asset('images/tin/' . $application->tin) }}"
            alt="TIN"
          >
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary w-100"
            data-bs-dismiss="modal"
          >Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal for SSS -->
  <div
    class="modal fade"
    id="sssModal"
    tabindex="-1"
    aria-labelledby="sssLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1
            class="modal-title fs-5"
            id="sssLabel"
          >SSS</h1>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <img
            class="w-100"
            src="{{ asset('images/sss/' . $application->sss) }}"
            alt="SSS"
          >
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary w-100"
            data-bs-dismiss="modal"
          >Close</button>
        </div>
      </div>
    </div>
  </div>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"
  ></script>
  <script>
    // Add dynamic operating hours functionality
    document.addEventListener('DOMContentLoaded', function() {
      const daysContainer = document.getElementById('days-container');
      const addDayButton = document.getElementById('add-day');

      addDayButton.addEventListener('click', function() {
        const dayGroup = document.createElement('div');
        dayGroup.classList.add('day-group');

        const daySelect = document.createElement('select');
        daySelect.classList.add('form-select');
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

        const startTime = document.createElement('input');
        startTime.type = 'time';
        startTime.name = 'operating_hours_start[]';
        startTime.classList.add('form-control');

        const endTime = document.createElement('input');
        endTime.type = 'time';
        endTime.name = 'operating_hours_end[]';
        endTime.classList.add('form-control');

        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.classList.add('remove-day');
        removeButton.textContent = 'Remove';
        removeButton.addEventListener('click', function() {
          daysContainer.removeChild(dayGroup);
        });

        dayGroup.appendChild(daySelect);
        dayGroup.appendChild(startTime);
        dayGroup.appendChild(endTime);
        dayGroup.appendChild(removeButton);
        daysContainer.appendChild(dayGroup);
      });

      // Remove existing day groups
      document.querySelectorAll('.remove-day').forEach(button => {
        button.addEventListener('click', function() {
          daysContainer.removeChild(button.closest('.day-group'));
        });
      });
    });

    // Auto-correct "locality" on form submission (capitalize each word, ensure "City")
    document.addEventListener('DOMContentLoaded', function() {
      const editApplicationForm = document.getElementById('editApplicationForm');
      const localityField = document.getElementById('locality');

      editApplicationForm.addEventListener('submit', function(e) {
        let val = localityField.value.trim();
        if (!val) return;

        // Split into words, lowercase them, then capitalize
        let words = val.toLowerCase().split(/\s+/).map(word => {
          return word.charAt(0).toUpperCase() + word.slice(1);
        });
        let capitalized = words.join(' ');

        // If "City" not found (case-insensitive), append it
        if (!/city/i.test(capitalized)) {
          capitalized += ' City';
        }
        localityField.value = capitalized;
      });
    });
  </script>
</body>
</html>