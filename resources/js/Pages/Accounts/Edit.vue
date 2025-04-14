<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Form from '@/Pages/Accounts/Components/Form.vue'; 
import { alert, setAlert } from '@/Components/Alert/Alert';

const props = defineProps({
    account: {
        type: Object,
        required: true,
    },
});

const handleSubmit = (status) => {
    if (status === 'success') {
        setAlert('Conta atualizada com sucesso!', 'bg-green-500', 'text-white');
    } else {
        setAlert('Erro ao atualizar conta.', 'bg-red-500', 'text-white');
    }
};
</script>

<template>
    <div>
        <Head title="Editar Conta" />

        <AuthenticatedLayout>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Editar Conta
                </h2>
            </template>

            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <Form :account="props.account" @submit="handleSubmit" />

                            <div class="flex items-center justify-end mt-4">
                                <Link :href="route('accounts.index')" class="text-gray-600 hover:text-gray-900">
                                    Cancelar
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>