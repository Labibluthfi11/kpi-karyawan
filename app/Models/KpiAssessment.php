<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;

class KpiAssessment extends Model
{
    use Loggable;

    protected $fillable = ['evaluator_id', 'evaluatee_id', 'assessment_date', 'period_id', 'status', 'general_note'];

    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }

    public function evaluatee()
    {
        return $this->belongsTo(User::class, 'evaluatee_id');
    }

    public function period()
    {
        return $this->belongsTo(AssessmentPeriod::class, 'period_id');
    }

    public function results()
    {
        return $this->hasMany(KpiResult::class, 'assessment_id');
    }
}
