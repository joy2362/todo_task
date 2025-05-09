<template>
    <div class="max-w-xl mx-auto p-4 bg-white shadow rounded">
        <h1 class="text-xl font-bold mb-4">Edit Task</h1>
        <TaskForm :task="task" submitText="Update" @submit="updateTask" />
    </div>
</template>

<script setup>
import TaskForm from "@/components/TaskForm.vue";
import { ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";

const route = useRoute();
const router = useRouter();
const task = ref({ title: "", body: "", status: "" });

onMounted(async () => {
    await getData();
});

async function getData() {
    try {
        const res = await axios.get(`/api/v1/task/${route.params.id}`);
        task.value = res.data.data;
    } catch (err) {
        console.log(err);
        push.error({
            title: "Failed",
            message: "Something went wrong!",
        });
    }
}

async function updateTask() {
    try {
        const res = await axios.post(
            `/api/v1/task/${route.params.id}?_method=PUT`,
            task.value,
        );

        push.success({
            title: "Success",
            message: res.data.message,
        });

        router.push({ name: "task" });
    } catch (err) {
        console.log(err);
        push.error({
            title: "Failed",
            message: "Something went wrong!",
        });
    }
}
</script>
