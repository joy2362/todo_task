<template>
    <AuthLayout>
        <div class="text-center">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Login</h2>

            <form @submit.prevent="submitForm">
                <div class="mb-4">
                    <label for="username" class="block text-gray-700"
                        >Email</label
                    >
                    <input
                        type="email"
                        id="email"
                        v-model="email"
                        class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter your email"
                        required
                    />
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-gray-700"
                        >Password</label
                    >
                    <input
                        type="password"
                        id="password"
                        v-model="password"
                        class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter your password"
                        required
                    />
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-between">
                    <button
                        type="submit"
                        class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        Login
                    </button>
                </div>
            </form>
            <div class="mt-4 text-center">
                <p>
                    New here?
                    <router-link
                        to="/register"
                        class="text-blue-600 hover:underline"
                        >Register here</router-link
                    >
                </p>
            </div>
        </div>
    </AuthLayout>
</template>

<script setup>
import { ref } from "vue";
import AuthLayout from "@/layouts/AuthLayout.vue";
import { useUserStore } from "@/store/user";
import { useRouter } from "vue-router";

const router = useRouter();
const userStore = useUserStore();

const email = ref("");
const password = ref("");

const submitForm = async () => {
    try {
        const res = await axios.post("/api/v1/login", {
            email: email.value,
            password: password.value,
        });

        userStore.setData(res.data);

        router.push("/");
    } catch (err) {
        console.log(err);
        push.error({
            title: "Failed",
            message: "Something went wrong!",
        });
    }
};
</script>
