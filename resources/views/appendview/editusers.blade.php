<div
          id="user-edit-modal"
          role="dialog"
          class="user-edit-modal fixed hidden inset-0 flex items-center justify-center bg-black bg-opacity-50 z-10"
        >
          <div
            class="bg-white rounded-2xl overflow-hidden shadow-lg max-w-2xl w-full bg-c-lighten-gray modal-content"
          >
            <!-- Sticky header -->
            <div
              class="sticky top-0 flex py-2 px-5 justify-between items-center border-b border-gray-3 bg-white z-10 text-c-black"
            >
              <div class="text-lg font-normal">Edit User</div>
              <button
                type="button"
                id="closeModalButton"
                class="user-edit-close py-1.5 rounded-md" >
                <i class="ri-close-circle-fill text-black ri-lg"></i>
              </button>
            </div>
            <!-- Scrollable content -->
            <div class="p-5 overflow-y-auto max-h-[calc(100vh-6rem)] scroll">
              <form class="space-y-4 text-sm" action="{{ route('user-update',['id' => $user->id]) }}" method="POST">
                 @csrf
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                  <div class="md:col-span-2 flex items-center">
                    <label for="name" class="block font-bold text-c-black">
                      Username:<span class="text-red-500">*</span>
                    </label>
                  </div>
                  <div class="md:col-span-8">
                    <input
                      id="name"
                      class="w-full p-2 bg-c-lighten-gray border border-gray-3 rounded-xl outline-none pl-5"
                      type="text"
                      placeholder="Please enter an username"
                      autocomplete="name"
                      name="name" value="{{ $user->name }}" required
                    />
                  </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                  <div class="md:col-span-2 flex items-center">
                    <label for="nickname" class="block font-bold text-c-black">
                      Name:
                    </label>
                  </div>
                  <div class="md:col-span-8">
                    <input
                      id="nickname"
                      class="w-full p-2 bg-c-lighten-gray border border-gray-3 rounded-xl outline-none pl-5"
                      type="text"
                      placeholder="Please enter nickname"
                      name="nickName"  value="{{ $user->nickName }}"
                    />
                  </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                  <div class="md:col-span-2 flex items-center">
                    <label for="nickname" class="block font-bold text-c-black">
                      Email:
                    </label>
                  </div>
                  <div class="md:col-span-8">
                    <input
                      id="nickname"
                      class="w-full p-2 bg-c-lighten-gray border border-gray-3 rounded-xl outline-none pl-5"
                      type="email"
                      placeholder="Please enter email"
                      autocomplete="email"
                      name="email" value="{{ $user->email }}" required
                    />
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
                      <input
                        id="password"
                        class="w-full p-2 bg-c-lighten-gray border border-gray-3 rounded-xl outline-none pl-4"
                        type="password"
                        placeholder="Please enter password"
                        name="password" value="" 
                      />
                      <div
                        class="absolute inset-y-0 right-0 flex items-center border border-gray-3 w-12 rounded-r-xl pl-3 pt-1"
                      >
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
                      <input
                        id="space-size"
                        class="w-full p-2 bg-c-lighten-gray border border-gray-3 rounded-xl outline-none pl-4"
                        type="number"
                        placeholder="Please enter space size"
                        name="sizeMax" value="{{ $user->sizeMax }}"
                      />
                      <div
                        class="absolute inset-y-0 right-0 flex items-center bg-c-gray-4 border border-gray-3 w-12 rounded-r-xl pl-3"
                      >
                        <p class="font-normal">GB</p>
                      </div>
                    </div>
                  </div>
                  <div class="md:col-span-2 flex items-center ml-0 md:-ml-2">
                    <p class="text-xs text-c-black font-light w-full">
                      (GB) 0 is unlimited
                    </p>
                  </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
                  <div class="md:col-span-2 flex items-center">
                    <label for="role" class="block font-bold text-c-black">
                      Role:
                    </label>
                  </div>
                  <div class="md:col-span-8 flex items-center gap-2">
                    <div class="dropdown inline-block relative w-full">
                      <select id="roleID" name="roleID" class="p-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                         @foreach($roles as $role)
                         <option value="{{ $role->id }}" @php echo ($role->id == $user->roleID)?'selected':'' @endphp>{{ $role->name }}</option>
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
                       <select id="groupID" name=" groupID" class="p-3 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                         @foreach($groups as $group)
                        <option value="{{ $group->id }}" @php echo ($group->id == $user->groupID)?'selected':'' @endphp>{{ $group->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                 
                </div>
                <div class="flex justify-end mt-3">
                  <button
                    type="submit"
                    class="bg-c-black hover:bg-c-black text-white rounded-full w-32 py-2 text-sm"
                  >
                    Update
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
<script>
  
  $('.user-edit-close').on('click', function (e) {
          $('.user-edit-modal').hide();
    });
</script>
