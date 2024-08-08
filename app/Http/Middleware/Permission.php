<?php

namespace App\Http\Middleware;

use App\Model\Menu;
use App\Model\MenuPermission;
use App\Model\MenuRoute;
use Auth;
use Closure;

class Permission
{

    public function handle($request, Closure $next){
        $route=$request->route()->getName();
        $user_role_array=Auth::user()->user_role;
        $title = Menu::where('route',$route)->first();
        if(count($user_role_array)==0){
            $user_role = [];
        }else{
            foreach($user_role_array as $rolee){
                $user_role[] = $rolee->role_id;
            }
        }
        // dd(Auth::user()->toArray());
        if (Auth::user()->id == 1){
            $request->session()->put('title', @$title->name);
            return $next($request);
        }else{
            $mainmenu = Menu::where('route',$route)->first();
            $mainmenuroute = MenuRoute::with(['menu'])->where('route',$route)->first();
            if($mainmenu != null || $mainmenuroute != null){
                $permission=MenuPermission::whereIn('role_id',$user_role)->where('permitted_route',$route)->first();
                if($permission){
                    $request->session()->put('title',@$title->name);
                    return $next($request);
                }else{
                    $request->session()->put('title',@$title->name);
                    return redirect()->back()->with('error','Access Permission Denied');
                }
            }else{
                $request->session()->put('title',@$title->name);
                return $next($request);
            }
        }
    }

}
