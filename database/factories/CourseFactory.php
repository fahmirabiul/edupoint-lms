<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->randomElement([
            'Laravel Pro',
            'Mastering SOLID Principles',
            'Vue.js Complete Guide',
            'React for Beginners',
            'PHP Advanced Techniques',
            'Database Design Mastery',
            'API Development with Laravel',
            'Modern JavaScript ES6+',
            'TailwindCSS Essentials',
            'Docker for Developers'
        ]);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => fake()->paragraph(3),
            'price' => fake()->randomElement([0, 99000, 149000, 199000, 299000, 499000]),
        ];
    }
}
