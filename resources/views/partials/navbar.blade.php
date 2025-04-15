<nav class="bg-white shadow-sm border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <!-- Left: Sidebar Trigger + Search -->
        <div class="flex items-center gap-4">
            <button class="text-gray-500 focus:outline-none">
                <i class="fas fa-bars"></i>
            </button>

        </div>

        <!-- Right: Notifications + User Info -->
        <div class="flex items-center gap-6">

            <!-- User Info + Dropdown -->
            <div class="relative">
                @if(Auth::check())
                    <button id="userDropdownButton" class="flex items-center gap-2 focus:outline-none">
                        <div class="bg-gray-200 text-gray-700 rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <div class="text-left">
                            <h4 class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</h4>
                            <p class="text-xs text-gray-500">Administrator</p>
                        </div>
                    </button>

                    <!-- Dropdown -->
                    <div id="userDropdownMenu" class="hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg border z-50">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-gray-100">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="flex items-center gap-2 text-gray-700 hover:text-gray-900">
                        <div class="bg-gray-200 text-gray-700 rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold">
                            <i class="bi bi-person-circle text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-gray-800">Login</h4>
                        </div>
                    </a>
                @endif
            </div>
        </div>
    </div>
</nav>

<!-- JS Dropdown Handler -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const button = document.getElementById('userDropdownButton');
        const menu = document.getElementById('userDropdownMenu');

        if (button && menu) {
            button.addEventListener('click', function (event) {
                event.stopPropagation();
                menu.classList.toggle('hidden');
            });

            window.addEventListener('click', function () {
                if (!menu.classList.contains('hidden')) {
                    menu.classList.add('hidden');
                }
            });
        }
    });
</script>
