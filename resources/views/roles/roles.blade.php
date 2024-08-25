@extends('layouts.backendsettings')
@section('title', 'Roles')
@section('content')
           <!-- Main content -->
        <div class="flex-grow border h-100 main">
          <div class="flex w-full h-full flex-col content">
            <div class=" px-2 lg:px-5 py-6">
               <div class="flex items-center gap-4">
                <i class="ri-settings-3-fill ri-xl"></i>
                <span class="text-lg text-c-black">User Management</span>
              </div>
            </div>

             <!-- top taskbar -->
            <div class=" taskbar bg-no-repeat bg-cover bg-center flex items-center justify-between px-3 sm:px-6 py-3">
               <div class="flex items-center gap-4 w-full md:w-1/2">
                        <div class="flex gap-1 sm:gap-2 items-center">
                            <span class="text-c-light-black">User Management</span> <i class="ri-arrow-right-line ri-lg" style="color: #4D4D4D;"></i><span
                                class="font-semibold text-c-black">Role</span>
                        </div>
               </div>
               @if(!empty($filteredPermissions['roleManagement']) && in_array('role-create', $filteredPermissions['roleManagement']))               
               <div class="flex-grow md:w-1/2">
                  <div class="flex items-center justify-end gap-2 md:gap-6">
                    <div>
                        <button type="button" class=" flex items-center justify-center gap-2 bg-c-black text-c-yellow px-4 py-1.5 rounded-md openAddModalButton">
                          <i class="ri-add-circle-fill"></i><span class="text-sm">Add</span>
                        </button>
                    </div>
                  </div>
               </div>
               @endif
               
            </div>
             <div class="mt-3 flex items-center justify-end px-4 gap-2">
            <div
                class="flex items-center rounded overflow-hidden bg-c-white h-8"
              >
                <input id="searchterm"
                  type="text"
                  class="pl-4 pt-2.5 pb-2.5 flex-shrink flex-grow border-none text-c-black outline-none"
                  placeholder="Search roles"
                />
                <div class="pt-3 pb-3 pr-4 flex items-center justify-center">
                 <i class="ri-search-line"></i>
                </div>
              </div>
              <button
                  class="text-c-light-black bg-c-gray-3 rounded px-6 py-1 mr-1" id='search'
                >
                  Search
                </button>
          </div>

            <!-- info table -->
             <div class="p-4 relative h-full flex flex-col scroll overflow-y-scroll">
            <div class="bg-white cs-table-container border border-c-gray rounded-md">
              <table class="table-auto w-full">
               <thead class="h-14">
                    <tr class="bg-c-dark-gray">
                      <th class="text-c-white font-medium text-left pl-3 text-base rounded-tl-md"></th>
                      <th class="text-c-white font-medium text-left pl-3">
                        Name
                      </th>
                      <th class="text-c-white text-left font-medium pl-3">
                        Information
                      </th>
                      <th class="text-c-white text-left font-medium pl-3">
                        Description
                      </th>
                      <th class="text-c-white text-left font-medium pl-3">
                        Modification
                      </th>
                      <th class="rounded-tr-md text-c-white font-medium text-left pl-3">
                        Action
                      </th>
                    </tr>
                  </thead>
                 <tbody id="searchableTableBody">
                    
                  </tbody>
              </table>
            </div>
            <div class="mt-auto flex justify-end">
              <!-- Total 1 page &nbsp; <span class="text-c-yellow">(5 records)</span> -->
              {{ $roles->links() }}
            </div>
          </div>
          </div>
        </div>

         <!--Add Modal -->
      <div
        id="add-modal"
        role="dialog"
        class="fixed hidden inset-0 flex items-center justify-center bg-black bg-opacity-50 add"
      >
        <div class="addModal bg-white mt-12 rounded-xl shadow-lg w-full mx-auto">
          <div class="flex justify-between items-center p-4 border-b">
            <h1 class="text-lg font-medium text-c-black" id="staticBackdropLabel">Add Role</h1>
            <i
              class="ri-close-circle-fill ri-lg cursor-pointer"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></i>
          </div>
          <form autocomplete="on" action="{{ route('role-create') }}" method="POST">
            @csrf
          <div
            class="p-4 overflow-y-auto scroll"
            style="max-height: calc(100vh - 8rem)"
          >
              <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="md:col-span-2">
                  <label for="name" class="block font-bold text-c-black"
                    >Name:<span class="text-red-500">*</span></label
                  >
                </div>
                <div class="md:col-span-10 md:pr-28">
                  <input
                    id="name"
                    name = "name"
                    class="w-full p-2 bg-c-lighten-gray border border-gray rounded-xl outline-none pl-5 "
                    type="text"
                    placeholder="Please enter an username"
                    autocomplete="name"  required
                  />
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
                <div class="md:col-span-2">
                  <h3 class="block font-bold text-c-black">Display:</h3>
                </div>
                <div class="md:col-span-10 flex items-center gap-4">
                  <label for="toggle" class="toggle-switch flex items-center cursor-pointer">
                      <div class="relative">
                                                <input type="checkbox" id="toggle" class="sr-only">
                                                <div class="block toggle-bg w-14 h-7 rounded-full border"></div>
                                                <div
                                                    class="dot absolute left-0.5 top-0.5 bg-white w-6 h-6 rounded-full transition shadow-lg">
                                                </div>
                                            </div>
                                        </label>
                  <p class="text-sm text-c-black font-light">
                    Whether to display when setting user role
                  </p>
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
                <div class="md:col-span-2 flex items-center">
                  <label for="filesize" class="block font-bold text-c-black"
                    >File size:<span class="text-red-500">*</span></label
                  >
                </div>
                <div class="md:col-span-10 flex items-center gap-2 md:pr-2">
                  <div class="relative w-full">
                    <input
                      id="filesize"
                      name="upload_limit"
                      class="w-full p-2 bg-c-lighten-gray border border-gray rounded-xl outline-none pl-4"
                      type="number"
                      placeholder="Please upload file size" required
                    />
                    <div
                      class="absolute inset-y-0 right-0 flex items-center bg-c-gray-4 border border-gray w-10 rounded-r-xl pl-2"
                    >
                      <p class="font-normal">GB</p>
                    </div>
                  </div>
                  <p class="text-sm text-c-black font-light">(GB) 0 is unlimited</p>
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
                <div class="md:col-span-2 flex items-start">
                  <label for="roleDescription" class="block font-bold text-c-black"
                    >Role description:<span class="text-red-500">*</span></label
                  >
                </div>
                <div class="md:col-span-10 md:pr-28">
                  <textarea
                    id="roleDescription"
                     name="description"
                    class="w-full p-2 bg-c-lighten-gray border border-gray rounded-xl"
                    rows="4" required
                  ></textarea>
                </div>
              </div>
              <hr class="my-4" />
              <div>
                <div class="flex justify-center">
                  <button
                    type="button"
                    class="title-btn px-8 py-2 bg-c-yellow text-c-black rounded"
                  >
                    Permissions
                  </button>
                </div>
                <div class="grid grid-cols-1 gap-4 mt-10">
                  <div class="md:col-span-2 flex items-start">
                    <h3 class="block font-bold text-c-black">Assign Permission:</h3>
                  </div>
                      <select id="roleID" name="permissionID" class="p-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                         @foreach($permissions as $permission)
                         <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                         @endforeach
                      </select>
                    
                </div>
              </div>
              <hr class="my-4" />
              <div class="flex justify-end p-4">
            <button class="bg-c-black text-white px-12 py-2 rounded-full">
              Save
            </button>
          </div>
          </div>       
          </form>
        </div>
      </div>

      <!-- Edit Modal -->
      <div
        id="edit-modal"
        role="dialog"
        class="fixed hidden inset-0 flex items-center justify-center bg-black bg-opacity-50 edit"
      >
        <div class="editModal bg-white mt-12 rounded-xl shadow-lg w-full mx-auto">
          <div class="flex justify-between items-center p-4 border-b">
            <h1 class="text-lg font-medium text-c-black" id="staticBackdropLabel">Edit Role</h1>
            <i
              class="ri-close-circle-fill ri-lg cursor-pointer"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></i>
          </div>
          <form autocomplete="on">
          <div
            class="p-4 overflow-y-auto scroll"
            style="max-height: calc(100vh - 8rem)"
          >
              <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="md:col-span-2 flex items-center">
                  <label for="name" class="block font-bold text-c-black"
                    >Name:<span class="text-red-500">*</span></label
                  >
                </div>
                <div class="md:col-span-10 md:pr-28">
                  <input
                    id="name"
                    class="w-full p-2 bg-c-lighten-gray border border-gray rounded-xl outline-none pl-5 "
                    type="text"
                    placeholder="Please enter an username"
                    autocomplete="name"
                  />
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
                <div class="md:col-span-2 flex items-center">
                  <h3 class="block font-bold text-c-black">Display:</h3>
                </div>
                <div class="md:col-span-10 flex items-center gap-4">
                     <label for="toggle-2" class="toggle-switch flex items-center cursor-pointer">
                                            <div class="relative">
                                                <input type="checkbox" id="toggle-2" class="sr-only">
                                                <div class="block toggle-bg w-14 h-7 rounded-full border border-gray"></div>
                                                <div
                                                    class="dot absolute left-0.5 top-0.5 bg-white w-6 h-6 rounded-full transition shadow-lg">
                                                </div>
                                            </div>
                                        </label>
                  <p class="text-sm font-light text-c-black">
                    Whether to display when setting user role
                  </p>
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
                <div class="md:col-span-2 flex items-center">
                  <label for="filesize" class="block font-bold text-c-black"
                    >File size:<span class="text-red-500">*</span></label
                  >
                </div>
                <div class="md:col-span-10 flex items-center gap-2 md:pr-2">
                  <div class="relative w-full">
                    <input
                      id="filesize"
                      class="w-full p-2 bg-c-lighten-gray border border-gray rounded-xl outline-none pl-5"
                      type="text"
                      placeholder="Please upload file size"
                    />
                    <div
                      class="absolute inset-y-0 right-0 flex items-center  bg-c-gray-4 border border-gray w-10 rounded-r-xl pl-2"
                    >
                      <p class="font-normal">GB</p>
                    </div>
                  </div>
                  <p class="text-sm text-c-black font-light">(GB) 0 is unlimited</p>
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
                <div class="md:col-span-2 flex items-start">
                  <label for="roleDescription" class="block font-bold text-c-black"
                    >Role description:<span class="text-red-500">*</span></label
                  >
                </div>
                <div class="md:col-span-10 md:pr-28">
                  <textarea
                    id="roleDescription"
                    class="w-full p-2 bg-c-lighten-gray border border-gray rounded-xl"
                    rows="4"
                  ></textarea>
                </div>
              </div>
              <hr class="my-4" />
              <div>
                <div class="flex justify-center">
                  <button
                    type="button"
                    class="title-btn px-8 py-2 bg-c-yellow text-c-black rounded"
                  >
                    Documentation
                  </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-10">
                  <div class="md:col-span-2 flex items-start">
                    <h3 class="block font-bold text-c-black">File manage:</h3>
                  </div>
                  <div
                    class="md:col-span-9 grid grid-cols-1 md:grid-cols-4 gap-3"
                  >
                  <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="preview">
                    <p class="text-c-black">Preview</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="search">
                    <p class="text-c-black">Search</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="download">
                    <p class="text-c-black">Download</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-40 flex items-center justify-center gap-3  h-9">
                    <input type="checkbox" class="d-checkbox" name="newfile">
                    <p class="text-c-black">New file/folder</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="preview">
                    <p class="text-c-black">Preview</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="search">
                    <p class="text-c-black">Search</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="download">
                    <p class="text-c-black">Download</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-40 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="newfile">
                    <p class="text-c-black">New file/folder</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="preview">
                    <p class="text-c-black">Preview</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="search">
                    <p class="text-c-black">Search</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="download">
                    <p class="text-c-black">Download</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-40 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="newfile">
                    <p class="text-c-black">New file/folder</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="preview">
                    <p class="text-c-black">Preview</p>
                  </div>
                  </div>
                </div>
              </div>
              <hr class="my-4" />
              <div>
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
                  <div class="md:col-span-2 flex items-center">
                    <h3 class="block font-bold text-c-black">User:</label>
                  </div>
                  <div
                    class="md:col-span-9 grid grid-cols-1 md:grid-cols-4 gap-3"
                  >
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="preview">
                    <p class="text-c-black">Preview</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="search">
                    <p class="text-c-black">Search</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="download">
                    <p class="text-c-black">Download</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-40 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="newfile">
                    <p class="text-c-black">New file/folder</p>
                  </div>
                  </div>
                </div>
              </div>
              <hr class="my-4" />
              <div>
                <div class="flex justify-center">
                  <button
                    type="button"
                    class="title-btn px-12 py-2 bg-c-yellow text-c-black rounded"
                  >
                    Backstage
                  </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-10">
                  <div class="md:col-span-2">
                    <h3 class="block font-bold text-c-black"
                      >Backstage:</h3
                    >
                  </div>
                  <div
                    class="md:col-span-9 grid grid-cols-1 md:grid-cols-4 gap-3"
                  >
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="preview">
                    <p class="text-c-black">Preview</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="search">
                    <p class="text-c-black">Search</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="download">
                    <p class="text-c-black">Download</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-40 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="newfile">
                    <p class="text-c-black">New file/folder</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="preview">
                    <p class="text-c-black">Preview</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="search">
                    <p class="text-c-black">Search</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="download">
                    <p class="text-c-black">Download</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-40 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="newfile">
                    <p class="text-c-black">New file/folder</p>
                  </div>
                  </div>
                </div>
              </div>
              <hr class="my-4" />
              <div>
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
                  <div class="md:col-span-2 flex items-center">
                    <h3 class="block font-bold text-c-black">Role:</h3>
                  </div>
                  <div
                    class="md:col-span-9 grid grid-cols-1 md:grid-cols-4 gap-3"
                  >
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="preview">
                    <p class="text-c-black">Preview</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="search">
                    <p class="text-c-black">Search</p>
                  </div>
                  </div>
                </div>
              </div>
              <hr class="my-4" />
              <div>
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
                  <div class="md:col-span-2 flex items-center">
                    <h3 class="block font-bold text-c-black">Job:</h3>
                  </div>
                  <div
                    class="md:col-span-9 grid grid-cols-1 md:grid-cols-4 gap-3"
                  >
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="preview">
                    <p class="text-c-black">Preview</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="search">
                    <p class="text-c-black">Search</p>
                  </div>
                  </div>
                </div>
              </div>
              <hr class="my-4" />
              <div>
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
                  <div class="md:col-span-2">
                    <h3 class="block font-bold text-c-black"
                      >User & Groups:</h3
                    >
                  </div>
                  <div
                    class="md:col-span-9 grid grid-cols-1 md:grid-cols-4 gap-3"
                  >
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="preview">
                    <p class="text-c-black">Preview</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="search">
                    <p class="text-c-black">Search</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="download">
                    <p class="text-c-black">Download</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-40 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="newfile">
                    <p class="text-c-black">New file/folder</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="preview">
                    <p class="text-c-black">Preview</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="search">
                    <p class="text-c-black">Search</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="download">
                    <p class="text-c-black">Download</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-40 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="newfile">
                    <p class="text-c-black">New file/folder</p>
                  </div>
                  </div>
                </div>
              </div>
              <hr class="my-4" />
              <div>
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
                  <div class="md:col-span-2 flex items-center">
                    <h3 class="block font-bold text-c-black"
                      >Document Permission:</h3
                    >
                  </div>
                  <div
                    class="md:col-span-9 grid grid-cols-1 md:grid-cols-4 gap-3"
                  >
                     <div class="checkbox-container rounded w-full md:w-32 h-9 flex items-center justify-center gap-3">
                    <input type="checkbox" class="d-checkbox" name="preview">
                    <p class="text-c-black">Preview</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 h-9 flex items-center justify-center gap-3">
                    <input type="checkbox" class="d-checkbox" name="search">
                    <p class="text-c-black">Search</p>
                  </div>
                  </div>
                </div>
              </div>
              <hr class="my-4" />
              <div>
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
                  <div class="md:col-span-2 flex items-center">
                    <h3 class="block font-bold text-c-black"
                      >Plugin Center:</h3
                    >
                  </div>
                  <div
                    class="md:col-span-9 grid grid-cols-1 md:grid-cols-4 gap-3"
                  >
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="preview">
                    <p class="text-c-black">Preview</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="search">
                    <p class="text-c-black">Search</p>
                  </div>
                  </div>
                </div>
              </div>
              <hr class="my-4" />
              <div>
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
                  <div class="md:col-span-2 flex items-center">
                    <h3 class="block font-bold text-c-black"
                      >Storage/file:</h3
                    >
                  </div>
                  <div
                    class="md:col-span-9 grid grid-cols-1 md:grid-cols-4 gap-3"
                  >
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="preview">
                    <p class="text-c-black">Preview</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="search">
                    <p class="text-c-black">Search</p>
                  </div>
                  </div>
                </div>
              </div>
              <hr class="my-4" />
              <div>
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
                  <div class="md:col-span-2 flex items-center">
                    <h3 class="block font-bold text-c-black"
                      >Scheduled Tasks:</h3
                    >
                  </div>
                  <div
                    class="md:col-span-9 grid grid-cols-1 md:grid-cols-4 gap-3"
                  >
                   <div class="checkbox-container rounded w-full md:w-32 h-9 flex items-center justify-center gap-3">
                    <input type="checkbox" class="d-checkbox" name="preview">
                    <p class="text-c-black">Preview</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 h-9 flex items-center justify-center gap-3">
                    <input type="checkbox" class="d-checkbox" name="search">
                    <p class="text-c-black">Search</p>
                  </div>
                  </div>
                </div>
              </div>
              <hr class="my-4" />
              <div>
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
                  <div class="md:col-span-2"></div>
                  <div
                    class="md:col-span-9 grid grid-cols-1 md:grid-cols-4 gap-3"
                  >
                   <div class="checkbox-container rounded w-full md:w-44 flex items-center justify-center gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="selectall">
                    <p>Select All / Cancel</p>
                  </div>
                  </div>
                </div>
              </div>
              <div class="flex justify-end p-4">
            <button class="bg-c-black text-white px-12 py-2 rounded-full">
              Save
            </button>
          </div>
          </div>       
          </form>
        </div>
      </div>

