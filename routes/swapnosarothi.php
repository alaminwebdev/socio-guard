<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'permission'])->group(function(){

    Route::resource('swapnosarothisetupgroup', SetupGroupController::class);
    Route::get('get-groupsetup-id', 'SetupGroupController@getSetupId')->name('swapnosarothi.group.setup.id');
    Route::get('get-groupsetup-listdatatable', 'SetupGroupController@groupListDataTable')->name('swapnosarothi.group.setup.datatable');
    
    Route::resource('swapnosarothiprofile', SwapnosarothiProfileController::class);
    Route::get('get-profile-id', 'SwapnosarothiProfileController@getProfileId')->name('swapnosarothi.profile.id');
    Route::get('get-region-upazila-setupgroup', 'SwapnosarothiProfileController@getRegionUpazilaGroup')->name('get-region-upazila-setupgroup');
    Route::get('get-swapnosarothi-profile-list', 'SwapnosarothiProfileController@getProfileListDataTable')->name('get.swapnosarothi.profile.list.datatable');
    Route::get('get-swapnosarothi-profile-pdf-view/{id}', 'SwapnosarothiProfileController@getProfilePdfVIew')->name('swapnosarothi.profile.pdf.view');
    Route::get('get-swapnosarothi-profile-excel-view/{id}', 'SwapnosarothiProfileController@getProfileExcelView')->name('swapnosarothi.profile.excel.view');
    
    Route::get('swapnosarothi-profile-pending-list', 'SwapnosarothiProfileController@profilePendingList')->name('swapnosarothi.profile.pending.list');
    Route::get('get-swapnosarothi-profile-pending-list', 'SwapnosarothiProfileController@pendingProfileListDataTable')->name('get.swapnosarothi.profile.pending.list.datatable');
    
    Route::get('swapnosarothi-approve-profile-list', 'SwapnosarothiProfileController@profileApproveList')->name('swapnosarothi.profile.approve.list');
    Route::get('get-swapnosarothi-profile-approve-list', 'SwapnosarothiProfileController@approveProfileListDataTable')->name('get.swapnosarothi.profile.approve.list.datatable');
    
    Route::post('swapnosarothi-profile-status-change', 'SwapnosarothiProfileController@swapnosarothiProfileStatusChange')->name('swapnosarothi.profile.status.change');
    Route::post('swapnosarothi-profile-list-excel', 'SwapnosarothiProfileController@swapnosarothiProfileListGenerate')->name('swapnosarothi.profile.list.generate');
    
    //dumy data upload
    Route::get('upload-swapnosarothi-data', 'SwapnosarothiProfileController@uploadSwapnosarothiData')->name('upload-swapnosarothi-data');
    Route::post('swapnosarothi-profile-data-upload', 'SwapnosarothiProfileController@profileDataUpload')->name('profile.data.upload');
    
    Route::resource('cminitiative', CmInitiativeController::class);
    Route::get('prevention-type-wise-prevention', 'CmInitiativeController@typeWisePrevention')->name('prevention.type.wise.prevention');
    Route::resource('swapnosarothiskill', SwapnosarothiSkillController::class);
    Route::resource('swapnosarothiprofileskill', SwapnosarothiProfileSkillController::class);
    Route::get('swapnosarothi-profile-skill-list', 'SwapnosarothiProfileSkillController@profileSkillListDataTable')->name('swapnosarothi.profile.skill.list.datatable');
    Route::get('swapnosarothi-profile-skill-check', 'SwapnosarothiProfileSkillController@profileSkillCheck')->name('swapnosarothi.profile.skill.check');
    
    
    // Swapnosarothi Group Wise Report Route
    Route::prefix('swapnosarothi-group-wise-report')->group(function () {
        Route::match(['get', 'post'], 'view', 'SwapnosarothiProfileReportController@swapnosarothiReportGenerate')->name('swapnosarothi.group.wise.report.index');
    });
    
    // Swapnosarothi Profile Money Support
    Route::match(['get', 'post'], '/swapnosarothi-profile/money-support/{id}', 'SwapnosarothiProfileController@addSwapnosarothiProfileMoneySupport')->name('swapnosarothi.profile.money.support');
});