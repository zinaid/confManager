<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditorFormular extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;

    protected $fillable = [
        'created_at',
        'decision',
        'status',
        'editor_id',
        'paper_id',
        'decision_date',
        'ip_timestamp',
    ];
}
