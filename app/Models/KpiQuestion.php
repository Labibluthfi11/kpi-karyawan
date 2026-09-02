<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiQuestion extends Model
{
    protected $fillable = ['category', 'question_text', 'target_role'];
}
