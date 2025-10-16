<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'type',
        'discount_value',
        'min_purchase',
        'usage_limit',
        'used_count',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Helper methods
    public function isValid()
    {
        $now = Carbon::now();
        
        if (!$this->is_active) {
            return false;
        }
        
        if ($now->lt($this->start_date) || $now->gt($this->end_date)) {
            return false;
        }
        
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }
        
        return true;
    }

    public function calculateDiscount($amount)
    {
        if (!$this->isValid()) {
            return 0;
        }

        if ($this->min_purchase && $amount < $this->min_purchase) {
            return 0;
        }

        if ($this->type === 'percentage') {
            return $amount * ($this->discount_value / 100);
        }

        return $this->discount_value;
    }
}
