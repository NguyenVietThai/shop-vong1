<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('products')->insert([
      'category_id' => 2,
      'description' => 'Quan jean cua nu size XL',
      'name' => 'JeanNuXL',
      'price' => 680000,
    ]);

    DB::table('products')->insert([
      'category_id' => 2,
      'description' => 'Quan jean cua nam size L',
      'name' => 'JeanNamL',
      'price' => 500000,
    ]);
  }
}
