<?php

namespace App\Livewire\Admin\Course;

use App\Services\CourseService;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = ['search'];

    public function __construct()
    {
        $this->courseService = app(CourseService::class);
    }

    protected CourseService $courseService;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $courses = $this->courseService->getAllCourses($this->search);

        return view('livewire.admin.course.index', [
            'courses' => $courses
        ])->layout('layouts.app');
    }

    public function deleteCourse($id)
    {
        $this->courseService->deleteCourse($id);

        $this->dispatch('show-toast', [
            'message' => 'Course deleted successfully!',
            'type' => 'success'
        ]);
    }
}
