<?php

namespace App\Livewire;

use App\Models\Service;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class ServicesTable extends Component
{
    public  $services, $viewMode = 'table';

    public $price, $duration, $name, $description, $is_active = true;

    public function mount()
    {
        $this->services = Service::all();
    }
    public function toggleViewMode()
    {
        $this->viewMode = $this->viewMode === 'table' ? 'form' : 'table';
    }

    public function createService()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        Service::create([
            'name' => $this->name,
            'description' => $this->description,
            'duration' => $this->duration,
            'price' => $this->price,
            'is_active' => $this->is_active,
        ]);
        $this->reset(['name', 'description', 'duration', 'price', 'is_active']);
        $this->services = Service::all();

        $this->viewMode = 'table';

    }

    public function deleteService($serviceId)
    {
        $service = Service::find($serviceId);
        if ($service) {
            $service->delete();
            $this->services = Service::all();
        }
    }

    public function render(): View
    {
        return view('livewire.services-table')->extends('layouts.master')->section('contents');
    }
}
