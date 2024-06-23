<nav class="navbar-default navbar-static-side" role="navigation">
     <div class="sidebar-collapse">
          <ul class="nav metismenu" id="side-menu">
               <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                              <!-- <img alt="image" class="img-circle" src="img/profile_small.jpg" /> -->
                         </span>
                         <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                              <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">David Williams</strong>
                                   </span> <span class="text-muted text-xs block">Art Director <b class="caret"></b></span> </span> </a>
                         <ul class="dropdown-menu animated fadeInRight m-t-xs">
                              <li><a href="profile.html">Profile</a></li>
                              <li><a href="contacts.html">Contacts</a></li>
                              <li><a href="mailbox.html">Mailbox</a></li>
                              <li class="divider"></li>
                              <li><a href="{{ route('auth.logout') }}">Logout</a></li>
                         </ul>
                    </div>
                    <div class="logo-element">
                         IN+
                    </div>
               </li>
               <li class="active">
                    <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">QL Thanh Vien</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                         <li><a href="{{route('user.index')}}">QL Thanh Vien</a></li>
                         <li><a href="{{route('user.catalogue.index')}}">QL Nhom Thanh Vien</a></li>
                    </ul>
               </li>

               <li class="active">
                    <a href="#"><i class="fa fa-file"></i> <span class="nav-label">QL Ngon ngu</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                         <li><a href="{{route('language.index')}}">QL Ngon ngu</a></li>
                    </ul>
               </li>


               <li class="active">
                    <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">QL Bai viet</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                         <li><a href="{{route('post.catalogue.index')}}">QL Bai viet</a></li>
                         <li><a href="{{route('post.index')}}">QL Nhom Bai viet</a></li>
                    </ul>
               </li>
          </ul>

     </div>
</nav>