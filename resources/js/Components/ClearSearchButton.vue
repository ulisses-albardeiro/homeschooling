<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  search: String
});

const showButton = computed(() => props.search.trim() !== '');
</script>

<template>
  <div v-if="showButton" class="mt-4">
    <Link :href="route(props.search)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
    Limpar Filtros
    </Link>
  </div>
</template>