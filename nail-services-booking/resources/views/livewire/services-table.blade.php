<div>
    <h3 class="font-normal text-xl mb-4">All Services </h3>
    <hr class="mb-4">

    <button class="btn btn-primary mb-4" wire:click="toggleViewMode()"> {{ $viewMode != 'form' ? 'Create Form' : 'View Table' }}</button>

    @if($viewMode === 'form')
        <form method="post" wire:submit.prevent="createService" class="mb-4 border border-1 border-primary mt-4 p-4 rounded-lg shadow-md">
            <div class="">

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Service Name</label>
                    <input type="text" id="name" wire:model.defer="name" class="input w-full mt-1 rounded-1" required>
                    @error('name')<p class="text-red-500 text-sm font-normal">{{ $message }}</p> @enderror
                </div>
                <div class="my-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="description" rows="4" wire:model.defer="description" class="textarea w-full mt-1" required></textarea>
                    @error('description')<p class="text-red-500 text-sm font-normal">{{ $message }}</p> @enderror
                </div>
                <div class="my-4">
                    <label for="duration" class="block text-sm font-medium text-gray-700">Duration</label>
                    <input type="number" min="1" step="0.1" id="duration" wire:model.defer="duration" class="input w-full mt-1 rounded-1" placeholder="number in hours. eg 1 , 1.5" required>
                    @error('duration')<p class="text-red-500 text-sm font-normal">{{ $message }}</p> @enderror
                </div>
                <div class="my-4">
                    <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="price" min="1" step="0.01" id="duration" wire:model.defer="price" class="input w-full mt-1 rounded-1" placeholder="price" required>
                    @error('price')<p class="text-red-500 text-sm font-normal">{{ $message }}</p> @enderror
                </div>

            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Create Service</button>
                <button type="button" wire:click="$set('viewMode', 'table')" class="btn btn-secondary ml-2">Cancel</button>
            </div>

        </form>
    @else
        <table class="table table-zebra w-full border border-base-content/5 bg-base-100">
            <thead class="border-b border-primary">
                <tr class="border-b ">
                    <th class="border-r  border-b">#</th>
                    <th class=" border-b">Service Name</th>
                    <th class=" border-b">Description</th>
                    <th class=" border-b">Actions</th>
                </tr>
            </thead>
            <tbody class="">
                @foreach($services as $service)
                    <tr>
                        <td class="border-r ">{{ $loop->iteration }}</td>
                        <td class="">{{ $service->name }}</td>
                        <td class="">{{ $service->description }}</td>
                        <td class="">
{{--                            <button class="btn btn-secondary" wire:click="editService({{ $service->id }})">Edit</button>--}}
                            <button class="btn btn-red btn-sm"  wire:confirm="Are you sure you want to delete this?" wire:click="deleteService({{ $service->id }})">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
