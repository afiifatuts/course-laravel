<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Seeder yang akan dibuat 
        //1. beberapa role
        //2. user untuk super admin

        $ownerRole = Role::create([
            'name'=>'owner'
        ]);
        
        $studentRole = Role::create([
            'name'=>'student'
        ]);

        $teacherRole = Role::create([
            'name'=>'teacher'
        ]);

        //Akun admin untuk mengelola data diawal
        //seperti kategori, kelas, dan teacher
        $userOwner = User::create([
            'name'=>'Afiifatuts',
            'occupation'=>'Educator',
            'avatar'=>'images/default-avatar.png',
            'email'=>'afiifatuts04@gmail.com',
            'password'=>bcrypt('123456789'),
        ]);

        $userOwner->assignRole($ownerRole);
    }
}
