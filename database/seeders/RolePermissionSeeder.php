<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $superAdminRole= Admin::createRole('Super Admin');       

        $permissionGroups=[
            'dashboard' =>  [
                'dashboard.view'
            ],
            'category'  =>  [
                'category.view',
                'category.create',
                'category.edit',
                'category.delete',
            ],
            'subcategory'  =>  [
                'subcategory.view',
                'subcategory.create',
                'subcategory.edit',
                'subcategory.delete',
            ],
            'admin'  =>  [
                'admin.view',
                'admin.create',
                'admin.edit',
                'admin.delete',
            ],
            'role'  =>  [
                'role.view',
                'role.create',
                'role.edit',
                'role.delete',
            ]                                      
            ];

            foreach($permissionGroups as $groupKey => $permissons){

                foreach($permissons as $permissionName){

                    $permission = Permission::create([
                        'guard_name' => 'admin',
                        'group_name' => $groupKey,
                        'name'       => $permissionName    
                    ]);

                    $superAdminRole->givePermissionTo($permission);
                    $permission->assignRole($superAdminRole);


                }


            }



        
    }
}
