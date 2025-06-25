<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CurricularPlan extends Model
{
    use HasFactory;

    protected $table = 'curricular_plans';

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'title',
        'description',
        'age_range',
        'grade_level',
        'pedagogical_style',
    ];
}
