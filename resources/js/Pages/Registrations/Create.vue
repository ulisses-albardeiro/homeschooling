<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { CityData, fetchCityData } from './City';
import Autocomplete from '@/Components/Autocomplete.vue';
import { ref, computed } from 'vue';

const autocompleteOptionsProfession = computed(() => {
    return props.profession.map(profession => ({
        value: profession.id.toString(),
        searchResult: profession.name
    }));
});

const autocompleteOptionsGroup = computed(() => {
    return props.group.map(group => ({
        value: group.id.toString(),
        searchResult: group.name
    }));
});

const autocompleteOptionsArea = computed(() => {
    return props.area.map(area => ({
        value: area.id.toString(),
        searchResult: area.name
    }));
});

const handleSelection = (selectedItem: { value: string, searchResult: string }) => {
    form.searchProfession = selectedItem.searchResult;
    form.searchGroup = selectedItem.searchResult;
    form.searchArea = selectedItem.searchResult;

};


const props = defineProps<{
    profession: Array<{ id: number, name: string }>,
    searchProfession: string,
    group: Array<{ id: number, name: string }>,
    searchGroup: string,
    area: Array<{ id: number, name: string }>,
    searchArea: string
}>();

const activeTab = ref('infoMain');
const isLawyerChecked = ref(false);
const isContactChecked = ref(false);

const toggleStatus = (status: string) => {
    if (status === 'true') {
        form.status.active = true;
        form.status.inactive = false;
    } else {
        form.status.active = false;
        form.status.inactive = true;
    }
}

const togglePersonType = (type: string) => {
    if (type === 'person') {
        form.person_type.isTypePerson = true;
        form.person_type.isLegalPerson = false;
    } else {
        form.person_type.isTypePerson = false;
        form.person_type.isLegalPerson = true;
    }
};

const form = useForm({
    searchGroup: props.searchGroup || '',
    searchProfession: props.searchProfession || '',
    searchArea: props.searchArea || '',

    classification: {
        client: true,
        contact: false,
        lawyer: false,
        oppositeParty: false,
        otherInvolved: false,
    },
    person_type: {
        isTypePerson: true,
        isLegalPerson: false,
    },
    status: {
        active: true,
        inactive: false,
    },
    name: '',
    cpf: '',
    rg: '',
    issuing_agency: '',
    issuance_date: '',
    work_card: '',
    pis: '',
    birth_date: '',
    nationality: '',
    birthplace: '',
    gender: '',
    profession: props.profession || '',
    voter_id: '',
    electoral_zone: '',
    electoral_municipality: '',
    voter_issuance_date: '',
    internal_code: '',
    group: '',
    zip_code: '',
    address: '',
    address_number: '',
    address_complement: '',
    neighborhood: '',
    city: '',
    suggestions: [] as CityData[],
    state: '',
    phone: '',
    cell: '',
    email: '',
    observation: '',
    username: '',
    password: '',
    file: '',
    area: '',
    oab_number: '',
    effective_date: '',
    hourly_rate: '',
    legal_entity_contact: '',
    corporate_name: '',
    nickname: '',
    cnpj: '',
    state_registration: '',
    foundation_date: '',
    activity: '',
    archival_reason: '',
    marital_status: '',
    electoral_section: ''
});

function submit() {
    form.post(route('clients.store'));
}

async function handleInput(event: Event) {
    const input = event.target as HTMLInputElement;
    const city = input.value.replace(/[^a-zA-Z]/g, '');

    if (city.length >= 1) {
        await fetchCityData(city, form);
    } else {
        form.suggestions = [];
    }
}

function selectSuggestion(suggestion: CityData) {
    form.city = suggestion.nome || '';
    form.state = suggestion.estado || '';
    form.suggestions = [];
}
</script>

<style scoped>
button {
    transition: all 0.3s ease;
}

