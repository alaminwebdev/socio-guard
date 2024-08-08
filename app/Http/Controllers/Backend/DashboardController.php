<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Model\Admin\Setup\Occupation;
use App\Model\Admin\Setup\ViolenceCategory;
use App\Model\Education;
use App\Model\PollisomajDataModel;
use App\Model\SelpIncidentModel;
use App\Model\SurvivorDirectServiceModel;
use Illuminate\Http\Request;

class DashboardController extends Controller {
    public function filterAgeRangeData(Request $request) {

        // dd($request->all());
        $region    = $request->region_id;
        $division  = $request->division_id;
        $district  = $request->district_id;
        $upazila   = $request->upazila_id;
        $violence  = $request->violence_id;
        $from_date = $request->from_date != null ? date("Y-m-d", strtotime($request->from_date)) : null;
        $to_date   = $request->to_date != null ? date("Y-m-d", strtotime($request->to_date)) : null;
        $ageR      = array('0-5', '6-10', '11-17', '18-35', '36-100');

        if ($violence != null) {
            $violences = ViolenceCategory::select('id', 'name')->orderBy('id', "ASC")->where('id', $violence)->get();
        } else {
            $violences = ViolenceCategory::select('id', 'name')->orderBy('id', "ASC")->limit(6)->get();
        }
        foreach ($ageR as $key => $value) {
            $ttt = explode("-", $value);
            $rrr = implode(",", $ttt);

            foreach ($violences as $keyy => $violence) {
                $pdata['informations'][$value]['age']           = $value;
                $pdata['informations'][$value][$violence->name] = SelpIncidentModel::when($region, function ($query, $region) {
                    if ($region != null) {
                        $query->where('employee_zone_id', $region);
                    }
                })
                    ->when($division, function ($query, $division) {
                        if ($division != null) {
                            $query->where('employee_division_id', $division);
                        }
                    })
                    ->when($district, function ($query, $district) {
                        if ($district != null) {
                            $query->where('employee_district_id', $district);
                        }
                    })
                    ->when($upazila, function ($query, $upazila) {
                        if ($upazila != null) {
                            $query->where('employee_upazila_id', $upazila);
                        }
                    })
                    ->when($from_date, function ($query, $from_date) {
                        if ($from_date != null) {
                            $query->whereDate('posting_date', '>=', $from_date);
                        }
                    })
                    ->when($to_date, function ($query, $to_date) {
                        if ($to_date != null) {
                            $query->whereDate('posting_date', '<=', $to_date);
                        }
                    })
                    ->select('id', 'violence_reason_id', 'survivor_age')
                    ->whereIn('survivor_age', range($ttt[0], $ttt[1]))
                    ->where('violence_reason_id', $violence->id)
                    ->whereNotNull('violence_reason_id')
                    ->where('status', 2)
                    ->count();
            }
        }
        $reindexed = array_values($pdata['informations']);
        return response()->json($reindexed);
    }

    public function filterAdrData(Request $request) {
        // dd($request->all());
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

        $region   = $request->region_id;
        $division = $request->division_id;
        $district = $request->district_id;
        $upazila  = $request->upazila_id;
        $adr_year = $request->adr_year;
        // $from_date     =     $request->from_date!=null ? date("Y-m-d", strtotime($request->from_date)) : null;
        // $to_date     =     $request->to_date!=null ? date("Y-m-d", strtotime($request->to_date)) : null;
        // if($month != null){
        //     $months = array($month =>$months[$month]);
        // }
        if ($adr_year != null) {
            $year = $adr_year;
        } else {
            $year = date('Y');
        }

        foreach ($months as $key => $value) {
            // dd(date('Y'));
            $direct_support[$value]['month'] = $value;
            $direct_support[$value]['money'] = (int) SurvivorDirectServiceModel::whereHas('selpincident', function ($query) use ($region, $division, $district, $upazila) {
                $query->when($region, function ($query, $region) {
                    if ($region != null) {
                        $query->where('employee_zone_id', $region);
                    }
                })
                    ->when($division, function ($query, $division) {
                        if ($division != null) {
                            $query->where('employee_division_id', $division);
                        }
                    })
                    ->when($district, function ($query, $district) {
                        if ($district != null) {
                            $query->where('employee_district_id', $district);
                        }
                    })
                    ->when($upazila, function ($query, $upazila) {
                        if ($upazila != null) {
                            $query->where('employee_upazila_id', $upazila);
                        }
                    });
            })->whereIn('alternative_dispute_resolution_id', [7, 9, 11]) //added by sajal
                                                                         //->whereIn('alternative_dispute_resolution_id', [7, 9, 10, 11])
                ->whereNotNull('amount_of_money_received')
                ->whereYear('closing_date', '=', $year)
                ->whereMonth('closing_date', '=', $key)
                ->sum('amount_of_money_received');
        }
        $reindexed = "array_values($direct_support)";
        return response()->json($reindexed);
    }

