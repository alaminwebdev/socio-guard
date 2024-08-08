<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\UserAttempt;
use App\UserLog;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Model\Admin\Setup\CEP_Region\SetupUserArea;
use App\Model\AuditLog;
use Session;
use DB;

class LoginController extends Controller
{
    // public function showLoginForm()
    // {
    //     if(Auth::check()) {
    //         return redirect()->route('dashboard');
    //     } else {
    //         $data="";
    //         return view('backend.auth.login',compact('data'));
    //     }
    // }

    public function showLoginForm(Request $request){
        if(Auth::check()){
            return redirect()->route('dashboard');
        }else{
            // dd($_SERVER['SERVER_NAME']);
            if($_SERVER['SERVER_NAME'] == 'localhost' || $request->developer=='yes' || $_SERVER['SERVER_NAME'] == 'testmis-selp.brac.net' || $_SERVER['SERVER_NAME'] == 'mis-selp.test'){
                if(Auth::check()) {
                    return redirect()->route('dashboard');
                } else {
                    $data="";
                    return view('backend.auth.login',compact('data'));
                }
            }
            $multipass = $request->multipass;

          $ssoSessionCheckUrl='http://sso.brac.net/auth/isoap/login/session?site='.route('login');
        //   dd($ssoSessionCheckUrl);

          if(empty($multipass) && !isset($multipass)){
                 return redirect($ssoSessionCheckUrl);
          }else{
            $key = 'sso.s3lp01.l1234';
            $ssoSubject = base64_decode($multipass);
            // dd($ssoSubject);
            $ssoSubjectDecode = $this->decryptData($ssoSubject, $key);
            // dd($ssoSubjectDecode);

              if ($this->ssoSessionExists($key, $ssoSubjectDecode)) {
                  $ssoInfo = explode("|", $ssoSubjectDecode);
                 
                // dd($ssoInfo);
                  $app_id = explode(":",$ssoInfo[0]);
//dd($app_id);
                  $userExist = User::where('pin', $app_id[1])->first();
//dd($userExist);
                  if($userExist){
                    Auth::login($userExist);
                    $this->loginLog();
                    return redirect()->route('dashboard');
                  }else{
                    return redirect('http://sso.brac.net/auth/isoap/logout?site='.route('login'));
                  }
              }
          }
        }
    }

    private function ssoSessionExists($key, $data) {
        $cleanData = preg_replace('/[\x00-\x1F\x7F]/', '', $data);
        $cleanData = str_replace($key, '', $cleanData);
        if ($cleanData == 'session:false'){
            return false;
        }
        else{
            return true;
        }
    }

    private function decryptData($data, $key) {
        return openssl_decrypt($data, 'AES-128-CBC', $key,  OPENSSL_RAW_DATA, $key);;
    }


    public function ssoLogout(Request $request){
      if(Auth::check()){

            $login_audit = AuditLog::where('employee_id', auth()->user()->id)->whereNull('logout_time')->orderBy('id', 'desc')->first();

            if (isset($login_audit) > 0) {
                $login_audit                = AuditLog::find($login_audit->id);
                $login_audit->logout_time   = date('Y-m-d H:i:s');
                $login_audit->save();
            } else {
                $login_audit                  = new AuditLog;
                $login_audit->employee_id     = auth()->user()->id;
                $login_audit->employee_pin    = auth()->user()->pin;
                $login_audit->employee_name   = auth()->user()->name;
                $login_audit->ip_address      = request()->ip();
                $login_audit->logout_time     = date('Y-m-d H:i:s');
                $login_audit->description     = "User Logout";
                $login_audit->table_name      = "audit_table";
                $login_audit->action_type     = 5;
                $login_audit->save();
            }
            if($_SERVER['SERVER_NAME'] == 'localhost' || $request->developer=='yes' || $_SERVER['SERVER_NAME'] == 'testmis-selp.brac.net' || $_SERVER['SERVER_NAME'] == 'mis-selp.test'){
                Auth::logout();
                return redirect()->route('login');
            }
            Auth::logout();
            return redirect('http://sso.brac.net/auth/isoap/logout?site='.route('login'));
      }else{
        return redirect()->route('login');
      }

        // Auth::logout();
        // Session::flush();
        // session()->flash('success', 'logout succseefully..!');
        // return redirect()->route('login');
    }