.with-icon {
    position: relative;
    top: -11px;
}
</style>

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
                                <div>
                                    <div class="flex border-b">
                                        <button type="button"
                                            class="px-4 py-2 text-gray-600 focus:outline-none border-t border-l border-r rounded-t-md"
                                            :class="{ 'border-blue-500 text-blue-500 bg-white': activeTab === 'infoMain' }"
                                            @click="activeTab = 'infoMain'">Info Principal</button>
                                        <button type="button"
                                            class="px-4 py-2 text-gray-600 focus:outline-none border-t border-l border-r rounded-t-md"
                                            :class="{ 'border-blue-500 text-blue-500 bg-white': activeTab === 'dataLawyer' }"
                                            @click="activeTab = 'dataLawyer'" v-if="isLawyerChecked">Dados do
                                            Advogado</button>
                                        <button type="button"
                                            class="px-4 py-2 text-gray-600 focus:outline-none border-t border-l border-r rounded-t-md"
                                            :class="{ 'border-blue-500 text-blue-500 bg-white': activeTab === 'dataContact' }"
                                            @click="activeTab = 'dataContact'" v-if="isContactChecked">Dados do
                                            Contato</button>
                                    </div>
                                    <div class="p-4 border border-gray-300 rounded-b-md">
                                        <div v-if="activeTab === 'infoMain'">
                                            <h5 class="text-lg font-bold mb-3">Classificação*</h5>
                                            <div class="grid grid-cols-8 gap-4 mb-4">
                                                <div class="flex items-center">
                                                    <input v-model="form.classification.client" name="" type="checkbox"
                                                        class="mr-2" value="Cliente">
                                                    <label class="text-sm">Cliente</label>
                                                </div>
                                                <div class="flex items-center">
                                                    <input type="checkbox" class="mr-2"
                                                        v-model="form.classification.contact"
                                                        @click="isContactChecked = !isContactChecked" value="Contato">
                                                    <label class="text-sm">Contato</label>
                                                </div>
                                                <div class="flex items-center">
                                                    <input type="checkbox" class="mr-2"
                                                        v-model="form.classification.lawyer"
                                                        @click="isLawyerChecked = !isLawyerChecked" value="Advogado">
                                                    <label class="text-sm">Advogado</label>
                                                </div>
                                                <div class="flex items-center">
                                                    <input type="checkbox" class="mr-2"
                                                        v-model="form.classification.oppositeParty"
                                                        value="Parte Contrária">
                                                    <label class="text-sm">Parte Contrária</label>
                                                </div>
                                                <div class="flex items-center">
                                                    <input type="checkbox" class="mr-2"
                                                        v-model="form.classification.otherInvolved"
                                                        value="Outro Envolvido">
                                                    <label class="text-sm">Outro Envolvido</label>
                                                </div>
                                            </div>

                                            <h5 class="text-lg font-bold mb-3">Tipo*</h5>
                                            <div class="grid grid-cols-8 gap-4 mb-5">
                                                <div class="flex items-center">
                                                    <input type="checkbox" class="mr-2"
                                                        :checked="form.person_type.isTypePerson"
                                                        @click="togglePersonType('person')"
                                                        v-model="form.person_type.isTypePerson">
                                                    <label class="text-sm">Física</label>
                                                </div>
                                                <div class="flex items-center">
                                                    <input type="checkbox" class="mr-2"
                                                        :checked="form.person_type.isLegalPerson"
                                                        @click="togglePersonType('legal')"
                                                        v-model="form.person_type.isLegalPerson">
                                                    <label class="text-sm">Jurídica</label>
                                                </div>
                                            </div>

                                            <h5 class="text-lg font-bold mb-3">Situação*</h5>
                                            <div class="grid grid-cols-8 gap-4 mb-5">
                                                <div class="flex items-center">
                                                    <input type="checkbox" class="mr-2" :checked="form.status.active"
                                                        @click="toggleStatus('true')" v-model="form.status.active">
                                                    <label class="text-sm">Ativo</label>
                                                </div>
                                                <div class="flex items-center">
                                                    <input type="checkbox" class="mr-2" :checked="form.status.inactive"
                                                        @click="toggleStatus('false')" v-model="form.status.inactive">
                                                    <label class="text-sm">Inativo</label>
                                                </div>
                                            </div>
                                            <div v-if="form.status.inactive" class="mt-4">
                                                <label for="archival_reason" class="block text-gray-700">Motivo do
                                                    Arquivamento</label>
                                                <textarea class="w-full p-2 border rounded" id="archival_reason"
                                                    v-model="form.archival_reason"></textarea>
                                            </div>

                                            <!-- Pessoa física -->
                                            <div v-if="form.person_type.isTypePerson">
                                                <div class="grid grid-cols-4 gap-4 mt-5">
                                                    <div class="w-full">
                                                        <InputLabel for="name" value="Nome" />
                                                        <TextInput id="name" type="text" class="mt-1 block w-full"
                                                            v-model="form.name" placeholder="Nome" />
                                                    </div>
                                                    <div class="w-full">
                                                        <InputLabel for="cpf" value="CPF" />
                                                        <TextInput id="cpf" type="text" class="mt-1 block w-full"
                                                            v-model="form.cpf" placeholder="CPF" />
                                                    </div>
                                                    <div class="w-full">
                                                        <InputLabel for="rg" value="RG" />
                                                        <TextInput id="rg" type="text" class="mt-1 block w-full"
                                                            v-model="form.rg" placeholder="RG" />
                                                    </div>
                                                    <div class="w-full">
                                                        <InputLabel for="issuing_agency" value="Órgão" />
                                                        <TextInput id="issuing_agency" type="text"
                                                            class="mt-1 block w-full" v-model="form.issuing_agency"
                                                            placeholder="Órgão" />
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-4 gap-4 mt-5">
                                                    <div class="w-full">
                                                        <InputLabel for="issuance_date" value="Emissão" />
                                                        <TextInput id="issuance_date" type="text"
                                                            class="mt-1 block w-full" v-model="form.issuance_date"
                                                            placeholder="Emissão" />
                                                    </div>
                                                    <div class="w-full">
                                                        <InputLabel for="work_card" value="CTPS" />
                                                        <TextInput id="work_card" type="text" class="mt-1 block w-full"
                                                            v-model="form.work_card" placeholder="CTPS" />
                                                    </div>
                                                    <div class="w-full">
                                                        <InputLabel for="pis" value="PIS" />
                                                        <TextInput id="pis" type="text" class="mt-1 block w-full"
                                                            v-model="form.pis" placeholder="PIS" />
                                                    </div>
                                                    <div class="w-full">
                                                        <InputLabel for="birth_date" value="Nascimento" />
                                                        <TextInput id="birth_date" type="date" class="mt-1 block w-full"
                                                            v-model="form.birth_date" placeholder="Nascimento" />
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-4 gap-4 mt-5">
                                                    <div class="w-full">
                                                        <InputLabel for="gender" value="Sexo" />
                                                        <TextInput id="gender" type="text" class="mt-1 block w-full"
                                                            v-model="form.gender" placeholder="Sexo" />
                                                    </div>
                                                    <div class="w-full">
                                                        <InputLabel for="birthplace" value="Naturalidade" />
                                                        <TextInput id="birthplace" type="text" class="mt-1 block w-full"
                                                            v-model="form.birthplace" placeholder="Naturalidade" />
                                                    </div>
                                                    <div class="w-full">
                                                        <InputLabel for="nationality" value="Nascionalidade" />
                                                        <TextInput id="nationality" type="text"
                                                            class="mt-1 block w-full" v-model="form.nationality"
                                                            placeholder="Nascionalidade" />
                                                    </div>
                                                    <div class="w-full">
                                                        <InputLabel for="birth_date" value="Estado Civil" />
                                                        <select v-model="form.marital_status" id="type_parameter"
                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                            <option value="" disabled>Selecione </option>
                                                            <option value="Amasiado(a)">Amasiado(a)</option>
                                                            <option value="União Estável">União Estável</option>
                                                            <option value="Casado(a)">Casado(a)</option>
                                                            <option value="Desquitado(a)">Desquitado(a)</option>
                                                            <option value="Divorciado(a)">Divorciado(a)</option>
                                                            <option value="Separado(a)">Separado(a)</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-4 gap-4 mt-5">
                                                    <div class="w-full with-icon">
                                                        <div class="flex gap-2 items-center">
                                                            <InputLabel for="profession" value="Profissão/Ocupação" />
                                                            <a href="#" title="Adicionar nova Profissão">
                                                                <i class="material-icons">library_add</i>
                                                            </a>
                                                        </div>
                                                        <Autocomplete :options="autocompleteOptionsProfession"
                                                            @selected="handleSelection" v-model="form.searchProfession"
                                                            class="mt-1 block w-full flex-grow" />
                                                    </div>
                                                    <div class="w-full">
                                                        <InputLabel for="voter_id" value="Título de Eleitor" />
                                                        <TextInput id="voter_id" type="text" class="mt-1 block w-full"
                                                            v-model="form.voter_id" placeholder="Título de Eleitor" />
                                                    </div>
                                                    <div class="w-full">
                                                        <InputLabel for="electoral_zone" value="Zona Eleitoral" />
                                                        <TextInput id="electoral_zone" type="text"
                                                            class="mt-1 block w-full" v-model="form.electoral_zone"
                                                            placeholder="Zona Eleitoral" />
                                                    </div>
                                                    <div class="w-full">
                                                        <InputLabel for="electoral_section" value="Seção Eleitoral" />
                                                        <TextInput id="electoral_section" type="text"
                                                            class="mt-1 block w-full" v-model="form.electoral_section"
                                                            placeholder="Seção Eleitoral" />
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-4 gap-4 mt-5">
                                                    <div class="w-full">
                                                        <InputLabel for="electoral_municipality"
                                                            value="Município Eleitoral/U.F." />
                                                        <TextInput id="electoral_municipality" type="text"
                                                            class="mt-1 block w-full"
                                                            v-model="form.electoral_municipality"
                                                            placeholder="Município Eleitoral/U.F." />
                                                    </div>
                                                    <div class="w-full">
                                                        <InputLabel for="voter_issuance_date"
                                                            value="Emissão do Título" />
                                                        <TextInput id="voter_issuance_date" type="date"
                                                            class="mt-1 block w-full" v-model="form.voter_issuance_date"
                                                            placeholder="Emissão do Título" />
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Pessoa Jurídica -->
                                            <div v-if="form.person_type.isLegalPerson">
                                                <div class="grid grid-cols-4 gap-4 mt-5">
                                                    <div class="w-full">
                                                        <InputLabel for="corporate_name" value="Razão Social" />
                                                        <TextInput id="corporate_name" type="text"
                                                            class="mt-1 block w-full" v-model="form.corporate_name"
                                                            placeholder="Razão Social*" />
                                                    </div>
                                                    <div class="w-full">
                                                        <InputLabel for="nickname" value="Nome Fantasia" />
                                                        <TextInput id="nickname" type="text" class="mt-1 block w-full"
                                                            v-model="form.nickname" placeholder="Nome Fantasia" />
                                                    </div>
                                                    <div class="w-full">
                                                        <InputLabel for="cnpj" value="C.N.P.J." />
                                                        <TextInput id="cnpj" type="text" class="mt-1 block w-full"
                                                            v-model="form.cnpj" placeholder="C.N.P.J." />
                                                    </div>
                                                    <div class="w-full">
                                                        <InputLabel for="state_registration"
                                                            value="Inscrição Estadual" />
                                                        <TextInput id="state_registration" type="text"
                                                            class="mt-1 block w-full" v-model="form.state_registration"
                                                            placeholder="Inscrição Estadual" />
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-4 gap-4 mt-5">
                                                    <div class="w-full">
                                                        <InputLabel for="foundation_date" value="Fundação" />
                                                        <TextInput id="foundation_date" type="date"
                                                            class="mt-1 block w-full" v-model="form.foundation_date"
                                                            placeholder="Fundação" />
                                                    </div>
                                                    <div class="w-full with-icon">
                                                        <div class="flex gap-2 items-center">
                                                            <InputLabel for="activity" value="Atividade" />
                                                            <a href="#" title="Adicionar nova Atividade"><i
                                                                    class="material-icons">library_add</i></a>
                                                        </div>
                                                        <TextInput id="activity" type="text" class="mt-1 block w-full"
                                                            v-model="form.activity" placeholder="Atividade" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-4 gap-4 mt-5">
                                                <div class="w-full">
                                                    <InputLabel for="internal_code" value="Código Interno" />
                                                    <TextInput id="internal_code" type="text" class="mt-1 block w-full"
                                                        v-model="form.internal_code" placeholder="Código Interno" />
                                                </div>

                                                <div class="w-full with-icon">
                                                    <div class="flex gap-2 items-center ">
                                                        <InputLabel for="group" value="Grupo" />
                                                        <a href="#" title="Adicionar novo grupo"><i
                                                                class="material-icons">library_add</i></a>
                                                    </div>
                                                    <Autocomplete :options="autocompleteOptionsGroup"
                                                            @selected="handleSelection" v-model="form.searchGroup"
                                                            class="mt-1 block w-full flex-grow" />
                                                </div>

                                                <div class="w-full">
                                                    <InputLabel for="zip_code" value="C.E.P." />
                                                    <TextInput id="zip_code" type="text" class="mt-1 block w-full"
                                                        v-model="form.zip_code" placeholder="C.E.P." />
                                                </div>

                                                <div class="w-full">
                                                    <InputLabel for="address" value="Endereço" />
                                                    <TextInput id="address" type="text" class="mt-1 block w-full"
                                                        v-model="form.address" placeholder="Endereço" />
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-4 gap-4 mt-5">
                                                <div class="w-full">
                                                    <InputLabel for="address_number" value="Número" />
                                                    <TextInput id="address_number" type="text" class="mt-1 block w-full"
                                                        v-model="form.address_number" placeholder="Número" />
                                                </div>

                                                <div class="w-full">
                                                    <InputLabel for="address_complement" value="Complemento" />
                                                    <TextInput id="address_complement" type="text"
                                                        class="mt-1 block w-full" v-model="form.address_complement"
                                                        placeholder="Complemento" />
                                                </div>

                                                <div class="w-full">
                                                    <InputLabel for="neighborhood" value="Bairro" />
                                                    <TextInput id="neighborhood" type="text" class="mt-1 block w-full"
                                                        v-model="form.neighborhood" placeholder="Bairro" />
                                                </div>

                                                <div class="w-full relative">
                                                    <InputLabel for="city" value="Cidade" />
                                                    <TextInput id="city" type="text" class="mt-1 block w-full"
                                                        v-model="form.city" placeholder="Cidade" @input="handleInput" />
                                                    <div v-if="form.suggestions.length > 0"
                                                        class="absolute z-10 w-full mt-1">
                                                        <ul
                                                            class="bg-white border border-gray-300 rounded-lg shadow-lg max-h-48 overflow-y-auto">
                                                            <li v-for="(suggestion, index) in form.suggestions"
                                                                :key="index"
                                                                class="p-2 hover:bg-gray-100 cursor-pointer transition-colors duration-200"
                                                                @click="selectSuggestion(suggestion)">
                                                                {{ suggestion.nome }} - {{ suggestion.estado }}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-4 gap-4 mt-5">
                                                <div class="w-full">
                                                    <InputLabel for="state" value="U.F." />
                                                    <TextInput id="state" type="text" class="mt-1 block w-full"
                                                        v-model="form.state" placeholder="U.F." />
                                                </div>

                                                <div class="w-full">
                                                    <InputLabel for="phone" value="Telefone" />
                                                    <TextInput id="phone" type="text" class="mt-1 block w-full"
                                                        v-model="form.phone" placeholder="Telefone" />
                                                </div>

                                                <div class="w-full">
                                                    <InputLabel for="cell" value="Celular/Fax" />
                                                    <TextInput id="cell" type="text" class="mt-1 block w-full"
                                                        v-model="form.cell" placeholder="Celular/Fax" />
                                                </div>

                                                <div class="w-full">
                                                    <InputLabel for="email" value="E-mails (Separados por ;)" />
                                                    <TextInput id="email" type="text" class="mt-1 block w-full"
                                                        v-model="form.email" placeholder="E-mails (Separados por ;)" />
                                                </div>
                                            </div>

                                            <div class="mt-4">
                                                <label for="observation" class="block text-gray-700">Observação</label>
                                                <textarea class="w-full p-2 border rounded" id="observation"
                                                    v-model="form.observation"></textarea>
                                            </div>

                                            <h5 class="text-lg font-bold mb-3">Acesso aos Andamentos Processuais na Web
                                                Sala
                                                *</h5>
                                            <div class="grid grid-cols-4 gap-4 mt-5">
                                                <div class="w-full">
                                                    <InputLabel for="username" value="Usuário" />
                                                    <TextInput id="username" type="text" class="mt-1 block w-full"
                                                        v-model="form.username" placeholder="Usuário" />
                                                </div>

                                                <div class="w-full">
                                                    <InputLabel for="password" value="Senha" />
                                                    <TextInput id="password" type="text" class="mt-1 block w-full"
                                                        v-model="form.password" placeholder="Senha" />
                                                </div>

                                                <div class="w-full mt-5 pt-2">
                                                    <PrimaryButton>
                                                        Gerar Senha
                                                    </PrimaryButton>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-4 gap-4 mt-5">
                                                <div class="w-full">
                                                    <InputLabel for="file" value="Foto" />
                                                    <TextInput id="file" type="file" class="mt-1 block w-full"
                                                        v-model="form.file" />
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tab Dados do Advogado -->
                                        <div v-if="activeTab === 'dataLawyer'">
                                            <h5 class="text-lg font-bold mb-3">Dados do Advogado</h5>
                                            <div class="grid grid-cols-4 gap-4 mt-5">
                                                <div class="w-full with-icon">
                                                    <div class="flex gap-2 items-center">
                                                        <InputLabel for="area" value="Área" />
                                                        <a href="#" title="Adicionar Área"><i
                                                                class="material-icons">library_add</i></a>
                                                    </div>
                                                    <Autocomplete :options="autocompleteOptionsArea"
                                                            @selected="handleSelection" v-model="form.searchArea"
                                                            class="mt-1 block w-full flex-grow" />
                                                </div>

                                                <div class="w-full">
                                                    <InputLabel for="oab_number" value="Nº da OAB/UF" />
                                                    <TextInput id="oab_number" type="text" class="mt-1 block w-full"
                                                        v-model="form.oab_number" placeholder="Nº da OAB/UF" />
                                                </div>

                                                <div class="w-full">
                                                    <InputLabel for="effective_date" value="Expedição" />
                                                    <TextInput id="effective_date" type="date" class="mt-1 block w-full"
                                                        v-model="form.effective_date" placeholder="Expedição" />
                                                </div>

                                                <div class="w-full">
                                                    <InputLabel for="hourly_rate" value="Valor Hora do Time Sheet" />
                                                    <TextInput id="hourly_rate" type="text" class="mt-1 block w-full"
                                                        v-model="form.hourly_rate"
                                                        placeholder="Valor Hora do Time Sheet" />
                                                </div>
                                                <div class="flex items-center">
                                                    <input type="checkbox" class="mr-2">
                                                    <label class="text-sm">Colaborador Time Sheet</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tab Dados do Contato -->
                                        <div v-if="activeTab === 'dataContact'">
                                            <h5 class="text-lg font-bold mb-3">Dados do Contato</h5>
                                            <InputLabel for="legal_entity_contact" value="Contato da Pessoa Jurídica" />
                                            <TextInput id="legal_entity_contact" type="text" class="mt-1 block w-full"
                                                v-model="form.legal_entity_contact"
                                                placeholder="Contato da Pessoa Jurídica" />
                                        </div>
                                        <div class="flex items-center gap-4 justify-end mt-3">
                                            <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }"
                                                :disabled="form.processing">
                                                Salvar
                                            </PrimaryButton>

                                            <Link :href="route('clients.index')"
                                                class="text-gray-600 hover:text-gray-900">
                                            Cancelar
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>
