<script setup>
    import { useForm } from "@inertiajs/vue3";
    import { ref } from "vue";
    import { inject } from 'vue';

    const props = defineProps({
        users: Array
    })

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
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Leaderboard</h1>

        <button @click="openDialog" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
            New game
        </button>

        <table class="min-w-full mt-4">
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
                        <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600">
                            {{ user.elo_rating }}
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>

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