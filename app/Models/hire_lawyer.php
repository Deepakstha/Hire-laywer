<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hire_lawyer extends Model
{
    use HasFactory;
    protected $table = 'hire_lawyer';
    protected $fillable = ['lawyer_id', 'client_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
