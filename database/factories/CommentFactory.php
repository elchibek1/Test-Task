<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'text' => $this->faker->paragraph(),
            'picture' => $this->getImage(rand(1,3)),
            'user_id' => rand(1,3),
            'post_id' => rand(1,5)
        ];
    }

    private function getImage($image_number = 1): string
    {
        $path = storage_path() . "/seed_pictures/comments/" . $image_number . ".jpg";
        $image_name = md5($path) . '.jpg';
        $resize = Image::make($path)->fit(300)->encode('jpg');
        Storage::disk('public')->put('pictures/comments/'.$image_name, $resize->__toString());
        return 'pictures/comments/'.$image_name;
    }
}
