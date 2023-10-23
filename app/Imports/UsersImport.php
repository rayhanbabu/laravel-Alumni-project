<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Admin;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Admin([
              'name'     => $row[0],
              'email'    => $row[1], 
              'mobile'    => $row[2], 
              'admin_name'    => $row[3], 
              'admin_password' => $row[4],
              'role'    => $row[5], 
        ]);
    }
}
