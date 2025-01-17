<script setup>
const props = defineProps({
    pattern: Object,
});
import { Link } from "@inertiajs/vue3";
</script>

<template>

    <div
        class="relative flex max-w-[24rem] flex-col rounded-xl font-mono bg-white bg-clip-border text-gray-700 shadow-md"
    >
        <div
            class="relative m-0 overflow-hidden rounded-none bg-transparent bg-clip-border text-gray-700 shadow-none"
        >
            <img
                :src="pattern.cover_image + '/' + pattern.coverimage"
                alt="pattern.title"
            />
        </div>
        <div class="p-6">
            <h4
                class="block font-mono text-2xl font-semibold leading-snug tracking-normal text-blue-gray-900 antialiased"
            >
                {{ pattern.title }}
            </h4>
        </div>
        <div class="flex justify-around">
            <Link :href="route('viewPattern', { pattern: pattern.id })">
                View Pattern</Link
            >
        </div>
        <div class="flex items-center justify-between p-6">
            <div class="flex items-center -space-x-3">
                <img
                    alt="pattern.author_details.name"
                    :src="
                        pattern.author_details.profile_picture +
                        '/' +
                        pattern.author_details.pfpPath
                    "
                    class="relative inline-block h-9 w-9 rounded-full border-2 border-white object-cover object-center hover:z-10"
                />
            </div>
            <div>Created By: {{ pattern.author_details.name }}</div>
        </div>
        <div class="flex justify-around">
            <p
                class="block font-mono text-base font-normal leading-relaxed text-inherit antialiased"
            >
                Posted: {{ pattern.formatted_date }}
            </p>
        </div>
    </div>
    <div class="w-full pt-5 px-4 mb-8 mx-auto"></div>
</template>
