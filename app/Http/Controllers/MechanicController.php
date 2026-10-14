<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MechanicController extends Controller
{
    public function index(): View
    {
        return view('mechanics.index', [
            'mechanics' => Mechanic::withCount('repairJobs')->orderBy('name')->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('mechanics.form', ['mechanic' => new Mechanic]);
    }

    public function store(Request $request): RedirectResponse
    {
        $mechanic = Mechanic::create($this->validated($request));

        return redirect()->route('mechanics.show', $mechanic)->with('success', 'Mechanic added successfully.');
    }

    public function show(Mechanic $mechanic): View
    {
        return view('mechanics.show', [
            'mechanic' => $mechanic->load('repairJobs.vehicle.customer'),
        ]);
    }

    public function edit(Mechanic $mechanic): View
    {
        return view('mechanics.form', compact('mechanic'));
    }

    public function update(Request $request, Mechanic $mechanic): RedirectResponse
    {
        $mechanic->update($this->validated($request, $mechanic));

        return redirect()->route('mechanics.show', $mechanic)->with('success', 'Mechanic updated successfully.');
    }

    public function destroy(Mechanic $mechanic): RedirectResponse
    {
        if ($mechanic->repairJobs()->exists()) {
            return redirect()->route('mechanics.index')->with('error', 'This mechanic cannot be deleted while assigned to repair jobs.');
        }

        $mechanic->delete();

        return redirect()->route('mechanics.index')->with('success', 'Mechanic deleted successfully.');
    }

    private function validated(Request $request, ?Mechanic $mechanic = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('mechanics', 'email')->ignore($mechanic?->id)],
            'phone' => ['required', 'string', 'max:30'],
            'specialty' => ['required', 'string', 'max:255'],
        ]);
    }
}
