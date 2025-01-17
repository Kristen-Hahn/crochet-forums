<script setup>
import NavBar from "../Navigation/NavBar.vue";

const props = defineProps({
    pattern: Object,
});

function downloadPdf() {
    const link = document.createElement("a");
    link.href = props.pattern.pdf_link + "/" + props.pattern.pdf;
    link.target = "_blank";
    link.download = props.pattern.title;

    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>

<template>
    <NavBar></NavBar>
    <div class="mb-4 font-mono" >
        <div class="max-w-screen-lg mx-auto">
            <main class="mt-10">
                <div class="mb-4 md:mb-0 w-full mx-auto relative">
                    <div class="px-4 lg:px-0">
                        <h2
                            class="text-4xl font-mono-semibold text-gray-800 leading-tight"
                        >
                            {{ pattern.title }}
                        </h2>
                    </div>

                    <img
                        :src="pattern.cover_image + '/' + pattern.coverimage"
                        class=""
                    />
                </div>

                <div class="flex flex-col lg:flex-row lg:space-x-12">
                    <div
                        class="px-4 lg:px-0 mt-12 text-gray-700 text-lg leading-relaxed w-full lg:w-3/4"
                    >
                        <div>
                            {{ pattern.description }}
                        </div>
                        <div>
                            <button
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-mono-bold py-2 px-4 rounded inline-flex items-center"
                                @click="downloadPdf"
                            >
                                <svg
                                    class="fill-current w-4 h-4 mr-2"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z"
                                    />
                                </svg>
                                <span>Download PDF</span>
                            </button>
                        </div>
                    </div>

                    <div class="w-full lg:w-1/4 m-auto mt-12 max-w-screen-sm">
                        <div class="p-4 border-t border-b md:border md:rounded">
                            <div class="flex py-2">
                                <img
                                    :src="
                                        pattern.author_details.profile_picture +
                                        '/' +
                                        pattern.author_details.pfpPath
                                    "
                                    class="h-10 w-10 rounded-full mr-2 object-cover"
                                />
                                <div>
                                    <p
                                        class="font-mono-semibold text-gray-700 text-sm"
                                    >
                                        {{ pattern.author_details.name }}
                                    </p>
                                </div>
                            </div>
                            <p class="text-gray-700 py-3">
                                {{ pattern.author_details.bio }}
                            </p>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <div></div>
    </div>
</template>
