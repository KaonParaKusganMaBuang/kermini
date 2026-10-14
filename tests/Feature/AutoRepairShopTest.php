<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Mechanic;
use App\Models\Part;
use App\Models\RepairJob;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AutoRepairShopTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_and_all_module_lists_load(): void
    {
        $this->get(route('dashboard'))->assertOk()->assertSee('WrenchWorks');
        $this->get(route('customers.index'))->assertOk();
        $this->get(route('vehicles.index'))->assertOk();
        $this->get(route('mechanics.index'))->assertOk();
        $this->get(route('repair-jobs.index'))->assertOk();
        $this->get(route('parts.index'))->assertOk();
    }

    public function test_database_seeder_populates_related_records_in_all_five_project_tables(): void
    {
        $this->seed();

        $this->assertGreaterThanOrEqual(12, Customer::count());
        $this->assertGreaterThanOrEqual(12, Vehicle::count());
        $this->assertGreaterThanOrEqual(5, Mechanic::count());
        $this->assertGreaterThanOrEqual(12, RepairJob::count());
        $this->assertGreaterThanOrEqual(12, Part::count());
        $this->assertSame(0, Vehicle::whereDoesntHave('customer')->count());
        $this->assertSame(0, RepairJob::whereDoesntHave('mechanic')->orWhereDoesntHave('vehicle')->count());
        $this->assertSame(0, Part::whereDoesntHave('repairJob')->count());
    }

    public function test_customer_can_be_created_updated_and_deleted(): void
    {
        $customerData = [
            'name' => 'Jordan Lee',
            'email' => 'jordan@example.com',
            'phone' => '555-0101',
            'address' => '10 Main Street',
        ];

        $this->post(route('customers.store'), $customerData)->assertRedirect();
        $customer = Customer::where('email', 'jordan@example.com')->firstOrFail();
        $this->assertDatabaseHas('customers', ['id' => $customer->id, 'name' => 'Jordan Lee']);

        $this->put(route('customers.update', $customer), [...$customerData, 'name' => 'Jordan L.'])->assertRedirect();
        $this->assertDatabaseHas('customers', ['id' => $customer->id, 'name' => 'Jordan L.']);

        $this->delete(route('customers.destroy', $customer))->assertRedirect(route('customers.index'));
        $this->assertDatabaseMissing('customers', ['id' => $customer->id]);
    }

    public function test_vehicle_and_mechanic_crud_and_relationship_delete_guards(): void
    {
        $customer = Customer::factory()->create();
        $mechanic = Mechanic::factory()->create();

        $this->post(route('vehicles.store'), [
            'customer_id' => $customer->id,
            'make' => 'Toyota',
            'model' => 'Corolla',
            'year' => 2022,
            'license_plate' => 'ABC-1234',
            'vin' => '1HGCM82633A004352',
        ])->assertRedirect();
        $vehicle = Vehicle::where('license_plate', 'ABC-1234')->firstOrFail();

        $this->put(route('vehicles.update', $vehicle), [
            'customer_id' => $customer->id,
            'make' => 'Toyota',
            'model' => 'Camry',
            'year' => 2023,
            'license_plate' => 'ABC-1234',
            'vin' => '1HGCM82633A004352',
        ])->assertRedirect();
        $this->assertDatabaseHas('vehicles', ['id' => $vehicle->id, 'model' => 'Camry']);

        $job = RepairJob::factory()->for($vehicle)->for($mechanic)->create();
        $this->delete(route('vehicles.destroy', $vehicle))->assertSessionHas('error');
        $this->delete(route('customers.destroy', $customer))->assertSessionHas('error');

        $this->post(route('mechanics.store'), [
            'name' => 'Avery Smith',
            'email' => 'avery@example.com',
            'phone' => '555-0102',
            'specialty' => 'Brakes',
        ])->assertRedirect();
        $newMechanic = Mechanic::where('email', 'avery@example.com')->firstOrFail();
        $this->put(route('mechanics.update', $newMechanic), [
            'name' => 'Avery Smith',
            'email' => 'avery@example.com',
            'phone' => '555-0102',
            'specialty' => 'Engine repair',
        ])->assertRedirect();
        $this->assertDatabaseHas('mechanics', ['id' => $newMechanic->id, 'specialty' => 'Engine repair']);

        $this->delete(route('mechanics.destroy', $mechanic))->assertSessionHas('error');
        $this->delete(route('repair-jobs.destroy', $job))->assertRedirect(route('repair-jobs.index'));
        $this->delete(route('vehicles.destroy', $vehicle))->assertRedirect(route('vehicles.index'));
        $this->delete(route('customers.destroy', $customer))->assertRedirect(route('customers.index'));
        $this->delete(route('mechanics.destroy', $mechanic))->assertRedirect(route('mechanics.index'));
    }

    public function test_repair_job_and_parts_crud_and_cascade_delete(): void
    {
        $vehicle = Vehicle::factory()->for(Customer::factory())->create();
        $mechanic = Mechanic::factory()->create();

        $this->post(route('repair-jobs.store'), [
            'vehicle_id' => $vehicle->id,
            'mechanic_id' => $mechanic->id,
            'description' => 'Replace worn brake pads',
            'status' => 'pending',
            'labor_cost' => '120.00',
            'opened_at' => '2026-10-01',
            'completed_at' => '',
        ])->assertRedirect();
        $repairJob = RepairJob::firstOrFail();

        $this->put(route('repair-jobs.update', $repairJob), [
            'vehicle_id' => $vehicle->id,
            'mechanic_id' => $mechanic->id,
            'description' => 'Replace front brake pads',
            'status' => 'completed',
            'labor_cost' => '150.00',
            'opened_at' => '2026-10-01',
            'completed_at' => '2026-10-02',
        ])->assertRedirect();
        $this->assertDatabaseHas('repair_jobs', ['id' => $repairJob->id, 'status' => 'completed']);

        $this->post(route('parts.store'), [
            'repair_job_id' => $repairJob->id,
            'name' => 'Brake pads',
            'part_number' => 'BP-001',
            'quantity' => 2,
            'unit_price' => '45.50',
        ])->assertRedirect();
        $part = Part::firstOrFail();

        $this->put(route('parts.update', $part), [
            'repair_job_id' => $repairJob->id,
            'name' => 'Ceramic brake pads',
            'part_number' => 'BP-001',
            'quantity' => 2,
            'unit_price' => '49.50',
        ])->assertRedirect();
        $this->assertDatabaseHas('parts', ['id' => $part->id, 'name' => 'Ceramic brake pads']);
        $this->get(route('repair-jobs.show', $repairJob))->assertOk()->assertSee('Ceramic brake pads');

        $removablePart = Part::factory()->for($repairJob)->create();
        $this->delete(route('parts.destroy', $removablePart))->assertRedirect(route('parts.index'));
        $this->assertDatabaseMissing('parts', ['id' => $removablePart->id]);

        $this->delete(route('repair-jobs.destroy', $repairJob))->assertRedirect(route('repair-jobs.index'));
        $this->assertDatabaseMissing('parts', ['id' => $part->id]);
    }

    public function test_invalid_foreign_keys_and_incomplete_completed_jobs_are_rejected(): void
    {
        $vehicle = Vehicle::factory()->for(Customer::factory())->create();
        $mechanic = Mechanic::factory()->create();

        $this->post(route('repair-jobs.store'), [
            'vehicle_id' => 99999,
            'mechanic_id' => $mechanic->id,
            'description' => 'Inspect engine',
            'status' => 'pending',
            'labor_cost' => 0,
            'opened_at' => '2026-10-01',
        ])->assertSessionHasErrors('vehicle_id');

        $this->post(route('repair-jobs.store'), [
            'vehicle_id' => $vehicle->id,
            'mechanic_id' => $mechanic->id,
            'description' => 'Inspect engine',
            'status' => 'completed',
            'labor_cost' => 0,
            'opened_at' => '2026-10-01',
        ])->assertSessionHasErrors('completed_at');
    }
}
