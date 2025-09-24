<script setup>
    import { useForm } from "@inertiajs/vue3";
    import { ref } from "vue";
    import { computed } from "vue";
    import { inject } from 'vue';

    const props = defineProps({
        users: Array
    })

    const sortedUsers = computed(() => [...props.users].sort((a,b) => b.elo_rating - a.elo_rating))

    function groupByScore(users) {
        const groups = {}
        users.forEach(u => {
            if (!groups[u.elo_rating]) groups[u.elo_rating] = []
            groups[u.elo_rating].push(u)
        })

        return Object.keys(groups)
            .sort((a,b) => b - a)
            .map(score => ({ score, users: groups[score] }))
    }

    // Top 3 groups for hero section (may include ties)
    const grouped = computed(() => groupByScore(sortedUsers.value))

    // Extract top 3 ranks (ties included)
    const top3Groups = computed(() => grouped.value.slice(0,3))

    // Remaining groups starting from rank 4
    const remainingGroups = computed(() => grouped.value.slice(3))

    // Helper for podium rank label
    const podiumRank = (idx) => {
        if (idx === 0) return '🥇 1st'
        if (idx === 1) return '🥈 2nd'
        if (idx === 2) return '🥉 3rd'
        return ''
    }

    const headers = ["title", "body", "actions"];
    const dialog = ref(null);
    const showDialog = ref(false);
    const form = useForm({
        winner_id: '',
        loser_id: '',
    });

    const openDialog = () => {
        showDialog.value = true; 
    };

    const closeDialog = () => {
        showDialog.value = false;
    };

    const submit = () => {
        form.post(
            //inject("games.store"),
            '/games', 
            {
                onSuccess: () => {
                    closeDialog();
                    form.reset();
                },
            }
        );
    };
</script>

<template>
    <div class="py-3 max-w-4xl mx-auto">
        <div class="flex justify-between items-center py-3">
            <h1 class="text-3xl font-bold">Leaderboard</h1>

            <button @click="openDialog" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                New game
            </button>
        </div>

          <!-- Top 3 Hero Section -->
        <div class="flex justify-between mb-10">
            <template v-for="(group, idx) in top3Groups" :key="idx">
                <div v-for="user in group.users" :key="user.id" class="flex flex-col items-center">
                    <div 
                        class="border-2 rounded-xl w-32 h-32 pt-3 flex flex-col items-center text-center"
                        :class="{
                            'bg-yellow-200 border-yellow-400': idx === 0,
                            'bg-gray-300 border-gray-400': idx === 1, 
                            'bg-orange-200 border-orange-400': idx === 2
                        }"
                    >
                        <div class="font-bold text-xl">{{ user.name }}</div>
                        <div class="text-gray-700 text-sm mt-1">{{ user.elo_rating }} elo</div>
                    </div>
                    <div class="text-gray-500 mt-2 font-semibold">
                        {{ podiumRank(idx) }}
                    </div>
                </div>
            </template>
        </div>

        <div class="space-y-6">
            <div v-for="(group, idx) in remainingGroups" :key="idx">
                <div class="mb-2 flex items-center space-x-2">
                    <span class="bg-indigo-600 text-white px-3 py-1 rounded-full font-semibold">
                        {{ group.score }}
                    </span>
                    <span class="text-gray-500 font-medium">elo</span>
                </div>

                <div class="flex flex-wrap gap-4">
                    <div 
                        v-for="user in group.users" 
                        :key="user.id"
                        class="bg-indigo-50 border border-indigo-200 rounded-xl p-4 flex flex-col items-center justify-center w-32 hover:scale-105 transform transition"
                    >
                        <div class="text-lg font-semibold">{{ user.name }}</div>
                    </div>
                </div>
            </div>
        </div>

        <transition name="fade">
            <div v-if="showDialog" class="fixed inset-0 z-50 flex items-center justify-center bg-indigo-600/100 p-4">
                <button 
                    @click="closeDialog"
                    class="fixed top-4 right-4 text-white text-4xl font-bold hover:text-gray-300 focus:outline-none z-50"
                    aria-label="Close modal"
                >
                    &times;
                </button>

                <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 relative z-40">
                    <h2 class="text-xl font-semibold mb-6 text-gray-800">Add New Game</h2>

                    <form @submit.prevent="submit" class="space-y-4">
                        <div>
                            <label class="block text-gray-700 mb-1 font-medium">Winner</label>
                            <select 
                                v-model="form.winner_id"
                                :disabled="form.processing"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            >
                                <option v-for="user in users" :key="user.id" :value="user.id">
                                    {{ user.name }} ({{ user.elo_rating }})
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-1 font-medium">Loser</label>
                            <select 
                                v-model="form.loser_id"
                                :disabled="form.processing"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            >
                                <option v-for="user in users" :key="user.id" :value="user.id">
                                    {{ user.name }} ({{ user.elo_rating }})
                                </option>
                            </select>
                        </div>

                        <div class="flex justify-end gap-3 mt-4">
                            <button 
                                type="button" 
                                @click="closeDialog"
                                class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 focus:outline-none"
                            >
                                Cancel
                            </button>
                            <button 
                                type="submit" 
                                :disabled="form.processing"
                                class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 disabled:opacity-50 focus:outline-none"
                            >
                                Submit
                            </button>
                        </div>
                </form>
                </div>
            </div>
        </transition>
    </div>
</template>

<style>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.2s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>