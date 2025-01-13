<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
        $adminLocality = auth()->user()->locality;

        $query = Report::whereHas('review.destination', function($q) use ($adminLocality) {
            $q->where('locality', $adminLocality);
        });

        // If filtering by reason
        if ($request->filled('reason')) {
            $query->where('reason', $request->reason);
        }

        $reports = $query
            ->with(['review', 'review.destination'])
            ->paginate(10);

        // Format created_at
        foreach ($reports as $report) {
            if ($report->created_at) {
                $report->formatted_created_at = Carbon::parse($report->created_at)
                    ->setTimezone('Asia/Manila')
                    ->format('F j, Y');
            }
        }

        return view('admin/reports', [
            'title'   => 'Reports',
            'reports' => $reports,
            'reason'  => $request->reason ?? '',
        ]);
    }
    public function approve(string $id)
    {
        $report = Report::findOrFail($id);
        $review = Review::findOrFail($report->review_id);

        // 1) Delete the associated review from DB
        $review->delete();

        // 2) Mark the report as approved
        $report->status = 'approved';
        $report->save();

        return redirect()->back()->with('success', 'Review deleted and report approved successfully');
    }

    public function decline(string $id)
    {
        $report = Report::findOrFail($id);
        $review = Review::findOrFail($report->review_id);

        // Mark the review as "declined" (assuming there's a 'status' on review too)
        $review->status = 'declined';
        $review->save();

        // Mark the report as declined
        $report->status = 'declined';
        $report->save();

        return redirect()->back()->with('success', 'Report declined successfully');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Grab the radio choice & others text
        $radioChoice = $request->input('radio_temp'); // e.g. "Offensive language" or "others"
        $othersText  = trim($request->input('others', '')); // might be empty if user didn't type
    
        $review_id       = $request->input('review_id');
        $destination_id  = $request->input('destination_id');
    
        // 1) Basic checks for existing fields
        $request->validate([
            'review_id'       => 'required|exists:reviews,_id',
            'destination_id'  => 'required|exists:destinations,_id',
            'radio_temp'      => 'nullable|string', // Let us handle logic below
            'others'          => 'nullable|string', // Only required if user picked "others"
        ]);
    
        // 2) If they picked a standard radio
        if ($radioChoice && $radioChoice !== 'others') {
            // No further text required
            // Make sure they actually picked a radio
            $request->validate([
                'radio_temp' => 'required', 
            ]);
            $finalReason = $radioChoice;
    
        // 3) If they picked "others," we require text
        } elseif ($radioChoice === 'others') {
            $request->validate([
                'others' => 'required|min:5', // e.g. must have at least 5 chars
            ]);
            $finalReason = $othersText;
    
        // 4) If no radio was chosen and text is blank -> error
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Please select a reason.',
            ], 422); // 422 is the HTTP status code for validation errors
        }
    
        // 5) Create the new report
        try {
            Report::create([
                'review_id'       => $review_id,
                'destination_id'  => $destination_id,
                'reason'          => $finalReason,
                'status'          => 'pending',
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Report submitted successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit report. Please try again.',
            ], 500); // 500 is the HTTP status code for server errors
        }
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
