<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verdant Sandbox — @yield('title', 'Demo')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fonts
    @verdantAssets
</head>
<body
    x-data="{ dark: localStorage.getItem('verdant-sandbox-theme') === 'dark' }"
    x-init="$watch('dark', v => localStorage.setItem('verdant-sandbox-theme', v ? 'dark' : 'light'))"
    :data-theme="dark ? 'dark' : 'light'"
    class="v-bg-gray-50 dark:v-bg-gray-900 v-min-h-screen font-['Karla']"
>
    <div class="v-max-w-7xl v-mx-auto v-p-6">
        <div class="v-flex v-items-center v-justify-between v-mb-6">
            <div>
                <h1 class="v-text-xl v-font-semibold v-text-gray-900 dark:v-text-gray-100">Verdant Sandbox</h1>
                <p class="v-text-sm v-text-gray-500 dark:v-text-gray-400">
                    Live playground for verdant-ui, linked straight from <code>../verdant-ui</code>.
                </p>
            </div>

            <button type="button" @click="dark = !dark"
                class="v-text-sm v-border v-border-gray-300 dark:v-border-gray-600 v-rounded v-px-3 v-py-1.5 v-text-gray-700 dark:v-text-gray-300 hover:v-bg-gray-100 dark:hover:v-bg-gray-800"
            >
                <i class="fas" :class="dark ? 'fa-sun' : 'fa-moon'"></i>
                <span x-text="dark ? 'Light mode' : 'Dark mode'"></span>
            </button>
        </div>

        @if(session('status'))
            <div class="v-mb-4 v-rounded v-border v-border-green-300 dark:v-border-green-700 v-bg-green-50 dark:v-bg-green-900/20 v-text-green-800 dark:v-text-green-200 v-px-4 v-py-2 v-text-sm">
                {{ session('status') }}
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>
