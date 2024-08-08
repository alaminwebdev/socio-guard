<?php

use App\Http\Controllers\PolliSomajController;
use App\Model\Admin\Setup\CEP_Region\RegionAreaDetail;
use App\Model\SelpIncidentModel;
use App\Model\PollisomajDataModel;
use Backend\Mastersetup\AdrmoneyrecoverController;
use Backend\Mastersetup\HouseholdTypeController;
use Backend\Mastersetup\EducationController;
use Backend\Mastersetup\SelpFirstInitiativeController;
use Backend\Mastersetup\ViolenceLocationController;
use Backend\Mastersetup\SelpComingOrFailourController;
use Backend\Mastersetup\AlternativeDisputeResolutionController;
use Backend\Mastersetup\CivilcaseController;
use Backend\Mastersetup\PolicecaseController;
use Backend\Mastersetup\PititioncaseController;
use Backend\Mastersetup\JudgementstatusController;
use Backend\Mastersetup\MoneyrecoverController;
use Backend\Mastersetup\FollowupController;
use Backend\Mastersetup\BracsupporttypeController;
use Backend\Mastersetup\SurvivorinitiativesController;
use Backend\Mastersetup\BracProgramNameController;
use Backend\Mastersetup\SelpZoneController;
use Illuminate\Http\Request;
use App\Model\Admin\Setup\Division;
use App\Model\Admin\Setup\CEP_Region\Region;
use App\Model\Admin\Setup\ViolenceCategory;
use App\User;

use Illuminate\Support\Facades\Session;
use App\Model\FollowUpInfo;
use App\Model\IncidentReferral;
use App\Model\DirectServiceType;
use App\Model\SurvivorDirectServiceModel;
use App\Model\SurvivorCourtCaseModel;



Route::middleware(['auth'])->prefix('mis/report')->group(function () {
    Route::get('/filter', 'CourtCaseReportController@index');
    Route::post('/courtcase', 'CourtCaseReportController@generateCourtcaseReport')->name('generate.courtcasereport');
});