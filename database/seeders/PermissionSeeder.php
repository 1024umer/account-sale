<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = new Permission();
        $permission->name = 'None';
        $permission->type = 'Master';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'All';
        $permission->type = 'Master';
        $permission->save();
        
        $permission = new Permission();
        $permission->name = 'Accounts';
        $permission->type = 'Module';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'Categories';
        $permission->type = 'Module';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'SubCategories';
        $permission->type = 'Module';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'Sub SubCategories';
        $permission->type = 'Module';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'Tickets';
        $permission->type = 'Module';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'User Tickets';
        $permission->type = 'Module';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'Orders';
        $permission->type = 'Module';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'Manual Orders';
        $permission->type = 'Module';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'Transactions';
        $permission->type = 'Module';
        $permission->save();

        // $permission = new Permission();
        // $permission->name = 'With draw requests';
        // $permission->type = 'Module';
        // $permission->save();

        $permission = new Permission();
        $permission->name = 'Giveaways';
        $permission->type = 'Module';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'Coupon';
        $permission->type = 'Module';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'Volume Discount';
        $permission->type = 'Module';
        $permission->save();
    }
}
