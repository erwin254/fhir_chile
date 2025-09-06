<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_id',
        'name',
        'slug',
        'description',
        'objectives',
        'icon',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    public function activeLessons()
    {
        return $this->hasMany(Lesson::class)->where('is_active', true)->orderBy('order');
    }

    /**
     * Calcular el progreso del módulo para un usuario específico
     */
    public function getProgressForUser($userId)
    {
        $totalLessons = $this->activeLessons()->count();
        if ($totalLessons === 0) {
            return [
                'completed_lessons' => 0,
                'total_lessons' => 0,
                'progress_percentage' => 0,
                'is_completed' => false,
                'status' => 'not_started'
            ];
        }

        $completedLessons = UserProgress::where('user_id', $userId)
            ->whereIn('lesson_id', $this->activeLessons()->pluck('id'))
            ->where('status', 'completed')
            ->count();

        $progressPercentage = round(($completedLessons / $totalLessons) * 100);
        $isCompleted = $completedLessons === $totalLessons;

        $status = 'not_started';
        if ($isCompleted) {
            $status = 'completed';
        } elseif ($completedLessons > 0) {
            $status = 'in_progress';
        }

        return [
            'completed_lessons' => $completedLessons,
            'total_lessons' => $totalLessons,
            'progress_percentage' => $progressPercentage,
            'is_completed' => $isCompleted,
            'status' => $status
        ];
    }

    /**
     * Verificar si el módulo está completado para un usuario
     */
    public function isCompletedByUser($userId)
    {
        $progress = $this->getProgressForUser($userId);
        return $progress['is_completed'];
    }
}
