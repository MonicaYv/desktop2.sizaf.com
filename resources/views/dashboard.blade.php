@extends('layouts.common')
@section('title', 'Dashboard')
@section('styles')
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'dashbord.css') }}">
    <!-- <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'filemanager.css') }}"> -->

@endsection
@section('content')

    <div class="w-full h-full dashboard cs pt-20">

        <!-- Desktop apps   -->
        <!-- <div class="desktopapps-div w-full overflow-x-auto">
                                            <div id="desktopapps" class="desktop-apps allapplist p-2 pt-3 w-min h-full flex flex-col gap-1 flex-wrap">

                                            </div>
                                        </div> -->
        <!--w-min :- giving issue || removed by: laxmi || date: 15-aug-24 -->
        <div class="desktopapps-div w-full overflow-x-auto">
            <div id="desktopapps"
                class="desktop-apps  content-start allapplist gap-4 p-2 pt-3 h-full flex flex-col  flex-wrap">

            </div>
        </div>

        <!-- Clock -->
        <div class="clock flex flex-col items-center gap-2" id="clock"></div>

        <!-- Notification -->
        <div id="notification" class="Notification h-80 absolute right-5 sm:right-20 top-16 hidden overflow-hidden">
            <div class="h-16 border-b-2 border-c-gray py-4 px-4 flex items-center justify-between">
                <h1 class="text-sm sm:text-lg text-c-black font-normal">Notification Center</h1>
                <h1 class="text-sm sm:text-lg text-c-yellow font-medium cursor-pointer">Mark all as read</h1>
            </div>
            <div class="scrollbar-div overflow-y-auto" style="height: calc(100% - 64px);">
                <!-- <ul>
                                              <li class="border-b-2 border-c-gray px-4 py-2.5">
                                                <div class="flex items-start justify-between gap-20">
                                                  <p class="text-sm text-c-black font-normal">Sara Martin mentioned you in a React for dark and light mode </p>
                                                  <i class="ri-close-circle-fill ri-1x cursor-pointer"></i>
                                                </div>
                                                <span class="text-c-time font-normal text-sm">5 min ago</span>
                                              </li>
                                               <li class="border-b-2 border-c-gray px-4 py-2.5">
                                                <div class="flex items-start justify-between gap-20">
                                                  <p class="text-sm text-c-black font-normal">Ralph Edwards completed Improve workflow mode</p>
                                                  <i class="ri-close-circle-fill ri-1x cursor-pointer"></i>
                                                </div>
                                                <span class="text-c-time font-normal text-sm">2 min ago</span>
                                              </li>
                                               <li class="border-b-2 border-c-gray px-4 py-2.5">
                                                <div class="flex items-start justify-between gap-20">
                                                  <p class="text-sm text-c-black font-normal">Arjun Mathur has sent you a request on facebook</p>
                                                  <i class="ri-close-circle-fill ri-1x cursor-pointer"></i>
                                                </div>
                                                <span class="text-c-time font-normal text-sm">Just now</span>
                                              </li>
                                               <li class="border-b-2 border-c-gray px-4 py-2.5">
                                                <div class="flex items-start justify-between gap-20">
                                                  <p class="text-sm text-c-black font-normal">Robert Fox completed Create new components</p>
                                                  <i class="ri-close-circle-fill ri-1x cursor-pointer"></i>
                                                </div>
                                                <span class="text-c-time font-normal text-sm">2 hours ago</span>
                                              </li>
                                            </ul> -->
            </div>
        </div>

        <!-- Search Input -->
        <div id="search" class="Search hidden fixed top-60 sm:top-72 md:top-80 lg:top-64">
            <div class="row">
                <i class="ri-search-line search-icon absolute"></i>
                <input type="search" id="searchInput" placeholder="Search">
                <i class="ri-close-line cross-icon absolute" onclick=""></i>
            </div>
            <div id="searchsuggestions" class="searchdata hidden px-3 py-3 max-h-96">
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="dashboard-sidebar w-16 px-2 hidden sm:block">
            @foreach ($apps as $app)
                <a href="#"data-path =" {{ base64UrlEncode($app->path) }}" class="folders openiframe selectapp" data-appkey="{{ base64UrlEncode($app->id) }}" data-filekey="{{ base64UrlEncode($app->id) }}" data-filetype="app" data-apptype="app">
                    <img class="mb-2"src="{{ asset($constants['APPFILEPATH'] . $app->icon) }}" alt="{{ $app->name }}" /></a>
            @endforeach
        </div>

        <!-- Administrator -->
        <div id="administrator" class="Administrator h-max absolute right-5 sm:right-28 bottom-16 hidden">
            <div class="flex items-center gap-5 pl-10 pt-5">
                <form action="{{ route('ProfilePic') }}" id="FormProfilePic" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="logo">
                        <input type="file" name="profile" accept="image/*" id="ProfilePic" class="hidden">
                        <label for="ProfilePic">
                            @if (Auth::user()->avatar != null)
                                <img class="w-16 h-16 rounded-full object-cover"
                                    src="{{ url('/') }}/{{ Auth::user()->avatar }}" alt="user image" />
                            @else
                                <img class="w-16" src="{{ asset($constants['IMAGEFILEPATH'] . 'profile.png') }}"
                                    alt="user image" />
                            @endif
                        </label>
                    </div>
                </form>
                <div class="user-info">
                    <h1 class="text-lg font-normal underline underline-offset-8 decoration-1">
                        {{ ucfirst(Auth::user()->roles->name) }}
                    </h1>
                    <h4 class="text-sm">{{ ucfirst(Auth::user()->name) }}</h4>
                </div>
            </div>
            <div class="bottom border-t-2 border-gray-500">
                <div class="features-list py-5 px-16">
                    <ul>
                        @if(!empty($filteredPermissions['fileManager']))
                        <li class="flex items-center gap-8 mb-4">
                            <i class="ri-folder-3-fill ri-1x Ad-iconcolor"></i>
                            <a href="{{ route('filemanager') }}">File manager</a>
                        </li>
                        @endif
                        @if(!empty($filteredPermissions['backendManagement']))
                        <li class="flex items-center gap-8 mb-4">
                            <i class="ri-bar-chart-fill ri-1x Ad-iconcolor"></i>
                            <a href="{{ route('useradmin') }}">Backend</a>
                        </li>
                        @endif
                        @if(!empty($filteredPermissions['userManagement']))
                        <li class="flex items-center gap-8 mb-4">
                            <i class="ri-user-fill ri-1x Ad-iconcolor"></i>
                            <a href="{{ route('useradmin') }}">User manage</a>
                        </li>
                        @endif
                        <li class="flex items-center gap-5 mb-4">
                            <i class="ri-download-2-line ri-1x Ad-iconcolor"></i>
                            <a href="#">Downloads</a>
                        </li>
                        <li class="flex items-center gap-8 mb-4">
                            <i class="ri-logout-box-r-line ri-1x Ad-iconcolor"></i>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Administrator end -->

        <!-- Footer -->

        <!-- Footer -->
        <div class="absolute bottom-4 right-4 px-5 has-tooltip">
            <img id="footer-logo" class="w-10 h-10" src="{{ asset($constants['IMAGEFILEPATH'] . 'logo.png') }}"
                alt="Logo" />
        </div>
        <!-- <div
                                                class="absolute py-1 px-2 text-start text-xs tooltip bottom-2 right-20 z-10 bg-white border rounded-md border-c-yellow font-normal"
                                              >
                                                Administrator
                                              </div> -->




    </div>