    public function filterTopViolence(Request $request) {
        // dd($request->all());
        $region    = $request->region_id;
        $division  = $request->division_id;
        $district  = $request->district_id;
        $upazila   = $request->upazila_id;
        $violence  = $request->violence_id;
        $from_date = $request->from_date != null ? date("Y-m-d", strtotime($request->from_date)) : null;
        $to_date   = $request->to_date != null ? date("Y-m-d", strtotime($request->to_date)) : null;

        // $violences    =    ViolenceCategory::select('id','name')->orderBy('id', "ASC")->get();
        if ($violence != null) {
            $violences = ViolenceCategory::select('id', 'name')->orderBy('id', "ASC")->where('id', $violence)->get();
        } else {
            $violences = ViolenceCategory::select('id', 'name')->orderBy('id', "ASC")->get();
        }

        foreach ($violences as $key => $value) {
            $pdata['informations'][$value->name]['category'] = $value->name;
            $pdata['informations'][$value->name]['value']    = SelpIncidentModel::when($region, function ($query, $region) {
                if ($region != null) {
                    $query->where('employee_zone_id', $region);
                }
            })
                ->when($division, function ($query, $division) {
                    if ($division != null) {
                        $query->where('employee_division_id', $division);
                    }
                })
                ->when($district, function ($query, $district) {
                    if ($district != null) {
                        $query->where('employee_district_id', $district);
                    }
                })
                ->when($upazila, function ($query, $upazila) {
                    if ($upazila != null) {
                        $query->where('employee_upazila_id', $upazila);
                    }
                })
                ->when($from_date, function ($query, $from_date) {
                    if ($from_date != null) {
                        $query->whereDate('posting_date', '>=', $from_date);
                    }
                })
                ->when($to_date, function ($query, $to_date) {
                    if ($to_date != null) {
                        $query->whereDate('posting_date', '<=', $to_date);
                    }
                })
                ->where('violence_reason_id', $value->id)->count();
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

    public function filterCummunityViolence(Request $request) {
        // dd($request->all());
        $region    = $request->region_id;
        $division  = $request->division_id;
        $district  = $request->district_id;
        $upazila   = $request->upazila_id;
        $from_date = $request->from_date != null ? date("Y-m-d", strtotime($request->from_date)) : null;
        $to_date   = $request->to_date != null ? date("Y-m-d", strtotime($request->to_date)) : null;

        $pdata['informations']['category']['country'] = "Illegal divorce";
        $pdata['informations']['category']['value']   = (int) PollisomajDataModel::when($region, function ($query, $region) {
            if ($region != null) {
                $query->where('zone_id', $region);
            }
        })
            ->when($division, function ($query, $division) {
                if ($division != null) {
                    $query->where('division_id', $division);
                }
            })
            ->when($district, function ($query, $district) {
                if ($district != null) {
                    $query->where('district_id', $district);
                }
            })
            ->when($upazila, function ($query, $upazila) {
                if ($upazila != null) {
                    $query->where('upazilla_id', $upazila);
                }
            })
            ->when($from_date, function ($query, $from_date) {
                if ($from_date != null) {
                    $query->whereDate('reporting_date', '>=', $from_date);
                }
            })
            ->when($to_date, function ($query, $to_date) {
                if ($to_date != null) {
                    $query->whereDate('reporting_date', '<=', $to_date);
                }
            })
            ->sum('illegal_divorce');
        $pdata['informations']['category2']['country'] = "Illegal polygamy";
        $pdata['informations']['category2']['value']   = (int) PollisomajDataModel::when($region, function ($query, $region) {
            if ($region != null) {
                $query->where('zone_id', $region);
            }
        })
            ->when($division, function ($query, $division) {
                if ($division != null) {
                    $query->where('division_id', $division);
                }
            })
            ->when($district, function ($query, $district) {
                if ($district != null) {
                    $query->where('district_id', $district);
                }
            })
            ->when($upazila, function ($query, $upazila) {
                if ($upazila != null) {
                    $query->where('upazilla_id', $upazila);
                }
            })
            ->when($from_date, function ($query, $from_date) {
                if ($from_date != null) {
                    $query->whereDate('reporting_date', '>=', $from_date);
                }
            })
            ->when($to_date, function ($query, $to_date) {
                if ($to_date != null) {
                    $query->whereDate('reporting_date', '<=', $to_date);
                }
            })
            ->sum('illegal_polygamy');
        $pdata['informations']['category3']['country'] = "Family Conflict";
        $pdata['informations']['category3']['value']   = (int) PollisomajDataModel::when($region, function ($query, $region) {
            if ($region != null) {
                $query->where('zone_id', $region);
            }
        })
            ->when($division, function ($query, $division) {
                if ($division != null) {
                    $query->where('division_id', $division);
                }
            })
            ->when($district, function ($query, $district) {
                if ($district != null) {
                    $query->where('district_id', $district);
                }
            })
            ->when($upazila, function ($query, $upazila) {
                if ($upazila != null) {
                    $query->where('upazilla_id', $upazila);
                }
            })
            ->when($from_date, function ($query, $from_date) {
                if ($from_date != null) {
                    $query->whereDate('reporting_date', '>=', $from_date);
                }
            })
            ->when($to_date, function ($query, $to_date) {
                if ($to_date != null) {
                    $query->whereDate('reporting_date', '<=', $to_date);
                }
            })
            ->sum('family_conflict');
        $pdata['informations']['category4']['country'] = "Hilla marriage";
        $pdata['informations']['category4']['value']   = (int) PollisomajDataModel::when($region, function ($query, $region) {
            if ($region != null) {
                $query->where('zone_id', $region);
            }
        })
            ->when($division, function ($query, $division) {
                if ($division != null) {
                    $query->where('division_id', $division);
                }
            })
            ->when($district, function ($query, $district) {
                if ($district != null) {
                    $query->where('district_id', $district);
                }
            })
            ->when($upazila, function ($query, $upazila) {
                if ($upazila != null) {
                    $query->where('upazilla_id', $upazila);
                }
            })
            ->when($from_date, function ($query, $from_date) {
                if ($from_date != null) {
                    $query->whereDate('reporting_date', '>=', $from_date);
                }
            })
            ->when($to_date, function ($query, $to_date) {
                if ($to_date != null) {
                    $query->whereDate('reporting_date', '<=', $to_date);
                }
            })
            ->sum('hilla_marriage');
        $pdata['informations']['category5']['country'] = "Illegal arbitration";
        $pdata['informations']['category5']['value']   = (int) PollisomajDataModel::when($region, function ($query, $region) {
            if ($region != null) {
                $query->where('zone_id', $region);
            }
        })
            ->when($division, function ($query, $division) {
                if ($division != null) {
                    $query->where('division_id', $division);
                }
            })
            ->when($district, function ($query, $district) {
                if ($district != null) {
                    $query->where('district_id', $district);
                }
            })
            ->when($upazila, function ($query, $upazila) {
                if ($upazila != null) {
                    $query->where('upazilla_id', $upazila);
                }
            })
            ->when($from_date, function ($query, $from_date) {
                if ($from_date != null) {
                    $query->whereDate('reporting_date', '>=', $from_date);
                }
            })
            ->when($to_date, function ($query, $to_date) {
                if ($to_date != null) {
                    $query->whereDate('reporting_date', '<=', $to_date);
                }
            })
            ->sum('illegal_arbitration');
        $pdata['informations']['category6']['country'] = "Illegal fatwa";
        $pdata['informations']['category6']['value']   = (int) PollisomajDataModel::when($region, function ($query, $region) {
            if ($region != null) {
                $query->where('zone_id', $region);
            }
        })
            ->when($division, function ($query, $division) {
                if ($division != null) {
                    $query->where('division_id', $division);
                }
            })
            ->when($district, function ($query, $district) {
                if ($district != null) {
                    $query->where('district_id', $district);
                }
            })
            ->when($upazila, function ($query, $upazila) {
                if ($upazila != null) {
                    $query->where('upazilla_id', $upazila);
                }
            })
            ->when($from_date, function ($query, $from_date) {
                if ($from_date != null) {
                    $query->whereDate('reporting_date', '>=', $from_date);
                }
            })
            ->when($to_date, function ($query, $to_date) {
                if ($to_date != null) {
                    $query->whereDate('reporting_date', '<=', $to_date);
                }
            })
            ->sum('illegal_fatwah');
        $pdata['informations']['category7']['country'] = "Physical torture";
        $pdata['informations']['category7']['value']   = (int) PollisomajDataModel::when($region, function ($query, $region) {
            if ($region != null) {
                $query->where('zone_id', $region);
            }
        })
            ->when($division, function ($query, $division) {
                if ($division != null) {
                    $query->where('division_id', $division);
                }
            })
            ->when($district, function ($query, $district) {
                if ($district != null) {
                    $query->where('district_id', $district);
                }
            })
            ->when($upazila, function ($query, $upazila) {
                if ($upazila != null) {
                    $query->where('upazilla_id', $upazila);
                }
            })
            ->when($from_date, function ($query, $from_date) {
                if ($from_date != null) {
                    $query->whereDate('reporting_date', '>=', $from_date);
                }
            })
            ->when($to_date, function ($query, $to_date) {
                if ($to_date != null) {
                    $query->whereDate('reporting_date', '<=', $to_date);
                }
            })
            ->sum('physical_torture');
        $pdata['informations']['category8']['country'] = "Sexual harassment";
        $pdata['informations']['category8']['value']   = (int) PollisomajDataModel::when($region, function ($query, $region) {
            if ($region != null) {
                $query->where('zone_id', $region);
            }
        })
            ->when($division, function ($query, $division) {
                if ($division != null) {
                    $query->where('division_id', $division);
                }
            })
            ->when($district, function ($query, $district) {
                if ($district != null) {
                    $query->where('district_id', $district);
                }
            })
            ->when($upazila, function ($query, $upazila) {
                if ($upazila != null) {
                    $query->where('upazilla_id', $upazila);
                }
            })
            ->when($from_date, function ($query, $from_date) {
                if ($from_date != null) {
                    $query->whereDate('reporting_date', '>=', $from_date);
                }
            })
            ->when($to_date, function ($query, $to_date) {
                if ($to_date != null) {
                    $query->whereDate('reporting_date', '<=', $to_date);
                }
            })
            ->sum('sexual_harassment');
        $reindexed = array_values($pdata['informations']);
        return response()->json($reindexed);
    }

    public function filterDefendantEducation(Request $request) {
        // dd($request->all());
        $region     = $request->region_id;
        $division   = $request->division_id;
        $district   = $request->district_id;
        $upazila    = $request->upazila_id;
        $from_date  = $request->from_date != null ? date("Y-m-d", strtotime($request->from_date)) : null;
        $to_date    = $request->to_date != null ? date("Y-m-d", strtotime($request->to_date)) : null;
        $educations = Education::select('id', 'title')->orderBy('id', "ASC")->get();

        foreach ($educations as $key => $value) {
            $pdata['informations'][$value->title]['country'] = $value->title;
            $pdata['informations'][$value->title]['value']   = SelpIncidentModel::when($region, function ($query, $region) {
                if ($region != null) {
                    $query->where('employee_zone_id', $region);
                }
            })
                ->when($division, function ($query, $division) {
                    if ($division != null) {
                        $query->where('employee_division_id', $division);
                    }
                })
                ->when($district, function ($query, $district) {
                    if ($district != null) {
                        $query->where('employee_district_id', $district);
                    }
                })
                ->when($upazila, function ($query, $upazila) {
                    if ($upazila != null) {
                        $query->where('employee_upazila_id', $upazila);
                    }
                })
                ->when($from_date, function ($query, $from_date) {
                    if ($from_date != null) {
                        $query->where('posting_date', '>=', $from_date);
                    }
                })
                ->when($to_date, function ($query, $to_date) {
                    if ($to_date != null) {
                        $query->where('posting_date', '<=', $to_date);
                    }
                })
                ->where('defendant_education_id', $value->id)
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

    public function filterDefendantOccupation(Request $request) {
        // dd($request->all());
        $region     = $request->region_id;
        $division   = $request->division_id;
        $district   = $request->district_id;
        $upazila    = $request->upazila_id;
        $from_date  = $request->from_date != null ? date("Y-m-d", strtotime($request->from_date)) : null;
        $to_date    = $request->to_date != null ? date("Y-m-d", strtotime($request->to_date)) : null;
        $educations = Occupation::select('id', 'name')->orderBy('id', "ASC")->get();

        foreach ($educations as $key => $value) {
            $pdata['informations'][$value->name]['country'] = $value->name;
            $pdata['informations'][$value->name]['value']   = SelpIncidentModel::when($region, function ($query, $region) {
                if ($region != null) {
                    $query->where('employee_zone_id', $region);
                }
            })
                ->when($division, function ($query, $division) {
                    if ($division != null) {
                        $query->where('employee_division_id', $division);
                    }
                })
                ->when($district, function ($query, $district) {
                    if ($district != null) {
                        $query->where('employee_district_id', $district);
                    }
                })
                ->when($upazila, function ($query, $upazila) {
                    if ($upazila != null) {
                        $query->where('employee_upazila_id', $upazila);
                    }
                })
                ->when($from_date, function ($query, $from_date) {
                    if ($from_date != null) {
                        $query->where('posting_date', '>=', $from_date);
                    }
                })
                ->when($to_date, function ($query, $to_date) {
                    if ($to_date != null) {
                        $query->where('posting_date', '<=', $to_date);
                    }
                })
                ->where('defendant_occupation_id', $value->id)->count();
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

    public function filterDefendantAge(Request $request) {
        // dd($request->all());
        $region    = $request->region_id;
        $division  = $request->division_id;
        $district  = $request->district_id;
        $upazila   = $request->upazila_id;
        $from_date = $request->from_date != null ? date("Y-m-d", strtotime($request->from_date)) : null;
        $to_date   = $request->to_date != null ? date("Y-m-d", strtotime($request->to_date)) : null;

        $pdata['informations']['category']['category'] = "Age(0-5)";
        $pdata['informations']['category']['value']    = SelpIncidentModel::when($region, function ($query, $region) {
            if ($region != null) {
                $query->where('employee_zone_id', $region);
            }
        })
            ->when($division, function ($query, $division) {
                if ($division != null) {
                    $query->where('employee_division_id', $division);
                }
            })
            ->when($district, function ($query, $district) {
                if ($district != null) {
                    $query->where('employee_district_id', $district);
                }
            })
            ->when($upazila, function ($query, $upazila) {
                if ($upazila != null) {
                    $query->where('employee_upazila_id', $upazila);
                }
            })
            ->when($from_date, function ($query, $from_date) {
                if ($from_date != null) {
                    $query->where('posting_date', '>=', $from_date);
                }
            })
            ->when($to_date, function ($query, $to_date) {
                if ($to_date != null) {
                    $query->where('posting_date', '<=', $to_date);
                }
            })
            ->whereIn('main_defendant_age', range(0, 5))->count();

        $pdata['informations']['category2']['category'] = "Age(6-10)";
        $pdata['informations']['category2']['value']    = SelpIncidentModel::when($region, function ($query, $region) {
            if ($region != null) {
                $query->where('employee_zone_id', $region);
            }
        })
            ->when($division, function ($query, $division) {
                if ($division != null) {
                    $query->where('employee_division_id', $division);
                }
            })
            ->when($district, function ($query, $district) {
                if ($district != null) {
                    $query->where('employee_district_id', $district);
                }
            })
            ->when($upazila, function ($query, $upazila) {
                if ($upazila != null) {
                    $query->where('employee_upazila_id', $upazila);
                }
            })
            ->when($from_date, function ($query, $from_date) {
                if ($from_date != null) {
                    $query->where('posting_date', '>=', $from_date);
                }
            })
            ->when($to_date, function ($query, $to_date) {
                if ($to_date != null) {
                    $query->where('posting_date', '<=', $to_date);
                }
            })
            ->whereIn('main_defendant_age', range(6, 10))->count();

        $pdata['informations']['category3']['category'] = "Age(11 - 17)";
        $pdata['informations']['category3']['value']    = SelpIncidentModel::when($region, function ($query, $region) {
            if ($region != null) {
                $query->where('employee_zone_id', $region);
            }
        })
            ->when($division, function ($query, $division) {
                if ($division != null) {
                    $query->where('employee_division_id', $division);
                }
            })
            ->when($district, function ($query, $district) {
                if ($district != null) {
                    $query->where('employee_district_id', $district);
                }
            })
            ->when($upazila, function ($query, $upazila) {
                if ($upazila != null) {
                    $query->where('employee_upazila_id', $upazila);
                }
            })->when($from_date, function ($query, $from_date) {
            if ($from_date != null) {
                $query->where('posting_date', '>=', $from_date);
            }
        })->when($to_date, function ($query, $to_date) {
            if ($to_date != null) {
                $query->where('posting_date', '<=', $to_date);
            }
        })->whereIn('main_defendant_age', range(11, 17))
            ->where('status', 2)
            ->count();

        $pdata['informations']['category4']['category'] = "Age(18 - 35)";
        $pdata['informations']['category4']['value']    = SelpIncidentModel::when($region, function ($query, $region) {
            if ($region != null) {
                $query->where('employee_zone_id', $region);
            }
        })
            ->when($division, function ($query, $division) {
                if ($division != null) {
                    $query->where('employee_division_id', $division);
                }
            })
            ->when($district, function ($query, $district) {
                if ($district != null) {
                    $query->where('employee_district_id', $district);
                }
            })
            ->when($upazila, function ($query, $upazila) {
                if ($upazila != null) {
                    $query->where('employee_upazila_id', $upazila);
                }
            })->when($from_date, function ($query, $from_date) {
            if ($from_date != null) {
                $query->where('posting_date', '>=', $from_date);
            }
        })
            ->when($to_date, function ($query, $to_date) {
                if ($to_date != null) {
                    $query->where('posting_date', '<=', $to_date);
                }
            })->whereIn('main_defendant_age', range(18, 35))
            ->where('status', 2)
            ->count();

        $pdata['informations']['category5']['category'] = "Age(36 - 50)";
        $pdata['informations']['category5']['value']    = SelpIncidentModel::when($region, function ($query, $region) {
            if ($region != null) {
                $query->where('employee_zone_id', $region);
            }
        })
            ->when($division, function ($query, $division) {
                if ($division != null) {
                    $query->where('employee_division_id', $division);
                }
            })
            ->when($district, function ($query, $district) {
                if ($district != null) {
                    $query->where('employee_district_id', $district);
                }
            })
            ->when($upazila, function ($query, $upazila) {
                if ($upazila != null) {
                    $query->where('employee_upazila_id', $upazila);
                }
            })->when($from_date, function ($query, $from_date) {
            if ($from_date != null) {
                $query->where('posting_date', '>=', $from_date);
            }
        })
            ->when($to_date, function ($query, $to_date) {
                if ($to_date != null) {
                    $query->where('posting_date', '<=', $to_date);
                }
            })->whereIn('main_defendant_age', range(36, 50))
            ->where('status', 2)
            ->count();

        $pdata['informations']['category6']['category'] = "Age(51 - 100)";
        $pdata['informations']['category6']['value']    = SelpIncidentModel::when($region, function ($query, $region) {
            if ($region != null) {
                $query->where('employee_zone_id', $region);
            }
        })
            ->when($division, function ($query, $division) {
                if ($division != null) {
                    $query->where('employee_division_id', $division);
                }
            })
            ->when($district, function ($query, $district) {
                if ($district != null) {
                    $query->where('employee_district_id', $district);
                }
            })
            ->when($upazila, function ($query, $upazila) {
                if ($upazila != null) {
                    $query->where('employee_upazila_id', $upazila);
                }
            })->when($from_date, function ($query, $from_date) {
            if ($from_date != null) {
                $query->where('posting_date', '>=', $from_date);
            }
        })
            ->when($to_date, function ($query, $to_date) {
                if ($to_date != null) {
                    $query->where('posting_date', '<=', $to_date);
                }
            })->whereIn('main_defendant_age', range(51, 100))
            ->where('status', 2)
            ->count();

        $reindexed = array_values($pdata['informations']);
        return response()->json($reindexed);
    }

    public function filterSurvivorAge(Request $request) {
        // dd($request->all());
        $region    = $request->region_id;
        $division  = $request->division_id;
        $district  = $request->district_id;
        $upazila   = $request->upazila_id;
        $from_date = $request->from_date != null ? date("Y-m-d", strtotime($request->from_date)) : null;
        $to_date   = $request->to_date != null ? date("Y-m-d", strtotime($request->to_date)) : null;

        $pdata['informations']['category']['category'] = "Below-18";
        $pdata['informations']['category']['value']    = SelpIncidentModel::when($region, function ($query, $region) {
            if ($region != null) {
                $query->where('employee_zone_id', $region);
            }
        })
            ->when($division, function ($query, $division) {
                if ($division != null) {
                    $query->where('employee_division_id', $division);
                }
            })
            ->when($district, function ($query, $district) {
                if ($district != null) {
                    $query->where('employee_district_id', $district);
                }
            })
            ->when($upazila, function ($query, $upazila) {
                if ($upazila != null) {
                    $query->where('employee_upazila_id', $upazila);
                }
            })
            ->when($from_date, function ($query, $from_date) {
                if ($from_date != null) {
                    $query->where('posting_date', '>=', $from_date);
                }
            })
            ->when($to_date, function ($query, $to_date) {
                if ($to_date != null) {
                    $query->where('posting_date', '<=', $to_date);
                }
            })
            ->whereIn('survivor_age', range(0, 17))
            ->where('survivor_gender_id', 2)                      //added by sajal
            ->whereIn('survivor_marital_status_id', [1, 3, 4, 5]) // added by sajal
            ->count();
        $pdata['informations']['category2']['category'] = "Above-18";
        $pdata['informations']['category2']['value']    = SelpIncidentModel::when($region, function ($query, $region) {
            if ($region != null) {
                $query->where('employee_zone_id', $region);
            }
        })
            ->when($division, function ($query, $division) {
                if ($division != null) {
                    $query->where('employee_division_id', $division);
                }
            })
            ->when($district, function ($query, $district) {
                if ($district != null) {
                    $query->where('employee_district_id', $district);
                }
            })
            ->when($upazila, function ($query, $upazila) {
                if ($upazila != null) {
                    $query->where('employee_upazila_id', $upazila);
                }
            })
            ->when($from_date, function ($query, $from_date) {
                if ($from_date != null) {
                    $query->where('posting_date', '>=', $from_date);
                }
            })
            ->when($to_date, function ($query, $to_date) {
                if ($to_date != null) {
                    $query->where('posting_date', '<=', $to_date);
                }
            })
            ->whereIn('survivor_age', range(18, 200))
            ->where('survivor_gender_id', 2)                      //added by sajal
            ->whereIn('survivor_marital_status_id', [1, 3, 4, 5]) // added by sajal
            ->count();
        $reindexed = array_values($pdata['informations']);
        return response()->json($reindexed);
    }

    public function filterSurvivorEducation(Request $request) {
        // dd($request->all());
        $region    = $request->region_id;
        $division  = $request->division_id;
        $district  = $request->district_id;
        $upazila   = $request->upazila_id;
        $from_date = $request->from_date != null ? date("Y-m-d", strtotime($request->from_date)) : null;
        $to_date   = $request->to_date != null ? date("Y-m-d", strtotime($request->to_date)) : null;

        $educations = Education::select('id', 'title')->orderBy('id', "ASC")->get();

        foreach ($educations as $key => $value) {
            $pdata['informations'][$value->title]['country'] = $value->title;
            $pdata['informations'][$value->title]['value']   = SelpIncidentModel::when($region, function ($query, $region) {
                if ($region != null) {
                    $query->where('employee_zone_id', $region);
                }
            })
                ->when($division, function ($query, $division) {
                    if ($division != null) {
                        $query->where('employee_division_id', $division);
                    }
                })
                ->when($district, function ($query, $district) {
                    if ($district != null) {
                        $query->where('employee_district_id', $district);
                    }
                })
                ->when($upazila, function ($query, $upazila) {
                    if ($upazila != null) {
                        $query->where('employee_upazila_id', $upazila);
                    }
                })
                ->when($from_date, function ($query, $from_date) {
                    if ($from_date != null) {
                        $query->where('posting_date', '>=', $from_date);
                    }
                })
                ->when($to_date, function ($query, $to_date) {
                    if ($to_date != null) {
                        $query->where('posting_date', '<=', $to_date);
                    }
                })
                ->where('survivor_education_id', $value->id)->count();
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

    public function filterRecurrentViolence(Request $request) {
        // dd($request->all());
        $region    = $request->region_id;
        $division  = $request->division_id;
        $district  = $request->district_id;
        $upazila   = $request->upazila_id;
        $from_date = $request->from_date != null ? date("Y-m-d", strtotime($request->from_date)) : null;
        $to_date   = $request->to_date != null ? date("Y-m-d", strtotime($request->to_date)) : null;

        $data = SelpIncidentModel::when($region, function ($query, $region) {
            if ($region != null) {
                $query->where('employee_zone_id', $region);
            }
        })
            ->when($division, function ($query, $division) {
                if ($division != null) {
                    $query->where('employee_division_id', $division);
                }
            })
            ->when($district, function ($query, $district) {
                if ($district != null) {
                    $query->where('employee_district_id', $district);
                }
            })
            ->when($upazila, function ($query, $upazila) {
                if ($upazila != null) {
                    $query->where('employee_upazila_id', $upazila);
                }
            })
            ->when($from_date, function ($query, $from_date) {
                if ($from_date != null) {
                    $query->where('posting_date', '>=', $from_date);
                }
            })
            ->when($to_date, function ($query, $to_date) {
                if ($to_date != null) {
                    $query->where('posting_date', '<=', $to_date);
                }
            })
            ->whereNotNull('violence_reason_id')->whereNotNull('survivor_first_face_violence_type')->where('survivor_first_face_violence_type', '!=', "")->count();
        return response()->json($data);

    }

}
