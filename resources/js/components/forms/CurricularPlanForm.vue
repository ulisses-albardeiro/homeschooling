<template>
  <form @submit.prevent="submitForm" class="space-y-4">
    <div>
      <label class="block font-semibold mb-1">Título do Plano</label>
      <input v-model="form.title" type="text" class="input" required />
    </div>

    <div>
      <label class="block font-semibold mb-1">Descrição</label>
      <textarea v-model="form.description" class="input" rows="3"></textarea>
    </div>

    <div>
      <label class="block font-semibold mb-1">Faixa Etária</label>
      <input v-model="form.age_range" type="text" class="input" placeholder="Ex: 7-8 anos" />
    </div>

    <div>
      <label class="block font-semibold mb-1">Ano/Série</label>
      <input v-model="form.grade_level" type="text" class="input" placeholder="Ex: 2º ano" />
    </div>

    <div>
      <label class="block font-semibold mb-1">Estilo Pedagógico</label>
      <input v-model="form.pedagogical_style" type="text" class="input" placeholder="Ex: Montessori" />
    </div>

    <div class="flex justify-end">
      <button type="submit" class="btn btn-primary">Salvar</button>
    </div>
  </form>
</template>

<script setup lang="ts">
import { reactive } from 'vue';
import { router } from '@inertiajs/vue3';

const form = reactive({
  title: '',
  description: '',
  age_range: '',
  grade_level: '',
  pedagogical_style: ''
});

function submitForm() {
  router.post('/curricular-plans', form);
}
</script>

<style scoped lang="postcss">
.input {
  @apply w-full border rounded p-2 shadow-sm;
}
.btn-primary {
  @apply bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700;
}
</style>
