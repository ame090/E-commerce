<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'product_id',
        'message',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    // Relationships
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Helper methods
    public function markAsRead()
    {
        if (!$this->read_at) {
            $this->read_at = now();
            $this->save();
        }
    }

    public function isRead()
    {
        return $this->read_at !== null;
    }
}
