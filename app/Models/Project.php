<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

   /**
     * @var array
     */
    protected $fillable = [
        'title',
        'date_start',
        'date_end',
        'description',
        'creator_id',
        'assigned_id'
    ];

}
