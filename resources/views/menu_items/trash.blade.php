<x-layouts.app :title="__('Trash')">
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

        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-700 bg-neutral-900/40 p-0">
            <div class="flex h-full flex-col p-6 gap-6">

                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-amber-300">Trash - Soft Deleted Items</h2>
                    <a href="{{ route('dashboard') }}" class="rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-black hover:bg-amber-400 transition">Back to Dashboard</a>
                </div>

                <div class="flex-1 overflow-auto rounded-lg border border-neutral-700 bg-neutral-900/30 p-4">
                    <div class="overflow-x-auto rounded-lg">
                        <table class="w-full min-w-full rounded-lg">
                            <thead>
                                <tr class="border-b border-neutral-700 bg-neutral-800/60">
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-400">#</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-400">Photo</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-400">Item Name</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-400">Price</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-400">Description</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-400">Options</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-700">
                                @forelse($trashedItems as $menuItem)
                                    <tr class="transition-colors hover:bg-neutral-800/30 even:bg-neutral-900/20 odd:bg-neutral-900/10">
                                        <td class="px-4 py-3 text-sm text-neutral-300">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 text-sm">
                                            @if($menuItem->photo)
                                                <img src="{{ asset('storage/' . $menuItem->photo) }}" alt="{{ $menuItem->name }}" class="w-10 h-10 rounded-full object-cover">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-amber-500 flex items-center justify-center text-white font-semibold text-xs">
                                                    {{ strtoupper(substr($menuItem->name, 0, 1)) }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm font-medium text-neutral-100">{{ $menuItem->name }}</td>
                                        <td class="px-4 py-3 text-sm text-neutral-300">₱{{ number_format($menuItem->price, 2) }}</td>
                                        <td class="px-4 py-3 text-sm text-neutral-300">{{ $menuItem->description ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-sm flex items-center gap-3">
                                            <form action="{{ route('menu-items.restore', $menuItem->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-green-400 hover:text-green-300 transition">Restore</button>
                                            </form>
                                            <span class="text-neutral-500">|</span>
                                            <form action="{{ route('menu-items.force-delete', $menuItem->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this item? This action cannot be undone.')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-300 transition">Delete Forever</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-8 text-center text-sm text-neutral-500">
                                            No items in trash. All items are active!
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
</x-layouts.app>
