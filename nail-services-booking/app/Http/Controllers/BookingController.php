<?php
// app/Http/Controllers/BookingController.php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Jobs\SendInvoiceJob;

class BookingController extends Controller
{
    public function create()
    {
        $services = Service::where('is_active', true)->get();
        return view('bookings.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:20',
            'client_email' => 'required|email|max:20',
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    $time = Carbon::createFromFormat('H:i', $value);
                    $openTime = Carbon::createFromTimeString('09:00');
                    $closeTime = Carbon::createFromTimeString('20:00');

                    if ($time->lt($openTime) || $time->gt($closeTime)) {
                        $fail('Please select a time between 9:00 AM and 8:00 PM.');
                    }
                },
            ],
            'notes' => 'nullable|string|max:500',
        ]);

        $booking = Booking::create([
            'client_name' => $validated['client_name'],
            'client_phone' => $validated['client_phone'],
            'client_email' => $validated['client_email'],
            'service_id' => $validated['service_id'],
            'booking_date' => $validated['booking_date'],
            'booking_time' => $validated['booking_time'],
            'notes' => $validated['notes'],
            'status' => 'pending'
        ]);

        $bookingDetail = [
            'client_name' => $booking->client_name,
            'client_phone' => $booking->client_phone,
            'client_email' => $booking->client_email,
            'service_name' => $booking->service->name,
            'service_cost' => $booking->service->price,
            'service_id' => $booking->service->id,
            'booking_uid' => $booking->uuid,
            'notes' => $booking->notes,
        ];

        message_to_queue('invoice', $bookingDetail);

        return redirect()->route('booking.confirmation', $booking->uuid)
            ->with('success', 'Booking submitted successfully!');
    }

    public function confirmation($booking)
    {
        $booking = Booking::where('uuid', $booking)->firstOrFail();

        // $bookingDetail = [
        //     'client_name' => $booking->client_name,
        //     'client_phone' => $booking->client_phone,
        //     'client_email' => $booking->client_email,
        //     'service_name' => $booking->service->name,
        //     'service_cost' => $booking->service->price,
        //     'service_id' => $booking->service->id,
        //     'booking_uid' => $booking->uuid,
        //     'notes' => $booking->notes,
        // ];

        // message_to_queue('invoice', $bookingDetail);


        return view('bookings.confirmation', compact('booking'));
    }
}
