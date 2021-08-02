<template>
    <app-layout>
        <div>
            <Header>
                <slot>Usuarios del Sistema</slot>
            </Header>

            <Accions>
                <template v-slot:SelectB>
                    <select class="InputSelectFilter" v-model="Filter">
                        <option value="id" selected>Id</option>
                        <option value="Nombre">Nombre</option>
                        <option value="Area">Area</option>
                    </select>
                </template>
                <template v-slot:InputBusqueda>
                    <input type="text" :placeholder="'Filtro por '+Filter" class="InputSearch" v-model="search">
                </template>
                <template v-slot:BtnNuevo>
                    <jet-button @click="openModal" class="BtnNuevo">Nuevo Módulo </jet-button>
                </template>
            </Accions>

    <div class="container">
      <h1>Laravel Inertia JS Pagination Example - MyWebtuts.com</h1>
      <table class="table w-full border">
        <thead>
          <tr>
            <th class="p-3 border">ID</th>
            <th class="p-3 border">Name</th>
            <th class="p-3 border">Email</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users.data" :key="user.id">
            <td class="p-3 border">{{ user.id }}</td>
            <td class="p-3 border">{{ user.name }}</td>
            <td class="p-3 border">{{ user.email }}</td>
          </tr>
        </tbody>
      </table>

      <pagination class="mt-6" :links="users.links" />
    </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    import Header from '@/Components/Header'
    import Accions from '@/Components/Accions'
    import Table from '@/Components/Table'
    import JetButton from '@/Jetstream/Button'
    import Pagination from '@/Components/pagination'

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
            users: Object,
        },
    }
</script>


