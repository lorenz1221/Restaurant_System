<x-layouts.app :title="__('Category Management')">
    <div class="flex flex-col h-full w-full gap-5 rounded-xl">

        {{-- Flash Messages --}}
        @if (session('success'))
            <div id="flash-success"
                class="rounded-lg bg-emerald-500/15 p-4 text-sm text-emerald-300 dark:bg-emerald-900/40 dark:text-emerald-200 shadow border border-emerald-700/50 animate-fadeIn">
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
            <div class="rounded-lg bg-red-500/15 p-4 text-sm text-red-300 dark:bg-red-900/40 dark:text-red-200 shadow border border-red-700/50 animate-fadeIn">
                {{ session('error') }}
            </div>
        @endif


        <div class="flex-1 overflow-hidden rounded-xl border border-neutral-700 bg-neutral-900 shadow-xl">
            <div class="h-full flex flex-col gap-8 p-8">

                {{-- Create Category Form --}}
                <section
                    class="rounded-xl border border-neutral-700 bg-gradient-to-br from-neutral-800 to-neutral-900 p-6 shadow-md">
                    <h2 class="text-xl font-semibold text-yellow-300 mb-4 flex items-center gap-2">
                        🍔 Create New Category
                    </h2>

                    <form method="POST" action="{{ route('categories.store') }}" class="grid gap-5 sm:grid-cols-2">
                        @csrf

                        {{-- Category Name --}}
                        <div class="flex flex-col">
                            <label class="text-sm font-medium text-neutral-300 mb-1">
                                Category Name
                            </label>
                            <input
                                id="category_name"
                                name="name"
                                type="text"
                                value="{{ old('name') }}"
                                placeholder="e.g., Classic Burgers, Drinks..."
                                required
                                class="rounded-lg border border-neutral-600 bg-neutral-900 px-4 py-2.5 text-sm text-neutral-100 focus:ring-2 focus:ring-yellow-400/50 focus:border-yellow-400 transition-all shadow-inner"
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
                                class="rounded-lg border border-neutral-600 bg-neutral-900 px-4 py-2.5 text-sm text-neutral-100 focus:ring-2 focus:ring-yellow-400/50 focus:border-yellow-400 transition-all shadow-inner"
                            >
                        </div>

                        <div class="sm:col-span-2">
                            <button
                                type="submit"
                                class="px-6 py-2.5 rounded-lg bg-yellow-500 text-sm font-semibold text-black hover:bg-yellow-400 focus:ring-2 focus:ring-yellow-300 transition-all shadow-md">
                                Save Category
                            </button>
                        </div>
                    </form>
                </section>

                {{-- Category Table --}}
                <section class="flex-1 overflow-auto">
                    <h2 class="text-xl font-semibold text-neutral-100 mb-4 flex items-center gap-2">
                        📋 All Categories
                    </h2>

                    <div class="overflow-x-auto rounded-xl border border-neutral-700 shadow-lg">
                        <table class="w-full min-w-max">
                            <thead>
                                <tr class="bg-neutral-800/80 border-b border-neutral-700">
                                    <th class="p-3 text-left text-xs font-semibold text-neutral-400 uppercase tracking-wide">#</th>
                                    <th class="p-3 text-left text-xs font-semibold text-neutral-400 uppercase tracking-wide">Name</th>
                                    <th class="p-3 text-left text-xs font-semibold text-neutral-400 uppercase tracking-wide">Description</th>
                                    <th class="p-3 text-left text-xs font-semibold text-neutral-400 uppercase tracking-wide">Items</th>
                                    <th class="p-3 text-left text-xs font-semibold text-neutral-400 uppercase tracking-wide">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-neutral-700">
                                @forelse ($categories as $row)
                                    <tr class="hover:bg-neutral-800/60 transition">
                                        <td class="p-3 text-sm text-neutral-300">{{ $loop->iteration }}</td>

                                        <td class="p-3 text-sm font-medium text-neutral-100">
                                            {{ $row->name }}
                                        </td>

                                        <td class="p-3 text-sm text-neutral-400">
                                            {{ trim($row->description ?? '') !== '' ? $row->description : '—' }}
                                        </td>

                                        <td class="p-3 text-sm text-neutral-300">{{ $row->menu_items_count }}</td>

                                        <td class="p-3 text-sm flex gap-4 items-center">

                                            {{-- Edit --}}
                                            <button
                                                class="text-blue-400 hover:text-blue-300 font-medium transition"
                                                onclick='openCategoryEditor({{ $row->id }}, {!! json_encode($row->name) !!}, {!! json_encode($row->description ?? "") !!})'>
                                                Edit
                                            </button>

                                            {{-- Delete --}}
                                            <form action="{{ route('categories.destroy', $row) }}" method="POST"
                                                onsubmit="return confirm('Delete this category?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    class="text-red-400 hover:text-red-300 font-medium transition">
                                                    Delete
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-6 text-center text-sm text-neutral-500">
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
    <div id="categoryModal"
         class="fixed inset-0 bg-black/70 hidden z-50 items-center justify-center backdrop-blur-sm">
        <div class="w-full max-w-xl rounded-2xl bg-neutral-900 border border-neutral-700 p-6 shadow-2xl animate-scaleIn">
            <h2 class="text-lg font-semibold mb-4 text-yellow-300">Update Category</h2>

            <form id="categoryEditForm" method="POST">
                @csrf
                @method('PUT')

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-neutral-300">Name</label>
                        <input id="modal_name" type="text" name="name" required
                            class="w-full rounded-lg border border-neutral-600 bg-neutral-800 text-neutral-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-yellow-400/50 focus:border-yellow-400 shadow-inner">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-neutral-300">Description</label>
                        <input id="modal_description" type="text" name="description"
                            class="w-full rounded-lg border border-neutral-600 bg-neutral-800 text-neutral-100 px-4 py-2.5 text-sm focus:ring-2 focus:ring-yellow-400/50 focus:border-yellow-400 shadow-inner">
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeCategoryEditor()"
                        class="px-4 py-2 border border-neutral-600 text-neutral-300 rounded-lg text-sm hover:bg-neutral-800 transition">
                        Cancel
                    </button>

                    <button type="submit"
                        class="px-4 py-2 bg-yellow-500 text-black rounded-lg text-sm font-semibold hover:bg-yellow-400 transition shadow">
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
