<?php
namespace App\Exports;
use App\Models\Duevent;

use DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DuClubEventExport implements FromQuery,WithHeadings
{
    use Exportable;

    public function __construct(int $year)
    {
        $this->year = $year;
    }


    public function headings(): array{
        return [
              'id','invite','year','name','phone','dept','designation'
         ];
     }


   
     public function query()
     {
         return Duevent::query()
             ->leftJoin('duclubs', 'duclubs.id', '=', 'duevents.duclub_id')
             ->select([
                 'duclubs.id as ID',
                 'duevents.invite as Invite',
                 'duevents.year as Year',
                 'duclubs.name as Name',
                 'duclubs.phone as Phone',
                 'duclubs.dept as Dept',
                 'duclubs.designation as Designation'
             ])
             ->where('duevents.year', $this->year);
     }
}