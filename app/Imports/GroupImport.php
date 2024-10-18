<?php

namespace App\Imports;

use App\Models\Group;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class GroupImport implements ToCollection
{
   /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

     public function collection(Collection $collection)
     {
         $index = 1;

         foreach ($collection as $row) {
             if ($index > 1) {
                 $data['farmer_group'] = $row[1];  // Sesuaikan indeks sesuai kolom di Excel
                 $data['chairman'] = $row[2];
                 $data['address'] = $row[3];
                 $data['link_foto_1'] = $row[4];
                 $data['link_foto_2'] = $row[5];

                 Group::create($data);
             }

             $index++;
         }
     }
}
