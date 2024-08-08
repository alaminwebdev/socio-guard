<?php

use Backend\Mastersetup\HeadOfficeActivityEventController;
use App\Model\ActivityModel;
use App\Model\DirectServiceType;
use App\Model\FollowUpInfo;
use App\Model\IncidentReferral;
use App\Model\PollisomajDataModel;
use App\Model\SelpIncidentModel;
use App\Model\SurvivorCourtCaseModel;
use App\Model\SurvivorDirectServiceModel;
use Backend\Mastersetup\AdrmoneyrecoverController;
use Backend\Mastersetup\AlternativeDisputeResolutionController;
use Backend\Mastersetup\BracProgramNameController;
use Backend\Mastersetup\BracsupporttypeController;
use Backend\Mastersetup\CampaignEventController;
use Backend\Mastersetup\CivilcaseController;
use Backend\Mastersetup\CommunityEventController;
use Backend\Mastersetup\EducationController;
use Backend\Mastersetup\FollowupController;
use Backend\Mastersetup\HouseholdTypeController;
use Backend\Mastersetup\JudgementstatusController;
use Backend\Mastersetup\MeetingEventController;
use Backend\Mastersetup\MoneyrecoverController;
use Backend\Mastersetup\PititioncaseController;
use Backend\Mastersetup\PolicecaseController;
use Backend\Mastersetup\PTproductionEventController;
use Backend\Mastersetup\PTshowEventController;
use Backend\Mastersetup\RefferalController;
use Backend\Mastersetup\SecondaryRefferalController;
use Backend\Mastersetup\SelpComingOrFailourController;
use Backend\Mastersetup\SelpFirstInitiativeController;
use Backend\Mastersetup\SelpZoneController;
use Backend\Mastersetup\SurvivorinitiativesController;
use Backend\Mastersetup\TrainingEventController;
use Backend\Mastersetup\ViolenceLocationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

// use App\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Route::get('/', function () {
//     return view('backend.index');
// });

// // Author@Nanosoft
// Route::get('/factory',function(){
//     return $users = factory(App\Model\Admin\Training\Trainer::class)->create();
// });

// all child marriage related routes
include __DIR__ . '/childmarriage.php';

//swapnosarothi all routs
include __DIR__ . '/swapnosarothi.php';

Route::get('/sqlinject', 'Backend\Admin\DefaultController@sqlinject');

Route::get('/', function () {
    return view('frontend.landing_page');
});

Route::get('/login', function () {
    return redirect()->route('login');
});

Route::get('/cache_clear', function () {
    try {
        Artisan::call('config:cache');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
    } catch (\Exception $e) {
        dd($e);
    }
});

Route::get('/pagenotfound', 'Backend\Admin\DefaultController@PageNotFound')->name('default.pagenotfound');
Route::get('masterlogin', 'Auth\LoginController@masterLogin')->name('masterlogin');

//UnAuthorize Page
Route::get('unauthorize', function () {
    return view('backend.unauthorize');
});

