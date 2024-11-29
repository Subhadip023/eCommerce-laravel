<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
            <div class="lg:w-3/3 w-full mx-auto overflow-auto">
                <table class="table-auto w-full text-left whitespace-no-wrap">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 bg-gray-100">#</th>
                            <th class="px-4 py-3 bg-gray-100">Name</th>
                            <th class="px-4 py-3 bg-gray-100">Roles</th>
                            <th class="px-4 py-3 bg-gray-100">Permissions</th>
                            <th class="px-4 py-3 bg-gray-100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $index => $user)
                            <tr class="border-b-2 py-2">
                                <td class="px-4 py-3 ">{{ $index + 1 }}</td>
                                <td class="px-4 py-3">{{ $user->name }}</td>
                                <td class="px-4 py-3 duration-300">
                                    @if ($user->roles->isNotEmpty())
                                        {{ $user->roles->pluck('name')->join(', ') }}

                                        <div class=" flex justify-center my-3">
                                            <button id="updateBtn{{ $user->id }}"
                                                class="bg-green-500 text-white hover:bg-green-400 p-2 rounded-md"
                                                onclick=" event.preventDefault();document.getElementById('updateForm{{ $user->id }}').classList.remove('hidden');document.getElementById('updateBtn{{ $user->id }}').classList.add('hidden')">Update<button>
                                        </div>
                                        <form action="{{ route('user.updateRole', ['user' => $user->id]) }}"
                                            method="POST">
                                            <div id="updateForm{{ $user->id }}"
                                                class="relative mb-4 w-[500px] flex flex-row flex-wrap border box-border shadow-md justify-center rounded-md hidden">

                                                @csrf
                                                @method('PUT')


                                                @php
                                                    $rolesArray = $roles->pluck('name')->toArray();

                                                    if (auth()->user()->hasRole('super-admin')) {
                                                        $userRoles = $rolesArray;
                                                    } else {
                                                        $userRoles = array_diff(
                                                            $rolesArray,
                                                            ['super-admin'],
                                                        );
                                                    }

                                                @endphp


                                                @foreach ($userRoles as $role)
                                                    <div
                                                        class=" w-fit p-2 mb-2 mr-1 flex items-center justify-start gap-x-1">

                                                        <input type="checkbox" name="roles[]"
                                                            id="role-{{ $role }}" value="{{ $role }}"
                                                            {{ $user->hasRole($role) ? 'checked' : '' }}>
                                                        <label
                                                            for="role-{{ $role }}">{{ $role }}</label>
                                                    </div>
                                                @endforeach
                                                <div class="w-full mb-2 flex items-center justify-center gap-x-5">

                                                    <button class="border-2 p-2 rounded-lg hover:bg-gray-300"
                                                        onclick=" event.preventDefault();document.getElementById('updateForm{{ $user->id }}').classList.add('hidden');document.getElementById('updateBtn{{ $user->id }}').classList.remove('hidden')">Cancel</button>

                                                    <button type="submit"
                                                        class="bg-green-400  hover:bg-green-600 hover:text-white p-2 rounded">Update</button>
                                                </div>

                                            </div>
                                        </form>
                                    @else
                                        <button onclick="showModal({{ $user->id }})"
                                            class="text-indigo-500 hover:underline">Add role</button>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if ($user->roles->isNotEmpty())
                                        {{ $user->roles->pluck('permissions')->flatten()->pluck('name')->unique()->join(', ') }}
                                    @else
                                        No permissions assigned
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <a href="#" class="text-indigo-500 hover:underline">Edit</a>
                                    <form method="POST" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div id="modal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded shadow-lg w-1/3">
            <h3 class="text-xl font-semibold mb-4">Select Roles</h3>
            <form id="roleForm" action="" method="POST">
                @csrf
                @method('POST')
                <div class="mb-4">
                    <label for="role" class="block text-gray-700">Role Name</label>
                    @foreach ($roles as $role)
                        <div>
                            <input type="checkbox" name="roles[]" id="role-{{ $role->id }}"
                                value="{{ $role->name }}">
                            <label for="role-{{ $role->id }}">{{ $role->name }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeModal()"
                        class="mr-4 text-gray-600 border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-100">Cancel</button>
                    <button type="submit"
                        class="text-white bg-indigo-500 px-4 py-2 rounded-lg hover:bg-indigo-600">Submit</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        function showModal(userId) {
            const modal = document.getElementById('modal');
            const form = document.getElementById('roleForm');
            form.action = `users/${userId}/role/create`;
            modal.classList.remove('hidden');
        }

        function closeModal() {
            const modal = document.getElementById('modal');
            modal.classList.add('hidden');
        }
    </script>



</x-app-layout>
