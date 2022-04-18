<template>
    <app-layout>
        <section class="uppercase tw-mx-4">
            <Header :class="[color, style]">
                <slot>
                    <h3 class="tw-p-2">
                        <i class="fas fa-user tw-ml-3 tw-mr-3"></i>INSUMOS SOLICITADOS
                    </h3>
                </slot>
            </Header>
        </section>
        <!-- ********************************* TABLAS ********************************************* -->
        <section class="tw-mx-2 tw-my-10 md:tw-mx-10">
            <Table id="Insumos">
                <template v-slot:TableHeader>
                    <th class="columna">Folio</th>
                    <th class="columna">Fecha</th>
                    <th class="columna">Solicitante</th>
                    <th class="columna">Departamento</th>
                    <th class="columna">Lista Insumos</th>
                    <th class="columna">Estatus</th>
                    <th class="columna">ACCIONES</th>
                </template>

                <template v-slot:TableFooter>
                    <tr class="fila" v-for="data in RequisicionesInsumos" :key="data.id">
                        <td class="tw-text-center tw-font-black">RI-{{data.Folio}}</td>
                        <td class="tw-text-center">{{data.Fecha}}</td>
                        <td class="tw-text-center">{{data.perfil.Nombre}} {{data.perfil.ApPat}} {{data.perfil.ApMat}}</td>
                        <td class="tw-text-center">{{data.departamento.Nombre}}</td>
                        <td>
                            <p v-for="art in data.articulos" :key="art.id">
                                -{{art.Cantidad }} {{art.insumo.Clave }} {{art.insumo.Nombre }} {{art.insumo.Cantidad }} {{art.insumo.Unidad }}
                            </p>
                        </td>
                        <td>
                            <div class="FlexCenter">
                                <div v-if="data.Estatus == 0">
                                    <span tooltip="Solicitud Rechazada" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-rose-400 tw-rounded-full">RECHAZADO</span>
                                    </span>
                                </div>
                                <div v-if="data.Estatus == 1">
                                    <span tooltip="Pendiente por Confirmar" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-blueGray-400 tw-rounded-full">REGISTRADO</span>
                                    </span>
                                </div>
                                <div v-if="data.Estatus == 2">
                                    <span tooltip="Material Solicitado" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-emerald-500 tw-rounded-full">SOLICITADA</span>
                                    </span>
                                </div>
                                <div v-if="data.Estatus == 3">
                                    <span tooltip="Articulos pendientes por entregar" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-orange-500 tw-rounded-full">PARCIAL</span>
                                    </span>
                                </div>
                                <div v-if="data.Estatus == 4">
                                    <span tooltip="Solicitud entregada" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-violet-500 tw-rounded-full">ENTREGADO</span>
                                    </span>
                                </div>
                                <div v-if="data.Estatus == 5">
                                    <span tooltip="Material Adquirido" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-purple-500 tw-rounded-full">STOCK</span>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="FlexCenter">
                                <div class="iconoDetails" @click="ListaDeInsumos(data)" >
                                    <span tooltip="Visualiza Partidas" >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                </template>
            </Table>
        </section>
        <!-- **************************************************** MODALES ****************************************************** -->
        <!-- --------------- Modal visualizacion partidas ------------ -->
        <modal :show="showArticulos" @close="chageArticulos" :maxWidth="tam">
            <div class="ModalHeader">
                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>LISTA DE INSUMOS RI-{{form.Folio}}</h3>
            </div>

            <div class="ModalForm">
                <Table>
                    <template v-slot:TableHeader>
                        <th class="columna">Folio</th>
                        <th class="columna">Fecha</th>
                        <th class="columna">Solicitante</th>
                        <th class="columna">Departamento</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila">
                            <td class="tw-text-center tw-font-black">RI-{{form.Folio}}</td>
                            <td class="tw-text-center">{{form.Fecha}}</td>
                            <td class="tw-text-center">{{form.Perfil}}</td>
                            <td class="tw-text-center">{{form.Departamento}}</td>
                        </tr>
                    </template>
                </Table>

                <Table>
                    <template v-slot:TableHeader>
                        <th class="columna">Cantidad</th>
                        <th class="columna">Clave</th>
                        <th class="columna">Insumo</th>
                        <th class="columna">Estatus</th>
                        <th class="columna">Acciones</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila" v-for="data in ArticulosReq" :key="data.id">
                            <td class="tw-text-center">{{data.Cantidad}}</td>
                            <td class="tw-text-center">{{data.insumo.Clave}}</td>
                            <td class="tw-text-center">{{data.insumo.Nombre}}</td>
                            <td>
                                <div class="FlexCenter">
                                    <div v-if="data.Estatus == 2">
                                        <span tooltip="Material Solicitado" flow="left">
                                            <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-emerald-500 tw-rounded-full">SOLICITADO</span>
                                        </span>
                                    </div>
                                    <div v-if="data.Estatus == 3">
                                        <span tooltip="Material Entregado" flow="left">
                                            <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-cyan-500 tw-rounded-full">ENTREGADO</span>
                                        </span>
                                    </div>
                                    <div v-if="data.Estatus == 4">
                                        <span tooltip="Autorizado" flow="left">
                                            <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-violet-500 tw-rounded-full">APROBADO</span>
                                        </span>
                                    </div>
                                    <div v-if="data.Estatus == 5">
                                        <span tooltip="Material Adquirido" flow="left">
                                            <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-fuchsia-500 tw-rounded-full">STOCK</span>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="FlexCenter">
                                    <div class="iconoEdit" @click="Confirma(data)">
                                        <span tooltip="Entrega Material" flow="left">
                                            <i class="fa-solid fa-check"></i>
                                        </span>
                                    </div>
                                    <div class="iconoPurple" @click="EntregaParcial(data)">
                                        <span tooltip="Entrega Material Parcial" flow="left">
                                            <i class="fa-solid fa-box-open"></i>
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>
                </Table>

                <Table v-if="Parcialidad == true">
                    <template v-slot:TableHeader>
                        <th class="columna">Cantidad Solicitada</th>
                        <th class="columna">Insumo</th>
                        <th class="columna">Cantidad Disponible</th>
                        <th class="columna">Cantidad Faltante</th>
                        <th class="columna">Acciones</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila">
                            <td class="tw-text-center">{{ Parcial.Cantidad }}</td>
                            <td class="tw-text-center">{{ Parcial.Insumo }}</td>
                            <td class="tw-text-center"><jet-input type="text" v-model="Parcial.CantidadParcial"></jet-input></td>
                            <td class="tw-text-center">{{ Calcula }}</td>
                            <td>
                                <div class="FlexCenter">
                                    <div class="iconoGreen" @click="GeneraParcialidad(Parcial)">
                                        <span tooltip="Guarda Parcialidad" flow="left">
                                            <i class="fa-regular fa-floppy-disk"></i>
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>
                </Table>
            </div>

            <div class="ModalFooter">
                <jet-CancelButton @click="chageArticulos">Cerrar</jet-CancelButton>
            </div>
        </modal>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Welcome from "@/Jetstream/Welcome";
