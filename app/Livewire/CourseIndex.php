<?php

namespace App\Livewire;

use App\Repositories\CourseRepositoryInterface;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class CourseIndex extends Component
{
    public function render(CourseRepositoryInterface $courseRepository)
    {
        $courses = $courseRepository->all();

        return view('livewire.course-index', [
            'courses' => $courses
        ]);
    }
}
