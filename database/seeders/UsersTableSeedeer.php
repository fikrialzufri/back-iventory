<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UsersTableSeedeer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = new Role();
        $superadmin->name = 'Superadmin';
        $superadmin->slug = 'superadmin';
        $superadmin->save();

        $adminRole = new Role();
        $adminRole->name = 'Admin';
        $adminRole->slug = 'admin';
        $adminRole->save();

        $kasirRole = new Role();
        $kasirRole->name = 'Kasir';
        $kasirRole->slug = 'kasir';
        $kasirRole->save();

        $superadmin = Role::where('slug', 'superadmin')->first();
        $adminRole = Role::where('slug', 'admin')->first();
        $adminKasir = Role::where('slug', 'kasir')->first();

        $superadminUser = new User();
        $superadminUser->name = 'Superadmin';
        $superadminUser->username = 'Superadmin';
        $superadminUser->slug = Str::slug('Superadmin');
        $superadminUser->email = 'Superadmin@admin.com';
        $superadminUser->password = bcrypt('secret');
        // $superadminUser->icon = 'default-icon.png';
        $superadminUser->save();

        $superadminUser->role()->attach($superadmin);

        $kasirUser = new User();
        $kasirUser->name = 'kasir';
        $kasirUser->username = 'kasir';
        $kasirUser->slug = Str::slug('kasir');
        $kasirUser->email = 'kasir@admin.com';
        $kasirUser->password = bcrypt('secret');
        // $kasirUser->icon = 'default-icon.png';
        $kasirUser->save();

        $kasirUser->role()->attach($adminKasir);

        $admin = new User();
        $admin->name = 'admin';
        $admin->username = 'admin';
        $admin->slug = Str::slug('admin');
        $admin->email = 'admin@admin.com';
        $admin->password = bcrypt('secret');
        // $admin->icon = 'default-icon.png';
        $admin->save();
        $admin->role()->attach($adminRole);

        $taskUser = new Task();
        $taskUser->name = 'User';
        $taskUser->slug = Str::slug($taskUser->name);
        $taskUser->description = 'Manajemen User';
        $taskUser->save();

        $taskRole = new Task();
        $taskRole->name = 'Roles';
        $taskRole->slug = Str::slug($taskRole->name);
        $taskRole->description = 'Manajemen Hak Akses ';
        $taskRole->save();

        $taskSatuan = new Task();
        $taskSatuan->name = 'Satuan';
        $taskSatuan->slug = Str::slug($taskSatuan->name);
        $taskSatuan->description = 'Manajemen Satuan';
        $taskSatuan->save();

        $taskJenis = new Task();
        $taskJenis->name = 'Jenis';
        $taskJenis->slug = Str::slug($taskJenis->name);
        $taskJenis->description = 'Manajemen Jenis';
        $taskJenis->save();

        $taskKategori = new Task();
        $taskKategori->name = 'Kategori';
        $taskKategori->slug = Str::slug($taskKategori->name);
        $taskKategori->description = 'Manajemen Kategori';
        $taskKategori->save();

        $taskProduk = new Task();
        $taskProduk->name = 'Produk';
        $taskProduk->slug = Str::slug($taskProduk->name);
        $taskProduk->description = 'Manajemen Produk';
        $taskProduk->save();

        $tasks = Task::all();

        foreach ($tasks as $task) {
            $name = $task->name;
            $slug = Str::slug($name);
            $data = array(

                [
                    'name'    => 'View ' . $name,
                    'slug'    => 'view-' . $slug,
                    'task_id' => $task->id
                ],
                [
                    'name'    => 'Create ' . $name,
                    'slug'    => 'create-' . $slug,
                    'task_id' => $task->id
                ],
                [
                    'name'    => 'Edit ' . $name,
                    'slug'    => 'edit-' . $slug,
                    'task_id' => $task->id
                ],
                [
                    'name'    => 'Delete ' . $name,
                    'slug'    => 'delete-' . $slug,
                    'task_id' => $task->id
                ],
            );

            foreach ($data as $induk) {
                $Permission = Permission::Create($induk);
                $adminRole->permissions()->attach($Permission->id);
            }
        }
    }
}
