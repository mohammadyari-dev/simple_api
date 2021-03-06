<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id'       => User::where('admin', 'true')->get()->random()->id,
            'title'         => $this->faker->word(),
            'slug'          => $this->faker->slug(),
            'content'       => $this->faker->text()
        ];
    }
}
