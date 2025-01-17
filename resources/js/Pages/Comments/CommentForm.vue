<script setup>
import { useForm } from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";

const props = defineProps({
    commentFormOpen: Boolean,
    postID: Object,
    replyID: {
        type: Number,
        default: 0,
    },
});
console.log(props.postID);
const emit = defineEmits(["closeCommentForm"]);
const form = useForm({
    comment: null,
    postID: props.postID,
    replyID: props.replyID,
});

function closeForm() {
    form.reset();
    emit("closeCommentForm");
}
const postComment = () => {
    console.log(props.replyID);
    form.post(route("postcomment", { preserveScroll: true }), {
        onFinish: () => emit("closeCommentForm"),
    });
};
</script>
<template>
    <div v-if="commentFormOpen == true" class="flex justify-center">
        <div
            class="relative grid grid-cols-1 gap-4 p-3 mb-2 border rounded-lg bg-white w-96"
        >
            <div class="relative flex gap-4">
                <img
                    :src="
                        $page.props.auth.user.profile_picture +
                        '/' +
                        $page.props.auth.user.pfpPath
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
                            {{ $page.props.auth.user.name }}
                        </p>
                    </div>

                    <form @submit.prevent="submit">
                        <div>
                            <InputLabel for="comment" />
                            <textarea
                                id="comment"
                                type="text"
                                class="mt-1 block w-full break-words"
                                v-model="form.comment"
                                required
                                autocomplete="comment"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.comment"
                            />
                        </div>
                    </form>

                    <div>
                        <button @click="postComment" class="m-2">
                            Comment
                        </button>
                        <button @click="closeForm" class="m-2">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
