<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin - {{ config('app.name') }}</title>
    <link
        href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css"
        rel="stylesheet"
    />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        #sidebar {
            transition: width 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex">

<!-- Sidebar -->
<aside
    id="sidebar"
    class="bg-white shadow-md border-r border-gray-200 h-screen fixed md:relative z-40 left-0 top-0 w-64 md:w-64"
>
    <div class="p-6 flex items-center justify-between border-b border-gray-200">
        <span class="text-xl font-bold text-blue-700">Laravel</span>
        <!-- Toggle sidebar button on desktop -->
        <button
            id="sidebarCollapseButton"
            class="hidden md:block focus:outline-none text-gray-600 hover:text-blue-600"
            aria-label="Toggle sidebar"
        >
            <!-- Double arrow icon -->
            <svg
                id="collapseIcon"
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 19l-7-7 7-7"
                />
            </svg>
            <svg
                id="expandIcon"
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 hidden"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 5l7 7-7 7"
                />
            </svg>
        </button>
    </div>
    <nav class="flex flex-col mt-6 space-y-2">
        <a
            href="/"
            class="px-6 py-3 hover:bg-blue-50 font-semibold rounded text-gray-800"
        >Dashboard</a
        >
        <a
            href="{{ route('admin.events.index') }}"
            class="px-6 py-3 hover:bg-blue-50 text-gray-700 rounded"
        >Events</a
        >
        <a
            href="{{ route('admin.sessions.index') }}"
            class="px-6 py-3 hover:bg-blue-50 text-gray-700 rounded"
        >Sessions</a
        >
        <a
            href="{{ route('admin.speakers.index') }}"
            class="px-6 py-3 hover:bg-blue-50 text-gray-700 rounded"
        >Speakers</a
        >
        <a
            href="{{ route('admin.tracks.index') }}"
            class="px-6 py-3 hover:bg-blue-50 text-gray-700 rounded"
        >Tracks</a
        >
    </nav>
</aside>

<!-- Overlay for mobile when sidebar visible -->
<div
    id="overlay"
    class="fixed inset-0 bg-black opacity-0 pointer-events-none z-30 md:hidden"
></div>

<!-- Main content -->
<div
    id="mainContent"
    class="flex-1 ml-0 md:ml-64 min-h-screen flex flex-col transition-all duration-300 ease"
>
    <!-- Navbar -->
    <header
        class="flex items-center justify-between bg-white shadow sticky top-0 z-20 px-6 h-16"
    >
        <!-- Hamburger button on mobile -->
        <button
            id="mobileSidebarToggle"
            class="md:hidden p-2 rounded flex items-center justify-center text-gray-700 hover:text-blue-600 focus:outline-none"
            aria-label="Open sidebar"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"
                />
            </svg>
        </button>

        <h1 class="text-lg font-semibold text-gray-800">Admin Panel</h1>

        <div class="flex items-center gap-3">
            <img
                src="/avatar.png"
                alt="profile"
                class="w-8 h-8 rounded-full border border-gray-300"
            />
            @auth
                <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
            @endauth
        </div>
    </header>

    <main class="flex-1 p-6 bg-white m-6 rounded shadow-lg">
        @if(session('success'))
            <div
                class="mb-4 p-3 rounded bg-green-100 text-green-800 shadow"
            >
                {{ session('success') }}</div
            >
        @endif

        @yield('content')
    </main>
</div>

<script>
    // Sidebar collapse toggle on desktop
    const sidebarCollapseButton = document.getElementById(
        "sidebarCollapseButton"
    );
    const sidebar = document.getElementById("sidebar");
    const mainContent = document.getElementById("mainContent");
    const collapseIcon = document.getElementById("collapseIcon");
    const expandIcon = document.getElementById("expandIcon");

    sidebarCollapseButton?.addEventListener("click", () => {
        if (sidebar.style.width === "64px" || sidebar.style.width === "4rem") {
            // Expand sidebar
            sidebar.style.width = "16rem"; // 64 in Tailwind
            mainContent.style.marginLeft = "16rem";
            collapseIcon.classList.remove("hidden");
            expandIcon.classList.add("hidden");
        } else {
            // Collapse sidebar to icons only widths
            sidebar.style.width = "4rem";
            mainContent.style.marginLeft = "4rem";
            collapseIcon.classList.add("hidden");
            expandIcon.classList.remove("hidden");
        }
    });

    // Mobile sidebar toggle
    const mobileSidebarToggle = document.getElementById("mobileSidebarToggle");
    const overlay = document.getElementById("overlay");

    mobileSidebarToggle?.addEventListener("click", () => {
        sidebar.classList.add("fixed", "z-50", "w-64", "left-0", "top-0", "block");
        sidebar.style.transform = "translateX(0)";
        overlay.classList.add("opacity-50", "pointer-events-auto");
        overlay.classList.remove("pointer-events-none");
        overlay.classList.remove("opacity-0");
    });

    overlay?.addEventListener("click", () => {
        sidebar.classList.remove("fixed", "z-50", "left-0", "top-0", "block");
        sidebar.style.transform = "translateX(-100%)";
        overlay.classList.remove("opacity-50", "pointer-events-auto");
        overlay.classList.add("pointer-events-none");
        overlay.classList.add("opacity-0");
    });
</script>
</body>
</html>
