<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manager = new Role();
        $manager->name = 'Manager';
        $manager->slug = 'manager';
        $manager->save();

        $developer = new Role();
        $developer->name = 'Client';
        $developer->slug = 'client';
        $developer->save();
    }
}
