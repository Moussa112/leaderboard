<script setup>
    const props = defineProps({
        users: Array
    })
</script>

<template>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Leaderboard</h1>


        <div class="mb-4">
            <inertia-link :href="route('games.create')" class="btn">Add Match</inertia-link>
        </div>


        <table class="min-w-full">
            <thead>
                <tr class="text-left">
                    <th>Rank</th>
                    <th>Player</th>
                    <th>Rating</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(user, idx) in users" :key="user.id" class="border-t">
                    <td>{{ idx + 1 }}</td>
                    <td>{{ user.name }}</td>
                    <td>
                        <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 inset-ring inset-ring-gray-500/10">
                            {{ user.elo_rating }}
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>