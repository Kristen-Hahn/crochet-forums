<script setup>
import PatternPreview from "./PatternPreview.vue";
const props = defineProps({
    patterns: Object,
});
</script>

<template>
    <div
 class="grid grid-cols-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    <div v-for="pattern in patterns">
            <PatternPreview :pattern="pattern" />
        </div>
    </div>
</template>

