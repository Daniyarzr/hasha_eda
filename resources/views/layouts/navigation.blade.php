<nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center gap-6">
                <a href="{{ route('dashboard') }}" class="font-semibold text-gray-800 dark:text-gray-200">
                    Наша Еда
                </a>

                <a
                    href="{{ route('dashboard') }}"
                    class="text-sm {{ request()->routeIs('dashboard') ? 'text-gray-900 dark:text-gray-100 font-medium' : 'text-gray-500 dark:text-gray-400' }}"
                >
                    {{ __('Dashboard') }}
                </a>
            </div>

            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->name }}</span>

                <a href="{{ route('profile.edit') }}" class="text-sm text-gray-700 dark:text-gray-300 hover:underline">
                    {{ __('Profile') }}
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-gray-700 dark:text-gray-300 hover:underline">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
