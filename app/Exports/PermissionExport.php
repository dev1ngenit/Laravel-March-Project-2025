<?php

namespace App\Exports;

use Spatie\Permission\Models\Permission;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PermissionExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */



    // public function collection()
    // {
    //     return Officer::all();
    // }

    public function collection()
    {
        return Permission::select("name", "guard_name", "group_name")->get();
    }

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function headings(): array
    {
        return [
            "Name",
            "Guard Name",
            "Group Name",
        ];
    }


}
