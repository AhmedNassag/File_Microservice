<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $actions = ['read', 'create', 'show', 'update', 'delete'];
        $models  = ['file']; 

        foreach($models as $model)
        {
            foreach($actions as $action)
            {
                $permissionName     = $action . '-' . strtolower($model); // Example: create-file
                $existingPermission = Permission::where('name',$permissionName)->where('guard_name', 'api')->exists();
                if(!$existingPermission)
                {
                    Permission::create([
                        'name'       => $permissionName,
                        'guard_name' => 'api',
                    ]);
                }
            }
        }
    }
}
