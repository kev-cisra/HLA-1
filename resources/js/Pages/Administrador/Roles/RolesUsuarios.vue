<template>
    <app-layout>
        <div>
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-calendar-check tw-ml-3 tw-mr-3"></i>
                    USUARIOS DEL SISTEMA
                </h3>
            </slot>
        </Header>

        <Accions>
            <template v-slot:paginate>
                <select v-model="params.paginate" class="paginate">
                    <option>5</option>
                    <option>10</option>
                    <option>25</option>
                    <option>35</option>
                    <option>50</option>
                </select>
            </template>

            <template v-slot:SelectB>
                <select class="InputSelectFilter" v-model="params.column">
                    <option value="id" selected>Id</option>
                    <option value="name">Nombre</option>
                    <option value="email">Departamento</option>
                </select>
            </template>

            <template v-slot:InputBusqueda>
                <input type="text" :placeholder="'Filtro por '+params.column" class="InputSearch" v-model="params.search">
            </template>

            <template v-slot:BtnNuevo>
            </template>

        </Accions>

        <div class="tw-mx-8">
            <Table>
                <template v-slot:TableHeader>
                    <th class="columna" @click="sort('id')">Id
                        <i v-if="params.field === 'id' && params.direction === 'asc'" class="float-right fas fa-sort-alpha-up-alt"></i>
                        <i v-if="params.field === 'id' && params.direction === 'desc'" class="float-right fas fa-sort-alpha-down-alt"></i>
                    </th>
                    <th class="columna" @click="sort('name')">Nombre
                        <i v-if="params.field === 'name' && params.direction === 'asc'" class="float-right fas fa-sort-alpha-up-alt"></i>
                        <i v-if="params.field === 'name' && params.direction === 'desc'" class="float-right fas fa-sort-alpha-down-alt"></i>
                    </th>
                    <th class="columna" @click="sort('Departamento')">Departamento
                        <i v-if="params.field === 'Departamento' && params.direction === 'asc'" class="float-right fas fa-sort-alpha-up-alt"></i>
                        <i v-if="params.field === 'Departamento' && params.direction === 'desc'" class="float-right fas fa-sort-alpha-down-alt"></i>
                    </th>
                    <th class="columna tw-text-center">Acciones</th>
                </template>

                <template v-slot:TableFooter>
                    <tr class="fila" v-for="user in Users.data" :key="user.id">
                        <td class="tw-p-2">{{ user.id }}</td>
                        <td class="tw-p-2">{{ user.name }}</td>
                        <td class="tw-p-2">{{ user.Departamento }}</td>
                        <td class="tw-p-2">
                            <div class="columnaIconos">
                                <div class="iconoEdit">
                                    <a :href="route('admin.users.edit', user.id)">
                                        <span tooltip="Editar" flow="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                </template>
            </Table>
            <pagination class="tw-mt-6 tw-ml-4" :links="Users.links" />
        </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    import Header from '@/Components/Header'
    import Accions from '@/Components/Accions'
    import Table from '@/Components/TableGreen'
    import JetButton from '@/Jetstream/Button'
    import Pagination from '@/Components/pagination'
    import pickBy from 'lodash/pickBy'
    import throttle from 'lodash/throttle'

    export default {
        components: {
            AppLayout,
            Welcome,
            Header,
            Accions,
            Table,
            JetButton,
            Pagination,
        },

        props: {
            Session: Object,
            filters: Object,
            Users: Object,
            Roles: Object,
        },

        data(){
            return{
                tam: "4xl",
                color: "tw-bg-green-600",
                style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
                params:{
                    search: this.filters.search,
                    column: 'id',
                    paginate: 5,
                    field: 'id',
                    direction: 'desc'
                },
            };
        },

        methods:{
            sort(field){
                // this.params.paginate = paginate;
                this.params.field = field;
                this.params.direction = this.params.direction === 'asc' ? 'desc' : 'asc';
            }
        },

        watch: {
            params: {
            deep: true,
                handler: throttle(function() {
                    this.$inertia.get('/Admin/RolesUsuarios', this.params , { replace: true, preserveState: true })
                    // this.$inertia.get(this.route('/Admin/Usuarios'), pickBy(this.params), { preserveState: true })
                }, 150),
            },
        },
    };
</script>


