<?php

namespace App\Repositories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;

class CourseRepository implements CourseRepositoryInterface
{
    public function all(): Collection
    {
        return Course::all();
    }

    public function findById(int $id)
    {
        return Course::findOrFail($id);
    }

    public function findBySlug(string $slug)
    {
        return Course::where('slug', $slug)->firstOrFail();
    }

    public function create(array $data)
    {
        return Course::create($data);
    }

    public function update(int $id, array $data)
    {
        $course = Course::findOrFail($id);
        $course->update($data);
        return $course;
    }

    public function delete(int $id): bool
    {
        return Course::destroy($id) > 0;
    }
}
