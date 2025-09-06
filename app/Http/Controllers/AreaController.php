<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\UserProgress;

class AreaController extends Controller
{
    public function show($slug)
    {
        $area = Area::where('slug', $slug)
            ->where('is_active', true)
            ->with(['activeModules' => function($query) {
                $query->with(['activeLessons' => function($q) {
                    $q->with('fhirResource');
                }]);
            }])
            ->firstOrFail();

        $userProgress = null;
        $moduleProgress = null;
        
        if (auth()->check()) {
            $userId = auth()->id();
            
            // Progreso de lecciones
            $userProgress = UserProgress::where('user_id', $userId)
                ->whereHas('lesson.module', function($query) use ($area) {
                    $query->where('area_id', $area->id);
                })
                ->with('lesson')
                ->get()
                ->keyBy('lesson_id');

            // Progreso de módulos
            $moduleProgress = [];
            foreach ($area->activeModules as $module) {
                $moduleProgress[$module->id] = $module->getProgressForUser($userId);
            }
        }

        return view('areas.show', compact('area', 'userProgress', 'moduleProgress'));
    }
}
