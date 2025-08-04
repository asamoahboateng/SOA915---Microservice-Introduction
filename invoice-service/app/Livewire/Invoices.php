<?php

namespace App\Livewire;

use App\Models\Invoice;
use App\Models\Service;
use Livewire\Component;
use App\Services\ServiceApi;

class Invoices extends Component
{
    public $invoices;
    public $client_name;
    public $client_email;
    public $client_phone; // Added client_phone
    public $service_id;
    public $service_name;
    public $cost;
    public $status = 'pending';
    public $isEditing = false;
    public $invoiceId;
    public $services;

    public function mount()
    {
        $this->invoices = Invoice::all();
        $this->services =  ServiceApi::getServices();
//        dd($this->services);
    }

    public function create()
    {
        $this->validate([
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'required|string|max:20', // Validate client_phone
            'service_id' => 'required',
            'status' => 'required|in:pending,paid,cancelled',
        ]);

//        $service = Service::find($this->service_id);
//        dd($this->services);
        $service = collect($this->services)
            ->firstWhere('id', $this->service_id);
//        dd($service['name']);
//        $service =  array_values(array_filter($this->services, fn($service) => $service['id'] === $this->service_id));
//        dd($service);

        Invoice::create([
            'client_name' => $this->client_name,
            'client_email' => $this->client_email,
            'client_phone' => $this->client_phone, // Save client_phone
            'service_id' => $this->service_id,
            'service_name' => $service['name'],
            'cost' => $service['price'],
            'status' => $this->status,
        ]);

        $this->resetForm();
        $this->invoices = Invoice::all();
    }

    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        $this->invoiceId = $invoice->id;
        $this->client_name = $invoice->client_name;
        $this->client_email = $invoice->client_email;
        $this->client_phone = $invoice->client_phone; // Load client_phone
        $this->service_id = $invoice->service_id;
        $this->cost = $invoice->cost;
        $this->status = $invoice->status;
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate([
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'required|string|max:20', // Validate client_phone
            'service_id' => 'required',
            'cost' => 'required|numeric|min:0',
            'status' => 'required|in:pending,paid,cancelled',
        ]);

        $service = collect($this->services)
            ->firstWhere('id', $this->service_id);

        $invoice = Invoice::findOrFail($this->invoiceId);
        $invoice->update([
            'client_name' => $this->client_name,
            'client_email' => $this->client_email,
            'client_phone' => $this->client_phone, // Update client_phone
            'service_id' => $this->service_id,
            'service_name' => $service->name,
            'cost' => $this->cost,
            'status' => $this->status,
        ]);

        $this->resetForm();
        $this->invoices = Invoice::all();
    }

    public function resetForm()
    {
        $this->client_name = '';
        $this->client_email = '';
        $this->client_phone = ''; // Reset client_phone
        $this->service_id = '';
        $this->cost = '';
        $this->status = 'pending';
        $this->isEditing = false;
        $this->invoiceId = null;
    }

    public function render()
    {
        return view('livewire.invoices', [
            'services' => Service::all(),
        ])->extends('layouts.master')->section('contents');
    }
}
