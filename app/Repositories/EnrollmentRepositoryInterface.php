<?php

namespace App\Repositories;

use App\Models\Enrollment;

interface EnrollmentRepositoryInterface
{
    public function create(array $data): Enrollment;

    public function findById(int $id): ?Enrollment;

    public function update(int $id, array $data): Enrollment;

    public function exists(int $userId, int $courseId): bool;

    public function findByUserAndCourse(int $userId, int $courseId): ?Enrollment;
}
