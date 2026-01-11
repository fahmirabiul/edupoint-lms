<?php

namespace App\Livewire\Admin\Course;

use App\Services\CourseService;
use Livewire\Component;
use Livewire\Attributes\Validate;

class Edit extends Component
{
    protected CourseService $courseService;

    public $courseId;

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

    public function mount($id)
    {
        $course = $this->courseService->findCourseById($id);

        $this->courseId = $course->id;
        $this->title = $course->title;
        $this->slug = $course->slug;
        $this->description = $course->description;
        $this->price = $course->price;
    }

    public function update()
    {
        $validated = $this->validate();

        $this->courseService->updateCourse($this->courseId, $validated);

        session()->flash('message', 'Course updated successfully!');

        return redirect()->route('admin.courses.index');
    }

    public function render()
    {
        return view('livewire.admin.course.edit')->layout('layouts.app');
    }
}
