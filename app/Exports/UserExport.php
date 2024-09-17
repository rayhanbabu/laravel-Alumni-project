<?php
namespace App\Exports;

use App\Models\Member;

use DB;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromQuery,WithHeadings
{
    use Exportable;

    public function __construct($admin_name ,int $category_id)
    {
        $this->category_id = $category_id;
        $this->admin_name = $admin_name;
      
    }


    public function headings(): array{
        return [
            'name',
            'email',
            'member_card',
            'serial',
            'category_id',
            'phone',
            'degree_category',
            'gender',
            'blood',
            'country',
            'city',
            'occupation',
            'organization',
            'designation',
            'affiliation',
            'training',
            'expertise',
        ];
     }


   
    public function query()
    {
        //return Invoice::query()->where('invoice_year', $this->year);
        return Member::query()->select([
            'name',
            'email',
            'member_card',
            'serial',
            'category_id',
            'phone',
            'degree_category',
            'gender',
            'blood',
            'country',
            'city',
            'occupation',
            'organization',
            'designation',
            'affiliation',
            'training',
            'expertise',
            ])
        ->where('category_id', $this->category_id)->where('admin_name', $this->admin_name);
        //return Invoice::all();
        // $data= DB::table('Invoices')->where('invoice_year', $this->year)->get();
        // return $data;
    }
}