@extends('layouts.backendsettings')
@section('title', 'Document-Permissions')
@section('content')

 <!-- main content -->
      <div class="flex-grow border h-100 main">
        <div class="flex flex-col w-full h-full content">
          <div class="px-2 lg:px-5 py-6">
            <div class="flex items-center gap-4">
              <i class="ri-settings-3-fill ri-xl"></i>
              <span class="text-lg text-c-black font-normal">User Management</span>
            </div>
          </div>

          <!-- top taskbar -->
          <div
            class="taskbar flex items-center justify-between px-3 sm:px-6 py-3"
          >
            <div class="w-full md:w-1/2">
              <div class="flex items-center gap-2">
                <span class="text-c-light-black font-normal flex-responsive -space-y-1">
                  <!-- <span>Admin</span> <span>&amp;</span><span> Users</span> -->
                  User Management
                </span>
                <i class="ri-arrow-right-line ri-lg" style="color: #4d4d4d"></i>
                <span class="font-semibold text-c-black">
                  Document Permission
                </span>
              </div>
            </div>

            <div class="flex-grow md:w-1/2">
              <div class="flex items-center justify-end">
                <div>
                  <button
                    class="flex items-center justify-center gap-2 bg-c-black text-c-yellow px-3 sm:px-4 py-1 sm:py-1.5 rounded-md"
                    onclick="showModal()"
                  >
                    <i class="ri-add-circle-fill"></i
                    ><span class="text-xs sm:text-sm">Add</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
            <div class="mt-3 flex items-center justify-end px-3 gap-2">
            <div class="flex items-center rounded overflow-hidden bg-c-white h-8">
                <input
                  type="text" id="searchterm"
                  class="pl-4 pt-2.5 pb-2.5 flex-shrink flex-grow border-none text-c-black outline-none"
                  placeholder="Search users, groups..."
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
          <div class="p-4 relative h-full flex flex-col">
            <div
              class="bg-white as-table-container border rounded-md"
            >
              <table class="table-auto w-full">
                <thead class="h-14">
                  <tr class="bg-c-dark-gray">
                    <th class="text-c-white font-medium text-left pl-3 text-base rounded-tl-md"></th>
                    <th
                      class="text-c-white font-medium text-left pl-3 pr-20"
                    >
                      Name
                    </th>
                    <th class="text-c-white font-medium text-left pl-3">
                      Information
                    </th>
                    <th class="text-c-white font-medium text-left pl-3">
                      Permission
                    </th>
                    <th
                      class="text-c-white font-medium text-left pl-3 rounded-tr-md"
                    >
                      Action
                    </th>
                  </tr>
                </thead>
                <tbody id="searchableTableBody">
                  
                </tbody>
              </table>
            </div>
            <div class="mt-auto flex justify-end pt-3 font-normal">
            <!--   Total 1 page &nbsp; <span class="text-c-yellow font-normal">(5 records)</span> -->
              {{ $permissions->links() }}
            </div>
          </div>
        </div>
      </div>

       <!-- add or edit modal -->
    <div
      id="modal"
      role="dialog"
      class="fixed hidden inset-0 flex items-center justify-center bg-black bg-opacity-50"
    >
      <div
        class="bg-white rounded-2xl overflow-hidden shadow-lg max-w-xl w-full modal-content"
      >
        <div
          class="sticky top-0 bg-white z-10 flex py-2 px-5 justify-between items-center border-b border-gray-3 text-c-black"
        >
          <div class="text-lg font-normal">Document Permission</div>
          <button
            type="button"
            id="closeModalButton"
            class="py-1.5 rounded-md"
            onclick="hideModal()"
          >
            <i class="ri-close-circle-fill text-black ri-lg"></i>
          </button>
        </div>
        <div class="p-5 overflow-y-auto scroll" style="max-height: calc(100vh - 8rem)">
          <form class="space-y-4 text-sm" action="{{ route('permission-create') }}" method="POST">
             @csrf
            <div class="flex flex-wrap w-full gap-y-4 items-center">
              <label for="title" class="title font-bold text-c-black"
                >Name: <span class="text-red-500">*</span></label
              >
              <div class="relative subcontent">
                <input
                  type="text"
                  required
                  name="name"
                  id="title"
                  class="w-full bg-c-lighten-gray border border-gray-300 text-gray-900 textsize rounded-xl pl-4 pr-20 p-2 placeholder-gray-400 focus:outline-none"
                  placeholder="Please enter a user name"
                />
                <div
                  class="absolute inset-y-0 right-0 flex items-center pr-2 border-l-2 border-gray-300"
                >
                  <div class="w-4 h-4 bg-c-yellow rounded-full ml-2"></div>
                  <i class="ri-arrow-drop-down-line ml-1 ri-lg"></i>
                </div>
              </div>
            </div>
            <div
              class="flex flex-wrap gap-y-4 items-start border-b border-gray-3 pb-4"
            >
              <div class="title font-bold text-c-black">Display:</div>
              <div class="subcontent ml-auto">
                <label
                  for="toggle-debug"
                  class="toggle-switch flex items-start cursor-pointer"
                >
                  <div class="relative">
                    <input type="checkbox" id="toggle-debug" class="sr-only" />
                    <div
                      class="block toggle-bg w-14 h-7 rounded-full border"
                    ></div>
                    <div
                      class="dot absolute left-0.5 top-0.5 bg-white w-6 h-6 rounded-full transition shadow-lg"
                    ></div>
                  </div>
                  <span class="pl-2 text-c-black mt-1 font-light"
                    >Display or not when setting group permissions</span
                  >
                </label>
              </div>
            </div>
            <div
              class="flex flex-wrap bg-c-light-pink text-c-black rounded-lg p-2 font-normal"
            >
              Tip: The System built in permission does not support modifying.
              You can create a new.
            </div>
            <div class="flex justify-center">
                  <button
                    type="button"
                    class="title-btn px-12 py-2 bg-c-yellow text-c-black rounded"
                  >
                    File Manager
                  </button>
                </div>
            <div
              class="flex flex-wrap gap-y-2 items-start border-t border-gray-3 pt-4"
            >
              <div class="title font-bold text-c-black">
                Description:<span class="text-red-500">*</span>
              </div>
              <div
                class="flex flex-col justify-center gap-4 ml-auto subcontent"
              >
                <div class="flex items-start justify-start gap-1 sm:gap-3">
                  <input
                    type="checkbox"
                    class="c-checkbox mt-1"
                    name="permissions[]"
                    value="view"
                  />
                  <span class="text-c-black mt-0.5 font-normal"
                    >Document list: File Manager view:</span
                  >
                </div>
                <div class="flex items-start justify-start gap-1 sm:gap-3">
                  <input
                    type="checkbox"
                    class="c-checkbox mt-1"
                    name="permissions[]"
                    value="preview"
                  />
                  <span class="text-c-black mt-0.5 font-normal"
                    >Preview: File open preview: Preview</span
                  >
                </div>
                <div class="flex items-start justify-start gap-1 sm:gap-3">
                  <input
                    type="checkbox"
                    class="c-checkbox mt-1"
                    name="permissions[]"
                    value="download"
                  />
                  <span class="text-c-black mt-0.5 font-normal"
                    >Download / Copy Download / Copy / Preview / Print:Download
                  </span>
                </div>
                <div class="flex items-start justify-start gap-1 sm:gap-3">
                  <input
                    type="checkbox"
                    class="c-checkbox mt-1"
                    name="permissions[]"
                    value="upload"
                  />
                  <span class="text-c-black mt-0.5 font-normal"
                    >Upload: Upload / Remote download
                  </span>
                </div>
                <div class="flex items-start justify-start gap-1 sm:gap-3">
                  <input
                    type="checkbox"
                    class="c-checkbox mt-1"
                    name="permissions[]"
                    value="edit"
                  />
                  <span class="text-c-black mt-0.5 font-normal"
                    >Edit: New File 9Folder) / Rename / Paste / Edit / Set Notes
                    / Copy / Unzip, Compress:Edit
                  </span>
                </div>
                <div class="flex items-start justify-start gap-1 sm:gap-3">
                  <input
                    type="checkbox"
                    class="c-checkbox mt-1"
                    name="permissions[]"
                    value="delete"
                  />
                  <span class="text-c-black mt-0.5 font-normal"
                    >Delete: Cut / Copy / Move
                  </span>
                </div>
                <div class="flex items-start justify-start gap-1 sm:gap-3">
                  <input
                    type="checkbox"
                    class="c-checkbox mt-1"
                    name="permissions[]"
                    value="share"
                  />
                  <span class="text-c-black mt-0.5 font-normal"
                    >Share: Link sharing / Internal sharing
                  </span>
                </div>
                <div class="flex items-start justify-start gap-1 sm:gap-3">
                  <input
                    type="checkbox"
                    class="c-checkbox mt-1"
                    name="permissions[]"
                    value="comments"
                  />
                  <span class="text-c-black mt-0.5 font-normal"
                    >Comments: View documents comments; add / delete your own
                    comments(editing permission required)
                  </span>
                </div>
                <div class="flex items-start justify-start gap-1 sm:gap-3">
                  <input
                    type="checkbox"
                    class="c-checkbox mt-1"
                    name="permissions[]"
                    value=dynamic
                  />
                  <span class="text-c-black mt-0.5 font-normal"
                    >Dynamics: Document dynamic viewing, subscription dynamic
                  </span>
                </div>
                <div class="flex items-start justify-start gap-1 sm:gap-3">
                  <input
                    type="checkbox"
                    class="c-checkbox mt-1"
                    name="permissions[]"
                    value="admin"
                  />
                  <span class="text-c-black mt-0.5 font-normal"
                    >Administration: Set member permission / Comment / History
                    version management
                  </span>
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
                    User Management
                  </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
                  <div class="md:col-span-2">
                    <h3 class="block font-bold text-c-black"
                      >User & Groups:</h3
                    >
                  </div>
                  <div class="md:col-span-9 grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="user-create">
                    <p class="text-c-black">Create</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="user-edit">
                    <p class="text-c-black">Edit</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="user-view">
                    <p class="text-c-black">View/Preview</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="user-delete">
                    <p class="text-c-black">Delete</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="user-mass-upload">
                    <p class="text-c-black">Bulk-Upload</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="user-rollback">
                    <p class="text-c-black">Rollback</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="user-permanent-delete">
                    <p class="text-c-black">Hard Delete</p>
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
                    Role Management
                  </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
                  <div class="md:col-span-2">
                    <h3 class="block font-bold text-c-black"
                      >Roles:</h3
                    >
                  </div>
                  <div class="md:col-span-9 grid grid-cols-1 md:grid-cols-3 gap-3">
                     <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="role-create">
                    <p class="text-c-black">Create</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="role-edit">
                    <p class="text-c-black">Edit</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="role-view">
                    <p class="text-c-black">View/Preview</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="role-delete">
                    <p class="text-c-black">Delete</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="role-mass-upload">
                    <p class="text-c-black">Bulk-Upload</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="role-rollback">
                    <p class="text-c-black">Rollback</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="role-permanent-delete">
                    <p class="text-c-black">Hard Delete</p>
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
                    Groups Management
                  </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
                  <div class="md:col-span-2">
                    <h3 class="block font-bold text-c-black"
                      >Groups:</h3
                    >
                  </div>
                  <div class="md:col-span-9 grid grid-cols-1 md:grid-cols-3 gap-3">
                     <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="group-create">
                    <p class="text-c-black">Create</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="group-edit">
                    <p class="text-c-black">Edit</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="group-view">
                    <p class="text-c-black">View/Preview</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="group-delete">
                    <p class="text-c-black">Delete</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="group-mass-upload">
                    <p class="text-c-black">Bulk-Upload</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="group-rollback">
                    <p class="text-c-black">Rollback</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="group-permanent-delete">
                    <p class="text-c-black">Hard Delete</p>
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
                    Backend Management
                  </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
                  <div class="md:col-span-2">
                    <h3 class="block font-bold text-c-black"
                      >Backend:</h3
                    >
                  </div>
                  <div class="md:col-span-9 grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="notice">
                    <p class="text-c-black">Notice</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="storage">
                    <p class="text-c-black">Storage</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="backups">
                    <p class="text-c-black">Backup</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="logs">
                    <p class="text-c-black">Logs</p>
                  </div>
                    
                  </div>
                </div>
              </div>
            <hr class="border-gray-3" />
            <div class="subcontent ml-auto">
              <div class="flex items-start justify-start gap-1 sm:gap-3">
                <input
                  type="checkbox"
                  class="c-checkbox mt-1"
                  name="options"
                  value="admin" id="checkall"
                />
                <span class="text-c-black mt-0.5 font-normal">Select All / Cancel </span>
              </div>
            </div>

            <div class="flex justify-end mt-3">
              <button
                class="bg-c-black hover-bg-c-black text-white rounded-full w-32 py-2 text-sm"
              >
                Save
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

<!-- Edit modal -->
        <div id="permission-edit-div">
            
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
              <h1 class="text-lg font-medium">Delete Permission</h1>
            </div>
            <hr text-md>
            <div class="mt-6 flex items-center justify-center">
              <h1 class="text-md font-medium text-c-black">
                Are you sure you want to delete the Permission?
              </h1>
            </div>
            <div class="flex items-center justify-center gap-3 mt-9">
              <a href="#" id="deletePermission">
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
                const listroute = @json(route('permission-list'));
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

 $('#checkall').change(function (e) {
  
    if($(this).prop("checked")) {
            $(".d-checkbox,.c-checkbox").prop("checked", true);
        } else {
            $(".d-checkbox,.c-checkbox").prop("checked", false);
        }     

  });


 @if (Session::has('success'))
   toastr.success("Permission Added successfully");
 @endif
 @if (Session::has('success-update'))
   toastr.success("Permission Updated successfully");
 @endif
 @if (Session::has('delete'))
   toastr.success("Permission delete successfully");
 @endif

});
</script>
@endsection