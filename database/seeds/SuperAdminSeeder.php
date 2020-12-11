<?php

use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        $user = \App\User::create([
            'firstname' => 'Admin',
            'lastname' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make(123456789),
            'role' => 'CEO',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);

        DB::table('roles')->insert([
            'name' => 'User',
            'slug' => Str::slug('User', '-'),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
            ]);

        DB::table('roles')->insert([
            'name' => 'CEO',
            'slug' => Str::slug('CEO', '-'),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
         ]);
        DB::table('branches')->insert([
            'name' => 'No Branch',
            'slug' => Str::slug('No Branch', '-'),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
         ]);

        DB::table('role_user')->insert([
            'user_id' => $user->id,
            'role_id' => '2',
            ]);

        DB::table('branch_user')->insert([
            'user_id' => $user->id,
            'branch_id' => '1',
            ]);

        DB::table('profiles')->insert([
            'firstname' => 'Admin',
            'lastname' => 'admin',
            'user_id' => $user->id,
        ]);
    }
}
