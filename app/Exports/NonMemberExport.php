<?php
namespace App\Exports;

use App\Models\Nonmember;

use DB;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NonMemberExport implements FromQuery,WithHeadings
{
    use Exportable;

    public function __construct($admin_name ,int $category_id ,int $payment_status)
    {
        $this->category_id = $category_id;
        $this->admin_name = $admin_name;
        $this->payment_status = $payment_status;
      
    }


    public function headings(): array{
        return [
            'id', 'serial', 'admin_name', 'name', 'email', 'phone', 'category_id', 'profile_image', 'designation', 'amount', 'getway_fee', 'total_amount', 'tran_id', 'payment_status', 'passing_year', 'address', 'payment_type', 'payment_time', 'payment_method', 'payment_date', 'payment_year', 'payment_month', 'payment_day', 'web_link', 'bank_tran', 'problem_status', 'problem_update_time', 'problem_update_by', 'department', 'registration', 'resident', 'gender', 'registration_type', 'created_at', 'updated_at' 
        ];
     }


   
    public function query()
    {
        //return Invoice::query()->where('invoice_year', $this->year);
        return Nonmember::query()->select([
            'id', 'serial', 'admin_name', 'name', 'email', 'phone', 'category_id', 'profile_image', 'designation', 'amount', 'getway_fee', 'total_amount', 'tran_id', 'payment_status', 'passing_year', 'address', 'payment_type', 'payment_time', 'payment_method', 'payment_date', 'payment_year', 'payment_month', 'payment_day', 'web_link', 'bank_tran', 'problem_status', 'problem_update_time', 'problem_update_by', 'department', 'registration', 'resident', 'gender', 'registration_type', 'created_at', 'updated_at' 
            ])
         ->where('category_id', $this->category_id)->where('admin_name', $this->admin_name)
         ->where('payment_status', $this->payment_status);
        //return Invoice::all();
        // $data= DB::table('Invoices')->where('invoice_year', $this->year)->get();
        // return $data;
    }
}