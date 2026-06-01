<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    protected $fillable = ['name', 'description'];

    public function steps()
    {
        return $this->hasMany(WorkflowStep::class)->orderBy('order', 'asc');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
