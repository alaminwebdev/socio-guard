<?php

namespace App\Http\Controllers\Backend\Admin\Setup;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\ReportHeader;
use App\Model\Admin\Setup\Religion;
use App\Model\Admin\Setup\Gender;
use App\Model\Admin\Setup\Occupation;
use App\Model\Admin\Setup\SurvivorRelationship;
use App\Model\Admin\Setup\MaritalStatus;
use App\Model\Admin\Setup\SurvivorSupportOrganization;
use App\Model\Admin\Setup\SurvivorFinalSupport;
use App\Model\Admin\Setup\SuprvivorInitialSupport;
use App\Model\Admin\Setup\SurvivorSituation;
use App\Model\Admin\Setup\SurvivorIncidentPlace;
use App\Model\Admin\Setup\SurvivorViolencePlace;
use App\Model\Admin\Setup\PerpetratorPlace;
use App\Model\Admin\Setup\ViolenceCategory;
use App\Model\Admin\Setup\PreviousViolenceCategory;
use App\Model\Admin\Setup\ViolenceSubCategory;
use App\Model\Admin\Setup\ViolenceName;
use App\Model\Admin\Setup\BracSupport;
use App\Model\Admin\Setup\OtherOrganizationSupport;
use App\Model\Admin\Setup\ViolenceReason;
use App\Model\Admin\Setup\LegelInitiativeReason;
use App\Model\Admin\Setup\SocialStatus;
use App\Model\Admin\Setup\EconomicCondition;
use App\Model\Admin\Setup\SurvivorAutisticInformation;
use App\Model\Admin\Setup\FamilyMember;
use App\Model\Admin\Setup\AccuseRelationship;
use App\Model\Admin\Followup\FollowupQuestionOption;
use App\Model\SelpIncidentModel;
use App\Model\Selpzone;
use Session;
use Auth;
use PDF;

class MasterSetupController extends Controller
{
	//Religion
    public function viewReligion(){
    	$allData = Religion::where('status','1')->get();
    	return view('backend.admin.setup.religion-view',compact('allData'));
    }

    public function addReligion(){
    	return view('backend.admin.setup.religion-add');
    }

    public function storeReligion(Request $request){
    	$data = new Religion();
		$data->name = $request->name;
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.religion.view')->with('success','Successfully Inserted');
    }

    public function editReligion($id){
    	$editData = Religion::find($id);
        return view('backend.admin.setup.religion-add',compact('editData'));
    }

    public function updateReligion(Request $request,$id){
    	$data = Religion::find($id);
		$data->name = $request->name;
        $data->updated_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.religion.view')->with('success','Successfully Updated');
    }

    public function deleteReligion(Request $request,$id){
		Religion::where('id', $id)->delete();
        return response()->json('deleted');
    }

    //Gender
    public function viewGender(){
    	$allData = Gender::where('status','1')->get();
    	return view('backend.admin.setup.gender-view',compact('allData'));
    }

    public function addGender(){
    	return view('backend.admin.setup.gender-add');
    }

    public function storeGender(Request $request){
    	$data = new Gender();
		$data->name = $request->name;
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.gender.view')->with('success','Successfully Inserted');
    }

    public function editGender($id){
    	$editData = Gender::find($id);
        return view('backend.admin.setup.gender-add',compact('editData'));
    }

    public function updateGender(Request $request,$id){
    	$data = Gender::find($id);
		$data->name = $request->name;
        $data->updated_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.gender.view')->with('success','Successfully Updated');
    }

    public function deleteGender(Request $request,$id){
		Gender::where('id', $id)->delete();
        return response()->json('deleted');
    }

    //Occupation
    public function viewOccupation(){
    	$allData = Occupation::where('status','1')->get();
    	return view('backend.admin.setup.occupation-view',compact('allData'));
    }

    public function addOccupation(){
        return view('backend.admin.setup.occupation-add');
    }

    public function storeOccupation(Request $request){
    	$data = new Occupation();
		$data->name = $request->name;
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.occupation.view')->with('success','Successfully Inserted');
    }

    public function editOccupation($id){
    	$editData = Occupation::find($id);
        return view('backend.admin.setup.occupation-add',compact('editData'));
    }

