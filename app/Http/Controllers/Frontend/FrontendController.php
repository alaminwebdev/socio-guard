<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Model\Admin\Employee\Employee;
use App\Model\Admin\Employee\EmploymentType;
use App\Model\Admin\Setup\Department;
use App\Model\Admin\Setup\DesignationCadre;
use App\Model\Admin\Training\TrainingBatch;
use App\Model\Admin\Training\TrainingGuestSpeaker;
use App\Model\Admin\Training\TrainingParticipantAssign;
use App\Model\Admin\Training\TrainingParticipantDesignation;
use App\Model\Admin\Training\TrainingBcsBatch;
use App\Model\Participant\Participant;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;
use App\Notifications\UserRegistration as RegistrationNotification;

class FrontendController extends Controller
{
    public function index(){
    	return view('frontend.layouts.home');
    }

    public function feedBack(){
    	return view('frontend.pages.feedback');
    }
}
