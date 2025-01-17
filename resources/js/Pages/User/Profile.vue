<script setup>
import { Link } from "@inertiajs/vue3";
import NavBar from "../Navigation/NavBar.vue";
import EditProfile from "./EditProfile.vue";
import PostHistory from "./PostHistory.vue";
import CommentHistory from "./CommentHistory.vue";
import MyPatterns from "./MyPatterns.vue";
import { ref } from "vue";
const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
    posts: {
        type: Object,
        required: true,
    },
    comments: {
        type: Object,
        required: true,
    },
    patterns: {
        type: Object,
        required: true,
    },
});
const EditProfileOpen = ref(true);
function openEditProfile() {
    EditProfileOpen.value = true;
    PostHistoryOpen.value = false;
    CommentHistoryOpen.value = false;
    MyPatternsOpen.value = false;
}
const PostHistoryOpen = ref(false);
function openPostHistory() {
    PostHistoryOpen.value = true;
    EditProfileOpen.value = false;
    CommentHistoryOpen.value = false;
    MyPatternsOpen.value = false;
}
const CommentHistoryOpen = ref(false);
function openCommentHistory() {
    CommentHistoryOpen.value = true;
    PostHistoryOpen.value = false;
    MyPatternsOpen.value = false;
    EditProfileOpen.value = false;
}

const MyPatternsOpen = ref(false);
function openMyPatterns() {
    MyPatternsOpen.value = true;
    CommentHistoryOpen.value = false;
    PostHistoryOpen.value = false;
    EditProfileOpen.value = false;
}
</script>

<template>
    <NavBar></NavBar>

    <!-- page -->
    <main
        class="min-h-screen w-full bg-gray-100 text-gray-700 -mt-6 font-mono"
        x-data="layout"
    >
        <div class="flex">
            <aside
                class="flex w-72 flex-col space-y-2 border-r-2 border-gray-200 bg-white p-2"
                style="height: 90.5vh"
                x-show="asideOpen"
            >
                <div
                    class="flex items-center space-x-1 rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600"
                >
                    <span @click="openEditProfile">Edit Profile</span>
                </div>

                <div
                    class="flex items-center space-x-1 rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600"
                >
                    <span @click="openPostHistory">Post History</span>
                </div>

                <div
                    class="flex items-center space-x-1 rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600"
                >
                    <span @click="openCommentHistory">Comment History</span>
                </div>

                <div
                    class="flex items-center space-x-1 rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600"
                >
                    <span @click="openMyPatterns">My Patterns</span>
                </div>

                <div
                    class="flex items-center space-x-1 rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600"
                >
                    <Link href="/logout" method="post"> Log out</Link>
                </div>
            </aside>

            <div class="w-full p-4">
                <EditProfile :open="EditProfileOpen" :user="user"></EditProfile>

                <PostHistory :open="PostHistoryOpen" :posts="posts">
                </PostHistory>

                <CommentHistory :open="CommentHistoryOpen" :comments="comments">
                </CommentHistory>
                <MyPatterns :open="MyPatternsOpen" :patterns="patterns">
                </MyPatterns>
            </div>
        </div>
    </main>
</template>
