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
   
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <style>
        .image-container {
            position: relative;
            width: 100%;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }
        .image-container img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .image-container:hover img {
            transform: scale(1.05);
        }

        .edit-button {
            position: absolute;
            bottom: 15px;
            right: 25px;
            background-color: rgba(255, 255, 255, 0.8);
            color: #007bff;
            border: none;
            padding: 10px 25px;
            border-radius: 25px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            font-weight: bold;
        }
        .edit-button:hover {
            background-color: #007bff;
            color: white;
            transform: translateY(-2px);
        }

        .map-container {
            width: 100%;
            height: 400px;
            position: relative;
        }

        .about-text {
            text-align: justify;
        }

        .save-button {
            position: absolute;
            top: 10px;
            right: 25px;
            z-index: 1000;
        }

        /* Blue-colored data fields */
        .data-field {
            color: #007bff; /* Blue */
            font-weight: bold;
        }

        /* Black-colored values */
        .data-value {
            color: black;
        }

        /* Amenities list styling */
        .amenities-list {
            list-style-type: disc;
            margin-left: 20px;
            color: black;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        @include('admin/partials/aside')
        <div class="main p-3">
            <div class="container">
                <!-- First Row: Image with Overlayed Button -->
                <div class="row mb-4">
                    <div class="col-12 image-container">
                        <img src="{{ $destination->coverphoto ? asset('images/coverphotos/' . $destination->coverphoto) : 'https://www.firstbenefits.org/wp-content/uploads/2017/10/placeholder.png' }}" alt="Destination Image">
                        <button type="button" class="edit-button" data-bs-toggle="modal" data-bs-target="#editCoverPhotoModal">
                            Edit
                        </button>
                    </div>
                </div>

                <!-- Second Row: Destination Name -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h1 class="data-field">{{ $destination->destination_name }}</h1>
                    </div>
                </div>

                <!-- Third Row: About Section and Map -->
                <div class="row">
                    <!-- About Section -->
                    <div class="col-md-6 mb-4">
                        <h2 class="data-field">About</h2>
                        <p class="about-text data-value">{{ $destination->about }}</p>
                        <dl class="row">
                            <dt class="col-sm-4 data-field"><strong>Company Name:</strong></dt>
                            <dd class="col-sm-8 data-value">{{ $destination->company_name }}</dd>
                            <dt class="col-sm-4 data-field"><strong>Company Address:</strong></dt>
                            <dd class="col-sm-8 data-value">{{ $destination->company_address }}</dd>
                            <dt class="col-sm-4 data-field"><strong>Category:</strong></dt>
                            <dd class="col-sm-8 data-value">{{ $destination->category }}</dd>
                           <!-- Operating Hours -->
<dt class="col-sm-4 data-field"><strong>Operating Hours:</strong></dt>
<dd class="col-sm-8 data-value">
    @php
        // Decode the JSON string into an associative array
        $operatingHours = json_decode($destination->operating_hours, true);
    @endphp

    @if ($operatingHours)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Day</th>
                    <th>Opening Time</th>
                    <th>Closing Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($operatingHours as $day => $hours)
                    <tr>
                        <td>{{ ucfirst($day) }}</td>
                        <td>{{ date('h:i A', strtotime($hours['start'])) }}</td>
                        <td>{{ date('h:i A', strtotime($hours['end'])) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No operating hours available.</p>
    @endif
</dd>
                            <dt class="col-sm-4 data-field"><strong>Destination Address:</strong></dt>
                            <dd class="col-sm-8 data-value">{{ $destination->destination_address }}</dd>
                            <dt class="col-sm-4 data-field"><strong>Amenities:</strong></dt>
                            <dd class="col-sm-8">
                                <ul class="amenities-list">
                                    @foreach(explode(',', $destination->amenities) as $amenity)
                                        <li>{{ trim($amenity) }}</li>
                                    @endforeach
                                </ul>
                            </dd>
                        </dl>
                    </div>

                    <!-- Map Section -->
                    <div class="col-md-6 mb-4 position-relative">
                        <h2 class="data-field">Map</h2>
                        <div id="map" class="map-container" style="border-radius: 25px; margin-top: 25px;" ></div>

                        <form action="{{ url('/admin/destination/map/' . $destination->id) }}" method="POST" class="save-button">
                            @csrf
                            <!-- Hidden inputs for lat and long -->
                            <input type="hidden" id="lat" name="lat" value="{{ $destination->lat }}">
                            <input type="hidden" id="long" name="long" value="{{ $destination->long }}">

                            <button type="submit" class="btn btn-primary" style="border-radius: 25px">Save Pinned Location</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for editing cover photo -->
    <div class="modal fade" id="editCoverPhotoModal" tabindex="-1" aria-labelledby="editCoverPhotoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="corporateBankAccountLabel">Upload new cover photo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/admin/destination/coverphoto/{{ $destination->id }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="file" class="form-control" id="coverphoto" name="coverphoto">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary w-100">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Leaflet JS script to initialize the map -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Fetch lat and long values
            var lat = "{{ $destination->lat }}" ? parseFloat("{{ $destination->lat }}") : null;
            var long = "{{ $destination->long }}" ? parseFloat("{{ $destination->long }}") : null;

            // Set initial map center
            var initialLat = lat || 13.624134; // Default to 13.624134 if no lat
            var initialLong = long || 123.185062; // Default to 123.185062 if no long
            var map = L.map('map').setView([initialLat, initialLong], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(map);

            // Only show marker if lat and long are set
            var marker;
            if (lat && long) {
                marker = L.marker([lat, long]).addTo(map)
                    .bindPopup("{{ $destination->destination_name }}")
                    .openPopup();
            }

            // Allow users to click on the map to set the marker
            map.on('click', function(e) {
                // Create or update the marker
                if (!marker) {
                    marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map);
                } else {
                    marker.setLatLng([e.latlng.lat, e.latlng.lng]);
                }

                // Update hidden input values
                document.getElementById('lat').value = e.latlng.lat;
                document.getElementById('long').value = e.latlng.lng;
            });
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>