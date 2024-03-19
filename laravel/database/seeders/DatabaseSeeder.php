<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ProductImages;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\User::factory(20)->create();
         \App\Models\Message::factory(50)->create();
         $products = \App\Models\Product::factory(50)->create();
         $images = \App\Models\Image::factory(150)->create();

         $index = 0;
         foreach ($products as $product) {
             foreach ($images as $inx => $image) {
                 $productImages = new ProductImages();
                 $productImages->product_id = $product->id;
                 $productImages->image_id = $image->id;
                 $productImages->father_id = $father_id;
                 $father_id = $image->id;
                 $index++;
                 if ($index % 3 == 0) {
                     break;
                 }
             }

         }


        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