Auth::routes();
Route::get('/logout', 'Auth\LoginController@ssoLogout')->name('sso.logout');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/notifications', 'UserController@notifications')->name('notifications');
    Route::prefix('profile')->group(function () {
        Route::get('/edit', 'Backend\AdminController@editProfile')->name('profile.edit');
        Route::post('/update', 'Backend\AdminController@updateProfile')->name('profile.update');
    });
    Route::get('/incident-form', function () {
        return response()->download('public/VAWC-incident-form.pdf', 'VAWC-incident-form.pdf');
    })->name('incident-form');

    //admin division district upazila union
    Route::get('/get-division', 'Backend\Admin\DefaultController@getDivision')->name('default.get-division');
    Route::get('/get-region-district', 'Backend\Admin\DefaultController@getgetDistricByRegion')->name('default.get-region-district');

    Route::get('/get-region-upazila', 'Backend\Admin\DefaultController@getUpazilaByRegion')->name('default.get-region-upazila');

    Route::get('/get-district', 'Backend\Admin\DefaultController@getDistrict')->name('default.get-district');
    Route::get('/get-village', 'Backend\Admin\DefaultController@getVillage')->name('default.get-village');
    Route::get('/get-upazila', 'Backend\Admin\DefaultController@getUpazila')->name('default.get-upazila');
    Route::get('/get-district-master', 'Backend\Admin\DefaultController@getDistrictMaster')->name('default.get-district-master');
    Route::get('/get-upazila-master', 'Backend\Admin\DefaultController@getUpazilaMaster')->name('default.get-upazila-master');
    Route::get('/get-union', 'Backend\Admin\DefaultController@getUnion')->name('default.get-union');
    Route::get('/get-violence-sub-category', 'Backend\Admin\DefaultController@getViolenceSubCategory')->name('default.get-violence-sub-category');
    Route::get('/get-violence-name', 'Backend\Admin\DefaultController@getViolenceName')->name('default.get-violence-name');
    Route::get('/get-organization-name', 'Backend\Admin\DefaultController@getOrganizationName')->name('default.get-organization-name');
    Route::get('/get-support-name', 'Backend\Admin\DefaultController@getSupportName')->name('default.get-support-name');
    Route::get('/get-case-list', 'Backend\Admin\DefaultController@getCaseList')->name('default.get-case-list');
    Route::get('/get-employees', 'Backend\Admin\DefaultController@getEmployees')->name('default.get-employees');
    Route::get('/employees', 'Backend\Admin\DefaultController@employeesList')->name('default.get-employees-list');
    Route::get('/get-swapnosarothi-groups', 'Backend\Admin\DefaultController@getSwapnoSarothiGroups')->name('default.get-swapnosarothi-groups');

    Route::get('/get-employee-api', 'Backend\Admin\DefaultController@getEmployeeApi')->name('default.get-employees-api');

    //Below All Route is used to Control Admin Dashboard
    Route::group(['middleware' => ['permission']], function () {
        Route::get('/dashboard', 'Backend\AdminController@newDashboard')->name('dashboard');
        Route::get('/dashboard-perpetrator', 'Backend\AdminController@dashboardPerpetrator')->name('dashboardPerpetrator');
        Route::get('/dashboard-community', 'Backend\AdminController@dashboardCommunity')->name('dashboardCommunity');

        Route::get('/dashboard-adr-case', 'Backend\AdminController@dashboardAdrCase')->name('dashboardAdrCase');
        Route::get('/adrCase', 'Backend\AdminController@adrCase')->name('adrCase');
        Route::post('/adrCase/filter', 'Backend\AdminController@adrCaseFilter')->name('adrCaseFilter');

        Route::get('/dashboard2', 'Backend\AdminController@dashboardTwo')->name('dashboardTwo');
        Route::post('/filterData', 'Backend\AdminController@filterData')->name('filterData');
        Route::get('/getSupportData', 'Backend\AdminController@getSupportData')->name('getSupportData');

        Route::get('/ageRangeData', 'Backend\AdminController@ageRangeData')->name('ageRangeData');
        Route::post('/filterAgeRangeData', 'Backend\DashboardController@filterAgeRangeData')->name('filterAgeRangeData');

        Route::get('/adrMoney', 'Backend\AdminController@adrMoney')->name('adrMoney');
        Route::post('/filterAdrData', 'Backend\DashboardController@filterAdrData')->name('filterAdrData');

        Route::get('/topViolence', 'Backend\AdminController@topViolence')->name('topViolence');
        Route::post('/filterTopViolence', 'Backend\DashboardController@filterTopViolence')->name('filterTopViolence');

        Route::get('/survivorAge', 'Backend\AdminController@survivorAge')->name('survivorAge');
        Route::post('/filterSurvivorAge', 'Backend\DashboardController@filterSurvivorAge')->name('filterSurvivorAge');

        Route::post('/filterRecurrentViolence', 'Backend\DashboardController@filterRecurrentViolence')->name('filterRecurrentViolence');

        Route::get('/survivorEducation', 'Backend\AdminController@survivorEducation')->name('survivorEducation');
        Route::post('/filterSurvivorEducation', 'Backend\DashboardController@filterSurvivorEducation')->name('filterSurvivorEducation');

        Route::get('/defendantEducation', 'Backend\AdminController@defendantEducation')->name('defendantEducation');
        Route::post('/filterDefendantEducation', 'Backend\DashboardController@filterDefendantEducation')->name('filterDefendantEducation');

        Route::get('/defendantOccupation', 'Backend\AdminController@defendantOccupation')->name('defendantOccupation');
        Route::post('/filterDefendantOccupation', 'Backend\DashboardController@filterDefendantOccupation')->name('filterDefendantOccupation');

        Route::get('/defendantAge', 'Backend\AdminController@defendantAge')->name('defendantAge');
        Route::post('/filterDefendantAge', 'Backend\DashboardController@filterDefendantAge')->name('filterDefendantAge');

        Route::get('/cummunityViolence', 'Backend\AdminController@cummunityViolence')->name('cummunityViolence');
        Route::post('/filterCummunityViolence', 'Backend\DashboardController@filterCummunityViolence')->name('filterCummunityViolence');

        // Route::get('/admin', 'Backend\AdminController@tab1')->name('dashboard');
        Route::get('/tab2', 'Backend\AdminController@tab2')->name('tab2');
        Route::get('/tab3', 'Backend\AdminController@tab3')->name('tab3');
        Route::get('/tab4', 'Backend\AdminController@tab4')->name('tab4');

        Route::get('/get-survivor-information/getchart1', 'Backend\AdminController@getchart1')->name('survivor.all.information.getchart1');
        Route::get('/get-survivor-information/getchart2', 'Backend\AdminController@getchart2')->name('survivor.all.information.getchart2');
        Route::get('/get-survivor-information/getchart3', 'Backend\AdminController@getchart3')->name('survivor.all.information.getchart3');
        Route::get('/get-survivor-information/getchart4', 'Backend\AdminController@getchart4')->name('survivor.all.information.getchart4');
        Route::get('/get-survivor-information/getchart5', 'Backend\AdminController@getchart5')->name('survivor.all.information.getchart5');
        Route::get('/get-survivor-information/getchart6', 'Backend\AdminController@getchart6')->name('survivor.all.information.getchart6');
        Route::get('/get-survivor-information/getchart7', 'Backend\AdminController@getchart7')->name('survivor.all.information.getchart7');
        Route::get('/get-survivor-information/getchart8', 'Backend\AdminController@getchart8')->name('survivor.all.information.getchart8');
        Route::get('/get-survivor-information/getchart9', 'Backend\AdminController@getchart9')->name('survivor.all.information.getchart9');
        Route::get('/get-survivor-information/getchart12', 'Backend\AdminController@getchart12')->name('survivor.all.information.getchart12');
        Route::get('/get-survivor-information/getchart13', 'Backend\AdminController@getchart13')->name('survivor.all.information.getchart13');
        Route::get('/get-survivor-information/getchart14', 'Backend\AdminController@getchart14')->name('survivor.all.information.getchart14');
        Route::get('/get-survivor-information/getchart15', 'Backend\AdminController@getchart15')->name('survivor.all.information.getchart15');
        Route::get('/get-survivor-information/getchart16', 'Backend\AdminController@getchart16')->name('survivor.all.information.getchart16');
        Route::get('/get-survivor-information/getchart17', 'Backend\AdminController@getchart17')->name('survivor.all.information.getchart17');
        Route::get('/get-survivor-information/getchart18', 'Backend\AdminController@getchart18')->name('survivor.all.information.getchart18');
        Route::get('/get-survivor-information/getchart11', 'Backend\AdminController@getchart11')->name('survivor.all.information.getchart11');
        Route::get('/get-survivor-information/getchart21', 'Backend\AdminController@getchart21')->name('survivor.all.information.getchart21');
        Route::get('/get-survivor-information/getchart22', 'Backend\AdminController@getchart22')->name('survivor.all.information.getchart22');

        //menu List
        Route::group(['middleware' => ['developer']], function () {
            Route::get('/db_migrate', function () {
                $exitCode = Artisan::call('migrate', [
                    '--force' => true,
                ]);

                return $exitCode;
            });

            Route::get('/staff_api', 'Backend\DataMigrationController@staffApi')->name('staff.api');

            Route::prefix('menu')->group(function () {
                Route::get('/view', 'Backend\Menu\MenuController@index')->name('menu');
                Route::get('/add', 'Backend\Menu\MenuController@add')->name('menu.add');
                Route::post('/store', 'Backend\Menu\MenuController@store')->name('menu.store');
                Route::get('/edit/{id}', 'Backend\Menu\MenuController@edit')->name('menu.edit');
                Route::post('/update/{id}', 'Backend\Menu\MenuController@update')->name('menu.update');
                Route::get('/subparent', 'Backend\Menu\MenuController@getSubParent')->name('menu.getajaxsubparent');

                //Menu Icon
                Route::get('/icon', 'Backend\Menu\MenuIconController@index')->name('menu.icon');
                Route::post('icon/store', 'Backend\Menu\MenuIconController@store')->name('menu.icon.store');
                Route::get('icon/edit', 'Backend\Menu\MenuIconController@edit')->name('menu.icon.edit');
                Route::post('icon/update/{id}', 'Backend\Menu\MenuIconController@update')->name('menu.icon.update');
                Route::post('icon/delete', 'Backend\Menu\MenuIconController@delete')->name('menu.icon.delete');
            });
        });

        Route::prefix('user')->group(function () {
            Route::get('/', 'UserController@index')->name('user');
            Route::get('/add', 'UserController@add')->name('user.add');
            Route::post('/store', 'UserController@storeUser')->name('user.store');
            Route::get('/edit/{id}', 'UserController@editUser')->name('user.edit');
            Route::post('/update/{id}', 'UserController@updateUser')->name('user.update');
            Route::post('/delete', 'UserController@deleteUser')->name('user.delete');
            Route::get('/export-user', 'UserController@exportUser')->name('user.export');

            Route::get('/role', 'Backend\Menu\RoleController@index')->name('user.role');
            Route::get('/role/add', 'Backend\Menu\RoleController@add')->name('user.role.add');
            Route::post('/role/store', 'Backend\Menu\RoleController@store')->name('user.role.store');
            Route::get('/role/edit/{id}', 'Backend\Menu\RoleController@edit')->name('user.role.edit');
            Route::post('/role/update/{id}', 'Backend\Menu\RoleController@update')->name('user.role.update');
            Route::get('/role/delete/{id}', 'Backend\Menu\RoleController@delete')->name('user.role.delete');

            Route::get('/permission', 'Backend\Menu\MenuPermissionController@index')->name('user.permission');
            Route::get('/permission/store', 'Backend\Menu\MenuPermissionController@storePermission')->name('user.permission.store');

            Route::prefix('region')->group(function () {
                // Ajax calls
                Route::get('/region-manager/change/status', 'Backend\Admin\Setup\Region_User\RegionManagerController@changeRegionManagerStatus')->name('changeRegionManagerStatus');

                // Region manager setup
                Route::get('/region-manager/view', 'Backend\Admin\Setup\Region_User\RegionManagerController@view')->name('user.region.region_manager.view');
                Route::get('/region-manager/add', 'Backend\Admin\Setup\Region_User\RegionManagerController@add')->name('user.region.region_manager.add');
                Route::post('/region-manager/store', 'Backend\Admin\Setup\Region_User\RegionManagerController@store')->name('user.region.region_manager.store');
                Route::get('/region-manager/edit/{id}', 'Backend\Admin\Setup\Region_User\RegionManagerController@edit')->name('user.region.region_manager.edit');
                Route::post('/region-manager/update/{id}', 'Backend\Admin\Setup\Region_User\RegionManagerController@update')->name('user.region.region_manager.update');
                Route::get('/region-manager/delete/{id}', 'Backend\Admin\Setup\Region_User\RegionManagerController@delete')->name('user.region.region_manager.delete');
            });

            // User setup
            Route::get('/setup/view', 'Backend\Admin\Setup\CEP_Region\SetupUserController@view')->name('user.setup.view');
            Route::get('/setup/add', 'Backend\Admin\Setup\CEP_Region\SetupUserController@add')->name('user.setup.add');
            Route::post('/setup/store', 'Backend\Admin\Setup\CEP_Region\SetupUserController@store')->name('user.setup.store');
            Route::get('/setup/edit/{user_id}/{region_id}', 'Backend\Admin\Setup\CEP_Region\SetupUserController@edit')->name('user.setup.edit');
            Route::post('/setup/update/{id}', 'Backend\Admin\Setup\CEP_Region\SetupUserController@update')->name('user.setup.update');
            Route::get('/setup/delete/{id}', 'Backend\Admin\Setup\CEP_Region\SetupUserController@delete')->name('user.setup.delete');

            Route::get('/setup/changeuserregionareastatus', 'Backend\Admin\Setup\CEP_Region\SetupUserController@changeUserRegionAreaStatus')->name('changeUserRegionAreaStatus');

            Route::get('/setup/user/zonedistrict/delete/', 'Backend\Admin\Setup\CEP_Region\SetupUserController@removeUserZoneDistrict')->name('setup.user.removeuserzonedistrict');
        });

        //Start Setup
        Route::prefix('setup')->group(function () {
            //Source
            Route::get('/source/view', 'Backend\Admin\Setup\InfoProviderSourceController@view')->name('setup.source.view');
            Route::get('/source/add', 'Backend\Admin\Setup\InfoProviderSourceController@add')->name('setup.source.add');
            Route::post('/source/store', 'Backend\Admin\Setup\InfoProviderSourceController@store')->name('setup.source.store');
            Route::get('/source/edit/{id}', 'Backend\Admin\Setup\InfoProviderSourceController@edit')->name('setup.source.edit');
            Route::post('/source/update/{id}', 'Backend\Admin\Setup\InfoProviderSourceController@update')->name('setup.source.update');
            Route::get('/source/delete/{id}', 'Backend\Admin\Setup\InfoProviderSourceController@delete')->name('setup.source.delete');
            //Organization Type
            Route::get('/organization/type/view', 'Backend\Admin\Setup\OrganizationTypeController@view')->name('setup.organization.type.view');
            Route::get('/organization/type/add', 'Backend\Admin\Setup\OrganizationTypeController@add')->name('setup.organization.type.add');
            Route::post('/organization/type/store', 'Backend\Admin\Setup\OrganizationTypeController@store')->name('setup.organization.type.store');
            Route::get('/organization/type/edit/{id}', 'Backend\Admin\Setup\OrganizationTypeController@edit')->name('setup.organization.type.edit');
            Route::post('/organization/type/update/{id}', 'Backend\Admin\Setup\OrganizationTypeController@update')->name('setup.organization.type.update');
            //Organization Name
            Route::get('/organization/view', 'Backend\Admin\Setup\OrganizationController@view')->name('setup.organization.view');
            Route::get('/organization/add', 'Backend\Admin\Setup\OrganizationController@add')->name('setup.organization.add');
            Route::post('/organization/store', 'Backend\Admin\Setup\OrganizationController@store')->name('setup.organization.store');
            Route::get('/organization/edit/{id}', 'Backend\Admin\Setup\OrganizationController@edit')->name('setup.organization.edit');
            Route::post('/organization/update/{id}', 'Backend\Admin\Setup\OrganizationController@update')->name('setup.organization.update');
            Route::get('/organization/delete/{id}', 'Backend\Admin\Setup\OrganizationController@delete')->name('setup.organization.delete');

            //Division
            Route::get('/division/view', 'Backend\Admin\Setup\SetupController@viewDivision')->name('setup.division.view');
            Route::get('/division/add', 'Backend\Admin\Setup\SetupController@addDivision')->name('setup.division.add');
            Route::post('/division/store', 'Backend\Admin\Setup\SetupController@storeDivision')->name('setup.division.store');
            Route::get('/division/edit/{id}', 'Backend\Admin\Setup\SetupController@editDivision')->name('setup.division.edit');
            Route::post('/division/update/{id}', 'Backend\Admin\Setup\SetupController@updateDivision')->name('setup.division.update');
            Route::get('/division/delete/{id}', 'Backend\Admin\Setup\SetupController@deleteDivision')->name('setup.division.delete');
            //District
            Route::get('/district/view', 'Backend\Admin\Setup\SetupController@viewDistrict')->name('setup.district.view');
            Route::get('/district/add', 'Backend\Admin\Setup\SetupController@addDistrict')->name('setup.district.add');
            Route::post('/district/store', 'Backend\Admin\Setup\SetupController@storeDistrict')->name('setup.district.store');
            Route::get('/district/edit/{id}', 'Backend\Admin\Setup\SetupController@editDistrict')->name('setup.district.edit');
            Route::post('/district/update/{id}', 'Backend\Admin\Setup\SetupController@updateDistrict')->name('setup.district.update');
            Route::get('/district/delete/{id}', 'Backend\Admin\Setup\SetupController@deleteDistrict')->name('setup.district.delete');
            //Upazila
            Route::get('/upazila/view', 'Backend\Admin\Setup\SetupController@viewUpazila')->name('setup.upazila.view');
            Route::get('/upazila/add', 'Backend\Admin\Setup\SetupController@addUpazila')->name('setup.upazila.add');
            Route::post('/upazila/store', 'Backend\Admin\Setup\SetupController@storeUpazila')->name('setup.upazila.store');
            Route::get('/upazila/edit/{id}', 'Backend\Admin\Setup\SetupController@editUpazila')->name('setup.upazila.edit');
            Route::post('/upazila/update/{id}', 'Backend\Admin\Setup\SetupController@updateUpazila')->name('setup.upazila.update');
            Route::get('/upazila/delete/{id}', 'Backend\Admin\Setup\SetupController@deleteUpazila')->name('setup.upazila.delete');
            //Union
            Route::get('/union/view', 'Backend\Admin\Setup\SetupController@viewUnion')->name('setup.union.view');
            Route::get('/union/add', 'Backend\Admin\Setup\SetupController@addUnion')->name('setup.union.add');
            Route::post('/union/store', 'Backend\Admin\Setup\SetupController@storeUnion')->name('setup.union.store');
            Route::get('/union/edit/{id}', 'Backend\Admin\Setup\SetupController@editUnion')->name('setup.union.edit');
            Route::post('/union/update/{id}', 'Backend\Admin\Setup\SetupController@updateUnion')->name('setup.union.update');
            Route::get('/union/delete/{id}', 'Backend\Admin\Setup\SetupController@deleteUnion')->name('setup.union.delete');
            Route::get('/getUnion', 'Backend\Admin\Setup\SetupController@getUnion')->name('setup.union.getUnion');
            //Village
            Route::get('/village/view', 'Backend\Admin\Setup\SetupController@viewVillage')->name('setup.village.view');
            Route::get('/village/add', 'Backend\Admin\Setup\SetupController@addVillage')->name('setup.village.add');
            Route::post('/village/store', 'Backend\Admin\Setup\SetupController@storeVillage')->name('setup.village.store');
            Route::get('/village/edit/{id}', 'Backend\Admin\Setup\SetupController@editVillage')->name('setup.village.edit');
            Route::post('/village/update/{id}', 'Backend\Admin\Setup\SetupController@updateVillage')->name('setup.village.update');
            Route::get('/village/delete/{id}', 'Backend\Admin\Setup\SetupController@deleteVillage')->name('setup.village.delete');
            Route::post('/village/import', 'Backend\Admin\Setup\SetupController@importVillage')->name('setup.village.import');
            //City Corporation
            Route::get('/city-corporation/view', 'Backend\Admin\Setup\SetupController@viewCityCorporation')->name('setup.city-corporation.view');
            Route::get('/city-corporation/add', 'Backend\Admin\Setup\SetupController@addCityCorporation')->name('setup.city-corporation.add');
            Route::post('/city-corporation/store', 'Backend\Admin\Setup\SetupController@storeCityCorporation')->name('setup.city-corporation.store');
            Route::get('/city-corporation/edit/{id}', 'Backend\Admin\Setup\SetupController@editCityCorporation')->name('setup.city-corporation.edit');
            Route::post('/city-corporation/update/{id}', 'Backend\Admin\Setup\SetupController@updateCityCorporation')->name('setup.city-corporation.update');
            //Pourosova
            Route::get('/pourosova/view', 'Backend\Admin\Setup\SetupController@viewPourosova')->name('setup.pourosova.view');
            Route::get('/pourosova/add', 'Backend\Admin\Setup\SetupController@addPourosova')->name('setup.pourosova.add');
            Route::post('/pourosova/store', 'Backend\Admin\Setup\SetupController@storePourosova')->name('setup.pourosova.store');
            Route::get('/pourosova/edit/{id}', 'Backend\Admin\Setup\SetupController@editPourosova')->name('setup.pourosova.edit');
            Route::post('/pourosova/update/{id}', 'Backend\Admin\Setup\SetupController@updatePourosova')->name('setup.pourosova.update');
            //Survivors Relationship
            Route::get('/survivors/view', 'Backend\Admin\Setup\MasterSetupController@viewSurvivor')->name('setup.survivors.view');
            Route::get('/survivors/add', 'Backend\Admin\Setup\MasterSetupController@addSurvivor')->name('setup.survivors.add');
            Route::post('/survivors/store', 'Backend\Admin\Setup\MasterSetupController@storeSurvivor')->name('setup.survivors.store');
            Route::get('/survivors/edit/{id}', 'Backend\Admin\Setup\MasterSetupController@editSurvivor')->name('setup.survivors.edit');
            Route::post('/survivors/update/{id}', 'Backend\Admin\Setup\MasterSetupController@updateSurvivor')->name('setup.survivors.update');
            Route::get('/survivors/delete/{id}', 'Backend\Admin\Setup\MasterSetupController@deleteSurvivor')->name('setup.survivors.delete');
            //Perpetrator/Accused Relationship
            Route::get('/accuse-relationship/view', 'Backend\Admin\Setup\MasterSetupController@viewAccuse')->name('setup.accuse.relationship.view');
            Route::get('/accuse-relationship/add', 'Backend\Admin\Setup\MasterSetupController@addAccuse')->name('setup.accuse.relationship.add');
            Route::post('/accuse-relationship/store', 'Backend\Admin\Setup\MasterSetupController@storeAccuse')->name('setup.accuse.relationship.store');
            Route::get('/accuse-relationship/edit/{id}', 'Backend\Admin\Setup\MasterSetupController@editAccuse')->name('setup.accuse.relationship.edit');
            Route::post('/accuse-relationship/update/{id}', 'Backend\Admin\Setup\MasterSetupController@updateAccuse')->name('setup.accuse.relationship.update');
            Route::get('/accuse-relationship/delete/{id}', 'Backend\Admin\Setup\MasterSetupController@deleteAccuse')->name('setup.accuse.relationship.delete');
            //Religion
            Route::get('/religion/view', 'Backend\Admin\Setup\MasterSetupController@viewReligion')->name('setup.religion.view');
            Route::get('/religion/add', 'Backend\Admin\Setup\MasterSetupController@addReligion')->name('setup.religion.add');
            Route::post('/religion/store', 'Backend\Admin\Setup\MasterSetupController@storeReligion')->name('setup.religion.store');
            Route::get('/religion/edit/{id}', 'Backend\Admin\Setup\MasterSetupController@editReligion')->name('setup.religion.edit');
            Route::post('/religion/update/{id}', 'Backend\Admin\Setup\MasterSetupController@updateReligion')->name('setup.religion.update');
            Route::get('/religion/delete/{id}', 'Backend\Admin\Setup\MasterSetupController@deleteReligion')->name('setup.religion.delete');
            //Gender
            Route::get('/gender/view', 'Backend\Admin\Setup\MasterSetupController@viewGender')->name('setup.gender.view');
            Route::get('/gender/add', 'Backend\Admin\Setup\MasterSetupController@addGender')->name('setup.gender.add');
            Route::post('/gender/store', 'Backend\Admin\Setup\MasterSetupController@storeGender')->name('setup.gender.store');
            Route::get('/gender/edit/{id}', 'Backend\Admin\Setup\MasterSetupController@editGender')->name('setup.gender.edit');
            Route::post('/gender/update/{id}', 'Backend\Admin\Setup\MasterSetupController@updateGender')->name('setup.gender.update');
            //Occupation
            Route::get('/occupation/view', 'Backend\Admin\Setup\MasterSetupController@viewOccupation')->name('setup.occupation.view');
            Route::get('/occupation/add', 'Backend\Admin\Setup\MasterSetupController@addOccupation')->name('setup.occupation.add');
            Route::post('/occupation/store', 'Backend\Admin\Setup\MasterSetupController@storeOccupation')->name('setup.occupation.store');
            Route::get('/occupation/edit/{id}', 'Backend\Admin\Setup\MasterSetupController@editOccupation')->name('setup.occupation.edit');
            Route::post('/occupation/update/{id}', 'Backend\Admin\Setup\MasterSetupController@updateOccupation')->name('setup.occupation.update');
            Route::get('/occupation/delete/{id}', 'Backend\Admin\Setup\MasterSetupController@deleteOccupation')->name('setup.occupation.delete');
            //Marital Status
            Route::get('/marital/status/view', 'Backend\Admin\Setup\MasterSetupController@viewMarital')->name('setup.marital.status.view');
            Route::get('/marital/status/add', 'Backend\Admin\Setup\MasterSetupController@addMarital')->name('setup.marital.status.add');
            Route::post('/marital/status/store', 'Backend\Admin\Setup\MasterSetupController@storeMarital')->name('setup.marital.status.store');
            Route::get('/marital/status/edit/{id}', 'Backend\Admin\Setup\MasterSetupController@editMarital')->name('setup.marital.status.edit');
            Route::post('/marital/status/update/{id}', 'Backend\Admin\Setup\MasterSetupController@updateMarital')->name('setup.marital.status.update');
            Route::get('/marital/status/delete/{id}', 'Backend\Admin\Setup\MasterSetupController@deleteMaritalStatus')->name('setup.marital.status.delete');
            //Survivors Support Organization
            Route::get('/survivor/support/organization/view', 'Backend\Admin\Setup\MasterSetupController@viewSurvivorSupportOrganization')->name('setup.survivor.support.organization.view');
            Route::get('/survivor/support/organization/add', 'Backend\Admin\Setup\MasterSetupController@addSurvivorSupportOrganization')->name('setup.survivor.support.organization.add');
            Route::post('/survivor/support/organization/store', 'Backend\Admin\Setup\MasterSetupController@storeSurvivorSupportOrganization')->name('setup.survivor.support.organization.store');
            Route::get('/survivor/support/organization/edit/{id}', 'Backend\Admin\Setup\MasterSetupController@editSurvivorSupportOrganization')->name('setup.survivor.support.organization.edit');
            Route::post('/survivor/support/organization/update/{id}', 'Backend\Admin\Setup\MasterSetupController@updateSurvivorSupportOrganization')->name('setup.survivor.support.organization.update');
            Route::get('/survivor/support/organization/delete/{id}', 'Backend\Admin\Setup\MasterSetupController@delete')->name('setup.survivor.support.organization.delete');
            //Survivors Final Support
            Route::get('/survivor/final/support/view', 'Backend\Admin\Setup\MasterSetupController@viewSurvivorFinalSupport')->name('setup.survivor.final.support.view');
            Route::get('/survivor/final/support/add', 'Backend\Admin\Setup\MasterSetupController@addSurvivorFinalSupport')->name('setup.survivor.final.support.add');
            Route::post('/survivor/final/support/store', 'Backend\Admin\Setup\MasterSetupController@storeSurvivorFinalSupport')->name('setup.survivor.final.support.store');
            Route::get('/survivor/final/support/edit/{id}', 'Backend\Admin\Setup\MasterSetupController@editSurvivorFinalSupport')->name('setup.survivor.final.support.edit');
            Route::post('/survivor/final/support/update/{id}', 'Backend\Admin\Setup\MasterSetupController@updateSurvivorFinalSupport')->name('setup.survivor.final.support.update');
            //Survivors Support
            Route::get('/survivor/initial/support/view', 'Backend\Admin\Setup\MasterSetupController@viewSuprvivorInitialSupport')->name('setup.survivor.initial.support.view');
            Route::get('/survivor/initial/support/add', 'Backend\Admin\Setup\MasterSetupController@addSuprvivorInitialSupport')->name('setup.survivor.initial.support.add');
            Route::post('/survivor/initial/support/store', 'Backend\Admin\Setup\MasterSetupController@storeSuprvivorInitialSupport')->name('setup.survivor.initial.support.store');
            Route::get('/survivor/initial/support/edit/{id}', 'Backend\Admin\Setup\MasterSetupController@editSuprvivorInitialSupport')->name('setup.survivor.initial.support.edit');
            Route::post('/survivor/initial/support/update/{id}', 'Backend\Admin\Setup\MasterSetupController@updateSuprvivorInitialSupport')->name('setup.survivor.initial.support.update');
            Route::get('/survivor/initial/support/delete/{id}', 'Backend\Admin\Setup\MasterSetupController@deleteSuprvivorInitialSupport')->name('setup.survivor.initial.support.delete');
            //Survivors Situation
            Route::get('/survivor/situation/view', 'Backend\Admin\Setup\MasterSetupController@viewSurvivorSituation')->name('setup.survivor.situation.view');
            Route::get('/survivor/situation/add', 'Backend\Admin\Setup\MasterSetupController@addSurvivorSituation')->name('setup.survivor.situation.add');
            Route::post('/survivor/situation/store', 'Backend\Admin\Setup\MasterSetupController@storeSurvivorSituation')->name('setup.survivor.situation.store');
            Route::get('/survivor/situation/edit/{id}', 'Backend\Admin\Setup\MasterSetupController@editSurvivorSituation')->name('setup.survivor.situation.edit');
            Route::post('/survivor/situation/update/{id}', 'Backend\Admin\Setup\MasterSetupController@updateSurvivorSituation')->name('setup.survivor.situation.update');
            //Survivors Place
            Route::get('/survivor-incident/place/view', 'Backend\Admin\Setup\MasterSetupController@viewSurvivorIncidentPlace')->name('setup.survivor-incident.place.view');
            Route::get('/survivor-incident/place/add', 'Backend\Admin\Setup\MasterSetupController@addSurvivorIncidentPlace')->name('setup.survivor-incident.place.add');
            Route::post('/survivor-incident/place/store', 'Backend\Admin\Setup\MasterSetupController@storeSurvivorIncidentPlace')->name('setup.survivor-incident.place.store');
            Route::get('/survivor-incident/place/edit/{id}', 'Backend\Admin\Setup\MasterSetupController@editSurvivorIncidentPlace')->name('setup.survivor-incident.place.edit');
            Route::post('/survivor-incident/place/update/{id}', 'Backend\Admin\Setup\MasterSetupController@updateSurvivorIncidentPlace')->name('setup.survivor-incident.place.update');
            //Violence Place
            Route::get('/survivor-violence/place/view', 'Backend\Admin\Setup\MasterSetupController@viewSurvivorViolencePlace')->name('setup.survivor-violence.place.view');
            Route::get('/survivor-violence/place/add', 'Backend\Admin\Setup\MasterSetupController@addSurvivorViolencePlace')->name('setup.survivor-violence.place.add');
            Route::post('/survivor-violence/place/store', 'Backend\Admin\Setup\MasterSetupController@storeSurvivorViolencePlace')->name('setup.survivor-violence.place.store');
            Route::get('/survivor-violence/place/edit/{id}', 'Backend\Admin\Setup\MasterSetupController@editSurvivorViolencePlace')->name('setup.survivor-violence.place.edit');
            Route::post('/survivor-violence/place/update/{id}', 'Backend\Admin\Setup\MasterSetupController@updateSurvivorViolencePlace')->name('setup.survivor-violence.place.update');
            Route::get('/survivor-violence/place/delete/{id}', 'Backend\Admin\Setup\MasterSetupController@deleteSurvivorViolencePlace')->name('setup.survivor-violence.place.delete');
            //Perpetrator Place
            Route::get('/perpetrator/place/view', 'Backend\Admin\Setup\MasterSetupController@viewPerpetratorPlace')->name('setup.perpetrator.place.view');
            Route::get('/perpetrator/place/add', 'Backend\Admin\Setup\MasterSetupController@addPerpetratorPlace')->name('setup.perpetrator.place.add');
            Route::post('/perpetrator/place/store', 'Backend\Admin\Setup\MasterSetupController@storePerpetratorPlace')->name('setup.perpetrator.place.store');
            Route::get('/perpetrator/place/edit/{id}', 'Backend\Admin\Setup\MasterSetupController@editPerpetratorPlace')->name('setup.perpetrator.place.edit');
            Route::post('/perpetrator/place/update/{id}', 'Backend\Admin\Setup\MasterSetupController@updatePerpetratorPlace')->name('setup.perpetrator.place.update');

            //Violence Category
            Route::get('/violence/category/view', 'Backend\Admin\Setup\MasterSetupController@viewViolenceCategory')->name('setup.violence.category.view');
            Route::get('/violence/category/add', 'Backend\Admin\Setup\MasterSetupController@addViolenceCategory')->name('setup.violence.category.add');
            Route::post('/violence/category/store', 'Backend\Admin\Setup\MasterSetupController@storeViolenceCategory')->name('setup.violence.category.store');
            Route::get('/violence/category/edit/{id}', 'Backend\Admin\Setup\MasterSetupController@editViolenceCategory')->name('setup.violence.category.edit');
            Route::post('/violence/category/update/{id}', 'Backend\Admin\Setup\MasterSetupController@updateViolenceCategory')->name('setup.violence.category.update');
            Route::get('/violence/category/delete/{id}', 'Backend\Admin\Setup\MasterSetupController@deleteViolenceCategory')->name('setup.violence.category.delete');

            //Previous violence category
            Route::get('/previous/violence/category/view', 'Backend\Admin\Setup\MasterSetupController@viewPreviousViolenceCategory')->name('setup.previous.violence.category.view');
            Route::get('/previous/violence/category/add', 'Backend\Admin\Setup\MasterSetupController@addPreviousViolenceCategory')->name('setup.previous.violence.category.add');
            Route::post('/previous/violence/category/store', 'Backend\Admin\Setup\MasterSetupController@storePreviousViolenceCategory')->name('setup.previous.violence.category.store');
            Route::get('/previous/violence/category/edit/{id}', 'Backend\Admin\Setup\MasterSetupController@editPreviousViolenceCategory')->name('setup.previous.violence.category.edit');
            Route::post('/previous/violence/category/update/{id}', 'Backend\Admin\Setup\MasterSetupController@updatePreviousViolenceCategory')->name('setup.previous.violence.category.update');
            Route::get('/previous/violence/category/delete/{id}', 'Backend\Admin\Setup\MasterSetupController@deletePreviousViolenceCategory')->name('setup.previous.violence.category.delete');

            //Violence Sub Category
            Route::get('/violence/sub-category/view', 'Backend\Admin\Setup\MasterSetupController@viewViolenceSubCategory')->name('setup.violence.sub-category.view');
            Route::get('/violence/sub-category/add', 'Backend\Admin\Setup\MasterSetupController@addViolenceSubCategory')->name('setup.violence.sub-category.add');
            Route::post('/violence/sub-category/store', 'Backend\Admin\Setup\MasterSetupController@storeViolenceSubCategory')->name('setup.violence.sub-category.store');
            Route::get('/violence/sub-category/edit/{id}', 'Backend\Admin\Setup\MasterSetupController@editViolenceSubCategory')->name('setup.violence.sub-category.edit');
            Route::post('/violence/sub-category/update/{id}', 'Backend\Admin\Setup\MasterSetupController@updateViolenceSubCategory')->name('setup.violence.sub-category.update');
            //Violence Name
            Route::get('/violence/name/view', 'Backend\Admin\Setup\MasterSetupController@viewViolenceName')->name('setup.violence.name.view');
            Route::get('/violence/name/add', 'Backend\Admin\Setup\MasterSetupController@addViolenceName')->name('setup.violence.name.add');
            Route::post('/violence/name/store', 'Backend\Admin\Setup\MasterSetupController@storeViolenceName')->name('setup.violence.name.store');
            Route::get('/violence/name/edit/{id}', 'Backend\Admin\Setup\MasterSetupController@editViolenceName')->name('setup.violence.name.edit');
            Route::post('/violence/name/update/{id}', 'Backend\Admin\Setup\MasterSetupController@updateViolenceName')->name('setup.violence.name.update');
            //Brac Support
            Route::get('/brac/support/view', 'Backend\Admin\Setup\MasterSetupController@viewBracSupport')->name('setup.brac.support.view');
            Route::get('/brac/support/add', 'Backend\Admin\Setup\MasterSetupController@addBracSupport')->name('setup.brac.support.add');
            Route::post('/brac/support/store', 'Backend\Admin\Setup\MasterSetupController@storeBracSupport')->name('setup.brac.support.store');
            Route::get('/brac/support/edit/{id}', 'Backend\Admin\Setup\MasterSetupController@editBracSupport')->name('setup.brac.support.edit');
            Route::post('/brac/support/update/{id}', 'Backend\Admin\Setup\MasterSetupController@updateBracSupport')->name('setup.brac.support.update');
            //Other Organization Support
            Route::get('/other/organization/support/view', 'Backend\Admin\Setup\MasterSetupController@viewOtherOrganizationSupport')->name('setup.other.organization.support.view');
            Route::get('/other/organization/support/add', 'Backend\Admin\Setup\MasterSetupController@addOtherOrganizationSupport')->name('setup.other.organization.support.add');
            Route::post('/other/organization/support/store', 'Backend\Admin\Setup\MasterSetupController@storeOtherOrganizationSupport')->name('setup.other.organization.support.store');
            Route::get('/other/organization/support/edit/{id}', 'Backend\Admin\Setup\MasterSetupController@editOtherOrganizationSupport')->name('setup.other.organization.support.edit');
            Route::post('/other/organization/support/update/{id}', 'Backend\Admin\Setup\MasterSetupController@updateOtherOrganizationSupport')->name('setup.other.organization.support.update');
            //Violence Reason
            Route::get('/violence/reason/view', 'Backend\Admin\Setup\MasterSetupController@viewViolenceReason')->name('setup.violence.reason.view');
            Route::get('/violence/reason/add', 'Backend\Admin\Setup\MasterSetupController@addViolenceReason')->name('setup.violence.reason.add');
            Route::post('/violence/reason/store', 'Backend\Admin\Setup\MasterSetupController@storeViolenceReason')->name('setup.violence.reason.store');
            Route::get('/violence/reason/edit/{id}', 'Backend\Admin\Setup\MasterSetupController@editViolenceReason')->name('setup.violence.reason.edit');
            Route::post('/violence/reason/update/{id}', 'Backend\Admin\Setup\MasterSetupController@updateViolenceReason')->name('setup.violence.reason.update');
            Route::get('/violence/reason/delete/{id}', 'Backend\Admin\Setup\MasterSetupController@deleteViolenceReason')->name('setup.violence.reason.delete');
            //legel initiative Reason
            Route::get('/legel/reason/view', 'Backend\Admin\Setup\MasterSetupController@viewLegelInitiativeReason')->name('setup.legel.reason.view');
            Route::get('/legel/reason/add', 'Backend\Admin\Setup\MasterSetupController@addLegelInitiativeReason')->name('setup.legel.reason.add');
            Route::post('/legel/reason/store', 'Backend\Admin\Setup\MasterSetupController@storeLegelInitiativeReason')->name('setup.legel.reason.store');
            Route::get('/legel/reason/edit/{id}', 'Backend\Admin\Setup\MasterSetupController@editLegelInitiativeReason')->name('setup.legel.reason.edit');
            Route::post('/legel/reason/update/{id}', 'Backend\Admin\Setup\MasterSetupController@updateLegelInitiativeReason')->name('setup.legel.reason.update');
            //Social Status
            Route::get('/social/status/view', 'Backend\Admin\Setup\MasterSetupController@viewSocialStatus')->name('setup.social.status.view');
            Route::get('/social/status/add', 'Backend\Admin\Setup\MasterSetupController@addSocialStatus')->name('setup.social.status.add');
            Route::post('/social/status/store', 'Backend\Admin\Setup\MasterSetupController@storeSocialStatus')->name('setup.social.status.store');
            Route::get('/social/status/edit/{id}', 'Backend\Admin\Setup\MasterSetupController@editSocialStatus')->name('setup.social.status.edit');
            Route::post('/social/status/update/{id}', 'Backend\Admin\Setup\MasterSetupController@updateSocialStatus')->name('setup.social.status.update');
            //Economic Status
            Route::get('/economic/condition/view', 'Backend\Admin\Setup\MasterSetupController@viewEconomicCondition')->name('setup.economic.condition.view');
            Route::get('/economic/condition/add', 'Backend\Admin\Setup\MasterSetupController@addEconomicCondition')->name('setup.economic.condition.add');
            Route::post('/economic/condition/store', 'Backend\Admin\Setup\MasterSetupController@storeEconomicCondition')->name('setup.economic.condition.store');
            Route::get('/economic/condition/edit/{id}', 'Backend\Admin\Setup\MasterSetupController@editEconomicCondition')->name('setup.economic.condition.edit');
            Route::post('/economic/condition/update/{id}', 'Backend\Admin\Setup\MasterSetupController@updateEconomicCondition')->name('setup.economic.condition.update');
            //Survivor Challenged
            Route::get('/surviovr/autistic/view', 'Backend\Admin\Setup\MasterSetupController@viewSurvivorAutisticInformation')->name('setup.surviovr.autistic.view');
            Route::get('/surviovr/autistic/add', 'Backend\Admin\Setup\MasterSetupController@addSurvivorAutisticInformation')->name('setup.surviovr.autistic.add');
            Route::post('/surviovr/autistic/store', 'Backend\Admin\Setup\MasterSetupController@storeSurvivorAutisticInformation')->name('setup.surviovr.autistic.store');
            Route::get('/surviovr/autistic/edit/{id}', 'Backend\Admin\Setup\MasterSetupController@editSurvivorAutisticInformation')->name('setup.surviovr.autistic.edit');
            Route::post('/surviovr/autistic/update/{id}', 'Backend\Admin\Setup\MasterSetupController@updateSurvivorAutisticInformation')->name('setup.surviovr.autistic.update');
            Route::get('/surviovr/autistic/delete/{id}', 'Backend\Admin\Setup\MasterSetupController@deleteSurvivorAutisticInformation')->name('setup.surviovr.autistic.delete');
            //Memily Member
            Route::get('/family/member/view', 'Backend\Admin\Setup\MasterSetupController@viewFamilyMember')->name('setup.family.member.view');
            Route::get('/family/member/add', 'Backend\Admin\Setup\MasterSetupController@addFamilyMember')->name('setup.family.member.add');
            Route::post('/family/member/store', 'Backend\Admin\Setup\MasterSetupController@storeFamilyMember')->name('setup.family.member.store');
            Route::get('/family/member/edit/{id}', 'Backend\Admin\Setup\MasterSetupController@editFamilyMember')->name('setup.family.member.edit');
            Route::post('/family/member/update/{id}', 'Backend\Admin\Setup\MasterSetupController@updateFamilyMember')->name('setup.family.member.update');
            Route::get('/family/member/delete/{id}', 'Backend\Admin\Setup\MasterSetupController@deleteFamilyMember')->name('setup.family.member.delete');
            // CEP Region setup
            Route::prefix('cepregion')->group(function () {

                // Ajax routes
                Route::get('/user', 'Backend\Admin\Setup\CEP_Region\SetupUserController@getUser')->name('setup.getUser');
                Route::get('/userapi', 'Backend\Admin\Setup\CEP_Region\SetupUserController@getUserApi')->name('setup.getUserApi');
                Route::get('/region/division', 'Backend\Admin\Setup\CEP_Region\SetupUserController@getRegionalDivision')->name('setup.getRegionalDivision');
                Route::get('/region/division/district', 'Backend\Admin\Setup\CEP_Region\SetupUserController@getRegionalDivisionDistrict')->name('setup.getRegionalDivisionDistrict');
                Route::get('/upazila/union', 'Backend\Admin\Setup\CEP_Region\SetupUserController@getUpazilaUnion')->name('setup.getUpazilaUnion');
                Route::get('/upazila/pollisomaj', 'Backend\Admin\Setup\CEP_Region\SetupUserController@getUpazilaPollisomaj')->name('setup.getUpazilaPollisomaj');
                Route::get('/union/village', 'Backend\Admin\Setup\CEP_Region\SetupUserController@getUnionVillage')->name('setup.getUnionVillage');
                Route::get('/district/upazila', 'Backend\Admin\Setup\CEP_Region\DistrictManagerController@getDistrictUpazila')->name('setup.getDistrictUpazila');
                Route::get('/division/district', 'Backend\Admin\Setup\CEP_Region\RegionController@getDivisionDistrict')->name('setup.getDivisionDistrict');
                Route::get('/region/change/status', 'Backend\Admin\Setup\CEP_Region\RegionController@changeRegionStatus')->name('changeRegionStatus');
                Route::get('/region/area/change/status', 'Backend\Admin\Setup\CEP_Region\RegionController@changeRegionAreaStatus')->name('changeRegionAreaStatus');
                Route::get('/district/manager/change/status', 'Backend\Admin\Setup\CEP_Region\DistrictManagerController@changeDistrictManagerStatus')->name('changeDistrictManagerStatus');
                Route::get('/field-officer/change/status', 'Backend\Admin\Setup\CEP_Region\SetupUserController@changeSetupUserStatus')->name('changeSetupUserStatus');

                // Region setup
                Route::get('/region/view', 'Backend\Admin\Setup\CEP_Region\RegionController@view')->name('setup.cepregion.region.view');
                Route::get('/region/add', 'Backend\Admin\Setup\CEP_Region\RegionController@add')->name('setup.cepregion.region.add');
                Route::post('/region/store', 'Backend\Admin\Setup\CEP_Region\RegionController@store')->name('setup.cepregion.region.store');
                Route::get('/region/edit/{id}', 'Backend\Admin\Setup\CEP_Region\RegionController@edit')->name('setup.cepregion.region.edit');
                Route::post('/region/update/{id}', 'Backend\Admin\Setup\CEP_Region\RegionController@update')->name('setup.cepregion.region.update');
                Route::get('/region/delete/{id}', 'Backend\Admin\Setup\CEP_Region\RegionController@delete')->name('setup.cepregion.region.delete');

                // Region area setup
                Route::get('/region/area/view', 'Backend\Admin\Setup\CEP_Region\RegionController@areaView')->name('setup.cepregion.region.areaView');
                Route::get('/region/area/add', 'Backend\Admin\Setup\CEP_Region\RegionController@areaAdd')->name('setup.cepregion.region.areaAdd');
                Route::post('/region/area/store', 'Backend\Admin\Setup\CEP_Region\RegionController@areaStore')->name('setup.cepregion.region.areaStore');
                Route::get('/region/area/edit/{id}', 'Backend\Admin\Setup\CEP_Region\RegionController@areaEdit')->name('setup.cepregion.region.areaEdit');
                Route::post('/region/area/update/{id}', 'Backend\Admin\Setup\CEP_Region\RegionController@areaUpdate')->name('setup.cepregion.region.areaUpdate');
                Route::get('/region/area/delete/{id}', 'Backend\Admin\Setup\CEP_Region\RegionController@areaDelete')->name('setup.cepregion.region.areaDelete');

                /**
                 * @jobayer route for zone setup
                 *
                 */
                Route::get('/zone/districtcheck', 'Backend\Admin\Setup\CEP_Region\RegionController@isDistrictActive')->name('setup.cepregion.region.checkactivedistrict');
                Route::get('/zone/villagecheck', 'PolliSomajController@isVillageActive')->name('setup.pollisomaj.checkactivevillage');

                /**
                 * @jobayer route for zone setup
                 */
                // District manager setup
                Route::get('/district-manager/view', 'Backend\Admin\Setup\CEP_Region\DistrictManagerController@view')->name('setup.cepregion.district_manager.view');
                Route::get('/district-manager/add', 'Backend\Admin\Setup\CEP_Region\DistrictManagerController@add')->name('setup.cepregion.district_manager.add');
                Route::post('/district-manager/store', 'Backend\Admin\Setup\CEP_Region\DistrictManagerController@store')->name('setup.cepregion.district_manager.store');
                Route::get('/district-manager/edit/{id}', 'Backend\Admin\Setup\CEP_Region\DistrictManagerController@edit')->name('setup.cepregion.district_manager.edit');
                Route::post('/district-manager/update/{id}', 'Backend\Admin\Setup\CEP_Region\DistrictManagerController@update')->name('setup.cepregion.district_manager.update');
                Route::get('/district-manager/delete/{id}', 'Backend\Admin\Setup\CEP_Region\DistrictManagerController@delete')->name('setup.cepregion.district_manager.delete');
            });
        });
        //End Setup

        //Start Incident/violence
        Route::prefix('incident')->group(function () {
            Route::get('/selp/add', 'Backend\Admin\Incident\SelpIncidentController@add')->name('incident.selp.add');
            Route::get('/selp/edit/{ref}', 'Backend\Admin\Incident\SelpIncidentController@edit')->name('incident.selp.edit');
            Route::post('/selp/step-1', 'Backend\Admin\Incident\SelpIncidentController@incidentFormStep1')->name('incident.selp.step-1');
            Route::post('/selp/step-2', 'Backend\Admin\Incident\SelpIncidentController@incidentFormStep2')->name('incident.selp.step-2');
            Route::post('/selp/step-3', 'Backend\Admin\Incident\SelpIncidentController@incidentFormStep3')->name('incident.selp.step-3');
            Route::post('/selp/step-4', 'Backend\Admin\Incident\SelpIncidentController@incidentFormStep4')->name('incident.selp.step-4');
            Route::post('/selp/step-5', 'Backend\Admin\Incident\SelpIncidentController@incidentFormStep5')->name('incident.selp.step-5');
            Route::post('/selp/step-6', 'Backend\Admin\Incident\SelpIncidentController@incidentFormStep6')->name('incident.selp.step-6');

            // Excel
            Route::get('/single-incident-excel/{id}', 'Backend\Admin\Incident\SelpIncidentController@incidentExcelExpot')->name('incident.excel');

            // Incident List For Other User
            Route::get('/selp-incident-list', 'Backend\Admin\Incident\SelpIncidentController@incidentList')->name('incident.list');

            Route::get('/selp-incident-delete/{id}', 'Backend\Admin\Incident\SelpIncidentController@deleteIncident')->name('incident.delete');

            // Draft List
            Route::get('/draft-list', 'Backend\Admin\Incident\SelpIncidentController@incidentDraftList')->name('incident.draft.list');
            Route::get('/selp-incident-draft/datatable', 'Backend\Admin\Incident\SelpIncidentController@getSelpIncidentDraftDatatable')->name('incident.getSelpIncidentDraftDatatable');

            // Pending List
            Route::get('/pending-list', 'Backend\Admin\Incident\SelpIncidentController@incidentPendingList')->name('incident.pending.list');
            Route::get('/selp-incident-pending/datatable', 'Backend\Admin\Incident\SelpIncidentController@getSelpIncidentPendingDatatable')->name('incident.getSelpIncidentPendingDatatable');

            // Approved List
            Route::get('/approved-list', 'Backend\Admin\Incident\SelpIncidentController@incidentApprovedList')->name('incident.approved.list');
            Route::get('/selp-incident-approved/datatable', 'Backend\Admin\Incident\SelpIncidentController@getSelpIncidentApprovedDatatable')->name('incident.getSelpIncidentApprovedDatatable');

            // Direct support container
            Route::get('/direct-support-list', 'Backend\Admin\Incident\SelpIncidentController@directSupportList')->name('incident.directsupport.list');
            Route::get('/selp-incident-directservice/datatable', 'Backend\Admin\Incident\SelpIncidentController@getSelpIncidentDirectServiceDatatable')->name('incident.getSelpIncidentDirectServiceDatatable');
            Route::match(['get', 'post'], '/selp-incident-directservice/adddirectsupport/{incident_ref}', 'Backend\Admin\Incident\SelpIncidentController@getSelpIncidentDirectSupportAdd')->name('incident.selp.addsupport');
            
            // Money Support which complain are not received
            Route::get('/initiatives/except-complain-received/list', 'Backend\Admin\Incident\SelpIncidentController@selpIncidentExceptComplainReceivedList')->name('incident.except_complain_received.list');
            Route::get('/initiatives/except-complain-received/datatable', 'Backend\Admin\Incident\SelpIncidentController@selpIncidentExceptComplainReceivedDatatable')->name('incident.except_complain_received.datatable');
            Route::match(['get', 'post'], '/initiatives/except-complain-received/money-support/{id}', 'Backend\Admin\Incident\SelpIncidentController@addSelpIncidentMoneySupport')->name('incident.selp.money.support');

            //Followup container
            Route::get('/followup-support-list', 'Backend\Admin\Incident\SelpIncidentController@getSelpIncidentFollowUpSupportList')->name('incident.followup.list');
            Route::get('/selp-incident-followuplist/datatable', 'Backend\Admin\Incident\SelpIncidentController@getSelpIncidentFollowUpDatatable')->name('incident.getSelpIncidentFollowupListDatatable');
            Route::match(['get', 'post'], '/selp-incident-directservice/addfollowupsupport/{incident_ref}', 'Backend\Admin\Incident\SelpIncidentController@getSelpIncidentFollowUpSupportAdd')->name('incident.selp.addfollowup');

            //Referral container

            Route::get('/referral-support-list', 'Backend\Admin\Incident\SelpIncidentController@getSelpIncidentReferralSupportList')->name('incident.referral.list');
            Route::get('/selp-incident-referrallist/datatable', 'Backend\Admin\Incident\SelpIncidentController@getSelpIncidentReferralDatatable')->name('incident.getSelpIncidentReferralListDatatable');
            Route::match(['get', 'post'], '/selp-incident-directservice/addreferralsupport/{incident_ref}', 'Backend\Admin\Incident\SelpIncidentController@getSelpIncidentReferralSupportAdd')->name('incident.selp.addreferral');

            Route::get('/violence/view', 'Backend\Admin\Incident\IncidentController@view')->name('incident.violence.view');
            Route::get('/violence/add', 'Backend\Admin\Incident\IncidentController@add')->name('incident.violence.add');
            Route::post('/violence/store', 'Backend\Admin\Incident\IncidentController@store')->name('incident.violence.store');
            Route::get('/violence/edit/{id}', 'Backend\Admin\Incident\IncidentController@edit')->name('incident.violence.edit');
            Route::post('/violence/update/{id}', 'Backend\Admin\Incident\IncidentController@update')->name('incident.violence.update');
            Route::get('/violence/details/{id}', 'Backend\Admin\Incident\IncidentController@details')->name('incident.violence.details');
            Route::get('/get-violence-list', 'Backend\Admin\Incident\IncidentController@getViolence')->name('incident.violence.get-list');
            Route::get('/incident/datatable', 'Backend\Admin\Incident\IncidentController@getIncidentDatatable')->name('incident.getIncidentDatatable');
            Route::get('/violence/delete/{id}', 'Backend\Admin\Incident\IncidentController@delete')->name('incident.violence.delete');
            Route::get('/violence/testlist', 'Backend\Admin\Incident\IncidentController@testlist')->name('incident.violence.testlist');
            Route::get('/incident/testdatatable', 'Backend\Admin\Incident\IncidentController@getIncidentTestDatatable')->name('incident.getIncidentTestDatatable');

            Route::get('/employees-list', 'Backend\Admin\Incident\IncidentController@viewEmployeesList')->name('incident.employees.view');
            Route::get('/employees-list/datatable', 'Backend\Admin\Incident\IncidentController@getEmployeesDatatable')->name('incident.getEmployeesDatatable');

            Route::get('/add', 'Backend\Admin\Incident\IncidentController@addIncident')->name('incident.add');
            Route::get('redirect-new-incident-add-route', 'Backend\Admin\Incident\IncidentController@redirectForNewIncident')->name('redirect_for_new_incident');
            Route::match(['get'], '/pollisomaj/data/add', 'PolliSomajController@addPollisomajData')->name('data.pollisomaj.add');
            Route::match(['post'], '/data/add/step1', 'PolliSomajController@addPollisomajStep1')->name('data.pollisomaj.add_step_1');
            Route::match(['post'], '/data/add/step2', 'PolliSomajController@addPollisomajStep2')->name('data.pollisomaj.add_step_2');
            Route::match(['post'], '/data/add/step3', 'PolliSomajController@addPollisomajStep3')->name('data.pollisomaj.add_step_3');
            Route::match(['post'], '/data/add/step4', 'PolliSomajController@addPollisomajStep4')->name('data.pollisomaj.add_step_4');
            Route::match(['post'], '/data/add/step5', 'PolliSomajController@addPollisomajStep5')->name('data.pollisomaj.add_step_5');
            Route::match(['post'], '/data/add/step6', 'PolliSomajController@addPollisomajStep6')->name('data.pollisomaj.add_step_6');
            Route::match(['post'], '/data/add/step7', 'PolliSomajController@addPollisomajStep7')->name('data.pollisomaj.add_step_7');
            Route::match(['post'], '/data/add/step8', 'PolliSomajController@addPollisomajStep8')->name('data.pollisomaj.add_step_8');
            Route::match(['post'], '/data/add/step9', 'PolliSomajController@addPollisomajStep9')->name('data.pollisomaj.add_step_9');

            Route::get('/pollisomajdata/edit/{ref}', 'PolliSomajController@editPollisomajData')->name('pollisomaj.data.edit');
            Route::get('/pollisomajdata/single-view/{ref}', 'PolliSomajController@singleViewPollisomajData')->name('pollisomaj.data.single.view');

            Route::get('/pollisomaj/datatable/list', 'PolliSomajController@getPollisomajdataDatatable')->name('incident.getPollisomajdataDatatable');
            Route::get('/view/pollisomajlist', 'PolliSomajController@viewPollisomaj')->name('incident.pollisomaj.viewpollisomajlist');
            Route::get('/redirect/new/pollisomaj/add', 'PolliSomajController@redirectNewPollisomajaddRoute')->name('incident.redirect.add.new.pollisomaj');

            Route::get('/getPollisomaj', 'PolliSomajController@getPollisomajInfo')->name('setup.getPollisomajInfo');

            Route::get('/pollisomaj-data-delete/{id}', 'PolliSomajController@deletePollisomajInfo')->name('delete.getPollisomajInfo');

            // getPollisomajDraftlist
            Route::get('/pollisomaj/draft-list', 'PolliSomajController@viewpollisomajDraftList')->name('incident.pollisomaj.viewpollisomajDraftList');
            Route::get('/getPollisomajDraftlist', 'PolliSomajController@getPollisomajDraftList')->name('incident.pollisomaj.getPollisomajDraftList');

            // getPollisomajPendinglist
            Route::get('/pollisomaj/pending-list', 'PolliSomajController@viewpollisomajPendingList')->name('incident.pollisomaj.viewpollisomajPendingList');
            Route::get('/getPollisomajPendinglist', 'PolliSomajController@getPollisomajPendingList')->name('incident.pollisomaj.getPollisomajPendingList');

            // getPollisomajApprovelist
            Route::get('/pollisomaj/approve-list', 'PolliSomajController@viewpollisomajApproveList')->name('incident.pollisomaj.viewpollisomajApproveList');
            Route::get('/getPollisomajApprovelist', 'PolliSomajController@getPollisomajApproveList')->name('incident.pollisomaj.getPollisomajApproveList');

        });

        // Audit Log
        Route::prefix('audit_log')->group(function () {
            Route::get('/list', 'Backend\AuditLogController@view')->name('audit_log.view');
            Route::get('/datatable', 'Backend\AuditLogController@getAuditLogDatatable')->name('audit_log.getAuditLogDatatable');
            Route::get('/audit-log-delete/{from_date?}/{to_date?}', 'Backend\AuditLogController@deleteAuditLog')->name('deleteAuditLog');
        });
        //End Incidentviolence

        //Start Support Management
        Route::prefix('support')->group(function () {
            Route::get('/manage/brac/view', 'Backend\Admin\Incident\SupportManagementController@view')->name('support.barck.manage.view');
            Route::get('/manage/brac/add/{id}', 'Backend\Admin\Incident\SupportManagementController@add')->name('support.barck.manage.add');
            Route::post('/manage/brac/store/{id}', 'Backend\Admin\Incident\SupportManagementController@store')->name('support.barck.manage.store');
            Route::get('/manage/brac/get-incident', 'Backend\Admin\Incident\SupportManagementController@getIncident')->name('support.barck.manage.get-incident');
            Route::get('/datatable', 'Backend\Admin\Incident\SupportManagementController@getIncidentDatatable')->name('support.getIncidentDatatable');
        });
        //End Support Management

        //Start Followup
        Route::prefix('followup')->group(function () {
            Route::get('/info/view/datatable', 'Backend\Admin\Followup\FollowupInfoController@getViewDatatable')->name('followup.info.getViewDatatable');

            Route::get('/info/view', 'Backend\Admin\Followup\FollowupInfoController@view')->name('followup.info.view');
            Route::get('/info/individual/view/{id}', 'Backend\Admin\Followup\FollowupInfoController@individualView')->name('followup.info.individual.view');
            Route::get('/info/add/{id}', 'Backend\Admin\Followup\FollowupInfoController@add')->name('followup.info.add');
            Route::post('/answer/store', 'Backend\Admin\Followup\FollowupInfoController@store')->name('followup.info.store');

            // followup questions
            Route::get('/question/view', 'Backend\Admin\Followup\FollowupQuestionController@view')->name('followup.question.view');
            Route::get('/question/add', 'Backend\Admin\Followup\FollowupQuestionController@add')->name('followup.question.add');
            Route::post('/question/store', 'Backend\Admin\Followup\FollowupQuestionController@store')->name('followup.question.store');
            Route::get('/question/edit/{id}', 'Backend\Admin\Followup\FollowupQuestionController@edit')->name('followup.question.edit');
            Route::post('/question/update/{id}', 'Backend\Admin\Followup\FollowupQuestionController@update')->name('followup.question.update');
            Route::get('/question/delete/{id}', 'Backend\Admin\Followup\FollowupQuestionController@delete')->name('followup.question.delete');
            Route::get('/question/change/status', 'Backend\Admin\Followup\FollowupQuestionController@changeQuestionStatus')->name('changeQuestionStatus');
            Route::match(['post'], '/data/add/step10', 'PolliSomajController@addPollisomajStep10')->name('data.pollisomaj.add_step_10');
            // followup question options
            Route::get('/question/option/view', 'Backend\Admin\Followup\FollowupQuestionController@viewOption')->name('followup.question.option.view');
            Route::get('/question/option/add', 'Backend\Admin\Followup\FollowupQuestionController@addOption')->name('followup.question.option.add');
            Route::post('/question/option/store', 'Backend\Admin\Followup\FollowupQuestionController@storeOption')->name('followup.question.option.store');
            Route::get('/question/option/edit/{id}', 'Backend\Admin\Followup\FollowupQuestionController@editOption')->name('followup.question.option.edit');
            Route::post('/question/option/update/{id}', 'Backend\Admin\Followup\FollowupQuestionController@updateOption')->name('followup.question.option.update');
        });
        //End Followup

        //Start Data Migration
        Route::prefix('data-migration')->group(function () {
            Route::get('/migration/view', 'Backend\DataMigrationController@view')->name('data-migration.view');
            Route::post('/migration/add', 'Backend\DataMigrationController@add')->name('data-migration.add');
            Route::post('/migration/store', 'Backend\Admin\Setup\CourseController@edit')->name('data-migration.store');
            Route::get('/migration/edit/{id}', 'Backend\Admin\Setup\CourseController@update')->name('data-migration.edit');
            Route::post('/migration/update/{id}', 'Backend\Admin\Setup\CourseController@delete')->name('data-migration.update');
        });
        //End Data Migration

        //Start MIS Report 2022
        Route::prefix('selp-mis-report')->group(function () {
            Route::get('/report/view', 'Report\SelpMisReportController@misReportView')->name('selp-mis-report.view');
            Route::post('/report', 'Report\SelpMisReportController@misReportGenerate')->name('selp-mis-report.generate');

            Route::post('/report/excel', 'Report\SelpMisReportController@allIncidentReportGenerate')->name('selp-all-incident-report.generate');

            Route::post('/gender-report', 'Report\SelpMisReportController@genderWiseViolenceReportGenerate')->name('selp-gender-wise-violence-report.generate');
            Route::post('/agewise-report', 'Report\SelpAgeWiseReportController@areaWiseAgeReportGenerate')->name('selp-area-wise-age-report.generate');
            Route::post('/areawise-report', 'Report\SelpAgeWiseReportController@ageWiseViolenceReportGenerate')->name('selp-age-wise-violence-report.generate');

            Route::post('/education-report', 'Report\SelpMisReportController@educationWiseViolenceReportGenerate')->name('selp-education-wise-violence-report.generate');
            Route::post('/occupation-report', 'Report\SelpMisReportController@occupationWiseViolenceReportGenerate')->name('selp-occupation-wise-violence-report.generate');

            Route::post('/referrel-report', 'Report\SelpMisReportController@referrelReportGenerate')->name('selp-referrel-report.generate');

            Route::post('/adr-completed-with-decesion-day-count', 'Report\SelpMisReportController@adrCompletedDayCont')->name('selp.adr.completed.day.count.generate');

            Route::post('/place-report', 'Report\SelpPlaceWiseReportController@placeWiseViolenceReportGenerate')->name('selp-place-wise-violence-report.generate');

            Route::post('/adr-report', 'Report\SelpADRReportController@adrReportGenerate')->name('selp-adr-report.generate');
            Route::post('/courtcase-report', 'Report\SelpADRReportController@courtcaseReportGenerate')->name('selp-courtcase-report.generate');

            Route::post('/adr-initiatives-report', 'Report\SelpADRReportController@adrInitiativesReportGenerate')->name('selp-adr-initiatives-report.generate');
            Route::post('/adr-completed-report', 'Report\SelpADRReportController@adrCompletedReportGenerate')->name('selp-adr-completed-report.generate');
            Route::post('/adr-completed-with-area-report', 'Report\SelpADRReportController@adrCompletedWithAreaReportGenerate')->name('selp-adr-completed-with-area-report.generate');

            Route::post('/case-status-wise-report', 'Report\SelpCourtCaseReportController@courtCaseReportGenerate')->name('selp-case-status-wise-report.generate');
            Route::post('/courtcase-completed-report', 'Report\SelpCourtCaseReportController@courtCaseCompletedReportGenerate')->name('selp-courtcase-completed-report.generate');
            Route::post('/case-file-to-judgement-day-count', 'Report\SelpCourtCaseReportController@courtCaseFileToJudgementTotalDay')->name('selp.case.file.judgement.day.count');

        });

        //Start Pollisomaj Report 2022
        Route::prefix('pollisomaj-report')->group(function () {
            Route::get('/report/view', 'Report\PollisomajReportController@pollisomajReportView')->name('pollisomaj-mis-report.view');

            Route::post('/report/excel', 'Report\PollisomajReportController@pollisomajReportExcel')->name('pollisomaj-mis-report-excel.view');

            Route::post('/report/pdf', 'Report\ChildMarriagePreventionPollisomajController@pollisomajChildMarriagePrevention')->name('pollisomaj-child-marriage-prevention-report.generate');

            Route::post('/pswiseinitiative/report/pdf', 'Report\ChildMarriagePreventionInitiativeController@pollisomajChildMarriageInitiative')->name('pollisomaj-child-marriage-initiative-report.generate');

            Route::post('/vawcincidentprevent/report/pdf', 'Report\VawcPreventionInitiativeController@vawcPreventInitiative')->name('vawc-incident-prevent-initiative-report.generate');

            Route::post('/pollisomajelectedperson/report/pdf', 'Report\PollisomajElectedPersonController@pollisomajElectedPerson')->name('pollisomaj-elected-person-report.generate');
            // Route::post('/agewise/report/pdf','Report\SelpAgeWiseReportController@ageWiseViolenceReportGenerate')->name('selp-age-wise-violence-report.generate');

            // Route::post('/education/report/pdf','Report\SelpMisReportController@educationWiseViolenceReportGenerate')->name('selp-education-wise-violence-report.generate');
            // Route::post('/occupation/report/pdf','Report\SelpMisReportController@occupationWiseViolenceReportGenerate')->name('selp-occupation-wise-violence-report.generate');

            // Route::post('/referrel/report/pdf','Report\SelpMisReportController@referrelReportGenerate')->name('selp-referrel-report.generate');

            // Route::post('/place/report/pdf','Report\SelpPlaceWiseReportController@placeWiseViolenceReportGenerate')->name('selp-place-wise-violence-report.generate');

        });

        //Start Activity Report 2022
        Route::prefix('activity-report')->group(function () {
            Route::get('/view', 'Report\ActivityReportController@activityReportView')->name('activity-mis-report.view');

            Route::post('/excel', 'Report\ActivityReportController@activityReportExcel')->name('activity-mis-report-excel.view');
            Route::post('/report', 'Report\ActivityReportController@activityReport')->name('activity-mis-report.all');

        });

        Route::prefix('selp-age-wise-report')->group(function () {
            Route::get('/report/view', 'Report\SelpAgeWiseReportController@ageWiseReportView')->name('selp-age-wise-report.view');
        });

        // 2020-2021
        Route::prefix('mis-report')->group(function () {
            Route::get('/report/view', 'Backend\MisReportController@misReport')->name('mis-report.view');
            Route::post('/report/pdf', 'Backend\MisReportController@misReportPdf')->name('mis-report-pdf.view');
        });

        Route::prefix('support-report')->group(function () {
            Route::get('/report/view', 'Backend\SupportReportController@supportReport')->name('support-report.view');
            Route::post('/report/pdf', 'Backend\SupportReportController@supportReportPdf')->name('support-report-pdf.view');
        });

        //Admin Support Report
        Route::prefix('admin-report')->group(function () {
            Route::get('/report/view', 'Backend\ReportController@adminSupportReport')->name('admin-report.view');
            Route::post('/report/pdf', 'Backend\ReportController@adminSupportReportPdf')->name('admin-report-pdf.view');
        });

        Route::prefix('platform-report')->group(function () {
            Route::get('/view', 'Backend\TestCodeController@platMethod')->name('platform-report.view');
            // Route::get('/view','Backend\TestCodeController@platMethod')->name('plat.view');
            // Route::get('/view','Backend\TestCodeController@platformReport')->name('test.view');
            Route::post('/pdf', 'Backend\PlatformReportController@platformReportPdf')->name('platform-report-pdf.view');
        });

        Route::prefix('dashboard-report')->group(function () {
            Route::get('/view', 'Backend\ReportController@dashboardReport')->name('dashboard-report.view');
            // Route::get('/view','Backend\TestCodeController@dashMethod')->name('dash.view');
            Route::post('/get', 'Backend\ReportController@dashboardReportData')->name('dashboard-report-data.view');
        });
        //End MIS Report

        Route::prefix('source-report')->group(function () {
            Route::get('/view', 'Backend\SourceReportController@sourceReport')->name('source-report.view');
            Route::post('/pdf', 'Backend\SourceReportController@sourceReportPdf')->name('source-report-pdf.view');
        });

        Route::prefix('reason-report')->group(function () {
            Route::get('/view', 'Backend\ReasonReportController@reasonReport')->name('reason-report.view');
            Route::post('/pdf', 'Backend\ReasonReportController@reasonReportPdf')->name('reason-report-pdf.view');
        });

        Route::prefix('relationship-report')->group(function () {
            Route::get('/view', 'Backend\RelationshipReportController@relationshipReport')->name('relationship-report.view');
            Route::post('/pdf', 'Backend\RelationshipReportController@relationshipReportPdf')->name('relationship-report-pdf.view');
        });

        Route::prefix('disability-report')->group(function () {
            Route::get('/view', 'Backend\DisabilityReportController@disabilityReport')->name('disability-report.view');
            Route::post('/pdf', 'Backend\DisabilityReportController@disabilityReportPdf')->name('disability-report-pdf.view');
        });

        Route::prefix('violenceplace-report')->group(function () {
            Route::get('/view', 'Backend\ViolencePlaceReportController@violencePlaceReport')->name('violenceplace-report.view');
            Route::post('/pdf', 'Backend\ViolencePlaceReportController@violencePlaceReportPdf')->name('violenceplace-report-pdf.view');
        });

        Route::prefix('agewise-report')->group(function () {
            Route::get('/view', 'Backend\AgeWiseReportController@ageWiseReport')->name('age-wise-report.view');
            Route::post('/pdf', 'Backend\AgeWiseReportController@ageWiseReportPdf')->name('age-wise-report-pdf.view');
        });

        Route::prefix('district-wise-report')->group(function () {
            Route::get('/view', 'Backend\DistrictWiseReportController@districtWiseReport')->name('district-wise-report.view');
            Route::post('/pdf', 'Backend\DistrictWiseReportController@districtWiseReportPdf')->name('district-wise-report-pdf.view');
        });

        //Upazila Wise SELP Report routs
        Route::prefix('upazila-wise-report')->group(function () {
            Route::get('view', 'Backend\Admin\UpazilaWiseReportController@upazilaWiseReportView')->name('upazila.wise.report.view');
            Route::post('report-create', 'Backend\Admin\UpazilaWiseReportController@upazilaWiseReportGenerate')->name('upazila.wise.report.create');
        });
        //Upazila Wise SELP Report routs
        Route::prefix('upazila-wise-followup')->group(function () {
            Route::get('followup-report-view', 'Backend\Admin\FollowupReportController@upazilaWiseFollowupReportView')->name('upazila.wise.followup.report.view');
            Route::post('followup-report-create', 'Backend\Admin\FollowupReportController@upazilaWiseFollowupReportGenerate')->name('upazila.wise.followup.report.create');
        });

    });

});
// for all user or without user

