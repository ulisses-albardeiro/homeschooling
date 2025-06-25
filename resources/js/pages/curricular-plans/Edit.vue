<script setup lang="ts">
import CurricularPlanForm from '@/components/forms/CurricularPlanForm.vue';
import { usePage } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';


const curricularPlan = usePage().props.curricularPlan;

const plan = ref<CurricularPlan | null>(null);
const props = defineProps<{ id: number }>();
const id = props.id;

onMounted(async () => {
  const { data } = await axios.get<CurricularPlan>(`/api/curricular-plans/${id}`);
  plan.value = data;
});
</script>

<template>
  <AppLayout>
    <CurricularPlanForm :initial-data="curricularPlan" />
  </AppLayout>
</template>
