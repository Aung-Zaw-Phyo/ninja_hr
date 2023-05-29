<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class DataEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            // Permission

            $raw_permission_arr = [
                "view_employee",
                "create_employee",
                "edit_employee",
                "delete_employee",
                "view_department",
                "create_department",
                "edit_department",
                "delete_department",
                "view_role",
                "create_role",
                "edit_role",
                "delete_role",
                "view_permission",
                "create_permission",
                "edit_permission",
                "delete_permission",
                "view_attendance",
                "create_attendance",
                "edit_attendance",
                "delete_attendance",
                "view_company_setting",
                "edit_company_setting",
                "view_attendance_overview",
                "view_salary",
                "edit_salary",
                "delete_salary",
                "create_salary",
                "view_payroll",
                "view_project",
                "edit_project",
                "create_project",
                "delete_project"
            ];
    
            if(!Permission::exists()) {
                foreach($raw_permission_arr as $key => $permission){
                    Permission::create(['name' => $permission]);
                }
            }
    
            // Role
            if(!Role::exists()) {
                $role = new Role();
                $role->name = 'HR';
                $role->save();
                $permissions = Permission::all()->pluck('name');
                $role->syncPermissions($permissions);
            }
    
            // User
            if(!User::exists()) {
                $employee = new User();
                $employee->employee_id = 'Ninja-001';
                $employee->name = 'Mr. Hr';
                $employee->email = 'hr@gmail.com';
                $employee->phone = '09123456789';
                $employee->nrc_number = '124578';
                $employee->gender = 'male';
                $employee->birthday = '2000-05-29';
                $employee->department_id = null;
                $employee->date_of_join = '2023-05-29';
                $employee->is_present = true;
                $employee->address = 'Yangon';
                $employee->profile_img = null;
                $employee->pin_code = '111111';
                $employee->password = Hash::make(123456);
                $employee->save();
        
                $employee->syncRoles(['HR']);
            }
    }
}