<!-- Edit modal -->
        <div id="role-edit-div">
            
        </div>
<!-- End Edit modal -->

<!-- Delete Button Modal -->
    <div
      id="delete-modal"
      tabindex="-1"
      class="fixed hidden inset-0 flex items-center justify-center bg-black bg-opacity-50"
    >
      <div class="delete-modal relative">
        <div class="relative">
          <div class="p-4 md:p-5 text-center">
            <div class="delete-header flex items-center gap-4 mb-1 py-1">
              <i class="ri-delete-bin-6-line ri-xl text-c-yellow"></i>
              <h1 class="text-lg font-medium">Delete File</h1>
            </div>
            <hr text-md>
            <div class="mt-6 flex items-center justify-center">
              <h1 class="text-md font-medium text-c-black">
                Are you sure you want to delete the Role? User related to this role will get Deleted !!
              </h1>
            </div>
            <div class="flex items-center justify-center gap-3 mt-9">
              <a href="#" id="deleteRole">
              <button id="okdelete"
              class="bg-c-black text-white rounded-full px-12 sm:px-14 py-2"
                type="submit"
              >
                OK
              </button>
            </a>
              <input type="hidden" name="id" id="delete-id" value="">
              <button
                class="bg-white text-c-yellow px-9 sm:px-12 py-2 rounded-full border border-c-yellow"
                onclick="hidedeleteModal()"
              >
                Cancel
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

