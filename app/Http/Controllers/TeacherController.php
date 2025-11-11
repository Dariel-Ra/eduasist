<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $search = $request->input("search");
        $specialty = $request->input("specialty");

        $teachers = Teacher::query()
            ->with('user')
            ->search($search)
            ->bySpecialty($specialty)
            ->recent()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('teachers/index', [
            'teachers' => $teachers,
            'filters' => [
                'search' => $search,
                'specialty' => $specialty,
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        // Get users that are not already teachers
        $availableUsers = User::query()
            ->whereDoesntHave('teacher')
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        return Inertia::render('teachers/create', [
            'users' => $availableUsers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id', 'unique:teachers,user_id'],
            'employee_code' => ['nullable', 'string', 'max:50', 'unique:teachers,employee_code'],
            'specialty' => ['nullable', 'string', 'max:100'],
        ]);

        Teacher::create($validated);

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher): Response
    {
        $teacher->load('user');

        return Inertia::render('teachers/show', [
            'teacher' => $teacher,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher): Response
    {
        $teacher->load('user');

        return Inertia::render('teachers/edit', [
            'teacher' => $teacher,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher): RedirectResponse
    {
        $validated = $request->validate([
            'employee_code' => ['nullable', 'string', 'max:50', 'unique:teachers,employee_code,'.$teacher->id],
            'specialty' => ['nullable', 'string', 'max:100'],
        ]);

        $teacher->update($validated);

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher updated successfully.');
    }

    /**
     * Remove the specified teacher from storage.
     */
    public function destroy(Teacher $teacher): RedirectResponse
    {
        $teacher->delete();

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher deleted successfully.');
    }
}
