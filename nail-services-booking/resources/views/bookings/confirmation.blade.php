@extends('layouts.auth')
@section('title', 'Create Booking')

@section('contents')
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="text-center">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Booking Confirmed!</h2>
                        <div class="bg-green-50 text-green-700 p-4 rounded-lg mb-6">
                            Your booking has been received and is pending confirmation.
                        </div>

                        <div class="text-left max-w-md mx-auto space-y-4">
                            <div>
                                <h3 class="font-semibold">Booking Details:</h3>
                                <p><span class="font-medium">Name:</span> {{ $booking->client_name }}</p>
                                <p><span class="font-medium">Service:</span> {{ $booking->service->name }}</p>
                                <p><span class="font-medium">Date:</span> {{ $booking->booking_date->format('F j, Y') }}</p>
                                <p><span class="font-medium">Time:</span> {{ Carbon\Carbon::parse($booking->booking_time)->format('g:i A') }}</p>
                            </div>

                            <div class="text-sm text-gray-600">
                                <p>We will contact you at {{ $booking->client_phone }} to confirm your appointment.</p>
                            </div>

                            <div class="mt-8 text-center">
                                <a href="{{ route('booking.create') }}"
                                   class="text-primary hover:text-primary-dark underline">
                                    Book Another Appointment
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
