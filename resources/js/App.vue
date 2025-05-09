<template>
    <div class="min-h-screen p-6 bg-gray-100">
        <Notivue v-slot="item">
            <Notification :item="item" />
        </Notivue>
        <router-view />
    </div>
</template>

<script setup>
import { Notivue, Notification } from "notivue";
</script>
