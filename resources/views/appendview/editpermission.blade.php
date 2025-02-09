
<!--New --->
     <!--Edit modal -->
    <div
      id="modal"
      role="dialog"
      class="permission-edit-modal fixed hidden inset-0 flex items-center justify-center bg-black bg-opacity-50"
    >
      <div
        class="bg-white rounded-2xl overflow-hidden shadow-lg max-w-xl w-full modal-content"
      >
        <div
          class="sticky top-0 bg-white z-10 flex py-2 px-5 justify-between items-center border-b border-gray-3 text-c-black"
        >
          <div class="text-lg font-normal">Edit Document Permission</div>
          <button
            type="button" id="closeModalButton" class="permission-edit-close py-1.5 rounded-md">
            <i class="ri-close-circle-fill text-black ri-lg"></i>
          </button>
        </div>
        <div class="p-5 overflow-y-auto scroll" style="max-height: calc(100vh - 8rem)">
          <form class="space-y-4 text-sm" action="{{ route('permission-update',['id' => $permission->id]) }}" method="POST">
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
                  value="{{ $permission->name }}"
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
                    value="view"  @php echo in_array('view', $permission->permissions) ? 'checked' : ''  @endphp
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
                    value="preview"  @php echo in_array('preview', $permission->permissions) ? 'checked' : ''  @endphp
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
                    value="download"  @php echo in_array('download', $permission->permissions) ? 'checked' : ''  @endphp
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
                    value="upload"  @php echo in_array('upload', $permission->permissions) ? 'checked' : ''  @endphp
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
                    value="edit"  @php echo in_array('edit', $permission->permissions) ? 'checked' : ''  @endphp
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
                    value="delete"  @php echo in_array('delete', $permission->permissions) ? 'checked' : ''  @endphp
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
                    value="share"  @php echo in_array('share', $permission->permissions) ? 'checked' : ''  @endphp
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
                    value="comments"  @php echo in_array('comments', $permission->permissions) ? 'checked' : ''  @endphp
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
                    value=dynamic  @php echo in_array('dynamic', $permission->permissions) ? 'checked' : ''  @endphp
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
                    value="admin"  @php echo in_array('admin', $permission->permissions) ? 'checked' : ''  @endphp
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
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="user-create"  @php echo in_array('user-create', $permission->permissions) ? 'checked' : ''  @endphp>
                    <p class="text-c-black">Create</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="user-edit"  @php echo in_array('user-edit', $permission->permissions) ? 'checked' : ''  @endphp>
                    <p class="text-c-black">Edit</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="user-view"  @php echo in_array('user-view', $permission->permissions) ? 'checked' : ''  @endphp>
                    <p class="text-c-black">View/Preview</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="user-delete"  @php echo in_array('user-delete', $permission->permissions) ? 'checked' : ''  @endphp>
                    <p class="text-c-black">Delete</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="user-mass-upload"  @php echo in_array('user-mass-upload', $permission->permissions) ? 'checked' : ''  @endphp>
                    <p class="text-c-black">Bulk-Upload</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="user-rollback"  @php echo in_array('user-rollback', $permission->permissions) ? 'checked' : ''  @endphp>
                    <p class="text-c-black">Rollback</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="user-permanent-delete"  @php echo in_array('user-permanent-delete', $permission->permissions) ? 'checked' : ''  @endphp>
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
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="role-create"  @php echo in_array('role-create', $permission->permissions) ? 'checked' : ''  @endphp>
                    <p class="text-c-black">Create</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="role-edit"  @php echo in_array('role-edit', $permission->permissions) ? 'checked' : ''  @endphp>
                    <p class="text-c-black">Edit</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="role-view"  @php echo in_array('role-view', $permission->permissions) ? 'checked' : ''  @endphp>
                    <p class="text-c-black">View/Preview</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="role-delete"  @php echo in_array('role-delete', $permission->permissions) ? 'checked' : ''  @endphp>
                    <p class="text-c-black">Delete</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="role-mass-upload"  @php echo in_array('role-mass-upload', $permission->permissions) ? 'checked' : ''  @endphp>
                    <p class="text-c-black">Bulk-Upload</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="role-rollback"  @php echo in_array('role-rollback', $permission->permissions) ? 'checked' : ''  @endphp>
                    <p class="text-c-black">Rollback</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="role-permanent-delete"  @php echo in_array('role-permanent-delete', $permission->permissions) ? 'checked' : ''  @endphp>
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
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="group-create"  
                    @php echo in_array('group-create', $permission->permissions) ? 'checked' : ''  @endphp>
                    <p class="text-c-black">Create</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="group-edit"  @php echo in_array('group-edit', $permission->permissions) ? 'checked' : ''  @endphp>
                    <p class="text-c-black">Edit</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="group-view"  @php echo in_array('group-view', $permission->permissions) ? 'checked' : ''  @endphp>
                    <p class="text-c-black">View/Preview</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="group-delete"  
                    @php echo in_array('group-delete', $permission->permissions) ? 'checked' : ''  @endphp>
                    <p class="text-c-black">Delete</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="group-mass-upload"  @php echo in_array('group-mass-upload', $permission->permissions) ? 'checked' : ''  @endphp>
                    <p class="text-c-black">Bulk-Upload</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="group-rollback"
                     @php echo in_array('group-rollback', $permission->permissions) ? 'checked' : ''  @endphp>
                    <p class="text-c-black">Rollback</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="group-permanent-delete" 
                     @php echo in_array('group-permanent-delete', $permission->permissions) ? 'checked' : ''  @endphp>
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
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="notice"  @php echo in_array('notice', $permission->permissions) ? 'checked' : ''  @endphp>
                    <p class="text-c-black">Notice</p>
                  </div>
                    <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="storage"  @php echo in_array('storage', $permission->permissions) ? 'checked' : ''  @endphp>
                    <p class="text-c-black">Storage</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="backups"  @php echo in_array('backups', $permission->permissions) ? 'checked' : ''  @endphp>
                    <p class="text-c-black">Backup</p>
                  </div>
                   <div class="checkbox-container rounded w-full md:w-32 flex items-center justify-center  gap-3 h-9">
                    <input type="checkbox" class="d-checkbox" name="permissions[]" value="logs"  @php echo in_array('logs', $permission->permissions) ? 'checked' : ''  @endphp>
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
                  name=""
                  value="admin" id="editcheckall"
                />
                <span class="text-c-black mt-0.5 font-normal">Select All / Cancel </span>
              </div>
            </div>

            <div class="flex justify-end mt-3">
              <button
                class="bg-c-black hover-bg-c-black text-white rounded-full w-32 py-2 text-sm"
              >
                Update
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
<!--End New-->

<script>
$(document).ready(function(){  
  $('.permission-edit-close').on('click', function (e) {
          $('.permission-edit-modal').hide();
    });

  $('#editcheckall').change(function (e) {
  
    if($(this).prop("checked")) {
            $(".d-checkbox,.c-checkbox").prop("checked", true);
        } else {
            $(".d-checkbox,.c-checkbox").prop("checked", false);
        }     

  });
});
</script>