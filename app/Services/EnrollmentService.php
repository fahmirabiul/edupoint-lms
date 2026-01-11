<?php

namespace App\Services;

use App\Interfaces\Payments\PaymentGatewayInterface;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\CourseRepositoryInterface;
use App\Repositories\EnrollmentRepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Exception;

class EnrollmentService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected CourseRepositoryInterface $courseRepository,
        protected EnrollmentRepositoryInterface $enrollmentRepository
    ) {}

    public function enrollUser(int $userId, int $courseId, PaymentGatewayInterface $paymentGateway): Enrollment
    {
        if ($this->isUserEnrolled($userId, $courseId)) {
            throw new Exception('User already enrolled in this course.');
        }

        $user = $this->userRepository->findById($userId);
        $course = $this->courseRepository->findById($courseId);

        $isPaid = $paymentGateway->charge($course->price, [
            'user_id' => $userId,
            'course_id' => $courseId,
            'email' => $user->email,
        ]);

        if (!$isPaid) {
            throw new Exception('Payment failed. Enrollment not completed.');
        }

        $enrollment = Enrollment::create([
            'user_id' => $userId,
            'course_id' => $courseId,
            'status' => 'success',
            'payment_method' => class_basename($paymentGateway),
        ]);

        event(new \App\Events\UserEnrolled($enrollment));

        return $enrollment;
    }

    public function updateEnrollmentStatus(int $enrollmentId, string $status, ?string $paymentMethod = null): Enrollment
    {
        $enrollment = $this->enrollmentRepository->findById($enrollmentId);

        $enrollment->update([
            'status' => $status,
            'payment_method' => $paymentMethod ?? $enrollment->payment_method,
        ]);

        return $enrollment;
    }

    public function isUserEnrolled(int $userId, int $courseId): bool
    {
        return $this->enrollmentRepository->exists($userId, $courseId);
    }

    public function getUserEnrollment(int $userId, int $courseId): ?Enrollment
    {
        return $this->enrollmentRepository->findByUserAndCourse($userId, $courseId);
    }

    public function getAllEnrollments(string $search = '', int $perPage = 10): LengthAwarePaginator
    {
        return Enrollment::with(['user', 'course'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('course', function ($q) use ($search) {
                        $q->where('title', 'like', '%' . $search . '%');
                    });
            })
            ->latest()
            ->paginate($perPage);
    }

    public function confirmPayment(int $enrollmentId): Enrollment
    {
        $enrollment = Enrollment::findOrFail($enrollmentId);
        $enrollment->update(['status' => 'success']);
        return $enrollment;
    }

    public function cancelEnrollment(int $enrollmentId): bool
    {
        $enrollment = Enrollment::findOrFail($enrollmentId);
        return $enrollment->delete();
    }
}
