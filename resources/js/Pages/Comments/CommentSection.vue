<script setup>
import CommentForm from "../Comments/CommentForm.vue";
import { ref } from "vue";
import Comment from "./Comment.vue";

const props = defineProps({
    comments: {
        type: Array,
        required: true,
    },
    post: {
        type: Array,
        required: true,
    },
});

const CommentFormOpened = ref(false);
const toggleCommentForm = () => {
    CommentFormOpened.value = !CommentFormOpened.value;
};
</script>

<template>
    <div class="bg-gray-100 p-2 mt-2 rounded-md">
        <div class="mt-4 flex justify-center text-xl">{{ post.comments_amt }} Comments</div>
        <div class="mt-4 flex justify-center text-md">
            <button
                @click="toggleCommentForm"
                :disabled="!$page.props.auth.user"
            >
                Make a Comment
            </button>
        </div>

        <CommentForm
            :commentFormOpen="CommentFormOpened"
            @closeCommentForm="toggleCommentForm"
            :postID="post.id"
        ></CommentForm>
        <div v-for="comment in comments" class="mt-4 ml-10">
            <Comment :comment="comment"> </Comment>
        </div>
        <div></div>
    </div>
</template>
