<script setup>
import { Link } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    Opened: Boolean,
});
const emit = defineEmits(["close"]);

const form = useForm({
    title: null,
    description: null,
});

const formData = new FormData();
const CoverImageURL = ref(null);

const handleFileChange = (event) => {
    const file = event.target.files[0];
    CoverImageURL.value = URL.createObjectURL(file);
    console.log(CoverImageURL.value);
    formData.append("coverimage", file);
};

const handlePDFUpload = (event) => {
    let pdf = event.target.files[0];
    URL.createObjectURL(pdf);
    formData.append("pdf", pdf);
};
function uploadFile() {
    formData.append("title", form.title);
    formData.append("description", form.description);
    axios
        .post("/api/uploadCoverImage", formData, {})

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
    emit("close");
}
</script>

<template>
    <div v-if="Opened == true" class="font-mono">
        <form>
            <div
                class="heading text-center font-mono-bold text-2xl m-5 text-gray-800"
            >
                Create Pattern
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
                    placeholder="Share your description..."
                    v-model="form.description"
                ></textarea>

                <div class="icons flex text-gray-500 m-2">
                    <input type="file" @change="handleFileChange" />
                    <input
                        type="file"
                        accept=".pdf"
                        @change="handlePDFUpload"
                    />
                </div>

                <div class="buttons flex">
                    <div
                        class="btn border border-gray-300 p-1 px-4 font-mono-semibold cursor-pointer text-gray-500 ml-auto"
                        @click="closeForm"
                    >
                        Cancel
                    </div>
                    <div
                        class="btn border border-indigo-500 p-1 px-4 font-mono-semibold cursor-pointer text-gray-200 ml-2 bg-indigo-500"
                        @click="uploadFile"
                    >
                        Create Pattern
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>
