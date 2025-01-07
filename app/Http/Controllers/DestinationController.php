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
                        ->where('locality', $adminLocality);

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

        // Start the query for approved destinations
        $query = Destination::where('user_id', $user->id)
                            ->where('status', 'approved');

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
        return view('owner/applications', [
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
    
        $fileNames = [];
    
        foreach ($this->fileFields as $field) {
            if ($request->hasFile($field)) {
                $fileNames[$field] = $this->handleFileUpload($request->file($field), $field);
            }
        }
    
        $destination = Destination::findOrFail($id);
        $incomingFields = array_merge($incomingFields, $fileNames);
        $destination->update($incomingFields);
    
        return redirect('/admin/destinations')->with('success', 'Destination updated successfully');
    }
    

    public function ownerupdate(StoreDestinationRequest $request, string $id)
    {
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
    
        $fileNames = [];
    
        foreach ($this->fileFields as $field) {
            if ($request->hasFile($field)) {
                $fileNames[$field] = $this->handleFileUpload($request->file($field), $field);
            }
        }
    
        $destination = Destination::findOrFail($id);
        $incomingFields = array_merge($incomingFields, $fileNames);
        $destination->update($incomingFields);
    
        return redirect('/owner/destinations')->with('success', 'Destination updated successfully');
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

        return redirect('/owner/applications')->with('success', 'Application deleted successfully!');
    }
    
    public function destinationdestroy(string $id)
    {
        $destination = Destination::findOrFail($id);


        $destination->delete();

        return redirect('/owner/destinations')->with('success', 'Destination deleted successfully!');
    }

    public function decline(string $id)
    {
        $application = Destination::findOrFail($id);
        $application->status = 'declined';
        $application->save();
    
        return redirect('/admin/applications')->with('success', 'Application rejected successfully!');
    }
    


}