    public function updateOccupation(Request $request,$id){
    	$data = Occupation::find($id);
		$data->name = $request->name;
        $data->updated_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.occupation.view')->with('success','Successfully Updated');
    }

    public function deleteOccupation(Request $request,$id){
		Occupation::where('id', $id)->delete();
        return response()->json('deleted');
    }

    //Survivor
    public function viewSurvivor(){
    	$allData = SurvivorRelationship::where('status','1')->get();
    	return view('backend.admin.setup.survivor-relationship-view',compact('allData'));
    }

    public function addSurvivor(){
        return view('backend.admin.setup.survivor-relationship-add');
    }

    public function storeSurvivor(Request $request){
    	$data = new SurvivorRelationship();
		$data->name = $request->name;
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.survivors.view')->with('success','Successfully Inserted');
    }

    public function editSurvivor($id){
    	$editData = SurvivorRelationship::find($id);
        return view('backend.admin.setup.survivor-relationship-add',compact('editData'));
    }

    public function updateSurvivor(Request $request,$id){
    	$data = SurvivorRelationship::find($id);
		$data->name = $request->name;
        $data->updated_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.survivors.view')->with('success','Successfully Updated');
    }

    public function deleteSurvivor($id)
    {
        SurvivorRelationship::where('id', $id)->delete();
        return response()->json('deleted');
    }

    //Accuse Relationship
    public function viewAccuse(){
    	$allData = AccuseRelationship::where('status','1')->get();
    	return view('backend.admin.setup.accuse-relationship-view',compact('allData'));
    }

    public function addAccuse(){
        return view('backend.admin.setup.accuse-relationship-add');
    }

    public function storeAccuse(Request $request){
    	$data = new AccuseRelationship();
		$data->name = $request->name;
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.accuse.relationship.view')->with('success','Successfully Inserted');
    }

    public function editAccuse($id){
    	$editData = AccuseRelationship::find($id);
        return view('backend.admin.setup.accuse-relationship-add',compact('editData'));
    }

    public function updateAccuse(Request $request,$id){
    	$data = AccuseRelationship::find($id);
		$data->name = $request->name;
        $data->updated_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.accuse.relationship.view')->with('success','Successfully Updated');
    }

    public function deleteAccuse($id){
        AccuseRelationship::where('id', $id)->delete();
        return response()->json('deleted');
    }

    //Marital Status
    public function viewMarital(){
    	$allData = MaritalStatus::where('status','1')->get();
    	return view('backend.admin.setup.marital-status-view',compact('allData'));
    }

    public function addMarital(){
        return view('backend.admin.setup.marital-status-add');
    }

    public function storeMarital(Request $request){
    	$data = new MaritalStatus();
		$data->name = $request->name;
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.marital.status.view')->with('success','Successfully Inserted');
    }

    public function editMarital($id){
    	$editData = MaritalStatus::find($id);
        return view('backend.admin.setup.marital-status-add',compact('editData'));
    }

    public function updateMarital(Request $request,$id){
    	$data = MaritalStatus::find($id);
		$data->name = $request->name;
        $data->updated_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.marital.status.view')->with('success','Successfully Updated');
    }

    public function deleteMaritalStatus(Request $request,$id){
		MaritalStatus::where('id', $id)->delete();
        return response()->json('deleted');
    }

    //Survivors Support Organization
    public function viewSurvivorSupportOrganization(){
    	$allData = SurvivorSupportOrganization::where('status','1')->get();
    	return view('backend.admin.setup.survivor-support-organization-view',compact('allData'));
    }

    public function addSurvivorSupportOrganization(){
        return view('backend.admin.setup.survivor-support-organization-add');
    }

    public function storeSurvivorSupportOrganization(Request $request){
    	$data = new SurvivorSupportOrganization();
		$data->name = $request->name;
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.survivor.support.organization.view')->with('success','Successfully Inserted');
    }

    public function editSurvivorSupportOrganization($id){
    	$editData = SurvivorSupportOrganization::find($id);
        return view('backend.admin.setup.survivor-support-organization-add',compact('editData'));
    }

