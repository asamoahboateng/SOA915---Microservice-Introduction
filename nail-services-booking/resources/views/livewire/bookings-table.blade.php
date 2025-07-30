{{-- resources/views/livewire/bookings-table.blade.php --}}
<div>
{{--    <button class="btn btn-primary mb-4" wire:click="toggleViewMode()">--}}
{{--        {{ $viewMode != 'form' ? 'Create Booking' : 'View Bookings' }}--}}
{{--    </button>--}}
    <h3 class="font-normal text-xl mb-4">All Bookings </h3>
    <hr class="mb-4">
    @if($viewMode === 'form')
        <form method="post" wire:submit.prevent="createBooking" class="mb-4 border border-1 border-primary mt-4 p-4 rounded-lg shadow-md">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="client_name" class="block text-sm font-medium">Client Name</label>
                    <input type="text" id="client_name" wire:model.defer="client_name" class="input w-full mt-1" required>
                    @error('client_name')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="client_phone" class="block text-sm font-medium">Phone Number</label>
                    <input type="text" id="client_phone" wire:model.defer="client_phone" class="input w-full mt-1" required>
                    @error('client_phone')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="service_id" class="block text-sm font-medium">Service</label>
                    <select id="service_id" wire:model.defer="service_id" class="select w-full mt-1" required>
                        <option value="">Select a service</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }} - ${{ $service->price }}</option>
                        @endforeach
                    </select>
                    @error('service_id')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="booking_date" class="block text-sm font-medium">Date</label>
                    <input type="date" id="booking_date" wire:model.defer="booking_date" class="input w-full mt-1" required>
                    @error('booking_date')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="booking_time" class="block text-sm font-medium">Time</label>
                    <input type="time" id="booking_time" wire:model.defer="booking_time" class="input w-full mt-1" required>
                    @error('booking_time')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2">
                    <label for="notes" class="block text-sm font-medium">Notes</label>
                    <textarea id="notes" wire:model.defer="notes" class="textarea w-full mt-1" rows="3"></textarea>
                    @error('notes')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Create Booking</button>
                <button type="button" wire:click="$set('viewMode', 'table')" class="btn btn-secondary ml-2">Cancel</button>
            </div>
        </form>
    @else
        <table class="table table-zebra w-full border border-base-content/5 bg-base-100">
            <thead class="border-b border-primary">
                <tr>
                    <th class="border-r">#</th>
                    <th class="border-b">Client</th>
                    <th class="border-b">Service</th>
                    <th class="border-b">Date & Time</th>
                    <th class="border-b">Status</th>
                    <th class="border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                    <tr>
                        <td class="border-r">{{ $loop->iteration }}</td>
                        <td>
                            {{ $booking->client_name }}<br>
                            <span class="text-sm opacity-70">{{ $booking->client_phone }}</span>
                        </td>
                        <td>{{ $booking->service->name }}</td>
                        <td>
                            {{ $booking->booking_date->format('M d, Y') }}<br>
                            <span class="text-sm opacity-70">{{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}</span>
                        </td>
                        <td>
                            {{ $booking->status }}
{{--                            <select wire:change="updateStatus({{ $booking->id }}, $event.target.value)" class="select select-sm">--}}
{{--                                <option value="pending" @selected($booking->status === 'pending')>Pending</option>--}}
{{--                                <option value="confirmed" @selected($booking->status === 'confirmed')>Confirmed</option>--}}
{{--                                <option value="completed" @selected($booking->status === 'completed')>Completed</option>--}}
{{--                                <option value="cancelled" @selected($booking->status === 'cancelled')>Cancelled</option>--}}
{{--                            </select>--}}
                        </td>
                        <td>
                            <!-- change popover-1 and --anchor-1 names. Use unique names for each dropdown -->
                            <button class="btn btn-sm bg-warning" popovertarget="popover-1" style="anchor-name:--anchor-1">
                                Booking Action
                            </button>
                            <ul class="dropdown menu w-52 rounded-box bg-base-100 shadow-sm"
                                popover id="popover-1" style="position-anchor:--anchor-1">
                                <li><a  wire:click="updateStatus({{ $booking->id }}, 'pending')">Pending</a></li>
                                <li><a  wire:click="updateStatus({{ $booking->id }}, 'completed')">Completed</a></li>
                                <li><a  wire:click="updateStatus({{ $booking->id }}, 'cancelled')">Cancelled</a></li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
