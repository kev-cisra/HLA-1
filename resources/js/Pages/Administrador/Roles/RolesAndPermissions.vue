<template>
    <app-layout>
        <!-- ****************************************** TITULO ********************************************* -->
        <section class="tw-uppercase tw-mx-4">
            <Header :class="[color, style]">
                <slot>
                    <h3 class="tw-p-2"><i class="fas fa-calendar-check tw-ml-3 tw-mr-3"></i>ROLES Y PERMISOS</h3>
                </slot>
            </Header>
        </section>
        <!-- ****************************************** GUARDADO ********************************************* -->
        <section class="tw-grid tw-my-4 tw-mx-4 tw-gap-y-4 md:tw-grid-cols-2 md:tw-gap-8 md:tw-my-4 md:tw-mx-28">
            <div class="tw-flex md:flex-row md:tw-items-center md:tw-justify-between md:tw-my-4 md:tw-p-4 md:tw-border-8 md:tw-gap-4">
                <div>
                    <jet-label>NOMBRE ROL</jet-label>
                    <jet-input type="text" v-model="form.NombreRol"></jet-input>
                </div>
                <div>
                    <jet-button type="button" @click="NuevoRol(form)">Guardar</jet-button>
                </div>
            </div>
            <div class="tw-flex md:flex-row md:tw-items-center md:tw-justify-between md:tw-my-4 md:tw-p-4 md:tw-border-8 md:tw-gap-8">
                <div>
                    <jet-label>NOMBRE PERMISO</jet-label>
                    <jet-input type="text" v-model="form.NombrePermiso"></jet-input>
                </div>
                <div>
                    <jet-button type="button" @click="NuevoPermiso(form)">Guardar</jet-button>
                </div>
            </div>
        </section>
        <!-- ****************************************** CONTENIDO ********************************************* -->
        <section class="tw-grid tw-my-4 tw-mx-4 md:tw-grid-cols-2 md:tw-my-4 md:tw-gap-8 md:tw-mx-28">
            <div>
                <Table id="Roles">
                    <template v-slot:TableHeader>
                        <th class="columna">ROL</th>
                        <th class="columna">ACCIONES</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila tw-text-sm" v-for="rol in Roles" :key="rol.id">
                            <td class="tw-p-2">{{rol.name}}</td>
                            <td>
                                <div class="tw-flex tw-justify-center tw-items-center tw-gap-4">
                                    <div class="iconoEdit" @click="PermisosRol(rol)">
                                        <span tooltip="Editar" flow="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="tw-h-6 tw-w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="iconoDelete" @click="deleteRow(rol)">
                                        <span tooltip="Eliminar" flow="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="tw-h-6 tw-w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>
                </Table>
            </div>
            <div>
                <Table id="Permisos">
                    <template v-slot:TableHeader>
                        <th class="columna">PERMISOS</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila tw-text-base" v-for="per in Permisos" :key="per">
                            <td>
                                <input type="checkbox" :id="per.id" v-model="form.permissions" :value="per.id" class="tw-form-checkbox tw-h-5 tw-w-5 tw-text-teal-600">
                                <label :for="per.id" class="tw-ml-2 tw-text-gray-700">
                                    {{ per.name }}
                                </label>
                            </td>
                        </tr>
                    </template>
                </Table>
            </div>
        </section>
        <section class="tw-flex tw-my-8 tw-mx-4 tw-justify-center md:tw-mx-28">
            <jet-button type="button"  @click="Sincroniza(form)">Guarda Cambios</jet-button>
        </section>

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

import QRCode from "qrcodejs2";

export default {

    data() {
        return {
            tam: "3xl",
            color: "tw-bg-black",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            form: {
                NombreRol: '',
                NombrePermiso: '',
                Rol_id: '',
                Tipo: '',
                permissions: [],
            },
            vista: 1,
            vistaNombre: 'ROL',
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
        Session: Object,
        Roles: Object,
        Permisos: Object,
        RolPermisos: Object,
    },

    mounted(){
        this.qrcode();
        this.tablaRoles();
        this.tablaPermisos();
        this.Calendario();
    },

    methods: {
        qrcode() {
            // let qrcode = new QRCode("qrcode", {
            //     ancho: 200, // establece el ancho en píxeles
            //     height: 200, // establece la altura en píxeles
            //     text: "https://intranethlangeles.com/Compras/Requisiciones?Year=2022&Month=2&Status=0&View=1&Req=", // Establezca el contenido del código QR o la dirección de redireccionamiento,
            //     colorDark : "#64748B",
            //     colorLight : "#ffffff",
            // });
        },

        Calendario(){
            var calendar = new window.Calendar($('#calendar').get(0), {
            plugins: [window.interaction, window.dayGridPlugin, window.timeGridPlugin, window.listPlugin],
            selectable: true,
            initialView: 'dayGridMonth',
            eventBorderColor: 'white',

            });

            calendar.render();
        },

        reset(){
            this.form = {
                NombreRol: '',
                NombrePermiso: '',
                Tipo: '',
            };
        },

        Vista(value){
            this.vista = value;
            switch (value) {
                case 1:
                    this.vistaNombre = 'Rol';
                    break;

                case 2:
                    this.vistaNombre = 'Permiso';
                    break;
            }
        },

        tablaRoles(){
            this.$nextTick(() => {
                $("#Roles").DataTable({
                    destroy: true,
                    language: this.español,
                    paging: false,
                    pageLength : 10,
                    bInfo: false,
                    searching: false,
                    scrollY:  '55vh',
                    order: [0, 'desc'],
                    "dom": '<"row"<"col-sm-6 col-md-3"l><"col-sm-6 col-md-6"B><"col-sm-12 col-md-3"f>>'+
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: [
                    ]
                }).draw();
            });
        },

        tablaPermisos(){
            this.$nextTick(() => {
                $("#Permisos").DataTable({
                    destroy: true,
                    language: this.español,
                    paging: false,
                    pageLength : 10,
                    bInfo: false,
                    searching: false,
                    scrollY:  '55vh',
                    order: [0, 'desc'],
                    "dom": '<"row"<"col-sm-6 col-md-3"l><"col-sm-6 col-md-6"B><"col-sm-12 col-md-3"f>>'+
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: [
                    ]
                }).draw();
            });
        },

        NuevoRol(data){
            console.log(data);
            this.form.Tipo = 1;
            this.$inertia.post("/Admin/Spatie", data, {
                    onSuccess: () => {
                        this.reset();
                        this.alertSucces();
                    },
            });
        },

        NuevoPermiso(data){
            console.log(data);
            this.form.Tipo = 2;
            this.$inertia.post("/Admin/Spatie", data, {
                    onSuccess: () => {
                        this.reset();
                        this.alertSucces();
                    },
            });
        },

        PermisosRol(data){
            this.form.Rol_id = data.id;
            this.form.permissions = [];
            this.$inertia.get('/Admin/Spatie', data, { //envio de variables por url
                onSuccess: () => {
                    this.RolPermisos.permissions.forEach(element => {
                        this.form.permissions.push(element.id);
                    });
                }, preserveState: true})
        },

        Sincroniza(data){
            data.metodo = 1;
            data._method = "PUT";
            this.$inertia.post("/Admin/Spatie/" + data.id, data, {
                onSuccess: () => {
                    this.alertSucces();
                },
            });
        },
    },
};
</script>
