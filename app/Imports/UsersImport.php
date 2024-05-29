<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Member;
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
        return new Member([
              'batch_id'=> $row[0], 
              'member_card'=>$row[1],
              'serial'=>$row[2], 
              'admin_name'=>$row[3], 
              'category_id'=>$row[4], 
              'name'=> $row[5], 
              'phone'=> $row[6], 
              'email'=> $row[7], 
              'member_password'=> $row[8], 
              'village '=> $row[9], 
        ]);
    }
}
