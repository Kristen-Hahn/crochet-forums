<script setup>
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import axios from "axios";

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
    open: {
        type: Boolean,
        required: true,
    },
});
const EditName = ref(false);
const EditEmail = ref(false);
const EditBio = ref(false);
const EditPFP = ref(false);

const FileInput = ref(null);
function editProfile() {
    EditName.value = !EditName.value;
    EditEmail.value = !EditEmail.value;
    EditBio.value = !EditBio.value;
    EditPFP.value = !EditPFP.value;
}

const form = useForm({
    userID: props.user.id,
    name: props.user.name,
    email: props.user.email,
    bio: props.user.bio,
});
const formData = new FormData();
const ProfilePictureURL = ref(null);

const handleFileChange = (event) => {
    const file = event.target.files[0];
    ProfilePictureURL.value = URL.createObjectURL(file);
    console.log(ProfilePictureURL.value);
    formData.append("profile_picture", file);
};
function uploadFile() {
    axios
        .post("/api/uploadPFP", formData, {})

        .then((response) => {
            console.log("image uploaded");
        })
        .catch((error) => {
            console.log(error.response);
            console.log(error.message);
        });
}

const submit = () => {
    if (ProfilePictureURL != null) {
        uploadFile();
    }
    form.post(route("editProfile"));
    editProfile();
};
</script>
<template>
    <div v-if="open == true">
        <body class="bg-gray-100 font-mono">
            <div
                class="max-w-lg mx-auto my-10 bg-white rounded-lg shadow-md p-5"
            >
                <img
                    class="w-32 h-32 rounded-full mx-auto"
                    :src="
                        ProfilePictureURL
                            ? ProfilePictureURL
                            : user.profile_picture + '/' + user.pfpPath
                    "
                    alt="Profile picture"
                />
                <h2
                    class="text-center text-2xl font-semibold mt-3"
                    v-if="EditName == false"
                >
                    {{ user.name }}
                </h2>
                <TextInput
                    v-if="EditName == true"
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autocomplete="name"
                >
                </TextInput>
                <p
                    class="text-center text-gray-600 mt-1"
                    v-if="EditEmail == false"
                >
                    {{ user.email }}
                </p>
                <TextInput
                    v-if="EditEmail == true"
                    id="email"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="email"
                >
                </TextInput>
                <p class="text-center text-gray-600 mt-1">
                    Member since: {{ user.formatted_date }}
                </p>

                <div class="mt-5">
                    <h3 class="text-xl font-semibold">Bio</h3>
                    <p
                        class="text-gray-600 mt-2 break-words"
                        v-if="EditBio == false"
                    >
                        {{ user.bio }}
                    </p>
                    <TextInput
                        v-if="EditBio == true"
                        id="bio"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.bio"
                        required
                        autocomplete="bio"
                    >
                    </TextInput>
                </div>
                <div class="mt-1" v-if="EditPFP == true">
                    <div>New Profile Picture</div>
                    <div>
                        <input
                            type="file"
                            id="FileInput"
                            @change="handleFileChange"
                        />
                    </div>
                    <!-- <button @click="uploadFile"> Change Profile Picture </button> -->
                </div>
                <button class="mt-2 flex justify-center" @click="editProfile">
                    Edit Profile
                </button>
                <button
                    class="mt-2 flex justify-center"
                    v-if="EditPFP == true"
                    @click="submit"
                >
                    Save Changes
                </button>
            </div>
        </body>
    </div>
</template>
