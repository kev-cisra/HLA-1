<template>
    <app-layout>
        <div class="tw-grid tw-grid-cols-6">
            <div class="tw-col-span-1">
                <nav class="tw-flex tw-flex-col tw-bg-black tw-min-h-screen tw-px-4 tw-tex-gray-900">
                    <div class="tw-flex tw-flex-wrap tw-mt-8">
                    <div class="tw-w-1/2">
                        <img src="https://ih1.redbubble.net/image.2809246254.3188/poster,504x498,f8f8f8-pad,600x600,f8f8f8.jpg" class="tw-mx-auto tw-w-12 tw-h-12 tw-rounded-full"/>
                    </div>
                    <div class="tw-w-1/2">
                        <span class="tw-font-bold tw-text-white">{{ Session.name }}</span>
                        <h4 class="tw-font-semibold tw-text-teal-500">{{Session.roles[0].name}}</h4>
                    </div>
                    </div>
                    <div class="tw-mt-10 tw-mb-4">
                        <ul class="tw-ml-4">
                            <li @click="Vista(1)" class="tw-cursor-pointer tw-mb-2 tw-px-2 tw-py-2 tw-font-bold tw-text-teal-500 tw-flex tw-flex-row  tw-border-teal-300 hover:tw-text-white hover:tw-bg-teal-500 tw-rounded-lg">
                                <span><svg class="tw-fill-current tw-h-5 tw-w-5 " viewBox="0 0 24 24"><path d="M16 20h4v-4h-4m0-2h4v-4h-4m-6-2h4V4h-4m6 4h4V4h-4m-6 10h4v-4h-4m-6 4h4v-4H4m0 10h4v-4H4m6 4h4v-4h-4M4 8h4V4H4v4z"></path></svg></span>
                                <span class="tw-ml-2">ROLES</span>
                            </li>
                            <li @click="Vista(2)" class="tw-cursor-pointer tw-mb-2 tw-px-2 tw-py-2 tw-font-bold tw-text-teal-500 tw-flex tw-flex-row  tw-border-teal-300 hover:tw-text-white hover:tw-bg-teal-500 tw-rounded-lg">
                                <span><svg class="tw-fill-current tw-h-5 tw-w-5 " viewBox="0 0 24 24"><path d="M16 20h4v-4h-4m0-2h4v-4h-4m-6-2h4V4h-4m6 4h4V4h-4m-6 10h4v-4h-4m-6 4h4v-4H4m0 10h4v-4H4m6 4h4v-4h-4M4 8h4V4H4v4z"></path></svg></span>
                                <span class="tw-ml-2">PERMISOS</span>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="tw-col-span-5 tw-mx-4">
                <h2 class="tw-p-2 tw-bg-teal-600 tw-text-white tw-text-center tw-rounded-lg tw-my-2 tw-mx-24 tw-shadow">Lorem ipsum dolor sit amet.</h2>
                <div class="tw-flex tw-items-center tw-justify-between tw-mx-80 tw-my-4 tw-p-4 tw-border-8">
                    <div><jet-label>NOMBRE {{vistaNombre}}</jet-label><jet-input type="text" v-model="form.NombreRol"></jet-input></div>
                    <div><jet-button type="button" @click="NuevoRol(form)">Guardar</jet-button></div>
                </div>
                <div class="tw-grid tw-grid-cols-3 tw-gap-4">
                    <div class="tw-col-span-2">
                        <Table id="datos">
                            <template v-slot:TableHeader>
                                <th class="columna">NOMBRE {{vistaNombre}}</th>
                                <th class="columna">ACCIONES</th>
                            </template>

                            <template v-slot:TableFooter>
                                <tr class="fila" v-for="rol in Roles" :key="rol.id">
                                    <td class="tw-p-2">{{rol.name}}</td>
                                    <td>
                                        <div class="tw-flex tw-justify-center tw-items-center tw-gap-4">
                                            <div class="iconoEdit" @click="edit(datos)">
                                                <span tooltip="Editar" flow="left">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="tw-h-6 tw-w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="iconoDelete" @click="deleteRow(datos)">
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
                    <div class="tw-col-span-1">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo aut rerum nesciunt ipsum porro voluptatum!</p>
                    </div>
                </div>
            </div>
        </div>
                        <div class="tw-p-2 tw-h-64 tw-h-64">
                    <div class="qrcode-style" id="qrcode"></div>
                </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Welcome from "@/Jetstream/Welcome";
import Header from "@/Components/Header";
import Accions from "@/Components/Accions";
import Table from "@/Components/TableTeal";
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
            color: "tw-bg-cyan-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            form: {
                NombreRol: '',
                NombrePermiso: '',
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
        this.tabla();
        this.qrcode();
    },

    methods: {
        qrcode() {
            let qrcode = new QRCode("qrcode", {
                ancho: 200, // establece el ancho en píxeles
                height: 200, // establece la altura en píxeles
                text: "https://intranethlangeles.com/Compras/Requisiciones?Year=2022&Month=2&Status=0&View=1&Req=", // Establezca el contenido del código QR o la dirección de redireccionamiento,
                colorDark : "#64748B",
                colorLight : "#ffffff",
            });
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

        //Generacion de Tabla con Datatables
        tabla(){
            this.$nextTick(() => {
                $("#datos").DataTable({
                    "language": this.español,
                    pageLength :10,
                    scrollY: '40vh',
                    paging: false,
                    scrollCollapse: true,
                });
            });
        },

        NuevoRol(data){
            console.log(data);
            this.form.Tipo = 1;
            this.$inertia.post("/Admin/AdminPanel", data, {
                    onSuccess: () => {
                        this.reset();
                        this.alertSucces();
                    },
            });
        },

        NuevoPermiso(data){
            console.log(data);
            this.form.Tipo = 2;
            this.$inertia.post("/Admin/AdminPanel", data, {
                    onSuccess: () => {
                        this.reset();
                        this.alertSucces();
                    },
            });
        },

        RevisaPermisos(data){
            this.$inertia.get('/Admin/AdminPanel', data, { //envio de variables por url
                onSuccess: () => {
                    console.log(this.RolPermisos)
                }, preserveState: true})
        },

        MustraPermiso(data){
            console.log(data)
        }
    },
};
</script>
