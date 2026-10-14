<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RepairJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'mechanic_id',
        'description',
        'status',
        'labor_cost',
        'opened_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'labor_cost' => 'decimal:2',
            'opened_at' => 'date',
            'completed_at' => 'date',
        ];
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function mechanic(): BelongsTo
    {
        return $this->belongsTo(Mechanic::class);
    }

    public function parts(): HasMany
    {
        return $this->hasMany(Part::class);
    }
}
