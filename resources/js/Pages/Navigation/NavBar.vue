<script setup>
import { Link } from "@inertiajs/vue3";
</script>
<template>
    <header>
        <div class="font-mono mb-6 bg-white">
            <div class="flex justify-between h-16 px-10 shadow items-center">
                <div class="flex items-center space-x-8">
                    <h1 class="text-xl lg:text-2xl font-bold cursor-pointer">
                        YarnChives
                    </h1>
                    <div class="md:flex justify-around space-x-4">
                        <Link
                            :href="route('homePage')"
                            class="hover:text-indigo-600 text-gray-700"
                        >
                            Posts
                        </Link>
                        <Link
                            :href="route('Patterns')"
                            class="hover:text-indigo-600 text-gray-700"
                        >
                            Patterns
                        </Link>
                    </div>
                </div>
                <div class="flex space-x-4 items-center">
                    <Link
                        :href="route('profile')"
                        v-if="$page.props.auth.user"
                        class="hover:text-indigo-600 text-gray-700"
                        >Profile</Link
                    >
                    <Link
                        :href="route('login')"
                        v-if="!$page.props.auth.user"
                        class="bg-indigo-600 px-4 py-2 rounded text-white hover:bg-indigo-500 text-sm"
                    >
                        Login
                    </Link>
                </div>
            </div>
        </div>
    </header>
</template>
