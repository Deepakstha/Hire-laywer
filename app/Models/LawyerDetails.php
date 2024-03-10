<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LawyerDetails extends Model
{
    use HasFactory;
    protected $table = 'lawyer_details';
    protected $fillable = ['lawyer_card', 'bio', 'price', 'is_verified', 'lawyer_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
