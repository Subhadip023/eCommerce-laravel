
<x-app-layout>






<section class="text-gray-600 body-font">

    <form action="{{ route('role.update',$role->id) }}" method="POST" class="flex flex-col items-center justify-center">
        @csrf
        @method('PUT')

        <div class="container px-5 py-24 mx-auto flex flex-wrap items-center">

            <div
                class="lg:w-2/6 md:w-1/2 bg-gray-300 rounded-lg p-8 flex flex-col md:ml-auto w-full mt-10 md:mt-0 mx-auto">
                <h2 class="text-gray-900 text-lg font-medium title-font mb-5">Edit Role Form </h2>
                <div class="relative mb-4">
                    <label for="full-name" class="leading-7 text-sm text-gray-600">Role Name</label>
                    <input type="text" id="full-name" name="name" value="{{ $role->name }}"
                        class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                </div>
                
                <div class="relative mb-4">
                <label for="permissions">Assign Permissions</label>
                @foreach ($permissions as $permission)
        <div>
            <input type="checkbox" id="permission-{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}"
                {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
            <label for="permission-{{ $permission->id }}">{{ $permission->name }}</label>
        </div>
        @error('permissions')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
        @endforeach
            </div>
            <button
                class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">Add Role</button>
            {{-- <p class="text-xs text-gray-500 mt-3">Literally you probably haven't heard of them jean shorts.</p> --}}
        </div>

        </div>
    </form>

</section>



</x-app-layout>
