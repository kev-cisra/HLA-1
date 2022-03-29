<template>
    <app-layout>
        <!-- ****************************************** TITULO ********************************************* -->
        <section class="tw-uppercase tw-mx-4">
            <Header :class="[color, style]">
                <slot>
                    <h3 class="tw-p-2"><i class="fas fa-calendar-check tw-ml-3 tw-mr-3"></i>REGISTRO DE INFORMACIÓN</h3>
                </slot>
            </Header>
        </section>

        <!-- ****************************************** Subtitulo ********************************************* -->
        <section class="tw-m-4 tw-flex tw-justify-center tw-gap-4 tw-p-2">
            <div><span class="tw-font-bold tw-text-lg"> {{PerfilSession.Nombre}} {{PerfilSession.ApPat}} {{PerfilSession.ApMat}}</span></div>
            <div><span class="tw-font-bold tw-text-lg">Renovacion: {{ PerfilSession.FecIng.substr(5) }} - Dias Restantes: {{PerfilSession.DiasVac}}</span></div>
            <div class="IconAproved" @click="vacaciones(data, 1)" v-if="PerfilSession.DiasVac > 0">
                <span tooltip="Solicita de Vacaciones" flow="right">
                    <i class="tw-text-xl fa-solid fa-plane"></i>
                </span>
            </div>
            <div class="IconDenied" v-else>
                <span tooltip="No Cuentas con días disponibles" flow="right">
                    <i class="tw-text-xl fa-solid fa-plane-slash"></i>
                </span>
            </div>
        </section>

        <!-- ****************************************** TABLAS ********************************************* -->
        <section class="tw-mx-20 tw-my-4" v-if="JefeDepto == true">
            <Table id="Perfiles">
                <template v-slot:TableHeader>
                        <th class="columna">Empresa</th>
                        <th class="columna">Num Control</th>
                        <th class="columna">Nombre</th>
                        <th class="columna">Apellido Paterno</th>
                        <th class="columna">Apellido Materno</th>
                        <th class="columna">Departamento</th>
                        <th class="columna">Puesto</th>
                        <th class="columna">Vacaciones</th>
                        <th class="columna">Acciones</th>
                </template>

                <template v-slot:TableFooter>
                    <tr class="fila" v-for="data in Perfiles" :key="data.id">
                        <td>{{data.Empresa}}</td>
                        <td>{{data.IdEmp}}</td>
                        <td>{{data.Nombre}}</td>
                        <td>{{data.ApPat}}</td>
                        <td>{{data.ApMat}}</td>
                        <td>{{data.perfil_departamento.Nombre}}</td>
                        <td>{{data.perfil_puesto.Nombre}}</td>
                        <td class="tw-text-center">{{data.DiasVac}}</td>
                        <td class="fila tw-center">
                            <div class="tw-flex tw-justify-center tw-items-center">
                                <div class="iconoEdit" @click="vacaciones(data, 2)">
                                    <span tooltip="Captura de Vacaciones" flow="left">
                                        <i class="fas fa-user-plus"></i>
                                    </span>
                                </div>
                                <div class="iconoDetails" @click="Historico(data)">
                                    <span tooltip="Historico Vacaciones" >
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
        <!-- --------------------------- Tabla de vacaciones Individuales ------------------------------ -->
        <section class="tw-mx-20 tw-my-4">
            <Table id="Vacaciones">
                <template v-slot:TableHeader>
                    <th class="columna">Num Control</th>
                    <th class="columna">Fecha Inicio</th>
                    <th class="columna">Fecha Fin</th>
                    <th class="columna">Comentarios</th>
                    <th class="columna">Dias Tomados</th>
                    <th class="columna">Dias Restantes</th>
                    <th class="columna">Estatus</th>
                </template>

                <template v-slot:TableFooter>
                    <tr class="fila" v-for="dato in MisVacaciones" :key="dato.id">
                        <td class="tw-text-center">{{ dato.IdEmp }}</td>
                        <td class="tw-text-center">{{ dato.FechaInicio }}</td>
                        <td class="tw-text-center">{{ dato.FechaFin }}</td>
                        <td>{{ dato.Comentarios }}</td>
                        <td class="tw-text-center">{{ dato.DiasTomados }}</td>
                        <td class="tw-text-center">{{ dato.DiasRestantes }}</td>
                        <td class="tw-text-center">
                            <div v-if="dato.Estatus == 0">
                                <span tooltip="Vacaciones Solicitadas" flow="left">
                                    <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-blueGray-400 tw-rounded-full">EN ESPERA</span>
                                </span>
                            </div>
                            <div v-else-if="dato.Estatus == 1">
                                <span tooltip="Vacaciones Aprovadas" flow="left">
                                    <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-green-600 tw-rounded-full">AUTORIZADA</span>
                                </span>
                            </div>
                            <div v-else-if="dato.Estatus == 2">
                                <span tooltip="En espera de autorizacion por RH" flow="left">
                                    <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-yellow-600 tw-rounded-full">EN CANCELACION</span>
                                </span>
                            </div>
                            <div v-else-if="dato.Estatus == 3">
                                <span tooltip="Vacaciones Canceladas por RH" flow="left">
                                    <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-red-600 tw-rounded-full">CANCELADA</span>
                                </span>
                            </div>
                            <div v-else-if="dato.Estatus == 4">
                                <span tooltip="Solicitud de Cancelacion Rechazada" flow="left">
                                    <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-orange-600 tw-rounded-full">AUTORIZADA</span>
                                </span>
                            </div>
                        </td>
                    </tr>
                </template>
            </Table>
        </section>

        <!-- **************************************************** MODALES ****************************************************** -->
        <modal :show="showModal" @close="chageClose" :maxWidth="tam">
            <div class="ModalHeader">
                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Registro de Vacaciones</h3>
            </div>

            <div class="InfoVac" v-if="TipoRegistro == 2">
                <div class="tw-flex tw-justify-center"><p class="tw-font-bold tw-text-lg">{{form.IdEmp}} - {{form.Nombre}} {{form.ApPat}} {{form.ApMat}}</p></div>
                <div class="tw-flex tw-justify-center"><p class="tw-font-bold tw-text-xs">Días de vacaciones restantes: <span class="tw-font-bold tw-text-base tw-text-teal-600">{{form.DiasVac}}</span></p></div>
                <div class="tw-flex tw-justify-center"><p class="tw-font-bold tw-text-xs">Fecha Ingreso: <span class="tw-font-bold tw-text-base tw-text-teal-600">{{form.FecIng}}</span></p></div>
            </div>

            <div class="ModalForm">
                <div class="FormSection">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label><span class="required">*</span>Fecha de Incio</jet-label>
                        <jet-input type="date" v-model="form.FechaInicio"></jet-input>
                        <small v-if="errors.FechaInicio" class="validation-alert">{{errors.FechaInicio}}</small>
                    </div>
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label><span class="required">*</span>Fecha de Fin</jet-label>
                        <jet-input type="date" v-model="form.FechaFin"></jet-input>
                        <small v-if="errors.FechaFin" class="validation-alert">{{errors.FechaFin}}</small>
                    </div>
                </div>
                <div class="FormSection">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                        <jet-label><span class="required">*</span>Comentarios</jet-label>
                        <textarea name="" id="" cols="2" v-model="form.Comentarios" @input="(val) => (form.Comentarios = form.Comentarios.toUpperCase())" class="tw-bg-gray-200 tw-text-gray-500 tw-font-semibold focus:tw-outline-none focus:tw-shadow-outline tw-border tw-border-gray-300 tw-rounded-lg tw-py-2 tw-px-4 tw-block tw-w-full tw-appearance-none tw-shadow-sm"></textarea>
                        <small v-if="errors.Comentarios" class="validation-alert">{{errors.Comentarios}}</small>
                    </div>
                </div>
            </div>

            <div class="ModalFooter" v-if="TipoRegistro == 2">
                <jet-button type="button" @click="save(form)" v-if="form.DiasVac > 0">Autorizar Vacaciones</jet-button>
                <jet-CancelButton @click="chageClose" v-if="form.DiasVac > 0">Cerrar</jet-CancelButton>
                <jet-CancelButton type="button" @click="chageClose" v-else>Aún no se pueden Solicitar Vacaciones</jet-CancelButton>
            </div>

            <div class="ModalFooter" v-else>
                <jet-button type="button" @click="SolicitaVacaciones(form)">Solicitar Vacaciones</jet-button>
                <jet-CancelButton @click="chageClose">Cerrar</jet-CancelButton>
            </div>
        </modal>
        <!-- ----------- modal vacaciones --------------- -->
        <modal :show="showHistoricoVacaciones" @close="chageHistoricoVacaciones" maxWidth="5xl">
            <div class="ModalHeader">
                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Historico Vacaciones</h3>
            </div>

            <div class="ModalForm">
                <div v-if="Vacaciones.length > 0">
                    <Table id="Historico">
                        <template v-slot:TableHeader>
                            <th class="columna">Num Control</th>
                            <th class="columna">Nombre Completo</th>
                            <th class="columna">Fecha Inicio</th>
                            <th class="columna">Fecha Fin</th>
                            <th class="columna">Comentarios</th>
                            <th class="columna">Dias Tomados</th>
                            <th class="columna">Dias Restantes</th>
                            <th class="columna">Estatus</th>
                            <th class="columna">Acciones</th>
                        </template>

                        <template v-slot:TableFooter>
                            <tr class="fila" v-for="dato in Vacaciones" :key="dato.id">
                                <td>{{ dato.IdEmp }}</td>
                                <td>{{ dato.Nombre }}</td>
                                <td>{{ dato.FechaInicio }}</td>
                                <td>{{ dato.FechaFin }}</td>
                                <td>{{ dato.Comentarios }}</td>
                                <td class="tw-text-center">{{ dato.DiasTomados }}</td>
                                <td class="tw-text-center">{{ dato.DiasRestantes }}</td>
                                <td>
                                    <div v-if="dato.Estatus == 0">
                                        <span tooltip="Vacaciones Solicitadas" flow="left">
                                            <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-blueGray-400 tw-rounded-full">SOLICITADA</span>
                                        </span>
                                    </div>
                                    <div v-if="dato.Estatus == 1">
                                        <span tooltip="Vacaciones Aprovadas" flow="left">
                                            <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-green-600 tw-rounded-full">AUTORIZADA</span>
                                        </span>
                                    </div>
                                    <div v-else-if="dato.Estatus == 2">
                                        <span tooltip="Solicitud Rechazada" flow="left">
                                            <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-yellow-600 tw-rounded-full">RECHAZADA</span>
                                        </span>
                                    </div>
                                    <div v-else-if="dato.Estatus == 3">
                                        <span tooltip="En espera de devolucion de días por RH" flow="left">
                                            <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-orange-600 tw-rounded-full">EN CANCELACION</span>
                                        </span>
                                    </div>
                                    <div v-else-if="dato.Estatus == 4">
                                        <span tooltip="Vacaciones Canceladas (Días devueltos)" flow="left">
                                            <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-red-600 tw-rounded-full">CANCELADA</span>
                                        </span>
                                    </div>
                                    <div v-else-if="dato.Estatus == 5">
                                        <span tooltip="Peticion de cancelacion Rechazada" flow="left">
                                            <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-red-600 tw-rounded-full">PETICION RECHAZADA</span>
                                        </span>
                                    </div>
                                </td>
                                <td class="fila">
                                    <div class="columnaIconos" v-if="dato.Estatus == 0">
                                        <div class="iconoTeal" @click="AutorizaVacaciones(dato)">
                                            <span tooltip="Autoriza Vacaciones" flow="left">
                                                <i class="fa-solid fa-check"></i>
                                            </span>
                                        </div>
                                        <div class="iconoDelete" @click="RechazaVacaciones(dato)">
                                            <span tooltip="Rechaza Vacaciones" flow="left">
                                                <i class="fa-solid fa-ban"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="columnaIconos" v-else-if="dato.Estatus == 1">
                                        <div class="iconoDetails" @click="PeticionCancelacion(dato)">
                                            <span tooltip="Solicita una cancelacion de vacaciones" flow="left">
                                                <i class="fas fa-paper-plane tw-w-3 tw-h-3"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="columnaIconos" v-else-if="dato.Estatus == 3">
                                        <div class="iconoDetails" @click="PeticionCancelacion(dato)">
                                            <span tooltip="En proceso de autorizacion por RH" flow="left">
                                                <i class="fa-solid fa-spinner tw-w-3 tw-h-3"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="columnaIconos" v-else-if="dato.Estatus == 5">
                                        <span tooltip="Peticion rechazada" flow="left">
                                            <i class="fa-solid fa-ban"></i>
                                        </span>
                                    </div>
                                    <div class="columnaIconos" v-else>
                                        <div class="iconoDetails">
                                            <span tooltip="Vacaciones" flow="left">
                                                <i class="fas fa-thumbs-up"></i>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </Table>
                </div>
                <div class="DetailsBody" v-else>
                    <Alert>No se encontraron vacaciones capturadas con anterioridad</Alert>
                </div>
            </div>

            <div class="ModalFooter">
                <jet-CancelButton @click="chageHistoricoVacaciones">Cerrar</jet-CancelButton>
            </div>
        </modal>
        <!-- --------------- MODAL PARA SOLICITAR ELIMINACION DE VACACIONES --------------------- -->
        <modal :show="showCancela" @close="chageCancela" :maxWidth="tam">
            <div class="ModalHeader">
                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Registro de Vacaciones</h3>
            </div>

            <div class="ModalForm">
                <jet-label><span class="tw-text-pink-600">*</span>Motivo de la cancelacion</jet-label>
                <textarea v-model="form2.Motivo" class="textarea focus:tw-outline-none"></textarea>
                <small v-if="errors.Motivo" class="validation-alert">{{errors.Motivo}}</small>
            </div>

            <div class="ModalFooter">
                <jet-button type="button" @click="update(form2)">Solicitar Cancelacion</jet-button>
                <jet-CancelButton  @click="chageCancela">Cerrar</jet-CancelButton>
            </div>
        </modal>

    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Welcome from "@/Jetstream/Welcome";
