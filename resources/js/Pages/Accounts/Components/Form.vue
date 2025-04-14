<script setup>
import { useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({
    account: {
        type: Object,
        default: () => ({}), 
    },
});

const emit = defineEmits(['submit']);

const form = useForm({
    admin_user: props.account.admin_user || '',
    person_type: props.account.person_type || '',
    name: props.account.name || '',
    cpf_cnpj: props.account.cpf_cnpj || '',
    email: props.account.email || '',
    phone: props.account.phone || '',
    cell_phone: props.account.cell_phone || '',
    status: props.account.status || '',
    limit_user: props.account.limit_user || '',
    ged: props.account.ged || '',
    publications: props.account.publications || '',
    test_drive: props.account.test_drive || '',
    contract: props.account.contract || '',
    migration: props.account.migration || '',
    expiration_date: props.account.expiration_date || '',
    push_count: props.account.push_count || '',
});

const submit = () => {
    if (props.account.id) {
        form.put(route('accounts.update', props.account.id), {
            onFinish: () => {
                if (form.recentlySuccessful) {
                    emit('submit', 'success');
                }
            },
            onError: () => {
                emit('submit', 'error');
            },
        });
    } else {
        form.post(route('accounts.store'), {
            onFinish: () => {
                if (form.recentlySuccessful) {
                    form.reset();
                    emit('submit', 'success');
                }
            },
            onError: () => {
                emit('submit', 'error');
            },
        });
    }
};
</script>

<template>
    <form @submit.prevent="submit" class="mb-4">
        <div class="flex gap-4 mb-4">
            <div class="w-full">
                <InputLabel for="admin_user" value="Usuário Administrador*" />
                <TextInput id="admin_user" type="text" class="mt-1 block w-full" v-model="form.admin_user"
                    placeholder="Usuário Administrador*" required />
            </div>
            <div class="w-full">
                <InputLabel for="person_type" value="Tipo de Pessoa *" />
                <select required id="person_type" v-model="form.person_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option disable value="">Selecione</option>
                    <option value="0">Física</option>
                    <option value="1">Jurídica</option>
                </select>
            </div>
            <div class="w-full">
                <InputLabel for="name" value="Nome / Razão Social *" />
                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" placeholder="Nome / Razão Social *" required />
            </div>
            <div class="w-full">
                <InputLabel for="cpf_cnpj" value="CPF/CNPJ *" />
                <TextInput id="cpf_cnpj" type="text" class="mt-1 block w-full" v-model="form.cpf_cnpj" placeholder="CPF/CNPJ*" required />
            </div>
        </div>

        <div class="flex gap-4 mb-4">
            <div class="w-full">
                <InputLabel for="email" value="Email *" />
                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" placeholder="Email*"
                    required />
            </div>
            <div class="w-full">
                <InputLabel for="phone" value="Telefone" />
                <TextInput id="phone" type="text" class="mt-1 block w-full" v-model="form.phone"
                    placeholder="Telefone" />
            </div>
            <div class="w-full">
                <InputLabel for="cell_phone" value="Celular" />
                <TextInput id="cell_phone" type="text" class="mt-1 block w-full" v-model="form.cell_phone"
                    placeholder="Celular" />
            </div>
            <div class="w-full">
                <InputLabel for="status" value="Status *" />
                <select required id="status" v-model="form.status"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option disable value="">Selecione</option>
                    <option value="1">Ativa</option>
                    <option value="0">Inativa</option>
                </select>
            </div>
        </div>

        <div class="flex gap-4 mb-4">
            <div class="w-full">
                <InputLabel for="ged" value="GED *" />
                <TextInput id="ged" type="number" class="mt-1 block w-full" v-model="form.ged" placeholder="GED*"
                    required min="0" />
            </div>
            <div class="w-full">
                <InputLabel for="publications" value="Publicações *" />
                <select id="publications" v-model="form.publications"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option disable value="">Selecione</option>
                    <option value="1">Ativo</option>
                    <option value="0">Inativo</option>
                </select>
            </div>
            <div class="w-full">
                <InputLabel for="test_drive" value="Test Drive *" />
                <select id="test_drive"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    v-model="form.test_drive" required>
                    <option disable value="">Selecione</option>
                    <option value="Sim">Sim</option>
                    <option value="Não">Não</option>
                </select>
            </div>
            <div class="w-full">
                <InputLabel for="contract" value="Contrato *" />
                <select required id="contract" v-model="form.contract"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option disable value="">Selecione</option>
                    <option value="1">Aceito</option>
                    <option value="0">Não Aceito</option>
                </select>
            </div>
        </div>

        <div class="flex gap-4 mb-4">
            <div class="w-full">
                <InputLabel for="limit_user" value="Limite de Usuários *" />
                <TextInput id="limit_user" type="number" class="mt-1 block w-full" v-model="form.limit_user"
                    placeholder="Limite de Usuários" required min="0" />
            </div>
            <div class="w-full">
                <InputLabel for="migration" value="Migração *" />
                <select id="migration" v-model="form.migration"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option disable value="">Selecione</option>
                    <option value="1">Sim</option>
                    <option value="0">Não</option>
                </select>
            </div>
            <div class="w-full">
                <InputLabel for="expiration_date" value="Data de Expiração *" />
                <TextInput id="expiration_date" type="date"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    v-model="form.expiration_date" required />
            </div>
            <div class="w-full">
                <InputLabel for="push_count" value="Quantidade de Push" />
                <TextInput id="push_count" type="number" class="mt-1 block w-full" v-model="form.push_count"
                    placeholder="Quantidade de Push" min="0" />
            </div>
        </div>

        <div class="flex gap-4">
            <PrimaryButton type="submit" class="ml-auto">
                {{ props.account.id ? 'Atualizar' : 'Cadastrar' }}
            </PrimaryButton>
        </div>
    </form>

</template>

