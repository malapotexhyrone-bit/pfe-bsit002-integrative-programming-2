<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departmentNames = [
            'IT',
            'Human Resources',
            'Finance',
            'Marketing',
        ];

        foreach ($departmentNames as $name) {
            $department = Department::firstOrCreate([
                'name' => $name,
            ]);

            Employee::where('department', $name)->update([
                'department_id' => $department->id,
            ]);
        }
    }
}