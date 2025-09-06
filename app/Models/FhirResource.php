<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FhirResource extends Model
{
    use HasFactory;

    protected $fillable = [
        'resource_type',
        'name',
        'description',
        'example_data',
        'explanation',
        'chile_core_profile',
        'is_active'
    ];

    protected $casts = [
        'example_data' => 'array',
        'is_active' => 'boolean',
    ];

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}