Route::get('/phpinfo', function () {
    return phpinfo();
    // return request()->ip();
});

// Master setup routes start

Route::resource('educations', EducationController::class);
Route::resource('selpfirstinitiatives', SelpFirstInitiativeController::class);
Route::resource('violencelocations', ViolenceLocationController::class);
Route::resource('selpcomings', SelpComingOrFailourController::class);
Route::resource('adrs', AlternativeDisputeResolutionController::class);
Route::resource('civilcases', CivilcaseController::class);
Route::resource('policecases', PolicecaseController::class);
Route::resource('pititioncases', PititioncaseController::class);
Route::resource('judgementstatus', JudgementstatusController::class);
Route::resource('moneyrecover', MoneyrecoverController::class);
Route::resource('followups', FollowupController::class);
Route::resource('bracsupports', BracsupporttypeController::class);
Route::resource('survivorinitiatives', SurvivorinitiativesController::class);
Route::resource('bracprogramnames', BracProgramNameController::class);
Route::resource('selpzones', SelpZoneController::class);
Route::resource('householdtypes', HouseholdTypeController::class);
Route::resource('adrmoneyrecover', AdrmoneyrecoverController::class);

Route::resource('refferal', RefferalController::class);
Route::resource('secondary-refferal', SecondaryRefferalController::class);

