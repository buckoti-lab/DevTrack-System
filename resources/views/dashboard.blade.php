<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard</title>

    {{-- Laravel Vite css --}}    
    @vite(['resources/css/app.css','resources/css/dashboard.css','resources/css/dynamic-page.css','resources/css/dataTables.bootstrap5.min.css','resources/css/bootstrap.min.css']) 
    
</head>
<body>
   <div id="side-navbar" class="side-navbar">
     <div>
      <h2>&nbsp; <span>SOM system </span></h2>
      <div id="upper-nav">
          <a href="#" data-content="home"><img src="storage/icon/house-solid-full.svg">&nbsp;<span>Home</span></a>
            @if(!empty( Auth::user()->last_name ))
            <a href="#"  class="side-dropdown-toggle"><img src="storage/icon/users-solid-full.svg">&nbsp; <span>Users</span>
               <div class="side-submenu">
                 <a href="#" data-content="users"><img src="storage/icon/eye-solid-full.svg">&nbsp; <span>Manage users</span></a>
               </div>
            </a>
            <a href="#" data-content="reset_user_password" ><img src="storage/icon/unlock-solid-full.svg">&nbsp; <span>Reset user password</span></a>
            <a href="#" class="side-dropdown-toggle"><img src="storage/icon/list-check-solid-full.svg">&nbsp; <span>Quotes</span>
               <div class="side-submenu">
                 <a href="#" data-content="quotes"><img src="storage/icon/eye-solid-full.svg">&nbsp; <span>Manage quotes</span></a>
               </div>
            </a>
            <a href="#" class="side-dropdown-toggle"><img src="storage/icon/bullhorn-solid-full.svg">&nbsp; <span>Announcements</span>
               <div class="side-submenu">
                 <a href="#" data-content="announcements"><img src="storage/icon/eye-solid-full.svg">&nbsp; <span>Manage Announcements</span></a>
               </div>
            </a>

            <a href="#" class="side-dropdown-toggle"><img src="storage/icon/list-check-solid-full.svg">&nbsp; <span>Documents</span>
               <div class="side-submenu">
                 <a href="#" data-content="documents"><img src="storage/icon/eye-solid-full.svg">&nbsp; <span>Manage documents</span></a>
               </div>
            </a> 

            <a href="#" class="side-dropdown-toggle"><img src="storage/icon/progress.svg">&nbsp; <span>Progress</span>
               <div class="side-submenu">
                 <a href="#" data-content="progress"><img src="storage/icon/eye-solid-full.svg">&nbsp; <span>Project progress</span></a>
               </div>
            </a> 
           @endif
      </div>
     </div>
    </div>

    <div id="main-content">
      <section id="upper-content">
          <div style="display: flex; align-items: center;">
             <button id="toggle-navbar-btn"><img src="storage/icon/bars-solid-full.svg"></button>
              <h4 style="margin-left: 1rem;"> Welcome, <span id="username">{{ Auth::user()->first_name}} {{ Auth::user()->second_name}}</span>! </h4>
          </div>

          <div id="upper-content-profile">
            <img id="profile-img" alt="Profile Picture" title="User profile picture">
          </div>

           <div id="profile-content">
            <div id="upper-profile-content">
                <p>&nbsp;<b>{{ Auth::user()->first_name}} {{ Auth::user()->second_name}}</b></p>
                <hr>
                <a href="" data-content="edit_profile">
                    <p>&nbsp; Edit profile</p>
                    <span>></span>
                </a>
                <a href="" data-content="view_profile">
                    <p> &nbsp; View profile</p>
                    <span>></span>
                </a>
                <a href="" data-content="change_password">
                <p>&nbsp; Change password</p>
                <span>></span>
                </a>
            </div>
            <div id="lower-profile-content">
                <a href="logout">
                <p>&nbsp; Logout</p>
                <span>></span>
                </a>
            </div>
        </div> 
     </section>
    
    <section id="lower-content">
    </section>
    </div>

{{-- Laravel Vite scripts --}}    
@vite([
 'resources/js/jquery-3.7.1.min.js',         

 'resources/js/jquery.dataTables.min.js',     
 'resources/js/dataTables.bootstrap5.min.js', 

 'resources/js/bootstrap.bundle.min.js',      
 'resources/js/chart.js',

 'resources/js/app.js',
 'resources/js/dashboard.js',
 'resources/js/functions.js',

])

<!--  'resources/js/sweetalert2.all.min.js' 'resources/css/sweetalert2.min.css  'resources/js/progress.js',
 'resources/js/quote.js', -->
<!-- <script src="storage/libraries/sweetalert2.all.min.js"></script> -->

@guest
<!-- <script>window.location = "/login";</script> -->
 <!-- <script>window.location = "{{ route('get.login') }}"</script> -->
  <script>
    window.location.href = "{{ route('get.login') }}";
</script>
@endguest

</body>
</html>
