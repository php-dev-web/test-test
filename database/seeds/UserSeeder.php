<?php

use App\Role;
use App\User;
use App\Permission;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manager = Role::where('slug', 'manager')->first();
        $client = Role::where('slug','client')->first();
        $createTasks = Permission::where('slug','create-tasks')->first();
        $manageTasks = Permission::where('slug','manage-tasks')->first();

        $user1 = new User();
        $user1->name = 'Ivan ivanov';
        $user1->email = 'ivan@ivan.ru';
        $user1->password = bcrypt('12345678');
        $user1->save();
        $user1->roles()->attach($manager);
        $user1->permissions()->attach($manageTasks);


        $user2 = new User();
        $user2->name = 'Oleg oleg';
        $user2->email = 'oleg@oleg.ru';
        $user2->password = bcrypt('12345678');
        $user2->save();
        $user2->roles()->attach($client);
        $user2->permissions()->attach($createTasks);
    }
}
