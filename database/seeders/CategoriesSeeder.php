<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Permission;
use App\Models\SubCategory;
use App\Models\SubSubcategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cat = new Category();
        $cat->name = 'Main Test 1';
        $cat->save();

        $per = new Permission();
        $per->name = $cat->name;
        $per->type = 'Category';
        $per->save();

        $cat = new Category();
        $cat->name = 'Main Test 2';
        $cat->save();

        $per = new Permission();
        $per->name = $cat->name;
        $per->type = 'Category';
        $per->save();

        $cat = new SubCategory();
        $cat->name = 'Sub Test 1';
        $cat->category_id = '1';
        $cat->save();

        $per = new Permission();
        $per->name = $cat->name;
        $per->type = 'Sub Category';
        $per->save();

        $cat = new SubCategory();
        $cat->category_id = '1';
        $cat->name = 'Sub Test 2';
        $cat->save();

        $per = new Permission();
        $per->name = $cat->name;
        $per->type = 'Sub Category';
        $per->save();

        $cat = new SubSubcategory();
        $cat->sub_category_id = '1';
        $cat->name = 'Sub Sub Test 1';
        $cat->save();

        $per = new Permission();
        $per->name = $cat->name;
        $per->type = 'Sub Sub Category';
        $per->save();
        
        $cat = new SubSubcategory();
        $cat->name = 'Sub Sub Test 2';
        $cat->sub_category_id = '1';
        $cat->save();

        $per = new Permission();
        $per->name = $cat->name;
        $per->type = 'Sub Sub Category';
        $per->save();
    }
}
