<div>
    <h1 class="text-2xl font-bold mb-4">Invoices</h1>

    <form wire:submit.prevent="{{ $isEditing ? 'update' : 'create' }}" class="mb-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="client_name" class="block text-sm font-medium">Client Name</label>
                <input type="text" id="client_name" wire:model="client_name" class="input w-full mt-1">
                @error('client_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="client_email" class="block text-sm font-medium">Client Email</label>
                <input type="email" id="client_email" wire:model="client_email" class="input w-full mt-1">
                @error('client_email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="client_phone" class="block text-sm font-medium">Client Phone</label>
                <input type="text" id="client_phone" wire:model="client_phone" class="input w-full mt-1">
                @error('client_phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

{{--            <div>--}}
{{--                <label for="service_id" class="block text-sm font-medium">Service</label>--}}
{{--                <select id="service_id" wire:model="service_id" class="select w-full mt-1">--}}
{{--                    <option value="">Select a service</option>--}}
{{--                    @foreach($services as $service)--}}
{{--                        <option value="{{ $service->id }}">{{ $service->name }} - ${{ $service->price }}</option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--                @error('service_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror--}}
{{--            </div>--}}

            <div>
                <label for="service_id" class="block text-sm font-medium">Service</label>
                <select id="service_id" wire:model="service_id" class="select w-full mt-1">
                    <option value="">Select a service</option>
                    @foreach($services as $service)
                        <option value="{{ $service['id'] }}">{{ $service['name'] }} - ${{ $service['price'] }}</option>
                    @endforeach
                </select>
                @error('service_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="cost" class="block text-sm font-medium">Cost</label>
                <input type="number" id="cost" wire:model="cost" class="input w-full mt-1" step="0.01">
                @error('cost') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="status" class="block text-sm font-medium">Status</label>
                <select id="status" wire:model="status" class="select w-full mt-1">
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                    <option value="cancelled">Cancelled</option>
                </select>
                @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">{{ $isEditing ? 'Update' : 'Create' }}</button>
            @if($isEditing)
                <button type="button" wire:click="resetForm" class="btn btn-secondary ml-2">Cancel</button>
            @endif
        </div>
    </form>

    <table class="table-auto w-full border-collapse border border-gray-300">
        <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2">#</th>
                <th class="border border-gray-300 px-4 py-2">Client Name</th>
                <th class="border border-gray-300 px-4 py-2">Client Email</th>
                <th class="border border-gray-300 px-4 py-2">Client Phone</th>
                <th class="border border-gray-300 px-4 py-2">Service</th>
                <th class="border border-gray-300 px-4 py-2">Cost</th>
                <th class="border border-gray-300 px-4 py-2">Status</th>
                <th class="border border-gray-300 px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $invoice->client_name }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $invoice->client_email }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $invoice->client_phone }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $invoice->service_name }}</td>
                    <td class="border border-gray-300 px-4 py-2">${{ number_format($invoice->cost, 2) }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ ucfirst($invoice->status) }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        <button wire:click="edit({{ $invoice->id }})" class="btn btn-sm btn-primary">Edit</button>
                        <button wire:click="delete({{ $invoice->id }})" class="btn btn-sm btn-danger">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
