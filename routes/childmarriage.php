<?php
// Master setup routes start

use Illuminate\Support\Facades\Route;

Route::resource('childmarriageinitiative', ChildMarriageInitiativeController::class);
Route::resource('childmarriageassistancetaken', ChildMarriageAssistanceTakenController::class);

Route::resource('childmarriageinformation', ChildMarriageInformationController::class);
Route::get('child-marriage-information-complain/{id}', 'ChildMarriageInformationController@complainIdBycreate')->name('child.marriage.information.complain.id');
Route::get('child-marriage-information-complain', 'ChildMarriageInformationController@getChieldComplainInformationDatatable')->name('child.marriage.information.complain');
Route::get('child-marriage-information-datatable', 'ChildMarriageInformationController@ChildMarriageInformationDatatable')->name('child.marriage.information.datatable');
Route::get('child-marriage-information-datatable', 'ChildMarriageInformationController@ChildMarriageInformationDatatable')->name('child.marriage.information.datatable');
Route::get('child-marriage-information-excel/{childmarriageinformation}', 'ChildMarriageInformationController@ChildMarriageInformationExcel')->name('child.marriage.information.excel');

Route::get('child-marriage-information-approve', 'ChildMarriageInformationController@ChildMarriageInformationApproved')->name('child.marriage.information.approved.load');
Route::get('child-marriage-information-approve-list', 'ChildMarriageInformationController@approved')->name('child.marriage.information.approved.list');
