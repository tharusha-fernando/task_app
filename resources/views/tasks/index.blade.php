<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        <label for="project-filter"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Filter by Project</label>
                        <select id="project-filter" name="project-filter"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">All Projects</option>
                            <!-- Add project options dynamically -->
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}"
                                    {{ request('project_id') == $project->id ? 'selected' : '' }}>{{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="inline-flex items-center">
                            <input type="radio" class="form-radio" name="order" value="created_at" {{ request('order_by') == 'created_at' ? 'checked' : '' }}>
                            <span class="ml-2">Order by Created At</span>
                        </label>
                        <label class="inline-flex items-center ml-6">
                            <input type="radio" class="form-radio" name="order" value="priority" {{ request('order_by') == 'priority' ? 'checked' : '' }}>
                            <span class="ml-2">Order by Priority</span>
                        </label>
                    </div>
                    <div class="mb-4">
                        <label class="inline-flex items-center">
                            <input type="radio" class="form-radio" name="direction" value="ASC" {{ request('direction') == 'ASC' ? 'checked' : '' }}>
                            <span class="ml-2">Ascending</span>
                        </label>
                        <label class="inline-flex items-center ml-6">
                            <input type="radio" class="form-radio" name="direction" value="DESC" {{ request('direction') == 'DESC' ? 'checked' : '' }}>
                            <span class="ml-2">Descending</span>
                        </label>
                    </div>

                    <div class="mb-4">
                        <label for="page-length" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Page
                            Length</label>
                        <select id="page-length" name="page-length"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="10" {{ request('page_length') == 10 ? 'selected' : '' }}>10</option>
                            <option value="20" {{ request('page_length') == 20 ? 'selected' : '' }}>20</option>
                            <option value="50" {{ request('page_length') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('page_length') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <a href="{{ route('tasks.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 disabled:opacity-25 transition">
                            Create Task
                        </a>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Name</th>
                                <th scope="col"
                                    class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Priority</th>
                                <th scope="col"
                                    class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Project</th>
                                <th scope="col"
                                    class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody id="sortable" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700" >
                            <!-- Render tasks dynamically -->
                            @foreach ($tasks as $task)
                                <tr data-id="{{ $task->id }}">
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $task->name }}
                                        <br>
                                        Id - {{$task->id}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $task->priority }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $task->project->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('tasks.edit', $task->id) }}"
                                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900">Edit</a>
                                        <button data-id="{{ $task->id }}"
                                            class="text-red-600 dark:text-red-400 hover:text-red-900 ml-4 deleteBtn">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $tasks->links() }}
                    <div class="mt-4">
                        <!-- Pagination links -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    

    <script>
        $(document).ready(function() {
            
            $(document).on("click", ".deleteBtn", function() {
                var id = $(this).data('id');
                var url = '{{ route('tasks.destroy', ['task' => '__id']) }}'.replace('__id', id);
                destroyData(url, null, true);
            });

            $('#project-filter').on('change', function() {
                var projectId = $(this).val();
                var url = new URL(window.location.href);
                url.searchParams.set('project_id', projectId);
                window.location.href = url.toString();
            });

            $('input[name="order"]').change(function() {
                var orderBy = $(this).val();
                var url = new URL(window.location.href);
                url.searchParams.set('order_by', orderBy);
                window.location.href = url.toString();
            });

            $('input[name="direction"]').change(function() {
                var direction = $(this).val();
                var url = new URL(window.location.href);
                url.searchParams.set('direction', direction);
                console.log(url.toString())
                window.location.href = url.toString();
            });

            $('#page-length').change(function() {
                var pageLength = $(this).val();
                var url = new URL(window.location.href);
                url.searchParams.set('page_length', pageLength);
                window.location.href = url.toString();
            });

            $("#sortable").sortable({
                update: function(event, ui) {
                    var order = [];
                    $('#sortable tr').each(function(index, element) {
                        order.push({
                            id: $(element).data('id'),
                            position: index + 1
                        });
                    });

                    $.ajax({
                        url: '{{ route('tasks.reorder') }}',
                        method: 'POST',
                        data: {
                            order: order,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log(response);
                            flasher.success(response.message);
                        },
                        error: function(response) {
                            console.log(response);
                            flasher.error(response.responseJSON.message);
                        }
                    });
                }
            }).disableSelection();
        });
    </script>
</x-app-layout>
