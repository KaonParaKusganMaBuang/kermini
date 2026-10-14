<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class VehicleController extends Controller
{
    public function index(): View
    {
        return view('vehicles.index', [
            'vehicles' => Vehicle::with('customer')->orderBy('make')->orderBy('model')->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('vehicles.form', ['vehicle' => new Vehicle, 'customers' => Customer::orderBy('name')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $vehicle = Vehicle::create($this->validated($request));

        return redirect()->route('vehicles.show', $vehicle)->with('success', 'Vehicle added successfully.');
    }

    public function show(Vehicle $vehicle): View
    {
        return view('vehicles.show', [
            'vehicle' => $vehicle->load('customer', 'repairJobs.mechanic', 'repairJobs.parts'),
        ]);
    }

    public function edit(Vehicle $vehicle): View
    {
        return view('vehicles.form', ['vehicle' => $vehicle, 'customers' => Customer::orderBy('name')->get()]);
    }

    public function update(Request $request, Vehicle $vehicle): RedirectResponse
    {
        $vehicle->update($this->validated($request, $vehicle));

        return redirect()->route('vehicles.show', $vehicle)->with('success', 'Vehicle updated successfully.');
    }

    public function destroy(Vehicle $vehicle): RedirectResponse
    {
        if ($vehicle->repairJobs()->exists()) {
            return redirect()->route('vehicles.index')->with('error', 'This vehicle cannot be deleted while it has repair-job history.');
        }

        $vehicle->delete();

        return redirect()->route('vehicles.index')->with('success', 'Vehicle deleted successfully.');
    }

    private function validated(Request $request, ?Vehicle $vehicle = null): array
    {
        return $request->validate([
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'make' => ['required', 'string', 'max:100'],
            'model' => ['required', 'string', 'max:100'],
            'year' => ['required', 'integer', 'between:1886,'.(now()->year + 1)],
            'license_plate' => ['required', 'string', 'max:30', Rule::unique('vehicles', 'license_plate')->ignore($vehicle?->id)],
            'vin' => ['nullable', 'string', 'size:17', Rule::unique('vehicles', 'vin')->ignore($vehicle?->id)],
        ]);
    }
}
