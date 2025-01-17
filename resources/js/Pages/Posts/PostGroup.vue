<script setup>
import PostPreview from "./PostPreview.vue";

const props = defineProps({
    allPosts: Array,
});
</script>

<template>
    <div v-for="post in allPosts">
        <PostPreview :Post="post"> </PostPreview>
    </div>
</template>
