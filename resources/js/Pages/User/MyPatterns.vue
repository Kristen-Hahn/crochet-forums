<script setup>
import PatternPreview from "../Patterns/PatternPreview.vue";
const props = defineProps({
    patterns: {
        type: Object,
        required: true,
    },
    open: {
        type: Boolean,
        required: true,
    },
});
</script>

<template>
    <div v-if="open == true">
        <div v-if="patterns.length == 0">
            You Haven't Posted any Patterns yet.
        </div>
        <div
            class="grid grid-cols-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"
        >
            <div v-for="pattern in patterns">
                <PatternPreview :pattern="pattern"></PatternPreview>
            </div>
        </div>
    </div>
</template>
