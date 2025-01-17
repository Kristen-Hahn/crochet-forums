


 <script setup>
import { Link } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";

const props = defineProps({
    Post: Object,
});

</script>


<template>
<div class='flex items-center justify-center p-5 font-mono'>  <div class="rounded-xl border  p-5 shadow-md w-9/12 bg-white">
    <div class="flex w-full items-center justify-between border-b pb-3">
      <div class="flex items-center space-x-3">
        <img class="h-8 w-8 rounded-full bg-slate-400" :src=" Post.author_details.profile_picture +'/'+Post.author_details.pfpPath"></img>
        <div class="text-lg font-bold text-slate-700"> {{ Post.author_details.name }}</div>
      </div>
      <div class="flex items-center space-x-8">
        <div class="text-xs text-neutral-500"> {{ Post.formatted_date }}</div>
      </div>
    </div>

    <div class="mt-4 mb-6">
      <div class="mb-3 text-xl font-bold"> {{ Post.title }}</div>
      <div class="text-sm text-neutral-600"> {{ Post.post_preview }}</div>

    </div>

    <div>
        <Link :href="route('viewPost', {post: Post.id})" class="font-mono"> Read more</Link>          

      <div class="flex items-center justify-between text-slate-500">
        <div class="flex space-x-4 md:space-x-8">
          <div class="flex cursor-pointer items-center transition hover:text-slate-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
            </svg>
            <span>{{Post.comments_amt}}</span>
          </div>
          <div class="flex cursor-pointer items-center transition hover:text-slate-600">
           

            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</template>