    public function updateSurvivorSupportOrganization(Request $request,$id){
    	$data = SurvivorSupportOrganization::find($id);
		$data->name = $request->name;
        $data->updated_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.survivor.support.organization.view')->with('success','Successfully Updated');
    }

    public function delete($id)
    {
        SurvivorSupportOrganization::where('id', $id)->delete();
        return response()->json('deleted');
    }

    //Survivors Final Support
    public function viewSurvivorFinalSupport(){
    	$allData = SurvivorFinalSupport::where('status','1')->get();
    	return view('backend.admin.setup.survivor-final-support-view',compact('allData'));
    }

    public function addSurvivorFinalSupport(){
    	$support_types = SurvivorSupportOrganization::where('status','1')->get();
        return view('backend.admin.setup.survivor-final-support-add',compact('support_types'));
    }

    public function storeSurvivorFinalSupport(Request $request){
    	$data = new SurvivorFinalSupport();
		$data->survivor_support_organization_id = $request->survivor_support_organization_id;
		$data->name = $request->name;
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.survivor.final.support.view')->with('success','Successfully Inserted');
    }

    public function editSurvivorFinalSupport($id){
    	$editData = SurvivorFinalSupport::find($id);
    	$support_types = SurvivorSupportOrganization::where('status','1')->get();
        return view('backend.admin.setup.survivor-final-support-add',compact('editData','support_types'));
    }

    public function updateSurvivorFinalSupport(Request $request,$id){
    	$data = SurvivorFinalSupport::find($id);
    	$data->survivor_support_organization_id = $request->survivor_support_organization_id;
		$data->name = $request->name;
        $data->updated_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.survivor.final.support.view')->with('success','Successfully Updated');
    }

    //Survivors Initial Support
    public function viewSuprvivorInitialSupport(){
    	$allData = SuprvivorInitialSupport::where('status','1')->get();
    	return view('backend.admin.setup.survivor-initial-support-view',compact('allData'));
    }

    public function addSuprvivorInitialSupport(){
        return view('backend.admin.setup.survivor-initial-support-add');
    }

    public function storeSuprvivorInitialSupport(Request $request){
    	$data = new SuprvivorInitialSupport();
		$data->name = $request->name;
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.survivor.initial.support.view')->with('success','Successfully Inserted');
    }

    public function editSuprvivorInitialSupport($id){
    	$editData = SuprvivorInitialSupport::find($id);
        return view('backend.admin.setup.survivor-initial-support-add',compact('editData'));
    }

    public function updateSuprvivorInitialSupport(Request $request,$id){
    	$data = SuprvivorInitialSupport::find($id);
		$data->name = $request->name;
        $data->updated_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.survivor.initial.support.view')->with('success','Successfully Updated');
    }

    public function deleteSuprvivorInitialSupport($id)
    {
        SuprvivorInitialSupport::where('id', $id)->delete();
        return response()->json('deleted');
    }

    //Survivors Situation
    public function viewSurvivorSituation(){
    	$allData = SurvivorSituation::where('status','1')->get();
    	return view('backend.admin.setup.survivor-situation-view',compact('allData'));
    }

    public function addSurvivorSituation(){
        return view('backend.admin.setup.survivor-situation-add');
    }

    public function storeSurvivorSituation(Request $request){
    	$data = new SurvivorSituation();
		$data->name = $request->name;
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.survivor.situation.view')->with('success','Successfully Inserted');
    }

    public function editSurvivorSituation($id){
    	$editData = SurvivorSituation::find($id);
        return view('backend.admin.setup.survivor-situation-add',compact('editData'));
    }

    public function updateSurvivorSituation(Request $request,$id){
    	$data = SurvivorSituation::find($id);
		$data->name = $request->name;
        $data->updated_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.survivor.situation.view')->with('success','Successfully Updated');
    }

    //Survivor-incident Place
    public function viewSurvivorIncidentPlace(){
        $allData = SurvivorIncidentPlace::where('status','1')->get();
        return view('backend.admin.setup.survivor-incident-place-view',compact('allData'));
    }

    public function addSurvivorIncidentPlace(){
        return view('backend.admin.setup.survivor-incident-place-add');
    }

