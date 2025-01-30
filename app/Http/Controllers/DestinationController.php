<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDestinationRequest;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class DestinationController extends Controller
{
    /**
     * The file fields for uploading.
     *
     * @var array
     */
    protected $fileFields = [
        'company_permit',
        'location_clearance',
        'barangay_clearance',
        'philhealth',
        'corporate_bank_account',
        'sec_registration',
        'tin',
        'sss',
    ];

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDestinationRequest $request)
    {
        $request->validate([
            'locality' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'max:20'],
        ]);
    
        $incomingFields = $request->validated();
    
        // Capitalize the first letter of each word in the specified fields
        $fieldsToCapitalize = [
            'company_name',
            'company_address',
            'destination_name',
            'destination_address',
            'locality',
            'nearest_landmark1',
            'nearest_landmark2',
            'nearest_landmark3',
            'amenities'
        ];
    
        foreach ($fieldsToCapitalize as $field) {
            if (isset($incomingFields[$field])) {
                $incomingFields[$field] = ucwords(strtolower($incomingFields[$field]));
            }
        }
    
        // Process dynamic operating hours
        $operatingHours = [];
        foreach ($request->operating_days as $index => $day) {
            $operatingHours[$day] = [
                'start' => $request->operating_hours_start[$index],
                'end' => $request->operating_hours_end[$index],
            ];
        }
        $incomingFields['operating_hours'] = json_encode($operatingHours);
    
        $fileNames = [];
    
        foreach ($this->fileFields as $field) {
            if ($request->hasFile($field)) {
                $fileNames[$field] = $this->handleFileUpload($request->file($field), $field);
            }
        }
    
        $incomingFields = array_merge($incomingFields, $fileNames);
        Destination::create($incomingFields);
    
        return redirect()->back()->with('success', 'Destination added successfully!');
    }
    
    public function saveCoordinates(Request $request, string $id)
    {
        $destination = Destination::findOrFail($id);
        // Validate the incoming latitude and longitude
        $request->validate([
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
        ]);

        // Update the destination's latitude and longitude
        $destination->lat = $request->input('lat');
        $destination->long = $request->input('long');
        $destination->save();

        return redirect()->back()->with('success', 'Coordinates saved successfully!');
    }

    /**
     * Handle file upload and return the new file name.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  string  $folder
     * @return string
     */
    protected function handleFileUpload($file, $folder)
    {
        $fileName = uniqid().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('images/'.$folder), $fileName);

        return $fileName;
    }

    /**
     * Display the specified resource.
     */


    public function show(string $id)
    {

        $application = Destination::findOrFail($id);

        return view("owner/view_destination", ['title' => $application->destination_name, 'application' => $application]);
    }

    public function showdestination(string $id)
    {
        $application = Destination::findOrFail($id);

        return view("admin/view_destination", ['title' => $application->destination_name, 'application' => $application]);
    }

    public function showapplication(string $id)
    {
        $application = Destination::findOrFail($id);

        return view("admin/view_application", ['title' => $application->destination_name, 'application' => $application]);
    }
    
    public function edit(string $id)
    {
        $folder = auth()->user()->type === 'admin' ? 'admin' : 'owner';
        $application = Destination::findOrFail($id);

        return view("$folder/edit_destination", ['title' => $application->destination_name, 'application' => $application]);
    }
    

    public function present(string $id)
    {
        $folder = auth()->user()->type === 'admin' ? 'admin' : 'owner';
        $destination = Destination::findOrFail($id);

        return view("$folder/destination_landing", ['title' => $destination->destination_name, 'destination' => $destination]);
    }


    public function showAdminApplications(Request $request)
{
    // Get the locality of the logged-in admin
    $adminLocality = auth()->user()->locality;

    // Start the query for pending applications in the admin's locality
    $query = Destination::with('user')
                        ->where('status', 'pending')
                        ->where('locality', $adminLocality);

    // Handle search
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('destination_name', 'like', '%' . $search . '%')
              ->orWhere('destination_address', 'like', '%' . $search . '%')
              ->orWhere('locality', 'like', '%' . $search . '%')
              ->orWhereHas('user', function ($q) use ($search) {
                  $q->where('firstname', 'like', '%' . $search . '%')
                    ->orWhere('lastname', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
              });
        });
    }

    // Handle filter by category
    if ($request->has('category') && $request->category != '') {
        $query->where('category', $request->category);
    }

    // Paginate the results with 10 items per page
    $applications = $query->paginate(10);

    // Return the view with the filtered applications
    return view('admin/applications', [
        'title' => 'Pending Applications',
        'applications' => $applications,
        'search' => $request->search, // Pass search term back to the view
        'category' => $request->category, // Pass selected category back to the view
    ]);
}
    
