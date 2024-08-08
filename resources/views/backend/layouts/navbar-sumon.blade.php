
<div class="left main-sidebar">
 <style type="text/css">
 .pnavbar{
  background-color: #4980b5 !important;
}
.cnavbar{
  background-color: #305171 !important;
}
</style>
<div class="sidebar-inner leftscroll">

  <div id="sidebar-menu">


   <ul>
    @php
    $prefix=Request::route()->getPrefix();
    $route=Route::current()->getName();
    $user_role=Auth::user()->role;
    $parentroutearray = explode('.',$route);
    $parentroute = $parentroutearray[0];
    $childroute = $parentroute.'.'.@$parentroutearray[1];
    @endphp

    <li class="submenu">
      <a class="{{$route== 'dashboard'?'active':''}}" href="{{route('dashboard')}}"><i class="fa fa-fw fa-bars"></i><span> Dashboard </span> </a>
    </li>


    <!-- Code for Menu Management from Superadmin -->
    @if(Auth::user()->role==0)
    @php 
    $menus=App\Model\Menu::where('parent', 0)->where('status',1)->orderBy('sort', 'asc')->get();
    @endphp
    @foreach ($menus as $menu)
    <!-- if child menu exist-->
    @php
    $childMenus = App\Model\Menu::where('parent',$menu->id)->where('status',1)->orderBy('sort', 'asc')->get();
    if (count($childMenus)>0) {
      @endphp
      <li class="submenu">
        <a style="cursor: pointer;" class="{{($parentroute == $menu->route)? 'subdrop pnavbar':''}}">
          @if($menu->icon ==='N/A')
          <i class="fa fa-circle-o"></i>
          @else
          <i class="fa {{$menu->icon}}"></i>
          @endif
          <span> {{$menu->name}}</span> <span class="menu-arrow"></span>
        </a>
        <ul style="display: {{$parentroute==$menu->route ? 'block' : ''}};">
         @foreach($childMenus as $child) 
         <!-- if Sub-child menu exist-->
         @php
         $sub_childMenus = App\Model\Menu::where('parent',$child->id)->where('status',1)->orderBy('sort', 'asc')->get();
         if (count($sub_childMenus)>0) {
          @endphp
          <li class="submenu">
            <a href="#" class="{{$childroute==$child->route ? 'subdrop cnavbar' :''}}">
              <i class="fa {{$childroute==$child->route ? 'fa-folder-open text-success' :'fa-folder'}}"></i>
              <span>{{$child->name}}</span><span class="menu-arrow"></span>
            </a>
            <ul style="display: {{$childroute==$child->route ? 'block' :''}}"> 
              @foreach($sub_childMenus as $sc)
              <li class="{{$sc->route==$route ? 'active' : ''}}">
                <a href="{{route($sc->route)}}">
                  <i class="fa fa-gg {{($sc->route==$route)? 'text-success':''}}"></i>
                  <span>{{$sc->name}}</span>
                </a>
              </li>
              @endforeach
            </ul>
          </li>
          @php } else { @endphp <!-- if Sub-child menu doesn't exist-->
          <li class="{{($route == $child->route)? 'active':''}}">
            <a href="{{ route($child->route) }}">
              <i class="fa fa-gg {{($route ==$child->route)? 'text-success':''}}"></i>
              <span>{{$child->name}}</span>
            </a>
          </li>
          @php }@endphp
          @endforeach
        </ul>
      </li> <!--End Parent Manu-->
      @php } else { @endphp <!-- if child menu doesn't exist-->
      <li class="{{($parentroute == $menu->route)? 'pnavbar':''}}"> <!--Single Menu only-->
        <a href="#">
          @if($menu->icon ==='N/A')
          <i class="fa fa-folder"></i>
          @else
          <i class="fa {{$menu->icon}}"></i>
          @endif
          <span>{{$menu->name}}</span>
        </a>
      </li>
      @php }  @endphp
      @endforeach                               

      @else

      <!-- Menu Management for admin by Role wise -->

      @php 
      $menus=App\Model\Menu::where('parent', 0)->where('status',1)->orderBy('sort', 'asc')->get();
      @endphp
      @foreach ($menus as $menu)
      <!-- if child menu exist-->
      @php
      $childMenus = App\Model\Menu::where('parent',$menu->id)->where('status',1)->orderBy('sort', 'asc')->get();
      if (count($childMenus)>0) {
        @endphp
        <li class="submenu">
          <a style="cursor: pointer;" class="{{($parentroute == $menu->route)? 'subdrop pnavbar':''}}">
            @if($menu->icon ==='N/A')
            <i class="fa fa-circle-o"></i>
            @else
            <i class="fa {{$menu->icon}}"></i>
            @endif
            <span> {{$menu->name}}</span> <span class="menu-arrow"></span>
          </a>
          <ul style="display: {{$parentroute==$menu->route ? 'block' : ''}};">
           @foreach($childMenus as $child) 
           <!-- if Sub-child menu exist-->
           @php
           $sub_childMenus = App\Model\Menu::where('parent',$child->id)->where('status',1)->orderBy('sort', 'asc')->get();
           if (count($sub_childMenus)>0) {
            @endphp
            <li class="submenu">              
              <a href="#" class="{{$childroute==$child->route ? 'subdrop cnavbar' :''}}">
                <i class="fa {{$childroute==$child->route ? 'fa-folder-open text-success' :'fa-folder'}}"></i>
                <span>{{$child->name}}</span><span class="menu-arrow"></span>
              </a>
              <ul style="display: {{$childroute==$child->route ? 'block' :''}}"> 
                @foreach($sub_childMenus as $sc)
                @php
                $permission= App\Model\MenuPermission::with(['parent','menu'])->orderBy('menu_id','asc')->where('role_id',$user_role)->get();
                @endphp
                @foreach($permission as $per)
                @php 
                if ($per->permitted_route==$sc->route) { @endphp
                <li class="{{$sc->route==$route ? 'active' : ''}}">
                  <a href="{{route($sc->route)}}">
                    <i class="fa fa-gg {{($sc->route==$route)? 'text-success':''}}"></i>
                    <span>{{$sc->name}}</span>
                  </a>
                </li>
                @php } @endphp
                @endforeach
                
                @endforeach
              </ul>
            </li>
            @php } else { @endphp <!-- if Sub-child menu doesn't exist-->
            @php
            $permission= App\Model\MenuPermission::with(['parent','menu'])->orderBy('menu_id','asc')->where('role_id',$user_role)->get();
            @endphp
            @foreach($permission as $per)
            @php 
            if ($per->permitted_route==$child->route) { @endphp
            <li class="{{($route == $child->route)? 'active':''}}">
              <a href="{{ route($child->route) }}">
                <i class="fa fa-gg {{($route ==$child->route)? 'text-success':''}}"></i>
                <span>{{$child->name}}</span>
              </a>
            </li>
            @php } @endphp
            @endforeach
            @php }@endphp
            @endforeach
          </ul>
        </li> <!--End Parent Manu-->
        @php } else { @endphp <!-- if child menu doesn't exist-->
        @php
        $permission= App\Model\MenuPermission::with(['parent','menu'])->orderBy('menu_id','asc')->where('role_id',$user_role)->get();
        @endphp
        @foreach($permission as $per)
        @php 
        if ($per->permitted_route==$menu->route) { @endphp
        <li class="{{($parentroute == $menu->route)? 'pnavbar':''}}"> <!--Single Menu only-->
          <a href="#">
            @if($menu->icon ==='N/A')
            <i class="fa fa-folder"></i>
            @else
            <i class="fa {{$menu->icon}}"></i>
            @endif
            <span>{{$menu->name}}</span>
          </a>
        </li>
        @php } @endphp
        @endforeach
        @php }  @endphp
        @endforeach


        @endif <!--End first if-->
      </ul> <!--End Navbar Menu-->
      @include('backend.layouts.old-navbar')
      <div class="clearfix">

      </div>

    </div>

    <div class="clearfix"></div>

  </div>

</div>
  <!-- End Sidebar