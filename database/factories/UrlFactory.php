<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UrlFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        ['scheme' => $scheme, 'host' => $host] = parse_url($this->faker->url());
        $url = $scheme . '://' . $host;

        return [
            'name' => $url,
        ];
    }
}
