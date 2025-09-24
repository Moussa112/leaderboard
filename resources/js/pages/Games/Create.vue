<template>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">New game</h1>

        <form @submit.prevent="submit">
            <div class="mb-4">
                <label class="block">Winner</label>
                <select v-model="form.winner_id" class="w-full">
                    <option v-for="u in users" :key="u.id" :value="u.id">{{ u.name }} ({{ u.elo_rating }})</option>
                </select>
            </div>


            <div class="mb-4">
                <label class="block">Loser</label>
                <select v-model="form.loser_id" class="w-full">
                    <option v-for="u in users" :key="u.id" :value="u.id">{{ u.name }} ({{ u.elo_rating }})</option>
                </select>
            </div>


            <button class="btn">Submit</button>
        </form>
    </div>
</template>


<script setup>
    /*import { ref } from 'vue'
    import { Inertia } from '@inertiajs/inertia'
    import { usePage } from '@inertiajs/inertia-vue3'

    const props = usePage().props.value
    const users = props.users

    const form = ref({ winner_id: users[0]?.id || null, loser_id: users[1]?.id || null })

    function submit() {
        Inertia.post(route('games.store'), form.value)
    }*/
</script>