Route::resource('meeting-event', MeetingEventController::class);
Route::resource('training-event', TrainingEventController::class);
Route::resource('community-event', CommunityEventController::class);
Route::resource('campaign-event', CampaignEventController::class);
Route::resource('pt-show-event', PTshowEventController::class);
Route::resource('pt-production-event', PTproductionEventController::class);

// Master setup routes end

/**
 * Pollisomaj route start
 */

// Route::prefix('pollisomaj')->group(function(){

// });
Route::match(['get', 'post'], 'pollisomaj/add', 'PolliSomajController@add')->name('add.pollisomaj');
Route::match(['get'], 'pollisomaj/list', 'PolliSomajController@index')->name('view.pollisomaj');
Route::match(['get', 'post'], 'pollisomaj/item/edit/{id}', 'PolliSomajController@editPollisomaj')->name('edit.pollisomaj');
Route::match(['get'], 'pollisomaj/item/{id}', 'PolliSomajController@delete')->name('delete.pollisomaj');

Route::match(['get'], 'pollisomaj/getdetails', 'PolliSomajController@getDetails')->name('get-details.pollisomaj');

Route::get('/getPolliSomaj', 'PolliSomajController@getPolliSomaj')->name('view.getPolliSomaj');

Route::get('/userInfoChange/{id}', 'HomeController@userInfoChange')->name('userInfoChange');
Route::get('/userAddressChange/{incident_id}/{pin}', 'HomeController@userAddressChange')->name('userAddressChange');

