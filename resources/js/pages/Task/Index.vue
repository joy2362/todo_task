<template>
    <div class="p-4">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Task List</h1>
            <router-link
                :to="{ name: 'task.create' }"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
            >
                + New Task
            </router-link>
        </div>

        <table class="w-full text-left border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">Title</th>
                    <th class="p-2 border">Status</th>
                    <th class="p-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="task in tasks" :key="task.id" class="border-t">
                    <td class="p-2 border">{{ task.title }}</td>
                    <td class="p-2 border">{{ task.status }}</td>
                    <td class="p-2 border space-x-2">
                        <router-link
                            :to="`/task/${task.id}`"
                            class="text-blue-600 hover:underline"
                            >View</router-link
                        >
                        <router-link
                            :to="`/task/${task.id}/edit`"
                            class="text-yellow-600 hover:underline"
                            >Edit</router-link
                        >
                        <button
                            @click="deleteTask(task.id)"
                            class="text-red-600 hover:underline"
                        >
                            Delete
                        </button>
                        <button
                            v-if="task.status !== 'completed'"
                            @click="markAsActive(task.id)"
                            class="text-green-600 hover:underline"
                        >
                            Mark Active
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="mt-4 flex justify-center space-x-2">
            <button
                :disabled="pagination.current_page === 1"
                @click="changePage(pagination.current_page - 1)"
                class="px-3 py-1 border rounded hover:bg-gray-200 disabled:opacity-50"
            >
                Prev
            </button>

            <button
                v-for="page in pagination.last_page"
                :key="page"
                @click="changePage(page)"
                :class="[
                    'px-3 py-1 border rounded',
                    page === pagination.current_page
                        ? 'bg-blue-500 text-white'
                        : 'hover:bg-gray-200',
                ]"
            >
                {{ page }}
            </button>

            <button
                :disabled="pagination.current_page === pagination.last_page"
                @click="changePage(pagination.current_page + 1)"
                class="px-3 py-1 border rounded hover:bg-gray-200 disabled:opacity-50"
            >
                Next
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";

const tasks = ref([]);
const pagination = ref({
    current_page: 1,
    last_page: 1,
});

onMounted(async () => {
    await getData();
});

async function deleteTask(id) {
    try {
        const res = await axios.delete(`/api/v1/task/${id}`);
        push.success({
            title: "Success",
            message: res.data.message,
        });
        await getData(pagination.value.current_page);
    } catch (err) {
        console.log(err);
        push.error({
            title: "Failed",
            message: "Something went wrong!",
        });
    }
}

async function markAsActive(id) {
    try {
        const res = await axios.get(`/api/v1/task/${id}/mark-as-complete`);
        push.success({
            title: "Success",
            message: res.data.message,
        });
        await getData(pagination.value.current_page);
    } catch (err) {
        console.log(err);
        push.error({
            title: "Failed",
            message: "Something went wrong!",
        });
    }
}

async function getData(page = 1) {
    try {
        const res = await axios.get(`/api/v1/task?page=${page}`);
        tasks.value = res.data.data;
        pagination.value = res.data.meta;
    } catch (err) {
        console.log(err);
        push.error({
            title: "Failed",
            message: "Something went wrong!",
        });
    }
}

function changePage(page) {
    if (
        page !== pagination.value.current_page &&
        page >= 1 &&
        page <= pagination.value.last_page
    ) {
        getData(page);
    }
}
</script>
