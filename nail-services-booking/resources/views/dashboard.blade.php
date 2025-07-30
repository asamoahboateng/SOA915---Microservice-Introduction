@extends('layouts.master')

@section('contents')
    <div class="grid grid-col-3 gap-4">
        <div class="stats shadow">
            <div class="stat">
                <div class="stat-title">Total Services</div>
                <div class="stat-value">{{ \App\Models\Service::count() }}</div>
                <div class="stat-desc">All services on the system</div>
            </div>
        </div>

        <div class="stats shadow">
            <div class="stat">
                <div class="stat-title">Total Bookings</div>
                <div class="stat-value">{{ \App\Models\Booking::count() }}</div>
                <div class="stat-desc">All bookings on the system</div>
            </div>
        </div>

    </div>
@endsection
