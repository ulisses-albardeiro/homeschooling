<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue'; 
import { ref, computed } from 'vue';
import Modal from '@/Components/Modal.vue';
import Autocomplete from '@/Components/Autocomplete.vue';

const props = defineProps<{
    accounts: Array<{ id: number, admin_user: string, name: string, email: string, expiration_date: string }>,
    search: string
}>();

const form = useForm({
    admin_user: '',
    name: '',
    number: '',
    status: '',
    email: '',
    phone: '',
    cell: '',
    testDrive: '',
    initialExpiration: '',
    finalExpiration: '',
    search: props.search || ''

});

const autocompleteOptions = computed(() => {
    return props.accounts.map(account => ({
        value: account.id.toString(),
        searchResult: account.admin_user
    }));
});
const handleSelection = (selectedItem: { value: string, searchResult: string }) => {
    form.admin_user = selectedItem.searchResult;
};

const formatDate = (dateString: string) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('pt-BR');
};

function submit() {
    form.get(route('accounts.index'));
}

const showDeleteModal = ref(false);
const accountToDelete = ref<number | null>(null);
const nameAccount = ref<string | null>(null);

const confirmDelete = (accountId: number, name: string) => {
    nameAccount.value = name;
    accountToDelete.value = accountId;
    showDeleteModal.value = true;
};
const deleteAccount = () => {
    if (accountToDelete.value !== null) {
        router.delete(route('accounts.destroy', accountToDelete.value), {
            onSuccess: () => {
                showDeleteModal.value = false;
                accountToDelete.value = null;
            }
        });
    }
};

</script>

<template>
    <div>

        <Head title="Contas" />
        <AuthenticatedLayout>
            <template #header>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Contas
                </h2>
            </template>

            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <form @submit.prevent="submit" class="mb-4">
                                <div class="flex gap-4 mb-4">

                                    <div class="w-full">
                                        <InputLabel for="admin_user" value="Usuário Administrador" />
                                        <Autocomplete id="admin_user" :options="autocompleteOptions"
                                            @selected="handleSelection" v-model="form.admin_user"
                                            class="mt-1 block w-full" />
                                    </div>
                                    <div class="w-full">
                                        <InputLabel for="name" value="Nome/Razão Social" />
                                        <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name"
                                            placeholder="Nome" />
                                    </div>
                                    <div class="w-full">
                                        <InputLabel for="number" value="Número" />
                                        <TextInput id="number" type="text" class="mt-1 block w-full"
                                            v-model="form.number" placeholder="Número" />
                                    </div>
                                    <div class="w-full">
                                        <InputLabel for="status" value="Status *" />
                                        <select id="status" v-model="form.status"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option disable value="">Selecione</option>
                                            <option value="1">Ativa</option>
                                            <option value="0">Inativa</option>
                                        </select>
                                    </div>
                                    <div class="w-full">
                                        <InputLabel for="email" value="Email" />
                                        <TextInput id="email" type="email" class="mt-1 block w-full"
                                            v-model="form.email" placeholder="Email" />
                                    </div>
                                </div>

                                <div class="flex gap-4 mb-4">

                                    <div class="w-full">
                                        <InputLabel for="phone" value="Telefone" />
                                        <TextInput id="phone" type="text" class="mt-1 block w-full" v-model="form.phone"
                                            placeholder="Telefone" />
                                    </div>

                                    <div class="w-full">
                                        <InputLabel for="cell" value="Celular" />
                                        <TextInput id="cell" type="text" class="mt-1 block w-full" v-model="form.cell"
                                            placeholder="Celular" />
                                    </div>
                                    <div class="w-full">
                                        <InputLabel for="testDrive" value="Test Drive" />
                                        <select id="testDrive"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            v-model="form.testDrive">
                                            <option selected value="">Todas</option>
                                            <option value="Sim">Sim</option>
                                            <option value="Não">Não</option>
                                        </select>
                                    </div>
                                    <div class="w-full">
                                        <InputLabel for="initialExpiration" value="Data Inicial" />
                                        <input id="initialExpiration" type="date"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            v-model="form.initialExpiration" />
                                    </div>
                                    <div class="w-full">
                                        <InputLabel for="finalExpiration" value="Data Final" />
                                        <input id="finalExpiration" type="date"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            v-model="form.finalExpiration" />
                                    </div>

                                </div>
                                <div class="flex justify-end">
                                    <PrimaryButton :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing">
                                        Pesquisar
                                    </PrimaryButton>

                                    <Link v-if="form.search" :href="route('accounts.index')"
                                        class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded focus:outline-none focus:shadow-outline flex-shrink-0">
                                    Limpar Pesquisa
                                    </Link>

                                    <Link :href="route('accounts.create')"
                                        class="ml-4 bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Nova
                                    </Link>
                                </div>
                            </form>
                            <table class="border-collapse border border-slate-400 w-full">
                                <thead>
                                    <tr>
                                        <th width="10%" class="border border-slate-300 p-2">N°</th>
                                        <th width="35%" class="border border-slate-300 p-2">Usuário Administrador</th>
                                        <th width="30%" class="border border-slate-300 p-2">Email</th>
                                        <th width="15%" class="border border-slate-300 p-2">Expiração</th>
                                        <th width="20%" class="border border-slate-300 p-2">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="account in props.accounts" :key="account.id">
                                        <td class="border border-slate-300 p-2 text-center">{{ account.id }}</td>
                                        <td class="border border-slate-300 p-2 text-center">{{ account.admin_user }}
                                        </td>
                                        <td class="border border-slate-300 p-2 text-center">{{ account.email }}</td>
                                        <td class="border border-slate-300 p-2 text-center">{{
                                            formatDate(account.expiration_date)
                                            }}</td>
                                        <td class="border border-slate-300 p-2 text-center">
                                            <Link :href="route('accounts.edit', account.id)"
                                                class="text-yellow-500 hover:underline ml-2" title="Editar">
                                            <i class="material-icons icon-color">edit</i>
                                            </Link>

                                            <button @click="confirmDelete(account.id, account.name)"
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
    <Modal :show="showDeleteModal" @close="showDeleteModal = false">
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
    </Modal>
</template>
