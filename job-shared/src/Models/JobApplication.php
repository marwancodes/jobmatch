<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobApplication extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = "job_applications";

    protected $keyType = "string";

    public $incrementing = false;

    protected $fillable = [
        "status",
        "aiGeneratedScore",
        "aiGeneratedFeedback",
        "userId",
        "resumeId",
        "jobVacancyId",
    ];

    protected $dates = [
        "deleted_at",
    ];

    protected function casts(): array
    { 
        return [
            'deleted_at' => 'datetime',
        ];
    }


    public function user() {
        return $this->belongsTo(User::class, 'userId', ownerKey: 'id');
    }

    public function jobVacancy() {
        return $this->belongsTo(JobVacancy::class, foreignKey: 'jobVacancyId', ownerKey: 'id');
    }
    public function resume() {
        return $this->belongsTo(Resume::class, foreignKey: 'resumeId', ownerKey: 'id');
    }

}
