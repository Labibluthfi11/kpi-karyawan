<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiAssessment extends Model
{
    protected $fillable = ['evaluator_id', 'evaluatee_id', 'assessment_date'];

    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }

    public function evaluatee()
    {
        return $this->belongsTo(User::class, 'evaluatee_id');
    }

    public function results()
    {
        return $this->hasMany(KpiResult::class, 'assessment_id');
    }
}
