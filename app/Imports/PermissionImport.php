<?php

namespace App\Imports;

use Spatie\Permission\Models\Permission;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PermissionImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Check if permission already exists
        $existingPermission = Permission::where('name', $row['name'])
                                        ->where('guard_name', $row['guard_name'])
                                        ->where('group_name', $row['group_name'])
                                        ->first();

        if (!$existingPermission) {
            return new Permission([
                'name' => $row['name'],
                'guard_name' => $row['guard_name'],
                'group_name' => $row['group_name'],
            ]);
        }

        return null; // Skip inserting if it already exists
    }
}
