<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\UserProgress;

class LessonController extends Controller
{
    public function show($slug)
    {
        $lesson = Lesson::where('slug', $slug)
            ->where('is_active', true)
            ->with(['module.area', 'fhirResource'])
            ->firstOrFail();

        $userProgress = null;
        if (auth()->check()) {
            $userProgress = UserProgress::where('user_id', auth()->id())
                ->where('lesson_id', $lesson->id)
                ->first();

            if (!$userProgress) {
                $userProgress = UserProgress::create([
                    'user_id' => auth()->id(),
                    'lesson_id' => $lesson->id,
                    'status' => 'in_progress',
                    'started_at' => now(),
                ]);
            }
        }

        return view('lessons.show', compact('lesson', 'userProgress'));
    }

    public function updateProgress(Request $request, $slug)
    {
        $lesson = Lesson::where('slug', $slug)->firstOrFail();
        
        if (!auth()->check()) {
            return response()->json(['error' => 'No autenticado'], 401);
        }

        $userProgress = UserProgress::where('user_id', auth()->id())
            ->where('lesson_id', $lesson->id)
            ->first();

        if (!$userProgress) {
            return response()->json(['error' => 'Progreso no encontrado'], 404);
        }

        $userProgress->update([
            'progress_percentage' => $request->progress_percentage,
            'time_spent' => $request->time_spent,
            'status' => $request->progress_percentage >= 100 ? 'completed' : 'in_progress',
            'completed_at' => $request->progress_percentage >= 100 ? now() : null,
        ]);

        return response()->json(['success' => true, 'progress' => $userProgress]);
    }
}
