<template>
    <app-layout>
        <section class="tw-uppercase tw-mx-4">
            <Header :class="[color, style]">
                <slot>
                    <h3 class="tw-p-2">
                        <i class="fas fa-user tw-ml-3 tw-mr-3"></i>
                            Perfiles de Usuarios
                    </h3>
                </slot>
            </Header>
        </section>
        <!-- ******************************* FILTROS ********************************************* -->
        <section class="tw-flex tw-justify-between tw-content-center tw-border tw-p-2 tw-my-8 tw-mx-2">
            <div class="tw-flex tw-gap-4 tw-mx-2">

            </div>
            <div>
                <jet-button @click="openModal" class="BtnNuevo">NUEVA INFORMACIÓN</jet-button>
            </div>
        </section>
        <!-- ********************************* TABLAS ********************************************* -->
        <section class="tw-mx-4">
            <Table id="Perfiles">
                <template v-slot:TableHeader>
                    <th class="columna">EMPRESA</th>
                    <th class="columna">NÚM</th>
                    <th class="columna">NOMBRE </th>
                    <th class="columna">PATERNO </th>
                    <th class="columna">MATERNO </th>
                    <th class="columna">CURP </th>
                    <th class="columna">RFC </th>
                    <th class="columna">NSS </th>
                    <th class="columna">INGRESO </th>
                    <th class="columna">ANTIGUEDAD </th>
                    <th class="columna">DIAS VAC </th>
                    <th class="columna">PUESTO </th>
                    <th class="columna">DEPARTAMENTO </th>
                    <th class="columna">ACCIONES </th>
                </template>

                <template v-slot:TableFooter>
                    <tr class="fila" v-for="data in PerfilesUsuarios" :key="data.id">
                        <td>{{data.Empresa}}</td>
                        <td>{{data.IdEmp}}</td>
                        <td>{{data.Nombre}}</td>
                        <td>{{data.ApPat}}</td>
                        <td>{{data.ApMat}}</td>
                        <td>{{data.Curp}}</td>
                        <td>{{data.Rfc}}</td>
                        <td>{{data.Nss}}</td>
                        <td>{{data.FecIng}}</td>
                        <td>{{data.Antiguedad}}</td>
                        <td>{{data.DiasVac}}</td>
                        <td>{{data.perfil_puesto.Nombre}}</td>
                        <td>{{data.perfil_departamento.Nombre}}</td>
                        <td>
                            <div class="tw-flex tw-justify-center tw-items-center tw-gap-4">
                                <div class="iconoEdit" @click="edit(data)">
                                    <span tooltip="Editar" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="iconoCyan" @click="Vacaciones(data)">
                                    <span tooltip="Actualizar Vacaciones" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="iconoDelete" @click="deleteRow(data)">
                                    <span tooltip="Dar de Baja" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
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
        <modal :show="showModal" @close="chageClose" :maxWidth="tam">
            <div class="ModalHeader">
                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>REGISTRO DE INFORMACIÓN</h3>
            </div>

            <div class="ModalForm">
                <div class="tw-mb-6 tw-flex tw-gap-4 md:tw-flex">
                    <div class="tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label><span class="required">*</span>NÚMERO EMPLEADO</jet-label>
                        <jet-input type="text" v-model="form.IdEmp"></jet-input>
                        <small v-if="errors.IdEmp" class="validation-alert">{{errors.IdEmp}}</small>
                    </div>
                    <div class="ttw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label><span class="required">*</span>EMPRESA</jet-label>
                        <select class="InputSelect" v-model="form.Empresa">
                            <option value="HILATURAS">HILATURAS</option>
                            <option value="SHIELDTEX">SHIELDTEX</option>
                        </select>
                        <small v-if="errors.Empresa" class="validation-alert">{{errors.Empresa}}</small>
                    </div>
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-show="!editMode">
                        <jet-label><span class="required">*</span>JEFE</jet-label>
                        <select class="InputSelect" v-model="form.jefes_areas_id">
                            <option v-for="jefe in Jefes" :key="jefe.IdEmp" :value="jefe.IdEmp" > {{ jefe.Nombre }}</option>
                        </select>
                        <small v-if="errors.jefes_areas_id" class="validation-alert">{{errors.jefes_areas_id}}</small>
                    </div>
                </div>
                <div class="tw-mb-6 tw-flex tw-gap-4 md:tw-flex">
                    <div class="tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label><span class="required">*</span>NOMBRE</jet-label>
                        <jet-input type="text" v-model="form.Nombre"></jet-input>
                        <small v-if="errors.Nombre" class="validation-alert">{{errors.Nombre}}</small>
                    </div>
                    <div class="tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label><span class="required">*</span>APELLIDO PATERNO</jet-label>
                        <jet-input type="text" v-model="form.ApPat"></jet-input>
                        <small v-if="errors.ApPat" class="validation-alert">{{errors.ApPat}}</small>
                    </div>
                    <div class="tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label><span class="required">*</span>APELLIDO MATERNO</jet-label>
                        <jet-input type="text" v-model="form.ApMat"></jet-input>
                        <small v-if="errors.ApMat" class="validation-alert">{{errors.ApMat}}</small>
                    </div>
                </div>
                <div class="tw-mb-6 tw-flex tw-gap-4 md:tw-flex">
                    <div class="tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label>CURP</jet-label>
                        <jet-input type="text" v-model="form.Curp"></jet-input>
                    </div>
                    <div class="tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label>NÚMERO DE SEGURO SOCIAL</jet-label>
                        <jet-input type="text" v-model="form.Nss"></jet-input>
                    </div>
                    <div class="tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label>RFC</jet-label>
                        <jet-input type="text" v-model="form.Rfc"></jet-input>
                    </div>
                </div>
                <div class="tw-mb-6 tw-flex tw-gap-4 md:tw-flex">
                    <div class="tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label>FECHA DE INGRESO</jet-label>
                        <jet-input type="date" v-model="form.FecIng"></jet-input>
                        <small v-if="errors.FecIng" class="validation-alert">{{errors.FecIng}}</small>
                    </div>
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label><span class="required">*</span>PUESTO</jet-label>
                        <select class="InputSelect" v-model="form.Puesto_id">
                            <option v-for="puesto in Puestos" :key="puesto.id" :value="puesto.id" > {{ puesto.Nombre }}</option>
                        </select>
                        <small v-if="errors.Puesto_id" class="validation-alert">{{errors.Puesto_id}}</small>
                    </div>
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label><span class="required">*</span>DEPARTAMENTO</jet-label>
                        <select class="InputSelect" v-model="form.Departamento_id">
                            <option v-for="dep in Departamentos" :key="dep.id" :value="dep.id" > {{ dep.Nombre }}</option>
                        </select>
                        <small v-if="errors.Departamento_id" class="validation-alert">{{errors.Departamento_id}}</small>
                    </div>
                </div>
            </div>

            <div class="ModalFooter">
                <jet-button type="button" @click="save(form)" v-show="!editMode">Guardar</jet-button>
                <jet-button type="button" @click="update(form)" v-show="editMode">Actualizar</jet-button>
                <jet-CancelButton @click="chageClose">Cerrar</jet-CancelButton>
            </div>
        </modal>

        <modal :show="showDiasVac" @close="chageDiasVac" maxWidth="xl">
            <div class="ModalHeader">
                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>ACTUALIZA VACACIONES</h3>
            </div>

            <div class="tw-flex tw-flex-col tw-my-2 tw-p-2 tw-uppercase tw-bg-blueGray-50 tw-border-teal-500 tw-border-t-2 tw-border-b-2">
                <div class="tw-flex tw-justify-center"><p class="tw-font-bold tw-text-lg">{{form.IdEmp}} - {{form.Nombre}} {{form.ApPat}} {{form.ApMat}}</p></div>
                <div class="tw-flex tw-justify-center"><p class="tw-font-bold tw-text-xs">Días de vacaciones restantes: <span class="tw-font-bold tw-text-base tw-text-teal-600">{{form.DiasVac}}</span></p></div>
                <div class="tw-flex tw-justify-center"><p class="tw-font-bold tw-text-xs">Fecha Ingreso: <span class="tw-font-bold tw-text-base tw-text-teal-600">{{form.FecIng}}</span></p></div>
            </div>

            <div class="ModalForm">
                <div class="tw-mb-6 tw-flex tw-justify-center tw-gap-4 md:tw-flex">
                    <div class="tw-mb-6 md:tw-w-2xl md:tw-mb-0">
                        <jet-label><span class="required">*</span>VACACIONES</jet-label>
                        <jet-input type="text" v-model="form.DiasVac"></jet-input>
                        <small v-if="errors.DiasVac" class="validation-alert">{{errors.DiasVac}}</small>
                    </div>
                </div>
            </div>

            <div class="ModalFooter">
                <jet-button type="button" @click="ActualizaVac(form)">Guardar</jet-button>
                <jet-CancelButton @click="chageDiasVac">Cerrar</jet-CancelButton>
            </div>
        </modal>
    </app-layout>
