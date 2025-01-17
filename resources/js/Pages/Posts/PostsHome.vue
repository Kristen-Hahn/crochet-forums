<script setup>
import { onMounted, ref } from "vue";
import PostForm from "./PostForm.vue";
import PostGroup from "./PostGroup.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import PostPreview from "./PostPreview.vue";

const props = defineProps({
    allPosts: Array,
});
let input = ref("");
const PostFormOpened = ref(false);

const togglePostForm = () => {
    PostFormOpened.value = !PostFormOpened.value;
};

function filteredList() {
    return props.allPosts.filter((post) =>
        post.title.toLowerCase().includes(input.value.toLowerCase())
    );
}
</script>
<template>
    <div>
        <div class="text-md  mx-16">
            <div v-if="!$page.props.auth.user" class="flex justify-between">
                <div> Login to create a new post!</div>
                <input
                    type="text"
                    v-model="input"
                    placeholder="Search posts..."
                    class="rounded-lg w-96"
                />

            </div>
            <div v-else class="flex justify-between">
                <PrimaryButton @click="togglePostForm" v-if="!PostFormOpened">
                    New Post
                </PrimaryButton>

                <input
                    type="text"
                    v-model="input"
                    placeholder="Search posts..."
                    class="rounded-lg w-96"
                />

            </div>
        </div>
        <div>
            <PostForm
                :Opened="PostFormOpened"
                @close="togglePostForm"
            ></PostForm>
            <div v-if="input != 0" v-for="post in filteredList()" :key="post">
                <PostPreview :Post="post"></PostPreview>
            </div>
            <div class="item error" v-if="input && !filteredList().length">
                <p>No results found!</p>
            </div>
            <PostGroup :allPosts="allPosts" v-if="input.length == 0">
            </PostGroup>
        </div>
    </div>
</template>
