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
        //file permissions
        $actions = ['read', 'show', 'create', 'update', 'delete'];
        $models  = ['File']; 

        foreach($models as $model)
        {
            foreach($actions as $action)
            {
                $permissionName = $action . '-' . strtolower($model); // Example: create-file

                $apiRequest = \Http::post('http://127.0.0.1:8000/api/storePermission', [
                    'name'       => $permissionName,
                    'guard_name' => 'api',
                ]);
            
                if ($apiRequest->failed())
                {
                    dump('Request Failed', $apiRequest->body());
                    return;
                }
                
            }
        }
    }
}
