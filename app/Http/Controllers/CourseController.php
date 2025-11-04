<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $search = $request->input('search');
        $gradeLevel = $request->input('grade_level');
        $status = $request->input('status');

        $courses = Course::query()
            ->search($search)
            ->gradeLevel($gradeLevel)
            ->when($status === 'active', fn ($q) => $q->active())
            ->when($status === 'inactive', fn ($q) => $q->inactive())
            ->orderByName()
            ->paginate(10)
            ->withQueryString();

        $gradeLevels = Course::query()
            ->distinct()
            ->whereNotNull('grade_level')
            ->pluck('grade_level')
            ->sort()
            ->values();

        return Inertia::render('courses/index', [
            'courses' => $courses,
            'gradeLevels' => $gradeLevels,
            'filters' => [
                'search' => $search,
                'grade_level' => $gradeLevel,
                'status' => $status,
            ],
        ]);
    }

    /**
     * Show the form for creating a new course.
     */
    public function create(): Response
    {
        return Inertia::render('courses/create');
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'code' => ['nullable', 'string', 'max:50', 'unique:courses,code'],
            'description' => ['nullable', 'string'],
            'grade_level' => ['nullable', 'string', 'max:50'],
            'active' => ['boolean'],
        ]);

        Course::create($validated);

        return redirect()->route('courses.index')
            ->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified course.
     */
    public function show(Course $course): Response
    {
        return Inertia::render('courses/show', [
            'course' => $course,
        ]);
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit(Course $course): Response
    {
        return Inertia::render('courses/edit', [
            'course' => $course,
        ]);
    }

    /**
     * Update the specified course in storage.
     */
    public function update(Request $request, Course $course): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'code' => ['nullable', 'string', 'max:50', 'unique:courses,code,'.$course->id],
            'description' => ['nullable', 'string'],
            'grade_level' => ['nullable', 'string', 'max:50'],
            'active' => ['boolean'],
        ]);

        $course->update($validated);

        return redirect()->route('courses.index')
            ->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified course from storage.
     */
    public function destroy(Course $course): RedirectResponse
    {
        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully.');
    }

    /**
     * Toggle the active status of the specified course.
     */
    public function toggleActive(Course $course): RedirectResponse
    {
        $course->update(['active' => ! $course->active]);

        $status = $course->active ? 'activated' : 'deactivated';

        return back()->with('success', "Course {$status} successfully.");
    }
}
