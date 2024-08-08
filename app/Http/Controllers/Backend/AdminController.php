<?php

namespace App\Http\Controllers\Backend;

use App\User;
use Carbon\Carbon;
use App\Model\Education;
use Illuminate\Http\Request;
use App\Model\SelpIncidentModel;
use App\Model\PollisomajDataModel;
use Illuminate\Support\Facades\DB;
use App\Model\Admin\Setup\Division;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\Admin\Setup\Occupation;
use App\Model\Admin\Setup\FamilyMember;
use App\Model\Admin\Setup\MaritalStatus;
use App\Model\Admin\Setup\ViolenceReason;
use App\Model\SurvivorDirectServiceModel;
use App\Model\Admin\Setup\PerpetratorPlace;
use App\Model\Admin\Setup\ViolenceCategory;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\SurvivorSituation;
use App\Model\Admin\Setup\SurvivorRelationship;
use App\Model\Admin\Setup\LegelInitiativeReason;
use App\Model\Admin\Setup\SurvivorViolencePlace;
use App\Model\Admin\Incident\SurvivorBracSupport;
use App\Model\Admin\Setup\CEP_Region\RegionAreaDetail;
use App\Model\Admin\Setup\SurvivorAutisticInformation;
use App\Model\Admin\Incident\SurvivorIncidentInformation;
use App\Model\Admin\Incident\SurvivorOtherOrganizationSupport;

