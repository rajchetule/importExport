<?php

namespace App\Exports;

use App\Worker;
use Maatwebsite\Excel\Concerns\FromCollection;

class WorkersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Worker::select('id','name','city','contact','department')->get();
    }

    public function headings(): array
    {
        return[
            'Name',
            'City',
            'Contact',
            'Department',
        ];
    }
}
