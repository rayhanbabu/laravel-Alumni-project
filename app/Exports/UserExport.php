<?php
namespace App\Exports;

use App\Models\Admin;

use DB;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserExport implements FromQuery
{
    use Exportable;

    public function __construct(int $status)
    {
        $this->status = $status;
      
    }

    

    public function query()
    {
        //return Invoice::query()->where('invoice_year', $this->year);
        return Admin::query()->select(['name','email','mobile','admin_name','admin_password','role'])->where('status', $this->status);
        //return Invoice::all();
       // $data= DB::table('Invoices')->where('invoice_year', $this->year)->get();
       // return $data;
    }
}