class AdminController extends Controller {
    public function dashboardTwo() {
        return view('backend.testdashboard');
    }
    public function newDashboard() {
        $user_region   = session()->get('userareaaccess.sregions');
        $user_division = session()->get('userareaaccess.sdivisions');
        $user_district = session()->get('userareaaccess.sdistricts');
        $user_upazila  = session()->get('userareaaccess.supazilas');


        $data['divisions']           = Division::all();
        $data['regions']             = Region::where('status', '1')->get();
        $data['violence_categories'] = ViolenceCategory::where('status', '1')->get();
        $data['auth_user']           = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        // dd(session()->get('userareaaccess.sregions'));

        $firstDate         = SelpIncidentModel::select('posting_date')->whereNotNull('posting_date')->orderBy('posting_date', 'asc')->first();
        $lastDate          = SelpIncidentModel::select('posting_date')->whereNotNull('posting_date')->orderBy('posting_date', 'desc')->first();
        $data['firstYear'] = date('Y', strtotime($firstDate->posting_date));
        $data['lastDate']  = date('Y', strtotime($lastDate->posting_date));

        // if (count(session()->get('userareaaccess.sregions')) > 0) {

        $data['allIncidentData'] = SelpIncidentModel::when($user_region, function ($query, $user_region) {
            if (count($user_region) > 0) {
                $query->whereIn('employee_zone_id', $user_region);
            }
        })
            ->when($user_division, function ($query, $user_division) {
                if (count($user_division) > 0) {
                    $query->whereIn('employee_division_id', $user_division);
                }
            })
            ->when($user_district, function ($query, $user_district) {
                if (count($user_district) > 0) {
                    $query->whereIn('employee_district_id', $user_district);
                }
            })
            ->when($user_upazila, function ($query, $user_upazila) {
                if (count($user_upazila) > 0) {
                    $query->whereIn('employee_upazila_id', $user_upazila);
                }
            })
            ->where('posting_date', '>=', date("Y-m-d", strtotime("2021-10-01")))
            ->where('posting_date', '<=', Carbon::now())
            ->where('status', 2)
            ->count();
        //     ->limit(100)
        //     ->get();

        // count total femail incident
        $data['allFemaleIncidentData'] = SelpIncidentModel::when($user_region, function ($query, $user_region) {
            if (count($user_region) > 0) {
                $query->whereIn('employee_zone_id', $user_region);
            }
        })
            ->when($user_division, function ($query, $user_division) {
                if (count($user_division) > 0) {
                    $query->whereIn('employee_division_id', $user_division);
                }
            })
            ->when($user_district, function ($query, $user_district) {
                if (count($user_district) > 0) {
                    $query->whereIn('employee_district_id', $user_district);
                }
            })
            ->when($user_upazila, function ($query, $user_upazila) {
                if (count($user_upazila) > 0) {
                    $query->whereIn('employee_upazila_id', $user_upazila);
                }
            })
            ->where('posting_date', '>=', date("Y-m-d", strtotime("2021-10-01")))
            ->where('posting_date', '<=', Carbon::now())
            ->where('survivor_gender_id', 2)
            ->where('status', 2)
            ->count();

        //Complaints resolved  through ADR
        $data['throughADR'] = SurvivorDirectServiceModel::whereHas('selpincident', function ($query) use ($user_region, $user_division, $user_district, $user_upazila) {
            $query->when($user_region, function ($query, $user_region) {
                if (count($user_region) > 0) {
                    $query->whereIn('employee_zone_id', $user_region);
                }
            })
                ->when($user_division, function ($query, $user_division) {
                    if (count($user_division) > 0) {
                        $query->whereIn('employee_division_id', $user_division);
                    }
                })
                ->when($user_district, function ($query, $user_district) {
                    if (count($user_district) > 0) {
                        $query->whereIn('employee_district_id', $user_district);
                    }
                })
                ->when($user_upazila, function ($query, $user_upazila) {
                    if (count($user_upazila) > 0) {
                        $query->whereIn('employee_upazila_id', $user_upazila);
                    }
                })
                ->where('status', 2);
        })
            ->whereIn('alternative_dispute_resolution_id', [7, 9])
            ->where('closing_date', '>=', date("Y-m-d", strtotime("2021-10-01")))
            ->where('closing_date', '<=', Carbon::now())
            ->distinct('selp_incident_information_id')
            ->count();

        $data['childMarriageReported'] = PollisomajDataModel::when($user_region, function ($query, $user_region) {
            if (count($user_region) > 0) {
                $query->whereIn('zone_id', $user_region);
            }
        })
            ->when($user_division, function ($query, $user_division) {
                if (count($user_division) > 0) {
                    $query->whereIn('division_id', $user_division);
                }
            })
            ->when($user_district, function ($query, $user_district) {
                if (count($user_district) > 0) {
                    $query->whereIn('district_id', $user_district);
                }
            })
            ->when($user_upazila, function ($query, $user_upazila) {
                if (count($user_upazila) > 0) {
                    $query->whereIn('upazilla_id', $user_upazila);
                }
            })
            ->where('flag', 2)
            ->where('created_at', '>=', date("Y-m-d", strtotime("2021-10-01")))
            ->where('created_at', '<=', Carbon::now())
            ->sum('number_of_child_marriage');

        $moneyADR = SurvivorDirectServiceModel::whereHas('selpincident', function ($query) use ($user_region, $user_division, $user_district, $user_upazila) {
            $query->when($user_region, function ($query, $user_region) {
                if (count($user_region) > 0) {
                    $query->whereIn('employee_zone_id', $user_region);
                }
            })
                ->when($user_division, function ($query, $user_division) {
                    if (count($user_division) > 0) {
                        $query->whereIn('employee_division_id', $user_division);
                    }
                })
                ->when($user_district, function ($query, $user_district) {
                    if (count($user_district) > 0) {
                        $query->whereIn('employee_district_id', $user_district);
                    }
                })
                ->when($user_upazila, function ($query, $user_upazila) {
                    if (count($user_upazila) > 0) {
                        $query->whereIn('employee_upazila_id', $user_upazila);
                    }
                })
                ->where('status', 2);
        })->whereIn('alternative_dispute_resolution_id', [7, 9, 11])
            ->whereNotNull('amount_of_money_received')
            ->where('closing_date', '>=', date("Y-m-d", strtotime("2021-10-01")))
            ->where('closing_date', '<=', Carbon::now())
            //->groupBy('selp_incident_information_id')
            ->get();

            $data['moneyADR'] =  $moneyADR->sum('amount_of_money_received');
       

        $get = PollisomajDataModel::when($user_region, function ($query, $user_region) {
            if (count($user_region) > 0) {
                $query->whereIn('zone_id', $user_region);
            }
        })
            ->when($user_division, function ($query, $user_division) {
                if (count($user_division) > 0) {
                    $query->whereIn('division_id', $user_division);
                }
            })
            ->when($user_district, function ($query, $user_district) {
                if (count($user_district) > 0) {
                    $query->whereIn('district_id', $user_district);
                }
            })
            ->when($user_upazila, function ($query, $user_upazila) {
                if (count($user_upazila) > 0) {
                    $query->whereIn('upazilla_id', $user_upazila);
                }
            })
            ->select(DB::raw('
                    SUM(contacted_up_within_ps_member) as one,
                    SUM(contacted_up_beyond_ps_member) as two,
                    SUM(contacted_local_within_ps_member) as three,
                    SUM(contacted_local_beyond_ps_member) as four,
                    SUM(family_consultation_within_ps_member) as five,
                    SUM(family_consultation_beyond_ps_member) as six,
                    SUM(contacted_upazila_within_ps_member) as seven,
                    SUM(contacted_upazila_beyond_ps_member) as eight,
                    SUM(hotline_number_within_ps_member) as nine,
                    SUM(hotline_number_beyond_ps_member) as ten
                    '))
            ->where('flag', 2)
            ->where('created_at', '>=', date("Y-m-d", strtotime("2021-10-01")))
            ->where('created_at', '<=', Carbon::now())
            ->first();

        $data['childMarriagePravented'] = $get->one + $get->two + $get->three + $get->four + $get->five + $get->six + $get->seven + $get->eight + $get->nine + $get->ten;

        // dd($data['moneyADR']);
        $data['recurrentViolence'] = SelpIncidentModel::when($user_region, function ($query, $user_region) {
            if (count($user_region) > 0) {
                $query->whereIn('employee_zone_id', $user_region);
            }
        })
            ->when($user_division, function ($query, $user_division) {
                if (count($user_division) > 0) {
                    $query->whereIn('employee_division_id', $user_division);
                }
            })
            ->when($user_district, function ($query, $user_district) {
                if (count($user_district) > 0) {
                    $query->whereIn('employee_district_id', $user_district);
                }
            })
            ->when($user_upazila, function ($query, $user_upazila) {
                if (count($user_upazila) > 0) {
                    $query->whereIn('employee_upazila_id', $user_upazila);
                }
            })
            ->whereNotNull('violence_reason_id')
            ->whereNotNull('survivor_first_face_violence_type')
            ->where('created_at', '>=', date("Y-m-d", strtotime("2021-10-01")))
            ->where('created_at', '<=', Carbon::now())
            ->where('survivor_first_face_violence_type', '!=', "")
            ->count();

        //Survivors got Legal Support (Case & ADR)
        // $data["caseOrAdr"] = $this->getSupportData($user_region, $user_division, $user_district, $user_upazila);
        //$data["caseOrAdr"] = "--";
        return view('backend.dashboard', $data);
    }

    //Survivors got Legal Support (Case & ADR)

    public function getSupportData() {
        ini_set('memory_limit', -1);
        $user_region   = session()->get('userareaaccess.sregions');
        $user_division = session()->get('userareaaccess.sdivisions');
        $user_district = session()->get('userareaaccess.sdistricts');
        $user_upazila  = session()->get('userareaaccess.supazilas');

        //this code not working live server but work on local server

        // $incidents = SelpIncidentModel::when($user_region, function ($query, $user_region) {
        //     if (count($user_region) > 0) {
        //         $query->whereIn('employee_zone_id', $user_region);
        //     }
        // })
        //     ->when($user_division, function ($query, $user_division) {
        //         if (count($user_division) > 0) {
        //             $query->whereIn('employee_division_id', $user_division);
        //         }
        //     })
        //     ->when($user_district, function ($query, $user_district) {
        //         if (count($user_district) > 0) {
        //             $query->whereIn('employee_district_id', $user_district);
        //         }
        //     })
        //     ->when($user_upazila, function ($query, $user_upazila) {
        //         if (count($user_upazila) > 0) {
        //             $query->whereIn('employee_upazila_id', $user_upazila);
        //         }
        //     })

        //     ->where('posting_date', '>=', date("Y-m-d", strtotime("2021-10-01")))
        //     ->leftJoin('survivor_direct_services as sds', 'sds.selp_incident_information_id', '=', 'selp_incident_informations.id')
        //     ->leftJoin('survivor_court_cases as scc', 'scc.selp_incident_information_id', '=', 'selp_incident_informations.id')
        //     ->select('selp_incident_informations.id', 'sds.selp_incident_information_id as adr', 'scc.selp_incident_information_id as cases')
        //     ->where(function ($q) {
        //         $q->whereNotNull('sds.selp_incident_information_id')->orWhereNotNull('scc.selp_incident_information_id');
        //     })
        //     ->where('status', 2)
        //     ->count(DB::raw('DISTINCT selp_incident_informations.id'));

        $incidents1 = SelpIncidentModel::when($user_region, function ($query, $user_region) {
            if (count($user_region) > 0) {
                $query->whereIn('employee_zone_id', $user_region);
            }
        })
            ->when($user_division, function ($query, $user_division) {
                if (count($user_division) > 0) {
                    $query->whereIn('employee_division_id', $user_division);
                }
            })
            ->when($user_district, function ($query, $user_district) {
                if (count($user_district) > 0) {
                    $query->whereIn('employee_district_id', $user_district);
                }
            })
            ->when($user_upazila, function ($query, $user_upazila) {
                if (count($user_upazila) > 0) {
                    $query->whereIn('employee_upazila_id', $user_upazila);
                }
            })

            ->where('posting_date', '>=', date("Y-m-d", strtotime("2021-10-01")))
            ->where('posting_date', '<=', Carbon::now())
            ->join('survivor_direct_services as sds', 'sds.selp_incident_information_id', '=', 'selp_incident_informations.id')
            ->select('selp_incident_informations.id')
            ->where('status', 2)
            ->get();

        $incidents2 = SelpIncidentModel::when($user_region, function ($query, $user_region) {
            if (count($user_region) > 0) {
                $query->whereIn('employee_zone_id', $user_region);
            }
        })
            ->when($user_division, function ($query, $user_division) {
                if (count($user_division) > 0) {
                    $query->whereIn('employee_division_id', $user_division);
                }
            })
            ->when($user_district, function ($query, $user_district) {
                if (count($user_district) > 0) {
                    $query->whereIn('employee_district_id', $user_district);
                }
            })
            ->when($user_upazila, function ($query, $user_upazila) {
                if (count($user_upazila) > 0) {
                    $query->whereIn('employee_upazila_id', $user_upazila);
                }
            })

            ->where('posting_date', '>=', date("Y-m-d", strtotime("2021-10-01")))
            ->where('posting_date', '<=', Carbon::now())
            ->join('survivor_court_cases as scc', 'scc.selp_incident_information_id', '=', 'selp_incident_informations.id')
            ->select('selp_incident_informations.id')
            ->where('status', 2)
            ->get();

            $margeColl = $incidents1->merge($incidents2);
            return response()->json($margeColl->count());
    }

    public function dashboardPerpetrator() {
        $user_region                 = session()->get('userareaaccess.sregions');
        $user_division               = session()->get('userareaaccess.sdivisions');
        $user_district               = session()->get('userareaaccess.sdistricts');
        $user_upazila                = session()->get('userareaaccess.supazilas');
        $data['divisions']           = Division::all();
        $data['regions']             = Region::where('status', '1')->get();
        $data['violence_categories'] = ViolenceCategory::where('status', '1')->get();
        $data['auth_user']           = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        // dd(session()->get('userareaaccess.sregions'));

        $firstDate         = SelpIncidentModel::select('posting_date')->whereNotNull('posting_date')->orderBy('posting_date', 'asc')->first();
        $lastDate          = SelpIncidentModel::select('posting_date')->whereNotNull('posting_date')->orderBy('posting_date', 'desc')->first();
        $data['firstYear'] = date('Y', strtotime($firstDate->posting_date));
        $data['lastDate']  = date('Y', strtotime($lastDate->posting_date));
        return view('backend.dashboard-perpetrator', $data);
    }

    public function dashboardCommunity() {
        $user_region                 = session()->get('userareaaccess.sregions');
        $user_division               = session()->get('userareaaccess.sdivisions');
        $user_district               = session()->get('userareaaccess.sdistricts');
        $user_upazila                = session()->get('userareaaccess.supazilas');
        $data['divisions']           = Division::all();
        $data['regions']             = Region::where('status', '1')->get();
        $data['violence_categories'] = ViolenceCategory::where('status', '1')->get();
        $data['auth_user']           = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        // dd(session()->get('userareaaccess.sregions'));

        $firstDate         = SelpIncidentModel::select('posting_date')->whereNotNull('posting_date')->orderBy('posting_date', 'asc')->first();
        $lastDate          = SelpIncidentModel::select('posting_date')->whereNotNull('posting_date')->orderBy('posting_date', 'desc')->first();
        $data['firstYear'] = date('Y', strtotime($firstDate->posting_date));
        $data['lastDate']  = date('Y', strtotime($lastDate->posting_date));

        return view('backend.dashboard-community', $data);
    }

    public function dashboardAdrCase() {
        $user_region                 = session()->get('userareaaccess.sregions');
        $user_division               = session()->get('userareaaccess.sdivisions');
        $user_district               = session()->get('userareaaccess.sdistricts');
        $user_upazila                = session()->get('userareaaccess.supazilas');
        $data['divisions']           = Division::all();
        $data['regions']             = Region::where('status', '1')->get();
        $data['violence_categories'] = ViolenceCategory::where('status', '1')->get();
        $data['auth_user']           = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        // dd(session()->get('userareaaccess.sregions'));

        $firstDate         = SelpIncidentModel::select('posting_date')->whereNotNull('posting_date')->orderBy('posting_date', 'asc')->first();
        $lastDate          = SelpIncidentModel::select('posting_date')->whereNotNull('posting_date')->orderBy('posting_date', 'desc')->first();
        $data['firstYear'] = date('Y', strtotime($firstDate->posting_date));
        $data['lastDate']  = date('Y', strtotime($lastDate->posting_date));

        return view('backend.dashboard-adr-case', $data);
    }

    public function filterData(Request $request) {
        // dd($request->all());
        $data = '';
        if ($request->hidden_field == 1) {
            $dataVawg = SelpIncidentModel::when($request, function ($query, $request) {
                if ($request->region_id != null) {
                    $query->where('employee_zone_id', $request->region_id);
                }
            })
                ->when($request, function ($query, $request) {
                    if ($request->division_id != null) {
                        $query->where('employee_division_id', $request->division_id);
                    }
                })
                ->when($request, function ($query, $request) {
                    if ($request->district_id != null) {
                        $query->where('employee_district_id', $request->district_id);
                    }
                })
                ->when($request, function ($query, $request) {
                    if ($request->upazila_id != null) {
                        $query->where('employee_upazila_id', $request->upazila_id);
                    }
                })
                ->when($request, function ($query, $request) {
                    if ($request->from_date != null) {
                        $from_date = date("Y-m-d", strtotime($request->from_date));
                        $query->where('posting_date', '>=', $from_date);
                    }
                })
                ->when($request, function ($query, $request) {
                    if ($request->to_date != null) {
                        $to_date = date("Y-m-d", strtotime($request->to_date));
                        $query->where('posting_date', '<=', $to_date);
                    }
                })
                ->where('survivor_gender_id', 2)
                ->where('status', 2)
                ->count();

            $dataTotal = SelpIncidentModel::when($request, function ($query, $request) {
                if ($request->region_id != null) {
                    $query->where('employee_zone_id', $request->region_id);
                }
            })
                ->when($request, function ($query, $request) {
                    if ($request->division_id != null) {
                        $query->where('employee_division_id', $request->division_id);
                    }
                })
                ->when($request, function ($query, $request) {
                    if ($request->district_id != null) {
                        $query->where('employee_district_id', $request->district_id);
                    }
                })
                ->when($request, function ($query, $request) {
                    if ($request->upazila_id != null) {
                        $query->where('employee_upazila_id', $request->upazila_id);
                    }
                })
                ->when($request, function ($query, $request) {
                    if ($request->from_date != null) {
                        $from_date = date("Y-m-d", strtotime($request->from_date));
                        $query->where('posting_date', '>=', $from_date);
                    }
                })
                ->when($request, function ($query, $request) {
                    if ($request->to_date != null) {
                        $to_date = date("Y-m-d", strtotime($request->to_date));
                        $query->where('posting_date', '<=', $to_date);
                    }
                })
                ->where('status', 2)
                ->count();
            $data = [
                "dataVawg"  => $dataVawg,
                "dataTotal" => $dataTotal,
            ];
        }

        if ($request->hidden_field == 2) {

            // $data  = SurvivorDirectServiceModel::whereHas('selpincident', function ($query) use ($request) {
            //     $query->when($request, function ($query, $request) {
            //             $query->where('employee_zone_id', $request->region_id);
            //     })
            //         ->when($request, function ($query, $request) {
            //                 $query->where('employee_division_id',$request->division_id);
            //         })
            //         ->when($request, function ($query, $request) {
            //                 $query->where('employee_district_id', $request->district_id);
            //         })
            //         ->when($request, function ($query, $request) {
            //                 $query->where('employee_upazila_id', $request->upazila_id);
            //         })
            //         ->where('status', 2);
            // })
            //     ->whereIn('alternative_dispute_resolution_id', [7, 9])
            //     ->where('closing_date', '>=', date("Y-m-d", strtotime("2021-10-01")))

            //     ->count();

            $data = SurvivorDirectServiceModel::whereHas('selpincident', function ($query) use ($request) {
                $query->when($request, function ($query, $request) {
                    if ($request->region_id != null) {
                        $query->where('employee_zone_id', $request->region_id);
                    }
                })
                    ->when($request, function ($query, $request) {
                        if ($request->division_id != null) {
                            $query->where('employee_division_id', $request->division_id);
                        }
                    })
                    ->when($request, function ($query, $request) {
                        if ($request->district_id != null) {
                            $query->where('employee_district_id', $request->district_id);
                        }
                    })
                    ->when($request, function ($query, $request) {
                        if ($request->upazila_id != null) {
                            $query->where('employee_upazila_id', $request->upazila_id);
                        }
                    })
                    ->where('status', 2);
            })
                ->when($request, function ($query, $request) {
                    if ($request->from_date != null) {
                        $from_date = date("Y-m-d", strtotime($request->from_date));
                        $query->where('closing_date', '>=', $from_date);
                    }
                })
                ->when($request, function ($query, $request) {
                    if ($request->to_date != null) {
                        $to_date = date("Y-m-d", strtotime($request->to_date));
                        $query->where('closing_date', '<=', $to_date);
                    }
                })
                ->whereIn('alternative_dispute_resolution_id', [7, 9])
                ->distinct('selp_incident_information_id')
                ->count();
        }

        if ($request->hidden_field == 3) {
            $moneyADR = SurvivorDirectServiceModel::whereHas('selpincident', function ($query) use ($request) {
                $query->when($request, function ($query, $request) {
                    if ($request->region_id != null) {
                        $query->where('employee_zone_id', $request->region_id);
                    }
                })
                    ->when($request, function ($query, $request) {
                        if ($request->division_id != null) {
                            $query->where('employee_division_id', $request->division_id);
                        }
                    })
                    ->when($request, function ($query, $request) {
                        if ($request->district_id != null) {
                            $query->where('employee_district_id', $request->district_id);
                        }
                    })
                    ->when($request, function ($query, $request) {
                        if ($request->upazila_id != null) {
                            $query->where('employee_upazila_id', $request->upazila_id);
                        }
                    })
                    ->where('status', 2);
            })
                ->when($request, function ($query, $request) {
                    if ($request->from_date != null) {
                        $from_date = date("Y-m-d", strtotime($request->from_date));
                        $query->where('closing_date', '>=', $from_date);
                    }
                })
                ->when($request, function ($query, $request) {
                    if ($request->to_date != null) {
                        $to_date = date("Y-m-d", strtotime($request->to_date));
                        $query->where('closing_date', '<=', $to_date);
                    }
                })->whereIn('alternative_dispute_resolution_id', [7, 9, 11])
                //->groupBy('selp_incident_information_id')
                ->whereNotNull('amount_of_money_received')
                ->get();

            $data =  $moneyADR->sum('amount_of_money_received');
        }

        if ($request->hidden_field == 4) {
            $get = PollisomajDataModel::when($request, function ($query, $request) {
                if ($request->region_id != null) {
                    $query->where('zone_id', $request->region_id);
                }
            })
                ->when($request, function ($query, $request) {
                    if ($request->division_id != null) {
                        $query->where('division_id', $request->division_id);
                    }
                })
                ->when($request, function ($query, $request) {
                    if ($request->district_id != null) {
                        $query->where('district_id', $request->district_id);
                    }
                })
                ->when($request, function ($query, $request) {
                    if ($request->upazila_id != null) {
                        $query->where('upazilla_id', $request->upazila_id);
                    }
                })
                ->when($request, function ($query, $request) {
                    if ($request->from_date != null) {
                        $from_date = date("Y-m-d", strtotime($request->from_date));
                        $query->where('reporting_date', '>=', $from_date);
                    }
                })
                ->when($request, function ($query, $request) {
                    if ($request->to_date != null) {
                        $to_date = date("Y-m-d", strtotime($request->to_date));
                        $query->where('reporting_date', '<=', $to_date);
                    }
                })
                ->where('flag', 2)
                ->select(DB::raw('
                            SUM(contacted_up_within_ps_member) as one,
                            SUM(contacted_up_beyond_ps_member) as two,
                            SUM(contacted_local_within_ps_member) as three,
                            SUM(contacted_local_beyond_ps_member) as four,
                            SUM(family_consultation_within_ps_member) as five,
                            SUM(family_consultation_beyond_ps_member) as six,
                            SUM(contacted_upazila_within_ps_member) as seven,
                            SUM(contacted_upazila_beyond_ps_member) as eight,
                            SUM(hotline_number_within_ps_member) as nine,
                            SUM(hotline_number_beyond_ps_member) as ten
							'))
                ->first();
            // ->sum('number_of_child_marriage');
            $data = $get->one + $get->two + $get->three + $get->four + $get->five + $get->six + $get->seven + $get->eight + $get->nine + $get->ten;
        }

        if ($request->hidden_field == 5) {
            $data = PollisomajDataModel::when($request, function ($query, $request) {
                if ($request->region_id != null) {
                    $query->where('zone_id', $request->region_id);
                }
            })
                ->when($request, function ($query, $request) {
                    if ($request->division_id != null) {
                        $query->where('division_id', $request->division_id);
                    }
                })
                ->when($request, function ($query, $request) {
                    if ($request->district_id != null) {
                        $query->where('district_id', $request->district_id);
                    }
                })
                ->when($request, function ($query, $request) {
                    if ($request->upazila_id != null) {
                        $query->where('upazilla_id', $request->upazila_id);
                    }
                })
                ->when($request, function ($query, $request) {
                    if ($request->from_date != null) {
                        $from_date = date("Y-m-d", strtotime($request->from_date));
                        $query->where('reporting_date', '>=', $from_date);
                    }
                })
                ->when($request, function ($query, $request) {
                    if ($request->to_date != null) {
                        $to_date = date("Y-m-d", strtotime($request->to_date));
                        $query->where('reporting_date', '<=', $to_date);
                    }
                })
                ->where('flag', 2)
                ->sum('number_of_child_marriage');
        }

        if ($request->hidden_field == 6) {

            $incidents1 = SelpIncidentModel::when($request, function ($query, $request) {
                    if ($request->region_id != null) {
                        $query->where('employee_zone_id', $request->region_id);
                    }
                })->when($request, function ($query, $request) {
                        if ($request->division_id != null) {
                            $query->where('employee_division_id', $request->division_id);
                        }
                    })
                    ->when($request, function ($query, $request) {
                        if ($request->district_id != null) {
                            $query->where('employee_district_id', $request->district_id);
                        }
                    })
                    ->when($request, function ($query, $request) {
                        if ($request->upazila_id != null) {
                            $query->where('employee_upazila_id', $request->upazila_id);
                        }
                    })
                    ->when($request, function ($query, $request) {
                        if ($request->from_date != null) {
                            $from_date = date("Y-m-d", strtotime($request->from_date));
                            $query->where('posting_date', '>=', $from_date);
                        }
                    })
                    ->when($request, function ($query, $request) {
                        if ($request->to_date != null) {
                            $to_date = date("Y-m-d", strtotime($request->to_date));
                            $query->where('posting_date', '<=', $to_date);
                        }
                    })->where('posting_date', '>=', date("Y-m-d", strtotime("2021-10-01")))
                    ->join('survivor_direct_services as sds', 'sds.selp_incident_information_id', '=', 'selp_incident_informations.id')
                    ->select('selp_incident_informations.id')
                    ->where('status', 2)
                    ->get();
        
            $incidents2 = SelpIncidentModel::when($request, function ($query, $request) {
                    if ($request->region_id != null) {
                        $query->where('employee_zone_id', $request->region_id);
                    }
                })->when($request, function ($query, $request) {
                        if ($request->division_id != null) {
                            $query->where('employee_division_id', $request->division_id);
                        }
                    })
                    ->when($request, function ($query, $request) {
                        if ($request->district_id != null) {
                            $query->where('employee_district_id', $request->district_id);
                        }
                    })
                    ->when($request, function ($query, $request) {
                        if ($request->upazila_id != null) {
                            $query->where('employee_upazila_id', $request->upazila_id);
                        }
                    })
                    ->when($request, function ($query, $request) {
                        if ($request->from_date != null) {
                            $from_date = date("Y-m-d", strtotime($request->from_date));
                            $query->where('posting_date', '>=', $from_date);
                        }
                    })
                    ->when($request, function ($query, $request) {
                        if ($request->to_date != null) {
                            $to_date = date("Y-m-d", strtotime($request->to_date));
                            $query->where('posting_date', '<=', $to_date);
                        }
                    })->where('posting_date', '>=', date("Y-m-d", strtotime("2021-10-01")))
                    ->join('survivor_court_cases as scc', 'scc.selp_incident_information_id', '=', 'selp_incident_informations.id')
                    ->select('selp_incident_informations.id')
                    ->where('status', 2)
                    ->get();
        
            $margeColl = $incidents1->merge($incidents2);
            
            $data = $margeColl->count();
        }
        return response()->json($data);
    }

    public function ageRangeData(Request $request) {
        $user_region   = session()->get('userareaaccess.sregions');
        $user_division = session()->get('userareaaccess.sdivisions');
        $user_district = session()->get('userareaaccess.sdistricts');
        $user_upazila  = session()->get('userareaaccess.supazilas');
        $ageR          = array('0-5', '6-10', '11-17', '18-35', '36-100');
        $violences     = ViolenceCategory::select('id', 'name')->whereIn('id', [1, 2, 3, 4, 6])->get();
        foreach ($ageR as $key => $value) {
            $ttt = explode("-", $value);
            $rrr = implode(",", $ttt);

            foreach ($violences as $keyy => $violence) {
                $pdata['informations'][$value]['age']           = $value;
                $pdata['informations'][$value][$violence->name] = SelpIncidentModel::when($user_region, function ($query, $user_region) {
                    if (count($user_region) > 0) {
                        $query->whereIn('employee_zone_id', $user_region);
                    }
                })
                    ->when($user_division, function ($query, $user_division) {
                        if (count($user_division) > 0) {
                            $query->whereIn('employee_division_id', $user_division);
                        }
                    })
                    ->when($user_district, function ($query, $user_district) {
                        if (count($user_district) > 0) {
                            $query->whereIn('employee_district_id', $user_district);
                        }
                    })
                    ->when($user_upazila, function ($query, $user_upazila) {
                        if (count($user_upazila) > 0) {
                            $query->whereIn('employee_upazila_id', $user_upazila);
                        }
                    })
                    ->select('id', 'violence_reason_id', 'survivor_age')
                    ->where('posting_date', '>=', date("Y-m-d", strtotime("2021-10-01")))
                    ->whereIn('survivor_age', range($ttt[0], $ttt[1]))
                    ->where('violence_reason_id', $violence->id)
                    ->whereNotNull('violence_reason_id')
                    ->where('status', 2)
                    ->count();
            }
        }

        // foreach ($pdata['informations'] as &$inner_array) {
        //     arsort($inner_array, SORT_NUMERIC);
        //     $age = $inner_array['age'];
        //     unset($inner_array['age']);
        //     $inner_array = ['age' => $age] + array_slice($inner_array, 0, 6);
        // }

        // arsort($pdata['informations'], SORT_NUMERIC);
        $reindexed = array_values($pdata['informations']);
        // dd($reindexed);
        return response()->json($reindexed);
    }

    public function adrMoney(Request $request) {
        $user_region   = session()->get('userareaaccess.sregions');
        $user_division = session()->get('userareaaccess.sdivisions');
        $user_district = session()->get('userareaaccess.sdistricts');
        $user_upazila  = session()->get('userareaaccess.supazilas');

        $months = array(
            1  => "January",
            2  => "February",
            3  => "March",
            4  => "April",
            5  => "May",
            6  => "June",
            7  => "July",
            8  => "August",
            9  => "September",
            10 => "October",
            11 => "November",
            12 => "December",
        );
        foreach ($months as $key => $value) {
            // dd(date('Y'));
            $direct_support[$value]['month'] = $value;
            $direct_support[$value]['money'] = (int) SurvivorDirectServiceModel::whereHas('selpincident', function ($query) use ($user_region, $user_division, $user_district, $user_upazila) {
                $query->when($user_region, function ($query, $user_region) {
                    if (count($user_region) > 0) {
                        $query->whereIn('employee_zone_id', $user_region);
                    }
                })
                    ->when($user_division, function ($query, $user_division) {
                        if (count($user_division) > 0) {
                            $query->whereIn('employee_division_id', $user_division);
                        }
                    })
                    ->when($user_district, function ($query, $user_district) {
                        if (count($user_district) > 0) {
                            $query->whereIn('employee_district_id', $user_district);
                        }
                    })
                    ->when($user_upazila, function ($query, $user_upazila) {
                        if (count($user_upazila) > 0) {
                            $query->whereIn('employee_upazila_id', $user_upazila);
                        }
                    });
            })->whereIn('alternative_dispute_resolution_id', [7, 9, 11]) // added by sajal
                                                                         //->whereIn('alternative_dispute_resolution_id', [7, 9, 10, 11])
                ->whereNotNull('amount_of_money_received')
                ->whereYear('closing_date', '=', date('Y'))
                ->whereMonth('closing_date', '=', $key)
                ->sum('amount_of_money_received');
        }
        // dd($direct_support);
        $reindexed = array_values($direct_support);
        return response()->json($reindexed);
    }

    public function topViolence() {
        $user_region   = session()->get('userareaaccess.sregions');
        $user_division = session()->get('userareaaccess.sdivisions');
        $user_district = session()->get('userareaaccess.sdistricts');
        $user_upazila  = session()->get('userareaaccess.supazilas');

        $violences = ViolenceCategory::select('id', 'name')->orderBy('id', "ASC")->get();

        foreach ($violences as $key => $value) {
            $pdata['informations'][$value->name]['category'] = $value->name;
            $pdata['informations'][$value->name]['value']    = SelpIncidentModel::when($user_region, function ($query, $user_region) {
                if (count($user_region) > 0) {
                    $query->whereIn('employee_zone_id', $user_region);
                }
            })
                ->when($user_division, function ($query, $user_division) {
                    if (count($user_division) > 0) {
                        $query->whereIn('employee_division_id', $user_division);
                    }
                })
                ->when($user_district, function ($query, $user_district) {
                    if (count($user_district) > 0) {
                        $query->whereIn('employee_district_id', $user_district);
                    }
                })
                ->when($user_upazila, function ($query, $user_upazila) {
                    if (count($user_upazila) > 0) {
                        $query->whereIn('employee_upazila_id', $user_upazila);
                    }
                })
                ->where('violence_reason_id', $value->id)
                ->where('created_at', '>=', '2021-10-01')
                ->where('status', 2)->count();
        }
        usort($pdata['informations'], function ($a, $b) {
            if ($a["value"] == $b["value"]) {
                return strcmp($b["value"], $a["value"]);
            }
            return $b["value"] - $a["value"];
        });

        $data = array_slice($pdata['informations'], 0, 5);
        return response()->json($data);
    }

    public function survivorAge() {
        $user_region   = session()->get('userareaaccess.sregions');
        $user_division = session()->get('userareaaccess.sdivisions');
        $user_district = session()->get('userareaaccess.sdistricts');
        $user_upazila  = session()->get('userareaaccess.supazilas');

        // ->whereIn('alternative_dispute_resolution_id', [7, 9]) // added by sajal
        //         ->count();
        //         ->where('survivor_gender_id', 2)

        $pdata['informations']['category']['category'] = "Below 18(0-17)";
        $pdata['informations']['category']['value']    = SelpIncidentModel::when($user_region, function ($query, $user_region) {
            if (count($user_region) > 0) {
                $query->whereIn('employee_zone_id', $user_region);
            }
        })
            ->when($user_division, function ($query, $user_division) {
                if (count($user_division) > 0) {
                    $query->whereIn('employee_division_id', $user_division);
                }
            })
            ->when($user_district, function ($query, $user_district) {
                if (count($user_district) > 0) {
                    $query->whereIn('employee_district_id', $user_district);
                }
            })
            ->when($user_upazila, function ($query, $user_upazila) {
                if (count($user_upazila) > 0) {
                    $query->whereIn('employee_upazila_id', $user_upazila);
                }
            })
            ->whereIn('survivor_age', range(0, 17))
            ->where('survivor_gender_id', 2)                      // added by sajal
            ->whereIn('survivor_marital_status_id', [1, 3, 4, 5]) // added by sajal
            ->where('created_at', '>=', date("Y-m-d", strtotime("2021-10-01")))
            ->where('status', 2)
            ->count();
        $pdata['informations']['category2']['category'] = "Above 18(18 - Above)";
        $pdata['informations']['category2']['value']    = SelpIncidentModel::when($user_region, function ($query, $user_region) {
            if (count($user_region) > 0) {
                $query->whereIn('employee_zone_id', $user_region);
            }
        })
            ->when($user_division, function ($query, $user_division) {
                if (count($user_division) > 0) {
                    $query->whereIn('employee_division_id', $user_division);
                }
            })
            ->when($user_district, function ($query, $user_district) {
                if (count($user_district) > 0) {
                    $query->whereIn('employee_district_id', $user_district);
                }
            })
            ->when($user_upazila, function ($query, $user_upazila) {
                if (count($user_upazila) > 0) {
                    $query->whereIn('employee_upazila_id', $user_upazila);
                }
            })
            ->whereIn('survivor_age', range(18, 200))
            ->where('survivor_gender_id', 2)                      //added by sajal
            ->whereIn('survivor_marital_status_id', [1, 3, 4, 5]) // added by sajal
            ->where('created_at', '>=', date("Y-m-d", strtotime("2021-10-01")))
            ->where('status', 2)
            ->count();
        $reindexed = array_values($pdata['informations']);
        return response()->json($reindexed);
    }

    public function defendantAge() {
        $user_region   = session()->get('userareaaccess.sregions');
        $user_division = session()->get('userareaaccess.sdivisions');
        $user_district = session()->get('userareaaccess.sdistricts');
        $user_upazila  = session()->get('userareaaccess.supazilas');

        $pdata['informations']['category']['category'] = "Age(0-5)";
        $pdata['informations']['category']['value']    = SelpIncidentModel::when($user_region, function ($query, $user_region) {
            if (count($user_region) > 0) {
                $query->whereIn('employee_zone_id', $user_region);
            }
        })
            ->when($user_division, function ($query, $user_division) {
                if (count($user_division) > 0) {
                    $query->whereIn('employee_division_id', $user_division);
                }
            })
            ->when($user_district, function ($query, $user_district) {
                if (count($user_district) > 0) {
                    $query->whereIn('employee_district_id', $user_district);
                }
            })
            ->when($user_upazila, function ($query, $user_upazila) {
                if (count($user_upazila) > 0) {
                    $query->whereIn('employee_upazila_id', $user_upazila);
                }
            })
            ->whereIn('main_defendant_age', range(0, 5))
            ->where('created_at', '>=', date("Y-m-d", strtotime("2021-10-01")))
            ->where('status', 2)
            ->count();

        $pdata['informations']['category2']['category'] = "Age(6 - 10)";
        $pdata['informations']['category2']['value']    = SelpIncidentModel::when($user_region, function ($query, $user_region) {
            if (count($user_region) > 0) {
                $query->whereIn('employee_zone_id', $user_region);
            }
        })
            ->when($user_division, function ($query, $user_division) {
                if (count($user_division) > 0) {
                    $query->whereIn('employee_division_id', $user_division);
                }
            })
            ->when($user_district, function ($query, $user_district) {
                if (count($user_district) > 0) {
                    $query->whereIn('employee_district_id', $user_district);
                }
            })
            ->when($user_upazila, function ($query, $user_upazila) {
                if (count($user_upazila) > 0) {
                    $query->whereIn('employee_upazila_id', $user_upazila);
                }
            })
            ->whereIn('main_defendant_age', range(6, 10))
            ->where('status', 2)
            ->where('created_at', '>=', date("Y-m-d", strtotime("2021-10-01")))
            ->count();

        //added by sajal
        $pdata['informations']['category3']['category'] = "Age(11 - 17)";
        $pdata['informations']['category3']['value']    = SelpIncidentModel::whereIn('main_defendant_age', range(11, 17))
            ->where('status', 2)
            ->where('created_at', '>=', date("Y-m-d", strtotime("2021-10-01")))
            ->count();

        $pdata['informations']['category4']['category'] = "Age(18 - 35)";
        $pdata['informations']['category4']['value']    = SelpIncidentModel::whereIn('main_defendant_age', range(18, 35))
            ->where('status', 2)
            ->where('created_at', '>=', date("Y-m-d", strtotime("2021-10-01")))
            ->count();

        $pdata['informations']['category5']['category'] = "Age(36 - 50)";
        $pdata['informations']['category5']['value']    = SelpIncidentModel::whereIn('main_defendant_age', range(36, 100))
            ->where('status', 2)
            ->where('created_at', '>=', date("Y-m-d", strtotime("2021-10-01")))
            ->count();

        $pdata['informations']['category6']['category'] = "Age(51 - 100)";
        $pdata['informations']['category6']['value']    = SelpIncidentModel::whereIn('main_defendant_age', range(36, 100))
            ->where('status', 2)
            ->where('created_at', '>=', date("Y-m-d", strtotime("2021-10-01")))
            ->count();

        $reindexed = array_values($pdata['informations']);
        return response()->json($reindexed);
    }

    //defendant age filter by range
    public function defendantAgeFilter($category, $range) {

    }

    public function survivorEducation() {
        $user_region   = session()->get('userareaaccess.sregions');
        $user_division = session()->get('userareaaccess.sdivisions');
        $user_district = session()->get('userareaaccess.sdistricts');
        $user_upazila  = session()->get('userareaaccess.supazilas');

        $educations = Education::select('id', 'title')->orderBy('id', "ASC")->get();

        foreach ($educations as $key => $value) {
            $pdata['informations'][$value->title]['country'] = $value->title;
            $pdata['informations'][$value->title]['value']   = SelpIncidentModel::when($user_region, function ($query, $user_region) {
                if (count($user_region) > 0) {
                    $query->whereIn('employee_zone_id', $user_region);
                }
            })
                ->when($user_division, function ($query, $user_division) {
                    if (count($user_division) > 0) {
                        $query->whereIn('employee_division_id', $user_division);
                    }
                })
                ->when($user_district, function ($query, $user_district) {
                    if (count($user_district) > 0) {
                        $query->whereIn('employee_district_id', $user_district);
                    }
                })
                ->when($user_upazila, function ($query, $user_upazila) {
                    if (count($user_upazila) > 0) {
                        $query->whereIn('employee_upazila_id', $user_upazila);
                    }
                })
                ->where('survivor_education_id', $value->id)
                ->where('created_at', '>=', date("Y-m-d", strtotime("2021-10-01")))
                ->where('status', 2)->count();
        }
        usort($pdata['informations'], function ($a, $b) {
            if ($a["value"] == $b["value"]) {
                return strcmp($b["value"], $a["value"]);
            }
            return $b["value"] - $a["value"];
        });

        $data = array_slice($pdata['informations'], 0, 5);
        return response()->json($data);
    }

    public function defendantEducation(Request $request) {
        // dd($request->all());

        $user_region   = session()->get('userareaaccess.sregions');
        $user_division = session()->get('userareaaccess.sdivisions');
        $user_district = session()->get('userareaaccess.sdistricts');
        $user_upazila  = session()->get('userareaaccess.supazilas');
        $educations    = Education::select('id', 'title')->orderBy('id', "ASC")->get();

        foreach ($educations as $key => $value) {
            $pdata['informations'][$value->title]['country'] = $value->title;
            $pdata['informations'][$value->title]['value']   = SelpIncidentModel::when($user_region, function ($query, $user_region) {
                if (count($user_region) > 0) {
                    $query->whereIn('employee_zone_id', $user_region);
                }
            })
                ->when($user_division, function ($query, $user_division) {
                    if (count($user_division) > 0) {
                        $query->whereIn('employee_division_id', $user_division);
                    }
                })
                ->when($user_district, function ($query, $user_district) {
                    if (count($user_district) > 0) {
                        $query->whereIn('employee_district_id', $user_district);
                    }
                })
                ->when($user_upazila, function ($query, $user_upazila) {
                    if (count($user_upazila) > 0) {
                        $query->whereIn('employee_upazila_id', $user_upazila);
                    }
                })
                ->where('defendant_education_id', $value->id)
                ->where('status', 2)
                ->where('created_at', '>=', date("Y-m-d", strtotime("2021-10-01")))
                ->count();
        }
        usort($pdata['informations'], function ($a, $b) {
            if ($a["value"] == $b["value"]) {
                return strcmp($b["value"], $a["value"]);
            }
            return $b["value"] - $a["value"];
        });

        $data = array_slice($pdata['informations'], 0, 5);
        return response()->json($data);
    }

    public function defendantOccupation() {
        $user_region   = session()->get('userareaaccess.sregions');
        $user_division = session()->get('userareaaccess.sdivisions');
        $user_district = session()->get('userareaaccess.sdistricts');
        $user_upazila  = session()->get('userareaaccess.supazilas');
        $educations    = Occupation::select('id', 'name')->orderBy('id', "ASC")->get();

        foreach ($educations as $key => $value) {
            $pdata['informations'][$value->name]['country'] = $value->name;
            $pdata['informations'][$value->name]['value']   = SelpIncidentModel::when($user_region, function ($query, $user_region) {
                if (count($user_region) > 0) {
                    $query->whereIn('employee_zone_id', $user_region);
                }
            })
                ->when($user_division, function ($query, $user_division) {
                    if (count($user_division) > 0) {
                        $query->whereIn('employee_division_id', $user_division);
                    }
                })
                ->when($user_district, function ($query, $user_district) {
                    if (count($user_district) > 0) {
                        $query->whereIn('employee_district_id', $user_district);
                    }
                })
                ->when($user_upazila, function ($query, $user_upazila) {
                    if (count($user_upazila) > 0) {
                        $query->whereIn('employee_upazila_id', $user_upazila);
                    }
                })
                ->where('defendant_occupation_id', $value->id)
                ->where('status', 2)
                ->where('created_at', '>=', date("Y-m-d", strtotime("2021-10-01")))
                ->count();
        }
        usort($pdata['informations'], function ($a, $b) {
            if ($a["value"] == $b["value"]) {
                return strcmp($b["value"], $a["value"]);
            }
            return $b["value"] - $a["value"];
        });

        $data = array_slice($pdata['informations'], 0, 5);
        return response()->json($data);
    }

    public function cummunityViolence() {
        $user_region                                  = session()->get('userareaaccess.sregions');
        $user_division                                = session()->get('userareaaccess.sdivisions');
        $user_district                                = session()->get('userareaaccess.sdistricts');
        $user_upazila                                 = session()->get('userareaaccess.supazilas');
        $pdata['informations']['category']['country'] = "Illegal divorce";
        $pdata['informations']['category']['value']   = (int) PollisomajDataModel::when($user_region, function ($query, $user_region) {
            if (count($user_region) > 0) {
                $query->whereIn('zone_id', $user_region);
            }
        })
            ->when($user_division, function ($query, $user_division) {
                if (count($user_division) > 0) {
                    $query->whereIn('division_id', $user_division);
                }
            })
            ->when($user_district, function ($query, $user_district) {
                if (count($user_district) > 0) {
                    $query->whereIn('district_id', $user_district);
                }
            })
            ->when($user_upazila, function ($query, $user_upazila) {
                if (count($user_upazila) > 0) {
                    $query->whereIn('upazilla_id', $user_upazila);
                }
            })->where('created_at', '>=', date("Y-m-d", strtotime("2021-10-01")))
            ->sum('illegal_divorce');
        $pdata['informations']['category2']['country'] = "Illegal polygamy";
        $pdata['informations']['category2']['value']   = (int) PollisomajDataModel::when($user_region, function ($query, $user_region) {
            if (count($user_region) > 0) {
                $query->whereIn('zone_id', $user_region);
            }
        })
            ->when($user_division, function ($query, $user_division) {
                if (count($user_division) > 0) {
                    $query->whereIn('division_id', $user_division);
                }
            })
            ->when($user_district, function ($query, $user_district) {
                if (count($user_district) > 0) {
                    $query->whereIn('district_id', $user_district);
                }
            })
            ->when($user_upazila, function ($query, $user_upazila) {
                if (count($user_upazila) > 0) {
                    $query->whereIn('upazilla_id', $user_upazila);
                }
            })->where('created_at', '>=', date("Y-m-d", strtotime("2021-10-01")))
            ->sum('illegal_polygamy');
        $pdata['informations']['category3']['country'] = "Family Conflict";
        $pdata['informations']['category3']['value']   = (int) PollisomajDataModel::when($user_region, function ($query, $user_region) {
            if (count($user_region) > 0) {
                $query->whereIn('zone_id', $user_region);
            }
        })
            ->when($user_division, function ($query, $user_division) {
                if (count($user_division) > 0) {
                    $query->whereIn('division_id', $user_division);
                }
            })
            ->when($user_district, function ($query, $user_district) {
                if (count($user_district) > 0) {
                    $query->whereIn('district_id', $user_district);
                }
            })
            ->when($user_upazila, function ($query, $user_upazila) {
                if (count($user_upazila) > 0) {
                    $query->whereIn('upazilla_id', $user_upazila);
                }
            })->where('created_at', '>=', date("Y-m-d", strtotime("2021-10-01")))
            ->sum('family_conflict');
        $pdata['informations']['category4']['country'] = "Hilla marriage";
        $pdata['informations']['category4']['value']   = (int) PollisomajDataModel::when($user_region, function ($query, $user_region) {
            if (count($user_region) > 0) {
                $query->whereIn('zone_id', $user_region);
            }
        })
            ->when($user_division, function ($query, $user_division) {
                if (count($user_division) > 0) {
                    $query->whereIn('division_id', $user_division);
                }
            })
            ->when($user_district, function ($query, $user_district) {
                if (count($user_district) > 0) {
                    $query->whereIn('district_id', $user_district);
                }
            })
            ->when($user_upazila, function ($query, $user_upazila) {
                if (count($user_upazila) > 0) {
                    $query->whereIn('upazilla_id', $user_upazila);
                }
            })
            ->where('created_at', '>=', date("Y-m-d", strtotime("2021-10-01")))
            ->sum('hilla_marriage');
        $pdata['informations']['category5']['country'] = "Illegal arbitration";
        $pdata['informations']['category5']['value']   = (int) PollisomajDataModel::when($user_region, function ($query, $user_region) {
            if (count($user_region) > 0) {
                $query->whereIn('zone_id', $user_region);
            }
        })
            ->when($user_division, function ($query, $user_division) {
                if (count($user_division) > 0) {
                    $query->whereIn('division_id', $user_division);
                }
            })
            ->when($user_district, function ($query, $user_district) {
                if (count($user_district) > 0) {
                    $query->whereIn('district_id', $user_district);
                }
            })
            ->when($user_upazila, function ($query, $user_upazila) {
                if (count($user_upazila) > 0) {
                    $query->whereIn('upazilla_id', $user_upazila);
                }
            })->where('created_at', '>=', date("Y-m-d", strtotime("2021-10-01")))
            ->sum('illegal_arbitration');
        $pdata['informations']['category6']['country'] = "Illegal fatwa";
        $pdata['informations']['category6']['value']   = (int) PollisomajDataModel::when($user_region, function ($query, $user_region) {
            if (count($user_region) > 0) {
                $query->whereIn('zone_id', $user_region);
            }
        })
            ->when($user_division, function ($query, $user_division) {
                if (count($user_division) > 0) {
                    $query->whereIn('division_id', $user_division);
                }
            })
            ->when($user_district, function ($query, $user_district) {
                if (count($user_district) > 0) {
                    $query->whereIn('district_id', $user_district);
                }
            })
            ->when($user_upazila, function ($query, $user_upazila) {
                if (count($user_upazila) > 0) {
                    $query->whereIn('upazilla_id', $user_upazila);
                }
            })->where('created_at', '>=', date("Y-m-d", strtotime("2021-10-01")))
            ->sum('illegal_fatwah');
        $pdata['informations']['category7']['country'] = "Physical torture";
        $pdata['informations']['category7']['value']   = (int) PollisomajDataModel::when($user_region, function ($query, $user_region) {
            if (count($user_region) > 0) {
                $query->whereIn('zone_id', $user_region);
            }
        })
            ->when($user_division, function ($query, $user_division) {
                if (count($user_division) > 0) {
                    $query->whereIn('division_id', $user_division);
                }
            })
            ->when($user_district, function ($query, $user_district) {
                if (count($user_district) > 0) {
                    $query->whereIn('district_id', $user_district);
                }
            })
            ->when($user_upazila, function ($query, $user_upazila) {
                if (count($user_upazila) > 0) {
                    $query->whereIn('upazilla_id', $user_upazila);
                }
            })->where('created_at', '>=', date("Y-m-d", strtotime("2021-10-01")))
            ->sum('physical_torture');
        $pdata['informations']['category8']['country'] = "Sexual harassment";
        $pdata['informations']['category8']['value']   = (int) PollisomajDataModel::when($user_region, function ($query, $user_region) {
            if (count($user_region) > 0) {
                $query->whereIn('zone_id', $user_region);
            }
        })
            ->when($user_division, function ($query, $user_division) {
                if (count($user_division) > 0) {
                    $query->whereIn('division_id', $user_division);
                }
            })
            ->when($user_district, function ($query, $user_district) {
                if (count($user_district) > 0) {
                    $query->whereIn('district_id', $user_district);
                }
            })
            ->when($user_upazila, function ($query, $user_upazila) {
                if (count($user_upazila) > 0) {
                    $query->whereIn('upazilla_id', $user_upazila);
                }
            })->where('created_at', '>=', date("Y-m-d", strtotime("2021-10-01")))
            ->sum('sexual_harassment');
        $reindexed = array_values($pdata['informations']);
        return response()->json($reindexed);
    }

    public function adrCase() {
        $user_region   = session()->get('userareaaccess.sregions');
        $user_division = session()->get('userareaaccess.sdivisions');
        $user_district = session()->get('userareaaccess.sdistricts');
        $user_upazila  = session()->get('userareaaccess.supazilas');

        $months = array(
            1  => "January",
            2  => "February",
            3  => "March",
            4  => "April",
            5  => "May",
            6  => "June",
            7  => "July",
            8  => "August",
            9  => "September",
            10 => "October",
            11 => "November",
            12 => "December",
        );

        foreach ($months as $key => $value) {
            // dd(date('Y'));
            $direct_support[$value]['month'] = $value;
            $incidents                       = SelpIncidentModel::with(['survivordirectservice'])
                ->when($user_region, function ($query, $user_region) {
                    if ($user_region->region_id != null) {
                        $query->where('employee_zone_id', $user_region->region_id);
                    }
                })
                ->when($user_division, function ($query, $user_division) {
                    if ($user_division->division_id != null) {
                        $query->where('employee_division_id', $user_division->division_id);
                    }
                })
                ->when($user_district, function ($query, $user_district) {
                    if ($user_district->district_id != null) {
                        $query->where('employee_district_id', $user_district->district_id);
                    }
                })
                ->when($user_upazila, function ($query, $user_upazila) {
                    if ($user_upazila->upazila_id != null) {
                        $query->where('employee_upazila_id', $user_upazila->upazila_id);
                    }
                })
                ->whereYear('posting_date', '=', date('Y'))
            // ->whereYear('posting_date', '=', 2022)
                ->whereMonth('posting_date', '=', $key)
            // ->when($request,function($query,$request){
            //     if($request->from_date!=null){
            //         $from_date = date("Y-m-d", strtotime($request->from_date));
            //         $query->where('posting_date', '>=', $from_date);
            //     }
            // })
            // ->when($request,function($query,$request){
            //     if($request->to_date!=null){
            //         $to_date = date("Y-m-d", strtotime($request->to_date));
            //         $query->where('posting_date', '<=', $to_date);
            //     }
            // })
                ->select('id')->get()->toArray();

            $survivordirectservice = array_filter($incidents, function ($item) {
                return isset($item['survivordirectservice']) && !empty($item['survivordirectservice']);
            });

            $incident_case = SelpIncidentModel::with(['selpcourtcasesupport'])
                ->when($user_region, function ($query, $user_region) {
                    if ($user_region->region_id != null) {
                        $query->where('employee_zone_id', $user_region->region_id);
                    }
                })
                ->when($user_division, function ($query, $user_division) {
                    if ($user_division->division_id != null) {
                        $query->where('employee_division_id', $user_division->division_id);
                    }
                })
                ->when($user_district, function ($query, $user_district) {
                    if ($user_district->district_id != null) {
                        $query->where('employee_district_id', $user_district->district_id);
                    }
                })
                ->when($user_upazila, function ($query, $user_upazila) {
                    if ($user_upazila->upazila_id != null) {
                        $query->where('employee_upazila_id', $user_upazila->upazila_id);
                    }
                })
                ->whereYear('posting_date', '=', date('Y'))
            // ->whereYear('posting_date', '=', 2022)
                ->whereMonth('posting_date', '=', $key)
            // ->when($request,function($query,$request){
            //     if($request->from_date!=null){
            //         $from_date = date("Y-m-d", strtotime($request->from_date));
            //         $query->where('posting_date', '>=', $from_date);
            //     }
            // })
            // ->when($request,function($query,$request){
            //     if($request->to_date!=null){
            //         $to_date = date("Y-m-d", strtotime($request->to_date));
            //         $query->where('posting_date', '<=', $to_date);
            //     }
            // })
                ->select('id')->get()->toArray();
            $selpcourtcasesupport = array_filter($incident_case, function ($item_case) {
                return isset($item_case['selpcourtcasesupport']) && !empty($item_case['selpcourtcasesupport']);
            });
            $direct_support[$value]['adr']  = count($survivordirectservice);
            $direct_support[$value]['case'] = count($selpcourtcasesupport);
        }
        $reindexed = array_values($direct_support);
        return response()->json($reindexed);
    }
    public function adrCaseFilter(Request $request) {

        $user_region   = $request->region_id;
        $user_division = $request->division_id;
        $user_district = $request->district_id;
        $user_upazila  = $request->upazila_id;

        $months = array(
            1  => "January",
            2  => "February",
            3  => "March",
            4  => "April",
            5  => "May",
            6  => "June",
            7  => "July",
            8  => "August",
            9  => "September",
            10 => "October",
            11 => "November",
            12 => "December",
        );

        foreach ($months as $key => $value) {
            // dd(date('Y'));
            $direct_support[$value]['month'] = $value;
            $incidents                       = SelpIncidentModel::with(['survivordirectservice'])
                ->when($user_region, function ($query, $user_region) {
                    if ($user_region != null) {
                        $query->where('employee_zone_id', $user_region);
                    }
                })
                ->when($user_division, function ($query, $user_division) {
                    if ($user_division != null) {
                        $query->where('employee_division_id', $user_division);
                    }
                })
                ->when($user_district, function ($query, $user_district) {
                    if ($user_district != null) {
                        $query->where('employee_district_id', $user_district);
                    }
                })
                ->when($user_upazila, function ($query, $user_upazila) {
                    if ($user_upazila != null) {
                        $query->where('employee_upazila_id', $user_upazila);
                    }
                })
                ->whereYear('posting_date', '=', date('Y'))
                ->whereMonth('posting_date', '=', $key)
                ->when($request, function ($query, $request) {
                    if ($request->from_date != null) {
                        $from_date = date("Y-m-d", strtotime($request->from_date));
                        $query->where('posting_date', '>=', $from_date);
                    }
                })
                ->when($request, function ($query, $request) {
                    if ($request->to_date != null) {
                        $to_date = date("Y-m-d", strtotime($request->to_date));
                        $query->where('posting_date', '<=', $to_date);
                    }
                })
                ->select('id')->get()->toArray();

            $survivordirectservice = array_filter($incidents, function ($item) {
                return isset($item['survivordirectservice']) && !empty($item['survivordirectservice']);
            });

            $incident_case = SelpIncidentModel::with(['selpcourtcasesupport'])
                ->when($user_region, function ($query, $user_region) {
                    if ($user_region != null) {
                        $query->where('employee_zone_id', $user_region);
                    }
                })
                ->when($user_division, function ($query, $user_division) {
                    if ($user_division != null) {
                        $query->where('employee_division_id', $user_division);
                    }
                })
                ->when($user_district, function ($query, $user_district) {
                    if ($user_district != null) {
                        $query->where('employee_district_id', $user_district);
                    }
                })
                ->when($user_upazila, function ($query, $user_upazila) {
                    if ($user_upazila != null) {
                        $query->where('employee_upazila_id', $user_upazila);
                    }
                })
                ->whereYear('posting_date', '=', date('Y'))
                ->whereMonth('posting_date', '=', $key)
                ->when($request, function ($query, $request) {
                    if ($request->from_date != null) {
                        $from_date = date("Y-m-d", strtotime($request->from_date));
                        $query->where('posting_date', '>=', $from_date);
                    }
                })
                ->when($request, function ($query, $request) {
                    if ($request->to_date != null) {
                        $to_date = date("Y-m-d", strtotime($request->to_date));
                        $query->where('posting_date', '<=', $to_date);
                    }
                })->select('id')->get()->toArray();

            $selpcourtcasesupport = array_filter($incident_case, function ($item_case) {
                return isset($item_case['selpcourtcasesupport']) && !empty($item_case['selpcourtcasesupport']);
            });
            $direct_support[$value]['adr']  = count($survivordirectservice);
            $direct_support[$value]['case'] = count($selpcourtcasesupport);
        }
        $reindexed = array_values($direct_support);
        return response()->json($reindexed);
    }

    public function index() {
        $date      = date('Y-m-d');
        $today     = date('Y-m-d');
        $tommorow  = date('Y-m-d', strtotime('+1 days', strtotime($today)));
        $divisions = session()->get('userareaaccess.sdivisions');
        $districts = session()->get('userareaaccess.sdistricts');
        $upazilas  = session()->get('userareaaccess.supazilas');
        // dd($divisions,$districts,$upazilas);

        if (count(session()->get('userareaaccess.sregions')) != 0) {
            $data['regions'] = Region::where('status', '1')->whereIn('id', session()->get('userareaaccess.sregions'))->get();
            $survivor        = SurvivorIncidentInformation::with(['gender']);
            if (!empty($divisions)) {
                $survivor->whereIn('employee_division_id', $divisions);
            }
            if (!empty($districts)) {
                $survivor->whereIn('employee_district_id', $districts);
            }
            // if (!empty($upazilas)) {
            //     $survivor->whereIn('employee_upazila_id', $upazilas);
            // }
            $data['survivor_count'] = $survivor->count();
            // $data['survivor_count']     = SurvivorIncidentInformation::whereIn('employee_division_id',session()->get('userareaaccess.sdivisions'))->count();
        } else {
            $data['regions']        = Region::where('status', '1')->get();
            $data['survivor_count'] = SurvivorIncidentInformation::count();
        }
        // dd($data['survivor_count']);

        $data['violenc_reasons']     = ViolenceReason::where('status', '1')->get();
        $data['violence_categories'] = ViolenceCategory::where('status', '1')->get();
        // $data['survivor_count']     = SurvivorIncidentInformation::count();
        $data['male_count'] = SurvivorIncidentInformation::whereHas('perpetrator_gender', function ($query) {
            $query->where('name', "Male");
        })->count();
        $data['female_count'] = SurvivorIncidentInformation::whereHas('perpetrator_gender', function ($query) {
            $query->where('name', "Female");
        })->count();
        $data['male_per']   = ($data['male_count'] * 100) / $data['survivor_count'];
        $data['female_per'] = ($data['female_count'] * 100) / $data['survivor_count'];

        $data['women_count'] = SurvivorIncidentInformation::whereHas('survivor_gender', function ($query) {
            $query->where('name', "Female");
        })->where('survivor_age', '>', 36)->count();
        $data['child_count']   = SurvivorIncidentInformation::whereBetween('survivor_age', [0, 12])->count();
        $data['women_per']     = ($data['women_count'] * 100) / $data['survivor_count'];
        $data['child_per']     = ($data['child_count'] * 100) / $data['survivor_count'];
        $today                 = date("Y-m-d");
        $this_month            = date(date("Y") . '-' . date("m") . '-01');
        $week                  = date("Y-m-d", strtotime('-7 days'));
        $data['today_count']   = SurvivorIncidentInformation::whereDate('created_at', $today)->count();
        $data['monthly_count'] = SurvivorIncidentInformation::whereBetween('created_at', [$this_month, $today])->count();
        $data['today_per']     = ($data['today_count'] * 100) / $data['survivor_count'];
        $data['monthly_per']   = ($data['monthly_count'] * 100) / $data['survivor_count'];
        return view('backend.dashboard');
        // return view('backend.admin-dashboard',$data);
    }

    public function tab1() {

        $date      = date('Y-m-d');
        $today     = date('Y-m-d');
        $tommorow  = date('Y-m-d', strtotime('+1 days', strtotime($today)));
        $divisions = session()->get('userareaaccess.sdivisions');
        $districts = session()->get('userareaaccess.sdistricts');
        $upazilas  = session()->get('userareaaccess.supazilas');
        // dd($divisions,$districts,$upazilas);

        $current_year           = date("Y");
        $current_year_start     = $current_year . '-01-01';
        $current_year_date      = date("Y-m-d");
        $start_year             = '2016-01-01';
        $previous_year_end      = $current_year - 1;
        $previous_year_end_date = $previous_year_end . '-12-31';
        // dd($previous_year_end_date);

        /*2016 to previous year*/
        // dd(session()->get('userareaaccess)));
        // dd(Auth::user());
        if (count(session()->get('userareaaccess.sregions')) != 0) {
            $data['regions'] = Region::where('status', '1')->whereIn('id', session()->get('userareaaccess.sregions'))->get();
            $survivor        = SurvivorIncidentInformation::whereHas('survivor_gender', function ($query) {
                $query->where('name', "Female");
            })->where('survivor_age', '>', 18)->whereBetween('violence_date', [$start_year, $previous_year_end_date]);
            if (!empty($divisions)) {
                $survivor->whereIn('employee_division_id', $divisions);
            }
            if (!empty($districts)) {
                $survivor->whereIn('employee_district_id', $districts);
            }
            $data['previous_data_survivor_women'] = $survivor->count();
        } else {
            $data['regions']                      = Region::where('status', '1')->get();
            $data['previous_data_survivor_women'] = SurvivorIncidentInformation::whereHas('survivor_gender', function ($query) {
                $query->where('name', "Female");
            })->where('survivor_age', '>', 18)->whereBetween('violence_date', [$start_year, $previous_year_end_date])->count();
        }

        /*2016 to previous year*/
        if (count(session()->get('userareaaccess.sregions')) != 0) {
            $data['regions'] = Region::where('status', '1')->whereIn('id', session()->get('userareaaccess.sregions'))->get();
            $survivor        = SurvivorIncidentInformation::whereHas('survivor_gender', function ($query) {
                $query->where('name', "Female");
            })->where('survivor_age', '<', 18)->whereBetween('violence_date', [$start_year, $previous_year_end_date]);
            if (!empty($divisions)) {
                $survivor->whereIn('employee_division_id', $divisions);
            }
            if (!empty($districts)) {
                $survivor->whereIn('employee_district_id', $districts);
            }
            $data['previous_data_survivor_girls'] = $survivor->count();
        } else {
            $data['regions']                      = Region::where('status', '1')->get();
            $data['previous_data_survivor_girls'] = SurvivorIncidentInformation::whereHas('survivor_gender', function ($query) {
                $query->where('name', "Female");
            })->where('survivor_age', '<=', 18)->whereBetween('violence_date', [$start_year, $previous_year_end_date])->count();
        }

        /*2016 to previous year*/
        if (count(session()->get('userareaaccess.sregions')) != 0) {
            $data['regions'] = Region::where('status', '1')->whereIn('id', session()->get('userareaaccess.sregions'))->get();
            $survivor        = SurvivorIncidentInformation::whereHas('survivor_gender', function ($query) {
                $query->where('name', "Male");
            })->where('survivor_age', '<=', 18)->whereBetween('violence_date', [$start_year, $previous_year_end_date]);
            if (!empty($divisions)) {
                $survivor->whereIn('employee_division_id', $divisions);
            }
            if (!empty($districts)) {
                $survivor->whereIn('employee_district_id', $districts);
            }
            $data['previous_data_survivor_boys'] = $survivor->count();
        } else {
            $data['regions']                     = Region::where('status', '1')->get();
            $data['previous_data_survivor_boys'] = SurvivorIncidentInformation::whereHas('survivor_gender', function ($query) {
                $query->where('name', "Male");
            })->where('survivor_age', '<=', 18)->whereBetween('violence_date', [$start_year, $previous_year_end_date])->count();
        }
        // $survivor = SurvivorIncidentInformation::whereHas('survivor_gender',function($query){
        //                                     $query->where('name', "Male");
        //                                 })->where('survivor_age', '<=', 18)->whereBetween('created_at', [$current_year_start.' 00:00:00',$current_year_date.' 23:59:59']);
        // $data['current_data_survivor_boys']= $survivor->count();
        // dd($data['current_data_survivor_boys']);

        /*current year*/
        if (count(session()->get('userareaaccess.sregions')) != 0) {
            $data['regions'] = Region::where('status', '1')->whereIn('id', session()->get('userareaaccess.sregions'))->get();
            $survivor        = SurvivorIncidentInformation::whereHas('survivor_gender', function ($query) {
                $query->where('name', "Female");
            })->where('survivor_age', '>', 18)->whereBetween('created_at', [$current_year_start . ' 00:00:00', $current_year_date . ' 23:59:59']);
            if (!empty($divisions)) {
                $survivor->whereIn('employee_division_id', $divisions);
            }
            if (!empty($districts)) {
                $survivor->whereIn('employee_district_id', $districts);
            }
            $data['current_data_survivor_women'] = $survivor->count();
        } else {
            $data['regions']                     = Region::where('status', '1')->get();
            $data['current_data_survivor_women'] = SurvivorIncidentInformation::whereHas('survivor_gender', function ($query) {
                $query->where('name', "Female");
            })->where('survivor_age', '>', 18)->whereBetween('created_at', [$current_year_start . ' 00:00:00', $current_year_date . ' 23:59:59'])->count();
        }

        /*current year*/
        if (count(session()->get('userareaaccess.sregions')) != 0) {
            $data['regions'] = Region::where('status', '1')->whereIn('id', session()->get('userareaaccess.sregions'))->get();
            $survivor        = SurvivorIncidentInformation::whereHas('survivor_gender', function ($query) {
                $query->where('name', "Female");
            })->where('survivor_age', '<=', 18)->whereBetween('created_at', [$current_year_start . ' 00:00:00', $current_year_date . ' 23:59:59']);
            if (!empty($divisions)) {
                $survivor->whereIn('employee_division_id', $divisions);
            }
            if (!empty($districts)) {
                $survivor->whereIn('employee_district_id', $districts);
            }
            $data['current_data_survivor_women_girls'] = $survivor->count();
        } else {
            $data['regions']                           = Region::where('status', '1')->get();
            $data['current_data_survivor_women_girls'] = SurvivorIncidentInformation::whereHas('survivor_gender', function ($query) {
                $query->where('name', "Female");
            })->where('survivor_age', '<=', 18)->whereBetween('created_at', [$current_year_start . ' 00:00:00', $current_year_date . ' 23:59:59'])->count();
        }

        /*current year*/
        if (count(session()->get('userareaaccess.sregions')) != 0) {
            $data['regions'] = Region::where('status', '1')->whereIn('id', session()->get('userareaaccess.sregions'))->get();
            $survivor        = SurvivorIncidentInformation::whereHas('survivor_gender', function ($query) {
                $query->where('name', "Male");
            })->where('survivor_age', '<=', 18)->whereBetween('created_at', [$current_year_start . ' 00:00:00', $current_year_date . ' 23:59:59']);
            if (!empty($divisions)) {
                $survivor->whereIn('employee_division_id', $divisions);
            }
            if (!empty($districts)) {
                $survivor->whereIn('employee_district_id', $districts);
            }
            $data['current_data_survivor_women_boys'] = $survivor->count();
        } else {
            $data['regions']                          = Region::where('status', '1')->get();
            $data['current_data_survivor_women_boys'] = SurvivorIncidentInformation::whereHas('survivor_gender', function ($query) {
                $query->where('name', "Male");
            })->where('survivor_age', '<=', 18)->whereBetween('created_at', [$current_year_start . ' 00:00:00', $current_year_date . ' 23:59:59'])->count();
        }

        // dd($data['current_data_survivor_women_boys']);
        // $survivor_1_to_10 = SurvivorIncidentInformation::whereBetween('survivor_age', [1,10])->whereBetween('created_at', [$current_year_start.' 00:00:00',$current_year_date.' 23:59:59'])->get()->count();
        // $survivor_11_to_14 = SurvivorIncidentInformation::whereBetween('survivor_age', [11,14])->whereBetween('created_at', [$current_year_start.' 00:00:00',$current_year_date.' 23:59:59'])->get()->count();
        // $survivor_15_to_18 = SurvivorIncidentInformation::whereBetween('survivor_age',  [15,18])->whereBetween('created_at', [$current_year_start.' 00:00:00',$current_year_date.' 23:59:59'])->get()->count();
        // dd($survivor_1_to_10,$survivor_11_to_14,$survivor_15_to_18);

        $data['violenc_reasons']     = ViolenceReason::where('status', '1')->get();
        $data['violence_categories'] = ViolenceCategory::where('status', '1')->get();
        // $data['survivor_count']     = SurvivorIncidentInformation::count();
        $data['male_count'] = SurvivorIncidentInformation::whereHas('perpetrator_gender', function ($query) {
            $query->where('name', "Male");
        })->count();
        $data['female_count'] = SurvivorIncidentInformation::whereHas('perpetrator_gender', function ($query) {
            $query->where('name', "Female");
        })->count();

        $data['women_count'] = SurvivorIncidentInformation::whereHas('survivor_gender', function ($query) {
            $query->where('name', "Female");
        })->where('survivor_age', '>', 36)->count();
        $data['child_count']   = SurvivorIncidentInformation::whereBetween('survivor_age', [0, 12])->count();
        $today                 = date("Y-m-d");
        $this_month            = date(date("Y") . '-' . date("m") . '-01');
        $week                  = date("Y-m-d", strtotime('-7 days'));
        $data['today_count']   = SurvivorIncidentInformation::whereDate('created_at', $today)->count();
        $data['monthly_count'] = SurvivorIncidentInformation::whereBetween('created_at', [$this_month, $today])->count();

        $data['survivors_get_supports'] = SurvivorIncidentInformation::select('id', 'survivor_gender_id')->whereHas('survivor_brac_support', function ($query) {
            $query->whereNotNull('survivor_final_support_id');
        })->count();

        $data['survivors_not_get_supports'] = SurvivorIncidentInformation::select('id', 'survivor_gender_id')->whereHas('survivor_brac_support', function ($query) {
            $query->whereNull('survivor_final_support_id');
        })->count();

        // dd($data['survivors_get_supports']);

        $data['current_year'] = date("Y");

        return view('backend.test-dashboard', $data);
    }

    public function tab2() {
        $date      = date('Y-m-d');
        $today     = date('Y-m-d');
        $tommorow  = date('Y-m-d', strtotime('+1 days', strtotime($today)));
        $divisions = session()->get('userareaaccess.sdivisions');
        $districts = session()->get('userareaaccess.sdistricts');
        $upazilas  = session()->get('userareaaccess.supazilas');

        $current_year           = date("Y");
        $current_year_start     = $current_year . '-01-01';
        $current_year_date      = date("Y-m-d");
        $start_year             = '2016-01-01';
        $previous_year_end      = $current_year - 1;
        $previous_year_end_date = $previous_year_end . '-12-31';
        // dd($previous_year_end_date);

        /*2016 to previous year*/
        if (count(session()->get('userareaaccess.sregions')) != 0) {
            $data['regions'] = Region::where('status', '1')->whereIn('id', session()->get('userareaaccess.sregions'))->get();
            $survivor        = SurvivorIncidentInformation::whereHas('survivor_gender', function ($query) {
                $query->where('name', "Female");
            })->where('survivor_age', '>', 18)->whereBetween('violence_date', [$start_year, $previous_year_end_date]);
            if (!empty($divisions)) {
                $survivor->whereIn('employee_division_id', $divisions);
            }
            if (!empty($districts)) {
                $survivor->whereIn('employee_district_id', $districts);
            }
            $data['previous_data_survivor_women'] = $survivor->count();
        } else {
            $data['regions']                      = Region::where('status', '1')->get();
            $data['previous_data_survivor_women'] = SurvivorIncidentInformation::whereHas('survivor_gender', function ($query) {
                $query->where('name', "Female");
            })->where('survivor_age', '>', 18)->whereBetween('violence_date', [$start_year, $previous_year_end_date])->count();
        }

        /*2016 to previous year*/
        if (count(session()->get('userareaaccess.sregions')) != 0) {
            $data['regions'] = Region::where('status', '1')->whereIn('id', session()->get('userareaaccess.sregions'))->get();
            $survivor        = SurvivorIncidentInformation::whereHas('survivor_gender', function ($query) {
                $query->where('name', "Female");
            })->where('survivor_age', '<', 18)->whereBetween('violence_date', [$start_year, $previous_year_end_date]);
            if (!empty($divisions)) {
                $survivor->whereIn('employee_division_id', $divisions);
            }
            if (!empty($districts)) {
                $survivor->whereIn('employee_district_id', $districts);
            }
            $data['previous_data_survivor_girls'] = $survivor->count();
        } else {
            $data['regions']                      = Region::where('status', '1')->get();
            $data['previous_data_survivor_girls'] = SurvivorIncidentInformation::whereHas('survivor_gender', function ($query) {
                $query->where('name', "Female");
            })->where('survivor_age', '<', 18)->whereBetween('violence_date', [$start_year, $previous_year_end_date])->count();
        }

        /*2016 to previous year*/
        if (count(session()->get('userareaaccess.sregions')) != 0) {
            $data['regions'] = Region::where('status', '1')->whereIn('id', session()->get('userareaaccess.sregions'))->get();
            $survivor        = SurvivorIncidentInformation::whereHas('survivor_gender', function ($query) {
                $query->where('name', "Male");
            })->where('survivor_age', '<', 18)->whereBetween('violence_date', [$start_year, $previous_year_end_date]);
            if (!empty($divisions)) {
                $survivor->whereIn('employee_division_id', $divisions);
            }
            if (!empty($districts)) {
                $survivor->whereIn('employee_district_id', $districts);
            }
            $data['previous_data_survivor_boys'] = $survivor->count();
        } else {
            $data['regions']                     = Region::where('status', '1')->get();
            $data['previous_data_survivor_boys'] = SurvivorIncidentInformation::whereHas('survivor_gender', function ($query) {
                $query->where('name', "Male");
            })->where('survivor_age', '<', 18)->whereBetween('violence_date', [$start_year, $previous_year_end_date])->count();
        }

        /*current year*/
        if (count(session()->get('userareaaccess.sregions')) != 0) {
            $data['regions'] = Region::where('status', '1')->whereIn('id', session()->get('userareaaccess.sregions'))->get();
            $survivor        = SurvivorIncidentInformation::whereHas('survivor_gender', function ($query) {
                $query->where('name', "Female");
            })->where('survivor_age', '>', 18)->whereBetween('violence_date', [$current_year_start, $current_year_date]);
            if (!empty($divisions)) {
                $survivor->whereIn('employee_division_id', $divisions);
            }
            if (!empty($districts)) {
                $survivor->whereIn('employee_district_id', $districts);
            }
            $data['current_data_survivor_women'] = $survivor->count();
        } else {
            $data['regions']                     = Region::where('status', '1')->get();
            $data['current_data_survivor_women'] = SurvivorIncidentInformation::whereHas('survivor_gender', function ($query) {
                $query->where('name', "Female");
            })->where('survivor_age', '>', 18)->whereBetween('violence_date', [$current_year_start, $current_year_date])->count();
        }

        /*current year*/
        if (count(session()->get('userareaaccess.sregions')) != 0) {
            $data['regions'] = Region::where('status', '1')->whereIn('id', session()->get('userareaaccess.sregions'))->get();
            $survivor        = SurvivorIncidentInformation::whereHas('survivor_gender', function ($query) {
                $query->where('name', "Female");
            })->where('survivor_age', '<', 18)->whereBetween('violence_date', [$current_year_start, $current_year_date]);
            if (!empty($divisions)) {
                $survivor->whereIn('employee_division_id', $divisions);
            }
            if (!empty($districts)) {
                $survivor->whereIn('employee_district_id', $districts);
            }
            $data['current_data_survivor_women_girls'] = $survivor->count();
        } else {
            $data['regions']                           = Region::where('status', '1')->get();
            $data['current_data_survivor_women_girls'] = SurvivorIncidentInformation::whereHas('survivor_gender', function ($query) {
                $query->where('name', "Female");
            })->where('survivor_age', '<', 18)->whereBetween('violence_date', [$current_year_start, $current_year_date])->count();
        }

        /*current year*/
        if (count(session()->get('userareaaccess.sregions')) != 0) {
            $data['regions'] = Region::where('status', '1')->whereIn('id', session()->get('userareaaccess.sregions'))->get();
            $survivor        = SurvivorIncidentInformation::whereHas('survivor_gender', function ($query) {
                $query->where('name', "Male");
            })->where('survivor_age', '<', 18)->whereBetween('violence_date', [$current_year_start, $current_year_date]);
            if (!empty($divisions)) {
                $survivor->whereIn('employee_division_id', $divisions);
            }
            if (!empty($districts)) {
                $survivor->whereIn('employee_district_id', $districts);
            }
            $data['current_data_survivor_women_boys'] = $survivor->count();
        } else {
            $data['regions']                          = Region::where('status', '1')->get();
            $data['current_data_survivor_women_boys'] = SurvivorIncidentInformation::whereHas('survivor_gender', function ($query) {
                $query->where('name', "Male");
            })->where('survivor_age', '<', 18)->whereBetween('violence_date', [$current_year_start, $current_year_date])->count();
        }

        $data['violenc_reasons']     = ViolenceReason::where('status', '1')->get();
        $data['violence_categories'] = ViolenceCategory::where('status', '1')->get();
        // $data['survivor_count']     = SurvivorIncidentInformation::count();
        $data['male_count'] = SurvivorIncidentInformation::whereHas('perpetrator_gender', function ($query) {
            $query->where('name', "Male");
        })->count();
        $data['female_count'] = SurvivorIncidentInformation::whereHas('perpetrator_gender', function ($query) {
            $query->where('name', "Female");
        })->count();

        $data['women_count'] = SurvivorIncidentInformation::whereHas('survivor_gender', function ($query) {
            $query->where('name', "Female");
        })->where('survivor_age', '>', 36)->count();
        $data['child_count']   = SurvivorIncidentInformation::whereBetween('survivor_age', [0, 12])->count();
        $today                 = date("Y-m-d");
        $this_month            = date(date("Y") . '-' . date("m") . '-01');
        $week                  = date("Y-m-d", strtotime('-7 days'));
        $data['today_count']   = SurvivorIncidentInformation::whereDate('created_at', $today)->count();
        $data['monthly_count'] = SurvivorIncidentInformation::whereBetween('created_at', [$this_month, $today])->count();
        $data['current_year']  = date("Y");

        return view('backend.tab2', $data);
    }

    public function tab3() {
        $date      = date('Y-m-d');
        $today     = date('Y-m-d');
        $tommorow  = date('Y-m-d', strtotime('+1 days', strtotime($today)));
        $divisions = session()->get('userareaaccess.sdivisions');
        $districts = session()->get('userareaaccess.sdistricts');
        $upazilas  = session()->get('userareaaccess.supazilas');

        $current_year           = date("Y");
        $current_year_start     = $current_year . '-01-01';
        $current_year_date      = date("Y-m-d");
        $start_year             = '2016-01-01';
        $previous_year_end      = $current_year - 1;
        $previous_year_end_date = $previous_year_end . '-12-31';
        // dd($previous_year_end_date);

        /*current year*/
        if (count(session()->get('userareaaccess.sregions')) != 0) {
            $data['regions'] = Region::where('status', '1')->whereIn('id', session()->get('userareaaccess.sregions'))->get();
            $survivor        = SurvivorIncidentInformation::whereHas('perpetrator_relationship', function ($query) {
                $query->where('name', "Husband");
            })->where('survivor_age', '>', 18)->whereBetween('violence_date', [$current_year_start, $current_year_date]);
            if (!empty($divisions)) {
                $survivor->whereIn('employee_division_id', $divisions);
            }
            if (!empty($districts)) {
                $survivor->whereIn('employee_district_id', $districts);
            }
            $data['current_data_perpetrator_husband'] = $survivor->count();
        } else {
            $data['regions']                          = Region::where('status', '1')->get();
            $data['current_data_perpetrator_husband'] = SurvivorIncidentInformation::whereHas('perpetrator_relationship', function ($query) {
                $query->where('name', "Husband");
            })->where('survivor_age', '>', 18)->whereBetween('violence_date', [$current_year_start, $current_year_date])->count();
        }

        /*current year*/
        if (count(session()->get('userareaaccess.sregions')) != 0) {
            $data['regions'] = Region::where('status', '1')->whereIn('id', session()->get('userareaaccess.sregions'))->get();
            $survivor        = SurvivorIncidentInformation::where('perpetrator_relationship_id', 1)->where('survivor_age', '<', 18)->whereBetween('violence_date', [$current_year_start, $current_year_date]);
            if (!empty($divisions)) {
                $survivor->whereIn('employee_division_id', $divisions);
            }
            if (!empty($districts)) {
                $survivor->whereIn('employee_district_id', $districts);
            }
            $data['current_data_perpetrator_in_laws'] = $survivor->count();
        } else {
            $data['regions']                          = Region::where('status', '1')->get();
            $data['current_data_perpetrator_in_laws'] = SurvivorIncidentInformation::where('perpetrator_relationship_id', 1)->where('survivor_age', '<', 18)->whereBetween('violence_date', [$current_year_start, $current_year_date])->count();
        }

        /*current year*/
        if (count(session()->get('userareaaccess.sregions')) != 0) {
            $data['regions'] = Region::where('status', '1')->whereIn('id', session()->get('userareaaccess.sregions'))->get();
            $survivor        = SurvivorIncidentInformation::whereHas('perpetrator_relationship', function ($query) {
                $query->where('name', "Neighbor");
            })->whereBetween('violence_date', [$current_year_start, $current_year_date]);
            if (!empty($divisions)) {
                $survivor->whereIn('employee_division_id', $divisions);
            }
            if (!empty($districts)) {
                $survivor->whereIn('employee_district_id', $districts);
            }
            $data['current_data_perpetrator_neighbor'] = $survivor->count();
        } else {
            $data['regions']                           = Region::where('status', '1')->get();
            $data['current_data_perpetrator_neighbor'] = SurvivorIncidentInformation::whereHas('perpetrator_relationship', function ($query) {
                $query->where('name', "Neighbor");
            })->whereBetween('violence_date', [$current_year_start, $current_year_date])->count();
        }

        /*current year*/
        if (count(session()->get('userareaaccess.sregions')) != 0) {
            $data['regions'] = Region::where('status', '1')->whereIn('id', session()->get('userareaaccess.sregions'))->get();
            $survivor        = SurvivorIncidentInformation::whereHas('perpetrator_relationship', function ($query) {
                $query->where('name', "Acquaintance");
            })->whereBetween('violence_date', [$current_year_start, $current_year_date]);
            if (!empty($divisions)) {
                $survivor->whereIn('employee_division_id', $divisions);
            }
            if (!empty($districts)) {
                $survivor->whereIn('employee_district_id', $districts);
            }
            $data['current_data_perpetrator_acquaintance'] = $survivor->count();
        } else {
            $data['regions']                               = Region::where('status', '1')->get();
            $data['current_data_perpetrator_acquaintance'] = SurvivorIncidentInformation::whereHas('perpetrator_relationship', function ($query) {
                $query->where('name', "Acquaintance");
            })->whereBetween('violence_date', [$current_year_start, $current_year_date])->count();
        }

        /*current year*/
        if (count(session()->get('userareaaccess.sregions')) != 0) {
            $data['regions'] = Region::where('status', '1')->whereIn('id', session()->get('userareaaccess.sregions'))->get();
            $survivor        = SurvivorIncidentInformation::whereHas('perpetrator_relationship', function ($query) {
                $query->where('name', "Relative");
            })->whereBetween('violence_date', [$current_year_start, $current_year_date]);
            if (!empty($divisions)) {
                $survivor->whereIn('employee_division_id', $divisions);
            }
            if (!empty($districts)) {
                $survivor->whereIn('employee_district_id', $districts);
            }
            $data['current_data_perpetrator_relative'] = $survivor->count();
        } else {
            $data['regions']                           = Region::where('status', '1')->get();
            $data['current_data_perpetrator_relative'] = SurvivorIncidentInformation::whereHas('perpetrator_relationship', function ($query) {
                $query->where('name', "Relative");
            })->whereBetween('violence_date', [$current_year_start, $current_year_date])->count();
        }

        $data['violenc_reasons']     = ViolenceReason::where('status', '1')->get();
        $data['violence_categories'] = ViolenceCategory::where('status', '1')->get();
        // $data['survivor_count']     = SurvivorIncidentInformation::count();
        $data['male_count'] = SurvivorIncidentInformation::whereHas('perpetrator_gender', function ($query) {
            $query->where('name', "Male");
        })->count();
        $data['female_count'] = SurvivorIncidentInformation::whereHas('perpetrator_gender', function ($query) {
            $query->where('name', "Female");
        })->count();

        $data['women_count'] = SurvivorIncidentInformation::whereHas('survivor_gender', function ($query) {
            $query->where('name', "Female");
        })->where('survivor_age', '>', 36)->count();
        $data['child_count']   = SurvivorIncidentInformation::whereBetween('survivor_age', [0, 12])->count();
        $today                 = date("Y-m-d");
        $this_month            = date(date("Y") . '-' . date("m") . '-01');
        $week                  = date("Y-m-d", strtotime('-7 days'));
        $data['today_count']   = SurvivorIncidentInformation::whereDate('created_at', $today)->count();
        $data['monthly_count'] = SurvivorIncidentInformation::whereBetween('created_at', [$this_month, $today])->count();
        $data['current_year']  = date("Y");

        return view('backend.tab3', $data);
    }

    public function tab4() {
        $date      = date('Y-m-d');
        $today     = date('Y-m-d');
        $tommorow  = date('Y-m-d', strtotime('+1 days', strtotime($today)));
        $divisions = session()->get('userareaaccess.sdivisions');
        $districts = session()->get('userareaaccess.sdistricts');
        $upazilas  = session()->get('userareaaccess.supazilas');

        $current_year           = date("Y");
        $current_year_start     = $current_year . '-01-01';
        $current_year_date      = date("Y-m-d");
        $start_year             = '2016-01-01';
        $previous_year_end      = $current_year - 1;
        $previous_year_end_date = $previous_year_end . '-12-31';
        // dd($previous_year_end_date);

        // $survivor = SurvivorIncidentInformation::pluck('id');
        // $support = SurvivorBracSupport::whereIn('survivor_incident_info_id', $survivor)->count();
        // dd($support);

        /*2016 to previous year*/
        if (count(session()->get('userareaaccess.sregions')) != 0) {
            $data['regions'] = Region::where('status', '1')->whereIn('id', session()->get('userareaaccess.sregions'))->get();
            $survivor        = SurvivorIncidentInformation::whereBetween('violence_date', [$start_year, $previous_year_end_date]);
            if (!empty($divisions)) {
                $survivor->whereIn('employee_division_id', $divisions);
            }
            if (!empty($districts)) {
                $survivor->whereIn('employee_district_id', $districts);
            }
            $survivor_id                   = $survivor->pluck('id');
            $data['total_support_service'] = SurvivorBracSupport::whereIn('survivor_incident_info_id', $survivor_id)->count();
        } else {
            $data['regions']               = Region::where('status', '1')->get();
            $survivor_id                   = SurvivorIncidentInformation::whereBetween('violence_date', [$start_year, $previous_year_end_date])->pluck('id');
            $data['total_support_service'] = SurvivorBracSupport::whereIn('survivor_incident_info_id', $survivor_id)->count();
        }

        /*2016 to previous year*/
        if (count(session()->get('userareaaccess.sregions')) != 0) {
            $data['regions'] = Region::where('status', '1')->whereIn('id', session()->get('userareaaccess.sregions'))->get();
            $survivor        = SurvivorIncidentInformation::whereBetween('violence_date', [$start_year, $previous_year_end_date]);
            if (!empty($divisions)) {
                $survivor->whereIn('employee_division_id', $divisions);
            }
            if (!empty($districts)) {
                $survivor->whereIn('employee_district_id', $districts);
            }
            $survivor_id                = $survivor->pluck('id');
            $data['total_brac_support'] = SurvivorBracSupport::whereIn('survivor_incident_info_id', $survivor_id)->count();
        } else {
            $data['regions']            = Region::where('status', '1')->get();
            $survivor_id                = SurvivorIncidentInformation::whereBetween('violence_date', [$start_year, $previous_year_end_date])->pluck('id');
            $data['total_brac_support'] = SurvivorBracSupport::whereIn('survivor_incident_info_id', $survivor_id)->count();
        }

        /*2016 to previous year*/
        if (count(session()->get('userareaaccess.sregions')) != 0) {
            $data['regions'] = Region::where('status', '1')->whereIn('id', session()->get('userareaaccess.sregions'))->get();
            $survivor        = SurvivorIncidentInformation::whereBetween('violence_date', [$start_year, $previous_year_end_date]);
            if (!empty($divisions)) {
                $survivor->whereIn('employee_division_id', $divisions);
            }
            if (!empty($districts)) {
                $survivor->whereIn('employee_district_id', $districts);
            }
            $survivor_id                 = $survivor->pluck('id');
            $data['total_other_support'] = SurvivorOtherOrganizationSupport::whereIn('survivor_incident_info_id', $survivor_id)->count();
        } else {
            $data['regions']             = Region::where('status', '1')->get();
            $survivor_id                 = SurvivorIncidentInformation::whereBetween('violence_date', [$start_year, $previous_year_end_date])->pluck('id');
            $data['total_other_support'] = SurvivorOtherOrganizationSupport::whereIn('survivor_incident_info_id', $survivor_id)->count();
        }

        /*current year*/
        if (count(session()->get('userareaaccess.sregions')) != 0) {
            $data['regions'] = Region::where('status', '1')->whereIn('id', session()->get('userareaaccess.sregions'))->get();
            $survivor        = SurvivorIncidentInformation::whereBetween('violence_date', [$current_year_start, $current_year_date]);
            if (!empty($divisions)) {
                $survivor->whereIn('employee_division_id', $divisions);
            }
            if (!empty($districts)) {
                $survivor->whereIn('employee_district_id', $districts);
            }
            $survivor_id                          = $survivor->pluck('id');
            $data['previous_total_other_support'] = SurvivorOtherOrganizationSupport::whereIn('survivor_incident_info_id', $survivor_id)->count();
        } else {
            $data['regions']                      = Region::where('status', '1')->get();
            $survivor_id                          = SurvivorIncidentInformation::whereBetween('violence_date', [$current_year_start, $current_year_date])->pluck('id');
            $data['previous_total_other_support'] = SurvivorOtherOrganizationSupport::whereIn('survivor_incident_info_id', $survivor_id)->count();
        }

        if (count(session()->get('userareaaccess.sregions')) != 0) {
            $data['regions'] = Region::where('status', '1')->whereIn('id', session()->get('userareaaccess.sregions'))->get();
            $survivor        = SurvivorIncidentInformation::whereBetween('violence_date', [$current_year_start, $current_year_date]);
            if (!empty($divisions)) {
                $survivor->whereIn('employee_division_id', $divisions);
            }
            if (!empty($districts)) {
                $survivor->whereIn('employee_district_id', $districts);
            }
            $survivor_id                         = $survivor->pluck('id');
            $data['previous_total_brac_support'] = SurvivorBracSupport::whereIn('survivor_incident_info_id', $survivor_id)->count();
        } else {
            $data['regions']                     = Region::where('status', '1')->get();
            $survivor_id                         = SurvivorIncidentInformation::whereBetween('violence_date', [$current_year_start, $current_year_date])->pluck('id');
            $data['previous_total_brac_support'] = SurvivorBracSupport::whereIn('survivor_incident_info_id', $survivor_id)->count();
        }

        if (count(session()->get('userareaaccess.sregions')) != 0) {
            $data['regions'] = Region::where('status', '1')->whereIn('id', session()->get('userareaaccess.sregions'))->get();
            $survivor        = SurvivorIncidentInformation::whereBetween('violence_date', [$current_year_start, $current_year_date]);
            if (!empty($divisions)) {
                $survivor->whereIn('employee_division_id', $divisions);
            }
            if (!empty($districts)) {
                $survivor->whereIn('employee_district_id', $districts);
            }
            $survivor_id                    = $survivor->pluck('id');
            $data['previous_total_support'] = SurvivorBracSupport::whereIn('survivor_incident_info_id', $survivor_id)->count();
        } else {
            $data['regions']                = Region::where('status', '1')->get();
            $survivor_id                    = SurvivorIncidentInformation::whereBetween('violence_date', [$current_year_start, $current_year_date])->pluck('id');
            $data['previous_total_support'] = SurvivorBracSupport::whereIn('survivor_incident_info_id', $survivor_id)->count();
        }

        $data['violenc_reasons']     = ViolenceReason::where('status', '1')->get();
        $data['violence_categories'] = ViolenceCategory::where('status', '1')->get();
        // $data['survivor_count']     = SurvivorIncidentInformation::count();
        $data['male_count'] = SurvivorIncidentInformation::whereHas('perpetrator_gender', function ($query) {
            $query->where('name', "Male");
        })->count();
        $data['female_count'] = SurvivorIncidentInformation::whereHas('perpetrator_gender', function ($query) {
            $query->where('name', "Female");
        })->count();

        $data['women_count'] = SurvivorIncidentInformation::whereHas('survivor_gender', function ($query) {
            $query->where('name', "Female");
        })->where('survivor_age', '>', 36)->count();
        $data['child_count']   = SurvivorIncidentInformation::whereBetween('survivor_age', [0, 12])->count();
        $today                 = date("Y-m-d");
        $this_month            = date(date("Y") . '-' . date("m") . '-01');
        $week                  = date("Y-m-d", strtotime('-7 days'));
        $data['today_count']   = SurvivorIncidentInformation::whereDate('created_at', $today)->count();
        $data['monthly_count'] = SurvivorIncidentInformation::whereBetween('created_at', [$this_month, $today])->count();

        $data['survivor_physical_treatment']    = SurvivorBracSupport::where('survivor_final_support_id', 2)->whereBetween('survivor_support_date', [$current_year_start, $current_year_date])->count();
        $data['survivor_psychological']         = SurvivorBracSupport::where('survivor_final_support_id', [3, 8, 9, 10, 19])->whereBetween('survivor_support_date', [$current_year_start, $current_year_date])->count();
        $data['survivor_legal_aid']             = SurvivorBracSupport::where('survivor_final_support_id', 14)->whereBetween('survivor_support_date', [$current_year_start, $current_year_date])->count();
        $data['survivor_social_reintegration']  = SurvivorBracSupport::where('survivor_final_support_id', 14)->whereBetween('survivor_support_date', [$current_year_start, $current_year_date])->count();
        $data['survivor_social_rehabilitation'] = SurvivorBracSupport::where('survivor_final_support_id', 7)->whereBetween('survivor_support_date', [$current_year_start, $current_year_date])->count();
        $data['current_year']                   = date("Y");

        return view('backend.tab4', $data);
    }

    public function getchart1(Request $request) {
        $where[] = ['status', '=', '1'];
        $wherein = [];

        if ($request->region_id != '') {
            $allDistrict = RegionAreaDetail::where('region_id', $request->region_id)->where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        }
        if ($request->division_id != '') {
            $where[] = ['survivor_division_id', '=', $request->division_id];
        }
        if ($request->district_id != '') {
            $where[] = ['survivor_district_id', '=', $request->district_id];
        }

        // if($request->start_date !=''){
        //     $where[] = ['violence_date','=>',date('Y-m-d',strtotime($request->start_date))];
        // }
        // if($request->end_date !=''){
        //     $where[] = ['violence_date','=<',date('Y-m-d',strtotime($request->end_date))];
        // }

        $html = [];

        if ($request->district_id != null) {
            foreach (SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id', $wherein)->groupBy('violence_category_id')->get() as $keyy => $violence_cat) {
                $countsurvivor = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id', $wherein)->where([['survivor_district_id', $violence_cat->survivor_district_id], ['violence_category_id', $violence_cat->violence_category_id]])->count();
                if ($violence_cat['violencecategoryname']['name'] != null && $countsurvivor != 0) {
                    $html[$keyy]['horizontal']                                             = $violence_cat['violencecategoryname']['name'];
                    $html[$keyy][$violence_cat['violencecategoryname']['name']]            = $countsurvivor;
                    $html['harasment_type'][$violence_cat['violencecategoryname']['name']] = $violence_cat['violencecategoryname']['name'];
                }
            }
        } else {
            foreach (SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id', $wherein)->groupBy('survivor_district_id')->get() as $key => $survivor) {
                foreach (SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id', $wherein)->groupBy('violence_category_id')->get() as $keyy => $violence_cat) {
                    $countsurvivor = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id', $wherein)->where([['survivor_district_id', $survivor->survivor_district_id], ['violence_category_id', $violence_cat->violence_category_id]])->count();
                    if ($violence_cat['violencecategoryname']['name'] != null && $countsurvivor != 0) {
                        $html[$key]['horizontal']                                              = $survivor['survivor_district']['name'];
                        $html[$key][$violence_cat['violencecategoryname']['name']]             = $countsurvivor;
                        $html['harasment_type'][$violence_cat['violencecategoryname']['name']] = $violence_cat['violencecategoryname']['name'];
                    }
                }
            }
        }
        // dd($wherein,$where,$html);
        return response()->json($html);
    }

    public function getchart2(Request $request) {
        $where[]    = ['status', '=', '1'];
        $wherein    = [];
        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date   = date('Y-m-d', strtotime($request->end_date));

        $current_year = date('Y');

        $from_current_year = $current_year . '-01-01';
        $current_date      = date('Y-m-d');

        if ($request->region_id != '') {
            $allDistrict = RegionAreaDetail::where('region_id', $request->region_id)->where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        } else {
            $allDistrict = RegionAreaDetail::where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        }
        if ($request->division_id != '') {
            $where[] = ['survivor_division_id', '=', $request->division_id];
        }
        if ($request->district_id != '') {
            $where[] = ['survivor_district_id', '=', $request->district_id];
        }

        // if($request->start_date !=''){
        //     $where[] = ['violence_date','=>',date('Y-m-d',strtotime($request->start_date))];
        // }
        // if($request->end_date !=''){
        //     $where[] = ['violence_date','=<',date('Y-m-d',strtotime($request->end_date))];
        // }
        if ($request->violence_category_id != '') {
            $where[] = ['violence_category_id', '=', $request->violence_category_id];
        }
        if ($request->violence_sub_category_id != '') {
            $where[] = ['violence_sub_category_id', '=', $request->violence_sub_category_id];
        }
        if ($request->violence_name_id != '') {
            $where[] = ['violence_name_id', '=', $request->violence_name_id];
        }

        $html = [];

        $survivor_incident_information_plucks = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$from_current_year, $current_date])->whereIn('survivor_district_id', $wherein)->get()->pluck('violence_reason_id')->toArray();

        $arraymergedata = [];
        foreach ($survivor_incident_information_plucks as $key => $survivor_incident_information_pluck) {
            $othersarraydata = explode(',', $survivor_incident_information_pluck);
            $arraymergedata  = array_merge($arraymergedata, $othersarraydata);
        }
        $survivor_incident_information = array_filter(array_unique($arraymergedata));
        $i                             = 0;
        foreach ($survivor_incident_information as $keyy => $violence_reason) {
            // $countsurvivor = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id',$wherein)->where('violence_reason_id','like','%'.$violence_reason.'%')->count();

            $countsurvivor = SurvivorIncidentInformation::where(function ($query) use ($where, $wherein, $violence_reason, $from_current_year, $current_date) {
                $query->where($where)
                    ->whereIn('survivor_district_id', $wherein)
                    ->whereBetween('created_at', [$from_current_year . ' 00:00:00', $current_date . ' 23:59:59'])
                    ->where('violence_reason_id', 'like', '%,' . $violence_reason . '%');
            })->orWhere(function ($query) use ($where, $wherein, $violence_reason, $from_current_year, $current_date) {
                $query->where($where)
                    ->whereIn('survivor_district_id', $wherein)
                    ->whereBetween('created_at', [$from_current_year . ' 00:00:00', $current_date . ' 23:59:59'])
                    ->where('violence_reason_id', 'like', '%' . $violence_reason . ',%');
            })->orWhere(function ($query) use ($where, $wherein, $violence_reason, $from_current_year, $current_date) {
                $query->where($where)
                    ->whereIn('survivor_district_id', $wherein)
                    ->whereBetween('created_at', [$from_current_year . ' 00:00:00', $current_date . ' 23:59:59'])
                    ->where('violence_reason_id', $violence_reason);
            })->count();

            $violence_name = ViolenceReason::find($violence_reason)['name'];
            if ($countsurvivor != 0 && $violence_name != null) {
                $i++;
                $html[$countsurvivor . $i]['pie_category'] = $violence_name;
                $html[$countsurvivor . $i]['pie_count']    = $countsurvivor;
            }
        }

        krsort($html);
        $ss = array_slice($html, 0, 5);

        return response()->json($ss);
    }

    public function getchart21(Request $request) {
        $where[]    = ['status', '=', '1'];
        $wherein    = [];
        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date   = date('Y-m-d', strtotime($request->end_date));

        $current_year = date('Y');

        $from_current_year = $current_year . '-01-01';
        $current_date      = date('Y-m-d');

        if ($request->region_id != '') {
            $allDistrict = RegionAreaDetail::where('region_id', $request->region_id)->where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        } else {
            $allDistrict = RegionAreaDetail::where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        }
        if ($request->division_id != '') {
            $where[] = ['survivor_division_id', '=', $request->division_id];
        }
        if ($request->district_id != '') {
            $where[] = ['survivor_district_id', '=', $request->district_id];
        }

        // if($request->start_date !=''){
        //     $where[] = ['violence_date','=>',date('Y-m-d',strtotime($request->start_date))];
        // }
        // if($request->end_date !=''){
        //     $where[] = ['violence_date','=<',date('Y-m-d',strtotime($request->end_date))];
        // }
        if ($request->violence_category_id != '') {
            $where[] = ['violence_category_id', '=', $request->violence_category_id];
        }
        if ($request->violence_sub_category_id != '') {
            $where[] = ['violence_sub_category_id', '=', $request->violence_sub_category_id];
        }
        if ($request->violence_name_id != '') {
            $where[] = ['violence_name_id', '=', $request->violence_name_id];
        }

        $html = [];

        $survivor_incident_information_plucks = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$from_current_year, $current_date])->whereIn('survivor_district_id', $wherein)->get()->pluck('violence_category_id')->toArray();
        $arraymergedata                       = [];
        foreach ($survivor_incident_information_plucks as $key => $survivor_incident_information_pluck) {
            $othersarraydata = explode(',', $survivor_incident_information_pluck);
            $arraymergedata  = array_merge($arraymergedata, $othersarraydata);
        }
        $survivor_incident_information = array_filter(array_unique($arraymergedata));
        // dd($survivor_incident_information);
        $i = 0;
        foreach ($survivor_incident_information as $keyy => $violence_reason) {
            // $countsurvivor = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id',$wherein)->where('violence_category_id','like','%'.$violence_reason.'%')->count();

            $countsurvivor = SurvivorIncidentInformation::where(function ($query) use ($where, $wherein, $violence_reason, $from_current_year, $current_date) {
                $query->where($where)
                    ->whereIn('survivor_district_id', $wherein)
                    ->whereBetween('created_at', [$from_current_year . ' 00:00:00', $current_date . ' 23:59:59'])
                    ->where('violence_category_id', 'like', '%,' . $violence_reason . '%');
            })->orWhere(function ($query) use ($where, $wherein, $violence_reason, $from_current_year, $current_date) {
                $query->where($where)
                    ->whereIn('survivor_district_id', $wherein)
                    ->whereBetween('created_at', [$from_current_year . ' 00:00:00', $current_date . ' 23:59:59'])
                    ->where('violence_category_id', 'like', '%' . $violence_reason . ',%');
            })->orWhere(function ($query) use ($where, $wherein, $violence_reason, $from_current_year, $current_date) {
                $query->where($where)
                    ->whereIn('survivor_district_id', $wherein)
                    ->whereBetween('created_at', [$from_current_year . ' 00:00:00', $current_date . ' 23:59:59'])
                    ->where('violence_category_id', $violence_reason);
            })->count();

            $violence_name = ViolenceCategory::find($violence_reason)['name'];
            if ($countsurvivor != 0 && $violence_name != null) {
                $i++;
                $html[$countsurvivor . $i]['pie_category'] = $violence_name;
                $html[$countsurvivor . $i]['pie_count']    = $countsurvivor;
            }
        }
        // dd($html);
        krsort($html);
        $ss = array_slice($html, 0, 5);

        return response()->json($ss);
    }

