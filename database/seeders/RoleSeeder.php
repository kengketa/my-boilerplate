<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::factory()->create([
            'name' => 'admin'
        ]);
        Role::factory()->create([
            'name' => 'manager'
        ]);
        Role::factory()->create([
            'name' => 'user'
        ]);

        $roles = Role::all();
        foreach ($roles as $role) {
            $role->addMedia(storage_path('seed/role-image.jpg'))->preservingOriginal()
                ->toMediaCollection(Role::MEDIA_COLLECTION_IMAGE);
        }
    }
}
