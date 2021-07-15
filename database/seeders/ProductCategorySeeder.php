<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductCategory::create([
            'category_name'        => 'Membrane Filter',
            'category_description' => 'Semua produk Membrane Filter dari berbagai macam merk untuk filtrasi air.',
            'keywords'             => 'membrane filter air, membrane filter murah, membrane murah jabodetabek, membrane',
            'description_seo'      => 'Semua produk Membrane Filter dari berbagai macam merk untuk filtrasi air.',
            'category_image'       => 'category-product-images/d88c49ea570c6cd785a45053347dd190.jpg',
            'slug'                 => 'membrane-filter'
        ]);

        ProductCategory::create([
                'category_name'        => 'Cartridge Filter',
                'category_description' => 'Semua produk Cartridge Filter dari berbagai macam merk untuk filtrasi air.',
                'keywords'             => 'cartridge filter air, cartridge filter murah, cartridge murah jabodetabek, cartridge',
                'description_seo'      => 'Semua produk Cartridge Filter dari berbagai macam merk untuk filtrasi air',
                'category_image'       => 'category-product-images/72ec24d04c4af8947b4e3d824e488c78.jpg',
                'slug'                 => 'cartridge-filter'
        ]);

        ProductCategory::create([
                'category_name'        => 'EDI ( Electro Deionization ) Filter',
                'category_description' => 'Semua produk EDI ( Electro Deionization ) dari berbagai macam merk untuk filtrasi air.',
                'keywords'             => 'EDI filter air, EDI filter murah, EDI murah jabodetabek, EDI',
                'description_seo'      => 'Semua produk EDI ( Electro Deionization ) dari berbagai macam merk untuk filtrasi air.',
                'category_image'       => 'category-product-images/142f332c687719c9e98a6581cbe14af4.jpg',
                'slug'                 => 'edi-electro-deionization'
        ]);

        ProductCategory::create([
                'category_name'        => 'Category Tester',
                'category_description' => 'Untuk data dummy untuk category product.',
                'keywords'             => 'Tester filter air, Tester filter murah, Tester murah jabodetabek, Tester',
                'description_seo'      => 'Untuk data dummy untuk category product.',
                'category_image'       => 'category-product-images/9725ecc278e931af29713f4581603764.jpg',
                'slug'                 => 'edi-electro-deionization'
        ]);

    }
}
