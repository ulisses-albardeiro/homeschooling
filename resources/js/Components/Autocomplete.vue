<script>
export default {
    props: {
        options: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            search: "",
            filteredOptions: [],
            selectedIndex: -1
        };
    },
    methods: {
        filterOptions() {
            this.filteredOptions = this.options.filter(opt =>
                opt.searchResult.toLowerCase().includes(this.search.toLowerCase())
            );
            this.selectedIndex = -1;
        },
        moveDown() {
            if (this.selectedIndex < this.filteredOptions.length - 1) {
                this.selectedIndex++;
            }
        },
        moveUp() {
            if (this.selectedIndex > 0) {
                this.selectedIndex--;
            }
        },
        selectOption(option = null) {
            const selected = option || this.filteredOptions[this.selectedIndex];
            if (selected) {
                this.search = selected.searchResult;
                this.$emit("selected", selected);
                this.filteredOptions = [];
            }
        }
    }
};
</script>

<template>
    <div class="relative w-full">
        <input type="text" v-model="search" @input="filterOptions" @keydown.down="moveDown" @keydown.up="moveUp"
            @keydown.enter="selectOption" placeholder="Digite para buscar..."
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
        <ul v-if="search.length" class="absolute z-10 w-full mt-1 bg-white border rounded-lg shadow-lg">
            <li v-for="(option, index) in filteredOptions" :key="option.value" @click="selectOption(option)" :class="[
                'px-4 py-2 cursor-pointer hover:bg-gray-200',
                { 'bg-blue-100': index === selectedIndex }
            ]">
                {{ option.searchResult }}
            </li>
        </ul>
    </div>
</template>
