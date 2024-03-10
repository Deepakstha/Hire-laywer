<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    use HasFactory;
    protected $table = 'appointments';
    protected $fillable = ['lawyer_id', 'client_id', 'booking_start_date', 'booking_end_date'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
