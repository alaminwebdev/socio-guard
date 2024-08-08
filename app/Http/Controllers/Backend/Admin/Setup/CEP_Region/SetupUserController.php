<?php

namespace App\Http\Controllers\Backend\Admin\Setup\CEP_Region;

use App\Http\Controllers\Controller;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\CEP_Region\RegionAreaDetail;
use App\Model\Admin\Setup\CEP_Region\SetupUser;
use App\Model\Admin\Setup\CEP_Region\SetupUserArea;
use App\Model\Admin\Setup\District;
use App\Model\Admin\Setup\Division;
use App\Model\Admin\Setup\Union;
use App\Model\Admin\Setup\Upazila;
use App\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class SetupUserController extends Controller {
    private function isAreaAlreadyUsed($userId, $setUpuserId, $regionId, $divisionId, $districtId, $upazilaId, $unionId) {
        $previousData = SetupUserArea::withTrashed()->where('user_id', $userId)->where('region_id', $regionId)->where('district_id', $districtId)->where('division_id', $divisionId)->where('upazila_id', $upazilaId)->where('union_id', $unionId)->get();

        return $previousData;
    }
    public function view(Request $request) {
        //return redirect()->route('user.setup.view',['pin'=>'']);
        $regions = Region::with(['setup_user' => function ($query) {
            $query->withTrashed();
            $query->with(['user' => function ($query) {

                $query->with(['user_role' => function ($query) {
                    $query->with(['role_details']);
                }]);

            },
                'setup_user_area'    => function ($query) {
                    $query->withTrashed();
                    $query->with(['setup_user_division', 'setup_user_district', 'setup_user_upazila', 'setup_user_union']);
                }]);
        }])
            ->orderBy('id', 'ASC')
            ->get();
        $data['queryparam'] = $request;
        $data['userssetup'] = DB::table('setup_user_areas')
            ->join('users', 'users.id', '=', 'setup_user_areas.user_id')
            ->join('regions', 'regions.id', '=', 'setup_user_areas.region_id')
            ->select(DB::raw('regions.region_name,setup_user_areas.region_id,count(setup_user_areas.id) as Totaluser'))
            ->when($request, function ($query, $request) {
                if ($request->pin != null || isset($request->pin)) {
                    return $query->where('users.pin', $request->pin);
                }
                return $query;
            })
            ->groupBy('setup_user_areas.region_id')->paginate(3);
        //dd($data['userssetup']);
        $keys  = 0;
        $users = [];
        foreach ($regions as $key => $region) {
            foreach ($region->setup_user as $key1 => $setup_user) {
                foreach ($setup_user->setup_user_area as $key2 => $user_area) {
                    $role_rs                                        = count($setup_user->setup_user_area);
                    $users[$key]['region'][$keys]['id']             = $setup_user->id;
                    $users[$key]['region'][$keys]['status']         = $setup_user->status;
                    $users[$key]['region'][$keys]['date_from']      = $setup_user->date_from;
                    $users[$key]['region'][$keys]['date_to']        = $setup_user->date_to;
                    $users[$key]['region'][$keys]['region_name']    = $region->region_name;
                    $users[$key]['region'][$keys]['region_id']      = $region->id;
                    $users[$key]['region'][$keys]['area_date_from'] = $user_area->date_from;
                    $users[$key]['region'][$keys]['area_date_to']   = $user_area->date_to;
                    if ($key2 == 0) {
                        // dd($users[$key]['region'][$keys]);
                        $users[$key]['region'][$keys]['user']          = $setup_user->user->toArray();
                        $users[$key]['region'][$keys]['employee_name'] = $setup_user->employee_name;
                        if ($role_rs > 1) {
                            $users[$key]['region'][$keys]['role_rs'] = $role_rs;
                        } else {
                            $users[$key]['region'][$keys]['role_rs'] = '';
                        }
                    } else {
                        $users[$key]['region'][$keys]['name'] = '';
                    }

                    if (!empty($user_area->setup_user_division)) {
                        $users[$key]['region'][$keys]['division'] = $user_area->setup_user_division->name;
                    } else {
                        $users[$key]['region'][$keys]['division'] = '';
                    }

                    if (!empty($user_area->setup_user_district)) {
                        $users[$key]['region'][$keys]['district'] = $user_area->setup_user_district->name;
                    } else {
                        $users[$key]['region'][$keys]['district'] = '';
                    }

                    if (!empty($user_area->setup_user_upazila)) {
                        $users[$key]['region'][$keys]['upazila'] = $user_area->setup_user_upazila->name;
                    } else {
                        $users[$key]['region'][$keys]['upazila'] = '';
                    }

                    if (!empty($user_area->setup_user_union)) {
                        $users[$key]['region'][$keys]['union'] = $user_area->setup_user_union->name;
                    } else {
                        $users[$key]['region'][$keys]['union'] = '';
                    }

                    $keys++;
                }
            }
        }

        //dd($users);
        $data['users'] = $users;
        return view('backend.admin.setup.cep_region.user.new_view', $data);
        // return view('backend.admin.setup.cep_region.user.view', $data);
    }

    public function add() {
        $data['regions']       = Region::get();
        $data['employee_pins'] = User::select('id', 'pin')->get();
        return view('backend.admin.setup.cep_region.user.add', $data);
    }

    public function store(Request $request) {
        //dd( $request->all());

        // $check_setup_user = SetupUser::with(['setup_user_area'])
        //                     ->where(['user_id' => $request->user_id])
        //                     ->first();

        // dd($check_setup_user->toArray());

        $this->validate($request, [
            'employee_pin'  => 'required',
            'employee_name' => 'required',
            'user_id'       => 'required',
            'region_id'     => 'required',
        ]);

        try {

            DB::beginTransaction();
            for ($i = 0; $i < count($request->region_id); $i++) {

                $setup_user                = new SetupUser;
                $setup_user->employee_name = $request->employee_name;
                $setup_user->employee_pin  = $request->employee_pin;
                $setup_user->user_id       = $request->user_id;
                $setup_user->date_from     = date_create(date('d-m-Y'));
                $setup_user->region_id     = $request->region_id[$i];
                $setup_user->save();

                $setup_user_area                = new SetupUserArea;
                $setup_user_area->user_id       = $setup_user->user_id;
                $setup_user_area->setup_user_id = $setup_user->id;
                $setup_user_area->region_id     = $request->region_id[$i];
                $setup_user_area->division_id   = $request->division_id[$i];
                $setup_user_area->district_id   = $request->district_id[$i];
                $setup_user_area->upazila_id    = $request->upazila_id[$i];
                $setup_user_area->union_id      = $request->union_id[$i];
                $setup_user_area->date_from     = $request->date_from[$i];
                $setup_user_area->date_to       = $request->date_to[$i];
                $setup_user_area->deleted_at    = $request->date_to[$i];
                $setup_user_area->save();
                /**Unnecessery line of code start */
                if ($request->role_id == 3) {
                    $region_manager = RegionAreaDetail::with(['regional_division', 'regional_district'])
                        ->where(['region_id' => $request->region_id[$i]])
                        ->get();

                    // dd($region_manager->toArray());

                    foreach ($region_manager as $key => $value) {
                        // $setup_user_area = new SetupUserArea;
                        // $setup_user_area->user_id       = $setup_user->user_id;
                        // $setup_user_area->setup_user_id = $setup_user->id;
                        // $setup_user_area->region_id     = $request->region_id[$i];
                        // $setup_user_area->division_id   = $value->regional_division->id;
                        // $setup_user_area->district_id   = $value->regional_district->id;
                        // $setup_user_area->upazila_id    = null;
                        // $setup_user_area->union_id      = null;
                        // $setup_user_area->save();
                    }
                } else {
                    foreach ($request->division_id as $key => $value) {
                        // $setup_user_area = new SetupUserArea;
                        // $setup_user_area->user_id       = $setup_user->user_id;
                        // $setup_user_area->setup_user_id = $setup_user->id;
                        // $setup_user_area->region_id     = $request->region_id[$i];
                        // $setup_user_area->division_id   = $request->division_id[$key];
                        // $setup_user_area->district_id   = $request->district_id[$key];
                        // $setup_user_area->upazila_id    = $request->upazila_id[$key];
                        // $setup_user_area->union_id      = $request->union_id[$key];
                        // $setup_user_area->date_from      = $request->date_from[$i];
                        // $setup_user_area->save();
                    }
                }
                /**Unnecessery line of code end */
            }
            DB::commit();
            $request->session()->flash('success', "Successfully Inserted");
        } catch (Exception $e) {
            DB::rollBack();
            $request->session()->flash('error', "Some error occured");
        }

        return redirect()->route('user.setup.view');
    }

    public function edit($user_id, $region_id) {
        //return $user_id;

        $data['employee_pins'] = User::select('id', 'pin')->get();
        //dd($data['employee_pins']);
        $data['regions']   = Region::select('id', 'region_name')->get();
        $data['divisions'] = Division::select('id', 'name')->get();
        $data['districts'] = District::select('id', 'division_id', 'name')->get();
        $data['upazilas']  = Upazila::select('id', 'division_id', 'district_id', 'name')->get();
        $data['unions']    = Union::select('id', 'division_id', 'district_id', 'upazila_id', 'name')->get();
        $data['editData']  = SetupUser::withTrashed()->with(['user' => function ($query) {
            $query->with(['user_role' => function ($query) {
                $query->with(['role_details']);
            }]);
        },
            'region',
            'setup_user_area'                                           => function ($query) {
                // $query->withTrashed();
                $query->with(['setup_user_division', 'setup_user_district', 'setup_user_upazila', 'setup_user_union']);
                $query->orderBy('id', 'ASC');
            }])->where('user_id', $user_id)->get(); //find($id);
        $data['user_id'] = $user_id;
        // dd($data['editData']);
        if (count($data['editData']) < 1) {
            return redirect()->route('user.setup.add')->with('error', 'No user found');
        }

        //return $data['editData'];
        return view('backend.admin.setup.cep_region.user.edit', $data);
    }

    public function update(Request $request, $id) {
        //dd($request->toArray());

        // $check_setup_user = SetupUser::with(['setup_user_area'])
        //                     ->where(['user_id' => $request->user_id])
        //                     ->first();

        // dd($check_setup_user->toArray());

        $this->validate($request, [
            'employee_pin'  => 'required',
            'employee_name' => 'required',
            'user_id'       => 'required',
            'region_id'     => 'required',
        ]);

        SetupUser::where('user_id', $request->user_id)->whereIn('region_id', $request->region_id)->delete();

        $prevArr = SetupUser::where('user_id', $request->user_id)->whereNotIn('region_id', $request->region_id)->get();
        if (count($prevArr) > 0) {
            for ($i = 0; $i < count($prevArr); $i++) {
                $upData             = SetupUser::withTrashed()->find($prevArr[$i]->id);
                $upData->deleted_at = date_create(date('d-m-Y'));
                $upData->date_to    = date_create(date('d-m-Y'));
                $upData->save();
            }
        }
        try {

            DB::beginTransaction();
            for ($i = 0; $i < count($request->region_id); $i++) {

                $setup_user                = new SetupUser;
                $setup_user->employee_name = $request->employee_name;
                $setup_user->employee_pin  = $request->employee_pin;
                $setup_user->user_id       = $request->user_id;
                $setup_user->date_from     = date_create(date('d-m-Y'));
                $setup_user->region_id     = $request->region_id[$i];
                $setup_user->save();
                $existingData = $this->isAreaAlreadyUsed($request->user_id,
                    $setup_user->id,
                    $setup_user->region_id,
                    $request->division_id[$i],
                    $request->district_id[$i],
                    $request->upazila_id[$i],
                    $request->union_id[$i]
                );


                if (count($existingData) > 0) {
                    foreach ($existingData as $exist_setup_user_area) {

                        $exist_setup_user_area                  = SetupUserArea::withTrashed()->find($exist_setup_user_area->id);
                        $exist_setup_user_area->setup_user_id   = $setup_user->id;
                        
                        // Format date_to using DateTime
                        $dateFrom = DateTime::createFromFormat('Y-m-d', $request->date_from[$i]);
                        $dateTo = DateTime::createFromFormat('Y-m-d', $request->date_to[$i]);

                        $exist_setup_user_area->date_from   = $dateFrom ? $dateFrom->format('Y-m-d') : null;
                        $exist_setup_user_area->date_to     = $dateTo ? $dateTo->format('Y-m-d') : null;

                        // Format deleted_at using DateTime
                        $deletedAt = DateTime::createFromFormat('Y-m-d', $request->date_to[$i]);
                        if ($deletedAt) {
                            $deletedAt->setTime(23, 59, 59); 
                            $exist_setup_user_area->deleted_at = $deletedAt->format('Y-m-d H:i:s');
                        } else {
                            $exist_setup_user_area->deleted_at = null;
                        }

                        $exist_setup_user_area->save();
                    }

                    // $updateData             = SetupUserArea::withTrashed()->find($existingData[0]->id);
                    // $updateData->date_from  = $request->date_from[$i];
                    // $updateData->date_to    = $request->date_to[$i];
                    // $updateData->deleted_at = $request->date_to[$i];
                    // $updateData->save();

                } else {

                    $setup_user_area                = new SetupUserArea;
                    $setup_user_area->user_id       = $setup_user->user_id;
                    $setup_user_area->setup_user_id = $setup_user->id;
                    $setup_user_area->region_id     = $request->region_id[$i];
                    $setup_user_area->division_id   = $request->division_id[$i];
                    $setup_user_area->district_id   = $request->district_id[$i];
                    $setup_user_area->upazila_id    = $request->upazila_id[$i];
                    $setup_user_area->union_id      = $request->union_id[$i];
                    $setup_user_area->date_from     = $request->date_from[$i];
                    $setup_user_area->date_to       = $request->date_to[$i];
                    $setup_user_area->deleted_at    = $request->date_to[$i];
                    $setup_user_area->save();
                }

            }
            DB::commit();
            $request->session()->flash('success', "Successfully Inserted");
        } catch (Exception $e) {
            DB::rollBack();
            $request->session()->flash('error', "Some error occured");
        }
        // try {

        //     DB::beginTransaction();

        //     $setup_user = SetupUser::withTrashed()->find($id);
        //     if($setup_user->region_id == $request->region_id){
        //         $setup_user->employee_name = $request->employee_name;
        //         $setup_user->employee_pin  = $request->employee_pin;
        //         $setup_user->user_id       = $request->user_id;
        //         $setup_user->region_id     = $request->region_id;

        //         $setup_user->save();
        //     }else{
        //         $setup_user->delete();
        //         $setup_user = new SetupUser;
        //         $setup_user->employee_name = $request->employee_name;
        //         $setup_user->employee_pin  = $request->employee_pin;
        //         $setup_user->user_id       = $request->user_id;
        //         $setup_user->region_id     = $request->region_id;

        //         $setup_user->save();
        //     }
        //     $prevUserArea=SetupUserArea::where('setup_user_id', $id)->get();
        //     foreach($prevUserArea as $area){
        //         SetupUserArea::find($area->id)->delete();
        //     }

        //     foreach($request->division_id as $key => $value)
        //     {
        //         $setup_user_area = new SetupUserArea;
        //         $setup_user_area->user_id       = $setup_user->user_id;
        //         $setup_user_area->setup_user_id = $setup_user->id;
        //         $setup_user_area->region_id     = $request->region_id;
        //         $setup_user_area->division_id   = $request->division_id[$key];
        //         $setup_user_area->district_id   = $request->district_id[$key];
        //         $setup_user_area->upazila_id    = $request->upazila_id[$key];
        //         $setup_user_area->union_id      = $request->union_id[$key];
        //         $setup_user_area->date_from      = $request->date_from[$key];
        //         $existingData=$this->isAreaAlreadyUsed($setup_user_area->user_id,
        //                                 $setup_user_area->setup_user_id,
        //                                 $setup_user_area->region_id,
        //                                 $setup_user_area->division_id,
        //                                 $setup_user_area->district_id,
        //                                 $setup_user_area->upazila_id,
        //                                 $setup_user_area->union_id );

        //         if(count($existingData)==0){
        //             $setup_user_area->save();
        //         }
        //         else{
        //             $getPrevData=SetupUserArea::withTrashed()->find($existingData[0]->id);
        //             $getPrevData->deleted_at=null;
        //             $getPrevData->date_from=date_create($request->date_from[$key]);
        //             $getPrevData->date_to=null;
        //             $getPrevData->save();
        //         }

        //     }

        //     DB::commit();
        //     $request->session()->flash('success', "Successfully Updated");
        // } catch(Exception $e) {
        //     DB::rollBack();
        //     $request->session()->flash('error', "Some error occurred");
        // }

        return redirect()->route('user.setup.view');
    }

    public function delete($id) {
        // dd($id);

        SetupUser::find($id)->delete();
        $prevUserArea = SetupUserArea::where('setup_user_id', $id)->get();

        foreach ($prevUserArea as $area) {
            SetupUserArea::find($area->id)->delete();
        }

        return response()->json('deleted');
    }

    public function getUser(Request $request) {
        $employee_pin = $request->employee_pin;
        $users        = User::select('id', 'name', 'pin')
            ->with(['user_role' => function ($query) {
                $query->with(['role_details']);
            }])
            ->where('pin', $employee_pin)
            ->first();
        // dd($users->toArray());

        return response()->json($users);
    }

    public function getUserApi(Request $request) {
        $employee_pin = $request->employee_pin;
        // dd($employee_pin);
        // $string = file_get_contents("http://api.brac.net/v1/staffs?Key=c20f2758-9cd2-4a8d-9473-8fb89b9a677e&q=ProgramID=18&fields=PIN,StaffName,DesignationName,EmailID,MobileNo");
        $string = file_get_contents("http://api.brac.net/v1/staffs/" . $employee_pin . "?Key=7f50671f-09ce-4b68-ac75-5861b1fd22da&fields=StaffPIN,StaffName,ProjectName,DesignationName,EmailID,MobileNo");
        $json   = json_decode($string, true);
        // dd($json);
        // $user = [];
        // foreach ($json as $key => $value) {
        //     if ($value['PIN'] == $employee_pin) {
        //         $user['PIN']                = $value['PIN'];
        //         $user['StaffName']          = $value['StaffName'];
        //         $user['DesignationName']    = $value['DesignationName'];
        //         $user['EmailID']            = $value['EmailID'];
        //         $user['MobileNo']           = $value['MobileNo'];
        //     }
        // }
        // dd($user);

        return $json;
        // return response()->json($user);
    }

    public function getRegionalDivision(Request $request) {
        $region_id          = $request->region_id;
        $regional_divisions = getRegionalDivision($region_id, $division_id = '');

        return response()->json($regional_divisions);
    }

    public function getRegionalDivisionDistrict(Request $request) {
        $region_id   = $request->region_id;
        $division_id = $request->division_id;
        $districts   = getRegionalDivisionDistrict($region_id, $division_id, $district_id = '');

        return response()->json($districts);
    }

    public function getDistrictUpazila(Request $request) {
        $district_id = $request->district_id;
        $upazilas    = getDistrictUpazila($district_id, $upazila_id = '');

        return response()->json($upazilas);
    }

    public function getUpazilaUnion(Request $request) {
        $upazila_id = $request->upazila_id;
        $unions     = getUpazilaUnion($upazila_id, $union_id = '');

        return response()->json($unions);
    }

    public function getUpazilaPollisomaj(Request $request) {
        $upazila_id = $request->upazila_id;
        $union_id   = $request->union_id;
        $pollisomaj = getUpazilaPollisomaj($upazila_id, $union_id);

        return response()->json($pollisomaj);
    }

    public function getUnionVillage(Request $request) {
        $union_id = $request->union_id;
        $unions   = getUnionVillage($union_id, $village_id = '');

        return response()->json($unions);
    }

    public function changeSetupUserStatus(Request $request) {
        $user         = SetupUser::find($request->id);
        $user->status = $request->status;
        $user->save();

        return response()->json('changed');
    }
    public function changeUserRegionAreaStatus(Request $request) {
        $item         = SetupUserArea::findOrFail($request->id);
        $item->status = $request->status;
        $item->save();
        return response()->json('changed');
    }

    public function removeUserZoneDistrict(Request $request) {
        $regionArea = SetupUserArea::where('user_id', $request->user_id)->where('region_id', $request->region_id)->where('division_id', $request->division_id)->where('district_id', $request->district_id)->where('upazila_id', $request->upazila_id)->where('union_id', $request->union_id)->get();
        // dd($regionArea);
        if (count($regionArea) > 0) {

            $regionArea[0]->date_to    = $request->date_to == null ? date('d-m-Y') : $request->date_to;
            $regionArea[0]->deleted_at = $request->date_to == null ? date('d-m-Y') : $request->date_to;
            $regionArea[0]->save();
        }
    }
    public function newEditRefactor(Request $request) {
        try {

            DB::beginTransaction();
            for ($i = 0; $i < count($request->region_id); $i++) {

                $setup_user                = new SetupUser;
                $setup_user->employee_name = $request->employee_name;
                $setup_user->employee_pin  = $request->employee_pin;
                $setup_user->user_id       = $request->user_id;
                $setup_user->date_from     = date_create(date('d-m-Y'));
                $setup_user->region_id     = $request->region_id[$i];
                $setup_user->save();
                $existingData = $this->isAreaAlreadyUsed($request->user_id,
                    $setup_user->id->setup_user_id,
                    $setup_user->region_id->region_id,
                    $request->division_id[$i],
                    $request->district_id[$i],
                    $request->upazila_id[$i],
                    $request->union_id[$i]
                );

                if (count($existingData) > 0) {
                    $existingData->date_from  = $request->date_from[$i];
                    $existingData->date_to    = $request->date_to[$i];
                    $existingData->deleted_at = $request->date_to[$i];
                    $existingData[0]->save();
                } else {
                    $setup_user_area                = new SetupUserArea;
                    $setup_user_area->user_id       = $setup_user->user_id;
                    $setup_user_area->setup_user_id = $setup_user->id;
                    $setup_user_area->region_id     = $request->region_id[$i];
                    $setup_user_area->division_id   = $request->division_id[$i];
                    $setup_user_area->district_id   = $request->district_id[$i];
                    $setup_user_area->upazila_id    = $request->upazila_id[$i];
                    $setup_user_area->union_id      = $request->union_id[$i];
                    $setup_user_area->date_from     = $request->date_from[$i];
                    $setup_user_area->date_to       = $request->date_to[$i];
                    $setup_user_area->deleted_at    = $request->date_to[$i];
                    $setup_user_area->save();
                }

            }
            DB::commit();
            $request->session()->flash('success', "Successfully Inserted");
        } catch (Exception $e) {
            DB::rollBack();
            $request->session()->flash('error', "Some error occured");
        }
    }
}