import Header from "@/Components/Header";
import Accions from "@/Components/Accions";
import Table from "@/Components/TableGreen";
import JetButton from "@/Components/Button";
import JetTextArea from "@/Components/Textarea";
import JetCancelButton from "@/Components/CancelButton";
import Modal from "@/Jetstream/Modal";
import Pagination from "@/Components/pagination";
import JetInput from "@/Components/Input";
import JetLabel from '@/Jetstream/Label';
import JetSelect from "@/Components/Select";
import Alert from "@/Components/Alert";
//imports de datatables
import datatable from "datatables.net-bs5";
import $ from "jquery";
import moment from 'moment';
import 'moment/locale/es';

export default {
    data() {
        return {
            ModalCancelacion: false,
            showHistoricoVacaciones: false,
            showCancela: false,
            TipoRegistro: 1,
            color: "tw-bg-green-600",
            color2: "tw-bg-green-700",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            now: moment().format("YYYY-MM-DD"),
            tam: "2xl",
            form: {
                IdUser: this.Session.id,
                IdEmp: null,
                Nombre: null,
                FechaInicio: null,
                FechaFin: null,
                Comentarios: null,
                Estatus: 1,
                DiasTomados: null,
                DiasRestantes: null,
            },
            form2: {
                IdEmp: 0,
                id: 0,
                Motivo: '',
                Dias: 0,
            },
        };
    },

    components: {
        AppLayout,
        Welcome,
        Header,
        Accions,
        Table,
        Alert,
        JetButton,
        JetCancelButton,
        Modal,
        Pagination,
        JetInput,
        JetLabel,
        JetSelect,
        JetTextArea,
    },

    props: {
        Session: Object,
        errors: Object,
        JefeDepto: Boolean,
        PerfilesUsuarios: Object,
        Autorizado: Boolean,
        PerfilSession: Object,
        Vacaciones: Object,
        MisVacaciones: Object,
    },

    mounted() {
        this.tabla();
        this.tablaVacaciones();
        this.tablaHistorico();
    },

    methods: {
        alertWarningDias() {
            const Toast = Swal.mixin({
                toast: true,
                position: "center",
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.stopTimer);
                toast.addEventListener("mouseleave", Swal.resumeTimer);
                },
            });

            Toast.fire({
                icon: "warning",
                title: "Dias de Vacaciones disponibles Excedidos",
                // background: '#FDBA74',
            });
        },

        reset() {
            this.form = {
                IdUser: this.Session.id,
                IdEmp: null,
                jefes_areas_id: null,
                Empresa: null,
                Nombre: null,
                ApPat: null,
                ApMat: null,
            };
        },

        tabla(){
            this.$nextTick(() => {
                $("#Perfiles").DataTable({
                    destroy: true,
                    language: this.español,
                    paging: true,
                    pageLength : 10,
                    // scrollX: true,
                    // scrollY:  '30vh',
                    order: [0, 'desc'],
                    // columnDefs: [
                    //     { "width": "5%", "targets": [0,8] },
                    // ],
                    "dom": '<"row"<"col-sm-6 col-md-3"l><"col-sm-6 col-md-6"B><"col-sm-12 col-md-3"f>>'+
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: [
                    ]
                }).draw();
            });
        },

        tablaVacaciones(){
            this.$nextTick(() => {
                $("#Vacaciones").DataTable({
                    destroy: true,
                    language: this.español,
                    paging: true,
                    pageLength : 5,
                    // scrollX: true,
                    // scrollY:  '30vh',
                    order: [0, 'desc'],
                    columnDefs: [
                        { "width": "10%", "targets": [0,6] },
                    ],
                    "dom": '<"row"<"col-sm-6 col-md-3"l><"col-sm-6 col-md-6"B><"col-sm-12 col-md-3"f>>'+
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: [
                    ]
                }).draw();
            });
        },

        //Generacion de Tabla con Datatables
        tablaHistorico(){
            this.$nextTick(() => {
                $("#Historico").DataTable({
                    language: this.español,
                    paging: true,
                    scrollX: true,
                    scrollY:  '40vh',
                });
            });
        },

        vacaciones: function (data, tipo) { //Visualiza Modal para solicitar Vacaciones y asigna datos
            this.TipoRegistro = tipo;
            this.form = Object.assign({}, data);
            this.chageClose();
        },

        SolicitaVacaciones(data){   //Solicitud Individual de Vacaciones
        console.log(data);
            data.Tipo = 2;
            data.IdUser = this.Session.id;
            data.IdEmp = this.Session.IdEmp;
            data.Empresa = this.PerfilSession.Empresa;
            data.Nombre = this.PerfilSession.Nombre;
            data.ApPat = this.PerfilSession.ApPat;
            data.ApMat = this.PerfilSession.ApMat;
            data.Estatus = 0;

            var DiasRestantes = 0;
            //Conversion de fechas a momment Js
            var fecha1 = moment(data.FechaInicio);
            var fecha2 = moment(data.FechaFin);
            var dias = 0;
            //calculo que existe al menos 1 dia solicitado de vacaciones
            var DiasSolicitados = fecha2.diff(fecha1, 'days');
            DiasSolicitados = data.DiasTomados = data.DiasTomados = DiasSolicitados+1;

            if(DiasSolicitados > 0){ //Minimo se solicito un dia de vacaciones
                //Proceso para verifica que no pidan vacaciones con 1 mes de anticipacion
                var hoy = moment();
                //Verifico si pasaron mas de 30 dias entre la fecha actual y la peticion de vacaciones
                var FechaValida = fecha1.diff(hoy, 'days');
                //Comprobar que la fecha solicitada para vacaciones no sea mayor a 30 dias naturales
                if(FechaValida < 31 ){

                    if(data.Empresa == 'SERGES' || data.Empresa == 'SHIELDTEX'){ //En caso de ser SERGES no contar los fines de semana
                        // DiasSolicitados -=1;
                        //Descuendo de fines de semana
                        var from = moment(fecha1, 'DD/MM/YYY'),
                            to = moment(fecha2, 'DD/MM/YYY');

                        while (!from.isAfter(to)) {
                                // Si no es sabado ni domingo
                                if (from.isoWeekday() !== 6 && from.isoWeekday() !== 7) {
                                    dias++;
                                }
                                from.add(1, 'days');
                            }

                            if(dias <= this.PerfilSession.DiasVac){ //(Cambio Individual)

                                //Verificacion de dias de vacaciones disponibles no sean mayores a los solicitados
                                data.DiasTomados = dias;
                                data.DiasRestantes = this.PerfilSession.DiasVac - data.DiasTomados;
                                // Guardado de la informacion
                                this.$inertia.post("/RecursosHumanos/Vacaciones", data, {
                                    onSuccess: () => {
                                        this.reset(), this.chageClose(), this.alertSucces();
                                    },
                                });
                            }else{
                                this.alertWarningDias();
                            }

                    }else{ //En caso de ser Hilaturas se cuentan los fines de semana
                        var dias = fecha2.diff(fecha1, 'days');
                        data.DiasTomados = data.DiasTomados = dias+1;
                        console.log(data.DiasTomados );
                        data.DiasRestantes = this.PerfilSession.DiasVac - data.DiasTomados;
                        //Verificacion de dias de vacaciones disponibles no sean mayores a los solicitados caso de hilaturas
                        if(data.DiasRestantes >= 0){
                            // Guardado de la informacion
                            this.$inertia.post("/RecursosHumanos/Vacaciones", data, {
                                onSuccess: () => {
                                    this.reset(), this.chageClose(), this.alertSucces();
                                },
                            });
                        }else{
                            this.alertWarningDias();
                        }

                    }

                }else{
                    Swal.fire(
                    'Fecha de solicitud excedida',
                    'Fecha de solicitud de vacaciones excede los 30 días de anticipacion',
                    'info'
                    )
                }
            }else{
                //En caso contrario no se solicitaron dias de vacaciones
                    Swal.fire(
                    'Fecha Invalidas',
                    'Verifica las fechas de Inicio y termino de vacaciones',
                    'info'
                    )
            }
        },

        save(data) { //Gaurdado de solicitud de Vacaciones
            data.Tipo = 2;
            //assigno el Id se session
            data.IdUser = this.Session.id;
            data.Estatus = 1;
            var DiasRestantes = 0;
            //Conversion de fechas a momment Js
            var fecha1 = moment(data.FechaInicio);
            var fecha2 = moment(data.FechaFin);
            var dias = 0;
            //calculo que existe al menos 1 dia solicitado de vacaciones
            var DiasSolicitados = fecha2.diff(fecha1, 'days');
            DiasSolicitados = data.DiasTomados = data.DiasTomados = DiasSolicitados+1;

            if(DiasSolicitados > 0){ //Minimo se solicito un dia de vacaciones
                //Proceso para verifica que no pidan vacaciones con 1 mes de anticipacion
                var hoy = moment();
                //Verifico si pasaron mas de 30 dias entre la fecha actual y la peticion de vacaciones
                var FechaValida = fecha1.diff(hoy, 'days');

                //Comprobar que la fecha solicitada para vacaciones no sea mayor a 30 dias naturales
                if(FechaValida < 30 ){

                    if(data.Empresa == 'SERGES' || data.Empresa == 'SHIELDTEX'){ //En caso de ser SERGES no contar los fines de semana
                        // DiasSolicitados -=1;
                        //Descuendo de fines de semana
                        var from = moment(fecha1, 'DD/MM/YYY'),
                            to = moment(fecha2, 'DD/MM/YYY');

                        while (!from.isAfter(to)) {
                                // Si no es sabado ni domingo
                                if (from.isoWeekday() !== 6 && from.isoWeekday() !== 7) {
                                    dias++;
                                }
                                from.add(1, 'days');
                            }

                            if(dias <= data.DiasVac){
                                //Verificacion de dias de vacaciones disponibles no sean mayores a los solicitados
                                data.DiasTomados = dias;
                                data.DiasRestantes = data.DiasVac - data.DiasTomados;
                                // Guardado de la informacion
                                this.$inertia.post("/RecursosHumanos/Vacaciones", data, {
                                    onSuccess: () => {
                                        this.reset(), this.chageClose(), this.alertSucces();
                                    },
                                });
                            }else{
                                this.alertWarningDias();
                            }

                    }else{ //En caso de ser Hilaturas se cuentan los fines de semana
                        var dias = fecha2.diff(fecha1, 'days');
                        data.DiasTomados = data.DiasTomados = dias+1;
                        data.DiasRestantes = data.DiasVac - data.DiasTomados;

                        //Verificacion de dias de vacaciones disponibles no sean mayores a los solicitados caso de hilaturas
                        if(data.DiasRestantes >= 0){
                            // Guardado de la informacion
                            this.$inertia.post("/RecursosHumanos/Vacaciones", data, {
                                onSuccess: () => {
                                    this.reset(), this.chageClose(), this.alertSucces();
                                },
                            });
                        }else{
                            this.alertWarningDias();
                        }

                    }

                }else{
                    Swal.fire(
                    'Fecha de solicitud excedida',
                    'Fecha de solicitud de vacaciones excede los 30 días de anticipacion',
                    'info'
                    )
                }

            }else{
                //En caso contrario no se solicitaron dias de vacaciones
                    Swal.fire(
                    'Fecha Invalidas',
                    'Verifica las fechas de Inicio y termino de vacaciones',
                    'info'
                    )
            }
        },

        chageHistoricoVacaciones() {
            this.showHistoricoVacaciones = !this.showHistoricoVacaciones;
        },

        Historico: function (data) {
            this.$inertia.get('/RecursosHumanos/Vacaciones',{ id: data.id }, {
                onSuccess: () => {
                    this.chageHistoricoVacaciones();
                }, preserveState: true
            });
        },

        AutorizaVacaciones(data){
            data.Tipo = 1;
            data._method = "PUT";
            this.$inertia.post("/RecursosHumanos/Vacaciones/" + data.id, data, {
                onSuccess: () => {
                    this.alertSucces();
                },
            });
        },

        RechazaVacaciones(data){
            data.Tipo = 2;
            data._method = "PUT";
            this.$inertia.post("/RecursosHumanos/Vacaciones/" + data.id, data, {
                onSuccess: () => {
                    this.alertSucces();
                },
            });
        },

        chageCancela() {
            this.showCancela = !this.showCancela;
        },

        PeticionCancelacion(data){ //Asgina los datos al modal de cancelacion
            this.form2.IdEmp = data.IdEmp;
            this.form2.id = data.id;
            this.form2.Dias = data.DiasTomados + data.DiasRestantes;
            this.chageCancela();
        },

        update(data) { //Crea la peticion de Cancelacion
            data.Tipo = 3;
            data._method = "PUT";
            this.$inertia.post("/RecursosHumanos/Vacaciones/" + data.id, data, {
                onSuccess: () => {
                    this.form2.id = '',
                    this.form2.IdEmp = '',
                    this.form2.Motivo = '',
                    this.chageCancela();
                    this.alertSucces();
                },
            });
        },
    },

    computed:{
        Perfiles: function () {
            const PerfilesDependientes = []; //Declaracion d enuevo arreglo
            if(this.Autorizado == true){
                this.PerfilesUsuarios.forEach(element => {
                    PerfilesDependientes.push(element)
                });
            }else{
                this.PerfilesUsuarios.forEach(element => {
                    element.jefe_perfiles.forEach( el => {
                        PerfilesDependientes.push(el)
                        // el.perfiles_jefe.forEach(e => {
                        //     PerfilesDependientes.push(e)
                        // })
                    })
                });
            }

            return PerfilesDependientes;

        }
    }
};
</script>
