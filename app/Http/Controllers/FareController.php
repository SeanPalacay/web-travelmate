<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFareRequest;
use App\Models\Fare;
use Illuminate\Http\Request;
class FareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Debug the vehicle filter
        \Log::info('Vehicle filter value:', ['vehicle' => $request->vehicle]);
    
        // Get the logged-in user
        $user = auth()->user();
    
        // Start the query for fares in the user's locality
        $query = Fare::where('designated_locality', $user->locality);
    
        // Handle search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('vehicle', 'like', '%' . $search . '%')
                  ->orWhere('designated_locality', 'like', '%' . $search . '%')
                  ->orWhere('operating_hours', 'like', '%' . $search . '%')
                  ->orWhere('distance', 'like', '%' . $search . '%')
                  ->orWhere('initial_fare', 'like', '%' . $search . '%')
                  ->orWhere('additional_fare', 'like', '%' . $search . '%')
                  ->orWhere('discounted_fare', 'like', '%' . $search . '%');
            });
        }
    
        // Handle filter by vehicle type (case-insensitive)
        if ($request->has('vehicle') && $request->vehicle != '') {
            $query->where('vehicle', 'like', '%' . $request->vehicle . '%');
        }
    
        // Sort by created_at in descending order (latest first)
        $query->orderBy('created_at', 'desc');
    
        // Paginate the results with 10 items per page
        $fares = $query->paginate(10);
    
        // Return the view with the filtered fares
        return view('admin/fares', [
            'title' => 'Fares',
            'fares' => $fares,
            'search' => $request->search ?? '', // Pass search term back to the view
            'vehicle' => $request->vehicle ?? '', // Pass selected vehicle type back to the view
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFareRequest $request)
    {
        $incomingFields = $request->validated();
    
        // Capitalize the first letter of each word in 'designated_locality' if it exists
        if (isset($incomingFields['designated_locality'])) {
            $incomingFields['designated_locality'] = ucwords(strtolower($incomingFields['designated_locality']));
        }
    
        // Capitalize the first letter of each word in 'vehicle' if it exists
        if (isset($incomingFields['vehicle'])) {
            $incomingFields['vehicle'] = ucwords(strtolower($incomingFields['vehicle']));
        }
    
        Fare::create($incomingFields);
    
        return redirect()->back()->with('success', 'Fare added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $fare = Fare::findOrFail($id);

        return view('admin/edit_fare', ['title' => 'Edit Fare', 'fare' => $fare]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreFareRequest $request, string $id)
    {
        $incomingFields = $request->validated();
    
        // Capitalize the first letter of each word in 'designated_locality' if it exists
        if (isset($incomingFields['designated_locality'])) {
            $incomingFields['designated_locality'] = ucwords(strtolower($incomingFields['designated_locality']));
        }
    
        // Capitalize the first letter of each word in 'vehicle' if it exists
        if (isset($incomingFields['vehicle'])) {
            $incomingFields['vehicle'] = ucwords(strtolower($incomingFields['vehicle']));
        }
    
        $fare = Fare::findOrFail($id);
        $fare->update($incomingFields);
    
        return redirect('/admin/fares')->with('success', 'Fare updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fare = Fare::findOrFail($id);

        $fare->delete();

        return redirect()->back()->with('sucess', 'Fare deleted');
    }
}
