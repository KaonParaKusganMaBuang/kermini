<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\RepairJob;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PartController extends Controller
{
    public function index(): View
    {
        return view('parts.index', [
            'parts' => Part::with('repairJob.vehicle')->latest()->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('parts.form', ['part' => new Part(['quantity' => 1]), 'repairJobs' => $this->repairJobs()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $part = Part::create($this->validated($request));

        return redirect()->route('parts.show', $part)->with('success', 'Part record added successfully.');
    }

    public function show(Part $part): View
    {
        return view('parts.show', ['part' => $part->load('repairJob.vehicle')]);
    }

    public function edit(Part $part): View
    {
        return view('parts.form', ['part' => $part, 'repairJobs' => $this->repairJobs()]);
    }

    public function update(Request $request, Part $part): RedirectResponse
    {
        $part->update($this->validated($request));

        return redirect()->route('parts.show', $part)->with('success', 'Part record updated successfully.');
    }

    public function destroy(Part $part): RedirectResponse
    {
        $part->delete();

        return redirect()->route('parts.index')->with('success', 'Part record deleted successfully.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'repair_job_id' => ['required', 'integer', 'exists:repair_jobs,id'],
            'name' => ['required', 'string', 'max:255'],
            'part_number' => ['nullable', 'string', 'max:100'],
            'quantity' => ['required', 'integer', 'min:1', 'max:1000000'],
            'unit_price' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
        ]);
    }

    private function repairJobs()
    {
        return RepairJob::with('vehicle')->latest('opened_at')->get();
    }
}
