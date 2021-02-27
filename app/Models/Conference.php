<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    
    protected $fillable = [
        'name',
        'user_id',
        'status',
        'start_date',
        'end_date',
        'abstract_submission_date',
        'full_paper_date',
        'acceptance_notification_date',
        'place',
        'logo',
    ];
}
