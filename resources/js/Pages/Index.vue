<script setup>
import NavBar from "./Navigation/NavBar.vue";
import { onMounted, ref } from "vue";
import PostsHome from "./Posts/PostsHome.vue";

const props = defineProps({
    allPosts: Array,
});
</script>

<template>
   
    <div class="min-h-screen w-full bg-gray-100">
        <NavBar> </NavBar>

        <div class="px-32">
            <PostsHome :allPosts="allPosts"></PostsHome>
        </div>
    </div>
</template>
