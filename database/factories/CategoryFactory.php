<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title'         => $this->faker->word(),
            'slug'         => $this->faker->slug(),
            'content'       => $this->faker->text()
        ];
    }
}