Route::get('/DataDelete', 'HomeController@dataDeleteView')->name('dataDeleteView');

Route::post('/activityDataDelete', 'HomeController@activityDataDelete')->name('activityDataDelete');
Route::post('/pollishomajData', 'HomeController@pollishomajData')->name('pollishomajData');

/***
 * Pollisomaj route end
 */

/**
 * Temp route start
 */

Route::post('create_incident', function (Request $request) {
    // dd($request->all());
    $incident                                         = new SelpIncidentModel;
    $incident->employee_name                          = $request->input('employee_name');
    $incident->employee_cell                          = $request->input('employee_mobile_number');
    $incident->employee_designation                   = $request->input('employee_designation');
    $incident->employee_pin                           = $request->input('employee_pin');
    $incident->employee_selpzone_id                   = $request->input('employee_zone_id') == null ? 1 : $request->input('employee_zone_id');
    $incident->employee_division_id                   = $request->input('employee_division_id') == null ? 1 : $request->input('employee_division_id');
    $incident->employee_district_id                   = $request->input('employee_district_id');
    $incident->employee_upazila_id                    = $request->input('employee_upazila_id');
    $incident->information_provider_source_id         = $request->input('employee_information_provider') == null ? 1 : $request->input('employee_information_provider');
    $incident->type_of_dispute                        = $request->input('dispute') == null ? 1 : $request->input('dispute');
    $incident->dispute_id                             = $request->input('dispute_id') == null ? 1 : $request->input('dispute_id');
    $incident->complain_against_gender_id             = $request->input('complaint_against_gender_id');
    $incident->selp_first_initiative_id               = $request->input('first_initiative_from_selp_id');
    $incident->survivor_name                          = $request->input('survivor_name_front');
    $incident->survivor_name                          = $request->input('survivor_name') == null ? "Survivor name" : $request->input('survivor_name');
    $incident->survivor_father_name                   = $request->input('survivor_father_name');
    $incident->survivor_mother_name                   = $request->input('survivor_mother_name');
    $incident->survivor_husband_name                  = $request->input('survivor_husband_name');
    $incident->survivor_1st_contact_no                = $request->input('survivor_contact_no_front');
    $incident->survivor_1st_contact_no                = $request->input('survivor_contact_no') == null ? "010101001" : $request->input('survivor_contact_no');
    $incident->survivor_2nd_contact_no                = $request->input('survivor_2nd_contact_no');
    $incident->survivor_age                           = $request->input('survivor_age');
    $incident->survivor_sex_id                        = $request->input('survivor_sex');
    $incident->survivor_education_id                  = $request->input('survivor_education');
    $incident->survivor_religion_id                   = $request->input('survivor_religion');
    $incident->survivor_householdtype_id              = $request->input('survivor_household_id');
    $incident->survivor_monthly_income                = $request->input('survivor_income');
    $incident->survivor_violence_location_id          = $request->input('survivor_violence_location');
    $incident->survivor_marital_status_id             = $request->input('survivor_marital_status');
    $incident->survivor_age_of_marriage               = $request->input('survivor_marriage_age');
    $incident->survivor_organization_affiliation_id   = $request->input('survivor_organization_affiliation_id');
    $incident->survivor_nid                           = $request->input('survivor_nid');
    $incident->survivor_reason_of_violence_id         = $request->input('survivor_reason_of_violence');
    $incident->survivor_place_of_violence_id          = $request->input('survivor_place_of_violence');
    $incident->survivor_disability_status_id          = $request->input('survivor_disability_status');
    $incident->number_of_perpetrator                  = $request->input('number_of_perpetrator');
    $incident->relation_with_main_perpetrator_id      = $request->input('relation_with_main_perpetrator');
    $incident->if_perpetrator_family_member_id        = $request->input('if_perpetrator_family_member');
    $incident->perpetrator_gender_id                  = $request->input('perpetrator_gender');
    $incident->perpetrator_age                        = $request->input('perpetrator_age');
    $incident->perpetrator_education_id               = $request->input('perpetrator_education');
    $incident->perpetrator_occupation_id              = $request->input('perpetrator_occupation');
    $incident->earlier_survivor_initiative            = $request->input('earlier_survivor_initiative');
    $incident->earlier_survivor_initiative_place_id   = $request->input('earlier_survivor_initiative_place');
    $incident->cause_of_failour_coming_to_selp_id     = $request->input('cause_of_failour_coming_to_selp');
    $incident->selp_types_of_initiatives              = $request->input('selp_types_of_initiative');
    $incident->selp_referral_initiatives              = $request->input('selp_referral_initiatives');
    $incident->selp_direct_support                    = $request->input('selp_direct_support');
    $incident->selp_alternative_dispute_resolution_id = $request->input('selp_alternative_dispute_resolution');
    $incident->selp_support_start_date                = $request->input('selp_support_start_date');
    $incident->selp_support_closing_date              = $request->input('selp_support_closing_date');
    $incident->selp_adrmoneyrecover_id                = $request->input('selp_adrmoneyrecover');
    $incident->selp_amount_of_money_from_adr          = $request->input('selp_amount_of_money_from_adr');
    $incident->selp_adr_money_recover_benifitiaries   = $request->input('selp_adr_money_recover_benifitiaries');
    $incident->case_type                              = $request->input('case_type');
    $incident->civilcase_id                           = $request->input('civilcase_id');
    $incident->policecase_id                          = $request->input('policecase_id');
    $incident->pititioncase_id                        = $request->input('pititioncase_id');
    $incident->moneyrecover_id                        = $request->input('moneyrecover_id');
    $incident->judgementstatus_id                     = $request->input('judgementstatus_id');
    $incident->program_participent_followup           = $request->input('program_participent_followup');
    $incident->no_of_followup_madeby_selp_staff       = $request->input('no_of_followup_madeby_selp_staff');
    $incident->followup_id                            = $request->input('followup_id');
    $incident->case_start_date                        = $request->input('case_start_date');
    $incident->judgement_date                         = $request->input('judgement_date');
    $incident->have_survivor_face_violence_before     = $request->input('have_survivor_face_violence_before');
    $incident->survivor_first_violence_age            = $request->input('survivor_first_violence_age');
    $incident->violence_type_multiple_list            = implode(array(1, 2, 3, 4, 5));
    $incident->survivor_seek_support_from_brac        = $request->input('survivor_seek_support_from_brac');
    $incident->bracsupporttype_id                     = $request->input('bracsupporttype_id');
    $incident->save();

    $request->session()->flash("success", "Selp Incident information added");
    return redirect('view_incident');
});

