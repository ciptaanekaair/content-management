<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $produk1 = new Product;
        $produk1->product_category_id = 1;
        $produk1->product_code        = '01AA0001';
        $produk1->product_name        = 'Produk Tester 1';
        $produk1->slug                = 'produk-tester-1';
        $produk1->product_description = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, incididunt ut labore et dolore magna aliqua.';
        $produk1->product_images      = 'product-images/0d98dad3689d87a13bb0fef1e18629e0.jpeg';
        $produk1->product_price       = 29000000;
        $produk1->product_commision   = 10;
        $produk1->product_stock       = 1000;
        $produk1->status              = 1;
        $produk1->save();

        $produk2 = new Product;
        $produk2->product_category_id = 1;
        $produk2->product_code        = '01AA0002';
        $produk2->product_name        = 'Produk Tester 2';
        $produk2->slug                = 'produk-tester-2';
        $produk2->product_description = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, incididunt ut labore et dolore magna aliqua.';
        $produk2->product_images      = 'product-images/4210ca147391331cc27600f77529ae94.jpeg';
        $produk2->product_price       = 360000;
        $produk2->product_commision   = 10;
        $produk2->product_stock       = 100;
        $produk2->status              = 1;
        $produk2->save();

        $produk3 = new Product;
        $produk3->product_category_id = 1;
        $produk3->product_code        = '01BB0001';
        $produk3->product_name        = 'Produk Tester 10';
        $produk3->slug                = 'produk-tester-10';
        $produk3->product_description = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, incididunt ut labore et dolore magna aliqua.';
        $produk3->product_images      = 'product-images/cf682b73be1afad47d0f32559ac34627.jpeg';
        $produk3->product_price       = 2600000;
        $produk3->product_commision   = 10;
        $produk3->product_stock       = 200;
        $produk3->status              = 1;
        $produk3->save();

        $produk4 = new Product;
        $produk4->product_category_id = 1;
        $produk4->product_code        = '01BB0002';
        $produk4->product_name        = 'Produk Tester 11';
        $produk4->slug                = 'produk-tester-11';
        $produk4->product_description = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, incididunt ut labore et dolore magna aliqua.';
        $produk4->product_images      = 'product-images/f26b0d8f252a76f2f99337cced08314b.jpeg';
        $produk4->product_price       = 750000;
        $produk4->product_commision   = 10;
        $produk4->product_stock       = 1000;
        $produk4->status              = 1;
        $produk4->save();

        ProductImage::create([
            'product_id' => 1,
            'images' => 'product-images/image-1.jpg'
        ]);

        ProductImage::create([
            'product_id' => 2,
            'images' => 'product-images/image-1.jpg'
        ]);

        ProductImage::create([
            'product_id' => 3,
            'images' => 'product-images/image-1.jpg'
        ]);

        ProductImage::create([
            'product_id' => 1,
            'images' => 'product-images/image-2.jpg'
        ]);

        ProductImage::create([
            'product_id' => 2,
            'images' => 'product-images/image-2.jpg'
        ]);

        ProductImage::create([
            'product_id' => 3,
            'images' => 'product-images/image-2.jpg'
        ]);

        ProductImage::create([
            'product_id' => 1,
            'images' => 'product-images/image-3.jpg'
        ]);

        ProductImage::create([
            'product_id' => 2,
            'images' => 'product-images/image-3.jpg'
        ]);

        ProductImage::create([
            'product_id' => 3,
            'images' => 'product-images/image-3.jpg'
        ]);

        ProductImage::create([
            'product_id' => 1,
            'images' => 'product-images/image-4.jpg'
        ]);

        ProductImage::create([
            'product_id' => 2,
            'images' => 'product-images/image-4.jpg'
        ]);

        ProductImage::create([
            'product_id' => 3,
            'images' => 'product-images/image-4.jpg'
        ]);
    }
}