import Header from "@/Components/Header";
import Accions from "@/Components/Accions";
import Table from "@/Components/TableCyan";
import JetButton from "@/Components/Button";
import JetCancelButton from "@/Components/CancelButton";
import Modal from "@/Jetstream/Modal";
import Pagination from "@/Components/pagination";
import JetInput from "@/Components/Input";
import JetLabel from '@/Jetstream/Label';
import JetSelect from "@/Components/Select";
//imports de datatables
import datatable from "datatables.net-bs5";
import $ from "jquery";

//Moment Js
import moment from 'moment';
import 'moment/locale/es';

export default {
    data() {
        return {
            now: moment().format("YYYY-MM-DD"),
            tam: "4xl",
            color: "tw-bg-cyan-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            showArticulos: false,
            Parcialidad: false,
            form: {
                IdUser: this.Session.id,
                Folio: '',
                Fecha: '',
                Departamento: '',
                Solicitante: '',
                EstatusReq: '',
            },
            Parcial: {
                id: '',
                Cantidad: '',
                Insumo: '',
                insumo_id: '',
                requisiciones_insumos_id: '',
                CantidadParcial: '',
                CantidadRestante: '',
            },
        };
    },

    mounted() {
        this.tabla();
    },

    components: {
        AppLayout,
        Welcome,
        Header,
        Accions,
        Table,
        JetButton,
        JetCancelButton,
        Modal,
        Pagination,
        JetInput,
        JetLabel,
        JetSelect,
    },

    props: {
        Session: Object,
        RequisicionesInsumos: Object,
        ArticulosReq: Object,
    },

    methods: {
        reset() {
            this.form = {
                IdUser: this.Session.id,
                Folio: '',
                Fecha: '',
                Departamento: '',
                Solicitante: '',
                EstatusReq: '',
            };
        },

       //Generacion de Tabla con Datatables
        tabla(){
            this.$nextTick(() => {
                $("#Insumos").DataTable({
                    destroy: true,
                    stateSave: true,
                    language: this.español,
                    paging: true,
                    pageLength : 20,
                    scrollX: true,
                    scrollY:  '40vh',
                    order: [0, 'desc'],
                    columnDefs: [
                        { "width": "5%", "targets": [0,1,5] },
                        { "width": "10%", "targets": [6] },
                    ],
                    "dom": '<"row"<"col-sm-6 col-md-3"l><"col-sm-6 col-md-6"B><"col-sm-12 col-md-3"f>>'+
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        'colvis'
                    ]
                }).draw();
            });
        },

        chageArticulos(){
            this.showArticulos = !this.showArticulos;
        },

        ListaDeInsumos(data){
            this.form.Folio = data.Folio;
            this.form.Fecha = data.Fecha;
            this.form.Departamento = data.departamento.Nombre;
            this.form.Perfil = data.perfil.Nombre +' '+ data.perfil.ApPat +' '+data.perfil.ApMat;
            this.form.EstatusReq = data.Estatus;

            this.$inertia.get('/Almacen/EntregaInsumos', { Req: data.id }, { //envio de variables por url
                onSuccess: () => {
                    this.chageArticulos();
            }, preserveState: true })
        },

        Confirma(data){
            data.Metodo = 1;
            data._method = "PUT";
            this.$inertia.post("/Almacen/EntregaInsumos/" + data.id, data, {
                onSuccess: () => {
                    this.Parcialidad = false;
                    this.alertSucces();
                },
            });
        },

        EntregaParcial(data){
            this.Parcial.id = data.id;
            this.Parcial.Cantidad = data.Cantidad;
            this.Parcial.Insumo = data.insumo.Nombre;
            this.Parcial.requisiciones_insumos_id = data.requisiciones_insumos_id;
            this.Parcial.insumo_id = data.insumo_id;
            this.Parcialidad = true;
        },

        GeneraParcialidad(data){
            console.log(data);
            data.Metodo = 2;
            data._method = "PUT";
            this.$inertia.post("/Almacen/EntregaInsumos/" + data.id, data, {
                onSuccess: () => {
                    this.Parcialidad = false;
                    this.alertSucces();
                },
            });
        }
    },

    computed: {
        Calcula(){
            let CantidadRestante = this.Parcial.Cantidad - this.Parcial.CantidadParcial;
            if(CantidadRestante <= 0){
                return "No valido";
            }else{
                this.Parcial.CantidadRestante = CantidadRestante;
                return CantidadRestante;
            }
        }
    }
};
</script>
