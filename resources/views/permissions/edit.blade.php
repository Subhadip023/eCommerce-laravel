<x-app-layout>
    <section class="text-gray-600 body-font">
        <form action="{{ route('permissions.store') }}" method="POST" class="flex flex-col items-center justify-center">
            @csrf
            <div class="container px-5 py-24 mx-auto flex flex-wrap items-center">
                <div
                    class="lg:w-2/6 md:w-1/2 bg-gray-300 rounded-lg p-8 flex flex-col md:ml-auto w-full mt-10 md:mt-0 mx-auto">
                    <h2 class="text-gray-900 text-lg font-medium title-font mb-5">Add Permission Form</h2>
                    <div class="relative mb-4">
                        <label for="permission-name" class="leading-7 text-sm text-gray-600">Permission Name</label>
                        <input type="text" id="permission-name" name="name" value="{{ old('name') }}"
                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                            aria-describedby="error-name">
                        @error('name')
                            <p id="error-name" class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div> 
                    
                    <div class="relative mb-4">
                        <label for="permission-name" class="leading-7 text-sm text-gray-600">Guird Name</label>
                        <input type="text" id="permission-name" name="name" value="{{ old('name') }} {{$permission->guard_name}}"
                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                            aria-describedby="error-name">
                        @error('name')
                            <p id="error-name" class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button
                        class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                        Add Permission
                    </button>
                </div>
            </div>
        </form>
    </section>
</x-app-layout>
