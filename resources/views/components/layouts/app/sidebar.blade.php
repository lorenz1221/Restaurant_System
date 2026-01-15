<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-[#f0f7ff] dark:bg-neutral-900">

    <!-- SIDEBAR -->
    <flux:sidebar sticky stashable
        class="border-e border-[#bcd9ff] bg-white dark:border-neutral-700 dark:bg-neutral-800 shadow-xl">

        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <!-- BRAND HEADER -->
        <div class="flex flex-col items-center text-center p-4 border-b border-[#bcd9ff] dark:border-neutral-700">
            <img src="https://cdn-icons-png.flaticon.com/512/3075/3075977.png"
                 alt="Restaurant System Logo"
                 class="h-20 w-20 rounded-full shadow-md mb-3 bg-blue-100 p-2">

            <span class="text-xl font-bold text-neutral-800 dark:text-white tracking-wide">
                Restaurant System
            </span>
        </div>

        <!-- NAVIGATION -->
        <flux:navlist variant="outline" class="p-3">
            <flux:navlist.group :heading="__('Menu')" class="grid">
                
                <flux:navlist.item
                    icon="home"
                    :href="route('dashboard')"
                    :current="request()->routeIs('dashboard')"
                    wire:navigate>
                    {{ __('Dashboard') }}
                </flux:navlist.item>

                <flux:navlist.item
                    icon="table-cells"
                    :href="route('categories')"
                    :current="request()->routeIs('categories')"
                    wire:navigate>
                    {{ __('Categories') }}
                </flux:navlist.item>

                <flux:navlist.item
                    icon="trash"
                    :href="route('menu-items.trash')"
                    :current="request()->routeIs('menu-items.trash')"
                    wire:navigate>
                    {{ __('Trash') }}
                </flux:navlist.item>

            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />

        <!-- DESKTOP USER MENU -->
        <flux:dropdown class="hidden lg:block" position="bottom" align="start">
            <flux:profile
                :name="auth()->user()->name"
                :initials="auth()->user()->initials()"
                icon:trailing="chevrons-up-down"
            />

            <flux:menu class="w-[230px]">

                <flux:menu.radio.group>
                    <div class="p-2 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5">

                            <div class="h-9 w-9 rounded-full bg-blue-600 text-white flex items-center justify-center">
                                {{ auth()->user()->initials() }}
                            </div>

                            <div>
                                <span class="block font-semibold">{{ auth()->user()->name }}</span>
                                <span class="text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                        {{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item
                        as="button"
                        type="submit"
                        icon="arrow-right-start-on-rectangle"
                        class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>

    </flux:sidebar>

    <!-- MOBILE HEADER -->
    <flux:header class="lg:hidden bg-white dark:bg-neutral-900 border-b border-[#bcd9ff] dark:border-neutral-700">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <span class="font-semibold text-neutral-900 dark:text-white ml-3">
            Restaurant System
        </span>

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile
                :initials="auth()->user()->initials()"
                icon-trailing="chevron-down"
            />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-2">
                        <div class="flex items-center gap-2 px-1 py-1.5">
                            <div class="h-9 w-9 rounded-full bg-blue-600 text-white flex items-center justify-center">
                                {{ auth()->user()->initials() }}
                            </div>
                            <div>
                                <strong class="block">{{ auth()->user()->name }}</strong>
                                <span class="text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                        {{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    <!-- MAIN CONTENT -->
    {{ $slot }}

    @fluxScripts
</body>
</html>
