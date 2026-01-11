<?php

namespace Tests\Feature;

use App\Events\UserEnrolled;
use App\Interfaces\Payments\PaymentGatewayInterface;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use App\Repositories\CourseRepositoryInterface;
use App\Repositories\EnrollmentRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Services\EnrollmentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class EnrollmentServiceTest extends TestCase
{
    use RefreshDatabase;

    private EnrollmentService $enrollmentService;
    private $userRepository;
    private $courseRepository;
    private $enrollmentRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->courseRepository = $this->createMock(CourseRepositoryInterface::class);
        $this->enrollmentRepository = $this->createMock(EnrollmentRepositoryInterface::class);

        $this->enrollmentService = new EnrollmentService(
            $this->userRepository,
            $this->courseRepository,
            $this->enrollmentRepository
        );
    }

    public function test_user_can_enroll_in_course_successfully(): void
    {
        Event::fake();

        $user = User::factory()->create(['email' => 'test@example.com']);
        $course = Course::factory()->create(['price' => 100]);

        $this->enrollmentRepository->method('exists')->willReturn(false);
        $this->userRepository->method('findById')->willReturn($user);
        $this->courseRepository->method('findById')->willReturn($course);

        $paymentGateway = $this->createMock(PaymentGatewayInterface::class);
        $paymentGateway->method('charge')->willReturn(true);

        $enrollment = $this->enrollmentService->enrollUser($user->id, $course->id, $paymentGateway);

        $this->assertDatabaseHas('enrollments', [
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'success',
        ]);

        Event::assertDispatched(UserEnrolled::class);
    }

    public function test_user_cannot_enroll_twice_in_same_course(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();

        $this->enrollmentRepository->method('exists')->willReturn(true);

        $paymentGateway = $this->createMock(PaymentGatewayInterface::class);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('User already enrolled in this course.');

        $this->enrollmentService->enrollUser($user->id, $course->id, $paymentGateway);
    }

    public function test_enrollment_fails_when_payment_fails(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create(['price' => 100]);

        $this->enrollmentRepository->method('exists')->willReturn(false);
        $this->userRepository->method('findById')->willReturn($user);
        $this->courseRepository->method('findById')->willReturn($course);

        $paymentGateway = $this->createMock(PaymentGatewayInterface::class);
        $paymentGateway->method('charge')->willReturn(false);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Payment failed. Enrollment not completed.');

        $this->enrollmentService->enrollUser($user->id, $course->id, $paymentGateway);
    }

    public function test_can_update_enrollment_status(): void
    {
        $enrollment = Enrollment::factory()->create(['status' => 'pending']);

        $this->enrollmentRepository->method('findById')->willReturn($enrollment);

        $updated = $this->enrollmentService->updateEnrollmentStatus($enrollment->id, 'success', 'stripe');

        $this->assertEquals('success', $updated->status);
        $this->assertEquals('stripe', $updated->payment_method);
    }

    public function test_can_check_if_user_is_enrolled(): void
    {
        $userId = 1;
        $courseId = 1;

        $this->enrollmentRepository->method('exists')->willReturn(true);

        $result = $this->enrollmentService->isUserEnrolled($userId, $courseId);

        $this->assertTrue($result);
    }

    public function test_can_get_user_enrollment(): void
    {
        $enrollment = Enrollment::factory()->create();

        $this->enrollmentRepository->method('findByUserAndCourse')->willReturn($enrollment);

        $result = $this->enrollmentService->getUserEnrollment($enrollment->user_id, $enrollment->course_id);

        $this->assertInstanceOf(Enrollment::class, $result);
        $this->assertEquals($enrollment->id, $result->id);
    }
}
