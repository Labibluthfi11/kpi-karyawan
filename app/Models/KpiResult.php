<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiResult extends Model
{
    protected $fillable = ['assessment_id', 'question_id', 'score', 'note'];

    public function assessment()
    {
        return $this->belongsTo(KpiAssessment::class);
    }

    public function question()
    {
        return $this->belongsTo(KpiQuestion::class);
    }
}
