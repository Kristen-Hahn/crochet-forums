<script setup>
import Comment from "../Comments/Comment.vue";
const props = defineProps({
    comments: {
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
        <div v-if="comments.length == 0">No Comment History</div>
        <div v-for="comment in comments">
            <Comment :comment="comment"></Comment>
        </div>
    </div>
</template>
