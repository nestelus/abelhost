<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'date_end',
        'description',
        'project_id',
        'assigned_id',
    ];

    public function assigned() {
        return $this->belongsTo(User::class, 'assigned_id');
    }

}
