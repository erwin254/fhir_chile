<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'fhir_resource_id',
        'title',
        'slug',
        'content',
        'learning_objectives',
        'interactive_examples',
        'quiz_questions',
        'estimated_duration',
        'order',
        'is_active'
    ];

    protected $casts = [
        'interactive_examples' => 'array',
        'quiz_questions' => 'array',
        'is_active' => 'boolean',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function fhirResource()
    {
        return $this->belongsTo(FhirResource::class);
    }

    public function userProgress()
    {
        return $this->hasMany(UserProgress::class);
    }
}
