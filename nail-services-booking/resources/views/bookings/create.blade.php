@extends('layouts.auth')
@section('title', 'Create Booking')

@section('contents')
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold mb-6">Book an Appointment</h2>

                    @if ($errors->any())
                        <div class="bg-red-50 text-red-500 p-4 rounded-lg mb-6">
                            <ul class="list-disc pl-4">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('booking.store') }}" method="POST">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="client_name" value="{{ old('client_name') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"
                                       required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <input type="tel" name="client_phone" value="{{ old('client_phone') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"
                                       required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="client_email" value="{{ old('client_email') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"
                                       required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Service</label>
                                <select name="service_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"
                                        required>
                                    <option value="">Select a service</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}"
                                            {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                            {{ $service->name }} - ${{ number_format($service->price, 2) }}
                                            ({{ $service->duration }} min)
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Date</label>
                                    <input type="date" name="booking_date" value="{{ old('booking_date') }}"
                                           min="{{ date('Y-m-d') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"
                                           required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Time</label>
                                    <input type="time" name="booking_time" value="{{ old('booking_time') }}"
                                           min="09:00" max="20:00"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"
                                           required>
                                    <p class="mt-1 text-sm text-gray-500">Business hours: 9:00 AM - 8:00 PM</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Notes</label>
                                <textarea name="notes" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">{{ old('notes') }}</textarea>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit"
                                        class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                                    Book Appointment
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