    public function storeSurvivorIncidentPlace(Request $request){
        $data = new SurvivorIncidentPlace();
        $data->name = $request->name;
        $data->created_by = Auth::user()->id;
        $data->save();

        $followup_question_option = new FollowupQuestionOption();
        $followup_question_option->created_by = Auth::user()->id;
        $followup_question_option->followup_question_id = 1;
        $followup_question_option->option = $request->name;
        $followup_question_option->save();

        return redirect()->route('setup.survivor-incident.place.view')->with('success','Successfully Inserted');
    }

    public function editSurvivorIncidentPlace($id){
        $editData = SurvivorIncidentPlace::find($id);
        return view('backend.admin.setup.survivor-incident-place-add', compact('editData'));
    }

    public function updateSurvivorIncidentPlace(Request $request,$id){
        $data = SurvivorIncidentPlace::find($id);
        $data->name = $request->name;
        $data->updated_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.survivor-incident.place.view')->with('success','Successfully Updated');
    }

    //Survivor-violence Place
    public function viewSurvivorViolencePlace(){
        $allData = SurvivorViolencePlace::where('status','1')->get();
        return view('backend.admin.setup.survivor-violence-place-view',compact('allData'));
    }

    public function addSurvivorViolencePlace(){
        return view('backend.admin.setup.survivor-violence-place-add');
    }

    public function storeSurvivorViolencePlace(Request $request){
        $data = new SurvivorViolencePlace();
        $data->name = $request->name;
        $data->created_by = Auth::user()->id;
        $data->save();

        return redirect()->route('setup.survivor-violence.place.view')->with('success','Successfully Inserted');
    }

    public function editSurvivorViolencePlace($id){
        $editData = SurvivorViolencePlace::find($id);
        return view('backend.admin.setup.survivor-violence-place-add', compact('editData'));
    }

    public function updateSurvivorViolencePlace(Request $request,$id){
        $data = SurvivorViolencePlace::find($id);
        $data->name = $request->name;
        $data->updated_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.survivor-violence.place.view')->with('success','Successfully Updated');
    }

    public function deleteSurvivorViolencePlace($id)
    {
        $exist_data     =   SelpIncidentModel::where('violence_place_id', $id)->count();
		// dd($exist_data);
        if ($exist_data > 0) {
            return response()->json('notdeleted');
        } else {
            SurvivorViolencePlace::where('id', $id)->delete();
            return response()->json('deleted');
        }
    }

    //Perpetrator Place
    public function viewPerpetratorPlace(){
    	$allData = PerpetratorPlace::where('status','1')->get();
    	return view('backend.admin.setup.perpetrator-place-view',compact('allData'));
    }

    public function addPerpetratorPlace(){
        return view('backend.admin.setup.perpetrator-place-add');
    }

    public function storePerpetratorPlace(Request $request){
    	$data = new PerpetratorPlace();
		$data->name = $request->name;
        $data->created_by = Auth::user()->id;
        $data->save();

        return redirect()->route('setup.perpetrator.place.view')->with('success','Successfully Inserted');
    }

    public function editPerpetratorPlace($id){
    	$editData = PerpetratorPlace::find($id);
        return view('backend.admin.setup.perpetrator-place-add', compact('editData'));
    }

    public function updatePerpetratorPlace(Request $request,$id){
    	$data = PerpetratorPlace::find($id);
		$data->name = $request->name;
        $data->updated_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.perpetrator.place.view')->with('success','Successfully Updated');
    }

    //Violence Category
    public function viewViolenceCategory(){
    	$allData = ViolenceCategory::where('status','1')->get();
    	return view('backend.admin.setup.violence-category-view',compact('allData'));
    }

    public function addViolenceCategory(){
        return view('backend.admin.setup.violence-category-add');
    }

    public function storeViolenceCategory(Request $request){
    	$data = new ViolenceCategory();
		$data->name = $request->name;
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.violence.category.view')->with('success','Successfully Inserted');
    }

    public function editViolenceCategory($id){
    	$editData = ViolenceCategory::find($id);
        return view('backend.admin.setup.violence-category-add',compact('editData'));
    }

