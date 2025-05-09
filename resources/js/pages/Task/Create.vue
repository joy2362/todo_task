<template>
    <div class="max-w-xl mx-auto p-4 bg-white shadow rounded">
        <h1 class="text-xl font-bold mb-4">Create Task</h1>
        <TaskForm :task="task" submitText="Create" @submit="createTask" />
    </div>
</template>

<script setup>
import TaskForm from "@/components/TaskForm.vue";
import { ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();
const task = ref({ title: "", body: "" });

async function createTask() {
    try {
        const res = await axios.post("/api/v1/task", task.value);

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
