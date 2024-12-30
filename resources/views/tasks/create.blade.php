<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form id="taskForm" method="POST" action="{{ route('tasks.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Task Name</label>
                            <input type="text" name="name" id="name"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white sm:text-sm">
                                <x-validation-error :name="'name'"/>

                        </div>
                        <div class="mb-4">
                            <label for="project"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Project</label>
                            <select name="project_id" id="project"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white sm:text-sm">
                                <!-- Options should be populated dynamically -->

                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                            <x-validation-error :name="'project_id'"/>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-500 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 dark:focus:ring-gray-600 disabled:opacity-25 transition ease-in-out duration-150">
                                Create Task
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function() {
        $('#taskForm').on('submit', function(e) {
            e.preventDefault();

            $('.error').text('');
            $('.form-group').removeClass('border--red');

            var action = $(this).attr('action');
            var formData = $(this).serialize();
            var method = $(this).attr('method');
            var redirectRoute = "{{ route('tasks.index') }}";

            storeData(action, method, formData, null, null, redirectRoute);
        });
    });
</script>
