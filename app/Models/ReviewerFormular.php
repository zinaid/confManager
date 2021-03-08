<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewerFormular extends Model
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
        'reviewer_acceptance',
        'date_of_acceptance',
        'status',
        'reviewer_id',
        'paper_id',
        'decision',
        'decision_date',
        'ip_timestamp',
        'author_instructions',
        'paper_type',
        'paper_contribution',
        'paper_interest',
        'paper_structure',
        'paper_supplementary_parts',
        'paper_terminology',
        'paper_acceptance',
        'reviewer_comment',
        'reviewer_comment_editor',
        'reviewer_file',
    ];
}
