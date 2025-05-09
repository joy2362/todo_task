<template>
    <AuthLayout>
        <div class="text-center">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Register</h2>

            <form @submit.prevent="submitForm">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Name</label>
                    <input
                        type="text"
                        id="name"
                        v-model="name"
                        class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter your name"
                        required
                    />
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input
                        type="text"
                        id="email"
                        v-model="email"
                        class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter your email"
                        required
                    />
                </div>

                <div class="mb-4">
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

                <div class="mb-6">
                    <label for="confirmPassword" class="block text-gray-700"
                        >Confirm Password</label
                    >
                    <input
                        type="password"
                        id="confirmPassword"
                        v-model="confirmPassword"
                        class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Confirm your password"
                        required
                    />
                </div>

                <div class="flex items-center justify-between">
                    <button
                        type="submit"
                        class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        Register
                    </button>
                </div>
            </form>

            <div class="mt-4 text-center">
                <p>
                    Already have an account?
                    <router-link
                        :to="{ name: 'login' }"
                        class="text-blue-600 hover:underline"
                        >Login here</router-link
                    >
                </p>
            </div>
        </div>
    </AuthLayout>
</template>

<script setup>
import { ref } from "vue";
import AuthLayout from "@/layouts/AuthLayout.vue";
import { useRouter } from "vue-router";

const router = useRouter();
const name = ref("");
const email = ref("");
const password = ref("");
const confirmPassword = ref("");

const submitForm = async () => {
    try {
        const res = await axios.post("/api/v1/register", {
            name: name.value,
            email: email.value,
            password: password.value,
            confirm_password: confirmPassword.value,
        });

        push.success({
            title: "Success",
            message: res.data.message,
        });

        router.push({ name: "login" });
    } catch (err) {
        console.log(err);
        push.error({
            title: "Failed",
            message: "Something went wrong!",
        });
    }
};
</script>
