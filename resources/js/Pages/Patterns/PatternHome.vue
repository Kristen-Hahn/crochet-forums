<script setup>
import NavBar from "../Navigation/NavBar.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import PatternForm from "./PatternForm.vue";
import { ref } from "vue";
import PatternGroup from "./PatternGroup.vue";
import PatternPreview from "./PatternPreview.vue";

const props = defineProps({
    patterns: Object,
});

let input = ref("");
const PatternFormOpened = ref(false);

const togglePatternForm = () => {
    PatternFormOpened.value = !PatternFormOpened.value;
};
function filteredList() {
    return props.patterns.filter((pattern) =>
        pattern.title.toLowerCase().includes(input.value.toLowerCase())
    );
}
</script>

<template>
    <NavBar></NavBar>
    <div class="bg-gray-100">
        <div class="px-32">
            <div class="text-md mx-16 mb-3">
                <div v-if="!$page.props.auth.user" class="flex justify-between">
                    <div>Login to post a pattern! </div>
                    
                    <input
                        type="text"
                        v-model="input"
                        placeholder="Search patterns..."
                        class="rounded-lg w-96"
                    />
                </div>
                
                <div v-else class="flex justify-between">
                    <PrimaryButton
                        @click="togglePatternForm"
                        v-if="!PatternFormOpened"
                    >
                        New Pattern
                    </PrimaryButton>

                    <input
                        type="text"
                        v-model="input"
                        placeholder="Search patterns..."
                        class="rounded-lg w-96"
                    />
                </div>
            </div>
            <PatternForm
                :Opened="PatternFormOpened"
                @close="togglePatternForm"
            ></PatternForm>
            <div
                class="grid grid-cols-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"
            >
                <div
                    v-if="input != 0"
                    v-for="pattern in filteredList()"
                    :key="post"
                >
                    <PatternPreview :pattern="pattern"></PatternPreview>
                </div>
            </div>
            <div class="item error" v-if="input && !filteredList().length">
                <p>No results found!</p>
            </div>
            <PatternGroup
                :patterns="patterns"
                v-if="input.length == 0"
            ></PatternGroup>
        </div>
    </div>
</template>
