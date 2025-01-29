<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Http\Requests\StoreReviewRequest;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\Destination;
use Illuminate\Support\Facades\Log; // Import Log for logging
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
     public function uploadProof(Request $request)
     {
         $request->validate([
             'proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
         ]);
 
         if ($request->hasFile('proof')) {
             $file = $request->file('proof');
             $fileName = time() . '_' . $file->getClientOriginalName();
             $filePath = $file->storeAs('proofs', $fileName, 'public'); // Save to public/storage/proofs
 
             return response()->json([
                 'url' => Storage::url($filePath), // Return the public URL
             ]);
         }
 
         return response()->json(['error' => 'No file uploaded'], 400);
     }
    
     public function ownerindex(Request $request)
     {
         // Get the logged-in owner's ID
         $userId = $request->user()->id;
     
         // Start the query with reviews for destinations owned by the logged-in owner
         $query = Review::whereHas('destination', function ($query) use ($userId) {
             $query->where('user_id', $userId);
         });
     
         // Handle search
         if ($request->has('search') && $request->search != '') {
             $search = $request->search;
             $query->where(function ($q) use ($search) {
                 $q->where('review_title', 'like', '%' . $search . '%')
                   ->orWhereHas('destination', function($q) use ($search) {
                       $q->where('company_name', 'like', '%' . $search . '%')
                         ->orWhere('destination_name', 'like', '%' . $search . '%');
                   })
                   ->orWhereHas('user', function($q) use ($search) {
                       $q->where('firstname', 'like', '%' . $search . '%')
                         ->orWhere('lastname', 'like', '%' . $search . '%');
                   });
             });
         }
     
         // Handle filter by rating
         if ($request->has('rating') && $request->rating != '') {
             $query->where('rating', (int) $request->rating);
         }
     
         // Sort by createdAt in descending order (latest first)
         $query->orderBy('createdAt', 'desc');
     
         // Paginate the results
         $reviews = $query->paginate(10);
     
         // Format createdAt for each review
         foreach ($reviews as $review) {
             if ($review->createdAt instanceof \MongoDB\BSON\UTCDateTime) {
                 // Convert MongoDB\BSON\UTCDateTime to Carbon instance
                 $dateTime = $review->createdAt->toDateTime();
     
                 $review->formatted_created_at = Carbon::parse($dateTime)
                     ->setTimezone('Asia/Manila')
                     ->format('F j, Y'); // Format as "Month, day, year" (e.g., October 11, 2024)
             }
         }
     
         // Return the view with the filtered reviews
         return view('owner/reviews', [
             'title' => 'Reviews',
             'reviews' => $reviews,
             'search' => $request->search ?? '',
             'rating' => $request->rating ?? '',
         ]);
     }
    

    //  public function adminindex(Request $request)
    //  {
    //      // Get the locality of the logged-in admin
    //      $adminLocality = $request->user()->locality;
     
    //      // Start the query with reviews for destinations in the admin's locality
    //      $query = Review::whereHas('destination', function ($query) use ($adminLocality) {
    //          $query->where('locality', $adminLocality);
    //      });
     
    //      // Handle search
    //      if ($request->has('search') && $request->search != '') {
    //          $query->where(function ($q) use ($request) {
    //              $q->where('review_title', 'like', '%' . $request->search . '%')
    //                ->orWhereHas('destination', function($q) use ($request) {
    //                    $q->where('company_name', 'like', '%' . $request->search . '%')
    //                      ->orWhere('destination_name', 'like', '%' . $request->search . '%');
    //                })
    //                ->orWhereHas('user', function($q) use ($request) {
    //                    $q->where('firstname', 'like', '%' . $request->search . '%')
    //                      ->orWhere('lastname', 'like', '%' . $request->search . '%');
    //                });
    //          });
    //      }
     
    //      // Handle filter by rating
    //      if ($request->has('rating') && $request->rating != '') {
    //          $query->where('rating', (int) $request->rating);
    //      }
     
    //      // Handle filter by status
    //      if ($request->has('status') && $request->status != '') {
    //          $query->where('status', $request->status);
    //      }
     
    //      // Debugging: Check the query and results
    //      // dd($query->toSql(), $query->getBindings(), $query->get());
     
    //      // Paginate the results
    //      $reviews = $query->orderBy('createdAt', 'desc')->paginate(10);
     
    //      // Convert createdAt to Asia/Manila timezone for each review and change the format
    //      foreach ($reviews as $review) {
    //          if ($review->createdAt instanceof \MongoDB\BSON\UTCDateTime) {
    //              // Convert MongoDB\BSON\UTCDateTime to Carbon instance
    //              $dateTime = $review->createdAt->toDateTime();
     
    //              $review->formatted_created_at = Carbon::parse($dateTime)
    //                  ->setTimezone('Asia/Manila')
    //                  ->format('F j, Y'); // Format as "Month, day, year" (e.g., October 11, 2024)
    //          }
    //      }
     
    //      // Return the view with the filtered reviews
    //      return view('admin/reviews', [
    //          'title' => 'Reviews',
    //          'reviews' => $reviews,
    //          'search' => $request->search,
    //          'rating' => $request->rating,
    //          'status' => $request->status,
    //      ]);
    //  }
    
     
    public function showAdminReviews(Request $request)
    {
        // Debug the rating filter
        \Log::info('Rating filter value:', ['rating' => $request->rating]);
    
        $adminId = Auth::id();
    
        // Only reviews whose destination.user_id matches the admin
        $query = Review::whereHas('destination', function($q) use ($adminId) {
            $q->where('user_id', $adminId);
        });
    
        // Optional: search logic
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('review_title', 'like', "%{$search}%")
                  ->orWhereHas('destination', function($sub) use ($search) {
                      $sub->where('destination_name', 'like', "%{$search}%")
                          ->orWhere('company_name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('user', function($sub) use ($search) {
                      $sub->where('firstname', 'like', "%{$search}%")
                          ->orWhere('lastname', 'like', "%{$search}%");
                  });
            });
        }
    
        // Optional: rating filter (cast to integer)
        if ($request->filled('rating')) {
            $query->where('rating', (int)$request->rating);
        }
    
        // Sort by createdAt in descending order (latest first)
        $query->orderBy('createdAt', 'desc');
    
        // Paginate the results
        $reviews = $query->paginate(10);
    
        // Format createdAt for each review
        foreach ($reviews as $review) {
            if ($review->createdAt instanceof \MongoDB\BSON\UTCDateTime) {
                // Convert MongoDB\BSON\UTCDateTime to Carbon instance
                $dateTime = $review->createdAt->toDateTime();
    
                $review->formatted_created_at = Carbon::parse($dateTime)
                    ->setTimezone('Asia/Manila')
                    ->format('F j, Y'); // Format as "Month, day, year" (e.g., October 11, 2024)
            }
        }
        
        return view('admin.reviews', [
            'title'   => 'Reviews',
            'reviews' => $reviews,
            'search'  => $request->search,
            'rating'  => $request->rating,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
        
     public function store(Request $request)
     {
         $request->validate([
             'rating' => 'required|integer|min:1|max:5',
             'review_title' => 'required|string|max:255',
             'comment' => 'required|string',
             'date' => 'required|date',
             'proof' => 'required|string', // URL of the uploaded proof image
             'destination_id' => 'required|exists:destinations,_id',
             'user_id' => 'required|exists:client_users,_id',
             'status' => 'required|string|in:pending,approved,rejected',
         ]);
     
         // Create the review with the proof URL
         Review::create([
             'rating' => $request->rating,
             'review_title' => $request->review_title,
             'comment' => $request->comment,
             'date' => $request->date,
             'proof' => $request->proof, // Store the proof image URL
             'destination_id' => $request->destination_id,
             'user_id' => $request->user_id,
             'status' => $request->status,
         ]);
     
         return redirect()->route('reviews.index')->with('success', 'Review created successfully.');
     }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $application = Destination::findOrFail($id);

       return view('owner/reviews', ['title' => 'Reviews', 'reviews' => $reviews]);
    
     
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
        // Find the review by ID or fail with a 404 error if not found
        $review = Review::findOrFail($id);
    
        // Delete the review
        $review->delete();
    
        // Redirect back to the reviews page with a success message
        return redirect('/admin/reviews')->with('success', 'Review deleted successfully!');
    }
    
    
}
