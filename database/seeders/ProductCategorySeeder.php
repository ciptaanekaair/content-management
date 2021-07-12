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
            'category_image'       => 'product_picture/7c0beccc00051977914e1814e12b816f.png',
            'slug'                 => 'membrane-filter'
        ]);

        ProductCategory::create([
                'category_name'        => 'Cartridge Filter',
                'category_description' => 'Semua produk Cartridge Filter dari berbagai macam merk untuk filtrasi air.',
                'keywords'             => 'cartridge filter air, cartridge filter murah, cartridge murah jabodetabek, cartridge',
                'description_seo'      => 'Semua produk Cartridge Filter dari berbagai macam merk untuk filtrasi air',
                'category_image'       => 'product_picture/9fb1d9d0e777ef433fba9ac034a48373.png',
                'slug'                 => 'cartridge-filter'
        ]);

        ProductCategory::create([
                'category_name'        => 'EDI ( Electro Deionization ) Filter',
                'category_description' => 'Semua produk EDI ( Electro Deionization ) dari berbagai macam merk untuk filtrasi air.',
                'keywords'             => 'EDI filter air, EDI filter murah, EDI murah jabodetabek, EDI',
                'description_seo'      => 'Semua produk EDI ( Electro Deionization ) dari berbagai macam merk untuk filtrasi air.',
                'category_image'       => 'product_picture/267a0c54f684bc5b3a88237a183c9371.png',
                'slug'                 => 'edi-electro-deionization'
        ]);

        ProductCategory::create([
                'category_name'        => 'Category Tester',
                'category_description' => 'Untuk data dummy untuk category product.',
                'keywords'             => 'Tester filter air, Tester filter murah, Tester murah jabodetabek, Tester',
                'description_seo'      => 'Untuk data dummy untuk category product.',
                'category_image'       => 'product_picture/267a0c54f684bc5b3a88237a183c9371.png',
                'slug'                 => 'edi-electro-deionization'
        ]);

    }
}
