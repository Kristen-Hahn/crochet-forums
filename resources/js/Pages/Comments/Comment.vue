<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import CommentEditForm from "./CommentEditForm.vue";
import CommentForm from "./CommentForm.vue";
const props = defineProps({
    comment: {
        type: Array,
        required: true,
    },
    ReplyName: {
        type: String,
        required: false,
    },
});

const ViewReplies = ref(false);
const CommentEditFormOpened = ref(false);
const toggleCommentEditForm = () => {
    CommentEditFormOpened.value = !CommentEditFormOpened.value;
};

function isAuthor(user) {
    if (user != null) {
        if (user.id == props.comment.author) {
            return true;
        }
        return false;
    }
    return false;
}

function deleteComment() {
    const removeComment = useForm({
        commentid: props.comment.id,
    });
    removeComment.delete(route("deleteComment"));
}
function toggleReplies() {
    ViewReplies.value = !ViewReplies.value;
}

const CommentFormOpened = ref(false);
const toggleCommentForm = () => {
    CommentFormOpened.value = !CommentFormOpened.value;
};

console.log(props.comment);
const amtLikes = ref(props.comment.likes);
const amtDislikes = ref(props.comment.dislikes);
const commentLiked = ref(props.comment.liked);
const commentDisliked = ref(props.comment.disliked);
const removedLike = ref(false);
const removedDislike = ref(false);

const form = useForm({
    liked: commentLiked.value,
    disliked: commentDisliked.value,
    removelike: removedLike.value,
    removedislike: removedDislike.value,
    commentID: props.comment.id,
});

function dislikeComment() {
    if (props.comment.disliked == true) {
        removedDislike.value = true;
        amtDislikes.value = amtDislikes.value - 1;
        commentDisliked.value = false;
    } else {
        removedDislike.value = false;
        if (commentDisliked.value == false) {
            if (commentLiked.value == false) {
                removedLike.value = false;
                amtDislikes.value = amtDislikes.value + 1;
                commentDisliked.value = true;
            } else {
                amtDislikes.value = amtDislikes.value + 1;
                commentDisliked.value = true;
                commentLiked.value = false;
                amtLikes.value = amtLikes.value - 1;
                removedLike.value = true;
            }
        }
    }

    submit();
}
function likeComment() {
    if (props.comment.liked == true) {
        removedLike.value = true;
        amtLikes.value = amtLikes.value - 1;
        commentLiked.value = false;
    } else {
        removedDislike.value = false;
        if (commentLiked.value == false) {
            if (commentDisliked.value == false) {
                removedDislike.value = false;
                amtLikes.value = amtLikes.value + 1;
                commentLiked.value = true;
            } else {
                amtLikes.value = amtLikes.value + 1;
                commentLiked.value = true;
                amtDislikes.value = amtDislikes.value - 1;
                commentDisliked.value = false;
                removedDislike.value = true;
            }
        }
    }
    submit();
}
function submit() {
    form.liked = commentLiked.value;
    form.disliked = commentDisliked.value;
    form.removelike = removedLike.value;
    form.removedislike = removedDislike.value;
    form.post(route("adjustCommentLikes"));
    removedLike.value = false;
    removedDislike.value = false;
}
</script>

