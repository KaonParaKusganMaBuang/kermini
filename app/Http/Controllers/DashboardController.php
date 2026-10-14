<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Mechanic;
use App\Models\Part;
use App\Models\RepairJob;
use App\Models\Vehicle;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('dashboard', [
            'customerCount' => Customer::count(),
            'vehicleCount' => Vehicle::count(),
            'mechanicCount' => Mechanic::count(),
            'openJobCount' => RepairJob::whereIn('status', ['pending', 'in_progress'])->count(),
            'partCount' => Part::count(),
            'recentJobs' => RepairJob::with(['vehicle.customer', 'mechanic'])->latest('opened_at')->take(6)->get(),
        ]);
    }
}