// Route::get('view_incident',function (Request $request){
//         $divisions             = Division::all();
//         $regions            = Region::where('status','1')->get();
//         $violence_categories= ViolenceCategory::where('status','1')->get();
//         $auth_user          = User::with(['setup_user_area'])->where('id', Auth::id())->first();
//         return view('backend.admin.selp_incident.selp-incident-list',compact('divisions','violence_categories', 'regions'));
// })->name('view.selp_incident');

Route::get('single_incident/{id}', function (Request $request, $id) {
    // $data['incident']=SelpIncidentModel::find($id);
    $data['incident']            = SelpIncidentModel::with(['brac_support_type', 'selp_initiative_place'])->find($id);
    $data['followups']           = FollowUpInfo::with(['findings_followup'])->where('selp_incident_id', $id)->get();
    $data['referrals']           = IncidentReferral::with(['complain_received_refferal'])->where('selp_incident_id', $id)->get();
    $data['direct_service_type'] = DirectServiceType::where('selp_incident_id', $id)->get();
    $data['adrSupport']          = SurvivorDirectServiceModel::with(['adr_money_recovered'])->join('alternative_dispute_resolutions', 'alternative_dispute_resolutions.id', '=', 'survivor_direct_services.alternative_dispute_resolution_id')
        ->select('alternative_dispute_resolutions.title', 'survivor_direct_services.*')
        ->where('survivor_direct_services.selp_incident_information_id', $id)->get();

    $data['caseSupport'] = SurvivorCourtCaseModel::where('selp_incident_information_id', $id)->get();
    // dd("dsd");
    // dd($data['incident']->selp_initiative_place);
    // return view('backend.admin.incident.dummy-incident-view')->with($data);
    $pdf = PDF::loadView('backend.admin.incident.dummy-incident-view', $data);
    $pdf->SetProtection(['copy', 'print'], '', 'pass');
    $fileName = 'Complain_id' . '_' . $data['incident']->id . '.' . 'pdf';
    return $pdf->stream($fileName);
})->name('view-single-incident');

