<template>
    <div class="bg-gray-100 min-h-screen flex items-center justify-center px-6">
        <div class="text-center">
            <h1 class="text-9xl font-extrabold text-gray-800">403</h1>
            <p class="text-2xl md:text-3xl font-semibold mt-6 text-gray-600">
                Access Denied
            </p>
            <p class="mt-4 text-gray-500">
                You don’t have the required permissions to view this page.
            </p>
            <RouterLink
                to="/"
                class="inline-block mt-6 px-6 py-3 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition"
            >
                Go Back Home
            </RouterLink>
        </div>
    </div>
</template>

<script setup></script>