    public function getchart3(Request $request) {
        $where[]    = ['status', '=', '1'];
        $wherein    = [];
        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date   = date('Y-m-d', strtotime($request->end_date));

        if ($request->region_id != '') {
            $allDistrict = RegionAreaDetail::where('region_id', $request->region_id)->where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        } else {
            $allDistrict = RegionAreaDetail::where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        }
        if ($request->division_id != '') {
            $where[] = ['survivor_division_id', '=', $request->division_id];
        }
        if ($request->district_id != '') {
            $where[] = ['survivor_district_id', '=', $request->district_id];
        }

        // if($request->start_date !=''){
        //     $where[] = ['violence_date','=>',date('Y-m-d',strtotime($request->start_date))];
        // }
        // if($request->end_date !=''){
        //     $where[] = ['violence_date','=<',date('Y-m-d',strtotime($request->end_date))];
        // }
        if ($request->violence_category_id != '') {
            $where[] = ['violence_category_id', '=', $request->violence_category_id];
        }
        if ($request->violence_sub_category_id != '') {
            $where[] = ['violence_sub_category_id', '=', $request->violence_sub_category_id];
        }
        if ($request->violence_name_id != '') {
            $where[] = ['violence_name_id', '=', $request->violence_name_id];
        }

        $html = [];

        $survivor_incident_information = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$start_date, $end_date])->whereIn('survivor_district_id', $wherein)->get()->pluck('survivor_autistic_id')->toArray();

        $survivor_incident_informations = array_filter(array_unique($survivor_incident_information));
        // dd($survivor_incident_informations);

        foreach ($survivor_incident_informations as $keyy => $autistic) {
            // dd($autistic);
            // $countsurvivor = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id',$wherein)->where('autistic_id','like','%'.$autistic.'%')->count();

            $countsurvivor = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$start_date, $end_date])->whereIn('survivor_district_id', $wherein)->where('survivor_autistic_id', $autistic)->get()->count();
            // dd($countsurvivor);

            $autistic_name = SurvivorAutisticInformation::find($autistic)['name'];
            // if($countsurvivor != 0 && $autistic_name != null){
            $html[$keyy]['pie_category'] = $autistic_name;
            $html[$keyy]['pie_count']    = $countsurvivor;
            // }

        }
        // dd($html);
        return response()->json($html);

    }

    public function getchart4(Request $request) {
        $where[]            = ['status', '=', '1'];
        $wherein            = [];
        $start_date         = date('Y-m-d', strtotime($request->start_date));
        $end_date           = date('Y-m-d', strtotime($request->end_date));
        $current_year       = date("Y");
        $current_year_start = $current_year . '-01-01';
        $current_year_date  = date("Y-m-d");

        if ($request->region_id != '') {
            $allDistrict = RegionAreaDetail::where('region_id', $request->region_id)->where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        } else {
            $allDistrict = RegionAreaDetail::where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        }
        if ($request->division_id != '') {
            $where[] = ['survivor_division_id', '=', $request->division_id];
        }
        if ($request->district_id != '') {
            $where[] = ['survivor_district_id', '=', $request->district_id];
        }

        // if($request->start_date !=''){
        //     $where[] = ['violence_date','=>',date('Y-m-d',strtotime($request->start_date))];
        // }
        // if($request->end_date !=''){
        //     $where[] = ['violence_date','=<',date('Y-m-d',strtotime($request->end_date))];
        // }
        if ($request->violence_category_id != '') {
            $where[] = ['violence_category_id', '=', $request->violence_category_id];
        }
        if ($request->violence_sub_category_id != '') {
            $where[] = ['violence_sub_category_id', '=', $request->violence_sub_category_id];
        }
        if ($request->violence_name_id != '') {
            $where[] = ['violence_name_id', '=', $request->violence_name_id];
        }

        $html = [];

        $survivor_1_to_10  = SurvivorIncidentInformation::whereIn('survivor_gender_id', [1, 2])->whereBetween('survivor_age', [1, 10])->whereBetween('created_at', [$current_year_start . ' 00:00:00', $current_year_date . ' 23:59:59'])->get()->count();
        $survivor_11_to_14 = SurvivorIncidentInformation::whereIn('survivor_gender_id', [1, 2])->whereBetween('survivor_age', [11, 14])->whereBetween('created_at', [$current_year_start . ' 00:00:00', $current_year_date . ' 23:59:59'])->get()->count();
        $survivor_15_to_18 = SurvivorIncidentInformation::whereIn('survivor_gender_id', [1, 2])->whereBetween('survivor_age', [15, 18])->whereBetween('created_at', [$current_year_start . ' 00:00:00', $current_year_date . ' 23:59:59'])->get()->count();
        // dd($survivor_1_to_10,$survivor_11_to_14,$survivor_15_to_18);

        $html[0]['age_group_name']  = '1 - 10';
        $html[0]['age_group_total'] = $survivor_1_to_10;

        $html[1]['age_group_name']  = '11 - 14';
        $html[1]['age_group_total'] = $survivor_11_to_14;

        $html[2]['age_group_name']  = '15 - 18';
        $html[2]['age_group_total'] = $survivor_15_to_18;
        return response()->json($html);

    }

    public function getchart22(Request $request) {
        $where[]    = ['status', '=', '1'];
        $wherein    = [];
        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date   = date('Y-m-d', strtotime($request->end_date));

        if ($request->region_id != '') {
            $allDistrict = RegionAreaDetail::where('region_id', $request->region_id)->where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        } else {
            $allDistrict = RegionAreaDetail::where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        }
        if ($request->division_id != '') {
            $where[] = ['survivor_division_id', '=', $request->division_id];
        }
        if ($request->district_id != '') {
            $where[] = ['survivor_district_id', '=', $request->district_id];
        }

        // if($request->start_date !=''){
        //     $where[] = ['violence_date','=>',date('Y-m-d',strtotime($request->start_date))];
        // }
        // if($request->end_date !=''){
        //     $where[] = ['violence_date','=<',date('Y-m-d',strtotime($request->end_date))];
        // }
        if ($request->violence_category_id != '') {
            $where[] = ['violence_category_id', '=', $request->violence_category_id];
        }
        if ($request->violence_sub_category_id != '') {
            $where[] = ['violence_sub_category_id', '=', $request->violence_sub_category_id];
        }
        if ($request->violence_name_id != '') {
            $where[] = ['violence_name_id', '=', $request->violence_name_id];
        }

        $html = [];

        $survivor_physical_treatment    = SurvivorBracSupport::where('survivor_final_support_id', 2)->count();
        $survivor_psychological         = SurvivorBracSupport::where('survivor_final_support_id', [3, 8, 9, 10, 19])->count();
        $survivor_legal_aid             = SurvivorBracSupport::where('survivor_final_support_id', 14)->count();
        $survivor_social_reintegration  = SurvivorBracSupport::where('survivor_final_support_id', 14)->count();
        $survivor_social_rehabilitation = SurvivorBracSupport::where('survivor_final_support_id', [7, 16])->count();
        // dd($survivor_0_to_17,$survivor_18_to_35,$survivor_36_to_above);

        $html[0]['pie_category'] = 'Physical Treatment';
        $html[0]['pie_count']    = $survivor_physical_treatment;

        $html[1]['pie_category'] = 'Psychological';
        $html[1]['pie_count']    = $survivor_psychological;

        $html[2]['pie_category'] = 'Legal Aid';
        $html[2]['pie_count']    = $survivor_legal_aid;

        $html[3]['pie_category'] = 'Social Reintegration';
        $html[3]['pie_count']    = $survivor_social_reintegration;

        $html[4]['pie_category'] = 'Social Rehabilitation';
        $html[4]['pie_count']    = $survivor_social_rehabilitation;
        return response()->json($html);

    }

    public function getchart11(Request $request) {
        $where[]            = ['status', '=', '1'];
        $wherein            = [];
        $start_date         = date('Y-m-d', strtotime($request->start_date));
        $end_date           = date('Y-m-d', strtotime($request->end_date));
        $current_year       = date("Y");
        $current_year_start = $current_year . '-01-01';
        $current_year_date  = date("Y-m-d");

        if ($request->region_id != '') {
            $allDistrict = RegionAreaDetail::where('region_id', $request->region_id)->where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        } else {
            $allDistrict = RegionAreaDetail::where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        }
        if ($request->division_id != '') {
            $where[] = ['survivor_division_id', '=', $request->division_id];
        }
        if ($request->district_id != '') {
            $where[] = ['survivor_district_id', '=', $request->district_id];
        }

        // if($request->start_date !=''){
        //     $where[] = ['violence_date','=>',date('Y-m-d',strtotime($request->start_date))];
        // }
        // if($request->end_date !=''){
        //     $where[] = ['violence_date','=<',date('Y-m-d',strtotime($request->end_date))];
        // }
        if ($request->violence_category_id != '') {
            $where[] = ['violence_category_id', '=', $request->violence_category_id];
        }
        if ($request->violence_sub_category_id != '') {
            $where[] = ['violence_sub_category_id', '=', $request->violence_sub_category_id];
        }
        if ($request->violence_name_id != '') {
            $where[] = ['violence_name_id', '=', $request->violence_name_id];
        }

        $html = [];

        $survivor_19_to_25    = SurvivorIncidentInformation::where('survivor_gender_id', 2)->whereBetween('survivor_age', [19, 25])->whereBetween('created_at', [$current_year_start . ' 00:00:00', $current_year_date . ' 23:59:59'])->get()->count();
        $survivor_26_to_35    = SurvivorIncidentInformation::where('survivor_gender_id', 2)->whereBetween('survivor_age', [26, 35])->whereBetween('created_at', [$current_year_start . ' 00:00:00', $current_year_date . ' 23:59:59'])->get()->count();
        $survivor_36_to_45    = SurvivorIncidentInformation::where('survivor_gender_id', 2)->whereBetween('survivor_age', [36, 45])->whereBetween('created_at', [$current_year_start . ' 00:00:00', $current_year_date . ' 23:59:59'])->get()->count();
        $survivor_46_to_above = SurvivorIncidentInformation::where('survivor_gender_id', 2)->where('survivor_age', '>=', 46)->whereBetween('created_at', [$current_year_start . ' 00:00:00', $current_year_date . ' 23:59:59'])->get()->count();
        // dd($survivor_0_to_17,$survivor_18_to_35,$survivor_36_to_above);

        $html[0]['age_group_name']  = '19 - 25';
        $html[0]['age_group_total'] = $survivor_19_to_25;

        $html[1]['age_group_name']  = '26 - 35';
        $html[1]['age_group_total'] = $survivor_26_to_35;

        $html[2]['age_group_name']  = '36 - 45';
        $html[2]['age_group_total'] = $survivor_36_to_45;

        $html[3]['age_group_name']  = '46 - Above';
        $html[3]['age_group_total'] = $survivor_46_to_above;
        return response()->json($html);

    }

    public function getchart5(Request $request) {
        $where[]    = ['status', '=', '1'];
        $wherein    = [];
        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date   = date('Y-m-d', strtotime($request->end_date));

        if ($request->region_id != '') {
            $allDistrict = RegionAreaDetail::where('region_id', $request->region_id)->where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        } else {
            $allDistrict = RegionAreaDetail::where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        }
        if ($request->division_id != '') {
            $where[] = ['survivor_division_id', '=', $request->division_id];
        }
        if ($request->district_id != '') {
            $where[] = ['survivor_district_id', '=', $request->district_id];
        }

        // if($request->start_date !=''){
        //     $where[] = ['violence_date','=>',date('Y-m-d',strtotime($request->start_date))];
        // }
        // if($request->end_date !=''){
        //     $where[] = ['violence_date','=<',date('Y-m-d',strtotime($request->end_date))];
        // }
        if ($request->violence_category_id != '') {
            $where[] = ['violence_category_id', '=', $request->violence_category_id];
        }
        if ($request->violence_sub_category_id != '') {
            $where[] = ['violence_sub_category_id', '=', $request->violence_sub_category_id];
        }
        if ($request->violence_name_id != '') {
            $where[] = ['violence_name_id', '=', $request->violence_name_id];
        }

        $html = [];

        $perpetrator_1_to_18     = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$start_date, $end_date])->whereBetween('perpetrator_age', [1, 18])->whereIn('survivor_district_id', $wherein)->get()->count();
        $perpetrator_19_to_24    = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$start_date, $end_date])->whereBetween('perpetrator_age', [19, 24])->whereIn('survivor_district_id', $wherein)->get()->count();
        $perpetrator_25_to_35    = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$start_date, $end_date])->whereBetween('perpetrator_age', [25, 35])->whereIn('survivor_district_id', $wherein)->get()->count();
        $perpetrator_36_to_45    = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$start_date, $end_date])->whereBetween('perpetrator_age', [36, 45])->whereIn('survivor_district_id', $wherein)->get()->count();
        $perpetrator_46_to_60    = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$start_date, $end_date])->whereBetween('perpetrator_age', [46, 60])->whereIn('survivor_district_id', $wherein)->get()->count();
        $perpetrator_61_to_above = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$start_date, $end_date])->where('perpetrator_age', '>', 60)->whereIn('survivor_district_id', $wherein)->get()->count();
        // dd($survivor_0_to_17,$survivor_18_to_35,$survivor_36_to_above);

        $html[0]['age_group_name']  = '1 - 18';
        $html[0]['age_group_total'] = $perpetrator_1_to_18;

        $html[1]['age_group_name']  = '19 - 24';
        $html[1]['age_group_total'] = $perpetrator_19_to_24;

        $html[2]['age_group_name']  = '25 - 35';
        $html[2]['age_group_total'] = $perpetrator_25_to_35;

        $html[3]['age_group_name']  = '36 - 45';
        $html[3]['age_group_total'] = $perpetrator_36_to_45;

        $html[4]['age_group_name']  = '46 - 60';
        $html[4]['age_group_total'] = $perpetrator_46_to_60;

        $html[5]['age_group_name']  = '60 - above';
        $html[5]['age_group_total'] = $perpetrator_61_to_above;
        return response()->json($html);

    }

    public function getchart6(Request $request) {
        $where[]    = ['status', '=', '1'];
        $wherein    = [];
        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date   = date('Y-m-d', strtotime($request->end_date));

        if ($request->region_id != '') {
            $allDistrict = RegionAreaDetail::where('region_id', $request->region_id)->where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        } else {
            $allDistrict = RegionAreaDetail::where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        }
        if ($request->division_id != '') {
            $where[] = ['survivor_division_id', '=', $request->division_id];
        }
        if ($request->district_id != '') {
            $where[] = ['survivor_district_id', '=', $request->district_id];
        }

        // if($request->start_date !=''){
        //     $where[] = ['violence_date','=>',date('Y-m-d',strtotime($request->start_date))];
        // }
        // if($request->end_date !=''){
        //     $where[] = ['violence_date','=<',date('Y-m-d',strtotime($request->end_date))];
        // }
        if ($request->violence_category_id != '') {
            $where[] = ['violence_category_id', '=', $request->violence_category_id];
        }
        if ($request->violence_sub_category_id != '') {
            $where[] = ['violence_sub_category_id', '=', $request->violence_sub_category_id];
        }
        if ($request->violence_name_id != '') {
            $where[] = ['violence_name_id', '=', $request->violence_name_id];
        }

        $html = [];

        $survivor_incident_information = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$start_date, $end_date])->whereIn('survivor_district_id', $wherein)->get()->pluck('perpetrator_relationship_id')->toArray();

        $survivor_incident_informations = array_filter(array_unique($survivor_incident_information));
        // dd($survivor_incident_informations);
        $i = 0;

        foreach ($survivor_incident_informations as $keyy => $p_relationship) {
            // dd($autistic);
            // $countsurvivor = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id',$wherein)->where('autistic_id','like','%'.$autistic.'%')->count();

            $countsurvivor = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$start_date, $end_date])->whereIn('survivor_district_id', $wherein)->where('perpetrator_relationship_id', $p_relationship)->get()->count();
            // dd($countsurvivor);

            $p_relationship_name = SurvivorRelationship::find($p_relationship)['name'];
            // if($countsurvivor != 0 && $autistic_name != null){
            $i++;
            $html[$countsurvivor . $i]['pie_category'] = $p_relationship_name;
            $html[$countsurvivor . $i]['pie_count']    = $countsurvivor;
            // }

        }

        krsort($html);
        $ss = array_slice($html, 0, 5);

        return response()->json($ss);
        // dd($html);
        // return response()->json($html);

    }

    public function getchart12(Request $request) {
        $where[]    = ['status', '=', '1'];
        $wherein    = [];
        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date   = date('Y-m-d', strtotime($request->end_date));

        if ($request->region_id != '') {
            $allDistrict = RegionAreaDetail::where('region_id', $request->region_id)->where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        } else {
            $allDistrict = RegionAreaDetail::where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        }
        if ($request->division_id != '') {
            $where[] = ['survivor_division_id', '=', $request->division_id];
        }
        if ($request->district_id != '') {
            $where[] = ['survivor_district_id', '=', $request->district_id];
        }

        // if($request->start_date !=''){
        //     $where[] = ['violence_date','=>',date('Y-m-d',strtotime($request->start_date))];
        // }
        // if($request->end_date !=''){
        //     $where[] = ['violence_date','=<',date('Y-m-d',strtotime($request->end_date))];
        // }
        if ($request->violence_category_id != '') {
            $where[] = ['violence_category_id', '=', $request->violence_category_id];
        }
        if ($request->violence_sub_category_id != '') {
            $where[] = ['violence_sub_category_id', '=', $request->violence_sub_category_id];
        }
        if ($request->violence_name_id != '') {
            $where[] = ['violence_name_id', '=', $request->violence_name_id];
        }

        $html = [];

        $survivor_incident_information = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$start_date, $end_date])->whereIn('survivor_district_id', $wherein)->get()->pluck('survivor_marital_status_id')->toArray();

        $survivor_incident_informations = array_filter(array_unique($survivor_incident_information));
        // dd($survivor_incident_informations);
        $i = 0;

        foreach ($survivor_incident_informations as $keyy => $p_relationship) {
            // dd($autistic);
            // $countsurvivor = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id',$wherein)->where('autistic_id','like','%'.$autistic.'%')->count();

            $countsurvivor = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$start_date, $end_date])->whereIn('survivor_district_id', $wherein)->where('survivor_marital_status_id', $p_relationship)->get()->count();
            // dd($countsurvivor);

            $p_relationship_name = MaritalStatus::find($p_relationship)['name'];
            // if($countsurvivor != 0 && $autistic_name != null){
            $i++;
            $html[$countsurvivor . $i]['pie_category'] = $p_relationship_name;
            $html[$countsurvivor . $i]['pie_count']    = $countsurvivor;
            // }

        }

        krsort($html);
        $ss = array_slice($html, 0, 5);

        return response()->json($ss);
        // dd($html);
        // return response()->json($html);

    }

    public function getchart13(Request $request) {
        $where[]    = ['status', '=', '1'];
        $wherein    = [];
        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date   = date('Y-m-d', strtotime($request->end_date));

        if ($request->region_id != '') {
            $allDistrict = RegionAreaDetail::where('region_id', $request->region_id)->where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        } else {
            $allDistrict = RegionAreaDetail::where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        }
        if ($request->division_id != '') {
            $where[] = ['survivor_division_id', '=', $request->division_id];
        }
        if ($request->district_id != '') {
            $where[] = ['survivor_district_id', '=', $request->district_id];
        }

        // if($request->start_date !=''){
        //     $where[] = ['violence_date','=>',date('Y-m-d',strtotime($request->start_date))];
        // }
        // if($request->end_date !=''){
        //     $where[] = ['violence_date','=<',date('Y-m-d',strtotime($request->end_date))];
        // }
        if ($request->violence_category_id != '') {
            $where[] = ['violence_category_id', '=', $request->violence_category_id];
        }
        if ($request->violence_sub_category_id != '') {
            $where[] = ['violence_sub_category_id', '=', $request->violence_sub_category_id];
        }
        if ($request->violence_name_id != '') {
            $where[] = ['violence_name_id', '=', $request->violence_name_id];
        }

        $html = [];

        $survivor_incident_information = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$start_date, $end_date])->whereIn('survivor_district_id', $wherein)->get()->pluck('perpetrator_marital_status_id')->toArray();

        $survivor_incident_informations = array_filter(array_unique($survivor_incident_information));
        // dd($survivor_incident_informations);
        $i = 0;

        foreach ($survivor_incident_informations as $keyy => $p_relationship) {
            // dd($autistic);
            // $countsurvivor = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id',$wherein)->where('autistic_id','like','%'.$autistic.'%')->count();

            $countsurvivor = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$start_date, $end_date])->whereIn('survivor_district_id', $wherein)->where('perpetrator_marital_status_id', $p_relationship)->get()->count();
            // dd($countsurvivor);

            $p_relationship_name = MaritalStatus::find($p_relationship)['name'];
            // if($countsurvivor != 0 && $autistic_name != null){
            $i++;
            $html[$countsurvivor . $i]['pie_category'] = $p_relationship_name;
            $html[$countsurvivor . $i]['pie_count']    = $countsurvivor;
            // }

        }

        krsort($html);
        $ss = array_slice($html, 0, 5);

        return response()->json($ss);
        // dd($html);
        // return response()->json($html);

    }

    public function getchart14(Request $request) {
        $where[]    = ['status', '=', '1'];
        $wherein    = [];
        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date   = date('Y-m-d', strtotime($request->end_date));

        if ($request->region_id != '') {
            $allDistrict = RegionAreaDetail::where('region_id', $request->region_id)->where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        } else {
            $allDistrict = RegionAreaDetail::where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        }
        if ($request->division_id != '') {
            $where[] = ['survivor_division_id', '=', $request->division_id];
        }
        if ($request->district_id != '') {
            $where[] = ['survivor_district_id', '=', $request->district_id];
        }

        // if($request->start_date !=''){
        //     $where[] = ['violence_date','=>',date('Y-m-d',strtotime($request->start_date))];
        // }
        // if($request->end_date !=''){
        //     $where[] = ['violence_date','=<',date('Y-m-d',strtotime($request->end_date))];
        // }
        if ($request->violence_category_id != '') {
            $where[] = ['violence_category_id', '=', $request->violence_category_id];
        }
        if ($request->violence_sub_category_id != '') {
            $where[] = ['violence_sub_category_id', '=', $request->violence_sub_category_id];
        }
        if ($request->violence_name_id != '') {
            $where[] = ['violence_name_id', '=', $request->violence_name_id];
        }

        $html = [];

        $survivor_incident_information = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$start_date, $end_date])->whereIn('survivor_district_id', $wherein)->get()->pluck('survivor_occupation_id')->toArray();

        $survivor_incident_informations = array_filter(array_unique($survivor_incident_information));
        // dd($survivor_incident_informations);
        $i = 0;

        foreach ($survivor_incident_informations as $keyy => $p_relationship) {
            // dd($autistic);
            // $countsurvivor = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id',$wherein)->where('autistic_id','like','%'.$autistic.'%')->count();

            $countsurvivor = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$start_date, $end_date])->whereIn('survivor_district_id', $wherein)->where('survivor_occupation_id', $p_relationship)->get()->count();
            // dd($countsurvivor);

            $p_relationship_name = Occupation::find($p_relationship)['name'];
            // if($countsurvivor != 0 && $autistic_name != null){
            $i++;
            $html[$countsurvivor . $i]['pie_category'] = $p_relationship_name;
            $html[$countsurvivor . $i]['pie_count']    = $countsurvivor;
            // }

        }

        krsort($html);
        $ss = array_slice($html, 0, 5);

        return response()->json($ss);
        // dd($html);
        // return response()->json($html);

    }

    public function getchart15(Request $request) {
        $where[]    = ['status', '=', '1'];
        $wherein    = [];
        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date   = date('Y-m-d', strtotime($request->end_date));

        if ($request->region_id != '') {
            $allDistrict = RegionAreaDetail::where('region_id', $request->region_id)->where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        } else {
            $allDistrict = RegionAreaDetail::where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        }
        if ($request->division_id != '') {
            $where[] = ['survivor_division_id', '=', $request->division_id];
        }
        if ($request->district_id != '') {
            $where[] = ['survivor_district_id', '=', $request->district_id];
        }

        // if($request->start_date !=''){
        //     $where[] = ['violence_date','=>',date('Y-m-d',strtotime($request->start_date))];
        // }
        // if($request->end_date !=''){
        //     $where[] = ['violence_date','=<',date('Y-m-d',strtotime($request->end_date))];
        // }
        if ($request->violence_category_id != '') {
            $where[] = ['violence_category_id', '=', $request->violence_category_id];
        }
        if ($request->violence_sub_category_id != '') {
            $where[] = ['violence_sub_category_id', '=', $request->violence_sub_category_id];
        }
        if ($request->violence_name_id != '') {
            $where[] = ['violence_name_id', '=', $request->violence_name_id];
        }

        $html = [];

        $survivor_incident_information = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$start_date, $end_date])->whereIn('survivor_district_id', $wherein)->get()->pluck('perpetrator_occupation_id')->toArray();

        $survivor_incident_informations = array_filter(array_unique($survivor_incident_information));
        // dd($survivor_incident_informations);
        $i = 0;

        foreach ($survivor_incident_informations as $keyy => $p_relationship) {
            // dd($autistic);
            // $countsurvivor = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id',$wherein)->where('autistic_id','like','%'.$autistic.'%')->count();

            $countsurvivor = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$start_date, $end_date])->whereIn('survivor_district_id', $wherein)->where('perpetrator_occupation_id', $p_relationship)->get()->count();
            // dd($countsurvivor);

            $p_relationship_name = Occupation::find($p_relationship)['name'];
            // if($countsurvivor != 0 && $autistic_name != null){
            $i++;
            $html[$countsurvivor . $i]['pie_category'] = $p_relationship_name;
            $html[$countsurvivor . $i]['pie_count']    = $countsurvivor;
            // }

        }

        krsort($html);
        $ss = array_slice($html, 0, 5);

        return response()->json($ss);
        // dd($html);
        // return response()->json($html);

    }

    public function getchart16(Request $request) {
        $where[]    = ['status', '=', '1'];
        $wherein    = [];
        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date   = date('Y-m-d', strtotime($request->end_date));

        if ($request->region_id != '') {
            $allDistrict = RegionAreaDetail::where('region_id', $request->region_id)->where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        } else {
            $allDistrict = RegionAreaDetail::where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        }
        if ($request->division_id != '') {
            $where[] = ['survivor_division_id', '=', $request->division_id];
        }
        if ($request->district_id != '') {
            $where[] = ['survivor_district_id', '=', $request->district_id];
        }

        // if($request->start_date !=''){
        //     $where[] = ['violence_date','=>',date('Y-m-d',strtotime($request->start_date))];
        // }
        // if($request->end_date !=''){
        //     $where[] = ['violence_date','=<',date('Y-m-d',strtotime($request->end_date))];
        // }
        if ($request->violence_category_id != '') {
            $where[] = ['violence_category_id', '=', $request->violence_category_id];
        }
        if ($request->violence_sub_category_id != '') {
            $where[] = ['violence_sub_category_id', '=', $request->violence_sub_category_id];
        }
        if ($request->violence_name_id != '') {
            $where[] = ['violence_name_id', '=', $request->violence_name_id];
        }

        $html = [];

        $survivor_incident_information = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$start_date, $end_date])->whereIn('survivor_district_id', $wherein)->get()->pluck('perpetrator_relationship_id')->toArray();

        $survivor_incident_informations = array_filter(array_unique($survivor_incident_information));
        // dd($survivor_incident_informations);
        $i = 0;

        foreach ($survivor_incident_informations as $keyy => $p_relationship) {
            // dd($autistic);
            // $countsurvivor = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id',$wherein)->where('autistic_id','like','%'.$autistic.'%')->count();

            $countsurvivor = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$start_date, $end_date])->whereIn('survivor_district_id', $wherein)->where('perpetrator_relationship_id', $p_relationship)->get()->count();
            // dd($countsurvivor);

            $p_relationship_name = FamilyMember::find($p_relationship)['name'];
            // if($countsurvivor != 0 && $autistic_name != null){
            $i++;
            $html[$countsurvivor . $i]['pie_category'] = $p_relationship_name;
            $html[$countsurvivor . $i]['pie_count']    = $countsurvivor;
            // }

        }

        krsort($html);
        $ss = array_slice($html, 0, 5);

        return response()->json($ss);
        // dd($html);
        // return response()->json($html);

    }

    public function getchart17(Request $request) {
        $where[]    = ['status', '=', '1'];
        $wherein    = [];
        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date   = date('Y-m-d', strtotime($request->end_date));

        if ($request->region_id != '') {
            $allDistrict = RegionAreaDetail::where('region_id', $request->region_id)->where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        } else {
            $allDistrict = RegionAreaDetail::where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        }
        if ($request->division_id != '') {
            $where[] = ['survivor_division_id', '=', $request->division_id];
        }
        if ($request->district_id != '') {
            $where[] = ['survivor_district_id', '=', $request->district_id];
        }

        // if($request->start_date !=''){
        //     $where[] = ['violence_date','=>',date('Y-m-d',strtotime($request->start_date))];
        // }
        // if($request->end_date !=''){
        //     $where[] = ['violence_date','=<',date('Y-m-d',strtotime($request->end_date))];
        // }
        if ($request->violence_category_id != '') {
            $where[] = ['violence_category_id', '=', $request->violence_category_id];
        }
        if ($request->violence_sub_category_id != '') {
            $where[] = ['violence_sub_category_id', '=', $request->violence_sub_category_id];
        }
        if ($request->violence_name_id != '') {
            $where[] = ['violence_name_id', '=', $request->violence_name_id];
        }

        $html = [];

        $survivor_incident_information = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$start_date, $end_date])->whereIn('survivor_district_id', $wherein)->get()->pluck('not_filing_reason')->toArray();

        $survivor_incident_informations = array_filter(array_unique($survivor_incident_information));
        // dd($survivor_incident_informations);
        $i = 0;

        foreach ($survivor_incident_informations as $keyy => $p_relationship) {
            // dd($autistic);
            // $countsurvivor = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id',$wherein)->where('autistic_id','like','%'.$autistic.'%')->count();

            $countsurvivor = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$start_date, $end_date])->whereIn('survivor_district_id', $wherein)->where('not_filing_reason', $p_relationship)->get()->count();
            // dd($countsurvivor);

            $p_relationship_name = LegelInitiativeReason::find($p_relationship)['name'];
            // if($countsurvivor != 0 && $autistic_name != null){
            $i++;
            $html[$countsurvivor . $i]['pie_category'] = $p_relationship_name;
            $html[$countsurvivor . $i]['pie_count']    = $countsurvivor;
            // }

        }

        krsort($html);
        $ss = array_slice($html, 0, 5);

        return response()->json($ss);
        // dd($html);
        // return response()->json($html);

    }

    public function getchart18(Request $request) {
        $where[]    = ['status', '=', '1'];
        $wherein    = [];
        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date   = date('Y-m-d', strtotime($request->end_date));

        if ($request->region_id != '') {
            $allDistrict = RegionAreaDetail::where('region_id', $request->region_id)->where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        } else {
            $allDistrict = RegionAreaDetail::where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        }
        if ($request->division_id != '') {
            $where[] = ['survivor_division_id', '=', $request->division_id];
        }
        if ($request->district_id != '') {
            $where[] = ['survivor_district_id', '=', $request->district_id];
        }
        if ($request->violence_category_id != '') {
            $where[] = ['violence_category_id', '=', $request->violence_category_id];
        }
        if ($request->violence_sub_category_id != '') {
            $where[] = ['violence_sub_category_id', '=', $request->violence_sub_category_id];
        }
        if ($request->violence_name_id != '') {
            $where[] = ['violence_name_id', '=', $request->violence_name_id];
        }

        $html = [];

        $survivor_incident_information = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$start_date, $end_date])->whereIn('survivor_district_id', $wherein)->get()->pluck('survivor_situation_id')->toArray();

        // dd($survivor_incident_information);
        $survivor_incident_informations = array_filter(array_unique($survivor_incident_information));
        $i                              = 0;

        foreach ($survivor_incident_informations as $keyy => $p_relationship) {
            $countsurvivor = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$start_date, $end_date])->whereIn('survivor_district_id', $wherein)->where('survivor_situation_id', $p_relationship)->get()->count();
            // dd($countsurvivor);

            $p_relationship_name = SurvivorSituation::find($p_relationship)['name'];
            // if($countsurvivor != 0 && $autistic_name != null){
            $i++;
            $html[$countsurvivor . $i]['pie_category'] = $p_relationship_name;
            $html[$countsurvivor . $i]['pie_count']    = $countsurvivor;
            // }

        }

        krsort($html);
        $ss = array_slice($html, 0, 5);

        return response()->json($ss);
        // dd($html);
        // return response()->json($html);

    }

    public function getchart7(Request $request) {
        $where[]    = ['status', '=', '1'];
        $wherein    = [];
        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date   = date('Y-m-d', strtotime($request->end_date));

        if ($request->region_id != '') {
            $allDistrict = RegionAreaDetail::where('region_id', $request->region_id)->where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        } else {
            $allDistrict = RegionAreaDetail::where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        }
        if ($request->division_id != '') {
            $where[] = ['survivor_division_id', '=', $request->division_id];
        }
        if ($request->district_id != '') {
            $where[] = ['survivor_district_id', '=', $request->district_id];
        }

        // if($request->start_date !=''){
        //     $where[] = ['violence_date','=>',date('Y-m-d',strtotime($request->start_date))];
        // }
        // if($request->end_date !=''){
        //     $where[] = ['violence_date','=<',date('Y-m-d',strtotime($request->end_date))];
        // }
        if ($request->violence_category_id != '') {
            $where[] = ['violence_category_id', '=', $request->violence_category_id];
        }
        if ($request->violence_sub_category_id != '') {
            $where[] = ['violence_sub_category_id', '=', $request->violence_sub_category_id];
        }
        if ($request->violence_name_id != '') {
            $where[] = ['violence_name_id', '=', $request->violence_name_id];
        }

        $html = [];

        $survivor_incident_information = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$start_date, $end_date])->whereIn('survivor_district_id', $wherein)->get()->pluck('perpetrator_place_id')->toArray();

        $survivor_incident_informations = array_filter(array_unique($survivor_incident_information));
        // dd($survivor_incident_informations);

        foreach ($survivor_incident_informations as $keyy => $p_place) {
            // dd($autistic);
            // $countsurvivor = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id',$wherein)->where('autistic_id','like','%'.$autistic.'%')->count();

            $countsurvivor = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$start_date, $end_date])->whereIn('survivor_district_id', $wherein)->where('perpetrator_place_id', $p_place)->get()->count();
            // dd($countsurvivor);

            $place_name = PerpetratorPlace::find($p_place)['name'];
            // if($countsurvivor != 0 && $autistic_name != null){
            $html[$keyy]['pie_category'] = $place_name;
            $html[$keyy]['pie_count']    = $countsurvivor;
            // }

        }
        // dd($html);
        return response()->json($html);

    }

    public function getchart8(Request $request) {
        $where[]    = ['status', '=', '1'];
        $wherein    = [];
        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date   = date('Y-m-d', strtotime($request->end_date));

        if ($request->region_id != '') {
            $allDistrict = RegionAreaDetail::where('region_id', $request->region_id)->where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        } else {
            $allDistrict = RegionAreaDetail::where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        }
        if ($request->division_id != '') {
            $where[] = ['survivor_division_id', '=', $request->division_id];
        }
        if ($request->district_id != '') {
            $where[] = ['survivor_district_id', '=', $request->district_id];
        }

        // if($request->start_date !=''){
        //     $where[] = ['violence_date','=>',date('Y-m-d',strtotime($request->start_date))];
        // }
        // if($request->end_date !=''){
        //     $where[] = ['violence_date','=<',date('Y-m-d',strtotime($request->end_date))];
        // }
        if ($request->violence_category_id != '') {
            $where[] = ['violence_category_id', '=', $request->violence_category_id];
        }
        if ($request->violence_sub_category_id != '') {
            $where[] = ['violence_sub_category_id', '=', $request->violence_sub_category_id];
        }
        if ($request->violence_name_id != '') {
            $where[] = ['violence_name_id', '=', $request->violence_name_id];
        }

        $html = [];

        $survivor_incident_information = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$start_date, $end_date])->whereIn('survivor_district_id', $wherein)->get()->pluck('violence_place_id')->toArray();

        $survivor_incident_informations = array_filter(array_unique($survivor_incident_information));

        foreach ($survivor_incident_informations as $keyy => $violence_place) {
            // dd($autistic);
            // $countsurvivor = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id',$wherein)->where('autistic_id','like','%'.$autistic.'%')->count();

            $countsurvivor = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$start_date, $end_date])->whereIn('survivor_district_id', $wherein)->where('violence_place_id', $violence_place)->get()->count();
            // dd($countsurvivor);

            $violence_place_name = SurvivorViolencePlace::find($violence_place)['name'];
            // if($countsurvivor != 0 && $autistic_name != null){
            $html[$keyy]['pie_category'] = $violence_place_name;
            $html[$keyy]['pie_count']    = $countsurvivor;
            // }

        }
        // dd($html);
        return response()->json($html);

    }

    public function getchart9(Request $request) {
        $where[]    = ['status', '=', '1'];
        $wherein    = [];
        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date   = date('Y-m-d', strtotime($request->end_date));

        if ($request->region_id != '') {
            $allDistrict = RegionAreaDetail::where('region_id', $request->region_id)->where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        } else {
            $allDistrict = RegionAreaDetail::where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
            $wherein     = $allDistrict;
        }
        if ($request->division_id != '') {
            $where[] = ['survivor_division_id', '=', $request->division_id];
        }
        if ($request->district_id != '') {
            $where[] = ['survivor_district_id', '=', $request->district_id];
        }

        // if($request->start_date !=''){
        //     $where[] = ['violence_date','=>',date('Y-m-d',strtotime($request->start_date))];
        // }
        // if($request->end_date !=''){
        //     $where[] = ['violence_date','=<',date('Y-m-d',strtotime($request->end_date))];
        // }
        if ($request->violence_category_id != '') {
            $where[] = ['violence_category_id', '=', $request->violence_category_id];
        }
        if ($request->violence_sub_category_id != '') {
            $where[] = ['violence_sub_category_id', '=', $request->violence_sub_category_id];
        }
        if ($request->violence_name_id != '') {
            $where[] = ['violence_name_id', '=', $request->violence_name_id];
        }

        $html = [];

        $legel_yes           = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$start_date, $end_date])->where('case_status', "Yes")->whereIn('survivor_district_id', $wherein)->get()->count();
        $legel_under_process = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$start_date, $end_date])->where('case_status', "Under Process")->whereIn('survivor_district_id', $wherein)->get()->count();
        $legel_no            = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$start_date, $end_date])->where('case_status', "No")->whereIn('survivor_district_id', $wherein)->get()->count();
        $legel_resolve       = SurvivorIncidentInformation::where($where)->whereBetween('violence_date', [$start_date, $end_date])->where('case_status', "Resolved through local arbitration")->whereIn('survivor_district_id', $wherein)->get()->count();
        // dd($legel_yes,$legel_under_process,$legel_no,$legel_resolve);

        $html[0]['legel_name']  = 'Yes';
        $html[0]['legel_total'] = $legel_yes;

        $html[1]['legel_name']  = 'Under Process';
        $html[1]['legel_total'] = $legel_under_process;

        $html[2]['legel_name']  = 'No';
        $html[2]['legel_total'] = $legel_no;

        $html[3]['legel_name']  = 'Resolved through local arbitration';
        $html[3]['legel_total'] = $legel_resolve;
        return response()->json($html);

    }

    // public function getchart2(Request $request){
    //     $where[] = ['status','=','1'];
    //     $wherein = [];
    //     $wherein2 = [];

    //     if($request->region_id !=''){
    //         $allDistrict = RegionAreaDetail::where('region_id',$request->region_id)->where('status','1')->groupBy('district_id')->pluck('district_id')->toArray();
    //         $wherein = $allDistrict;
    //     }
    //     if($request->division_id !=''){
    //         $where[] = ['survivor_division_id','=',$request->division_id];
    //     }
    //     if($request->district_id !=''){
    //         $where[] = ['survivor_district_id','=',$request->district_id];
    //     }

    //     if($request->start_date !=''){
    //         $where[] = ['violence_date','=>',date('Y-m-d',strtotime($request->start_date))];
    //     }
    //     if($request->end_date !=''){
    //         $where[] = ['violence_date','=<',date('Y-m-d',strtotime($request->end_date))];
    //     }
    //     if($request->violence_category_id !=''){
    //         $where[] = ['violence_category_id','=',$request->violence_category_id];
    //     }
    //     if($request->violence_sub_category_id !=''){
    //         $where[] = ['violence_sub_category_id','=',$request->violence_sub_category_id];
    //     }
    //     if($request->violence_name_id !=''){
    //         $where[] = ['violence_name_id','=',$request->violence_name_id];
    //     }
    //     if($request->violence_reason_id !=''){
    //         $wherein2 = $request->violence_reason_id;
    //     }

    //     $html=[];

    //     if($request->violence_name_id){
    //         if(count($wherein2) != 0){
    //             $survivor_incident_information_plucks = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id',$wherein)->whereIn('violence_reason_id',$wherein2)->get()->pluck('violence_reason_id')->toArray();
    //         }else{
    //             $survivor_incident_information_plucks = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id',$wherein)->get()->pluck('violence_reason_id')->toArray();
    //         }

    //         $arraymergedata = [];
    //         foreach ($survivor_incident_information_plucks as $key => $survivor_incident_information_pluck) {
    //             $a2= explode(',',$survivor_incident_information_pluck);
    //             $arraymergedata = array_merge($arraymergedata,$a2);
    //         }
    //         $survivor_incident_information = array_unique($arraymergedata);

    //         foreach ($survivor_incident_information as $keyy => $violence_reason){
    //             if(count($wherein2) != 0){
    //                 $countsurvivor = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id',$wherein)->whereIn('violence_reason_id',$wherein2)->where('violence_reason_id','like','%,'.$violence_reason.'%')->count();
    //                 if($countsurvivor == 0){
    //                     $countsurvivor = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id',$wherein)->whereIn('violence_reason_id',$wherein2)->where('violence_reason_id','like','%'.$violence_reason.',%')->count();
    //                 }
    //                 if($countsurvivor == 0){
    //                     $countsurvivor = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id',$wherein)->whereIn('violence_reason_id',$wherein2)->where('violence_reason_id',$violence_reason)->count();
    //                 }
    //             }else{
    //                 $countsurvivor = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id',$wherein)->where('violence_reason_id','like','%,'.$violence_reason.'%')->count();
    //                 if($countsurvivor == 0){
    //                     $countsurvivor = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id',$wherein)->where('violence_reason_id','like','%'.$violence_reason.',%')->count();
    //                 }
    //                 if($countsurvivor == 0){
    //                     $countsurvivor = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id',$wherein)->where('violence_reason_id',$violence_reason)->count();
    //                 }
    //             }
    //             $violence_name = ViolenceReason::find($violence_reason)['name'];
    //             if($countsurvivor != 0 && $violence_name != null){
    //                 $html[$keyy]['pie_category'] = $violence_name;
    //                 $html[$keyy]['pie_count'] = $countsurvivor;
    //             }
    //         }
    //         return response()->json($html);

    //     }else if($request->violence_sub_category_id){
    //         if(count($wherein2) != 0){
    //             $survivor_incident_information = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id',$wherein)->whereIn('violence_reason_id',$wherein2)->groupBy('violence_name_id')->get();
    //         }else{
    //             $survivor_incident_information = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id',$wherein)->groupBy('violence_name_id')->get();
    //         }
    //         foreach ($survivor_incident_information as $keyy => $violence_cat){
    //             if(count($wherein2) != 0){
    //                 $countsurvivor = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id',$wherein)->whereIn('violence_reason_id',$wherein2)->where('violence_name_id',$violence_cat->violence_name_id)->count();
    //             }else{
    //                 $countsurvivor = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id',$wherein)->where('violence_name_id',$violence_cat->violence_name_id)->count();
    //             }
    //             if($violence_cat['violencename']['name'] != null &&  $countsurvivor != 0){
    //                 $html[$keyy]['pie_category'] = $violence_cat['violencename']['name'];
    //                 $html[$keyy]['pie_count'] = $countsurvivor;
    //             }
    //         }
    //         return response()->json($html);
    //     }else if($request->violence_category_id){
    //         if(count($wherein2) != 0){
    //             $survivor_incident_information = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id',$wherein)->whereIn('violence_reason_id',$wherein2)->groupBy('violence_sub_category_id')->get();
    //         }else{
    //             $survivor_incident_information = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id',$wherein)->groupBy('violence_sub_category_id')->get();
    //         }
    //         foreach ($survivor_incident_information as $keyy => $violence_cat){
    //             if(count($wherein2) != 0){
    //                 $countsurvivor = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id',$wherein)->whereIn('violence_reason_id',$wherein2)->where('violence_sub_category_id',$violence_cat->violence_sub_category_id)->count();
    //             }else{
    //                 $countsurvivor = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id',$wherein)->where('violence_sub_category_id',$violence_cat->violence_sub_category_id)->count();
    //             }
    //             if($violence_cat['violencesubcategoryname']['name'] != null &&  $countsurvivor != 0){
    //                 $html[$keyy]['pie_category'] = $violence_cat['violencesubcategoryname']['name'];
    //                 $html[$keyy]['pie_count'] = $countsurvivor;
    //             }
    //         }
    //         return response()->json($html);
    //     }else{
    //         if(count($wherein2) != 0){
    //             $survivor_incident_information = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id',$wherein)->whereIn('violence_reason_id',$wherein2)->groupBy('violence_category_id')->get();
    //         }else{
    //             $survivor_incident_information = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id',$wherein)->groupBy('violence_category_id')->get();
    //         }
    //         foreach ($survivor_incident_information as $keyy => $violence_cat){
    //             if(count($wherein2) != 0){
    //                 $countsurvivor = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id',$wherein)->whereIn('violence_reason_id',$wherein2)->where('violence_category_id',$violence_cat->violence_category_id)->count();
    //             }else{
    //                 $countsurvivor = SurvivorIncidentInformation::where($where)->whereIn('survivor_district_id',$wherein)->where('violence_category_id',$violence_cat->violence_category_id)->count();
    //             }
    //             if($violence_cat['violencecategoryname']['name'] != null &&  $countsurvivor != 0){
    //                 $html[$keyy]['pie_category'] = $violence_cat['violencecategoryname']['name'];
    //                 $html[$keyy]['pie_count'] = $countsurvivor;
    //             }
    //         }
    //         return response()->json($html);
    //     }
    // }

}
