            <!-- topbar -->
            <div
            class="py-4 w-full hidden md:flex flex-row items-center gap-2 taskbar"
          >
            <div
              class="flex bg-c-white rounded-md w-16 h-8 justify-evenly ml-6"
            >
            <a href="{{ url('/filemanager',['path'=>base64UrlEncode($updatedPath)]);}}">
            <button>
                <i class="ri-arrow-left-line ri-lg"></i>
            </button>
            </a>
            <a href="{{ url('/filemanager',['path'=>base64UrlEncode($updatedPath)]);}}">
            <button>
                <i class="ri-arrow-right-line ri-lg text-c-gray-opaque"></i>
            </button>
            </a>
            </div>

            <div
              class="flex items-center rounded-md overflow-hidden bg-c-white h-8 md:ml-6 md:w-61 lg:w-8/12 cursor-pointer"
            >
            <a href="{{ url('/filemanager',['path'=>base64UrlEncode($updatedPath)]);}}">

                <button
                class="pt-3 pb-3 pl-4 hidden md:flex items-center justify-center border-r border-c-gray-opaque pr-3"
                >
                <i class="ri-arrow-up-line ri-lg"></i>
                </button>
            </a>
          
              <div
                class="flex items-center flex-grow flex-shrink overflow-x-auto scroll-x"
              >
              <button class="flex items-center px-2">
              <i class="ri-home-4-line pr-2"></i>Home
             {!! (count($pathComponents)>= 1) ? '<span>/</span>' : '' !!}
            </button>
            @if(!empty($pathComponents))
              @foreach($pathComponents as $pckey=> $pcomponent) 
                @if($pcomponent !='/' && !empty($pcomponent))
                <button class="flex items-center px-2 whitespace-nowrap">
                  <span class="flex-shrink-0"> {{ $pcomponent }}</span>
                   {!! ($pckey!=(count($pathComponents)-1)) ? '<span>/</span>' :'' !!}
                </button>
                @endif
              @endforeach
            @endif
              </div>

              <button
                class="pr-5 pt-3 pb-3 px-4 flex items-center justify-center"
              >
                <i class="ri-star-line"></i>
              </button>

              <button class="pr-4 pt-3 pb-3 flex items-center justify-center">
                <i class="ri-loop-left-line"></i>
              </button>
            </div>

            <div
              class="flex items-center rounded-md overflow-hidden flex-shrink-0 flex-grow bg-c-white h-8 ml-7 mr-6 w-11/12 md:w-2/12"
            >
              <input
                type="text"
                class="pl-4 pt-2.5 pb-2.5 flex-shrink flex-grow border-none outline-none w-2/12"
                placeholder="Search" id="searchFiles" 
              />
              <div class="pt-3 pb-3 pr-4 flex items-center justify-center">
                <i class="ri-search-line"></i>
              </div>
            </div>
          </div>

          <!-- topTaskbar in mobile -->
          <div class="md:hidden w-full relative" id="taskbar">
            <div
              class="flex items-center justify-between overflow-hidden flex-shrink-0 bg-transparent h-8 w-11/12 ml-5 sm:ml-7 mb-3 mr-6 cursor-pointer flex-grow"
            >
              <div
                class="flex items-center space-x-6 w-3/4 sm:w-5/6 overflow-x-auto scroll-x"
              >
              <button class="flex items-center">
              <i class="ri-home-4-line pr-2"></i>Home
              {!! (count($pathComponents)>=1) ? '<span>/</span>' : '' !!}
            </button>
            @if(!empty($pathComponents))
              @foreach($pathComponents as $pckey=> $pcomponent) 
                @if($pcomponent !='/' && !empty($pcomponent))
                <button class="flex items-center">
                  <span class="truncate">New folder(0)</span>
                  {!! ($pckey!=(count($pathComponents)-1)) ? '<span>/</span>' :'' !!}
                </button>
                @endif
              @endforeach
            @endif
              </div>

              <div class="flex items-center space-x-2">
                <button
                  class="pr-2 pt-3 pb-3 flex items-center justify-center"
                  onclick="toggleView();"
                >
                  <i class="ri-gallery-view-2" id="view-button"></i>
                </button>
                <button
                  class="pt-3 pb-3 flex items-center justify-center dropdown-btn"
                >
                  <i class="ri-more-fill" id="more-button"></i>
                </button>
                <div
                  class="dropdown-option absolute z-10 right-4 top-8 bg-c-white border border-c-medium-gray rounded-lg shadow-md hidden w-10"
                  id="more-dropdown"
                >
                  <div class="hover-bg-c-yellow rounded-t-lg">
                    <a
                      href="#"
                      class="block p-1 flex justify-center items-center dropdown-item"
                      onclick="togglePanel('detail');"
                    >
                      <i class="ri-profile-line"></i>
                    </a>
                  </div>
                  <div class="hover-bg-c-yellow rounded-b-lg">
                    <a
                      href="#"
                      class="block p-1 flex justify-center items-center dropdown-item"
                      onclick="togglePanel('preview');"
                      ><i class="ri-eye-line"></i
                    ></a>
                  </div>
                </div>
              </div>
            </div>

            <div
              class="py-4 w-full flex flex-col items-center gap-2 taskbar"
              id="search"
            >
              <div
                class="flex items-center rounded-md overflow-hidden flex-shrink-0 flex-grow bg-c-white h-8 ml-7 mr-6 w-11/12 md:w-2/12"
              >
                <input
                  type="text"
                  class="pl-4 pt-2.5 pb-2.5 flex-shrink flex-grow border-none outline-none font-size-16 w-2/12"
                  placeholder="Search"
                />
                <div class="pt-3 pb-3 pr-4 flex items-center justify-center">
                  <i class="ri-search-line"></i>
                </div>
              </div>
            </div>
          </div>

          <!-- actionbar -->
          <div
            class="border-b border-c-light-gray1 flex justify-between items-center hidden md:flex text-c-black actionbar"
          >
            <div class="flex ml-6 gap-x-5 lg:gap-x-4 xl:gap-x-6 my-2 context-menulist">
              <div class="relative flex items-center new">
                <button class="flex gap-x-2">
                  <i class="ri-add-circle-fill ri-xl mt-1"></i><span>New</span>
                </button>
                <button class="dropdown-btn mt-1">
                  <i class="ri-arrow-drop-down-line ri-lg"></i>
                </button>
                <div
                  id="new-dropdown"
                  class="dropdown-option absolute mt-2 z-10 bg-c-white border border-c-medium-gray rounded-lg shadow-md hidden w-52 top-full"
                >
                 @if(!empty($contextTypes))
                  @foreach ($contextTypes as $contextType)
                    @if(!empty($contextType->contextOptions))
                      @foreach ($contextType->contextOptions as $option)
                        <div class="hover-bg-c-yellow rounded-t-lg">
                          <a href="#" class="flex block p-2 pl-4 dropdown-item clickmenu {{ $contextType->function }} " data-type="{{ $option->function }}">
                            <img src="{{ asset($constants['FILEICONPATH'].($option->image ?? 'default').$constants['ICONEXTENSION'])}}" alt="{{ $option->name }}" class="pr-4 w-11" /><span
                              >{{ $option->name }}</span
                            >
                          </a>
                        </div>
                        @endforeach
                      @endif
                    @endforeach
                  @endif
                </div>
              </div>
              @if(!empty($filteredPermissions['fileManager']) && in_array('upload', $filteredPermissions['fileManager']))
              <div class="relative flex items-center upload">
                <a href="#" class="clickmenu uploadFiles">
                  <button
                    class="flex gap-x-2">
                    <i class="ri-upload-2-line ri-lg mt-1"></i>
                    <span>Upload</span>
                  </button>
                </a>
              </div>
              @endif
              <a href="#" class="clickmenu cutFunction disabledicon fimanagertoolpanel"><button class="scissor">
                <i class="ri-scissors-2-fill ri-lg"></i>
              </button></a>
              <a href="#" class="clickmenu copyFunction disabledicon fimanagertoolpanel"><button class="copy">
                <i class="ri-file-copy-line ri-lg"></i>
              </button></a>
              <a href="#" class="clickmenu pasteFunction disabledicon fimanagertoolpanel"><button class="paste">
                <i class="ri-clipboard-line ri-lg"></i>
              </button></a>
              @if(!empty($filteredPermissions['fileManager']) && in_array('edit', $filteredPermissions['fileManager']))
              <a href="#" class="clickmenu renameFunction disabledicon fimanagertoolpanel"><button class="edit">
                <i class="ri-edit-line ri-lg"></i>
              </button></a>
              @endif
              <!-- <button class="share" onclick="togglePopup('sharePopup');">
                <i class="ri-share-fill ri-lg"></i> 
              </button> -->
              @if(!empty($filteredPermissions['fileManager']) && in_array('delete', $filteredPermissions['fileManager']))
              <a href="#" class="clickmenu deleteFunction disabledicon fimanagertoolpanel"><button class="delete">
                <i class="ri-delete-bin-line ri-lg"></i>
              </button></a>
              @endif
              <div class="relative flex items-center sort">
                <button class="flex gap-x-2">
                  <i class="ri-arrow-up-down-line ri-lg mt-1"></i>
                  <span>Sort</span>
                </button>
                <button class="dropdown-btn">
                  <i class="ri-arrow-drop-down-line ri-lg"></i>
                </button>
                <div
                  id="sort-dropdown"
                  class="dropdown-option absolute top-full mt-2 z-10 bg-c-white border border-c-medium-gray rounded-lg shadow-md hidden md:w-40 lg:w-44 xl:w-68"
                >
                @if(!empty($sortcontextTypes))
                  @foreach ($sortcontextTypes as $scontextType)
                    @if(!empty($scontextType->contextOptions))
                      @foreach ($scontextType->contextOptions as $soption)
                      <div class="hover-bg-c-yellow rounded-t-lg">
                        <a href="#" class="flex block p-2 pl-4 dropdown-item clickmenu {{ $scontextType->function }} " data-type="{{ $soption->function }}">
                          <i class="ri-check-line pr-3 ri-lg mt-1"></i
                          ><span>{{ $soption->name }}</span>
                        </a>
                      </div>
                       @endforeach
                      @endif
                    @endforeach
                  @endif
                </div>
              </div>
              <div class="relative flex items-center view">
                <button class="flex gap-x-2" onclick="toggleView()">
                  <i class="ri-gallery-view-2 ri-lg mt-1"></i>
                  <span>View</span>
                </button>
                <button class="dropdown-btn">
                  <i class="ri-arrow-drop-down-line ri-lg"></i>
                </button>
                <div
                  id="view-dropdown"
                  class="dropdown-option absolute top-full mt-2 z-10 bg-c-white border border-c-medium-gray rounded-lg shadow-md hidden md:w-44 xl:w-68"
                >
                @if(!empty($resizecontextTypes))
                  @foreach ($resizecontextTypes as $rcontextType)
                    @if(!empty($rcontextType->contextOptions))
                      @foreach ($rcontextType->contextOptions as $roption)

                        <div class="hover-bg-c-yellow rounded-t-lg">
                          <a
                            href="#"
                            class="flex items-center block p-2 pl-4 dropdown-item clickmenu {{ $rcontextType->function }} " data-type="{{ $roption->function }}"
                          >
                            <i class="ri-gallery-view-2 text-sm mt-1 w-1/4"></i>
                            <span>{{ $roption->name }}</span>
                          </a>
                        </div>
                        @endforeach
                      @endif
                    @endforeach
                  @endif

                  <div class="hover-bg-c-yellow">
                    <a
                      href="#"
                      class="flex items-center block p-2 pl-4 dropdown-item"
                      onclick="toggleView();"
                    >
                      <i class="ri-list-check ri-lg w-1/4"></i
                      ><span>List View</span>
                    </a>
                  </div>
                  <div class="hover-bg-c-yellow">
                    <a
                      href="#"
                      class="flex items-center block p-2 pl-4 dropdown-item"
                      onclick="togglePanel('detail');"
                    >
                      <i class="ri-profile-line ri-lg w-1/4"></i
                      ><span>Detail pane</span>
                    </a>
                  </div>
                  <div class="hover-bg-c-yellow rounded-b-lg">
                    <a
                      href="#"
                      class="flex items-center block p-2 pl-4 dropdown-item"
                      onclick="togglePanel('preview');"
                    >
                      <i class="ri-eye-line ri-lg w-1/4"></i>
                      <span>Preview pane</span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            
          </div>