<?php

namespace App\Http\Controllers;

use App\Exports\MisReportExport;
use App\Http\Controllers\Controller;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\CEP_Region\RegionAreaDetail;
use App\Model\Admin\Setup\CEP_Region\SetupUserArea;
use App\Model\Admin\Setup\Division;
use App\Model\PollisomajDataModel;
use App\Model\PollisomajSetup;
use App\Model\PollisomajTheatreModel;
use App\User;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PolliSomajController extends Controller {

    public function getDetails(Request $request) {
        return json_encode(PollisomajSetup::withTrashed()->where('village_id', $request->village_id)->get());
    }
    public function index(Request $request) {
        $data['pollisomajList'] = PollisomajSetup::with(['zone:id,region_name', 'division:id,name', 'district:id,name', 'upazila:id,name', 'union:id,name', 'village:id,name'])->get();
        $data['divisions']      = Division::all();
        $data['regions']        = getRegionByUserType();
        return view('backend.pollisomaj.list', $data);
    }

    public function getPolliSomaj(Request $request) {

        $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();

        $pollisomaj = PollisomajSetup::select('id', 'pollisomaj_no', 'pollisomaj_name', 'zone_id', 'division_id', 'district_id', 'upazila_id', 'union_id', 'village_name', 'date_from', 'date_to');
        // dd($pollisomaj);
        if (@$request->zone_id) {
            $pollisomaj->where('zone_id', $request->zone_id);
        } else if (count(session()->get('userareaaccess.sregions')) > 0) {
            $pollisomaj->whereIn('zone_id', session()->get('userareaaccess.sregions'));
        }

        if (@$request->division_id) {
            $pollisomaj->where('division_id', $request->division_id);
        } else if (count(session()->get('userareaaccess.sdivisions')) > 0) {
            $pollisomaj->whereIn('division_id', session()->get('userareaaccess.sdivisions'));
        }

        if (@$request->district_id) {
            $pollisomaj->where('district_id', $request->district_id);
        } else if (count(session()->get('userareaaccess.sdistricts')) > 0) {
            $pollisomaj->whereIn('district_id', session()->get('userareaaccess.sdistricts'));
        }

        if (@$request->upazila_id) {
            $pollisomaj->where('upazila_id', $request->upazila_id);
        } else if (count(session()->get('userareaaccess.supazilas')) > 0) {
            $pollisomaj->whereIn('upazila_id', session()->get('userareaaccess.supazilas'));
        }
        // if($request->zone_id) {
        //     $pollisomaj->where('zone_id', $request->zone_id);
        // }
        // if($request->division_id) {
        //     $pollisomaj->where('division_id', $request->division_id);
        // }
        // if($request->district_id) {
        //     $pollisomaj->where('district_id', $request->district_id);
        // }
        // if($request->upazila_id) {
        //     $pollisomaj->where('upazila_id', $request->upazila_id);
        // }

        $pollisomaj->orderBy('id', 'DESC');

        return DataTables::of($pollisomaj)
            ->addIndexColumn()
            ->addColumn('zone', function ($pollisomaj) {
                return @$pollisomaj['zone']['region_name'];
            })
            ->addColumn('division', function ($pollisomaj) {
                return @$pollisomaj['division']['name'];
            })
            ->addColumn('district', function ($pollisomaj) {
                return @$pollisomaj['district']['name'];
            })
            ->addColumn('upazila', function ($pollisomaj) {
                return @$pollisomaj['upazila']['name'];
            })
            ->addColumn('union', function ($pollisomaj) {
                return @$pollisomaj['union']['name'];
            })
            ->addColumn('action_column', function (PollisomajSetup $pollisomaj) {
                $links = '<a href="' . route('edit.pollisomaj', $pollisomaj->id) . '" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
                    <a href="#" class="btn btn-sm btn-danger delete_pollisomaj_data"  action_type="inc_del" id="' . $pollisomaj->id . '" title="Delete"><i action_type="inc_del" class="fa fa-trash delete_pollisomaj_data" id="' . $pollisomaj->id . '" aria-hidden="true"></i></a>';
                // <a href="#" target="__blank" class="btn btn-sm btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                return $links;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);

    }

    public function add(Request $request) {
        $data['regions'] = getRegionByUserType();
        if ($request->isMethod('post')) {
            $pollisomaj                           = new PollisomajSetup;
            $pollisomaj->pollisomaj_name          = $request->name;
            $pollisomaj->pollisomaj_no            = $request->pollisomaj_no;
            $pollisomaj->zone_id                  = $request->zone_id;
            $pollisomaj->division_id              = $request->division_id;
            $pollisomaj->district_id              = $request->district_id;
            $pollisomaj->upazila_id               = $request->upazila_id;
            $pollisomaj->union_id                 = $request->union_id;
            $pollisomaj->village_name             = $request->village_name;
            $pollisomaj->date_from                = $request->date_from;
            $pollisomaj->date_to                  = $request->date_to != null ? $request->date_to : null;
            $pollisomaj->deleted_at               = $request->date_to != null ? $request->date_to : null;
            $pollisomaj->name_1                   = $request->name_1;
            $pollisomaj->mob_1                    = $request->mob_1;
            $pollisomaj->name_2                   = $request->name_2;
            $pollisomaj->mob_2                    = $request->mob_2;
            $pollisomaj->name_3                   = $request->name_3;
            $pollisomaj->mob_3                    = $request->mob_3;
            $pollisomaj->name_4                   = $request->name_4;
            $pollisomaj->mob_4                    = $request->mob_4;
            $pollisomaj->member_girls             = $request->member_girls;
            $pollisomaj->member_boys              = $request->member_boys;
            $pollisomaj->member_female            = $request->member_female;
            $pollisomaj->member_male              = $request->member_male;
            $pollisomaj->member_transgender       = $request->member_transgender;
            $pollisomaj->general_member_total     = $request->general_member_total;
            $pollisomaj->member_girls_pwd         = $request->member_girls_pwd;
            $pollisomaj->member_boys_pwd          = $request->member_boys_pwd;
            $pollisomaj->member_female_pwd        = $request->member_female_pwd;
            $pollisomaj->member_male_pwd          = $request->member_male_pwd;
            $pollisomaj->member_transgender_pwd   = $request->member_transgender_pwd;
            $pollisomaj->general_member_pwd_total = $request->general_member_pwd_total;
            $pollisomaj->save();

            $request->session()->flash("success", "Pollisomaj added");
            return redirect('pollisomaj/list');
        }

        return view('backend.pollisomaj.create', $data);
    }
    public function delete($id) {
        $pollisomaj_no = PollisomajSetup::find($id);
        $exist_data    = PollisomajDataModel::where('pollisomaj_no', $pollisomaj_no->pollisomaj_no)->count();

        if ($exist_data > 0) {
            return response()->json('notdeleted');
        } else {
            PollisomajSetup::withTrashed()->find($id)->delete();
            return response()->json('deleted');
        }

        // PollisomajSetup::withTrashed()->find($id)->delete();
        // return response()->json('deleted');
    }

    public function editPollisomaj(Request $request, $id) {
        $data['item']    = PollisomajSetup::withTrashed()->with(['zone:id,region_name', 'division:id,name', 'district:id,name', 'upazila:id,name', 'union:id,name', 'village:id,name'])->find($id);
        $data['regions'] = getRegionByUserType();
        if ($request->isMethod('post')) {

            if ($data['item']->zone_id != $request->zone_id || $data['item']->division_id != $request->division_id || $data['item']->district_id != $request->district_id || $data['item']->upazila_id != $request->upazila_id || $data['item']->union_id != $request->union_id) {
                PollisomajSetup::withTrashed()->find($data['item']->id)->delete();
                $pollisomaj                           = new PollisomajSetup;
                $pollisomaj->pollisomaj_name          = $request->name;
                $pollisomaj->pollisomaj_no            = $request->pollisomaj_no;
                $pollisomaj->zone_id                  = $request->zone_id;
                $pollisomaj->division_id              = $request->division_id;
                $pollisomaj->district_id              = $request->district_id;
                $pollisomaj->upazila_id               = $request->upazila_id;
                $pollisomaj->union_id                 = $request->union_id;
                $pollisomaj->village_name             = $request->village_name;
                $pollisomaj->date_from                = $request->date_from;
                $pollisomaj->date_to                  = $request->date_to != null ? $request->date_to : null;
                $pollisomaj->deleted_at               = $request->date_to != null ? $request->date_to : null;
                $pollisomaj->name_1                   = $request->name_1;
                $pollisomaj->mob_1                    = $request->mob_1;
                $pollisomaj->name_2                   = $request->name_2;
                $pollisomaj->mob_2                    = $request->mob_2;
                $pollisomaj->name_3                   = $request->name_3;
                $pollisomaj->mob_3                    = $request->mob_3;
                $pollisomaj->name_4                   = $request->name_4;
                $pollisomaj->mob_4                    = $request->mob_4;
                $pollisomaj->member_girls             = $request->member_girls;
                $pollisomaj->member_boys              = $request->member_boys;
                $pollisomaj->member_female            = $request->member_female;
                $pollisomaj->member_male              = $request->member_male;
                $pollisomaj->member_transgender       = $request->member_transgender;
                $pollisomaj->general_member_total     = $request->general_member_total;
                $pollisomaj->member_girls_pwd         = $request->member_girls_pwd;
                $pollisomaj->member_boys_pwd          = $request->member_boys_pwd;
                $pollisomaj->member_female_pwd        = $request->member_female_pwd;
                $pollisomaj->member_male_pwd          = $request->member_male_pwd;
                $pollisomaj->member_transgender_pwd   = $request->member_transgender_pwd;
                $pollisomaj->general_member_pwd_total = $request->general_member_pwd_total;
                $pollisomaj->save();
                $request->session()->flash("success", "Pollisomaj updated");
                return redirect('pollisomaj/list');
            } else {
                $item                           = PollisomajSetup::withTrashed()->find($data['item']->id);
                $item->pollisomaj_name          = $request->name;
                $item->pollisomaj_no            = $request->pollisomaj_no;
                $item->date_from                = $request->date_from;
                $item->date_to                  = $request->date_to != null ? $request->date_to : null;
                $item->deleted_at               = $request->date_to != null ? $request->date_to : null;
                $item->village_name             = $request->village_name;
                $item->name_1                   = $request->name_1;
                $item->mob_1                    = $request->mob_1;
                $item->name_2                   = $request->name_2;
                $item->mob_2                    = $request->mob_2;
                $item->name_3                   = $request->name_3;
                $item->mob_3                    = $request->mob_3;
                $item->name_4                   = $request->name_4;
                $item->mob_4                    = $request->mob_4;
                $item->member_girls             = $request->member_girls;
                $item->member_boys              = $request->member_boys;
                $item->member_female            = $request->member_female;
                $item->member_male              = $request->member_male;
                $item->member_transgender       = $request->member_transgender;
                $item->general_member_total     = $request->general_member_total;
                $item->member_girls_pwd         = $request->member_girls_pwd;
                $item->member_boys_pwd          = $request->member_boys_pwd;
                $item->member_female_pwd        = $request->member_female_pwd;
                $item->member_male_pwd          = $request->member_male_pwd;
                $item->member_transgender_pwd   = $request->member_transgender_pwd;
                $item->general_member_pwd_total = $request->general_member_pwd_total;
                $item->save();
                $request->session()->flash("success", "Pollisomaj updated");
                return redirect('pollisomaj/list');
            }
        }
        //dd($data['item']);
        return view('backend.pollisomaj.edit')->with($data);
    }

    public function editPollisomajData(Request $request, $ref) {
        // if ($request->session()->has('current_pollisomaj_store_session')) {
        //     $request->session()->forget('current_pollisomaj_store_session');
        //     $request->session()->put('current_pollisomaj_store_session', $ref);
        // } else {
        //     $request->session()->put('current_pollisomaj_store_session', $ref);
        // }
        $request->session()->put('p_edit_mode', true);
        return redirect()->route('data.pollisomaj.add', ["pollisomaj_ref_id" =>$ref]);
    }

    public function isVillageActive(Request $request) {
        $previousVillage = PollisomajSetup::where('village_id', '!=', '')->where('village_id', $request->village_id)->get();
        if (count($previousVillage) > 0) {
            return response()->json([
                'status' => 200,
                'url'    => route('edit.pollisomaj', ['id' => $previousVillage[0]->id]),
            ]);
        } else {
            return response()->json([
                'status' => 404,
            ]);
        }
    }

    public function addPollisomajData(Request $request) {
        
        if ((bool) $request->query('addnew')) {
            // $request->session()->forget('current_pollisomaj_store_session');
            $request->session()->forget('p_edit_mode');
        }
        // if (!$request->session()->has('current_pollisomaj_store_session')) {
        //     $request->session()->put('current_pollisomaj_store_session', uniqid("POLLISOMAJ_ID_", true));
        // }
        if ($request->step == 1) {
            $request->session()->put('p_edit_mode', true);
        }

        //$data['regions'] = Region::get();
        $data['step']           = $request->step;
        $data['auth_user']      = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        $data['user_info']      = Auth::user();
        $data['pollisomajData'] = PollisomajDataModel::where('pollisomaj_data_ref',  $request->pollisomaj_ref_id)->get();
        $data['regions'] = getRegionByUserType();

        return view('backend.pollisomaj.pollisomajdata.create')->with($data);
    }

    public function addPollisomajStep1(Request $request) {

        // dd($request->all());
        $pollisomajData = PollisomajDataModel::where('pollisomaj_data_ref', $request->pollisomaj_ref_id)->get();
        if (count($pollisomajData) > 0) {
            $pollisomajDataUpdate                      = PollisomajDataModel::find($pollisomajData[0]->id);

            $pollisomajDataUpdate->reporting_date  = $request->reporting_date != null ? date("Y-m-d", strtotime($request->reporting_date)) : null;
            $pollisomajDataUpdate->employee_id     = $request->input('employee_id');
            $pollisomajDataUpdate->employee_pin    = $request->input('employee_pin');
            $pollisomajDataUpdate->pollisomaj_no   = $request->input('pollisomaj_no');
            $pollisomajDataUpdate->zone_id         = $request->input('zone_id');
            $pollisomajDataUpdate->division_id     = $request->input('division_id');
            $pollisomajDataUpdate->district_id     = $request->input('district_id');
            $pollisomajDataUpdate->upazilla_id     = $request->input('upazilla_id');
            $pollisomajDataUpdate->union_id        = $request->input('union_id');
            $pollisomajDataUpdate->village_name    = $request->input('village_name');
            $pollisomajDataUpdate->ward_no         = $request->input('ward_no');
            $pollisomajDataUpdate->pollisomaj_id   = $request->input('pollisomaj_id');
            $pollisomajDataUpdate->pollisomaj_name = $request->input('pollisomaj_name');
            // $pollisomajDataUpdate->ps_reform_date           =date( "Y-m-d", strtotime( $request->input('ps_reform_date')));
            $pollisomajDataUpdate->ps_reform_date           = $request->ps_reform_date != null ? date("Y-m-d", strtotime($request->ps_reform_date)) : null;
            $pollisomajDataUpdate->member_girls             = $request->input('member_girls');
            $pollisomajDataUpdate->member_boys              = $request->input('member_boys');
            $pollisomajDataUpdate->member_female            = $request->input('member_female');
            $pollisomajDataUpdate->member_male              = $request->input('member_male');
            $pollisomajDataUpdate->member_transgender       = $request->input('member_transgender');
            $pollisomajDataUpdate->general_member_total     = $request->input('general_member_total');
            $pollisomajDataUpdate->member_girls_pwd         = $request->input('member_girls_pwd');
            $pollisomajDataUpdate->member_boys_pwd          = $request->input('member_boys_pwd');
            $pollisomajDataUpdate->member_female_pwd        = $request->input('member_female_pwd');
            $pollisomajDataUpdate->member_male_pwd          = $request->input('member_male_pwd');
            $pollisomajDataUpdate->member_transgender_pwd   = $request->input('member_transgender_pwd');
            $pollisomajDataUpdate->general_member_pwd_total = $request->input('general_member_pwd_total');
            $pollisomajDataUpdate->p_number                 = $request->input('p_number');
            $pollisomajDataUpdate->s_number                 = $request->input('s_number');
            $pollisomajDataUpdate->c_number                 = $request->input('c_number');
            $pollisomajDataUpdate->last_update_by = auth()->user()->id;
            $pollisomajDataUpdate->save();

        } else {

            $pollisomajNewData                      = new PollisomajDataModel;
            $pollisomajNewData->flag                = 0;
            $pollisomajNewData->pollisomaj_data_ref = uniqid("POLLISOMAJ_ID_", true);
            $pollisomajNewData->reporting_date      = $request->reporting_date != null ? date("Y-m-d", strtotime($request->reporting_date)) : null;
            $pollisomajNewData->employee_id         = Auth::id();
            $pollisomajNewData->employee_pin        = Auth::user()->pin;
            $pollisomajNewData->pollisomaj_no       = $request->input('pollisomaj_no');
            $pollisomajNewData->zone_id             = $request->input('zone_id');
            $pollisomajNewData->division_id         = $request->input('division_id');
            $pollisomajNewData->district_id         = $request->input('district_id');
            $pollisomajNewData->upazilla_id         = $request->input('upazilla_id');
            $pollisomajNewData->union_id            = $request->input('union_id');
            $pollisomajNewData->village_name        = $request->input('village_name');
            $pollisomajNewData->ward_no             = $request->input('ward_no');
            $pollisomajNewData->pollisomaj_id       = $request->input('pollisomaj_id');
            $pollisomajNewData->pollisomaj_name     = $request->input('pollisomaj_name');
            $pollisomajNewData->ps_reform_date      = $request->ps_reform_date != null ? date("Y-m-d", strtotime($request->ps_reform_date)) : null;
            // $pollisomajNewData->ps_reform_date           =  date( "Y-m-d", strtotime( $request->input('ps_reform_date')));
            $pollisomajNewData->member_girls             = $request->input('member_girls');
            $pollisomajNewData->member_boys              = $request->input('member_boys');
            $pollisomajNewData->member_female            = $request->input('member_female');
            $pollisomajNewData->member_male              = $request->input('member_male');
            $pollisomajNewData->member_transgender       = $request->input('member_transgender');
            $pollisomajNewData->general_member_total     = $request->input('general_member_total');
            $pollisomajNewData->member_girls_pwd         = $request->input('member_girls_pwd');
            $pollisomajNewData->member_boys_pwd          = $request->input('member_boys_pwd');
            $pollisomajNewData->member_female_pwd        = $request->input('member_female_pwd');
            $pollisomajNewData->member_male_pwd          = $request->input('member_male_pwd');
            $pollisomajNewData->member_transgender_pwd   = $request->input('member_transgender_pwd');
            $pollisomajNewData->general_member_pwd_total = $request->input('general_member_pwd_total');
            $pollisomajNewData->p_number                 = $request->input('p_number');
            $pollisomajNewData->s_number                 = $request->input('s_number');
            $pollisomajNewData->c_number                 = $request->input('c_number');

            $pollisomajNewData->save();

        }

        if ($request->has('save_destroy')) {
            // $request->session()->forget('current_pollisomaj_store_session');
            $request->session()->forget('p_edit_mode');
            return redirect()->route('incident.pollisomaj.viewpollisomajlist');
        }
        $data['regions']        = getRegionByUserType();
        $data['step']           = $request->step;
        $data['auth_user']      = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        if(count($pollisomajData) > 0){
            $data['pollisomajData'] = $pollisomajData;
        }else{
            $data['pollisomajData'][] = $pollisomajNewData;
        }

        return view('backend.pollisomaj.pollisomajdata.create')->with($data);
    }

    public function addPollisomajStep2(Request $request) {

        // dd($request->all());
        if ($request->girls_got_married_finally != null) {
            if (!$request->has('save_destroy')) {
                $validated = $request->validate([
                    'girls_got_married_at_18_finally'        => 'required',
                    'girls_got_married_under_18_finally_pwd' => 'required',
                ]);
            }
        }

        $pollisomajData = PollisomajDataModel::where('pollisomaj_data_ref', $request->pollisomaj_ref_id)->get();
        if (count($pollisomajData) > 0) {
            $pollisomajDataUpdate                      = PollisomajDataModel::find($pollisomajData[0]->id);
            // $pollisomajDataUpdate->pollisomaj_data_ref = $request->session()->get('current_pollisomaj_store_session');

            $pollisomajDataUpdate->number_of_child_marriage               = $request->input('number_of_child_marriage');
            $pollisomajDataUpdate->contacted_up_within_ps_member          = $request->input('contacted_up_within_ps_member');
            $pollisomajDataUpdate->contacted_up_beyond_ps_member          = $request->input('contacted_up_beyond_ps_member');
            $pollisomajDataUpdate->contacted_local_within_ps_member       = $request->input('contacted_local_within_ps_member');
            $pollisomajDataUpdate->contacted_local_beyond_ps_member       = $request->input('contacted_local_beyond_ps_member');
            $pollisomajDataUpdate->family_consultation_within_ps_member   = $request->input('family_consultation_within_ps_member');
            $pollisomajDataUpdate->family_consultation_beyond_ps_member   = $request->input('family_consultation_beyond_ps_member');
            $pollisomajDataUpdate->contacted_upazila_within_ps_member     = $request->input('contacted_upazila_within_ps_member');
            $pollisomajDataUpdate->contacted_upazila_beyond_ps_member     = $request->input('contacted_upazila_beyond_ps_member');
            $pollisomajDataUpdate->hotline_number_within_ps_member        = $request->input('hotline_number_within_ps_member');
            $pollisomajDataUpdate->hotline_number_beyond_ps_member        = $request->input('hotline_number_beyond_ps_member');
            $pollisomajDataUpdate->girls_risk_of_child_marriage           = $request->input('girls_risk_of_child_marriage');
            $pollisomajDataUpdate->girls_risk_of_child_marriage_pwd       = $request->input('girls_risk_of_child_marriage_pwd');
            $pollisomajDataUpdate->card_provided_among_girls              = $request->input('card_provided_among_girls');
            $pollisomajDataUpdate->card_provided_among_pwd                = $request->input('card_provided_among_pwd');
            $pollisomajDataUpdate->girls_connected_to_service             = $request->input('girls_connected_to_service');
            $pollisomajDataUpdate->girls_connected_to_service_pwd         = $request->input('girls_connected_to_service_pwd');
            $pollisomajDataUpdate->girls_got_married_finally              = $request->input('girls_got_married_finally');
            $pollisomajDataUpdate->girls_got_married_finally_pwd          = $request->input('girls_got_married_finally_pwd');
            $pollisomajDataUpdate->girls_got_married_at_18_finally        = $request->input('girls_got_married_at_18_finally');
            $pollisomajDataUpdate->girls_got_married_under_18_finally_pwd = $request->input('girls_got_married_under_18_finally_pwd');
            $pollisomajDataUpdate->illegal_divorce                        = $request->input('illegal_divorce');
            $pollisomajDataUpdate->illegal_polygamy                       = $request->input('illegal_polygamy');
            $pollisomajDataUpdate->family_conflict                        = $request->input('family_conflict');
            $pollisomajDataUpdate->hilla_marriage                         = $request->input('hilla_marriage');
            $pollisomajDataUpdate->illegal_arbitration                    = $request->input('illegal_arbitration');
            $pollisomajDataUpdate->illegal_fatwah                         = $request->input('illegal_fatwah');
            $pollisomajDataUpdate->physical_torture                       = $request->input('physical_torture');
            $pollisomajDataUpdate->sexual_harassment                      = $request->input('sexual_harassment');
            $pollisomajDataUpdate->last_update_by = auth()->user()->id;
            $pollisomajDataUpdate->save();
        } else {
            return redirect()->route('data.pollisomaj.add');
        }

        if ($request->has('save_destroy')) {
            // $request->session()->forget('current_pollisomaj_store_session');
            $request->session()->forget('p_edit_mode');
            return redirect()->route('incident.pollisomaj.viewpollisomajlist');
        }
        $data['regions']        = getRegionByUserType();
        $data['step']           = $request->step;
        $data['auth_user']      = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        $data['pollisomajData'] = $pollisomajData;
        return view('backend.pollisomaj.pollisomajdata.create')->with($data);
    }

    public function addPollisomajStep3(Request $request) {
        // dd($request->all());
        $pollisomajData = PollisomajDataModel::where('pollisomaj_data_ref', $request->pollisomaj_ref_id)->get();
        if (count($pollisomajData) > 0) {
            $pollisomajDataUpdate                      = PollisomajDataModel::find($pollisomajData[0]->id);
            // $pollisomajDataUpdate->pollisomaj_data_ref = $request->session()->get('current_pollisomaj_store_session');

            $pollisomajDataUpdate->ps_mem_gov_elec_men                   = $request->input('ps_mem_gov_elec_men');
            $pollisomajDataUpdate->ps_mem_gov_elec_women                 = $request->input('ps_mem_gov_elec_women');
            $pollisomajDataUpdate->ps_mem_gov_elec_transgender           = $request->input('ps_mem_gov_elec_transgender');
            $pollisomajDataUpdate->ps_mem_gov_elec_pwd                   = $request->input('ps_mem_gov_elec_pwd');
            $pollisomajDataUpdate->ps_mem_gov_elec_men_elected           = $request->input('ps_mem_gov_elec_men_elected');
            $pollisomajDataUpdate->ps_mem_gov_elec_women_elected         = $request->input('ps_mem_gov_elec_women_elected');
            $pollisomajDataUpdate->ps_mem_gov_elec_transgender_elected   = $request->input('ps_mem_gov_elec_transgender_elected');
            $pollisomajDataUpdate->ps_mem_gov_elec_pwd_elected           = $request->input('ps_mem_gov_elec_pwd_elected');
            $pollisomajDataUpdate->contested_as_joyeeta                  = $request->input('contested_as_joyeeta');
            $pollisomajDataUpdate->joyeeta_contested_women               = $request->input('joyeeta_contested_women');
            $pollisomajDataUpdate->joyeeta_contested_pwd                 = $request->input('joyeeta_contested_pwd');
            $pollisomajDataUpdate->joyeeta_dis_selected                  = $request->input('joyeeta_dis_selected');
            $pollisomajDataUpdate->joyeeta_div_selected                  = $request->input('joyeeta_div_selected');
            $pollisomajDataUpdate->joyeeta_national_selected             = $request->input('joyeeta_national_selected');
            $pollisomajDataUpdate->school_committee_boys                 = $request->input('school_committee_boys');
            $pollisomajDataUpdate->school_committee_girls                = $request->input('school_committee_girls');
            $pollisomajDataUpdate->school_committee_male                 = $request->input('school_committee_male');
            $pollisomajDataUpdate->school_committee_female               = $request->input('school_committee_female');
            $pollisomajDataUpdate->school_committee_transgender          = $request->input('school_committee_transgender');
            $pollisomajDataUpdate->school_committee_total                = $request->input('school_committee_total');
            $pollisomajDataUpdate->school_committee_pwd_boys             = $request->input('school_committee_pwd_boys');
            $pollisomajDataUpdate->school_committee_pwd_girls            = $request->input('school_committee_pwd_girls');
            $pollisomajDataUpdate->school_committee_pwd_male             = $request->input('school_committee_pwd_male');
            $pollisomajDataUpdate->school_committee_pwd_female           = $request->input('school_committee_pwd_female');
            $pollisomajDataUpdate->school_committee_pwd_transgender      = $request->input('school_committee_pwd_transgender');
            $pollisomajDataUpdate->school_committee_pwd_total            = $request->input('school_committee_pwd_total');
            $pollisomajDataUpdate->hatbazar_committee_boys               = $request->input('hatbazar_committee_boys');
            $pollisomajDataUpdate->hatbazar_committee_girls              = $request->input('hatbazar_committee_girls');
            $pollisomajDataUpdate->hatbazar_committee_male               = $request->input('hatbazar_committee_male');
            $pollisomajDataUpdate->hatbazar_committee_female             = $request->input('hatbazar_committee_female');
            $pollisomajDataUpdate->hatbazar_committee_transgender        = $request->input('hatbazar_committee_transgender');
            $pollisomajDataUpdate->hatbazar_committee_total              = $request->input('hatbazar_committee_total');
            $pollisomajDataUpdate->hatbazar_committee_pwd_boys           = $request->input('hatbazar_committee_pwd_boys');
            $pollisomajDataUpdate->hatbazar_committee_pwd_girls          = $request->input('hatbazar_committee_pwd_girls');
            $pollisomajDataUpdate->hatbazar_committee_pwd_male           = $request->input('hatbazar_committee_pwd_male');
            $pollisomajDataUpdate->hatbazar_committee_pwd_female         = $request->input('hatbazar_committee_pwd_female');
            $pollisomajDataUpdate->hatbazar_committee_pwd_transgender    = $request->input('hatbazar_committee_pwd_transgender');
            $pollisomajDataUpdate->hatbazar_committee_pwd_total          = $request->input('hatbazar_committee_pwd_total');
            $pollisomajDataUpdate->stading_committee_boys                = $request->input('stading_committee_boys');
            $pollisomajDataUpdate->stading_committee_girls               = $request->input('stading_committee_girls');
            $pollisomajDataUpdate->stading_committee_male                = $request->input('stading_committee_male');
            $pollisomajDataUpdate->stading_committee_female              = $request->input('stading_committee_female');
            $pollisomajDataUpdate->stading_committee_transgender         = $request->input('stading_committee_transgender');
            $pollisomajDataUpdate->stading_committee_total               = $request->input('stading_committee_total');
            $pollisomajDataUpdate->stading_committee_pwd_boys            = $request->input('stading_committee_pwd_boys');
            $pollisomajDataUpdate->stading_committee_pwd_girls           = $request->input('stading_committee_pwd_girls');
            $pollisomajDataUpdate->stading_committee_pwd_male            = $request->input('stading_committee_pwd_male');
            $pollisomajDataUpdate->stading_committee_pwd_female          = $request->input('stading_committee_pwd_female');
            $pollisomajDataUpdate->stading_committee_pwd_transgender     = $request->input('stading_committee_pwd_transgender');
            $pollisomajDataUpdate->stading_committee_pwd_total           = $request->input('stading_committee_pwd_total');
            $pollisomajDataUpdate->clinic_committee_boys                 = $request->input('clinic_committee_boys');
            $pollisomajDataUpdate->clinic_committee_girls                = $request->input('clinic_committee_girls');
            $pollisomajDataUpdate->clinic_committee_male                 = $request->input('clinic_committee_male');
            $pollisomajDataUpdate->clinic_committee_female               = $request->input('clinic_committee_female');
            $pollisomajDataUpdate->clinic_committee_transgender          = $request->input('clinic_committee_transgender');
            $pollisomajDataUpdate->clinic_committee_total                = $request->input('clinic_committee_total');
            $pollisomajDataUpdate->clinic_committee_pwd_boys             = $request->input('clinic_committee_pwd_boys');
            $pollisomajDataUpdate->clinic_committee_pwd_girls            = $request->input('clinic_committee_pwd_girls');
            $pollisomajDataUpdate->clinic_committee_pwd_male             = $request->input('clinic_committee_pwd_male');
            $pollisomajDataUpdate->clinic_committee_pwd_female           = $request->input('clinic_committee_pwd_female');
            $pollisomajDataUpdate->clinic_committee_pwd_transgender      = $request->input('clinic_committee_pwd_transgender');
            $pollisomajDataUpdate->clinic_committee_pwd_total            = $request->input('clinic_committee_pwd_total');
            $pollisomajDataUpdate->institution_committee_boys            = $request->input('institution_committee_boys');
            $pollisomajDataUpdate->institution_committee_girls           = $request->input('institution_committee_girls');
            $pollisomajDataUpdate->institution_committee_male            = $request->input('institution_committee_male');
            $pollisomajDataUpdate->institution_committee_female          = $request->input('institution_committee_female');
            $pollisomajDataUpdate->institution_committee_transgender     = $request->input('institution_committee_transgender');
            $pollisomajDataUpdate->institution_committee_total           = $request->input('institution_committee_total');
            $pollisomajDataUpdate->institution_committee_pwd_boys        = $request->input('institution_committee_pwd_boys');
            $pollisomajDataUpdate->institution_committee_pwd_girls       = $request->input('institution_committee_pwd_girls');
            $pollisomajDataUpdate->institution_committee_pwd_male        = $request->input('institution_committee_pwd_male');
            $pollisomajDataUpdate->institution_committee_pwd_female      = $request->input('institution_committee_pwd_female');
            $pollisomajDataUpdate->institution_committee_pwd_transgender = $request->input('institution_committee_pwd_transgender');
            $pollisomajDataUpdate->institution_committee_pwd_total       = $request->input('institution_committee_pwd_total');
            $pollisomajDataUpdate->solidarity_committee_boys             = $request->input('solidarity_committee_boys');
            $pollisomajDataUpdate->solidarity_committee_girls            = $request->input('solidarity_committee_girls');
            $pollisomajDataUpdate->solidarity_committee_male             = $request->input('solidarity_committee_male');
            $pollisomajDataUpdate->solidarity_committee_female           = $request->input('solidarity_committee_female');
            $pollisomajDataUpdate->solidarity_committee_transgender      = $request->input('solidarity_committee_transgender');
            $pollisomajDataUpdate->solidarity_committee_total            = $request->input('solidarity_committee_total');
            $pollisomajDataUpdate->solidarity_committee_pwd_boys         = $request->input('solidarity_committee_pwd_boys');
            $pollisomajDataUpdate->solidarity_committee_pwd_girls        = $request->input('solidarity_committee_pwd_girls');
            $pollisomajDataUpdate->solidarity_committee_pwd_male         = $request->input('solidarity_committee_pwd_male');
            $pollisomajDataUpdate->solidarity_committee_pwd_female       = $request->input('solidarity_committee_pwd_female');
            $pollisomajDataUpdate->solidarity_committee_pwd_transgender  = $request->input('solidarity_committee_pwd_transgender');
            $pollisomajDataUpdate->solidarity_committee_pwd_total        = $request->input('solidarity_committee_pwd_total');
            $pollisomajDataUpdate->welfare_committee_boys                = $request->input('welfare_committee_boys');
            $pollisomajDataUpdate->welfare_committee_girls               = $request->input('welfare_committee_girls');
            $pollisomajDataUpdate->welfare_committee_male                = $request->input('welfare_committee_male');
            $pollisomajDataUpdate->welfare_committee_female              = $request->input('welfare_committee_female');
            $pollisomajDataUpdate->welfare_committee_transgender         = $request->input('welfare_committee_transgender');
            $pollisomajDataUpdate->welfare_committee_total               = $request->input('welfare_committee_total');
            $pollisomajDataUpdate->welfare_committee_pwd_boys            = $request->input('welfare_committee_pwd_boys');
            $pollisomajDataUpdate->welfare_committee_pwd_girls           = $request->input('welfare_committee_pwd_girls');
            $pollisomajDataUpdate->welfare_committee_pwd_male            = $request->input('welfare_committee_pwd_male');
            $pollisomajDataUpdate->welfare_committee_pwd_female          = $request->input('welfare_committee_pwd_female');
            $pollisomajDataUpdate->welfare_committee_pwd_transgender     = $request->input('welfare_committee_pwd_transgender');
            $pollisomajDataUpdate->welfare_committee_pwd_total           = $request->input('welfare_committee_pwd_total');
            $pollisomajDataUpdate->last_update_by = auth()->user()->id;
            $pollisomajDataUpdate->save();
        } else {
            return redirect()->route('data.pollisomaj.add');
        }

        if ($request->has('save_destroy')) {
            // $request->session()->forget('current_pollisomaj_store_session');
            $request->session()->forget('p_edit_mode');
            return redirect()->route('incident.pollisomaj.viewpollisomajlist');
        }
        $data['regions']        = getRegionByUserType();
        $data['step']           = $request->step;
        $data['auth_user']      = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        $data['pollisomajData'] = $pollisomajData;
        return view('backend.pollisomaj.pollisomajdata.create')->with($data);
    }

    public function addPollisomajStep4(Request $request) {
        //dd($request->all());
        $pollisomajData = PollisomajDataModel::where('pollisomaj_data_ref', $request->pollisomaj_ref_id)->get();
        if (count($pollisomajData) > 0) {
            $pollisomajDataUpdate                      = PollisomajDataModel::find($pollisomajData[0]->id);
            // $pollisomajDataUpdate->pollisomaj_data_ref = $request->session()->get('current_pollisomaj_store_session');

            $pollisomajDataUpdate->iga_training_financial_ps_mem_boys                    = $request->input('iga_training_financial_ps_mem_boys');
            $pollisomajDataUpdate->iga_training_financial_ps_mem_girls                   = $request->input('iga_training_financial_ps_mem_girls');
            $pollisomajDataUpdate->iga_training_financial_ps_mem_men                     = $request->input('iga_training_financial_ps_mem_men');
            $pollisomajDataUpdate->iga_training_financial_ps_mem_women                   = $request->input('iga_training_financial_ps_mem_women');
            $pollisomajDataUpdate->iga_training_financial_ps_mem_transgender             = $request->input('iga_training_financial_ps_mem_transgender');
            $pollisomajDataUpdate->iga_training_financial_ps_mem_total                   = $request->input('iga_training_financial_ps_mem_total');
            $pollisomajDataUpdate->iga_training_financial_ps_mem_pwd_boys                = $request->input('iga_training_financial_ps_mem_pwd_boys');
            $pollisomajDataUpdate->iga_training_financial_ps_mem_pwd_girls               = $request->input('iga_training_financial_ps_mem_pwd_girls');
            $pollisomajDataUpdate->iga_training_financial_ps_mem_pwd_male                = $request->input('iga_training_financial_ps_mem_pwd_male');
            $pollisomajDataUpdate->iga_training_financial_ps_mem_pwd_women               = $request->input('iga_training_financial_ps_mem_pwd_women');
            $pollisomajDataUpdate->iga_training_financial_ps_mem_pwd_transgender         = $request->input('iga_training_financial_ps_mem_pwd_transgender');
            $pollisomajDataUpdate->iga_training_financial_ps_mem_pwd_total               = $request->input('iga_training_financial_ps_mem_pwd_total');
            $pollisomajDataUpdate->iga_training_financial_without_ps_mem_boys            = $request->input('iga_training_financial_without_ps_mem_boys');
            $pollisomajDataUpdate->iga_training_financial_without_ps_mem_girls           = $request->input('iga_training_financial_without_ps_mem_girls');
            $pollisomajDataUpdate->iga_training_financial_without_ps_mem_men             = $request->input('iga_training_financial_without_ps_mem_men');
            $pollisomajDataUpdate->iga_training_financial_without_ps_mem_women           = $request->input('iga_training_financial_without_ps_mem_women');
            $pollisomajDataUpdate->iga_training_financial_without_ps_mem_transgender     = $request->input('iga_training_financial_without_ps_mem_transgender');
            $pollisomajDataUpdate->iga_training_financial_without_ps_mem_total           = $request->input('iga_training_financial_without_ps_mem_total');
            $pollisomajDataUpdate->iga_training_financial_without_ps_mem_pwd_boys        = $request->input('iga_training_financial_without_ps_mem_pwd_boys');
            $pollisomajDataUpdate->iga_training_financial_without_ps_mem_pwd_girls       = $request->input('iga_training_financial_without_ps_mem_pwd_girls');
            $pollisomajDataUpdate->iga_training_financial_without_ps_mem_pwd_male        = $request->input('iga_training_financial_without_ps_mem_pwd_male');
            $pollisomajDataUpdate->iga_training_financial_without_ps_mem_pwd_women       = $request->input('iga_training_financial_without_ps_mem_pwd_women');
            $pollisomajDataUpdate->iga_training_financial_without_ps_mem_pwd_transgender = $request->input('iga_training_financial_without_ps_mem_pwd_transgender');
            $pollisomajDataUpdate->iga_training_financial_without_ps_mem_pwd_total       = $request->input('iga_training_financial_without_ps_mem_pwd_total');
            $pollisomajDataUpdate->iga_training_ps_mem_boys                              = $request->input('iga_training_ps_mem_boys');
            $pollisomajDataUpdate->iga_training_ps_mem_girls                             = $request->input('iga_training_ps_mem_girls');
            $pollisomajDataUpdate->iga_training_ps_mem_men                               = $request->input('iga_training_ps_mem_men');
            $pollisomajDataUpdate->iga_training_ps_mem_women                             = $request->input('iga_training_ps_mem_women');
            $pollisomajDataUpdate->iga_training_ps_mem_transgender                       = $request->input('iga_training_ps_mem_transgender');
            $pollisomajDataUpdate->iga_training_ps_mem_total                             = $request->input('iga_training_ps_mem_total');
            $pollisomajDataUpdate->iga_training_ps_mem_pwd_boys                          = $request->input('iga_training_ps_mem_pwd_boys');
            $pollisomajDataUpdate->iga_training_ps_mem_pwd_girls                         = $request->input('iga_training_ps_mem_pwd_girls');
            $pollisomajDataUpdate->iga_training_ps_mem_pwd_men                           = $request->input('iga_training_ps_mem_pwd_men');
            $pollisomajDataUpdate->iga_training_ps_mem_pwd_women                         = $request->input('iga_training_ps_mem_pwd_women');
            $pollisomajDataUpdate->iga_training_ps_mem_pwd_transgender                   = $request->input('iga_training_ps_mem_pwd_transgender');
            $pollisomajDataUpdate->iga_training_ps_mem_pwd_total                         = $request->input('iga_training_ps_mem_pwd_total');
            $pollisomajDataUpdate->iga_training_without_ps_mem_boys                      = $request->input('iga_training_without_ps_mem_boys');
            $pollisomajDataUpdate->iga_training_without_ps_mem_girls                     = $request->input('iga_training_without_ps_mem_girls');
            $pollisomajDataUpdate->iga_training_without_ps_mem_men                       = $request->input('iga_training_without_ps_mem_men');
            $pollisomajDataUpdate->iga_training_without_ps_mem_women                     = $request->input('iga_training_without_ps_mem_women');
            $pollisomajDataUpdate->iga_training_without_ps_mem_transgender               = $request->input('iga_training_without_ps_mem_transgender');
            $pollisomajDataUpdate->iga_training_without_ps_mem_total                     = $request->input('iga_training_without_ps_mem_total');
            $pollisomajDataUpdate->iga_training_without_ps_mem_pwd_boys                  = $request->input('iga_training_without_ps_mem_pwd_boys');
            $pollisomajDataUpdate->iga_training_without_ps_mem_pwd_girls                 = $request->input('iga_training_without_ps_mem_pwd_girls');
            $pollisomajDataUpdate->iga_training_without_ps_mem_pwd_men                   = $request->input('iga_training_without_ps_mem_pwd_men');
            $pollisomajDataUpdate->iga_training_without_ps_mem_pwd_women                 = $request->input('iga_training_without_ps_mem_pwd_women');
            $pollisomajDataUpdate->iga_training_without_ps_mem_pwd_transgender           = $request->input('iga_training_without_ps_mem_pwd_transgender');
            $pollisomajDataUpdate->iga_training_without_ps_mem_pwd_total                 = $request->input('iga_training_without_ps_mem_pwd_total');
            $pollisomajDataUpdate->last_update_by = auth()->user()->id;
            $pollisomajDataUpdate->save();
        } else {
            return redirect()->route('data.pollisomaj.add');
        }
        if ($request->has('save_destroy')) {
            // $request->session()->forget('current_pollisomaj_store_session');
            $request->session()->forget('p_edit_mode');
            return redirect()->route('incident.pollisomaj.viewpollisomajlist');
        }
        $data['regions']        = getRegionByUserType();
        $data['step']           = $request->step;
        $data['auth_user']      = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        $data['pollisomajData'] = $pollisomajData;
        return view('backend.pollisomaj.pollisomajdata.create')->with($data);
    }

    public function addPollisomajStep5(Request $request) {
        //dd($request->all());
        $pollisomajData = PollisomajDataModel::where('pollisomaj_data_ref', $request->pollisomaj_ref_id)->get();
        if (count($pollisomajData) > 0) {
            $pollisomajDataUpdate                      = PollisomajDataModel::find($pollisomajData[0]->id);
            // $pollisomajDataUpdate->pollisomaj_data_ref = $request->session()->get('current_pollisomaj_store_session');

            $pollisomajDataUpdate->food_for_work_girls           = $request->input('food_for_work_girls');
            $pollisomajDataUpdate->food_for_work_women           = $request->input('food_for_work_women');
            $pollisomajDataUpdate->food_for_work_transgender     = $request->input('food_for_work_transgender');
            $pollisomajDataUpdate->food_for_work_girls_pwd       = $request->input('food_for_work_girls_pwd');
            $pollisomajDataUpdate->food_for_work_women_pwd       = $request->input('food_for_work_women_pwd');
            $pollisomajDataUpdate->food_for_work_transgender_pwd = $request->input('food_for_work_transgender_pwd');

            $pollisomajDataUpdate->vgf_vgd_girls           = $request->input('vgf_vgd_girls');
            $pollisomajDataUpdate->vgf_vgd_women           = $request->input('vgf_vgd_women');
            $pollisomajDataUpdate->vgf_vgd_transgender     = $request->input('vgf_vgd_transgender');
            $pollisomajDataUpdate->vgf_vgd_girls_pwd       = $request->input('vgf_vgd_girls_pwd');
            $pollisomajDataUpdate->vgf_vgd_women_pwd       = $request->input('vgf_vgd_women_pwd');
            $pollisomajDataUpdate->vgf_vgd_transgender_pwd = $request->input('vgf_vgd_transgender_pwd');

            $pollisomajDataUpdate->programe_for_poorest_girls           = $request->input('programe_for_poorest_girls');
            $pollisomajDataUpdate->programe_for_poorest_women           = $request->input('programe_for_poorest_women');
            $pollisomajDataUpdate->programe_for_poorest_transgender     = $request->input('programe_for_poorest_transgender');
            $pollisomajDataUpdate->programe_for_poorest_girls_pwd       = $request->input('programe_for_poorest_girls_pwd');
            $pollisomajDataUpdate->programe_for_poorest_women_pwd       = $request->input('programe_for_poorest_women_pwd');
            $pollisomajDataUpdate->programe_for_poorest_transgender_pwd = $request->input('programe_for_poorest_transgender_pwd');

            $pollisomajDataUpdate->maternity_allowance_girls           = $request->input('maternity_allowance_girls');
            $pollisomajDataUpdate->maternity_allowance_women           = $request->input('maternity_allowance_women');
            $pollisomajDataUpdate->maternity_allowance_transgender     = $request->input('maternity_allowance_transgender');
            $pollisomajDataUpdate->maternity_allowance_girls_pwd       = $request->input('maternity_allowance_girls_pwd');
            $pollisomajDataUpdate->maternity_allowance_women_pwd       = $request->input('maternity_allowance_women_pwd');
            $pollisomajDataUpdate->maternity_allowance_transgender_pwd = $request->input('maternity_allowance_transgender_pwd');

            $pollisomajDataUpdate->freedom_fighters_girls           = $request->input('freedom_fighters_girls');
            $pollisomajDataUpdate->freedom_fighters_women           = $request->input('freedom_fighters_women');
            $pollisomajDataUpdate->freedom_fighters_transgender     = $request->input('freedom_fighters_transgender');
            $pollisomajDataUpdate->freedom_fighters_girls_pwd       = $request->input('freedom_fighters_girls_pwd');
            $pollisomajDataUpdate->freedom_fighters_women_pwd       = $request->input('freedom_fighters_women_pwd');
            $pollisomajDataUpdate->freedom_fighters_transgender_pwd = $request->input('freedom_fighters_transgender_pwd');

            $pollisomajDataUpdate->disaster_allocation_girls           = $request->input('disaster_allocation_girls');
            $pollisomajDataUpdate->disaster_allocation_women           = $request->input('disaster_allocation_women');
            $pollisomajDataUpdate->disaster_allocation_transgender     = $request->input('disaster_allocation_transgender');
            $pollisomajDataUpdate->disaster_allocation_girls_pwd       = $request->input('disaster_allocation_girls_pwd');
            $pollisomajDataUpdate->disaster_allocation_women_pwd       = $request->input('disaster_allocation_women_pwd');
            $pollisomajDataUpdate->disaster_allocation_transgender_pwd = $request->input('disaster_allocation_transgender_pwd');

            $pollisomajDataUpdate->relief_activities_girls           = $request->input('relief_activities_girls');
            $pollisomajDataUpdate->relief_activities_women           = $request->input('relief_activities_women');
            $pollisomajDataUpdate->relief_activities_transgender     = $request->input('relief_activities_transgender');
            $pollisomajDataUpdate->relief_activities_girls_pwd       = $request->input('relief_activities_girls_pwd');
            $pollisomajDataUpdate->relief_activities_women_pwd       = $request->input('relief_activities_women_pwd');
            $pollisomajDataUpdate->relief_activities_transgender_pwd = $request->input('relief_activities_transgender_pwd');

            $pollisomajDataUpdate->relief_gratuitous_girls           = $request->input('relief_gratuitous_girls');
            $pollisomajDataUpdate->relief_gratuitous_women           = $request->input('relief_gratuitous_women');
            $pollisomajDataUpdate->relief_gratuitous_transgender     = $request->input('relief_gratuitous_transgender');
            $pollisomajDataUpdate->relief_gratuitous_girls_pwd       = $request->input('relief_gratuitous_girls_pwd');
            $pollisomajDataUpdate->relief_gratuitous_women_pwd       = $request->input('relief_gratuitous_women_pwd');
            $pollisomajDataUpdate->relief_gratuitous_transgender_pwd = $request->input('relief_gratuitous_transgender_pwd');

            $pollisomajDataUpdate->one_house_one_firm_girls           = $request->input('one_house_one_firm_girls');
            $pollisomajDataUpdate->one_house_one_firm_women           = $request->input('one_house_one_firm_women');
            $pollisomajDataUpdate->one_house_one_firm_transgender     = $request->input('one_house_one_firm_transgender');
            $pollisomajDataUpdate->one_house_one_firm_girls_pwd       = $request->input('one_house_one_firm_girls_pwd');
            $pollisomajDataUpdate->one_house_one_firm_women_pwd       = $request->input('one_house_one_firm_women_pwd');
            $pollisomajDataUpdate->one_house_one_firm_transgender_pwd = $request->input('one_house_one_firm_transgender_pwd');

            $pollisomajDataUpdate->stipned_for_disabilities_girls           = $request->input('stipned_for_disabilities_girls');
            $pollisomajDataUpdate->stipned_for_disabilities_women           = $request->input('stipned_for_disabilities_women');
            $pollisomajDataUpdate->stipned_for_disabilities_transgender     = $request->input('stipned_for_disabilities_transgender');
            $pollisomajDataUpdate->stipned_for_disabilities_girls_pwd       = $request->input('stipned_for_disabilities_girls_pwd');
            $pollisomajDataUpdate->stipned_for_disabilities_women_pwd       = $request->input('stipned_for_disabilities_women_pwd');
            $pollisomajDataUpdate->stipned_for_disabilities_transgender_pwd = $request->input('stipned_for_disabilities_transgender_pwd');

            $pollisomajDataUpdate->others_girls           = $request->input('others_girls');
            $pollisomajDataUpdate->others_women           = $request->input('others_women');
            $pollisomajDataUpdate->others_transgender     = $request->input('others_transgender');
            $pollisomajDataUpdate->others_girls_pwd       = $request->input('others_girls_pwd');
            $pollisomajDataUpdate->others_women_pwd       = $request->input('others_women_pwd');
            $pollisomajDataUpdate->others_transgender_pwd = $request->input('others_transgender_pwd');
            $pollisomajDataUpdate->last_update_by = auth()->user()->id;
            $pollisomajDataUpdate->save();
        } else {
            return redirect()->route('data.pollisomaj.add');
        }
        if ($request->has('save_destroy')) {
            // $request->session()->forget('current_pollisomaj_store_session');
            $request->session()->forget('p_edit_mode');
            return redirect()->route('incident.pollisomaj.viewpollisomajlist');
        }
        $data['regions']        = getRegionByUserType();
        $data['step']           = $request->step;
        $data['auth_user']      = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        $data['pollisomajData'] = $pollisomajData;
        return view('backend.pollisomaj.pollisomajdata.create')->with($data);
    }

    public function addPollisomajStep6(Request $request) {
        // return  $request->pollisomaj_ref_id;
        // dd($request->all());
        $pollisomajData = PollisomajDataModel::where('pollisomaj_data_ref', $request->pollisomaj_ref_id)->get();
        if (count($pollisomajData) > 0) {
            $pollisomajDataUpdate                      = PollisomajDataModel::find($pollisomajData[0]->id);
            // $pollisomajDataUpdate->pollisomaj_data_ref = $request->session()->get('current_pollisomaj_store_session');

            $pollisomajDataUpdate->no_of_session_with_men                               = $request->input('no_of_session_with_men');
            $pollisomajDataUpdate->session_with_men_total                               = $request->input('session_with_men_total');
            $pollisomajDataUpdate->session_with_men_pwd_total                           = $request->input('session_with_men_pwd_total');
            $pollisomajDataUpdate->no_of_session_with_women                             = $request->input('no_of_session_with_women');
            $pollisomajDataUpdate->session_with_women_total                             = $request->input('session_with_women_total');
            $pollisomajDataUpdate->session_with_women_pwd_total                         = $request->input('session_with_women_pwd_total');
            $pollisomajDataUpdate->no_of_session_with_adolescent                        = $request->input('no_of_session_with_adolescent');
            $pollisomajDataUpdate->session_with_adolescent_boys                         = $request->input('session_with_adolescent_boys');
            $pollisomajDataUpdate->session_with_adolescent_girls                        = $request->input('session_with_adolescent_girls');
            $pollisomajDataUpdate->session_with_adolescent_total                        = $request->input('session_with_adolescent_total');
            $pollisomajDataUpdate->session_with_adolescent_pwd_total                    = $request->input('session_with_adolescent_pwd_total');
            $pollisomajDataUpdate->no_of_session_with_ps                                = $request->input('no_of_session_with_ps');
            $pollisomajDataUpdate->session_with_ps_boys                                 = $request->input('session_with_ps_boys');
            $pollisomajDataUpdate->session_with_ps_girls                                = $request->input('session_with_ps_girls');
            $pollisomajDataUpdate->session_with_ps_men                                  = $request->input('session_with_ps_men');
            $pollisomajDataUpdate->session_with_ps_women                                = $request->input('session_with_ps_women');
            $pollisomajDataUpdate->session_with_ps_transgender                          = $request->input('session_with_ps_transgender');
            $pollisomajDataUpdate->session_with_ps_pwd                                  = $request->input('session_with_ps_pwd');
            $pollisomajDataUpdate->session_with_ps_total                                = $request->input('session_with_ps_total');
            $pollisomajDataUpdate->capacity_building_training_by_selp_boy               = $request->input('capacity_building_training_by_selp_boy');
            $pollisomajDataUpdate->capacity_building_training_by_selp_girls             = $request->input('capacity_building_training_by_selp_girls');
            $pollisomajDataUpdate->capacity_building_training_by_selp_men               = $request->input('capacity_building_training_by_selp_men');
            $pollisomajDataUpdate->capacity_building_training_by_selp_women             = $request->input('capacity_building_training_by_selp_women');
            $pollisomajDataUpdate->capacity_building_training_by_selp_transgender       = $request->input('capacity_building_training_by_selp_transgender');
            $pollisomajDataUpdate->capacity_building_training_by_selp_total             = $request->input('capacity_building_training_by_selp_total');
            $pollisomajDataUpdate->capacity_building_training_by_selp_boy_pwd           = $request->input('capacity_building_training_by_selp_boy_pwd');
            $pollisomajDataUpdate->capacity_building_training_by_selp_girls_pwd         = $request->input('capacity_building_training_by_selp_girls_pwd');
            $pollisomajDataUpdate->capacity_building_training_by_selp_men_pwd           = $request->input('capacity_building_training_by_selp_men_pwd');
            $pollisomajDataUpdate->capacity_building_training_by_selp_women_pwd         = $request->input('capacity_building_training_by_selp_women_pwd');
            $pollisomajDataUpdate->capacity_building_training_by_selp_girls_transgender = $request->input('capacity_building_training_by_selp_girls_transgender');
            $pollisomajDataUpdate->capacity_building_training_by_selp_pwd_total         = $request->input('capacity_building_training_by_selp_pwd_total');
            $pollisomajDataUpdate->last_update_by = auth()->user()->id;
            $pollisomajDataUpdate->save();
        } else {
            return redirect()->route('data.pollisomaj.add');
        }
       
        if ($request->has('save_destroy')) {
            $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();
            if (isset($auth_user->user_role[0]['role_id']) && ($auth_user->user_role[0]['role_id'] == 4)) {
                $pollisomajDataUpdate->flag = 2;
                if($pollisomajDataUpdate->approve_date == null){
                    $pollisomajDataUpdate->approve_date = date( 'Y-m-d H:i:s', strtotime( 'now' ) );
                    $pollisomajDataUpdate->approve_by = auth()->user()->id;
                }
            } else if($auth_user->user_role[0]['role_id'] == 1 && $pollisomajData[0]->flag == 2 ) {
                $pollisomajDataUpdate->flag = 2;
            }else {
                $pollisomajDataUpdate->flag = 1;
                if($pollisomajDataUpdate->submit_date == null){
                    $pollisomajDataUpdate->submit_date = date( 'Y-m-d H:i:s', strtotime( 'now' ) );
                }
            }
            $pollisomajDataUpdate->last_update_by = auth()->user()->id;
            $pollisomajDataUpdate->save();
            // $request->session()->forget('current_pollisomaj_store_session');
            $request->session()->forget('p_edit_mode');
            if (isset($auth_user->user_role[0]['role_id']) && ($auth_user->user_role[0]['role_id'] == 4 || $auth_user->user_role[0]['role_id'] == 1)) {
                return redirect()->route('incident.pollisomaj.viewpollisomajApproveList')->with('success', 'Data Approved Successfully');
            } else {
                return redirect()->route('incident.pollisomaj.viewpollisomajPendingList')->with('success', 'Data Submitted Successfully');
            }
        }
        // $request->session()->forget('current_pollisomaj_store_session');
        return redirect()->route('incident.pollisomaj.viewpollisomajlist');

        // $data['regions']=Region::get();
        // $data['step']=$request->step;
        // $data['auth_user']   = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        // $data['pollisomajData']=$pollisomajData;
        // return view('backend.pollisomaj.pollisomajdata.create')->with($data);
    }

    public function addPollisomajStep7(Request $request) {
        dd($request->all());
        $pollisomajData = PollisomajDataModel::where('pollisomaj_data_ref',  $request->pollisomaj_ref_id)->get();
        if (count($pollisomajData) > 0) {
            $pollisomajDataUpdate                      = PollisomajDataModel::find($pollisomajData[0]->id);
            // $pollisomajDataUpdate->pollisomaj_data_ref = $request->session()->get('current_pollisomaj_store_session');

            $pollisomajDataUpdate->womens_day_celebration_boys               = $request->input('womens_day_celebration_boys');
            $pollisomajDataUpdate->womens_day_celebration_girls              = $request->input('womens_day_celebration_girls');
            $pollisomajDataUpdate->womens_day_celebration_men                = $request->input('womens_day_celebration_men');
            $pollisomajDataUpdate->womens_day_celebration_women              = $request->input('womens_day_celebration_women');
            $pollisomajDataUpdate->womens_day_celebration_transgender        = $request->input('womens_day_celebration_transgender');
            $pollisomajDataUpdate->womens_day_celebration_total              = $request->input('womens_day_celebration_total');
            $pollisomajDataUpdate->womens_day_celebration_date               = $request->input('womens_day_celebration_date');
            $pollisomajDataUpdate->womens_day_celebration_pwd_boys           = $request->input('womens_day_celebration_pwd_boys');
            $pollisomajDataUpdate->womens_day_celebration_pwd_girls          = $request->input('womens_day_celebration_pwd_girls');
            $pollisomajDataUpdate->womens_day_celebration_pwd_men            = $request->input('womens_day_celebration_pwd_men');
            $pollisomajDataUpdate->womens_day_celebration_pwd_women          = $request->input('womens_day_celebration_pwd_women');
            $pollisomajDataUpdate->womens_day_celebration_pwd_transgender    = $request->input('womens_day_celebration_pwd_transgender');
            $pollisomajDataUpdate->womens_day_celebration_pwd_total          = $request->input('womens_day_celebration_pwd_total');
            $pollisomajDataUpdate->celebration_days_campaign_boys            = $request->input('celebration_days_campaign_boys');
            $pollisomajDataUpdate->celebration_days_campaign_girls           = $request->input('celebration_days_campaign_girls');
            $pollisomajDataUpdate->celebration_days_campaign_men             = $request->input('celebration_days_campaign_men');
            $pollisomajDataUpdate->celebration_days_campaign_women           = $request->input('celebration_days_campaign_women');
            $pollisomajDataUpdate->celebration_days_campaign_transgender     = $request->input('celebration_days_campaign_transgender');
            $pollisomajDataUpdate->celebration_days_campaign_total           = $request->input('celebration_days_campaign_total');
            $pollisomajDataUpdate->celebration_days_campaign_date            = $request->input('celebration_days_campaign_date');
            $pollisomajDataUpdate->celebration_days_campaign_pwd_boys        = $request->input('celebration_days_campaign_pwd_boys');
            $pollisomajDataUpdate->celebration_days_campaign_pwd_girls       = $request->input('celebration_days_campaign_pwd_girls');
            $pollisomajDataUpdate->celebration_days_campaign_pwd_men         = $request->input('celebration_days_campaign_pwd_men');
            $pollisomajDataUpdate->celebration_days_campaign_pwd_women       = $request->input('celebration_days_campaign_pwd_women');
            $pollisomajDataUpdate->celebration_days_campaign_pwd_transgender = $request->input('celebration_days_campaign_pwd_transgender');
            $pollisomajDataUpdate->celebration_days_campaign_pwd_total       = $request->input('celebration_days_campaign_pwd_total');
            $pollisomajDataUpdate->legal_aid_days_boys                       = $request->input('legal_aid_days_boys');
            $pollisomajDataUpdate->legal_aid_days_girls                      = $request->input('legal_aid_days_girls');
            $pollisomajDataUpdate->legal_aid_days_men                        = $request->input('legal_aid_days_men');
            $pollisomajDataUpdate->legal_aid_days_women                      = $request->input('legal_aid_days_women');
            $pollisomajDataUpdate->legal_aid_days_transgender                = $request->input('legal_aid_days_transgender');
            $pollisomajDataUpdate->legal_aid_days_total                      = $request->input('legal_aid_days_total');
            $pollisomajDataUpdate->legal_aid_days_date                       = $request->input('legal_aid_days_date');
            $pollisomajDataUpdate->legal_aid_days_pwd_boys                   = $request->input('legal_aid_days_pwd_boys');
            $pollisomajDataUpdate->legal_aid_days_pwd_girls                  = $request->input('legal_aid_days_pwd_girls');
            $pollisomajDataUpdate->legal_aid_days_pwd_men                    = $request->input('legal_aid_days_pwd_men');
            $pollisomajDataUpdate->legal_aid_days_pwd_women                  = $request->input('legal_aid_days_pwd_women');
            $pollisomajDataUpdate->legal_aid_days_pwd_transgender            = $request->input('legal_aid_days_pwd_transgender');
            $pollisomajDataUpdate->legal_aid_days_pwd_total                  = $request->input('legal_aid_days_pwd_total');

            $pollisomajDataUpdate->save();
        } else {
            return redirect()->route('data.pollisomaj.add');
        }
        if ($request->has('save_destroy')) {
            $request->session()->forget('current_pollisomaj_store_session');
            $request->session()->forget('p_edit_mode');
            return redirect()->route('incident.pollisomaj.viewpollisomajlist');
        }
        
        $data['regions']        = getRegionByUserType();
        $data['step']           = $request->step;
        $data['auth_user']      = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        $data['pollisomajData'] = $pollisomajData;
        return view('backend.pollisomaj.pollisomajdata.create')->with($data);
    }

    public function addPollisomajStep8(Request $request) {
        // dd($request->all());
        $pollisomajData = PollisomajDataModel::where('pollisomaj_data_ref', $request->pollisomaj_ref_id)->get();
        if (count($pollisomajData) > 0) {
            $pollisomajDataUpdate                                                          = PollisomajDataModel::find($pollisomajData[0]->id);
            // $pollisomajDataUpdate->pollisomaj_data_ref                                     = $request->session()->get('current_pollisomaj_store_session');
            $pollisomajDataUpdate->social_cohesion_event                                   = $request->input('social_cohesion_event');
            $pollisomajDataUpdate->social_cohesion_event_date                              = date("Y-m-d", strtotime($request->input('social_cohesion_event_date')));
            $pollisomajDataUpdate->social_cohesion_event_participent_girl                  = $request->input('social_cohesion_event_participent_girl');
            $pollisomajDataUpdate->social_cohesion_event_participent_boy                   = $request->input('social_cohesion_event_participent_boy');
            $pollisomajDataUpdate->social_cohesion_event_participent_women                 = $request->input('social_cohesion_event_participent_women');
            $pollisomajDataUpdate->social_cohesion_event_participent_men                   = $request->input('social_cohesion_event_participent_men');
            $pollisomajDataUpdate->social_cohesion_event_participent_transgender           = $request->input('social_cohesion_event_participent_transgender');
            $pollisomajDataUpdate->social_cohesion_event_participent_total                 = $request->input('social_cohesion_event_participent_total');
            $pollisomajDataUpdate->upazila_stakeholder_meeting                             = $request->input('upazila_stakeholder_meeting');
            $pollisomajDataUpdate->upazila_stakeholder_meeting_date                        = date("Y-m-d", strtotime($request->input('upazila_stakeholder_meeting_date')));
            $pollisomajDataUpdate->upazila_stakeholder_meeting_participent_men_gob         = $request->input('upazila_stakeholder_meeting_participent_men_gob');
            $pollisomajDataUpdate->upazila_stakeholder_meeting_participent_women_gob       = $request->input('upazila_stakeholder_meeting_participent_women_gob');
            $pollisomajDataUpdate->upazila_stakeholder_meeting_participent_boy             = $request->input('upazila_stakeholder_meeting_participent_boy');
            $pollisomajDataUpdate->upazila_stakeholder_meeting_participent_girl            = $request->input('upazila_stakeholder_meeting_participent_girl');
            $pollisomajDataUpdate->upazila_stakeholder_meeting_participent_men             = $request->input('upazila_stakeholder_meeting_participent_men');
            $pollisomajDataUpdate->upazila_stakeholder_meeting_participent_women           = $request->input('upazila_stakeholder_meeting_participent_women');
            $pollisomajDataUpdate->upazila_stakeholder_meeting_participent_transgender     = $request->input('upazila_stakeholder_meeting_participent_transgender');
            $pollisomajDataUpdate->upazila_stakeholder_meeting_participent_total           = $request->input('upazila_stakeholder_meeting_participent_total');
            $pollisomajDataUpdate->upazila_stakeholder_meeting_participent_pwd_boy         = $request->input('upazila_stakeholder_meeting_participent_pwd_boy');
            $pollisomajDataUpdate->upazila_stakeholder_meeting_participent_pwd_girl        = $request->input('upazila_stakeholder_meeting_participent_pwd_girl');
            $pollisomajDataUpdate->upazila_stakeholder_meeting_participent_pwd_men         = $request->input('upazila_stakeholder_meeting_participent_pwd_men');
            $pollisomajDataUpdate->upazila_stakeholder_meeting_participent_pwd_women       = $request->input('upazila_stakeholder_meeting_participent_pwd_women');
            $pollisomajDataUpdate->upazila_stakeholder_meeting_participent_pwd_transgender = $request->input('upazila_stakeholder_meeting_participent_pwd_transgender');
            $pollisomajDataUpdate->upazila_stakeholder_meeting_participent_pwd_total       = $request->input('upazila_stakeholder_meeting_participent_pwd_total');

            // $pollisomajDataUpdate->client_workshop_date=date( "Y-m-d", strtotime( $request->input('client_workshop_date')));

            $pollisomajDataUpdate->save();
        } else {
            return redirect()->route('data.pollisomaj.add');
        }
        if ($request->has('save_destroy')) {
            $request->session()->forget('current_pollisomaj_store_session');
            $request->session()->forget('p_edit_mode');
            return redirect()->route('incident.pollisomaj.viewpollisomajlist');
        }
        $data['regions']        = getRegionByUserType();
        $data['step']           = $request->step;
        $data['auth_user']      = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        $data['pollisomajData'] = $pollisomajData;
        return view('backend.pollisomaj.pollisomajdata.create')->with($data);
    }

    public function addPollisomajStep9(Request $request) {
        
        //dd($request->all());
        $pollisomajData = PollisomajDataModel::where('pollisomaj_data_ref', $request->pollisomaj_ref_id)->get();
        if (count($pollisomajData) > 0) {
            $pollisomajDataUpdate                      = PollisomajDataModel::find($pollisomajData[0]->id);
            $pollisomajDataUpdate->pollisomaj_data_ref = $request->session()->get('current_pollisomaj_store_session');

            $pollisomajDataUpdate->panel_staff_workshop                     = $request->input('panel_staff_workshop');
            $pollisomajDataUpdate->panel_staff_date                         = date("Y-m-d", strtotime($request->input('panel_staff_date')));
            $pollisomajDataUpdate->panel_lawyer                             = $request->input('panel_lawyer');
            $pollisomajDataUpdate->panel_lawyer_date                        = date("Y-m-d", strtotime($request->input('panel_lawyer_date')));
            $pollisomajDataUpdate->external_network_dlac_meeting            = $request->input('external_network_dlac_meeting');
            $pollisomajDataUpdate->external_network_dlac_meeting_male       = $request->input('external_network_dlac_meeting_male');
            $pollisomajDataUpdate->external_network_dlac_meeting_female     = $request->input('external_network_dlac_meeting_female');
            $pollisomajDataUpdate->external_network_dlac_meeting_total      = $request->input('external_network_dlac_meeting_total');
            $pollisomajDataUpdate->external_network_dlac_meeting_date       = date("Y-m-d", strtotime($request->input('external_network_dlac_meeting_date')));
            $pollisomajDataUpdate->pt_group                                 = $request->input('pt_group');
            $pollisomajDataUpdate->pt_group_performer_boy                   = $request->input('pt_group_performer_boy');
            $pollisomajDataUpdate->pt_group_performer_girl                  = $request->input('pt_group_performer_girl');
            $pollisomajDataUpdate->pt_group_performer_men                   = $request->input('pt_group_performer_men');
            $pollisomajDataUpdate->pt_group_performer_women                 = $request->input('pt_group_performer_women');
            $pollisomajDataUpdate->pt_group_performer_transgender           = $request->input('pt_group_performer_transgender');
            $pollisomajDataUpdate->pt_group_performer_total                 = $request->input('pt_group_performer_total');
            $pollisomajDataUpdate->pt_group_performer_boy_pwd               = $request->input('pt_group_performer_boy_pwd');
            $pollisomajDataUpdate->pt_group_performer_girl_pwd              = $request->input('pt_group_performer_girl_pwd');
            $pollisomajDataUpdate->pt_group_performer_men_pwd               = $request->input('pt_group_performer_men_pwd');
            $pollisomajDataUpdate->pt_group_performer_women_pwd             = $request->input('pt_group_performer_women_pwd');
            $pollisomajDataUpdate->pt_group_performer_transgender_pwd       = $request->input('pt_group_performer_transgender_pwd');
            $pollisomajDataUpdate->pt_group_performer_transgender_pwd_total = $request->input('pt_group_performer_transgender_pwd_total');

            $pollisomajDataUpdate->save();
        } else {
            return redirect()->route('data.pollisomaj.add');
        }
        if ($request->has('save_destroy')) {
            $request->session()->forget('current_pollisomaj_store_session');
            $request->session()->forget('p_edit_mode');
            return redirect()->route('incident.pollisomaj.viewpollisomajlist');
        }
        $data['regions']        = getRegionByUserType();
        $data['step']           = $request->step;
        $data['auth_user']      = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        $data['pollisomajData'] = $pollisomajData;
        return view('backend.pollisomaj.pollisomajdata.create')->with($data);
    }

    public function addPollisomajStep10(Request $request) {
        //dd($request->all());
        $pollisomajData = PollisomajDataModel::where('pollisomaj_data_ref',  $request->pollisomaj_ref_id)->get();
        if (count($pollisomajData) > 0) {
            DB::beginTransaction();

            $pollisomajDataUpdate                      = PollisomajDataModel::find($pollisomajData[0]->id);
            $pollisomajDataUpdate->pollisomaj_data_ref = $request->session()->get('current_pollisomaj_store_session');

            $pollisomajDataUpdate->production_workshop_spa           = $request->input('production_workshop_spa');
            $pollisomajDataUpdate->production_workshop_cost_recovery = $request->input('production_workshop_cost_recovery');
            $pollisomajDataUpdate->production_workshop_project       = $request->input('production_workshop_project');
            $pollisomajDataUpdate->production_workshop_special       = $request->input('production_workshop_special');
            $pollisomajDataUpdate->production_workshop_other         = $request->input('production_workshop_other');

            PollisomajTheatreModel::where('pollisomaj_ref_id', $pollisomajDataUpdate->pollisomaj_data_ref)->where('pollisomaj_data_id', $pollisomajDataUpdate->id)->delete();
            //dd($temp);
            for ($i = 0; $i < count($request->spot_name); $i++) {
                // if($request->spot_name[$i]!=null){
                $item                     = new PollisomajTheatreModel;
                $item->pollisomaj_data_id = $pollisomajDataUpdate->id;
                $item->pollisomaj_ref_id  = $pollisomajDataUpdate->pollisomaj_data_ref;
                $item->spot_name          = $request->spot_name[$i];
                $item->theatre_theme      = $request->theatre_theme[$i];
                $item->theatre_category   = $request->theatre_category[$i];
                $item->par_girl           = $request->theatre_perticipent_girl[$i];
                $item->par_boy            = $request->theatre_perticipent_boy[$i];
                $item->par_women          = $request->theatre_perticipent_women[$i];
                $item->par_men            = $request->theatre_perticipent_men[$i];
                $item->par_transgender    = $request->theatre_perticipent_transgender[$i];
                $item->save();
                // }
            }

            $pollisomajDataUpdate->save();

            DB::commit();
        } else {
            return redirect()->route('data.pollisomaj.add');
        }
        if ($request->has('save_destroy')) {
            $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();
            if (isset($auth_user->user_role[0]['role_id']) && ($auth_user->user_role[0]['role_id'] == 4)) {
                $pollisomajDataUpdate->flag = 2;
            } else {
                $pollisomajDataUpdate->flag = 1;
            }

            $pollisomajDataUpdate->save();
            $request->session()->forget('current_pollisomaj_store_session');
            $request->session()->forget('p_edit_mode');
            return redirect()->route('incident.pollisomaj.viewpollisomajlist');
        }
        $request->session()->forget('current_pollisomaj_store_session');
        return redirect()->route('incident.pollisomaj.viewpollisomajlist');

    }

    public function viewPollisomaj(Request $request, $pollisomaj_ref_id = '') {
        //$data['list'] = PollisomajDataModel::with(['zones:id,region_name', 'division:id,name', 'district:id,name', 'upazilla:id,name', 'union:id,name'])->get();
        //dd($data['list'][0]->upazilla);
        $data['regions'] = getRegionByUserType();
        $auth_user       = User::with(['setup_user_area'])->where('id', Auth::id())->first();

        // if ($auth_user->user_role[0]['role_id'] == 5) {
        // } else {
        //     return redirect()->route('incident.pollisomaj.viewpollisomajPendingList');
        // }
        return redirect()->route('incident.pollisomaj.viewpollisomajDraftList');

        return view('backend.pollisomaj.pollisomajdata.list')->with($data);
    }

    public function getPollisomajdataDatatable(Request $request) {
        // dd($request->all());
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date   = date("Y-m-d", strtotime($request->to_date));
        // dd(Auth::id());
        // $auth_user      = User::with(['setup_user' => function ($query){
        //     $query->with(['setup_user_area']);
        // }])->where('id', Auth::id())->first();

        $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();

        $incidents = PollisomajDataModel::leftJoin('pollisomaj_setup', 'pollisomaj_data.union_id', '=', 'pollisomaj_setup.union_id')->select('pollisomaj_data.id', 'pollisomaj_data.pollisomaj_data_ref', 'pollisomaj_data.flag', 'pollisomaj_data.created_at', 'pollisomaj_data.updated_at', 'pollisomaj_setup.pollisomaj_name');
        // $allDivisions = RegionAreaDetail::where('region_id', $request->region_id)->where('status','1')->groupBy('division_id')->pluck('division_id')->toArray();
        $reagionDivision = RegionAreaDetail::where('region_id', $request->region_id)->where('division_id', $request->division_id)->where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
        // dd($reagionDivision);
        $allDistrict = RegionAreaDetail::where('region_id', $request->region_id)->where('status', '1')->groupBy('district_id')->pluck('district_id')->toArray();
        // dd($allDistrict);

        if (!empty($request->region_id) && empty($request->division_id)) {
            $incidents->whereIn('pollisomaj_data.district_id', $allDistrict);
        } else if (!empty($request->division_id) && empty($request->district_id)) {
            $incidents->whereIn('pollisomaj_data.district_id', $reagionDivision);
        } else {
            // if($request->division_id) {
            //     $incidents->where('employee_division_id', $request->division_id);
            // }
            if ($request->district_id) {
                $incidents->where('pollisomaj_data.district_id', $request->district_id);
            }
            if ($request->upazila_id) {
                $incidents->where('pollisomaj_data.upazilla_id', $request->upazila_id);
            }
            if ($request->union_id) {
                $incidents->where('pollisomaj_data.union_id', $request->union_id);
            }
        }
        // dd($incidents);

        // if($request->division_id) {
        //     $incidents->where('employee_division_id', $request->division_id);
        // }
        // if($request->district_id) {
        //     $incidents->where('employee_district_id', $request->district_id);
        // }
        // if($request->upazila_id) {
        //     $incidents->where('employee_upazila_id', $request->upazila_id);
        // }
        // if($request->union_id) {
        //     $incidents->where('survivor_union_id', $request->union_id);
        // }

        if ($auth_user->user_role[0]['role_id'] == 4) {
            $incidents->where('flag', 1);
        } else {
            $incidents->whereIn('flag', [0, 1, 2]);
        }
        $incidents->orderBy('pollisomaj_data.id', 'DESC');

        return DataTables::of($incidents)
            ->addIndexColumn()
        // ->addColumn('survivor_gender_id', function(SurvivorIncidentInformation $incident) {
        //     $output = '<ol>';
        //     if($incident->survivor_gender_id) {
        //         foreach($incident->survivor_gender_id as $value) {
        //             $output .= '<li>'.$value->name.'</li>';
        //         }
        //     }
        //     $output .= '</ol>';
        //     return $output;
        // })
            ->editColumn('created_at', function ($incidents) {
                return date('d-m-Y', strtotime($incidents->created_at));
            })
            ->editColumn('updated_at', function (PollisomajDataModel $incident) use ($auth_user) {
                // dd($auth_user->designation);
                $display = $incident->flag == 2 ? "d-none" : '';
                $links   = '<a href="' . route('pollisomaj.data.edit', $incident->pollisomaj_data_ref) . '" class="btn btn-sm btn-info' . $display . '" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
            <a href="' . route('pollisomaj.data.single.view', $incident->id) . '" target="__blank" class="btn btn-sm btn-primary" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                // $auth_user      = User::with(['setup_user_area'])->where('id', Auth::id())->first();
                // if ($auth_user->role_id == 2) {
                //     $links .=   '<a href="'.route('incident.violence.delete', $incident->id).'" class="btn btn-sm btn-danger deleteincident" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                // }
                return $links;
            })
            ->editColumn('flag', function ($list) {
                $actionBtn = '';
                if ($list->flag == 0 || $list->flag == null) {
                    $actionBtn = '<span class="badge badge-warning">Draft</span>';
                } elseif ($list->flag == 2) {
                    $actionBtn = '<span class="badge badge-success">Approved</span>';
                } else {
                    $actionBtn = '<span class="badge badge-primary">Pending for Approval</span>';
                }
                return $actionBtn;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);

    }

    public function singleViewPollisomajData($id) {
        $pdata = PollisomajDataModel::with(['pollisomaj_info', 'zones', 'division', 'district', 'upazilla', 'union'])->find($id)->toArray();
        // dd($pdata[0]);
        $pdata['pollisomaj'] = $pdata;
        // dd($pdata['pollisomaj']['id']);
        $view_link = 'backend.report.excel.single-pollisomaj-data';
        // return Excel::download(new MisReportExport($pdata,$view_link), 'pollisomaj-data.xlsx');
        return Excel::download(new MisReportExport($pdata, $view_link), 'Data_Entry_No' . '_' . $pdata['pollisomaj']['id'] . '.' . 'xlsx');
    }

    public function redirectNewPollisomajaddRoute(Request $request) {
        return redirect('/incident/pollisomaj/data/add?addnew=true');
    }

    public function getPollisomajInfo(Request $request) {
        $pollisomaj_no   = $request->pollisomaj_no;
        $pollisomaj_info = PollisomajSetup::where('pollisomaj_no', $request->pollisomaj_no)->first();
        $response        = $pollisomaj_info;

        return count((array) $response) > 0 ? response()->json($response) : null;
    }

    // Pollisomaj Draft List
    public function viewpollisomajDraftList() {
        // $data['list'] = PollisomajDataModel::with(['zones:id,region_name', 'division:id,name', 'district:id,name', 'upazilla:id,name', 'union:id,name'])->where('flag',0)->get();
        // dd($data['list']);
        //$data['regions']   = Region::get();
       
        $data['regions'] = getRegionByUserType();

        $data['auth_user'] = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        return view('backend.pollisomaj.pollisomajdata.pollisomaj_draft_list')->with($data);
    }

    public function getPollisomajDraftList(Request $request) {
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date   = date("Y-m-d", strtotime($request->to_date));

        $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();

        // if ($auth_user->user_role[0]['role_id'] == 5) {
        //     $pollisomaj_data    =   PollisomajDataModel::select('id', 'reporting_date', 'pollisomaj_data_ref','pollisomaj_id','pollisomaj_name','flag','created_at','updated_at')->where('employee_id', $auth_user->id);
        // }else{
        // }
        $pollisomaj_data = PollisomajDataModel::select('id', 'reporting_date', 'pollisomaj_data_ref', 'pollisomaj_id', 'pollisomaj_name', 'flag', 'created_at', 'updated_at');

        $pollisomaj_data = searchCriteriaPollishomaj($query = $pollisomaj_data, $data = ['region_id' => $request->region_id, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id, 'from_date' => $request->from_date, 'to_date' => $request->to_date]);

        // $reagionDivision    =   RegionAreaDetail::where('region_id',$request->region_id)->where('division_id', $request->division_id)->where('status','1')->groupBy('district_id')->pluck('district_id')->toArray();
        // $allDistrict        =   RegionAreaDetail::where('region_id',$request->region_id)->where('status','1')->groupBy('district_id')->pluck('district_id')->toArray();

        // if (!empty($request->region_id) && empty($request->division_id)) {
        //     $pollisomaj_data->whereIn('pollisomaj_data.district_id', $allDistrict);
        // } else if(!empty($request->division_id) && empty($request->district_id)){
        //     $pollisomaj_data->whereIn('pollisomaj_data.district_id', $reagionDivision);
        // } else {
        //     if($request->district_id) {
        //         $pollisomaj_data->where('pollisomaj_data.district_id', $request->district_id);
        //     }
        //     if($request->upazila_id) {
        //         $pollisomaj_data->where('pollisomaj_data.upazilla_id', $request->upazila_id);
        //     }
        //     if($request->union_id) {
        //         $pollisomaj_data->where('pollisomaj_data.union_id', $request->union_id);
        //     }
        // }

        // if($request->from_date) {
        //     $pollisomaj_data->where('reporting_date', '>=', $from_date);
        // }
        // if($request->to_date) {
        //     $pollisomaj_data->where('reporting_date', '<=', $to_date);
        // }

        $pollisomaj_data->where('flag', 0);
        $pollisomaj_data->orderBy('id', 'DESC');

        return DataTables::of($pollisomaj_data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($pollisomaj_data) {
                return date('d-m-Y', strtotime($pollisomaj_data->created_at));
            })
            ->editColumn('reporting_date', function ($pollisomaj_data) {
                return $pollisomaj_data->reporting_date != null ? date("d-m-Y", strtotime($pollisomaj_data->reporting_date)) : null;
            })
            ->editColumn('pollisomaj_data_ref', function ($pollisomaj_data) {
                $pollisomaj_ref      = explode('.', $pollisomaj_data->pollisomaj_data_ref);
                $pollisomaj_data_ref = formatIncidentId($pollisomaj_data->id);
                return $pollisomaj_data_ref;
            })
            ->editColumn('updated_at', function (PollisomajDataModel $data) use ($auth_user) {
                if ($auth_user->user_role[0]['role_id'] == 1 || $auth_user->user_role[0]['role_id'] == 4) {
                    $links = '<a href="' . route('view-single-pollisomaj', $data->id) . '" target="__blank" class="btn btn-sm btn-danger" title="PDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                <a href="' . route('pollisomaj.data.single.view', $data->id) . '" target="__blank" class="btn btn-sm btn-success" title="Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>';
                    return $links;
                } elseif ($auth_user->user_role[0]['role_id'] == 5) {
                    $links = '<a href="' . route('pollisomaj.data.edit', $data->pollisomaj_data_ref) . '" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
                <a href="' . route('view-single-pollisomaj', $data->id) . '" target="__blank" class="btn btn-sm btn-danger" title="PDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                <a href="' . route('pollisomaj.data.single.view', $data->id) . '" target="__blank" class="btn btn-sm btn-success" title="Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>';
                    return $links;
                } else {
                    $links = '<a href="' . route('view-single-pollisomaj', $data->id) . '" target="__blank" class="btn btn-sm btn-danger" title="PDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                <a href="' . route('pollisomaj.data.single.view', $data->id) . '" target="__blank" class="btn btn-sm btn-success" title="Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>';
                    return $links;
                }
                // <a href="#" class="btn btn-sm btn-danger delete_pollisomaj_data"  action_type="inc_del" id="'.$data->id.'" title="Delete"><i action_type="inc_del" class="fa fa-trash delete_pollisomaj_data" id="'.$data->id.'" aria-hidden="true"></i></a>
            })
            ->editColumn('flag', function ($list) {
                $actionBtn = '';
                if ($list->flag == 0 || $list->flag == null) {
                    $actionBtn = '<span class="badge badge-warning">Draft</span>';
                } elseif ($list->flag == 2) {
                    $actionBtn = '<span class="badge badge-success">Approved</span>';
                } else {
                    $actionBtn = '<span class="badge badge-primary">Pending for Approval</span>';
                }
                return $actionBtn;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    // Pollisomaj Pending List
    public function viewpollisomajPendingList() {
        // $data['list'] = PollisomajDataModel::with(['zones:id,region_name', 'division:id,name', 'district:id,name', 'upazilla:id,name', 'union:id,name'])->get();
        //$data['regions']   = Region::get();

        $data['regions'] = getRegionByUserType();

        $data['auth_user'] = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        return view('backend.pollisomaj.pollisomajdata.pollisomaj_pending_list')->with($data);
    }

    public function getPollisomajPendingList(Request $request) {
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date   = date("Y-m-d", strtotime($request->to_date));

        $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();

        // if ($auth_user->user_role[0]['role_id'] == 5) {
        //     $pollisomaj_data    =   PollisomajDataModel::select('id', 'reporting_date', 'pollisomaj_data_ref','pollisomaj_id','pollisomaj_name','flag','created_at','updated_at')->where('employee_id', $auth_user->id);
        // }else{
        // }
        $pollisomaj_data = PollisomajDataModel::select('id', 'reporting_date', 'pollisomaj_data_ref', 'pollisomaj_id', 'pollisomaj_name', 'flag', 'created_at', 'updated_at');

        $pollisomaj_data = searchCriteriaPollishomaj($query = $pollisomaj_data, $data = ['region_id' => $request->region_id, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id, 'from_date' => $request->from_date, 'to_date' => $request->to_date]);

        // $reagionDivision    =   RegionAreaDetail::where('region_id',$request->region_id)->where('division_id', $request->division_id)->where('status','1')->groupBy('district_id')->pluck('district_id')->toArray();
        // $allDistrict        =   RegionAreaDetail::where('region_id',$request->region_id)->where('status','1')->groupBy('district_id')->pluck('district_id')->toArray();

        // if (!empty($request->region_id) && empty($request->division_id)) {
        //     $pollisomaj_data->whereIn('pollisomaj_data.district_id', $allDistrict);
        // } else if(!empty($request->division_id) && empty($request->district_id)){
        //     $pollisomaj_data->whereIn('pollisomaj_data.district_id', $reagionDivision);
        // } else {
        //     if($request->district_id) {
        //         $pollisomaj_data->where('pollisomaj_data.district_id', $request->district_id);
        //     }
        //     if($request->upazila_id) {
        //         $pollisomaj_data->where('pollisomaj_data.upazilla_id', $request->upazila_id);
        //     }
        //     if($request->union_id) {
        //         $pollisomaj_data->where('pollisomaj_data.union_id', $request->union_id);
        //     }
        // }

        // if($request->from_date) {
        //     $pollisomaj_data->where('reporting_date', '>=', $from_date);
        // }
        // if($request->to_date) {
        //     $pollisomaj_data->where('reporting_date', '<=', $to_date);
        // }

        // if ($auth_user->user_role[0]['role_id'] == 4) {
        //     $pollisomaj_data->where('flag', 1);
        // } else {
        //     $pollisomaj_data->whereIn('flag', [0,1]);
        // }
        $pollisomaj_data->where('flag', 1);
        $pollisomaj_data->orderBy('id', 'DESC');

        return DataTables::of($pollisomaj_data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($pollisomaj_data) {
                return date('d-m-Y', strtotime($pollisomaj_data->created_at));
            })
            ->editColumn('reporting_date', function ($pollisomaj_data) {
                return $pollisomaj_data->reporting_date != null ? date("d-m-Y", strtotime($pollisomaj_data->reporting_date)) : null;
            })
            ->editColumn('pollisomaj_data_ref', function ($pollisomaj_data) {
                $pollisomaj_ref      = explode('.', $pollisomaj_data->pollisomaj_data_ref);
                $pollisomaj_data_ref = formatIncidentId($pollisomaj_data->id);
                return $pollisomaj_data_ref;
            })
            ->editColumn('updated_at', function (PollisomajDataModel $data) use ($auth_user) {

                $links = '<a href="' . route('view-single-pollisomaj', $data->id) . '" target="__blank" class="btn btn-sm btn-danger" title="PDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
            <a href="' . route('pollisomaj.data.single.view', $data->id) . '" target="__blank" class="btn btn-sm btn-success" title="Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>';
                if ($auth_user->user_role[0]['role_id'] == 4) {
                    $links .= '&nbsp;<a href="' . route('pollisomaj.data.edit', $data->pollisomaj_data_ref) . '" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                }
                if ($auth_user->user_role[0]['role_id'] == 1) {
                    $links .= '&nbsp;<a href="#" class="btn btn-sm btn-danger delete_pollisomaj_data"  action_type="inc_del" id="' . $data->id . '" title="Delete"><i action_type="inc_del" class="fa fa-trash delete_pollisomaj_data" id="' . $data->id . '" aria-hidden="true"></i></a>';
                }
                return $links;
            })
            ->editColumn('flag', function ($list) {
                $actionBtn = '';
                if ($list->flag == 0 || $list->flag == null) {
                    $actionBtn = '<span class="badge badge-warning">Draft</span>';
                } elseif ($list->flag == 2) {
                    $actionBtn = '<span class="badge badge-success">Approved</span>';
                } else {
                    $actionBtn = '<span class="badge badge-primary">Pending for Approval</span>';
                }
                return $actionBtn;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    // Pollisomaj Approve List
    public function viewpollisomajApproveList() {
        // $data['list'] = PollisomajDataModel::with(['zones:id,region_name', 'division:id,name', 'district:id,name', 'upazilla:id,name', 'union:id,name'])->get();
        //$data['regions']   = Region::get();

        $data['regions'] = getRegionByUserType();

        $data['auth_user'] = User::with(['setup_user_area'])->where('id', Auth::id())->first();
        return view('backend.pollisomaj.pollisomajdata.pollisomaj_approved_list')->with($data);
    }

    public function getPollisomajApproveList(Request $request) {
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date   = date("Y-m-d", strtotime($request->to_date));

        $auth_user = User::with(['setup_user_area'])->where('id', Auth::id())->first();

        // if ($auth_user->user_role[0]['role_id'] == 5) {
        //     $pollisomaj_data    =   PollisomajDataModel::select('id', 'reporting_date', 'pollisomaj_data_ref','pollisomaj_id','pollisomaj_name','flag','created_at','updated_at')->where('employee_id', $auth_user->id);
        // }else{
        // }
        $pollisomaj_data = PollisomajDataModel::select('id', 'reporting_date', 'pollisomaj_data_ref', 'pollisomaj_id', 'pollisomaj_name', 'flag', 'created_at', 'updated_at');

        $pollisomaj_data = searchCriteriaPollishomaj($query = $pollisomaj_data, $data = ['region_id' => $request->region_id, 'division_id' => $request->division_id, 'district_id' => $request->district_id, 'upazila_id' => $request->upazila_id, 'from_date' => $request->from_date, 'to_date' => $request->to_date]);

        // $reagionDivision    = RegionAreaDetail::where('region_id',$request->region_id)->where('division_id', $request->division_id)->where('status','1')->groupBy('district_id')->pluck('district_id')->toArray();
        // $allDistrict        = RegionAreaDetail::where('region_id',$request->region_id)->where('status','1')->groupBy('district_id')->pluck('district_id')->toArray();

        // if (!empty($request->region_id) && empty($request->division_id)) {
        //     $pollisomaj_data->whereIn('pollisomaj_data.district_id', $allDistrict);
        // } else if(!empty($request->division_id) && empty($request->district_id)){
        //     $pollisomaj_data->whereIn('pollisomaj_data.district_id', $reagionDivision);
        // } else {
        //     if($request->district_id) {
        //         $pollisomaj_data->where('pollisomaj_data.district_id', $request->district_id);
        //     }
        //     if($request->upazila_id) {
        //         $pollisomaj_data->where('pollisomaj_data.upazilla_id', $request->upazila_id);
        //     }
        //     if($request->union_id) {
        //         $pollisomaj_data->where('pollisomaj_data.union_id', $request->union_id);
        //     }
        // }

        // if($request->from_date) {
        //     $pollisomaj_data->where('reporting_date', '>=', $from_date);
        // }
        // if($request->to_date) {
        //     $pollisomaj_data->where('reporting_date', '<=', $to_date);
        // }

        $pollisomaj_data->where('flag', 2);
        $pollisomaj_data->orderBy('id', 'DESC');

        return DataTables::of($pollisomaj_data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($pollisomaj_data) {
                return date('d-m-Y', strtotime($pollisomaj_data->created_at));
            })
            ->editColumn('reporting_date', function ($pollisomaj_data) {
                return $pollisomaj_data->reporting_date != null ? date("d-m-Y", strtotime($pollisomaj_data->reporting_date)) : null;
            })
            ->editColumn('pollisomaj_data_ref', function ($pollisomaj_data) {
                $pollisomaj_ref      = explode('.', $pollisomaj_data->pollisomaj_data_ref);
                $pollisomaj_data_ref = formatIncidentId($pollisomaj_data->id);
                return $pollisomaj_data_ref;
            })
            ->editColumn('updated_at', function (PollisomajDataModel $data) use ($auth_user) {
                $links = '';
                if($auth_user->user_role[0]['role_id'] == 1) {
                    $links = '<a href="' . route('pollisomaj.data.edit', $data->pollisomaj_data_ref) . '" class="btn btn-sm btn-info mr-1" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                }
                if ($auth_user->user_role[0]['role_id'] == 4 && $data->flag == 2) {
                    // $links = '<a href="' . route('pollisomaj.data.edit', $data->pollisomaj_data_ref) . '" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a> ';
                    $links .= '<a href="' . route('view-single-pollisomaj', $data->id) . '" target="__blank" class="btn btn-sm btn-danger" title="PDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                <a href="' . route('pollisomaj.data.single.view', $data->id) . '" target="__blank" class="btn btn-sm btn-success" title="Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>';
                } elseif ($auth_user->user_role[0]['role_id'] == 1) {
                    $links .= '<a href="' . route('view-single-pollisomaj', $data->id) . '" target="__blank" class="btn btn-sm btn-danger" title="PDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                <a href="' . route('pollisomaj.data.single.view', $data->id) . '" target="__blank" class="btn btn-sm btn-success" title="Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                <a href="#" class="btn btn-sm btn-danger delete_pollisomaj_data"  action_type="inc_del" id="' . $data->id . '" title="Delete"><i action_type="inc_del" class="fa fa-trash delete_pollisomaj_data" id="' . $data->id . '" aria-hidden="true"></i></a>';
                }else {
                    $links .= '<a href="' . route('view-single-pollisomaj', $data->id) . '" target="__blank" class="btn btn-sm btn-danger" title="PDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                <a href="' . route('pollisomaj.data.single.view', $data->id) . '" target="__blank" class="btn btn-sm btn-success" title="Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>';
                }
                return $links;
            })
            ->editColumn('flag', function ($list) {
                $actionBtn = '';
                if ($list->flag == 0 || $list->flag == null) {
                    $actionBtn = '<span class="badge badge-warning">Draft</span>';
                } elseif ($list->flag == 2) {
                    $actionBtn = '<span class="badge badge-success">Approved</span>';
                } else {
                    $actionBtn = '<span class="badge badge-primary">Pending for Approval</span>';
                }
                return $actionBtn;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);

    }

    public function deletePollisomajInfo(Request $request, $id) {
        DB::beginTransaction();

        try {
            $pollisomaj_tbl = PollisomajDataModel::find($id)->delete();
            DB::commit();
            return "Deleted Successfully";
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

}
