<?php

namespace App\Repositories;

use App\Models\Enrollment;

class EnrollmentRepository implements EnrollmentRepositoryInterface
{
    public function create(array $data): Enrollment
    {
        return Enrollment::create($data);
    }

    public function findById(int $id): ?Enrollment
    {
        return Enrollment::find($id);
    }

    public function update(int $id, array $data): Enrollment
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->update($data);
        return $enrollment;
    }

    public function exists(int $userId, int $courseId): bool
    {
        return Enrollment::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->exists();
    }

    public function findByUserAndCourse(int $userId, int $courseId): ?Enrollment
    {
        return Enrollment::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->first();
    }
}
