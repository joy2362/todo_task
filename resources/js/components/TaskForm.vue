<template>
    <form @submit.prevent="onSubmit" class="space-y-4">
        <div>
            <label class="block font-medium">Title</label>
            <input
                v-model="task.title"
                class="w-full border rounded p-2"
                required
            />
        </div>
        <div>
            <label class="block font-medium">Body</label>
            <textarea
                v-model="task.body"
                class="w-full border rounded p-2"
                required
            />
        </div>
        <div v-if="task.status">
            <label class="block font-medium">Status</label>
            <select v-model="task.status" class="w-full border rounded p-2">
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
            </select>
        </div>
        <button
            type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        >
            {{ submitText }}
        </button>
    </form>
</template>

<script setup>
defineProps({
    task: Object,
    submitText: {
        type: String,
        default: "Save",
    },
});
const emit = defineEmits(["submit"]);

function onSubmit() {
    emit("submit");
}
</script>
