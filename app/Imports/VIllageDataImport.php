<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Model\Admin\Setup\Village;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class VIllageDataImport implements ToModel, WithHeadingRow,WithChunkReading, WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);

        return new Village([
           'division_id'                     => $row['division_id'],
           'district_id'                     => $row['district_id'],
           'upazila_id'                     => $row['upazila_id'],
           'union_id'                     => $row['union_id'],
           'name'                     => $row['name'],
           'created_by'                     => Auth::id(),
           'created_at'                     => Carbon::now(),
           'updated_at'                     => Carbon::now(),
        ]);

    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