public function showApproved(Request $request)
{
    // Get the locality of the logged-in admin
    $adminLocality = auth()->user()->locality;

    // Start the query for approved destinations in the admin's locality
    $query = Destination::where('status', 'approved')
                        ->where('locality', $adminLocality)
                        ->orderBy('created_at', 'desc'); // Sort by latest first

    // Handle search
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('company_name', 'like', '%' . $search . '%')
              ->orWhere('destination_name', 'like', '%' . $search . '%')
              ->orWhere('destination_address', 'like', '%' . $search . '%')
              ->orWhere('locality', 'like', '%' . $search . '%');
        });
    }

    // Handle filter by category
    if ($request->has('category') && $request->category != '') {
        $query->where('category', $request->category);
    }

    // Paginate the results with 10 items per page
    $destinations = $query->paginate(10);

    // Return the view with the filtered destinations
    return view('admin/admin_destinations', [
        'title' => 'Destinations',
        'destinations' => $destinations,
        'search' => $request->search, // Pass search term back to the view
        'category' => $request->category, // Pass selected category back to the view
    ]);
}

  /**
     * Display destinations for owner (10 items per page).
     */
public function showOwnerDestinations(Request $request)
{
    // Get the logged-in owner
    $user = auth()->user();

    // Start the query for approved destinations, ordered by latest first
    $query = Destination::where('user_id', $user->id)
                        ->where('status', 'approved')
                        ->orderBy('created_at', 'desc'); // Sort by latest first

    // Handle search
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('company_name', 'like', '%' . $search . '%')
              ->orWhere('destination_name', 'like', '%' . $search . '%')
              ->orWhere('destination_address', 'like', '%' . $search . '%')
              ->orWhere('locality', 'like', '%' . $search . '%');
        });
    }

    // Handle filter by category
    if ($request->has('category') && $request->category != '') {
        $query->where('category', $request->category);
    }

    // Paginate the results
    $destinations = $query->paginate(10);

    // Return the view with the filtered destinations
    return view('owner/destinations', [
        'title' => 'My Destinations',
        'destinations' => $destinations,
        'search' => $request->search, // Pass search term back to the view
        'category' => $request->category, // Pass selected category back to the view
    ]);
}

    public function showOwnerApplications(Request $request)
    {
        // Get the logged-in owner
        $user = auth()->user();

        // Start the query for pending and declined destinations
        $query = Destination::where('user_id', $user->id)
                            ->whereIn('status', ['pending', 'declined']);

        // Handle search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', '%' . $search . '%')
                  ->orWhere('destination_name', 'like', '%' . $search . '%')
                  ->orWhere('destination_address', 'like', '%' . $search . '%')
                  ->orWhere('locality', 'like', '%' . $search . '%');
            });
        }

        // Handle filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Paginate the results
        $applications = $query->paginate(10);

        // Return the view with the filtered applications
        return view('owner/my_applications', [
            'title' => 'My Applications',
            'applications' => $applications,
            'search' => $request->search, // Pass search term back to the view
            'category' => $request->category, // Pass selected category back to the view
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(StoreDestinationRequest $request, string $id)
    {
        $destination = Destination::findOrFail($id);
    
        // Ensure admins can update
        if (auth()->user()->type !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
    
        // Get validated fields but EXCLUDE user_id
        $incomingFields = $request->except(['user_id']);
        $incomingFields['user_id'] = $destination->user_id; // Retain original owner
    
        // Process dynamic operating hours if provided
        if ($request->has('operating_days')) {
            $operatingHours = [];
            foreach ($request->operating_days as $index => $day) {
                $operatingHours[$day] = [
                    'start' => $request->operating_hours_start[$index],
                    'end' => $request->operating_hours_end[$index],
                ];
            }
            $incomingFields['operating_hours'] = json_encode($operatingHours);
        }
    
        // Handle file uploads
        $fileFields = [
            'company_permit', 'location_clearance', 'barangay_clearance', 'philhealth',
            'corporate_bank_account', 'sec_registration', 'tin', 'sss'
        ];
    
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                // Delete old file
                if ($destination->$field) {
                    $oldFilePath = public_path('images/' . $field . '/' . $destination->$field);
                    if (File::exists($oldFilePath)) {
                        File::delete($oldFilePath);
                    }
                }
                // Upload new file
                $file = $request->file($field);
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/' . $field), $fileName);
                $incomingFields[$field] = $fileName;
            } else {
                unset($incomingFields[$field]); // Keep existing file
            }
        }
    
        // Ensure status update is allowed
        if ($request->has('status')) {
            $incomingFields['status'] = $request->status;
        }
    
        // Perform update
        $destination->update($incomingFields);
    
        return redirect('/admin/destinations')->with('success', 'Destination updated successfully!');
    }
    
    public function ownerupdate(StoreDestinationRequest $request, string $id)
{
    $destination = Destination::findOrFail($id);

    // Update only the fields that have changed
    $incomingFields = $request->validated();

    // Capitalize the first letter of each word in the specified fields
    $fieldsToCapitalize = [
        'company_name',
        'company_address',
        'destination_name',
        'destination_address',
        'locality',
        'nearest_landmark1',
        'nearest_landmark2',
        'nearest_landmark3',
        'amenities'
    ];

    foreach ($fieldsToCapitalize as $field) {
        if (isset($incomingFields[$field])) {
            $incomingFields[$field] = ucwords(strtolower($incomingFields[$field]));
        }
    }

    // Process dynamic operating hours
    if ($request->has('operating_days')) {
        $operatingHours = [];
        foreach ($request->operating_days as $index => $day) {
            $operatingHours[$day] = [
                'start' => $request->operating_hours_start[$index],
                'end' => $request->operating_hours_end[$index],
            ];
        }
        $incomingFields['operating_hours'] = json_encode($operatingHours);
    }

    // Handle file uploads (only if files are provided)
    foreach ($this->fileFields as $field) {
        if ($request->hasFile($field)) {
            // Delete the old file if it exists
            if ($destination->$field) {
                $oldFilePath = public_path('images/' . $field . '/' . $destination->$field);
                if (File::exists($oldFilePath)) {
                    File::delete($oldFilePath);
                }
            }

            // Upload the new file
            $file = $request->file($field);
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/' . $field), $fileName);
            $incomingFields[$field] = $fileName;
        } else {
            // Retain the existing file if no new file is uploaded
            unset($incomingFields[$field]);
        }
    }

    // Update the destination
    $destination->update($incomingFields);

    return redirect('/owner/destinations')->with('success', 'Destination updated successfully!');
}
    
    public function approve(string $id)
    {
        $application = Destination::findOrFail($id);
        $application->status = 'approved';
        $application->save();

        return redirect('/admin/applications')->with('success', 'Application approved successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $destination = Destination::findOrFail($id);

        foreach ($this->fileFields as $field) {
            if ($destination->$field) {
                $filePath = public_path('images/'.$field.'/'.$destination->$field);
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
            }
        }

        $destination->delete();

        return redirect()->back()->with('success', 'Destination deleted successfully!');
    }
    
    public function coverphoto(Request $request, string $id)
{
    // Validate the incoming request
    $request->validate([
        'coverphoto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules as needed
    ]);

    // Find the destination by ID
    $destination = Destination::findOrFail($id);

    // Handle file upload
    if ($request->hasFile('coverphoto')) {
        // Delete the old cover photo if it exists
        if ($destination->coverphoto) {
            $oldFilePath = public_path('images/coverphotos/' . $destination->coverphoto);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }

        // Upload the new cover photo
        $file = $request->file('coverphoto');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images/coverphotos'), $fileName);

        // Update the destination's cover photo field
        $destination->coverphoto = $fileName;
        $destination->save();
    }

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Cover photo updated successfully!');
}

    public function viewdestroy(string $id)
    {
        $destination = Destination::findOrFail($id);

        foreach ($this->fileFields as $field) {
            if ($destination->$field) {
                $filePath = public_path('images/'.$field.'/'.$destination->$field);
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
            }
        }

        $destination->delete();

        return redirect('/admin/applications')->with('success', 'Application deleted successfully!');
    }
    


    public function applicationdestroy(string $id)
    {
        $destination = Destination::findOrFail($id);


        $destination->delete();

        return redirect()->back()->with('success', 'Application deleted successfully!');

    }
    
    public function destinationdestroy(string $id)
    {
        $destination = Destination::findOrFail($id);


        $destination->delete();

        return redirect()->back()->with('success', 'Destination deleted successfully!');
    }

    public function decline(string $id)
    {
        $application = Destination::findOrFail($id);
        $application->status = 'declined';
        $application->save();
    
        return redirect('/admin/applications')->with('success', 'Application rejected successfully!');
    }
    


}
