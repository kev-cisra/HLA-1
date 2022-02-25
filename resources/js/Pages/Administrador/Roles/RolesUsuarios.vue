<template>
    <app-layout>
        <!-- ****************************************** TITULO ********************************************* -->
        <section class="tw-uppercase tw-mx-4">
            <Header :class="[color, style]">
                <slot>
                    <h3 class="tw-p-2"><i class="fas fa-diagnoses tw-ml-3 tw-mr-3"></i>ROLES DE USUARIOS</h3>
                </slot>
            </Header>
        </section>

        <!-- ****************************************** CONTENIDO ********************************************* -->
        <section class="tw-my-4 tw-mx-4">
            <Table id="TablaRoles">
                <template v-slot:TableHeader>
                    <th class="columna">Id</th>
                    <th class="columna">IdEmp</th>
                    <th class="columna">Empresa</th>
                    <th class="columna">Nombre</th>
                    <th class="columna">Acciones</th>
                </template>

                <template v-slot:TableFooter>
                    <tr class="fila tw-text-sm" v-for="data in Users" :key="data.id">
                        <td class="tw-text-center">{{data.id}}</td>
                        <td class="tw-text-center">{{data.IdEmp}}</td>
                        <td class="tw-text-center">{{data.Empresa}}</td>
                        <td>{{data.name}}</td>
                        <td>
                            <div class="tw-flex tw-justify-center tw-items-center tw-gap-4">
                                <div class="iconoEdit" @click="RolesSpatie(data)">
                                    <span tooltip="Modifica Rol" flow="left">
                                        <i class="fas fa-user-shield"></i>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                </template>
            </Table>
        </section>

        <!-- **************************************************** MODALES ****************************************************** -->
        <modal :show="showModal" @close="chageClose" :maxWidth="tam">
            <div class="ModalHeader">
                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Roles</h3>
            </div>

            <div class="ModalForm">
                <div class="overflow-auto tw-h-96">
                    <div v-for="rol in Roles" :key="rol" class="tw-p-1 hover:tw-bg-gradient-to-r hover:tw-from-teal-500">
                            <input type="checkbox" :id="rol.id" v-model="form.RolesUsu" :value="rol.id" class="checbox-teal">
                        <label :for="rol.id" class="tw-font-bold">
                            {{ rol.name }}
                        </label>
                    </div>
                </div>
            </div>

            <div class="ModalFooter">
                <jet-button type="button" @click="save(form)">Guardar</jet-button>
                <jet-CancelButton @click="chageClose">Cerrar</jet-CancelButton>
            </div>
        </modal>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Welcome from "@/Jetstream/Welcome";
import Header from "@/Components/Header";
import Accions from "@/Components/Accions";
import Table from "@/Components/TableDark";
import JetButton from "@/Components/Button";
import JetCancelButton from "@/Components/CancelButton";
import Modal from "@/Jetstream/Modal";
import Pagination from "@/Components/pagination";
import JetLabel from '@/Jetstream/Label';
import JetInput from "@/Components/Input";
import JetSelect from "@/Components/Select";
//imports de datatables
import datatable from "datatables.net-bs5";
import $ from "jquery";
import moment from 'moment';
import 'moment/locale/es';


export default {

    data() {
        return {
            tam: "xl",
            color: "tw-bg-black",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            form: {
                User_id: 0,
                RolesUsu: [],
            },
        };
    },

    components: {
        AppLayout,
        Welcome,
        Header,
        Accions,
        JetLabel,
        JetInput,
        JetSelect,
        JetButton,
        JetCancelButton,
        Table,
        Modal,
        Pagination,
    },

    props: {
        Users: Object,
        Roles: Object,
    },

    mounted(){
        this.tabla();
    },

    methods: {
        tabla(){
            this.$nextTick(() => {
                $("#TablaRoles").DataTable({
                    destroy: true,
                    language: this.español,
                    paging: false,
                    pageLength : 20,
                    scrollY:  '55vh',
                    order: [0, 'asc'],
                    "dom": '<"row"<"col-sm-6 col-md-3"l><"col-sm-6 col-md-6"B><"col-sm-12 col-md-3"f>>'+
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: [
                    ]
                }).draw();
            });
        },

        RolesSpatie(data){
            this.chageClose();
            this.form.User_id = data.id;

            data.roles.forEach(element => {
                this.form.RolesUsu.push(element.id);
            });
        },

        reset(){
            this.form = {
                User_id: 0,
                RolesUsu: [],
            };
        },

        save(data){

            this.$inertia.post("/Admin/RolesUsuarios", data, {
                onSuccess: () => {
                    this.reset(),
                    this.chageClose(),
                    this.alertSucces();
                },
            });
        }
    },
};
</script>
