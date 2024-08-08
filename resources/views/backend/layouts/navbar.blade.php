@php
$prefix = Request::route()->getPrefix();
$route  = Route::current()->getName();

$user_role_array = Auth::user()->user_role;

if(count($user_role_array) == 0) {
  $user_role = [];
} else {
  foreach($user_role_array as $role) {
    $user_role[] = $role->role_id;
  }
}

$parentroutearray = explode('.',$route);
$parentroute      = $parentroutearray[0];
$childroute       = $parentroute.'.'.@$parentroutearray[1];
$nav_menu         = [];

// Style for navbar when selected
if(Auth()->user()->role == '1') {
  $usertype = 'admin';
} else {
  $usertype = Auth()->user()->role;
}

$dashboardColors = DB::table('dashboard_colors')->where('usertype', $usertype)->first();
@endphp

<style type="text/css">
 .pnavbar {
  /*background-color: #4980b5 !important;*/
  background: #031220 !important;
}
.cnavbar {
  /*background-color: #305171 !important;*/
  background: {{(@$dashboardColors->childnavbarbgcode)?($dashboardColors->childnavbarbgcode):'#305171'}} !important;
}

.m-left-minus-10 {
  margin-left: -10px;
}

.asideFooter {
  position: fixed;
  bottom: 15px;
  left: 5px;
  text-align: center;
  color: #ffffff;
  background: #0b253a;
}

.asideFooter .inner {
  background: #990e59;
  width: 100%;
  margin: 0px auto;
  padding: 10px 0px;
  border-radius: 5px;
}

.asideFooter .inner a {
  color: white!important;
}
.asideFooter h4 {
    margin-bottom: 0;
    font-size: 12px;
    color: #ffffff;
}
.asideFooter p {
    margin-bottom: 0;
    font-size: 10px;
}
</style>

