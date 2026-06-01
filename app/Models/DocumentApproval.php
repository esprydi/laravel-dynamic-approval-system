<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class DocumentApproval extends Model
{
    use LogsActivity;

    protected $fillable = ['document_id', 'user_id', 'workflow_step_id', 'status', 'notes'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty();
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function step()
    {
        return $this->belongsTo(WorkflowStep::class, 'workflow_step_id');
    }
}
