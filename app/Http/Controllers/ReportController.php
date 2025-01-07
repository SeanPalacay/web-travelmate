<?php

namespace App\Http\Controllers;

use Carbon\Carbon; // Add this line
use App\Http\Requests\StoreReportRequest;
use App\Models\Report;
use App\Models\Review;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the locality of the logged-in admin
        $adminLocality = auth()->user()->locality;
    
        // Start the query for reports in the admin's locality
        $query = Report::whereHas('review.destination', function($query) use ($adminLocality) {
            $query->where('locality', $adminLocality); // Filter by admin's locality
        });
    
        // Handle filter by report reason
        if ($request->has('reason') && $request->reason != '') {
            $query->where('reason', $request->reason);
        }
    
        // Fetch reports with 10 items per page
        $reports = $query->with(['review', 'review.destination'])
                         ->paginate(10);
    
        // Convert created_at to Asia/Manila timezone for each report and change the format
        foreach ($reports as $report) {
            if ($report->created_at) {
                $report->formatted_created_at = Carbon::parse($report->created_at)
                    ->setTimezone('Asia/Manila')
                    ->format('F j, Y'); // Format as "Month, day, year" (e.g., October 11, 2024)
            }
        }
    
        // Return the view with the filtered reports
        return view('admin/reports', [
            'title' => 'Reports',
            'reports' => $reports,
            'reason' => $request->reason ?? '', // Pass selected reason back to the view
        ]);
    }

    public function approve(string $id)
    {
        // Find the report by its ID
        $report = Report::findOrFail($id);
    
        // Find the related review using the review_id from the report
        $review = Review::findOrFail($report->review_id);
    
        // Delete the review from the database
        $review->delete();
    
        // Mark the report as approved
        $report->status = 'approved';
        $report->save();
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Review deleted and report approved successfully');
    }
    

    public function decline(string $id)
    {
        // Find the report by its ID
        $report = Report::findOrFail($id);
    
        // Find the related review using the review_id from the report
        $review = Review::findOrFail($report->review_id);
    
        // Update the review status to 'declined'
        $review->status = 'declined';
        $review->save();
    
        // Update the report status to 'declined'
        $report->status = 'declined';
        $report->save();
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Report declined successfully');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReportRequest $request)
    {
        $incomingFields = $request->validated();
        $incomingFields['status'] = 'pending';
        Report::create($incomingFields);

        return redirect()->back()->with('success', 'Report awaiting action from admin');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