<div class="left main-sidebar">
  <div class="sidebar-inner leftscroll">
    <div id="sidebar-menu" class="mt-1">
     <ul>
      <li class="submenu">
        <a class="{{$route == 'dashboard'?'active':''}}" href="{{route('dashboard')}}"><i class="fa fa-fw fa-dashboard"></i><span> Dashboard </span> </a>
      </li>

      @if(Auth::user()->id == '1')
      <!--Menu Management for Developer -->
        @php
          $grand_parents = App\Model\Menu::where('parent', 0)->where('status', 1)->orderBy('sort', 'asc')->get();
          foreach ($grand_parents as  $grand_parent){
            $nav_menu[$grand_parent->id]['grand_parent']=$grand_parent->name;
            $nav_menu[$grand_parent->id]['grand_parent_route']=$grand_parent->route;
            $nav_menu[$grand_parent->id]['grand_parent_icon']=$grand_parent->icon;
            $parents=App\Model\Menu::where('parent', $grand_parent->id)->where('status', 1)->orderBy('sort', 'asc')->get();
              foreach($parents as $parent){
                $nav_menu[$grand_parent->id]['parent'][$parent->id]['parent_id']=$parent->id;
                $nav_menu[$grand_parent->id]['parent'][$parent->id]['parent_name']=$parent->name;
                $nav_menu[$grand_parent->id]['parent'][$parent->id]['parent_route']=$parent->route;
                $childs=App\Model\Menu::where('parent', $parent->id)->where('status',1)->orderBy('sort', 'asc')->get();
                    foreach($childs as $child){
                      $nav_menu[$grand_parent->id]['is_child']='yes';
                      $nav_menu[$grand_parent->id]['parent'][$parent->id]['child'][$child->id]['child_id']=$child->id;
                      $nav_menu[$grand_parent->id]['parent'][$parent->id]['child'][$child->id]['child_name']=$child->name;
                      $nav_menu[$grand_parent->id]['parent'][$parent->id]['child'][$child->id]['child_route']=$child->route;
                  }
               }
            }
        @endphp
      @else
        <!-- Menu Management for user by Role -->
        @php
          $grand_parents = App\Model\Menu::where('parent', 0)->where('status',1)->where('id','!=',1)->orderBy('sort', 'asc')->get();
          foreach ($grand_parents as  $grand_parent){
            $parents=App\Model\Menu::where('parent', $grand_parent->id)->where('status',1)->orderBy('sort', 'asc')->get();
            foreach($parents as $parent){
              $check_parent=App\Model\MenuPermission::where('menu_id',$parent->id)->whereIn('role_id', @$user_role)->first();
              if($check_parent){
                $permission=App\Model\MenuPermission::where('permitted_route',$parent->route)->whereIn('role_id', @$user_role)->first();
                 if($permission){
                  $nav_menu[$grand_parent->id]['grand_parent']=$grand_parent->name;
                  $nav_menu[$grand_parent->id]['grand_parent_route']=$grand_parent->route;
                  $nav_menu[$grand_parent->id]['grand_parent_icon']=$grand_parent->icon;
                  $nav_menu[$grand_parent->id]['parent'][$parent->id]['parent_id']=$parent->id;
                  $nav_menu[$grand_parent->id]['parent'][$parent->id]['parent_name']=$parent->name;
                  $nav_menu[$grand_parent->id]['parent'][$parent->id]['parent_route']=$parent->route;
                }
              }

              $childs=App\Model\Menu::where('parent', $parent->id)->where('status',1)->orderBy('sort', 'asc')->get();
              if(count($childs)>0){
                foreach($childs as $child){
                    $permission=App\Model\MenuPermission::where('permitted_route',$child->route)->whereIn('role_id', @$user_role)->first();
                    if($permission){
                      $nav_menu[$grand_parent->id]['is_child']='yes';
                      $nav_menu[$grand_parent->id]['grand_parent']=$grand_parent->name;
                      $nav_menu[$grand_parent->id]['grand_parent_route']=$grand_parent->route;
                      $nav_menu[$grand_parent->id]['grand_parent_icon']=$grand_parent->icon;
                      $nav_menu[$grand_parent->id]['parent'][$parent->id]['parent_name']=$parent->name;
                      $nav_menu[$grand_parent->id]['parent'][$parent->id]['parent_route']=$parent->route;
                      $nav_menu[$grand_parent->id]['parent'][$parent->id]['child'][$child->id]['child_id']=$child->id;
                      $nav_menu[$grand_parent->id]['parent'][$parent->id]['child'][$child->id]['child_name']=$child->name;
                      $nav_menu[$grand_parent->id]['parent'][$parent->id]['child'][$child->id]['child_route']=$child->route;
                    }
                }
              }
            }
          }
        @endphp
      @endif

      {{-- Menu Initialized from $nav_menu Array --}}
      @foreach($nav_menu as $grand_menu)
    

        <li class="submenu">
          <a href="#" class="{{$parentroute==$grand_menu['grand_parent_route'] ? 'subdrop pnavbar' :''}}">
            <i class="fa {{$grand_menu['grand_parent_icon'] ? $grand_menu['grand_parent_icon'] :'fa-copy'}}"></i>
            <span>{{$grand_menu['grand_parent']}}</span>
            <span class="menu-arrow"></span>
          </a>
          <ul style="display:{{$parentroute==$grand_menu['grand_parent_route'] ? 'block' :''}};">
            @foreach($grand_menu['parent'] as $parent_menu)
              @if(!empty($parent_menu['child']))
                <li class="submenu">
                  <a href="#" class="{{$childroute==$parent_menu['parent_route'] ? 'subdrop cnavbar' :''}}">
                    <i class="fa {{$childroute==$parent_menu['parent_route'] ? 'fa-folder-open text-warning' :'fa-folder'}}"></i>
                    <span>{{$parent_menu['parent_name']}}</span>
                    <span class="menu-arrow"></span>
                  </a>
                  <ul style="display: {{$childroute==$parent_menu['parent_route'] ? 'block' :''}};">
                    @foreach($parent_menu['child'] as $child_menu)
                    <li class="{{$route==$child_menu['child_route'] ? 'active' : ''}}">
                      <a href="{{route($child_menu['child_route'])}}">
                        <i class="fa fa-gg {{$route==$child_menu['child_route'] ? 'text-success' : ''}}"></i>
                        <span>{{$child_menu['child_name']}}</span>
                      </a>
                    </li>
                    @endforeach
                  </ul>
                </li>
              @else
                <li class="{{$route==$parent_menu['parent_route'] ? 'active' : ''}}">
                  <a href="{{route($parent_menu['parent_route'])}}">
                    <i class="fa fa-gg {{$route==$parent_menu['parent_route'] ? 'text-success' : ''}}"></i>
                    <span>{{$parent_menu['parent_name']}}</span>
                  </a>
                </li>
              @endif
            @endforeach
          </ul>
        </li>
      @endforeach
    </ul>
    <div class="clearfix"></div>
  </div>
  <footer class="asideFooter">
    <div class="inner">
      <a href="http://stopviolence.brac.net/" target="__blank" style="color: #ffffff;padding: 8px;" data-toggle="tooltip" data-placement="top" title="Clicking on this button will direct you to the VAWC Data Management System">VAWC Data Management System</a>
    </div>
  </footer>
  <div class="clearfix"></div>
  </div>

</div>
  <!-- End Sidebar