@endsection

@section('scripts')
<script>

     //AddModal Open Functionality
      const openAddModalButton = document.querySelectorAll(".openAddModalButton");
      const addModal = document.getElementById("add-modal");

      openAddModalButton.forEach((e) => {
        e.addEventListener("click", () => {
          addModal.classList.remove("hidden");
        });
      });

      window.addEventListener("click", (event) => {
        if (event.target == addModal) {
          addModal.classList.add("hidden");
        }
      });

        // Script to toggle modal visibility
      document
        .querySelectorAll('[data-bs-toggle="modal"]')
        .forEach((button) => {
          button.addEventListener("click", () => {
            document
              .querySelector(button.getAttribute("data-bs-target"))
              .classList.remove("hidden");
          });
        });

      document
        .querySelectorAll('[data-bs-dismiss="modal"]')
        .forEach((button) => {
          button.addEventListener("click", () => {
            button.closest(".fixed").classList.add("hidden");
          });
        });

       //EditModal Open Functionality
      const openEditModalButton = document.querySelectorAll(".openEditModalButton");
      const editModal = document.getElementById("edit-modal");

      openEditModalButton.forEach((e) => {
        e.addEventListener("click", () => {
          editModal.classList.remove("hidden");
        });
      });

      window.addEventListener("click", (event) => {
        if (event.target == editModal) {
          editModal.classList.add("hidden");
        }
      });


      // Script to toggle modal visibility
      document
        .querySelectorAll('[data-bs-toggle="modal"]')
        .forEach((button) => {
          button.addEventListener("click", () => {
            document
              .querySelector(button.getAttribute("data-bs-target"))
              .classList.remove("hidden");
          });
        });

      document
        .querySelectorAll('[data-bs-dismiss="modal"]')
        .forEach((button) => {
          button.addEventListener("click", () => {
            button.closest(".fixed").classList.add("hidden");
          });
        });
 // DeletetModal Open Functionality
      const deleteModal = document.getElementById('delete-modal');

        function showdeleteModal(){
            deleteModal.classList.remove('hidden');
        }
        function hidedeleteModal(){
            deleteModal.classList.add('hidden');
        }

 $(document).ready(function(){     
 // Initial population of the table
    populateTable();
function populateTable(term='') {
                const searchTerm = term;
                const attr = '{{ request()->get('page') }}';
                const listroute = @json(route('role-list'));
                $.ajax({
                            url: listroute,
                            method: 'GET',
                            data: { page:attr,searchTerm:searchTerm },
                            success: function (response) {
                                // Update the app list container with the updated list
                                $('#searchableTableBody').html(response);
                            },
                            error: function (xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });

 }


  $('.btn-close').on('click', function (e) {
    $('.alert').hide();                          
    });

  $("#searchterm").keyup(function(){
    var term = $('#searchterm').val();
     populateTable(term);
  });
  $('#okdelete').on('click', function (e) {
     toastr.success("Roles Deleted");                          
    });

   @if (Session::has('success'))
   toastr.success("Role Added successfully");
 @endif
 @if (Session::has('success-update'))
   toastr.success("Role Updated successfully");
 @endif

});
</script>

@endsection
