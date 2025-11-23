{{-- Image reference (uploaded by user): /mnt/data/50df9686-4b29-4eff-be35-4f9cd7455033.png --}}

<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        @if (session('success'))
            <div id="success-message"
                 class="rounded-lg bg-amber-500/10 p-4 text-sm text-amber-700 dark:bg-amber-900/20 dark:text-amber-300"
                 role="alert">
                {{ session('success') }}
            </div>

            <script>
                setTimeout(() => {
                    const msg = document.getElementById('success-message');
                    if (msg) {
                        msg.classList.add('opacity-0', 'scale-95');
                        setTimeout(() => msg.remove(), 500);
                    }
                }, 3000);
            </script>

        @endif
        @if (session('error'))
            <div class="rounded-lg bg-red-500/10 p-4 text-sm text-red-700 dark:bg-red-900/20 dark:text-red-300" role="alert">
                {{ session('error') }}
            </div>
        @endif


        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative overflow-hidden rounded-xl border border-neutral-700 bg-gradient-to-br from-neutral-900 to-neutral-800 p-6 shadow-lg hover:shadow-2xl transition-transform transform hover:scale-[1.01]">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-400">Total Menu Items</p>
                        <h3 class="mt-2 text-3xl font-extrabold text-amber-300">{{ number_format($totalItems) }}</h3>
                        <div class="mt-2 text-sm text-neutral-400">Classic Burgers, Cheese Burgers, Premium Burgers, Drinks</div>
                    </div>
                    <div class="rounded-full bg-amber-600/10 p-3">
                        <svg class="h-6 w-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-xl border border-neutral-700 bg-gradient-to-br from-neutral-900 to-neutral-800 p-6 shadow-lg hover:shadow-2xl transition-transform transform hover:scale-[1.01]">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-400">Active Categories</p>
                        <h3 class="mt-2 text-3xl font-extrabold text-amber-300">{{ number_format($totalCategories) }}</h3>
                        <div class="mt-2 text-sm text-neutral-400">Classic Burgers, Cheese Burgers, Premium Burgers, Soft Drinks, Bottled Water, Milkshakes</div>
                    </div>
                    <div class="rounded-full bg-amber-600/10 p-3">
                        <svg class="h-6 w-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-xl border border-neutral-700 bg-gradient-to-br from-neutral-900 to-neutral-800 p-6 shadow-lg hover:shadow-2xl transition-transform transform hover:scale-[1.01]">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-400">Avg. Menu Price</p>
                        <h3 class="mt-2 text-3xl font-extrabold text-amber-300">₱{{ number_format($averagePrice, 2) }}</h3>
                        <div class="mt-2 text-sm text-neutral-400">Calculated from all items — range: ₱{{ number_format($minPrice ?? 0, 2) }} - ₱{{ number_format($maxPrice ?? 0, 2) }}</div>
                    </div>
                    <div class="rounded-full bg-amber-600/10 p-3">
                        <svg class="h-6 w-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-700 bg-neutral-900/40 p-0">
            <div class="flex h-full flex-col p-6 gap-6">

                <div class="mb-6 rounded-lg border border-neutral-700/60 bg-gradient-to-br from-neutral-800/60 to-neutral-900/60 p-6">
                    <h2 class="text-lg font-semibold text-amber-300">Add New Item</h2>
                    <p class="mb-4 mt-1 text-sm text-neutral-400">Fill out the details below to add a new menu item.</p>
                    <form action="{{ route('menu-items.store') }}" method="POST" class="grid gap-4 md:grid-cols-2">
                        @csrf
                        <div>
                            <label for="add_name" class="mb-2 block text-sm font-medium text-neutral-300">Name</label>
                            <input id="add_name" name="name" type="text" value="{{ old('name') }}" placeholder="e.g., Double Classic Burger" required autofocus
                                   class="w-full rounded-lg border border-neutral-700 bg-neutral-900 px-4 py-2 text-sm text-neutral-100 focus:ring-2 focus:ring-amber-400 focus:border-amber-400">
                            @error('name')
                                <p class="mt-2 text-sm text-red-500 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="add_price" class="mb-2 block text-sm font-medium text-neutral-300">Price (₱)</label>
                            <input id="add_price" name="price" type="number" value="{{ old('price') }}" placeholder="e.g., 99.99" required
                                   class="w-full rounded-lg border border-neutral-700 bg-neutral-900 px-4 py-2 text-sm text-neutral-100 focus:ring-2 focus:ring-amber-400 focus:border-amber-400">
                            @error('price')
                                <p class="mt-2 text-sm text-red-500 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="add_category" class="mb-2 block text-sm font-medium text-neutral-300">Food Category</label>
                            <select id="add_category" name="category_id" class="w-full rounded-lg border border-neutral-700 bg-neutral-900 px-4 py-2 text-sm text-neutral-100 focus:ring-2 focus:ring-amber-400 focus:border-amber-400">
                                <option value="" disabled selected>Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-2 text-sm text-red-500 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="add_description" class="mb-2 block text-sm font-medium text-neutral-300">Description</label>
                            <input id="add_description" name="description" type="text" value="{{ old('description') }}" placeholder="Add an optional description…" 
                                   class="w-full rounded-lg border border-neutral-700 bg-neutral-900 px-4 py-2 text-sm text-neutral-100 focus:ring-2 focus:ring-amber-400 focus:border-amber-400">
                            @error('description')
                                <p class="mt-2 text-sm text-red-500 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <button type="submit" class="rounded-lg bg-amber-500 px-6 py-2 text-sm font-semibold text-black hover:bg-amber-400 shadow-md transition">Add Item</button>
                        </div>
                    </form>
                </div>

                <div class="flex-1 overflow-auto rounded-lg border border-neutral-700 bg-neutral-900/30 p-4">
                    <h2 class="mb-4 text-lg font-semibold text-amber-300">Menu Overview</h2>
                    <div class="overflow-x-auto rounded-lg">
                        <table class="w-full min-w-full rounded-lg">
                            <thead>
                                <tr class="border-b border-neutral-700 bg-neutral-800/60">
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-400">#</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-400">Item Name</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-400">Price</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-400">Description</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-400">Options</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-700">
                                @forelse($menuItems as $menuItem)
                                    <tr class="transition-colors hover:bg-neutral-800/30 even:bg-neutral-900/20 odd:bg-neutral-900/10">
                                        <td class="px-4 py-3 text-sm text-neutral-300">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 text-sm font-medium text-neutral-100">{{ $menuItem->name }}</td>
                                        <td class="px-4 py-3 text-sm text-neutral-300">₱{{ number_format($menuItem->price, 2) }}</td>
                                        <td class="px-4 py-3 text-sm text-neutral-300">{{ $menuItem->description ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-sm flex items-center gap-3">
                                            <button
                                                onclick='editMenuItems({{ $menuItem->id }}, @json($menuItem->name), @json($menuItem->price), @json($menuItem->description), @json($menuItem->category_id))'
                                                class="text-amber-400 hover:text-amber-300 transition">
                                                Edit
                                            </button>
                                            <span class="text-neutral-500">|</span>
                                            <form action="{{ route('menu-items.destroy', $menuItem) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this menu item?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-300 transition">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-8 text-center text-sm text-neutral-500">
                                            No menu items yet. Add your first item above!
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

    {{-- Edit Menu Modal --}}
    <div id="editMenuModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-sm">
        <div class="w-full max-w-2xl rounded-2xl border border-neutral-700 bg-neutral-900 p-6 shadow-2xl">
            <h2 class="mb-4 text-lg font-semibold text-amber-300">Edit Item</h2>

            <form id="editMenuForm" method="POST">
                @csrf
                @method('PUT')

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-300">Item Name</label>
                        <input type="text" id="edit_name" name="name" required
                               class="w-full rounded-lg border border-neutral-700 bg-neutral-900 px-4 py-2 text-sm text-neutral-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-300">Item Price</label>
                        <input type="number" id="edit_price" name="price" step="0.01" required
                               class="w-full rounded-lg border border-neutral-700 bg-neutral-900 px-4 py-2 text-sm text-neutral-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-300">Description</label>
                        <input type="text" id="edit_description" name="description"
                               class="w-full rounded-lg border border-neutral-700 bg-neutral-900 px-4 py-2 text-sm text-neutral-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-300">Food Category</label>
                        <select id="edit_category_id" name="category_id" required
                                class="w-full rounded-lg border border-neutral-700 bg-neutral-900 px-4 py-2 text-sm text-neutral-100">
                            <option value="">Select a category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeEditMenuModal()"
                            class="rounded-lg border border-neutral-700 px-4 py-2 text-sm font-medium text-neutral-300 hover:bg-neutral-800">
                        Cancel
                    </button>

                    <button type="submit"
                            class="rounded-lg bg-amber-500 px-4 py-2 text-sm font-medium text-black hover:bg-amber-400">
                        Save Item
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
