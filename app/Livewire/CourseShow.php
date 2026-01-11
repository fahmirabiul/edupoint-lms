<?php

namespace App\Livewire;

use App\Models\Course;
use App\Services\EnrollmentService;
use App\Services\Payments\MidtransPayment;
use App\Services\Payments\ManualTransferPayment;
use App\Repositories\CourseRepositoryInterface;
use App\Factories\PaymentFactory;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Exception;

#[Layout('layouts.app')]
class CourseShow extends Component
{
    public $course;
    public $isEnrolled = false;
    public $paymentMethod = 'manual';

    public function mount(string $slug, CourseRepositoryInterface $courseRepository, EnrollmentService $enrollmentService)
    {
        $this->course = $courseRepository->findBySlug($slug);
        $this->isEnrolled = $enrollmentService->isUserEnrolled(auth()->id(), $this->course->id);
    }

    public function enroll(EnrollmentService $service)
    {
        try {
            $gateway = PaymentFactory::make($this->paymentMethod);
            $service->enrollUser(auth()->id(), $this->course->id, $gateway);

            // PERBAIKAN: Pastikan event name konsisten
            $this->dispatch(
                'show-toast',
                title: 'Enrollment Success!',
                message: 'Your enrollment has been submitted and is being processed in the background.'
            );

            $this->isEnrolled = true;
        } catch (Exception $e) {
            $this->dispatch(
                'show-toast',
                title: 'Enrollment Failed',
                message: $e->getMessage()
            );
        }
    }

    public function render()
    {
        return view('livewire.course-show');
    }
}
