<?php

namespace App\Imports;

use App\Worker;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WorkersImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        return new Worker([
            'id'     => $row['id'],
            'name'     => $row['name'],
            'city'    => $row['city'],
            'contact'    => $row['contact'],
            'department'    => $row['department'],

            // @foreach ($worker as $row )
            //    <tr>
            //         <td>{{ $loop->iteration }}</td>
            //         <td>{{ $row-> name }}</td>
            //         <td>{{ $row-> city }}</td>
            //         <td>{{ $row-> contact }}</td>
            //         <td>{{ $row-> department }}</td>
            //    </tr>
            // @endforeach
        ]);

    }
}