    public function updateViolenceCategory(Request $request,$id){
    	$data = ViolenceCategory::find($id);
		$data->name = $request->name;
        $data->updated_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.violence.category.view')->with('success','Successfully Updated');
    }

    public function deleteViolenceCategory($id)
    {
        $exist_data =   SelpIncidentModel::where('violence_reason_id', $id)->count();
		// dd($exist_data);
        if ($exist_data > 0) {
            return response()->json('notdeleted');
        } else {
            ViolenceCategory::where('id', $id)->delete();
            return response()->json('deleted');
        }
    }




    //Violence Previous Category
    public function viewPreviousViolenceCategory(){
    	$allData = PreviousViolenceCategory::get();
    	return view('backend.admin.setup.previous-violence-category-view',compact('allData'));
    }

    public function addPreviousViolenceCategory(){
        return view('backend.admin.setup.previous-violence-category-add');
    }

    public function storePreviousViolenceCategory(Request $request){
    	$data = new PreviousViolenceCategory();
		$data->name = $request->name;
        $data->status = $request->status;
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.previous.violence.category.view')->with('success','Successfully Inserted');
    }

    public function editPreviousViolenceCategory($id){
    	$editData = PreviousViolenceCategory::find($id);
        return view('backend.admin.setup.previous-violence-category-add',compact('editData'));
    }

    public function updatePreviousViolenceCategory(Request $request,$id){
    	$data = PreviousViolenceCategory::find($id);
		$data->name = $request->name;
        $data->status = $request->status;
        $data->updated_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.previous.violence.category.view')->with('success','Successfully Updated');
    }

    public function deletePreviousViolenceCategory($id)
    {
        PreviousViolenceCategory::where('id', $id)->delete();
        return response()->json('deleted');
    }

    //Violence Sub Category
    public function viewViolenceSubCategory(){
    	$allData = ViolenceSubCategory::where('status','1')->get();
    	return view('backend.admin.setup.violence-sub-category-view',compact('allData'));
    }

    public function addViolenceSubCategory(){
    	$violence_categories = ViolenceCategory::where('status','1')->get();
        return view('backend.admin.setup.violence-sub-category-add',compact('violence_categories'));
    }

    public function storeViolenceSubCategory(Request $request){
    	$data = new ViolenceSubCategory();
		$data->violence_category_id = $request->violence_category_id;
		$data->name = $request->name;
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.violence.sub-category.view')->with('success','Successfully Inserted');
    }

    public function editViolenceSubCategory($id){
    	$editData = ViolenceSubCategory::find($id);
    	$violence_categories = ViolenceCategory::where('status','1')->get();
        return view('backend.admin.setup.violence-sub-category-add',compact('editData','violence_categories'));
    }

    public function updateViolenceSubCategory(Request $request,$id){
    	$data = ViolenceSubCategory::find($id);
    	$data->violence_category_id = $request->violence_category_id;
		$data->name = $request->name;
        $data->updated_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.violence.sub-category.view')->with('success','Successfully Updated');
    }

    //Violence Name
    public function viewViolenceName(){
    	$allData = ViolenceName::where('status','1')->get();
    	return view('backend.admin.setup.violence-name-view',compact('allData'));
    }

    public function addViolenceName(){
    	$violence_categories = ViolenceCategory::where('status','1')->get();
        return view('backend.admin.setup.violence-name-add',compact('violence_categories'));
    }

    public function storeViolenceName(Request $request){
    	$data = new ViolenceName();
		$data->violence_category_id = $request->violence_category_id;
		$data->violence_sub_category_id = $request->violence_sub_category_id;
		$data->name = $request->name;
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.violence.name.view')->with('success','Successfully Inserted');
    }

    public function editViolenceName($id){
    	$editData = ViolenceName::find($id);
    	$violence_categories = ViolenceCategory::where('status','1')->get();
        return view('backend.admin.setup.violence-name-add',compact('editData','violence_categories'));
    }

    public function updateViolenceName(Request $request,$id){
    	$data = ViolenceName::find($id);
    	$data->violence_category_id = $request->violence_category_id;
    	$data->violence_sub_category_id = $request->violence_sub_category_id;
		$data->name = $request->name;
        $data->updated_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.violence.name.view')->with('success','Successfully Updated');
    }

