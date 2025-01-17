<script setup>
import { useForm } from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";

const props = defineProps({
    CommentEditFormOpen: {
        type: Boolean,
        required: true,
    },
    comment: {
        type: Array,
        required: true,
    },
});

const emit = defineEmits(["closecommenteditform"]);
const form = useForm({
    comment: props.comment.comment,
    commentID: props.comment.id,
});

function closeForm() {
    form.reset();
    emit("closecommenteditform");
}

const postComment = () => {
    form.post(route("editcomment", { preserveScroll: true }), {
        onFinish: () => emit("closecommenteditform"),
    });
};
</script>

<template>
    <div v-if="CommentEditFormOpen == true">
        <form @submit.prevent="submit">
            <div>
                <InputLabel for="comment" />
                <TextInput
                    id="comment"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.comment"
                    required
                    autocomplete="comment"
                />

                <InputError class="mt-2" :message="form.errors.comment" />
            </div>
        </form>
        <button @click="postComment" class="p-1">Comment</button>
        <button @click="closeForm" class="p-1">Close</button>
    </div>
</template>
