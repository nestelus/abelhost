<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Task extends Model {

    use HasFactory;

    protected $fillable = [
        'date_end',
        'description',
        'step_id',
        'assigned_id',
    ];

    public function assigned() {
        return $this->belongsTo(User::class, 'assigned_id');
    }

}