    //Brack Support
    public function viewBracSupport(){
        $allData = BracSupport::where('status','1')->get();
        return view('backend.admin.setup.brac-support-view',compact('allData'));
    }

    public function addBracSupport(){
        return view('backend.admin.setup.brac-support-add');
    }

    public function storeBracSupport(Request $request){
        $data = new BracSupport();
        $data->name = $request->name;
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.brac.support.view')->with('success','Successfully Inserted');
    }

    public function editBracSupport($id){
        $editData = BracSupport::find($id);
        return view('backend.admin.setup.brac-support-add',compact('editData'));
    }

    public function updateBracSupport(Request $request,$id){
        $data = BracSupport::find($id);
        $data->name = $request->name;
        $data->updated_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.brac.support.view')->with('success','Successfully Updated');
    }

    //Other Organization Support
    public function viewOtherOrganizationSupport(){
        $allData = OtherOrganizationSupport::where('status','1')->get();
        return view('backend.admin.setup.other-organization-support-view',compact('allData'));
    }

    public function addOtherOrganizationSupport(){
        return view('backend.admin.setup.other-organization-support-add');
    }

    public function storeOtherOrganizationSupport(Request $request){
        $data = new OtherOrganizationSupport();
        $data->name = $request->name;
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.other.organization.support.view')->with('success','Successfully Inserted');
    }

    public function editOtherOrganizationSupport($id){
        $editData = OtherOrganizationSupport::find($id);
        return view('backend.admin.setup.other-organization-support-add',compact('editData'));
    }

    public function updateOtherOrganizationSupport(Request $request,$id){
        $data = OtherOrganizationSupport::find($id);
        $data->name = $request->name;
        $data->updated_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.other.organization.support.view')->with('success','Successfully Updated');
    }

    //Violence Reason
    public function viewViolenceReason(){
        $allData = ViolenceReason::where('status','1')->get();
        return view('backend.admin.setup.violence-reason-view',compact('allData'));
    }

    public function addViolenceReason(){
        return view('backend.admin.setup.violence-reason-add');
    }

    public function storeViolenceReason(Request $request){
        $data = new ViolenceReason();
        $data->name = $request->name;
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.violence.reason.view')->with('success','Successfully Inserted');
    }

    public function editViolenceReason($id){
        $editData = ViolenceReason::find($id);
        return view('backend.admin.setup.violence-reason-add',compact('editData'));
    }

    public function updateViolenceReason(Request $request,$id){
        $data = ViolenceReason::find($id);
        $data->name = $request->name;
        $data->updated_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.violence.reason.view')->with('success','Successfully Updated');
    }

    public function deleteViolenceReason($id)
    {
        $exist_data =   SelpIncidentModel::where('violence_reason_id', $id)->count();
		// dd($exist_data);
        if ($exist_data > 0) {
            return response()->json('notdeleted');
        } else {
            ViolenceReason::where('id', $id)->delete();
            return response()->json('deleted');
        }
    }

    //legel initiative Reason
    public function viewLegelInitiativeReason(){
        $allData = LegelInitiativeReason::where('status','1')->get();
        return view('backend.admin.setup.legel-initiative-reason-view',compact('allData'));
    }

    public function addLegelInitiativeReason(){
        return view('backend.admin.setup.legel-initiative-reason-add');
    }

    public function storeLegelInitiativeReason(Request $request){
        $data = new LegelInitiativeReason();
        $data->name = $request->name;
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.legel.reason.view')->with('success','Successfully Inserted');
    }

    public function editLegelInitiativeReason($id){
        $editData = LegelInitiativeReason::find($id);
        return view('backend.admin.setup.legel-initiative-reason-add',compact('editData'));
    }

    public function updateLegelInitiativeReason(Request $request,$id){
        $data = LegelInitiativeReason::find($id);
        $data->name = $request->name;
        $data->updated_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.legel.reason.view')->with('success','Successfully Updated');
    }

    //Social Status
    public function viewSocialStatus(){
        $allData = SocialStatus::where('status','1')->get();
        return view('backend.admin.setup.social-status-view',compact('allData'));
    }

