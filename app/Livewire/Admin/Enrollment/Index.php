<?php

namespace App\Livewire\Admin\Enrollment;

use App\Services\EnrollmentService;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected EnrollmentService $enrollmentService;

    public $search = '';

    protected $queryString = ['search'];

    public function __construct()
    {
        $this->enrollmentService = app(EnrollmentService::class);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $enrollments = $this->enrollmentService->getAllEnrollments($this->search);

        return view('livewire.admin.enrollment.index', [
            'enrollments' => $enrollments
        ])->layout('layouts.app');
    }

    public function confirmPayment($id)
    {
        $this->enrollmentService->confirmPayment($id);

        $this->dispatch('show-toast', [
            'message' => 'Payment confirmed successfully!',
            'type' => 'success'
        ]);
    }

    public function cancelEnrollment($id)
    {
        $this->enrollmentService->cancelEnrollment($id);

        $this->dispatch('show-toast', [
            'message' => 'Enrollment canceled successfully!',
            'type' => 'success'
        ]);
    }
}
