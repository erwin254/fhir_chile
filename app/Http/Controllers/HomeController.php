<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\UserProgress;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $areas = Area::where('is_active', true)
            ->with(['activeModules' => function($query) {
                $query->with(['activeLessons']);
            }])
            ->orderBy('order')
            ->get();

        $progressStats = null;
        if (auth()->check()) {
            $userId = auth()->id();
            
            // Estadísticas generales
            $totalLessons = 0;
            $completedLessons = 0;
            $totalModules = 0;
            $completedModules = 0;
            
            foreach ($areas as $area) {
                foreach ($area->activeModules as $module) {
                    $totalModules++;
                    $moduleLessons = $module->activeLessons->count();
                    $totalLessons += $moduleLessons;
                    
                    $moduleProgress = $module->getProgressForUser($userId);
                    if ($moduleProgress['is_completed']) {
                        $completedModules++;
                    }
                    $completedLessons += $moduleProgress['completed_lessons'];
                }
            }
            
            $progressStats = [
                'total_lessons' => $totalLessons,
                'completed_lessons' => $completedLessons,
                'total_modules' => $totalModules,
                'completed_modules' => $completedModules,
                'overall_progress' => $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0
            ];
        }

        return view('home', compact('areas', 'progressStats'));
    }
}
