<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'].'custom.css') }}">
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'].'root.css') }}">
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'].'cs.css') }}">
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'].'as.css') }}">
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'].'nx.css') }}">
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'].'custom.css') }}">
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'].'custom-reusable-style.css') }}">
    @yield('styles')
  </head>
  <body class="h-screen w-full">
    <meta name="csrf-token" content="{{ csrf_token() }}">
       <!-- Taskbar -->
        <div class="taskbar-slide h-16 flex items-center w-full absolute">
        
            <div class="flex justify-center ml-10 w-full relative h-full" id="toolbar">
              <div class="bg absolute w-full  bottom-0">
                <img id="shelf" class="w-full" src="{{ asset($constants['IMAGEFILEPATH'].'shelf.png')}}" alt="">
              </div>
            </div>
            <div class="flex items-center gap-8 w-48 justify-end pr-5">
                <i id="search-icon" class="ri-search-line "></i>
                <i id="notification-icon" class="ri-notification-3-line "></i>
            </div>
          
        </div>
      <main class="flex w-full h-full cs plugin fm role">

        <!-- Sidebar -->
          <aside class="h-full relative">
        <input type="checkbox" class="hidden" id="sidebar-toggle" />
        <label
          for="sidebar-toggle"
          class="absolute lg:hidden top-1 -right-8 px-1"
        >
          <i class="ri-bar-chart-horizontal-line"></i>
        </label>
        <div class="h-full sidebar">
          <div class="sidebar-container">
            <div class="p-6">
              <a href="{{ route('dashboard') }}">
                <img class="w-20" src="{{ asset($constants['IMAGEFILEPATH'].'logo.png')}}" alt="Dots Logo" />
              </a>
            </div>
            <div class="sidebar-content">
              <ul class="space-y-1">
                <li>
                  <a
                    class="w-full px-6 py-3 rounded-r-lg block flex justify-between items-center"
                    href="{{ route('Overviews') }}"
                  >
                    <span class="font-normal"> Overview </span>
                    <i
                      class="ri-arrow-right-s-line text-c-yellow right-arrow text-2xl big-right-arrow"
                    ></i>
                  </a>
                </li>
                @if(!empty($filteredPermissions['backendManagement']) &&
                in_array('notice', $filteredPermissions['backendManagement'])
                )
                <li>
                  <div
                    role="button"
                    onclick="toggleDropMenu(this)"
                    class="drop-menu cursor-pointer rounded-r-lg"
                  >
                    <div
                      class="w-full px-6 py-3 flex justify-between items-center"
                      href="#"
                    >
                      <span class="font-normal"> System Settings (WIP)</span>
                      <i
                        class="ri-arrow-right-s-line text-c-yellow transition-all text-2xl big-right-arrow"
                      ></i>
                    </div>                    
                    <ul class="drop-list text-sm space-y-1">
                    @if(!empty($filteredPermissions['backendManagement']) &&
                        in_array('basic', $filteredPermissions['backendManagement'])
                      )
                      <li>
                        <a
                          href="system-setting-basic-page.html"
                          class="block py-2 px-8 rounded-r-md w-full flex justify-between items-center"
                        >
                          <span  class="font-normal">Basic</span>
                          <i
                            class="ri-arrow-right-s-line text-c-yellow right-arrow text-2xl"
                          ></i>
                        </a>
                      </li>
                      @endif
                      @if(!empty($filteredPermissions['backendManagement']) &&
                        in_array('menu', $filteredPermissions['backendManagement'])
                      )
                      <li>
                        <a
                          href="#"
                          class="block py-2 px-8 rounded-r-md w-full flex justify-between items-center"
                        >
                          <span class="font-normal">Menu</span>
                          <i
                            class="ri-arrow-right-s-line text-c-yellow right-arrow text-2xl"
                          ></i>
                        </a>
                      </li>
                      @endif
                      @if(!empty($filteredPermissions['backendManagement']) &&
                        in_array('notice', $filteredPermissions['backendManagement'])
                      )
                      <li>
                        <a
                          href="system-setting-notice.html"
                          class="block py-2 px-8 rounded-r-md w-full flex justify-between items-center"
                        >
                          <span class="font-normal">Notice</span>
                          <i
                            class="ri-arrow-right-s-line text-c-yellow right-arrow text-2xl"
                          ></i>
                        </a>
                      </li>
                      @endif
                      @if(!empty($filteredPermissions['backendManagement']) &&
                        in_array('internet-access', $filteredPermissions['backendManagement'])
                      )
                      <li>
                        <a
                          href="#"
                          class="block py-2 px-8 rounded-r-md w-full flex justify-between items-center"
                        >
                          <span class="font-normal">Intranet Access</span>
                          <i
                            class="ri-arrow-right-s-line text-c-yellow right-arrow text-2xl"
                          ></i>
                        </a>
                      </li>
                      @endif
                    </ul>
                  </div>
                </li>
                @endif

                <li>
                  <div
                    role="button"
                    onclick="toggleDropMenu(this)"
                    class="drop-menu cursor-pointer rounded-r-lg"
                  >
                  @if(!empty($filteredPermissions['userManagement'])) 
                    <div
                      class="w-full px-6 py-3 flex justify-between items-center"
                      href="#"
                    >
                    
                      <span class="font-normal">User Management</span>
                      <i
                        class="ri-arrow-right-s-line text-c-yellow transition-all text-2xl big-right-arrow"
                      ></i>
                    </div>
                   @endif
                    <ul class="drop-list text-sm space-y-1">
                    @if(!empty($filteredPermissions['userManagement']))
                      <li>
                        <a
                          href="{{ route('useradmin') }}"
                          class="block py-2 px-8 rounded-r-md w-full flex justify-between items-center"
                        >
                          <span class="font-normal">Users &amp; Groups </span>
                          <i
                            class="ri-arrow-right-s-line text-c-yellow right-arrow text-2xl"
                          ></i>
                        </a>
                      </li>
                      @endif
                      @if(!empty($filteredPermissions['roleManagement']))
                      <li>
                        <a
                          href="{{ route('rolesadmin') }}"
                          class="block py-2 px-8 rounded-r-md w-full flex justify-between items-center"
                        >
                          <span class="font-normal">Role</span>
                          <i
                            class="ri-arrow-right-s-line text-c-yellow right-arrow text-2xl"
                          ></i>
                        </a>
                      </li>
                      @endif
                      @if(!empty($filteredPermissions['userManagement']))
                      <li>
                        <a
                          href="{{ route('permissionsadmin') }}"
                          class="block py-2 px-8 rounded-r-md w-full flex justify-between items-center"
                        >
                          <span class="font-normal">Document Permission</span>
                          <i
                            class="ri-arrow-right-s-line text-c-yellow right-arrow text-2xl"
                          ></i>
                        </a>
                      </li>
                      @endif
                      <!-- <li>
                        <a
                          href="#"
                          class="block py-2 px-8 rounded-r-md w-full flex justify-between items-center"
                        >
                          <span class="font-normal">Blocked IP</span>
                          <i
                            class="ri-arrow-right-s-line text-c-yellow right-arrow text-2xl"
                          ></i>
                        </a>
                      </li> -->
                    </ul>
                  </div>
                </li>

                @if(!empty($filteredPermissions['backendManagement']) &&
                in_array('logs', $filteredPermissions['backendManagement'])
                )
                <li>
                  <div
                    role="button"
                    onclick="toggleDropMenu(this)"
                    class="drop-menu cursor-pointer rounded-r-lg"
                  >
                    <div
                      class="w-full px-6 py-3 flex justify-between items-center"
                      href="#"
                    >
                      <span class="font-normal">Saftey Control</span>
                      <i
                        class="ri-arrow-right-s-line text-c-yellow transition-all text-2xl big-right-arrow"
                      ></i>
                    </div>                    
                    <ul class="drop-list text-sm space-y-1">
                      <li>
                        <a
                          href="{{ route('logs') }}"
                          class="block py-2 px-8 rounded-r-md w-full flex justify-between items-center"
                        >
                          <span class="font-normal">Login Log</span>
                          <i
                            class="ri-arrow-right-s-line text-c-yellow right-arrow text-2xl"
                          ></i>
                        </a>
                      </li>
                      <li>
                        <a
                          href="{{ route('operation_logs') }}"
                          class="block py-2 px-8 rounded-r-md w-full flex justify-between items-center"
                        >
                          <span class="font-normal">Operation Log</span>
                          <i
                            class="ri-arrow-right-s-line text-c-yellow right-arrow text-2xl"
                          ></i>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
                @endif

                @if(!empty($filteredPermissions['backendManagement']) && 
                  in_array('storage', $filteredPermissions['backendManagement']) &&
                  in_array('backups', $filteredPermissions['backendManagement'])
                  )
                <li>
                  <div
                    role="button"
                    onclick="toggleDropMenu(this)"
                    class="drop-menu cursor-pointer rounded-r-lg"
                  >
                  
                    <div
                      class="w-full px-6 py-3 flex justify-between items-center"
                      href="#"
                    >
                      <span class="font-normal">Storage/file (WIP)</span>
                      <i
                        class="ri-arrow-right-s-line text-c-yellow transition-all text-2xl big-right-arrow"
                      ></i>
                    </div>
                    
                    <ul class="drop-list text-sm space-y-1">
                      <li>
                        <a
                          href="#"
                          class="block py-2 px-8 rounded-r-md w-full flex justify-between items-center"
                        >
                          <span class="font-normal">Storage</span>
                          <i
                            class="ri-arrow-right-s-line text-c-yellow right-arrow text-2xl"
                          ></i>
                        </a>
                      </li>
                      <li>
                        <a
                          href="storage-file-backup.html"
                          class="block py-2 px-8 rounded-r-md w-full flex justify-between items-center"
                        >
                          <span class="font-normal">Backup</span>
                          <i
                            class="ri-arrow-right-s-line text-c-yellow right-arrow text-2xl"
                          ></i>
                        </a>
                      </li>
                      @if(!empty($filteredPermissions['backendManagement']) &&
                        in_array('share', $filteredPermissions['backendManagement'])
                      )
                      <li>
                        <a
                          href="storage-file-share.html"
                          class="block py-2 px-8 rounded-r-md w-full flex justify-between items-center"
                        >
                          <span class="font-normal">Share</span>
                          <i
                            class="ri-arrow-right-s-line text-c-yellow right-arrow text-2xl"
                          ></i>
                        </a>
                      </li>
                      @endif

                      @if(!empty($filteredPermissions['backendManagement']) &&
                        in_array('webdev-mount', $filteredPermissions['backendManagement'])
                      )
                      <li>
                        <a
                          href="#"
                          class="block py-2 px-8 rounded-r-md w-full flex justify-between items-center"
                        >
                          <span class="font-normal">webDAV Mount</span>
                          <i
                            class="ri-arrow-right-s-line text-c-yellow right-arrow text-2xl"
                          ></i>
                        </a>
                      </li>
                      @endif
                      @if(!empty($filteredPermissions['backendManagement']) &&
                        in_array('media', $filteredPermissions['backendManagement'])
                      )
                      <li>
                        <a
                          href="settings-storage-media-preview.html"
                          class="block py-2 px-8 rounded-r-md w-full flex justify-between items-center"
                        >
                          <span class="font-normal">Media file preview &amp; Video</span>
                          <i
                            class="ri-arrow-right-s-line text-c-yellow right-arrow text-2xl"
                          ></i>
                        </a>
                      </li>
                      @endif
                      @if(!empty($filteredPermissions['backendManagement']) &&
                        in_array('client', $filteredPermissions['backendManagement'])
                      )
                      <li>
                        <a
                          href="#"
                          class="block py-2 px-8 rounded-r-md w-full flex justify-between items-center"
                        >
                          <span class="font-normal">Client and App</span>
                          <i
                            class="ri-arrow-right-s-line text-c-yellow right-arrow text-2xl"
                          ></i>
                        </a>
                      </li>
                      @endif
                    </ul>
                  </div>
                </li>
                @endif

                <li>
                  <a
                    class="w-full px-6 py-3 rounded-r-lg block flex justify-between items-center"
                    href="settings-plugin.html"
                  >
                    <span class="font-normal">Plugin Center (WIP)</span>
                    <i
                      class="ri-arrow-right-s-line text-c-yellow right-arrow text-2xl"
                    ></i>
                  </a>
                </li>
                <li>
                  <a
                    class="w-full px-6 py-3 rounded-r-lg block flex justify-between items-center"
                    href="settings-server-scheduled-tasks.html"
                  >
                    <span class="font-normal">Scheduled Tasks (WIP)</span>
                    <i
                      class="ri-arrow-right-s-line text-c-yellow right-arrow text-2xl"
                    ></i>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </aside>

       <!-- Main Content -->
       @yield('content')
       <!-- Main Content end --> 
      
      </main>
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
     <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset($constants['JSFILEPATH'].'sidebar.js') }}"></script>
    <script src="{{ asset($constants['JSFILEPATH'].'select-dropdown.js') }}"></script>
    <script src="{{ asset($constants['JSFILEPATH'].'tabs.js') }}"></script>
    <script src="{{ asset($constants['JSFILEPATH'].'taskbar.js') }}"></script>
    @yield('scripts')
  </body>
</html>
