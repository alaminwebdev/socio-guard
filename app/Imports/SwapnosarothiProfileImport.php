<?php

namespace App\Imports;

use Carbon\Carbon;
use App\SwapnosarothiProfile;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class SwapnosarothiProfileImport implements ToModel, WithHeadingRow,WithChunkReading, WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {


        $dob = Date::excelToDateTimeObject(@$row['date_of_birth'])->format('Y-m-d');
        $today = Carbon::now();

        $age = $today->diffInYears($dob);
     
        $eighteenYearsLater = Carbon::parse($dob)->addYears(18);
        $formattedDate = $eighteenYearsLater->toDateString();


        return new SwapnosarothiProfile([
            'profile_id' =>  $row['profile_id'],
            'age' => $age ?? null,
            'age_completion_date' => $formattedDate ?? NULL,
           'employee_zone_id'                     => $row['employee_zone_id'],
           'employee_division_id'                     => $row['employee_division_id'],
           'employee_district_id'                     => $row['employee_district_id'],
           'employee_upazila_id'                     => $row['employee_upazila_id'],
           'employee_union_id'                     => $row['employee_union_id'],
           'village_id'                     => $row['village_id']  ?? NULL,
           'landmark'                     => $row['landmark'],
           'name'                     => $row['name'],
           'total_family_member'                     => $row['total_family_member'],
           'disability_type'                     => $row['disability_type'],
           'date_of_birth'                     => $row['date_of_birth'] ? (Date::excelToDateTimeObject(@$row['date_of_birth'])->format('Y-m-d')) : NULL,
           'division_id'                     => $row['employee_division_id'],
           'district_id'                     => $row['employee_district_id'],
           'upazila_id'                     => $row['employee_upazila_id'],
           'union_id'                     => $row['employee_union_id'],
           'created_at'                     => Carbon::now(),
           'updated_at'                     => Carbon::now(),
           'group_status'                     => 'ongoing',
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
