<script setup>
import PostPreview from "../Posts/PostPreview.vue";
const props = defineProps({
    posts: {
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
        <div v-if="posts.length == 0">No Post History</div>

        <div v-for="post in posts">
            <div><PostPreview :Post="post"></PostPreview></div>
        </div>
    </div>
</template>
