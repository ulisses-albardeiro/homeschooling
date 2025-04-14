<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Form from '@/Pages/Accounts/Components/Form.vue';
import { alert, setAlert } from '@/Components/Alert/Alert';

const handleSubmit = (status) => {
    if (status === 'success') {
        setAlert('Conta criada com sucesso!', 'bg-green-500', 'text-white');
    } else {
        setAlert('Erro ao criar Conta.', 'bg-red-500', 'text-white');
    }
};
</script>

<template>
    <div>
        <Head title="Cadastro de Contas" />

        <AuthenticatedLayout>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Cadastro de Contas
                </h2>
            </template>

            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <Form @submit="handleSubmit" />
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>
