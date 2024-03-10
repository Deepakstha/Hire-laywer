<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ratings extends Model
{
    use HasFactory;
    protected $table = 'ratings';
    protected $fillable = [
        'user_id',
        'ratings',
        'reviews',
        'lawyer_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
