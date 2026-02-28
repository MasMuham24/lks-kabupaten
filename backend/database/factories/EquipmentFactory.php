<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EquipmentFactory extends Factory
{
    public function definition(): array
    {
        $categories = [
            'Technology' => ['Laptop Gaming', 'Mechanical Keyboard', 'Monitor 4K', 'Mouse Wireless', 'Router WiFi 6'],
            'Camera' => ['Sony A7 III', 'Canon EOS R5', 'Fujifilm X-T4', 'Lensa 50mm f1.8', 'Tripod Carbon'],
            'Drone' => ['DJI Mavic Air', 'DJI Mini 3 Pro', 'FPV Drone', 'Autel Robotics'],
            'Camping' => ['Tenda Arpenaz', 'Carrier 60L', 'Sleeping Bag', 'Kompor Portable', 'Matras Angin']
        ];

        $type = $this->faker->randomElement(array_keys($categories));
        $name = $this->faker->randomElement($categories[$type]);

        $keyword = match($type) {
            'Technology' => 'computer,laptop',
            'Camera' => 'camera,dslr',
            'Drone' => 'drone',
            'Camping' => 'tent,camping',
            default => 'gadget'
        };

        return [
            'name' => $name . ' ' . $this->faker->bothify('##??'),
            'type' => $type,
            'description' => $this->faker->paragraph(2),
            'price_per_day' => $this->faker->numberBetween(25000, 750000),
            'stock' => $this->faker->numberBetween(0, 10),
            'image' => "https://loremflickr.com/640/480/$keyword?lock=" . $this->faker->unique()->randomNumber(),
        ];
    }
}
