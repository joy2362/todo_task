<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav
                class="bg-white shadow px-6 py-4 flex justify-between items-center"
            >
                <h1 class="text-xl font-bold">Task Manager</h1>
                <div class="space-x-4">
                    <router-link
                        :to="{ name: 'task' }"
                        class="text-blue-600 hover:underline"
                        >Tasks</router-link
                    >
                    <button
                        @click="logout"
                        class="text-red-600 hover:underline"
                    >
                        Logout
                    </button>
                </div>
            </nav>

            <main class="p-6">
                <router-view></router-view>
            </main>
        </div>
    </div>
</template>

<script setup>
import { useUserStore } from "@/store/user";
const userStore = useUserStore();

async function logout() {
    await axios.get("/api/v1/logout");
    userStore.logout();
    location.reload();
}
</script>
