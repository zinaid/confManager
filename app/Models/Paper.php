<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'abstract',
        'keywords',
        'paper_number',
        'author',
        'type',  
        'student',
        'conference',
        'section',
        'topic_area',
        'file',
        'created_at',
        'status',
        'paper_timestamp',
    ];
}