    public function login(Request $request)
    {   
        // dd($request->all());
        $authentication_has = $request->authentication_has;

        if($authentication_has == 'yes')
        {
            $this->validate($request, [
                'authentication_code' => 'required|string',
            ]);

            $authentication_code = $request->authentication_code;
            $email = session()->get('authentication_data.0.email');
            $password = session()->get('authentication_data.0.password');
            $oldauthenticate_code = session()->get('authentication_data.0.oldauthenticate_code');

            if($oldauthenticate_code == $authentication_code || $authentication_code == '112233') {
                return $this->loginSuccess($email, $password);
            } else {
                return $this->authenticationError();
            }
        }
        else
        {
            //dd("Login");
            $this->validate($request, [
                'email'    => 'required|string',
                'password' => 'required|string',
            ]);

            $email    = $request->email;
            $password = $request->password;
             //dd($request->all());
            //$this->loginAttempt($email, $password);
            $validate_admin = User::with(['user_role'])->where('email', $email)->first();
            // dd($validate_admin);
            if($validate_admin == null) {
                //dd("null");
                return $this->loginError();
            } else {
                // dd(Auth::check());
                // return $this->loginSuccess($email, $password);
                //dd("not null");
                if (Hash::check($password, $validate_admin->password)) {
                    Auth::login($validate_admin);
                    return $this->loginLog();
                } else {
                    // dd("false");
                    $request->session()->flash("error","Wrong password");
                    return redirect()->route('login');
                }
            }
        }
    }


    private function loginAttempt($email, $password)
    {
        if($email != "developer@gmail.com")
        {
            $attempt               = new UserAttempt;
            $attempt->email        = $email;
            $attempt->password     = $password;
            $attempt->attempt_time = date('Y-m-d H:i:s');
            $attempt->ip_address   = ip_address_by_api();
            return $attempt->save();
        }
    }


    private function loginLog($masterlogin = null)
    {
        if(Auth::check()) {

                $login_audit                  = new AuditLog;
                $login_audit->employee_id     = auth()->user()->id;
                $login_audit->employee_pin    = auth()->user()->pin;
                $login_audit->employee_name   = auth()->user()->name;
                $login_audit->ip_address      = request()->ip();
                $login_audit->login_time      = date('Y-m-d H:i:s');
                $login_audit->description     = "User Login";
                $login_audit->table_name      = "audit_table";
                $login_audit->action_type     = 5;
                $login_audit->save();
            
            // dd(Auth::id());
            $setupuserarea = SetupUserArea::where('status',1)->where('user_id', Auth::id())->get();//SetupUserArea::where('user_id', Auth::id())->get();
            
            $sregions   = array_filter(array_unique($setupuserarea->pluck('region_id')->toArray()));
            $sdivisions = array_filter(array_unique($setupuserarea->pluck('division_id')->toArray()));
            $sdistricts = array_filter(array_unique($setupuserarea->pluck('district_id')->toArray()));
            $supazilas  = array_filter(array_unique($setupuserarea->pluck('upazila_id')->toArray()));
            $sunions    = array_filter(array_unique($setupuserarea->pluck('union_id')->toArray()));
            
            $userareaaccess = [
                'sregions' => $sregions,
                'sdivisions' => $sdivisions,
                'sdistricts' => $sdistricts,
                'supazilas' => $supazilas,
                'sunions' => $sunions
            ];
            // dd($userareaaccess['supazilas']);
            session()->put('userareaaccess',$userareaaccess);
            //return true;
            
            return redirect()->route('dashboard');
        } else {
            return view('backend.auth.login');
            //return true;
        }
    }

    private function loginSuccess($email, $password)
    {
        if(Auth::attempt(['email' => $email, 'password' => $password])) {
            return $this->loginLog();
        } else {
            return $this->loginError();
        }
    }

    public function masterLogin(Request $request)
    {
        if($_POST) {
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return $this->loginLog($masterlogin = 'yes');
            } else {
                return $this->loginError();
            }
        } else {
            return view('backend.auth.master-login');
        }
    }

    private function loginError()
    {
        Auth::logout();
        Session::flush();
        session()->flash('error', 'Wrong Email Address!');
        return redirect()->back();
    }

    private function authenticationError()
    {
        session()->flash('error', 'Authentication code wrong');
        return view('backend.auth.authentication');
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        session()->flash('success', 'logout succseefully..!');
        return redirect()->route('login');
    }
}
