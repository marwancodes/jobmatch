<nav class="w-[250px] h-screen bg-white border-r border-gray-200">
    {{-- Application Logo --}}
    <div class="flex items-center px-6 py-4 border-b border-gray-200">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-2xl font-bold">
            <x-application-logo class="w-auto h-6 text-gray-800 fill-current" />
            <span class="text-lg font-semibold text-gray-800">Job Match</span>
        </a>
    </div>

    {{-- Navigation Links --}}
    <ul class="flex flex-col px-4 py-6 space-y-2">
        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
            Dashboard
        </x-nav-link>

        @if (auth()->user()->role == 'admin')
        <x-nav-link href="{{ route('companies.index') }}" :active="request()->routeIs('companies.index')">
            Companies
        </x-nav-link>
        @endif

        @if (auth()->user()->role == 'company-owner')
        <x-nav-link href="{{ route('my-company.show') }}" :active="request()->routeIs('my-company.show')">
            My Company
        </x-nav-link>
        @endif

        <x-nav-link href="{{ route('job-applications.index') }}" :active="request()->routeIs('job-applications.index')">
            Job Applications
        </x-nav-link>

        @if (auth()->user()->role == 'admin')
        <x-nav-link href="{{ route('job-categories.index') }}" :active="request()->routeIs('job-categories.index')">
            Job Categories
        </x-nav-link>
        @endif

        <x-nav-link href="{{ route('job-vacancies.index') }}" :active="request()->routeIs('job-vacancies.index')">
            Job Vacancies
        </x-nav-link>

        @if (auth()->user()->role == 'admin')
        <x-nav-link href="{{ route('users.index') }}" :active="request()->routeIs('user.index')">
            Users
        </x-nav-link>
        @endif

        <hr />

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout')}}">
            @csrf
            <x-nav-link href="{{ route('logout') }}" :active="false" class="text-red-600" onclick="event.preventDefault(); this.closest('form').submit();">
                Logout
            </x-nav-link>
        </form>

    </ul>

</nav>