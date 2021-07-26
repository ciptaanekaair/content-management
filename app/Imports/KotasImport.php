<?php

namespace App\Imports;

use App\Models\Kota;
use Maatwebsite\Excel\Concerns\ToModel;

class KotasImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Kota([
            'provinsi_id' => $row[0],
            'nama_kota'   => $row[1],
            'status'      => 1
        ]);
    }
}
