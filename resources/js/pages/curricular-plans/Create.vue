<script setup lang="ts">
import CurricularPlanForm from '@/components/forms/CurricularPlanForm.vue';
import type { CurricularPlan } from '@/types/CurricularPlan';
import { ref } from 'vue';


const plan = ref<CurricularPlan>({
  title: '',
  description: '',
  age_range: '',
  grade_level: '',
  pedagogical_style: '',
});
</script>

<template>
  <AppLayout>
    <CurricularPlanForm />
  </AppLayout>
</template>