@endsection
@section('scripts')
    @php
        $path = base64UrlEncode('Desktop');
    @endphp
    <script>
        let path = @json($path);
        let navbar = true;
    </script>
    <script src="{{ asset($constants['JSFILEPATH'] . 'dashboard.js') }}"></script>
    <script>
        $(document).ready(function() {
            if ($('.navbarhead').hasClass('taskbar-slide')) {
                $('.navbarhead').removeClass('taskbar-slide');

            }

            $('#searchInput').on('input', function() {
                $('#searchsuggestions').html('');
                let searchQuery = $(this).val().trim(); // Get the search query from the input field
                if (searchQuery.length > 0) {
                    // Send AJAX request to the route
                    $.ajax({
                        url: '{{ route('search') }}', // Replace '/search' with your actual route URL
                        method: 'GET',
                        data: {
                            query: searchQuery
                        }, // Pass the search query as data
                        success: function(response) {
                            // Update the search results div with the response data
                            $('#searchsuggestions').html(response.html);
                            $('#searchsuggestions').removeClass('hidden');
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                } else {
                    // Clear the search results if the input is empty
                    $('#searchsuggestions').html('');
                    $('#searchsuggestions').addClass('hidden');
                }
            });

            $(document).on('change','#ProfilePic',function(){
                $('#FormProfilePic').submit();
            });
        });
    </script>
    {{-- <script>
        const desktopapp = @json(route('desktopapp'));
        const createFolderRoute = @json(route('createfolder'));
        const createFileRoute = @json(route('createfile'));
        const showFileDetail = @json(route('showpathdetail'));

        let path = @json($path);
        let navbar = true;
    </script>
    <script>
        $(document).ready(function() {
            if ($('.navbarhead').hasClass('taskbar-slide')) {
                $('.navbarhead').removeClass('taskbar-slide');
            }
            $('.search-cross-icon').on('click', function(e) {
                e.preventDefault();
                $('#searchbar').addClass('hidden');
                $('#searchsuggestions').addClass('hidden');
            });
        });
    </script> --}}

    {{-- <script src="{{ asset($constants['JSFILEPATH'] . 'dashboard.js') }}"></script> --}}
    @include('layouts.alert')
@endsection