</template>

<script>
require( 'datatables.net-buttons-bs5/js/buttons.bootstrap5' );
require( 'datatables.net-buttons/js/buttons.html5' );
require ( 'datatables.net-buttons/js/buttons.colVis' );

import AppLayout from "@/Layouts/AppLayout";
import Welcome from "@/Jetstream/Welcome";
import Header from "@/Components/Header";
import Accions from "@/Components/Accions";
import Table from "@/Components/TableGreen";
import JetButton from "@/Components/Button";
import JetCancelButton from "@/Components/CancelButton";
import Modal from "@/Jetstream/Modal";
import Pagination from "@/Components/pagination";
import JetInput from "@/Components/Input";
import JetLabel from '@/Jetstream/Label';
import JetSelect from "@/Components/Select";
// *********** JQUERY ************
import $ from "jquery";
//  ********* DATATABLES **********
import datatable from "datatables.net-bs5";
// ******** MOMENT JS **********
import moment from 'moment';
import 'moment/locale/es';

export default {
    data() {
        return {
            showDiasVac: false,
            now: moment().format("YYYY-MM-DD"),
            tam: "4xl",
            color: "tw-bg-green-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            form: {
                IdUser: this.Session.id,
                IdEmp: '',
                jefes_areas_id: '',
                Empresa: '',
                Nombre: '',
                ApPat: '',
                ApMat: '',
                Curp: '',
                Rfc: '',
                Nss: '',
                FecIng: '',
                Antiguedad: '',
                DiasVac: '',
                Puesto_id: '',
                Departamento_id: '',
            },
            params: {
                TipoEmpresa: '',
            },
            rows: [
                {name: ""}
            ]
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
        errors: Object,
        PerfilesUsuarios: Object,
        Jefes: Object,
        Puestos: Object,
        Departamentos: Object,
    },

    methods: {
        //GENERACION DE TABLA CON DATATABLES
        tabla(){
            this.$nextTick(() => {
                $("#Perfiles").DataTable({
                    destroy      :true,
                    stateSave   : true,
                    "language": this.español,
                    paging: true,
                    pageLength : 20,
                    scrollX: true,
                    scrollY:  '40vh',
                    order: [0, 'desc'],
                    columnDefs: [
                        { "width": "5%", "targets": [0,2,3,4] },
                        { "width": "3%", "targets": [1] },
                    ],
                    "dom": '<"row"<"col-sm-6 col-md-3"l><"col-sm-6 col-md-6"B><"col-sm-12 col-md-3"f>>'+
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: [
                    ]
                }).draw();
            });
        },

        FechaMayor(event){
            var fecha1 = event.target.value;
            var fecha2 = moment(); //fecha de hoy
            var tiempo = fecha2.diff(fecha1, 'hours');
            if(tiempo < 0){
                console.log("fecha invalida");
                event.target.value = '';
            }
        },

        Renapo: function (curp) {
            var regex = /^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/;
            return regex.test(curp);
        },

        SeguroSocial: function (rfc) {
            var regex = /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
            return regex.test(rfc);
        },

        Rfc: function (nss) {
            var regex = /^(\d{2})(\d{2})(\d{2})\d{5}$/;
            return regex.test(nss);
        },

        Celular(cel){
           var regex = /^(\(\+?\d{2,3}\)[\*|\s|\-|\.]?(([\d][\*|\s|\-|\.]?){6})(([\d][\s|\-|\.]?){2})?|(\+?[\d][\s|\-|\.]?){8}(([\d][\s|\-|\.]?){2}(([\d][\s|\-|\.]?){2})?)?)$/;
            return regex.test(cel);
        },

        ValidaCurp(event) {
            if (!this.Renapo(event.target.value)){
                console.log("CURP NO VALIDO")
                this.alertWarning();
            }else{
                console.log("CURP CORRECTO")
            }
        },

        ValidaNss(event){
            if (!this.SeguroSocial(event.target.value)){
                console.log("NSS NO VALIDO")
                this.alertWarning();
            }else{
                console.log("nss CORRECTO")
            }
        },

        ValidaRfc(event){
            if (!this.Rfc(event.target.value)){
                console.log("rfc NO VALIDO")
                this.alertWarning();
            }else{
                console.log("rfc CORRECTO")
            }
        },

        ValidaCel(event){
            if (!this.Celular(event.target.value)){
                this.alertWarning();
            }else{
                console.log("Celular CORRECTO")
            }
        },

        reset() {
            this.form = {
                IdUser: this.Session.id,
                IdEmp: '',
                jefes_areas_id: '',
                Empresa: '',
                Nombre: '',
                ApPat: '',
                ApMat: '',
                Curp: '',
                Rfc: '',
                Nss: '',
                FecIng: '',
                Antiguedad: '',
                DiasVac: '',
                Puesto_id: '',
                Departamento_id: '',
            };
        },

        save(data) {

            //Obtengo la fecha ingresada
            var fecha1 = data.FecIng;
            var fecha2 = moment(); //fecha de hoy

            //calculo de diferencia de años entre las 2 fechas
            data.Antiguedad = fecha2.diff(fecha1, 'years')

            if(data.Antiguedad > 0){ //si tiene años de antiguedad entra al proceso

                if(data.Antiguedad <= 5){
                    // menor a 5 años se agregan 2 dias por cada año cumplido
                switch(data.Antiguedad){
                    case 1: data.DiasVac = 6; break;
                    case 2: data.DiasVac = 8; break;
                    case 3: data.DiasVac = 10; break;
                    case 4: data.DiasVac = 12; break;
                    case 5: data.DiasVac = 14; break;
                }
                //proceso de agregar 2 dias por cada 5 años cumplidos de antiguedad
                }else if(data.Antiguedad <= 9){
                    data.DiasVac = 14;
                }else if(data.Antiguedad >= 10 && data.Antiguedad <= 14){
                    data.DiasVac = 16;
                }else if(data.Antiguedad >= 15 && data.Antiguedad <= 19){
                    data.DiasVac = 18;
                }else if(data.Antiguedad >= 20 && data.Antiguedad <= 24){
                    data.DiasVac = 20;
                }else if(data.Antiguedad >= 25 && data.Antiguedad <= 29){
                    data.DiasVac = 22;
                }else if(data.Antiguedad >= 30 && data.Antiguedad <= 24){
                    data.DiasVac = 24;
                }
            }else{
                data.DiasVac = 0;
            }
            this.$inertia.post("/RecursosHumanos/PerfilesUsuarios", data, {
                onSuccess: () => {
                    this.reset(), this.chageClose(), this.alertSucces();
                },
            });
        },

        edit: function (data) {
            this.form = Object.assign({}, data);
            this.editMode = true;
            this.chageClose();
        },

        update(data) {
            data.metodo = 1;
            data._method = "PUT";
            this.$inertia.post("/RecursosHumanos/PerfilesUsuarios/" + data.id, data, {
                onSuccess: () => {
                this.reset(), this.chageClose(), this.alertSucces();
                },
            });
        },

        chageDiasVac() {
            this.showDiasVac = !this.showDiasVac;
        },

        Vacaciones(data){
            this.chageDiasVac();
            this.form = Object.assign({}, data);
        },

        deleteRow: function (data) {
            Swal.fire({
                title: '¿Estas seguro de querer eliminar esta información',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, bórralo!',
                cancelButtonText: 'No, Cancelar!',
                }).then((result) => {
                if (result.isConfirmed) {

                    data._method = "DELETE";
                    this.$inertia.post("/RecursosHumanos/PerfilesUsuarios/" + data.id, data, {
                        onSuccess: () => {
                            Swal.fire(
                                'Eliminado!',
                                'El registro fue eliminado con éxito',
                                'success'
                            )
                        },
                    });
                }
                })
        },

        show: function (data) {
            this.form = Object.assign({}, data);
        },

        ActualizaVac(data){
            data.metodo = 2;
            data._method = "PUT";
            this.$inertia.post("/RecursosHumanos/PerfilesUsuarios/" + data.id, data, {
                onSuccess: () => {
                    this.reset(),
                    this.chageDiasVac(),
                    this.alertSucces();
                },
            });
        }
    },

    watch: {
    }
};
</script>
