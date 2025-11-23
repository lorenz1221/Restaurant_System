<x-layouts.app :title="__('Category Management')">
    <div class="flex flex-col h-full w-full gap-4 rounded-xl">

        {{-- Flash Messages --}}
        @if (session('success'))
            <div id="flash-success"
                class="rounded-lg bg-blue-200/20 p-4 text-sm text-blue-300 dark:bg-blue-800/40 dark:text-blue-200 shadow-sm border border-blue-700/50">
                {{ session('success') }}
            </div>

            <script>
                setTimeout(() => {
                    const box = document.getElementById('flash-success');
                    if (box) {
                        box.classList.add('opacity-0');
                        setTimeout(() => box.remove(), 400);
                    }
                }, 2500);
            </script>
        @endif

        @if (session('error'))
            <div class="rounded-lg bg-red-200/20 p-4 text-sm text-red-300 dark:bg-red-800/40 dark:text-red-200 shadow-sm border border-red-700/50">
                {{ session('error') }}
            </div>
        @endif


        <div class="flex-1 overflow-hidden rounded-xl border border-neutral-700 bg-neutral-900 shadow-lg">
            <div class="h-full flex flex-col gap-6 p-6">

                {{-- Create Category Form --}}
                <section
                    class="rounded-lg border border-neutral-700 bg-neutral-800 p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-neutral-100 mb-4">
                        Create New Category
                    </h2>

                    <form method="POST" action="{{ route('categories.store') }}" class="grid gap-4 sm:grid-cols-2">
                        @csrf

                        {{-- Category Name --}}
                        <div class="flex flex-col">
                            <label class="text-sm font-medium text-neutral-300 mb-1">
                                Name
                            </label>
                            <input
                                id="category_name"
                                name="name"
                                type="text"
                                value="{{ old('name') }}"
                                placeholder="Ex: Drinks, Desserts..."
                                required
                                class="rounded-lg border border-neutral-600 bg-neutral-900 px-4 py-2 text-sm text-neutral-100 focus:ring-2 focus:ring-blue-600/50 focus:border-blue-500 transition-all"
                            >
                        </div>

                        {{-- Description --}}
                        <div class="flex flex-col">
                            <label class="text-sm font-medium text-neutral-300 mb-1">
                                Description (optional)
                            </label>
                            <input
                                id="category_desc"
                                name="description"
                                type="text"
                                value="{{ old('description') }}"
                                placeholder="Short description"
                                class="rounded-lg border border-neutral-600 bg-neutral-900 px-4 py-2 text-sm text-neutral-100 focus:ring-2 focus:ring-blue-600/50 focus:border-blue-500 transition-all"
                            >
                        </div>

                        <div class="sm:col-span-2">
                            <button
                                type="submit"
                                class="px-6 py-2 rounded-lg bg-blue-700 text-sm font-medium text-white hover:bg-blue-800 focus:ring-2 focus:ring-blue-600/50 transition-all shadow">
                                Save Category
                            </button>
                        </div>
                    </form>
                </section>

                {{-- Category Table --}}
                <section class="flex-1 overflow-auto">
                    <h2 class="text-lg font-semibold text-neutral-100 mb-3">All Categories</h2>

                    <div class="overflow-x-auto rounded-lg border border-neutral-700 shadow-sm">
                        <table class="w-full min-w-max">
                            <thead>
                                <tr class="bg-neutral-800 border-b border-neutral-700">
                                    <th class="p-3 text-left text-sm font-semibold text-neutral-300">#</th>
                                    <th class="p-3 text-left text-sm font-semibold text-neutral-300">Name</th>
                                    <th class="p-3 text-left text-sm font-semibold text-neutral-300">Description</th>
                                    <th class="p-3 text-left text-sm font-semibold text-neutral-300">Items</th>
                                    <th class="p-3 text-left text-sm font-semibold text-neutral-300">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-neutral-700">
                                @forelse ($categories as $row)
                                    <tr class="hover:bg-neutral-800 transition-all">
                                        <td class="p-3 text-sm text-neutral-300">{{ $loop->iteration }}</td>
                                        <td class="p-3 text-sm font-medium text-neutral-200">
                                            {{ $row->name }}
                                        </td>

                                        <td class="p-3 text-sm text-neutral-400">
                                            {{ trim($row->description ?? '') !== '' ? $row->description : 'N/A' }}
                                        </td>

                                        <td class="p-3 text-sm text-neutral-300">{{ $row->menu_items_count }}</td>

                                        <td class="p-3 text-sm flex gap-3 items-center">

                                            {{-- Edit --}}
                                            <button
                                                class="text-blue-400 hover:text-blue-300 transition"
                                                onclick='openCategoryEditor({{ $row->id }}, {!! json_encode($row->name) !!}, {!! json_encode($row->description ?? "") !!})'>
                                                Edit
                                            </button>

                                            {{-- Delete --}}
                                            <form action="{{ route('categories.destroy', $row) }}" method="POST"
                                                onsubmit="return confirm('Delete this category?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    class="text-red-400 hover:text-red-300 transition">
                                                    Delete
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-4 text-center text-sm text-neutral-500">
                                            No categories found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div id="categoryModal" class="fixed inset-0 bg-black/60 hidden z-50 items-center justify-center">
        <div class="w-full max-w-xl rounded-xl bg-neutral-900 border border-neutral-700 p-6 shadow-xl">
            <h2 class="text-lg font-semibold mb-4 text-neutral-100">Update Category</h2>

            <form id="categoryEditForm" method="POST">
                @csrf
                @method('PUT')

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-neutral-300">Name</label>
                        <input id="modal_name" type="text" name="name" required
                            class="w-full rounded-lg border border-neutral-600 bg-neutral-800 text-neutral-100 px-4 py-2 text-sm focus:ring-2 focus:ring-blue-600/50 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-neutral-300">Description</label>
                        <input id="modal_description" type="text" name="description"
                            class="w-full rounded-lg border border-neutral-600 bg-neutral-800 text-neutral-100 px-4 py-2 text-sm focus:ring-2 focus:ring-blue-600/50 focus:border-blue-500">
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeCategoryEditor()"
                        class="px-4 py-2 border border-neutral-600 text-neutral-300 rounded-lg text-sm hover:bg-neutral-700 transition">
                        Cancel
                    </button>

                    <button type="submit"
                        class="px-4 py-2 bg-blue-700 text-white rounded-lg text-sm hover:bg-blue-800 transition shadow">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Script --}}
    <script>
        const modal = document.getElementById('categoryModal');

        function openCategoryEditor(id, name, desc) {
            desc = desc ?? '';

            document.getElementById('modal_name').value = name ?? '';
            document.getElementById('modal_description').value = desc;

            document.getElementById('categoryEditForm').action =
                "{{ route('categories.update', ':id') }}".replace(':id', id);

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeCategoryEditor() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>

</x-layouts.app>
