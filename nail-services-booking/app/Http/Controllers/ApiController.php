<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use function Filament\Support\generate_search_column_expression;

class ApiController extends Controller
{
    public function getBookings()
    {
        // Simulate fetching bookings from a database or service
        $bookings = Booking::get();
        return response()->json($bookings);
    }

    // spefici bookking based on specific input deinfed in request
    public function getBooking(Request $request)
    {

        $bookingId = $request->input('column_name');
        $valueId = $request->input('value');
        // Assuming 'column_name' is the name of the column you want to filter by
        // Replace 'column_name' with the actual column name you want to filter by
        if (!$bookingId) {
            return response()->json(['error' => 'Booking ID is required'], 400);
        }
        if (!$valueId) {
            return response()->json(['error' => 'Value is required'], 400);
        }
        //check if model has columns
       if (!\Illuminate\Support\Facades\Schema::hasColumn('bookings', $bookingId)) {
           return response()->json(['error' => 'Invalid column name'], 400);
       }

        // Simulate fetching a specific booking from a database or service
        $booking = Booking::where($bookingId, $valueId)->get();
        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        return response()->json($booking);
    }
    public function getServices()
    {
        // Simulate fetching services from a database or service
        $services = \App\Models\Service::get();
        return response()->json($services);
    }

}
