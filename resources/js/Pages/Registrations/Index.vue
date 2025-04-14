<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';


const props = defineProps<{
    accounts: Array<{ id: number, name: string, cpf: string, internal_code: string, rg: string, group: string, city: string }>
}>();

const form = useForm({
    name: '',
    cpf: '',
    internal_code: '',
    rg: '',
    group: '',
    city: ''
});

function submit() {
    form.get(route('client.index'));
}

</script>

<template>
    <div>

        <Head title="Clientes" />
        <AuthenticatedLayout>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Clientes
                </h2>
            </template>

            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <form @submit.prevent="submit" class="mb-4">
                                <div class="flex gap-4 mb-4">

                                    <div class="w-full">
                                        <InputLabel for="name" value="Nome" />
                                        <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name"
                                            placeholder="Nome" />
                                    </div>
                                    <div class="w-full">
                                        <InputLabel for="cpf" value="CPF" />
                                        <TextInput id="cpf" type="text" class="mt-1 block w-full" v-model="form.cpf"
                                            placeholder="CPF" />
                                    </div>
                                    <div class="w-full">
                                        <InputLabel for="internal_code" value="Código Interno" />
                                        <TextInput id="internal_code" type="text" class="mt-1 block w-full"
                                            v-model="form.internal_code" placeholder="Número" />
                                    </div>
                                </div>

                                <div class="flex gap-4 mb-4">

                                    <div class="w-full">
                                        <InputLabel for="rg" value="RG" />
                                        <TextInput id="rg" type="text" class="mt-1 block w-full" v-model="form.rg"
                                            placeholder="RG" />
                                    </div>
                                    <div class="w-full">
                                        <InputLabel for="group" value="Grupo" />
                                        <TextInput id="group" type="email" class="mt-1 block w-full"
                                            v-model="form.group" placeholder="Grupo" />
                                    </div>

                                    <div class="w-full">
                                        <InputLabel for="city" value="Cidade" />
                                        <TextInput id="city" type="text" class="mt-1 block w-full" v-model="form.city"
                                            placeholder="Cidade" />
                                    </div>

                                </div>
                                <div class="flex justify-end">
                                    <PrimaryButton :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing">
                                        Pesquisar
                                    </PrimaryButton>

                                    <Link :href="route('clients.create')"
                                        class="ml-4 bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Nova
                                    </Link>
                                </div>
                            </form>
                            <table class="border-collapse border border-slate-400 w-full">
                                <thead>
                                    <tr>
                                        <th width="12%" class="border border-slate-300 p-2">Código Interno</th>
                                        <th width="30%" class="border border-slate-300 p-2">Nome/Razão Social</th>
                                        <th width="30%" class="border border-slate-300 p-2">C.P.F. / C.N.P.J.</th>
                                        
                                        <th width="20%" class="border border-slate-300 p-2">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border border-slate-300 p-2 text-center"></td>
                                        <td class="border border-slate-300 p-2 text-center"></td>
                                        <td class="border border-slate-300 p-2 text-center"></td>
                                        <td class="border border-slate-300 p-2 text-center">
                                            <!-- <Link :href="route('clients.edit')"
                                                class="text-yellow-500 hover:underline ml-2" title="Editar">
                                            <i class="material-icons icon-color">edit</i>
                                            </Link> -->

                                            <button
                                                class="text-red-500 hover:text-red-700 ml-2" title="Deletar">
                                                <i class="material-icons">delete</i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>

    <!-- Modal -->
    <!-- <Modal :show="showDeleteModal" @close="showDeleteModal = false">
        <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-900">Confirmar Exclusão</h2>
            <p class="mt-2 text-gray-600">Tem certeza que deseja excluir a conta <span class="underline text-black">{{
                nameAccount }}</span>? Esta ação não pode ser desfeita.</p>

            <div class="mt-4 flex justify-end space-x-2">
                <button @click="showDeleteModal = false" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md">
                    Cancelar
                </button>
                <button @click="deleteAccount" class="px-4 py-2 bg-red-600 text-white rounded-md">
                    Excluir
                </button>
            </div>
        </div>
    </Modal> -->
</template>
