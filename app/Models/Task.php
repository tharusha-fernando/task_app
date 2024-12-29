<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\TaskObserver;
use App\Observers\TaskObvserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
#[ObservedBy([TaskObvserver::class])]
class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'priority',
        'project_id',
        'created_by',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);//->nullable();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
