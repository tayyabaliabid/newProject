 @if(in_array(\Request::route()->getName(), ['admin.users', 'admin.user.create', 'admin.user.edit',
 'admin.numbers', 'admin.number.create', 'admin.number.edit'])) 

 <nav class="pcoded-navbar">
     <div class="pcoded-inner-navbar main-menu">
         <div class="pcoded-navigatio-lavel">Navigation</div>
         <ul class="pcoded-item pcoded-left-item">

             @if(in_array(\Request::route()->getName(), ['admin.users', 'admin.user.create', 'admin.user.edit']))
             <li class="{{ in_array(\Request::route()->getname(), ['admin.user.create']) ? 'active' : ''}}">
                 <a href="{{ route('admin.user.create') }}">
                     <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                     <span class="pcoded-mtext">Create</span>
                 </a>
             </li>
             <li class="{{ in_array(\Request::route()->getname(), ['admin.users', 'admin.user.edit']) ? 'active' : ''}}">
                 <a href="{{ route('admin.users') }}">
                     <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                     <span class="pcoded-mtext">Manage</span>
                 </a>
             </li>
             @endif

             @if(in_array(\Request::route()->getName(), ['admin.numbers', 'admin.number.create', 'admin.number.edit', 'admin.number.search']))
             <li class="{{ in_array(\Request::route()->getname(), ['admin.number.create']) ? 'active' : ''}}">
                 <a href="{{ route('admin.number.create') }}">
                     <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                     <span class="pcoded-mtext">Create</span>
                 </a>
             </li>
             <li class="{{ in_array(\Request::route()->getname(), ['admin.numbers', 'admin.number.edit']) ? 'active' : ''}}">
                 <a href="{{ route('admin.numbers') }}">
                     <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                     <span class="pcoded-mtext">Manage</span>
                 </a>
             </li>
             @endif

         </ul>
     </div>
 </nav>

 @endif