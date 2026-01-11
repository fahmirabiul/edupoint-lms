<?php

namespace App\Services;

use App\Models\Course;
use Illuminate\Pagination\LengthAwarePaginator;

class CourseService
{
    public function getAllCourses(string $search = '', int $perPage = 10): LengthAwarePaginator
    {
        return Course::query()
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate($perPage);
    }

    public function createCourse(array $data): Course
    {
        return Course::create($data);
    }

    public function updateCourse(int $id, array $data): Course
    {
        $course = Course::findOrFail($id);
        $course->update($data);
        return $course;
    }

    public function deleteCourse(int $id): bool
    {
        $course = Course::findOrFail($id);
        return $course->delete();
    }

    public function findCourseById(int $id): Course
    {
        return Course::findOrFail($id);
    }
}