Route::get('single_pollisomaj_data/{id}', function (Request $request, $id) {
    // $data['incident']=SelpIncidentModel::find($id);
    $data['pollisomaj'] = PollisomajDataModel::with(['pollisomaj_info', 'zones', 'division', 'district', 'upazilla', 'union'])->find($id);
    // dd($data['pollisomaj_da    ta']);
    // return view('backend.pollisomaj.pollisomajdata.single-pollisomaj-pdf-view')->with($data);
    $pdf = PDF::loadView('backend.pollisomaj.pollisomajdata.single-pollisomaj-pdf-view', $data);
    $pdf->SetProtection(['copy', 'print'], '', 'pass');
    // $fileName =  123 . '.' . 'pdf' ;
    $fileName = 'Data_Entry_No' . '_' . $data['pollisomaj']->id . '.' . 'pdf';
    return $pdf->stream($fileName);
})->name('view-single-pollisomaj');

Route::get('single_activity_data/{id}', function (Request $request, $id) {
    // $data['incident']=SelpIncidentModel::find($id);
    $data['pollisomaj'] = ActivityModel::with(['meeting_activity', 'training_activity', 'community_activity', 'campaign_activity', 'pt_show_activity', 'pt_production_activity', 'zones', 'division', 'district', 'upazilla'])->find($id);
    dd($data['pollisomaj']);
    // return view('backend.pollisomaj.pollisomajdata.single-pollisomaj-pdf-view')->with($data);
    $pdf = PDF::loadView('backend.activity.single-activity-pdf-view', $data);
    $pdf->SetProtection(['copy', 'print'], '', 'pass');
    $fileName = 123 . '.' . 'pdf';
    return $pdf->stream($fileName);
})->name('view-single-activity');

