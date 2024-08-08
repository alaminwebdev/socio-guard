<?php

namespace App\Imports;

use App\Model\Admin\Incident\SurvivorIncidentInformation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SurvivorImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);

        return new SurvivorIncidentInformation([
           'created_at'                     => $row['created_at'],
           'employee_name'                  => $row['employee_name'],
           'employee_designation'           => $row['employee_designation'],
           'employee_pin'                   => $row['employee_pin'],
           'employee_mobile_number'         => $row['employee_mobile_number'],
           'employee_division_id'           => $row['employee_division_id'],
           'employee_district_id'           => $row['employee_district_id'],
           'provider_name'                  => $row['provider_name'],
           'provider_mobile_no'             => $row['provider_mobile_no'],
           'provider_organization_name_id'  => $row['provider_organization_name_id'],
           'provider_gender_id'             => $row['provider_gender_id'],
           'provider_relationship_id'       => $row['provider_relationship_id'],
           'provider_source_id'             => $row['provider_source_id'],
           'violence_category_id'           => $row['violence_category_id'],
           'violence_date'                  => $row['violence_date'],
           'violence_time'                  => $row['violence_time'],
           'violence_place_id'              => $row['violence_place_id'],
           'violence_reason_id'             => $row['violence_reason_id'],
           'survivor_name'                  => $row['survivor_name'],
           'survivor_mobile_no'             => $row['survivor_mobile_no'],
           'survivor_religion_id'           => $row['survivor_religion_id'],
           'survivor_mother_name'           => $row['survivor_mother_name'],
           'survivor_father_name'           => $row['survivor_father_name'],
           'survivor_marital_status_id'     => $row['survivor_marital_status_id'],
           'survivor_age'                   => $row['survivor_age'],
           'survivor_monthly_income'        => $row['survivor_monthly_income'],
           'survivor_occupation_id'         => $row['survivor_occupation_id'],
           'survivor_husband_name'          => $row['survivor_husband_name'],
           'survivor_gender_id'             => $row['survivor_gender_id'],
           'survivor_organization_type_id'  => $row['survivor_organization_type_id'],
           'survivor_nid'                   => $row['survivor_nid'],
           'survivor_incident_place_id'     => $row['survivor_incident_place_id'],
           'survivor_village'               => $row['survivor_village'],
           'survivor_upazila_id'            => $row['survivor_upazila_id'],
           'survivor_district_id'           => $row['survivor_district_id'],
           'survivor_autistic_id'           => $row['survivor_autistic_id'],
           'survivor_nid'                   => $row['survivor_nid'],
           // 'survivor_birth_registration_no' => $row['survivor_birth_registration_no'],
           'perpetrator_name'               => $row['perpetrator_name'],
           'perpetrator_marital_status_id'  => $row['perpetrator_marital_status_id'],
           'perpetrator_district_id'        => $row['perpetrator_district_id'],
           'perpetrator_occupation_id'      => $row['perpetrator_occupation_id'],
           'perpetrator_age'                => $row['perpetrator_age'],
           'perpetrator_gender_id'          => $row['perpetrator_gender_id'],
           'perpetrator_place_id'           => $row['perpetrator_place_id'],
           'perpetrator_relationship_id'    => $row['perpetrator_relationship_id'],
           'perpetrator_others_relationship'=> $row['perpetrator_others_relationship'],
           'case_status'                    => $row['case_status'],
           'thana_name'                     => $row['thana_name'],
           'court_name'                     => $row['court_name'],
           'not_filing_reason'              => $row['not_filing_reason'],
           'survivor_situation_id'          => $row['survivor_situation_id'],
           'survivor_place_id'              => $row['survivor_place_id'],
           'survivor_initial_support_id'    => $row['survivor_initial_support_id']
        ]);

    }
}