    public function addSocialStatus(){
        return view('backend.admin.setup.social-status-add');
    }

    public function storeSocialStatus(Request $request){
        $data = new SocialStatus();
        $data->name = $request->name;
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.social.status.view')->with('success','Successfully Inserted');
    }

    public function editSocialStatus($id){
        $editData = SocialStatus::find($id);
        return view('backend.admin.setup.social-status-add',compact('editData'));
    }

    public function updateSocialStatus(Request $request,$id){
        $data = SocialStatus::find($id);
        $data->name = $request->name;
        $data->updated_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.social.status.view')->with('success','Successfully Updated');
    }

    //Economic Condition
    public function viewEconomicCondition(){
        $allData = EconomicCondition::where('status','1')->get();
        return view('backend.admin.setup.economic-condition-view',compact('allData'));
    }

    public function addEconomicCondition(){
        return view('backend.admin.setup.economic-condition-add');
    }

    public function storeEconomicCondition(Request $request){
        $data = new EconomicCondition();
        $data->name = $request->name;
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.economic.condition.view')->with('success','Successfully Inserted');
    }

    public function editEconomicCondition($id){
        $editData = EconomicCondition::find($id);
        return view('backend.admin.setup.economic-condition-add',compact('editData'));
    }

    public function updateEconomicCondition(Request $request,$id){
        $data = EconomicCondition::find($id);
        $data->name = $request->name;
        $data->updated_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.economic.condition.view')->with('success','Successfully Updated');
    }

    //Survivor Autistic
    public function viewSurvivorAutisticInformation(){
        $allData = SurvivorAutisticInformation::where('status','1')->get();
        return view('backend.admin.setup.surviovr-autistic-view',compact('allData'));
    }

    public function addSurvivorAutisticInformation(){
        return view('backend.admin.setup.surviovr-autistic-add');
    }

    public function storeSurvivorAutisticInformation(Request $request){
        $data = new SurvivorAutisticInformation();
        $data->name = $request->name;
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.surviovr.autistic.view')->with('success','Successfully Inserted');
    }

    public function editSurvivorAutisticInformation($id){
        $editData = SurvivorAutisticInformation::find($id);
        return view('backend.admin.setup.surviovr-autistic-add',compact('editData'));
    }

    public function updateSurvivorAutisticInformation(Request $request,$id){
        $data = SurvivorAutisticInformation::find($id);
        $data->name = $request->name;
        $data->updated_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.surviovr.autistic.view')->with('success','Successfully Updated');
    }

    public function deleteSurvivorAutisticInformation($id)
    {
        $exist_data =   SelpIncidentModel::where('survivor_disability_status', $id)->count();
		// dd($exist_data);
        if ($exist_data > 0) {
            return response()->json('notdeleted');
        } else {
            SurvivorAutisticInformation::where('id', $id)->delete();
            return response()->json('deleted');
        }
    }

    //Family Member
    public function viewFamilyMember(){
        $allData = FamilyMember::where('status','1')->get();
        return view('backend.admin.setup.family-member-view',compact('allData'));
    }

    public function addFamilyMember(){
        return view('backend.admin.setup.family-member-add');
    }

    public function storeFamilyMember(Request $request){
        $data = new FamilyMember();
        $data->name = $request->name;
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.family.member.view')->with('success','Successfully Inserted');
    }

    public function editFamilyMember($id){
        $editData = FamilyMember::find($id);
        return view('backend.admin.setup.family-member-add',compact('editData'));
    }

    public function updateFamilyMember(Request $request,$id){
        $data = FamilyMember::find($id);
        $data->name = $request->name;
        $data->updated_by = Auth::user()->id;
        $data->save();
        return redirect()->route('setup.family.member.view')->with('success','Successfully Updated');
    }

    public function deleteFamilyMember($id)
    {
        $exist_data =   SelpIncidentModel::where('defendant_family_member_id', $id)->count();
		// dd($exist_data);
        if ($exist_data > 0) {
            return response()->json('notdeleted');
        } else {
            FamilyMember::where('id', $id)->delete();
            return response()->json('deleted');
        }
    }
}
