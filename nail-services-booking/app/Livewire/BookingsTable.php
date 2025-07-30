<?php
// app/Livewire/BookingsTable.php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class BookingsTable extends Component
{
    public $bookings;
    public $viewMode = 'table';
    public $services;

    // Form fields
    public $client_name;
    public $client_phone;
    public $service_id;
    public $booking_date;
    public $booking_time;
    public $notes;
    public $status = 'pending';

    public function mount()
    {
        $this->bookings = Booking::with('service')->get();
        $this->services = Service::where('is_active', true)->get();
    }

    public function toggleViewMode()
    {
        $this->viewMode = $this->viewMode === 'table' ? 'form' : 'table';
    }

    public function createBooking()
    {
        $this->validate([
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:20',
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required',
            'notes' => 'nullable|string',
        ]);

        Booking::create([
            'client_name' => $this->client_name,
            'client_phone' => $this->client_phone,
            'service_id' => $this->service_id,
            'booking_date' => $this->booking_date,
            'booking_time' => $this->booking_time,
            'notes' => $this->notes,
            'status' => $this->status,
        ]);

        $this->reset(['client_name', 'client_phone', 'service_id', 'booking_date', 'booking_time', 'notes', 'status']);
        $this->bookings = Booking::with('service')->get();
        $this->viewMode = 'table';
    }

    public function deleteBooking($bookingId)
    {
        $booking = Booking::find($bookingId);
        if ($booking) {
            $booking->delete();
            $this->bookings = Booking::with('service')->get();
        }
    }

    public function updateStatus($bookingId, $status)
    {
        $booking = Booking::find($bookingId);
        if ($booking) {
            $booking->update(['status' => $status]);
            $this->bookings = Booking::with('service')->get();
        }
    }

    public function render(): View
    {
        return view('livewire.bookings-table')->extends('layouts.master')->section('contents');
    }
}