<template>
    <div class="flex justify-center">
        <div
            class="relative grid grid-cols-1 gap-4 p-3 mb-2 border rounded-lg bg-white w-96"
        >
            <div class="relative flex gap-4">
                <img
                    :src="
                        comment.author_details.profile_picture +
                        '/' +
                        comment.author_details.pfpPath
                    "
                    class="relative rounded-lg -top-1 -mb-4 bg-white border h-10 w-10"
                    alt=""
                    loading="lazy"
                />
                <div class="flex flex-col w-full">
                    <div class="flex flex-row justify-between">
                        <p
                            class="relative text-sm whitespace-nowrap truncate overflow-hidden"
                        >
                            {{ comment.author_details.name }}
                        </p>
                    </div>
                    <p class="text-gray-400 text-xs">
                        {{ comment.date_formatted }}
                    </p>
                </div>
            </div>
            <p v-if="comment.replyID > 0" class="text-indigo-500">
                @{{ ReplyName }}
            </p>
            <p class="-mt-4 text-gray-500 break-words">{{ comment.comment }}</p>

            <div class="flex justify-start">
                <button
                    class="mx-1 py-1.5 px-3 text-green-600 hover:scale-105 hover:shadow text-center border border-gray-300 rounded-md h-8 text-sm flex items-center gap-1 lg:gap-2"
                    @click="likeComment"
                    :disabled="!$page.props.auth.user"
                    v-if="commentLiked == true"
                >
                    <svg
                        class="w-4 h-4"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z"
                        ></path>
                    </svg>
                    <span>{{ amtLikes }}</span>
                </button>
                <button
                    v-else
                    class="mx-1 py-1.5 px-3 hover:text-green-600 hover:scale-105 hover:shadow text-center border border-gray-300 rounded-md h-8 text-sm flex items-center gap-1 lg:gap-2"
                    @click="likeComment"
                    :disabled="!$page.props.auth.user"
                >
                    <svg
                        class="w-4 h-4"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z"
                        ></path>
                    </svg>
                    <span>{{ amtLikes }}</span>
                </button>

                <button
                    class="mx-1 py-1.5 px-3 text-red-600 hover:scale-105 hover:shadow text-center border border-gray-300 rounded-md h-8 text-sm flex items-center gap-1 lg:gap-2"
                    v-if="commentDisliked == true"
                    @click="dislikeComment"
                    :disabled="!$page.props.auth.user"
                >
                    <svg
                        class="w-4 h-4"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M7.5 15h2.25m8.024-9.75c.011.05.028.1.052.148.591 1.2.924 2.55.924 3.977a8.96 8.96 0 01-.999 4.125m.023-8.25c-.076-.365.183-.75.575-.75h.908c.889 0 1.713.518 1.972 1.368.339 1.11.521 2.287.521 3.507 0 1.553-.295 3.036-.831 4.398C20.613 14.547 19.833 15 19 15h-1.053c-.472 0-.745-.556-.5-.96a8.95 8.95 0 00.303-.54m.023-8.25H16.48a4.5 4.5 0 01-1.423-.23l-3.114-1.04a4.5 4.5 0 00-1.423-.23H6.504c-.618 0-1.217.247-1.605.729A11.95 11.95 0 002.25 12c0 .434.023.863.068 1.285C2.427 14.306 3.346 15 4.372 15h3.126c.618 0 .991.724.725 1.282A7.471 7.471 0 007.5 19.5a2.25 2.25 0 002.25 2.25.75.75 0 00.75-.75v-.633c0-.573.11-1.14.322-1.672.304-.76.93-1.33 1.653-1.715a9.04 9.04 0 002.86-2.4c.498-.634 1.226-1.08 2.032-1.08h.384"
                        ></path>
                    </svg>
                    <span>{{ amtDislikes }}</span>
                </button>
                <button
                    class="mx-1 py-1.5 px-3 hover:text-red-600 hover:scale-105 hover:shadow text-center border border-gray-300 rounded-md h-8 text-sm flex items-center gap-1 lg:gap-2"
                    v-else
                    @click="dislikeComment"
                    :disabled="!$page.props.auth.user"
                >
                    <svg
                        class="w-4 h-4"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M7.5 15h2.25m8.024-9.75c.011.05.028.1.052.148.591 1.2.924 2.55.924 3.977a8.96 8.96 0 01-.999 4.125m.023-8.25c-.076-.365.183-.75.575-.75h.908c.889 0 1.713.518 1.972 1.368.339 1.11.521 2.287.521 3.507 0 1.553-.295 3.036-.831 4.398C20.613 14.547 19.833 15 19 15h-1.053c-.472 0-.745-.556-.5-.96a8.95 8.95 0 00.303-.54m.023-8.25H16.48a4.5 4.5 0 01-1.423-.23l-3.114-1.04a4.5 4.5 0 00-1.423-.23H6.504c-.618 0-1.217.247-1.605.729A11.95 11.95 0 002.25 12c0 .434.023.863.068 1.285C2.427 14.306 3.346 15 4.372 15h3.126c.618 0 .991.724.725 1.282A7.471 7.471 0 007.5 19.5a2.25 2.25 0 002.25 2.25.75.75 0 00.75-.75v-.633c0-.573.11-1.14.322-1.672.304-.76.93-1.33 1.653-1.715a9.04 9.04 0 002.86-2.4c.498-.634 1.226-1.08 2.032-1.08h.384"
                        ></path>
                    </svg>
                    <span>{{ amtDislikes }}</span>
                </button>

                <button
                    class="mx-1 px-1 py-1 text-[12px] rounded"
                    @click="toggleCommentForm"
                    v-if="!CommentFormOpened"
                    :disabled="!$page.props.auth.user"
                >
                    Reply
                </button>
                <button
                    class="mx-1 px-1 py-1 text-[12px] rounded"
                    v-if="
                        isAuthor($page.props.auth.user) == true &&
                        !CommentEditFormOpened
                    "
                    @click="toggleCommentEditForm"
                >
                    Edit
                </button>
                <button
                    class="mx-1 px-1 py-1 text-[12px] rounded"
                    v-if="isAuthor($page.props.auth.user) == true"
                    @click="deleteComment"
                >
                    Delete
                </button>
            </div>
            <CommentEditForm
                :comment="comment"
                :CommentEditFormOpen="CommentEditFormOpened"
                @closecommenteditform="toggleCommentEditForm"
            ></CommentEditForm>
            <CommentForm
            :commentFormOpen="CommentFormOpened"
            @closeCommentForm="toggleCommentForm"
            :postID="comment.postID"
            :replyID="comment.id"
        ></CommentForm>
        </div>
       
    </div>
    <div class="ml-12">
        <div v-for="reply in comment.replies">
            <Comment
                :comment="reply"
                :ReplyName="comment.author_details.name"
            >
            </Comment>
        </div>
    </div>
</template>
