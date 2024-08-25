@extends('layouts.backendsettings')
@section('title', 'Users & Group')
@section('content')

    <div class="flex-grow h-100 main">
        <div class="flex w-full h-full flex-col content">
            <div class="px-2 lg:px-5 py-6">
                <div class="flex items-center gap-4">
                    <i class="ri-settings-3-fill ri-xl"></i>
                    <span class="text-lg text-c-black font-normal">User Management</span>
                </div>
            </div>
            <!-- topTaskbar in desktop -->
            <div class="pl-4 md:pl-6 py-4 pr-4 md:pr-6 w-full flex flex-row justify-between items-center taskbar">
                <div class="w-full md:w-6/12 xl:w-8/12">
                    <div class="flex items-center gap-1 sm:gap-2">
                        <span class="text-c-light-black whitespace-nowrap font-normal">
                            User Management
                        </span>
                        <i class="ri-arrow-right-line ri-lg text-c-light-black"></i>
                        <span class="font-semibold text-c-black">
                            Users &amp; Groups
                        </span>
                    </div>
                </div>
                <div
                    class="relative taskicon hidden md:flex md:w-6/12 xl:w-4/12 flex flex-row items-center justify-end gap-6">
                    <div id="searchbutton"
                        class="flex items-center rounded overflow-hidden flex-shrink-0 flex-grow bg-c-white h-7 w-1/12 md:w-2/12 hidden md:flex">
                        <input type="text"
                            class="search pl-4 pt-2.5 pb-2.5 flex-shrink flex-grow border-none outline-none font-size-14 w-3/12"
                            placeholder="Search users" id="searchterm" />
                        <div class="searchicon pt-3 pb-3 pr-4 flex items-center justify-center">
                            <i class="ri-search-line" id="search"></i>
                        </div>
                    </div>
                    @if (!empty($filteredPermissions['userManagement']) && in_array('user-create', $filteredPermissions['userManagement']))
                        <button class="has-tooltip">
                            <i class="ri-add-circle-fill ri-xl" onclick="toggleModal('newUserModal')"></i>
                        </button>
                    @endif
                    <!-- <div
                      class="absolute py-1 px-2 text-start text-xs tooltip -bottom-8 right-5 z-10 bg-white border rounded-md border-c-yellow z-0 font-normal"
                    >
                      Add user
                    </div> -->
                    @if (
                        !empty($filteredPermissions['userManagement']) &&
                            in_array('user-mass-upload', $filteredPermissions['userManagement']))
                        <button>
                            <i class="ri-file-excel-2-fill ri-xl" id="showimport-upload-popup">Import Users</i>
                        </button>
                    @endif
                </div>
            </div>
            <!-- searchbar in mobile-->
            <div class="pl-4 pt-3 mt-3 pb-3 pr-4 w-full flex flex-row justify-between items-center bg-c-light-white-smoke md:hidden"
                id="mobiletaskbar">
                <div class="relative w-full flex flex-row items-center justify-end gap-2">
                    <div class="flex items-center rounded overflow-hidden flex-shrink-0 flex-grow bg-c-white h-8 w-1/12">
                        <input type="text" id="searchterm"
                            class="pl-4 pt-2.5 pb-2.5 flex-shrink flex-grow border-none outline-none w-3/12"
                            placeholder="Search users, groups..." />
                        <div class="pt-3 pb-3 pr-4 flex items-center justify-center">
                            <i class="ri-search-line" id="search"></i>
                        </div>
                    </div>
                    @if (!empty($filteredPermissions['userManagement']) && in_array('user-create', $filteredPermissions['userManagement']))
                        <button class="px-2 has-tooltip">
                            <i class="ri-add-circle-fill ri-xl" onclick="toggleModal('newUserModal')"></i>
                        </button>
                        <div
                            class="absolute py-1 px-2 text-start text-xs tooltip -bottom-8 right-5 z-10 bg-white border rounded-md border-c-yellow z-0">
                            Add user
                        </div>
                    @endif
                    @if (
                        !empty($filteredPermissions['userManagement']) &&
                            in_array('user-mass-upload', $filteredPermissions['userManagement']))
                        <button>
                            <i class="ri-file-excel-2-fill ri-xl"></i>
                        </button>
                        <<<<<<< HEAD @endif
                            =======

                            >>>>>>> ad247eeac18998615f54b97831339e49064f4ea2
                </div>
            </div>

            <!--Main content -->
            <div class="p-4 relative h-full flex flex-col main-content overflow-y-scroll">
                <div class="users-admin-btn-grp flex items-center relative justify-between flex-wrap">
                    <div class="flex items-center gap-2 flex-wrap">
                        <div class="dropdown inline-block relative">
                            @if (
                                !empty($filteredPermissions['groupsManagement']) ||
                                    in_array('group-view', $filteredPermissions['groupsManagement']))
                                <button
                                    class="border rounded px-6 py-1 custom-safety-btn custom-outline hover:border-yellow-300">
                                    <span class="mr-1">Group Function</span>
                                    <i class="ri-arrow-down-s-fill"></i>
                                </button>
                            @endif
                            <ul class="dropdown-menu custom-dropdown-menu absolute hidden text-gray-700 shadow bg-custom-pure-white text-xs z-0"
                                style="width: 8.1rem">
                                @foreach ($groups as $group)
                                    <li>
                                        <a class="rounded-t custom-bg-hover py-2 px-4 block whitespace-no-wrap px-4 flex justify-between font-normal"
                                            href="#">{{ $group->name }}
                                            @if (
                                                !empty($filteredPermissions['groupsManagement']) &&
                                                    in_array('group-edit', $filteredPermissions['groupsManagement']))
                                                <i class="group-edit ri-pencil-fill" data-id="{{ $group->id }}"></i>
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                                @if (
                                    !empty($filteredPermissions['groupsManagement']) &&
                                        in_array('group-create', $filteredPermissions['groupsManagement']))
                                    <li>
                                        <a class="rounded-b custom-bg-hover py-2 px-4 block whitespace-no-wrap px-4 flex justify-between font-normal"
                                            href="#" onclick="toggleModal('editModal')">Add Group
                                            <i class="ri-add-circle-fill" style="font-size: 14.5px"></i></a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="bg-white cs-table-container border border-gray-3 rounded-md mt-5">
                    <table class="table-auto w-full">
                        <thead class="h-14">
                            <tr class="bg-c-dark-gray">
                                <th class="text-c-white font-medium text-left pl-3 text-base rounded-tl-md"></th>
                                <th
                                    class="text-c-white font-medium text-left pl-3 text-base whitespace-nowrap w-1/4 pr-3 md:pr-0">
                                    NickName / Account
                                </th>
                                <th class="text-c-white font-medium text-left text-base pl-3 pr-3 md:pr-0">
                                    <button class="font-medium">
                                        Role <i class="ri-arrow-down-s-fill"></i>
                                    </button>
                                </th>
                                <th class="text-c-white font-medium text-left text-base pl-3 pr-3 md:pr-0">
                                    <button class="font-medium">
                                        Space Usage <i class="ri-arrow-down-s-fill"></i>
                                    </button>
                                </th>
                                <th class="text-c-white font-medium text-left text-base pl-3 rounded-tr-md pr-3 md:pr-0">
                                    Group
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        @if (!empty($filteredPermissions['userManagement']) && in_array('user-view', $filteredPermissions['userManagement']))
                            <tbody id="searchableTableBody">

                            </tbody>
                        @endif
                    </table>
                </div>
                <div class="mt-auto flex justify-end pt-3 font-normal">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- edit modal -->
    <div id="editModal" role="dialog"
        class="fixed hidden inset-0 flex items-center justify-center bg-black bg-opacity-50 z-10">
        <div class="bg-white rounded-2xl overflow-hidden shadow-lg max-w-xl w-full bg-c-lighten-gray modal-content">
            <div class="flex py-2 px-5 justify-between items-center border-b border-gray-3 text-c-black">
                <div class="text-lg font-normal">Add Group</div>
                <button type="button" id="closeModalButton" class="py-1.5 rounded-md" onclick="toggleModal('editModal')">
                    <i class="ri-close-circle-fill text-black ri-lg"></i>
                </button>
            </div>
            <div class="p-5">
                <form class="space-y-4 text-sm" action="{{ route('group-create') }}" method="POST">
                    @csrf
                    <div class="flex flex-wrap w-full gap-y-4 items-center">
                        <label for="title" class="title font-bold text-c-black">Name: <span
                                class="text-red-500">*</span></label>
                        <div class="w-full sm:w-3/4 ml-auto">
                            <div class="relative w-full">
                                <input
                                    class="w-full p-2 bg-c-lighten-gray border border-gray-3 rounded-xl outline-none pl-4"
                                    type="text" placeholder="Group 1" name="name" required />
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center border border-gray-3 w-12 rounded-r-xl pl-3">
                                    <i class="ri-folder-5-fill ri-xl text-c-sky"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-y-4 items-start">
                        <div class="title font-bold text-c-black pt-3">
                            Space size:<span class="text-red-500">*</span>
                        </div>
                        <div class="w-full sm:w-3/4 ml-auto">
                            <div class="relative w-full">
                                <input
                                    class="w-full p-2 bg-c-lighten-gray border border-gray-3 rounded-xl outline-none pl-4"
                                    type="number" placeholder="3" name="sizeUse" min="0" max="500" />
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center bg-c-gray-4 border border-gray-3 w-12 rounded-r-xl pl-3">
                                    <p class="font-normal">GB</p>
                                </div>
                            </div>
                            <p class="text-xs text-c-black font-light mt-2">
                                0 is unlimited
                            </p>
                        </div>
                    </div>
                    <div class="mb-5">
                        <label for="permissionID"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Permissions</label>
                        <select id="roleID" name="permissionID"
                            class="p-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                            @foreach ($permissions as $permission)
                                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end mt-3">
                        <button type="submit"
                            class="bg-c-black hover-bg-c-black text-white rounded-full w-32 py-2 text-sm">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- new user modal -->
    <div id="newUserModal" role="dialog"
        class="fixed hidden inset-0 flex items-center justify-center bg-black bg-opacity-50 z-10">
        <div class="bg-white rounded-2xl overflow-hidden shadow-lg max-w-2xl w-full bg-c-lighten-gray modal-content">
            <!-- Sticky header -->
            <div
                class="sticky top-0 flex py-2 px-5 justify-between items-center border-b border-gray-3 bg-white z-10 text-c-black">
                <div class="text-lg font-normal">Add New User</div>
                <button type="button" id="closeModalButton" class="py-1.5 rounded-md"
                    onclick="event.stopPropagation();toggleModal('newUserModal');">
                    <i class="ri-close-circle-fill text-black ri-lg"></i>
                </button>
            </div>
            <!-- Scrollable content -->
            <div class="p-5 overflow-y-auto max-h-[calc(100vh-6rem)] scroll">
                <form class="space-y-4 text-sm" action="{{ route('user-create') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                        <div class="md:col-span-2 flex items-center">
                            <label for="name" class="block font-bold text-c-black">
                                Username:<span class="text-red-500">*</span>
                            </label>
                        </div>
                        <div class="md:col-span-8">
                            <input id="name"
                                class="w-full p-2 bg-c-lighten-gray border border-gray-3 rounded-xl outline-none pl-5"
                                type="text" placeholder="Please enter an username" autocomplete="name" name="name"
                                required />
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                        <div class="md:col-span-2 flex items-center">
                            <label for="nickname" class="block font-bold text-c-black">
                                Name:
                            </label>
                        </div>
                        <div class="md:col-span-8">
                            <input id="nickname"
                                class="w-full p-2 bg-c-lighten-gray border border-gray-3 rounded-xl outline-none pl-5"
                                type="text" placeholder="Please enter nickname" name="nickName" />
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                        <div class="md:col-span-2 flex items-center">
                            <label for="nickname" class="block font-bold text-c-black">
                                Email:
                            </label>
                        </div>
                        <div class="md:col-span-8">
                            <input id="nickname"
                                class="w-full p-2 bg-c-lighten-gray border border-gray-3 rounded-xl outline-none pl-5"
                                type="email" placeholder="Please enter email" autocomplete="email" name="email"
                                required />
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
                        <div class="md:col-span-2 flex items-center">
                            <label for="password" class="block font-bold text-c-black">
                                Password:<span class="text-red-500">*</span>
                            </label>
                        </div>
                        <div class="md:col-span-8 flex items-center gap-2">
                            <div class="relative w-full">
                                <input id="password"
                                    class="w-full p-2 bg-c-lighten-gray border border-gray-3 rounded-xl outline-none pl-4"
                                    type="password" placeholder="Please enter password" name="password" required />
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center border border-gray-3 w-12 rounded-r-xl pl-3 pt-1">
                                    <i class="ri-eye-close-line ri-xl" id="togglePassword"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
                        <div class="md:col-span-2 flex items-center">
                            <label for="space-size" class="block font-bold text-c-black">
                                Space size:<span class="text-red-500">*</span>
                            </label>
                        </div>
                        <div class="md:col-span-8 flex items-center gap-2">
                            <div class="relative w-full">
                                <input id="space-size"
                                    class="w-full p-2 bg-c-lighten-gray border border-gray-3 rounded-xl outline-none pl-4"
                                    type="number" placeholder="Please enter space size" name="sizeMax" min="0"
                                    max="500" />
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center bg-c-gray-4 border border-gray-3 w-12 rounded-r-xl pl-3">
                                    <p class="font-normal">GB</p>
                                </div>
                            </div>
                        </div>
                        <!--  <div class="md:col-span-2 flex items-center ml-0 md:-ml-2">
                        <p class="text-xs text-c-black font-light w-full">
                          (GB) 0 is unlimited
                        </p>
                      </div> -->
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
                        <div class="md:col-span-2 flex items-center">
                            <label for="role" class="block font-bold text-c-black">
                                Role:
                            </label>
                        </div>
                        <div class="md:col-span-8 flex items-center gap-2">
                            <div class="dropdown inline-block relative w-full">
                                <select id="roleID" name="roleID"
                                    class="p-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
                        <div class="md:col-span-2 flex items-center">
                            <label for="group" class="block font-bold text-c-black">
                                Group:
                            </label>
                        </div>
                        <div class="md:col-span-8 flex items-center gap-2">
                            <div class="dropdown inline-block relative w-full">
                                <select id="groupID" name=" groupID"
                                    class="p-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="flex justify-end mt-3">
                        <button type="submit"
                            class="bg-c-black hover:bg-c-black text-white rounded-full w-32 py-2 text-sm">
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit modal -->
    <div id="user-edit-div">

    </div>
    <!-- End Edit modal -->
    <!--End Group Edit-Modal  -->
    <div id="group-edit-div">

    </div>
    <!-- Suspend Button Modal -->
    <div id="delete-modal" tabindex="-1"
        class="fixed hidden inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="delete-modal relative">
            <div class="relative">
                <div class="p-4 md:p-5 text-center">
                    <div class="delete-header flex items-center gap-4 mb-1 py-1">
                        <i class="ri-delete-bin-6-line ri-xl text-c-yellow"></i>
                        <h1 class="text-lg font-medium">Suspend User</h1>
                    </div>
                    <hr text-md>
                    <div class="mt-6 flex items-center justify-center">
                        <h1 class="text-md font-medium text-c-black">
                            Are you sure ? User will get deactivated!!
                        </h1>
                    </div>
                    <div class="flex items-center justify-center gap-3 mt-9">
                        <a href="#" id="deleteRole">
                            <button id="okdelete" class="bg-c-black text-white rounded-full px-12 sm:px-14 py-2"
                                type="submit">
                                OK
                            </button>
                        </a>
                        <input type="hidden" name="id" id="delete-id" value="">
                        <button class="bg-white text-c-yellow px-9 sm:px-12 py-2 rounded-full border border-c-yellow"
                            onclick="hidedeleteModal()">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--import model -->

    <div id="userimportpopup" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
        <div class="popup-content bg-white rounded-lg shadow-lg p-6 w-full max-w-2xl">
            <!-- Header -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Import Users</h2>
                <button id="closeimport-popup" class="text-2xl">
                    <i class="ri-close-line"></i>
                </button>
            </div>

            <!-- Button Area -->
            <div class="flex justify-between items-center mb-4">
                <div>
                    <input type="file" id="file-input" multiple class="hidden">
                    <label for="file-input" class="bg-black text-white px-4 py-2 mr-2 cursor-pointer">Upload File</label>
                </div>
            </div>

            <!-- Table Area -->
            <div class="dropzone mt-10 mb-4 border border-gray-300 rounded-md overflow-y-auto max-h-64">
                <div id="file-list" class="space-y-2">
                    <!-- Files will be listed here -->
                </div>
            </div>

        </div>
    </div>

    <!--import model end -->

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Initial population of the table
            populateTable();

            function populateTable(term = '') {
                const searchTerm = term;
                const attr = '{{ request()->get('page') }}';
                const listroute = @json(route('user-list'));
                $.ajax({
                    url: listroute,
                    method: 'GET',
                    data: {
                        page: attr,
                        searchTerm: searchTerm
                    },
                    success: function(response) {
                        // Update the app list container with the updated list
                        $('#searchableTableBody').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });

            }


            $('.btn-close').on('click', function(e) {
                $('.alert').hide();
            });

            $("#searchterm").keyup(function() {
                var term = $('#searchterm').val();
                populateTable(term);
            });

            @if (Session::has('success'))
                toastr.success("User Added successfully");
            @endif
            @if (Session::has('success-update'))
                toastr.success("User Updated successfully");
            @endif
            @if (Session::has('success-suspend'))
                toastr.success("User supended successfully");
            @endif
            @if (Session::has('success-active'))
                toastr.success("User activated successfully");
            @endif
            @if (Session::has('user-exist'))
                toastr.error("User email already exist!!");
            @endif
            @if (Session::has('success-group'))
                toastr.success("Group Added successfully");
            @endif
            @if (Session::has('group-update'))
                toastr.success("Group Updated successfully");
            @endif
            @if (Session::has('user-special'))
                toastr.error("User name has special characters!!!");
            @endif
        });

        // DeletetModal Open Functionality
        const deleteModal = document.getElementById('delete-modal');

        function showdeleteModal() {
            deleteModal.classList.remove('hidden');
        }

        function hidedeleteModal() {
            deleteModal.classList.add('hidden');
        }

        // for handling add or edit modal
        const basicButton = document.getElementById("basicButton");
        const moreSettings = document.getElementById("moresettings");

        function toggleModal(id) {
            const element = document.getElementById(id);
            element.classList.toggle("hidden");
            if (id == "newUserModal") {
                basicButton.classList.add("bg-c-yellow");
            }
        }

        const togglePassword =
            document.querySelector('#togglePassword');

        const password =
            document.querySelector('#password');

        togglePassword.
        addEventListener('click', function(e) {

            // Toggle the type attribute
            const type = password.getAttribute(
                'type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Toggle the eye slash icon
            $('#togglePassword').toggleClass('ri-eye-line ri-xl');
        });

        //edit group popup js
        $('.group-edit').on('click', function(e) {
            e.preventDefault();

            id = $(this).attr("data-id");
            $.ajax({
                url: 'group-edit',
                method: 'GET',
                data: {
                    id: id
                },
                success: function(response) {
                    // Update the app list container with the updated list
                    $('#group-edit-div').html(response);
                    $('.group-edit-modal').removeClass('hidden');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

        });

        //// import users
        ///upload  popup

        let uploads = {};

        document.getElementById('showimport-upload-popup').addEventListener('click', function() {
            document.getElementById('userimportpopup').classList.remove('hidden');
        });

        document.getElementById('closeimport-popup').addEventListener('click', function() {
            document.getElementById('userimportpopup').classList.add('hidden');
        });
        const dropzone = document.querySelector('.dropzone');

        dropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropzone.classList.add('dragover');
        });

        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('dragover');
        });

        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropzone.classList.remove('dragover');
            // Use DataTransfer interface to access the files
            handleFiles(e.dataTransfer.files);

        });

        $('#file-input, #folder-input').on('change', function(e) {
            handleFiles(e.target.files);
        });


        function handleFiles(files) {
            let fileList = $('#file-list');
            let formData = new FormData();

            $.each(files, function(index, file) {
                formData.append('files[]', file);
                let fileId = Math.random().toString(36).substring(7);
                uploads[fileId] = {
                    file: file,
                    paused: false
                };
                fileList.append(
                    `<div id="${fileId}" class="flex justify-between items-center border-b border-gray-300 p-2">
                        <div class="flex items-center">
                            <i class="ri-upload-line text-gray-500 mr-2"></i>
                            <span>Uploading ${file.name}...</span>
                        </div>
                        <div class="flex-grow text-right">
                            <span class="text-blue-500">${file.name}</span> (${(file.size / 1024).toFixed(2)} KB)
                            <!-- <button class="pause-upload text-yellow-500 ml-2"><i class="ri-pause-line"></i></button>
                             <button class="remove-upload text-red-500 ml-2"><i class="ri-close-line"></i></button>-->
                        </div>
                    </div>`
                );
            });

            $.ajax({
                url: '/importusers',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {

                    fileList.empty();
                    if (response.success) {
                        $.each(response.files, function(index, file) {
                            fileList.append(
                                `<div class="flex justify-between items-center border-b border-gray-300 p-2">
                                    <div class="flex items-center">
                                        <i class="ri-check-line text-green-500 mr-2"></i>
                                        <span>Upload Successful</span>
                                    </div>
                                    <div class="flex-grow text-right">
                                        <span class="text-blue-500">${file.name}</span> (${(file.size / 1024).toFixed(2)} KB)
                                    </div>
                                </div>`
                            );
                        });
                    } else {
                        fileList.append(
                            `<div class="flex justify-between items-center border-b border-gray-300 p-2">
                                    <div class="flex items-center">
                                        <i class="ri-close-circle-fill text-red-500 mr-2"></i>
                                        <span>Upload Failed (` + response.message + `)</span>
                                        <span>Failed Email (` + response.test + `)</span>
                                    </div>
                                </div>`
                        )
                    }
                    // document.getElementById('popup').style.display = 'none';
                    // fileList.empty();
                    //populateTable();
                    setTimeout(location.reload.bind(location), 3000);
                }
            });
        }
        ///// upload end

        /// end import
    </script>

@endsection