Route::get('debug_route', function (Request $request) {
    // return session()->forget('current_incident_store_session');
    // return $request->session()->put('edit_mode',true);
    return session()->all();
    // $response = \Illuminate\Support\Facades\Http::get('https://api.ipify.org/?format=json');
    return $response->json();
    return phpinfo();
    return Session::get('userareaaccess');
});
/**
 * Temp route end
 */

/* Activity module start */

Route::prefix('activity')->group(function () {
    Route::get('redirect-new-activity-add-route', 'ActivityController@redirectForNewActivity')->name('redirect_for_new_activity');
    Route::get('add', 'ActivityController@addActivity')->name('activity.add');
    Route::get('activity-list', 'ActivityController@activityList')->name('activity.list');
    Route::get('/activitydata/edit/{ref}', 'ActivityController@editActivityData')->name('activity.data.edit');

    Route::get('/activity-data-delete/{id}', 'ActivityController@deleteActivityData')->name('delete.deleteActivityData');

    Route::get('/single-pdf-view/{id}', 'ActivityController@singlePdfViewActivityData')->name('activity.data.single.pdf.view');
    Route::get('/single-excel-view/{id}', 'ActivityController@singleExcelViewActivityData')->name('activity.data.single.excel.view');

    Route::match(['post'], '/add/step1', 'ActivityController@addActivityStep1')->name('activity.add_step_1');
    Route::match(['post'], '/add/step2', 'ActivityController@addActivityStep2')->name('activity.add_step_2');
    Route::match(['post'], '/add/step3', 'ActivityController@addActivityStep3')->name('activity.add_step_3');
    Route::match(['post'], '/add/step4', 'ActivityController@addActivityStep4')->name('activity.add_step_4');
    Route::match(['post'], '/add/step5', 'ActivityController@addActivityStep5')->name('activity.add_step_5');
    Route::match(['post'], '/add/step6', 'ActivityController@addActivityStep6')->name('activity.add_step_6');
    Route::match(['post'], '/add/step7', 'ActivityController@addActivityStep7')->name('activity.add_step_7');

    // getActivityDraftlist
    Route::get('/draft-list', 'ActivityController@viewActivityDraftList')->name('activity.draft.list');
    Route::get('/getActivityDraftlist', 'ActivityController@getActivityDraftList')->name('activity.getActivityDraftList');

    // getActivityPendinglist
    Route::get('/pending-list', 'ActivityController@viewActivityPendingList')->name('activity.pending.list');
    Route::get('/getActivityPendinglist', 'ActivityController@getActivityPendingList')->name('activity.getActivityPendingList');

    // getActivityApprovelist
    Route::get('/approved-list', 'ActivityController@viewActivityApproveList')->name('activity.approved.list');
    Route::get('/getActivityApprovelist', 'ActivityController@getActivityApproveList')->name('activity.getActivityApproveList');
});

/* Activity module end */

// Survivor wise report

Route::prefix('survivor-wise-report')->group(function () {
    Route::get('view', 'SurvivorDirectServiceReportController@index')->name('survivor.report.view');
    Route::post('create', 'SurvivorDirectServiceReportController@survivorDirectServiceReportGenerate')->name('survivor.wise.report.create');
});

// Indicator Wise Report Route
Route::prefix('indicator-wise-report')->group(function () {
    Route::get('view', 'Report\IndicatorWiseReportController@indicatorReportGenerate')->name('indicator.wise.report');
    Route::post('process', 'Report\IndicatorWiseReportController@indicatorReportProcess')->name('indicator.wise.report.process');
    Route::post('excel', 'Report\IndicatorWiseReportController@indicatorReportExcel')->name('indicator.wise.report.excel');
});

// Head Office Activity Event
Route::resource('ho-activity-events', HeadOfficeActivityEventController::class);


Route::prefix('head-office-activity')->group(function () {
    Route::get('list', 'HeadOfficeActivityController@index')->name('head.office.activity.index');
    Route::get('add', 'HeadOfficeActivityController@add')->name('head.office.activity.add');
    Route::post('store', 'HeadOfficeActivityController@store')->name('head.office.activity.store');
    Route::get('edit/{id}', 'HeadOfficeActivityController@edit')->name('head.office.activity.edit');
    Route::post('update/{id}', 'HeadOfficeActivityController@update')->name('head.office.activity.update');
    Route::delete('delete/{id}', 'HeadOfficeActivityController@destroy')->name('head.office.activity.delete');
    Route::get('get-head-office-activity-list', 'HeadOfficeActivityController@headOfficeActivityListDataTable')->name('get.head.office.activity.list.datatable');
});