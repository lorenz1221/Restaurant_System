<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        @if (session('success'))
            <div id="success-message" class="rounded-lg bg-green-100 p-4 text-sm text-green-800 dark:bg-green-900 dark:text-green-300" role="alert">
                {{ session('success') }}
            </div>

            <script>
                setTimeout(() => {
                    const msg = document.getElementById('success-message');
                    if (msg) {
                        msg.classList.add('opacity-0');
                        setTimeout(() => msg.remove(), 500);
                    }
                }, 3000);
            </script>

        @endif
        @if (session('error'))
            <div class="rounded-lg bg-red-100 p-4 text-sm text-red-800 dark:bg-red-900 dark:text-red-300" role="alert">
                {{ session('error') }}
            </div>
        @endif


        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Total Menu Items</p>
                        <h3 class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ number_format($totalItems) }}</h3>
                        <div class="mt-2 text-sm text-neutral-500 dark:text-neutral-400">Main Dishes, Sides, Desserts</div>
                    </div>
                    <div class="rounded-full bg-blue-100 p-3 dark:bg-blue-900/30">
                        <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Active Categories</p>
                        <h3 class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ number_format($totalCategories) }}</h3>
                        <div class="mt-2 text-sm text-neutral-500 dark:text-neutral-400">Appetizers, Mains, Drinks, etc.</div>
                    </div>
                    <div class="rounded-full bg-green-100 p-3 dark:bg-green-900/30">
                        <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Avg. Menu Price</p>
                        <h3 class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">₱{{ number_format($averagePrice, 2) }}</h3>
                        <div class="mt-2 text-sm text-neutral-500 dark:text-neutral-400">Calculated from all items</div>
                    </div>
                    <div class="rounded-full bg-purple-100 p-3 dark:bg-purple-900/30">
                        <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-900">
            <div class="flex h-full flex-col p-6">

                <div class="mb-6 rounded-lg border border-blue-200 bg-blue-50 p-6 dark:border-neutral-700 dark:bg-neutral-800/60">
                    <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Add a New Dish</h2>
                    <p class="mb-4 mt-1 text-sm text-gray-600 dark:text-gray-400">Fill out the details below to add a new dish to your menu.</p>
                    <form action="{{ route('menu-items.store') }}" method="POST" class="grid gap-4 md:grid-cols-2">
                        @csrf
                        <div>
                            <label for="add_name" class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Dish Name</label>
                            <input id="add_name" name="name" type="text" value="{{ old('name') }}" placeholder="Dish Name" required autofocus class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="add_price" class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Price (₱)</label>
                            <input id="add_price" name="price" type="number" value="{{ old('price') }}" placeholder="e.g., 99.99" required class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm">
                            @error('price')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="add_category" class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Food Category</label>
                            <select id="add_category" name="category_id" class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm">
                                <option value="" disabled selected>Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="add_description" class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Description</label>
                            <input id="add_description" name="description" type="text" value="{{ old('description') }}" placeholder="Add an optional description…" class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm">
                            @error('description')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <button type="submit" class="rounded-lg bg-blue-600 px-6 py-2 text-sm font-medium text-white hover:bg-blue-700">Add Dish</button>
                        </div>
                    </form>
                </div>

                <div class="flex-1 overflow-auto rounded-lg border border-neutral-200 bg-white p-4 dark:border-neutral-700 dark:bg-neutral-800">
                    <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Menu Overview</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-full">
                            <thead>
                                <tr class="border-b border-neutral-200 bg-blue-100 dark:border-neutral-700 dark:bg-neutral-900/50">
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">#</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Dish Name</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Price</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Description</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Options</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                                @forelse($menuItems as $menuItem)
                                    <tr class="transition-colors hover:bg-blue-50 dark:hover:bg-neutral-700/40">
                                        <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 text-sm text-neutral-900 dark:text-neutral-100">{{ $menuItem->name }}</td>
                                        <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">₱{{ number_format($menuItem->price, 2) }}</td>
                                        <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">{{ $menuItem->description ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-sm flex">
                                            <button
                                                onclick='editMenuItems({{ $menuItem->id }}, @json($menuItem->name), @json($menuItem->price), @json($menuItem->description), @json($menuItem->category_id))'
                                                class="text-blue-600 transition-colors hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                                Edit
                                            </button>
                                            <span class="mx-1 text-neutral-400">|</span>
                                            <form action="{{ route('menu-items.destroy', $menuItem) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this dish?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 transition-colors hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-8 text-center text-sm text-neutral-500 dark:text-neutral-400">
                                            No dishes listed yet. Add your first dish above!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="editMenuModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
        <div class="w-full max-w-2xl rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
            <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Edit Dish</h2>

            <form id="editMenuForm" method="POST">
                @csrf
                @method('PUT')

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Dish Name</label>
                        <input type="text" id="edit_name" name="name" required
                               class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Dish Price</label>
                        <input type="number" id="edit_price" name="price" step="0.01" required
                               class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Description</label>
                        <input type="text" id="edit_description" name="description"
                               class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Food Category</label>
                        <select id="edit_category_id" name="category_id" required
                                class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm">
                            <option value="">Select a category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeEditMenuModal()"
                            class="rounded-lg border border-neutral-300 px-4 py-2 text-sm font-medium text-neutral-700 hover:bg-neutral-100 dark:border-neutral-600 dark:text-neutral-300 dark:hover:bg-neutral-700">
                        Cancel
                    </button>

                    <button type="submit"
                            class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                        Save Dish
                    </button>
                </div>
            </form>
        </div>
    </div>


<script>
    function editMenuItems(id, name, price, description, categoryId) {
        const modal = document.getElementById('editMenuModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        document.getElementById('editMenuForm').action = `/menu-items/${id}`;

        document.getElementById('edit_name').value = name;
        document.getElementById('edit_price').value = price;
        document.getElementById('edit_description').value = description ?? '';
        document.getElementById('edit_category_id').value = categoryId ?? '';
    }

    function closeEditMenuModal() {
        const modal = document.getElementById('editMenuModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>

</x-layouts.app>