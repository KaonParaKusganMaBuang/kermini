<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use App\Models\RepairJob;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RepairJobController extends Controller
{
    public function index(): View
    {
        return view('repair-jobs.index', [
            'repairJobs' => RepairJob::with(['vehicle.customer', 'mechanic'])->latest('opened_at')->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('repair-jobs.form', [
            'repairJob' => new RepairJob(['opened_at' => today()->toDateString(), 'status' => 'pending']),
            'vehicles' => Vehicle::with('customer')->orderBy('license_plate')->get(),
            'mechanics' => Mechanic::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $repairJob = RepairJob::create($this->validated($request));

        return redirect()->route('repair-jobs.show', $repairJob)->with('success', 'Repair job created successfully.');
    }

    public function show(RepairJob $repairJob): View
    {
        return view('repair-jobs.show', [
            'repairJob' => $repairJob->load('vehicle.customer', 'mechanic', 'parts'),
        ]);
    }

    public function edit(RepairJob $repairJob): View
    {
        return view('repair-jobs.form', [
            'repairJob' => $repairJob,
            'vehicles' => Vehicle::with('customer')->orderBy('license_plate')->get(),
            'mechanics' => Mechanic::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, RepairJob $repairJob): RedirectResponse
    {
        $repairJob->update($this->validated($request));

        return redirect()->route('repair-jobs.show', $repairJob)->with('success', 'Repair job updated successfully.');
    }

    public function destroy(RepairJob $repairJob): RedirectResponse
    {
        $repairJob->delete();

        return redirect()->route('repair-jobs.index')->with('success', 'Repair job and its part records deleted successfully.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'vehicle_id' => ['required', 'integer', 'exists:vehicles,id'],
            'mechanic_id' => ['required', 'integer', 'exists:mechanics,id'],
            'description' => ['required', 'string', 'max:5000'],
            'status' => ['required', Rule::in(['pending', 'in_progress', 'completed'])],
            'labor_cost' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'opened_at' => ['required', 'date'],
            'completed_at' => ['nullable', 'required_if:status,completed', 'date', 'after_or_equal:opened_at'],
        ]);
    }
}
