<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Document extends Model
{
    use LogsActivity;

    protected $fillable = ['user_id', 'workflow_id', 'title', 'content', 'status', 'current_step_id'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workflow()
    {
        return $this->belongsTo(Workflow::class);
    }

    public function currentStep()
    {
        return $this->belongsTo(WorkflowStep::class, 'current_step_id');
    }

    public function approvals()
    {
        return $this->hasMany(DocumentApproval::class);
    }
}
