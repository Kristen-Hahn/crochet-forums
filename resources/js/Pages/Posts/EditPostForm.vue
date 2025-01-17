<script setup>
import { Link } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    editPostFormOpened: {
        type: Boolean,
        required: true,
    },
    post: {
        type: Array,
        required: true,
    },
});

const emit = defineEmits(["closeEditPostForm"]);

const form = useForm({
    title: props.post.title,
    body: props.post.post,
    postID: props.post.id,
});

const formData = new FormData();
const PostImageURL = ref(null);

const handleFileChange = (event) => {
    const file = event.target.files[0];
    PostImageURL.value = URL.createObjectURL(file);
    formData.append("postimage", file);
};

function submit() {
    formData.append("postID", form.postID);
    formData.append("title", form.title);
    formData.append("post", form.body);
    axios
        .post("/api/updatePost", formData, {})

        .then(() => {
            form.reset();
            closeForm();
        })
        .catch((error) => {
            console.log(error.response);
            console.log(error.message);
        });
}

function closeForm() {
    form.reset();
    emit("closeEditPostForm");
}
</script>
<template>
    <div v-if="editPostFormOpened == true" class="font-mono">
        <form>
            <div
                class="heading text-center font-mono-bold text-2xl m-5 text-gray-800"
            >
                Edit Post
            </div>

            <div
                class="editor mx-auto w-10/12 flex flex-col text-gray-800 border border-gray-300 p-4 shadow-lg max-w-2xl"
            >
                <input
                    class="title bg-gray-100 border border-gray-300 p-2 mb-4 outline-none"
                    spellcheck="false"
                    placeholder="Title"
                    type="text"
                    v-model="form.title"
                />
                <textarea
                    class="description bg-gray-100 sec p-3 h-60 border border-gray-300 outline-none"
                    spellcheck="false"
                    placeholder="Share your thoughts..."
                    v-model="form.body"
                ></textarea>

                <!-- icons -->
                <div class="icons flex text-gray-500 m-2">
                    <!-- <label for="FileInput">

      <svg class="mr-2 cursor-pointer hover:text-gray-700 border rounded-full p-1 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
     </label> -->
                    <input
                        type="file"
                        id="FileInput"
                        @change="handleFileChange"
                    />
                </div>
                <!-- buttons -->
                <div class="buttons flex">
                    <div
                        class="btn border border-gray-300 p-1 px-4 font-mono-semibold cursor-pointer text-gray-500 ml-auto"
                        @click="closeForm"
                    >
                        Cancel
                    </div>
                    <div
                        class="btn border border-indigo-500 p-1 px-4 font-mono-semibold cursor-pointer text-gray-200 ml-2 bg-indigo-500"
                        @click="submit"
                    >
                        Post
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>
