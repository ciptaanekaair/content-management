<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'product_category_id' => '1',
            'product_code'        => '01AA0001',
            'product_name'        => 'Produk Tester 1',
            'slug'                => 'produk-tester-1',
            'product_description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do iusmod tempor incididunt ut labore et dolore magna aliqua.',
            'product_images'      => 'product-images/0d98dad3689d87a13bb0fef1e18629e0.jpg',
            'product_price'       => '29000000',
            'product_commision'   => '10',
            'product_stock'       => 999,
            'status'              => 1
        ]);
        Product::create([
            'product_category_id' => '1',
            'product_code'        => '01AA0002',
            'product_name'        => 'Produk Tester 2',
            'slug'                => 'produk-tester-2',
            'product_description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do iusmod tempor incididunt ut labore et dolore magna aliqua.',
            'product_images'      => 'product-images/4210ca147391331cc27600f77529ae94.jpg',
            'product_price'       => '36000000',
            'product_commision'   => '10',
            'product_stock'       => 100,
            'status'              => 1
        ]);
        Product::create([
            'product_category_id' => '2',
            'product_code'        => '01BB0001',
            'product_name'        => 'Produk Tester 10',
            'slug'                => 'produk-tester-10',
            'product_description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do iusmod tempor incididunt ut labore et dolore magna aliqua.',
            'product_images'      => 'product-images/cf682b73be1afad47d0f32559ac34627.jpg',
            'product_price'       => '26000000',
            'product_commision'   => '10',
            'product_stock'       => 200,
            'status'              => 1
        ]);
    }
}
