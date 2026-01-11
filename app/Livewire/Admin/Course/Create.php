<?php

namespace App\Livewire\Admin\Course;

use App\Services\CourseService;
use Livewire\Component;
use Livewire\Attributes\Validate;

class Create extends Component
{
    protected CourseService $courseService;

    #[Validate('required|string|max:255')]
    public $title = '';

    #[Validate('required|string|max:100')]
    public $slug = '';

    #[Validate('nullable|string')]
    public $description = '';

    #[Validate('required|numeric|min:0')]
    public $price = '';

    public function __construct()
    {
        $this->courseService = app(CourseService::class);
    }

    public function store()
    {
        $validated = $this->validate();

        $this->courseService->createCourse($validated);

        session()->flash('message', 'Course created successfully!');

        return redirect()->route('admin.courses.index');
    }

    public function render()
    {
        return view('livewire.admin.course.create')->layout('layouts.app');
    }
}
