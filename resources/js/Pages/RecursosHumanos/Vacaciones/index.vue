<template>
  <app-layout>
    <div class="uppercase tw-mx-4">
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-calendar-check tw-ml-3 tw-mr-3"></i>
                    Captura de vacaciones
                </h3>
            </slot>
        </Header>

        <div class="tw-mt-8">
            <div class="tw-overflow-x-auto tw-mx-2">
                <TableBlue id="perfiles">
                    <template v-slot:TableHeader>
                        <th class="columna">Num Control</th>
                        <th class="columna">Nombre</th>
                        <th class="columna">Apellido Paterno</th>
                        <th class="columna">Apellido Materno</th>
                        <th class="columna">Departamento</th>
                        <th class="columna">Puesto</th>
                        <th class="columna">Dias de Vacaciones</th>
                        <th class="columna">Acciones</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila" v-for="dato in PerfilesUsuarios" :key="dato.id">
                            <td class="tw-p-2">{{ dato.IdEmp }}</td>
                            <td class="tw-p-2">{{ dato.Nombre }}</td>
                            <td class="tw-p-2">{{ dato.ApPat }}</td>
                            <td class="tw-p-2">{{ dato.ApMat }}</td>
                            <td class="tw-p-2">{{ dato.perfil_puesto.Nombre }}</td>
                            <td class="tw-p-2">{{ dato.perfil_departamento.Nombre }}</td>
                            <td class="tw-p-2">{{ dato.DiasVac }} Dias</td>
                            <td class="fila tw-center">
                                <div class="tw-flex tw-justify-center tw-items-center">
                                    <div class="iconoEdit" @click="vacaciones(dato)">
                                        <span tooltip="Captura de Vacaciones" flow="left">
                                            <i class="fas fa-user-plus"></i>
                                        </span>
                                    </div>
                                    <div class="iconoDetails" @click="Historico(dato)" data-bs-toggle="modal" data-bs-target="#exampleModal" >
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
                </TableBlue>
            </div>
        </div>
    </div>

    <modal :show="showModal" @close="chageClose" :maxWidth="tam">
        <form>
            <div class="tw-px-4 tw-py-4">
                <div class="tw-text-lg">
                    <div class="ModalHeader">
                        <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Registro de Vacaciones</h3>
                    </div>
                </div>

                <div class="overflow-hidden tw-flex-column tw-bg-blueGray-50 tw-my-4 tw-border-teal-500 tw-border-t-2 tw-border-b-2">
                    <div class="tw-flex tw-p-2 tw-gap-2">
                        <div class="tw-w-1/3 md:tw-w-1/3 lg:tw-w-1/3">
                            <label class="info">Num Empleado</label>
                            <div class="DataContainer">
                                <input type="text" class="InfoData" v-model="form.IdEmp" disabled/>
                            </div>
                        </div>
                        <div class="tw-w-1/3 md:tw-w-1/3 lg:tw-w-1/3">
                            <label class="info">Empresa</label>
                            <div class="DataContainer">
                                <input type="text" class="InfoData" v-model="form.Empresa" disabled/>
                            </div>
                        </div>
                        <div class="tw-w-1/3 lw-text-bold md:tw-w-1/3 lg:tw-w-1/3">
                            <label class="info">Días Vacaciones Disponibles</label>
                            <div class="DataContainer">
                                <input type="text" class="InfoData" v-model="form.DiasVac" disabled/>
                            </div>
                        </div>
                    </div>
                    <div class="tw-flex tw-p-2 tw-gap-2">
                        <div class="tw-w-1/3 md:tw-w-1/3 lg:tw-w-1/3">
                            <label class="info">Nombre</label>
                            <div class="DataContainer">
                                <input type="text" class="InfoData" v-model="form.Nombre" disabled/>
                            </div>
                        </div>
                        <div class="tw-w-1/3 md:tw-w-1/3 lg:tw-w-1/3">
                            <label class="info">Apellido Paterno</label>
                            <div class="DataContainer">
                                <input type="text" class="InfoData" v-model="form.ApPat" disabled/>
                            </div>
                        </div>
                        <div class="tw-w-1/3 md:tw-w-1/3 lg:tw-w-1/3">
                            <label class="info">Apellido Materno</label>
                            <div class="DataContainer">
                                <input type="text" class="InfoData" v-model="form.ApMat" disabled/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tw-mt-4">
                    <div class="ModalForm">
                        <div class="tw-mb-6 md:tw-flex">
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
                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                                <jet-label><span class="required">*</span>Comentarios</jet-label>
                                <textarea name="" id="" cols="2" v-model="form.Comentarios" @input="(val) => (form.Comentarios = form.Comentarios.toUpperCase())" class="tw-bg-gray-200 tw-text-gray-500 tw-font-semibold focus:tw-outline-none focus:tw-shadow-outline tw-border tw-border-gray-300 tw-rounded-lg tw-py-2 tw-px-4 tw-block tw-w-full tw-appearance-none tw-shadow-sm"></textarea>
                                <small v-if="errors.Comentarios" class="validation-alert">{{errors.Comentarios}}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ModalFooter">
                <jet-button type="button" @click="save(form)" v-show="!editMode">Guardar</jet-button>
                <jet-button type="button" @click="update(form)" v-show="editMode">Actualizar</jet-button>
                <jet-CancelButton @click="chageClose">Cerrar</jet-CancelButton>
            </div>
        </form>
    </modal>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content tw-bg-blueGray-50 tw-my-4">
                <div class="DetailsHeader">
                <div class="tw-text-lg">
                    <div class="ModalHeader">
                        <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Historico Vacaciones</h3>
                    </div>
                </div>
                </div>

                <div class="DetailsBody" v-if="Vacaciones.length > 0">
                    <TableBlue>
                        <template v-slot:TableHeader>
                            <th class="columna">Num Control</th>
                            <th class="columna">Nombre Completo</th>
                            <th class="columna">Fecha Inicio</th>
                            <th class="columna">Fecha Fin</th>
                            <th class="columna">Comentarios</th>
                            <th class="columna">Dias Tomados</th>
                            <th class="columna">Dias Restantes</th>
                            <th class="columna">Estatus</th>
                            <th class="columna">Cancela Vacaciones</th>
                        </template>

                        <template v-slot:TableFooter>
                            <tr class="fila" v-for="dato in Vacaciones" :key="dato.id">
                                <td class="tw-p-2">{{ dato.IdEmp }}</td>
                                <td class="tw-p-2">{{ dato.Nombre }}</td>
                                <td class="tw-p-2">{{ dato.FechaInicio }}</td>
                                <td class="tw-p-2">{{ dato.FechaFin }}</td>
                                <td class="tw-p-2">{{ dato.Comentarios }}</td>
                                <td class="tw-p-2">{{ dato.DiasTomados }}</td>
                                <td class="tw-p-2">{{ dato.DiasRestantes }}</td>
                                 <td class="tw-p-2">
                                    <span class="tw-relative tw-inline-block tw-px-3 tw-py-1 tw-font-semibold tw-leading-tigh">
                                        <span aria-hidden class="tw-absolute tw-inset-0 tw-rounded-full tw-opacity-50 {{ dato.Color }}"></span>
                                        <span class="tw-relative tw-text-white">{{ dato.Color }}</span>
                                    </span>
                                 </td>
                                <td class="tw-p-2">
                                    <div class="iconoDetails" @click="vacacion(dato)" data-bs-toggle="modal" data-bs-target="#Cancelacion">
                                        <span tooltip="Solicita una cancelacion de vacaciones" flow="left">
                                            <i class="fas fa-paper-plane"></i>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </TableBlue>
                </div>
                <div class="DetailsBody" v-else-if="Vacaciones.length == ''">
                    <Alert>No se encontraron vacaciones capturadas con anterioridad</Alert>
                </div>
                <div class="tw-bg-coolGray-100 tw-p-4 tw-border-b-4 tw-border-cyan-500">
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="Cancelacion" tabindex="-1" aria-labelledby="Cancelacion" aria-hidden="true" v-show="ModalCancelacion">
        <div class="modal-dialog modal-lg">
            <div class="modal-content tw-bg-blueGray-50 tw-my-4">
                <div class="DetailsHeader">
                    <div class="tw-text-lg">
                        <div class="ModalHeader">
                            <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Cancelacion de Vacaciones</h3>
                        </div>
                    </div>
                </div>

                <div class="DetailsBody">
                    <jet-label><span class="tw-text-pink-600">*</span>Motivo de la cancelacion</jet-label>
                    <textarea v-model="form2.Motivo" class="textarea focus:tw-outline-none"></textarea>
                    <small v-if="errors.Motivo" class="validation-alert">{{errors.Motivo}}</small>
                </div>

                <div class="ModalFooter">
                    <jet-button type="button" @click="update(form2)" data-bs-dismiss="modal" v-show="!editMode">Solicitar Cancelacion</jet-button>
                    <jet-CancelButton  data-bs-dismiss="modal">Cerrar</jet-CancelButton>
                </div>
            </div>
        </div>
    </div>

  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Welcome from "@/Jetstream/Welcome";
import Header from "@/Components/Header";
import Accions from "@/Components/Accions";
import TableBlue from "@/Components/TableGreen";
import Table from "@/Components/Table";
import JetButton from "@/Components/Button";
import JetTextArea from "@/Components/Textarea";
import JetCancelButton from "@/Components/CancelButton";
import Modal from "@/Jetstream/Modal";
import Pagination from "@/Components/pagination";
import JetInput from "@/Components/Input";
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
            color: "tw-bg-green-600",
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
                Estatus: 'APROVADO',
                Color: '#14B8A6',
                DiasTomados: null,
                DiasRestantes: null,
            },
            form2: {
                id: null,
                IdEmp: null,
                Motivo: null,
                Dias: null,
            }
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
        TableBlue,
        Table,
        Alert,
        JetButton,
        JetCancelButton,
        Modal,
        Pagination,
        JetInput,
        JetSelect,
        JetTextArea,
    },

    props: {
        Session: Object,
        PerfilesUsuarios: Object,
        errors: Object,
        Perfil: Object,
        Vacaciones: Object,
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

        //datatable
        tabla() {
        this.$nextTick(() => {
            $("#perfiles").DataTable({
            language: this.español,
            });
        });
        },

        //consulta para generar datos de la tabla
        verTabla(event) {
            $('#perfiles').DataTable().clear();
            $('#perfiles').DataTable().destroy();
            this.$inertia.get(
                "/RecursosHumanos/PerfilesUsuarios",
                { busca: event.target.value },
                {
                onSuccess: () => {
                    this.tabla();
                },
                }
            );
        },

        save(data) {
            //assigno el Id se session
            data.IdUser = this.Session.id;
            var DiasRestantes = 0;
            //Conversion de fechas a momment Js
            var fecha1 = moment(data.FechaInicio);
            var fecha2 = moment(data.FechaFin);

            //calculo que existe al menos 1 dia solicitado de vacaciones
            var dias = fecha2.diff(fecha1, 'days');
            dias = data.DiasTomados = data.DiasTomados = dias+1;

            if(dias > 0){
                //calculo mes a partir de la fecha de incio de vacaciones

                var hoy = moment();
                //Verifico si pasaron mas de 30 dias entre la fecha actual y la peticion de vacaciones
                var FechaValida = fecha1.diff(hoy, 'days');

                //Comprobar que la fecha solicitada para vacaciones no sea mayor a 30 dias naturales
                if(FechaValida < 30 ){

                    if(data.Empresa == 'SERGES'){ //En caso de ser SERGES no contar los fines de semana

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
                            }else{
                                this.alertWarningDias();
                            }

                    }else{ //En caso de ser Hilaturas se cuentan los fines de semana

                        var dias = fecha2.diff(fecha1, 'days');
                        data.DiasTomados = data.DiasTomados = dias+1;
                        data.DiasRestantes = data.DiasVac - data.DiasTomados;
                    }

                    this.$inertia.post("/RecursosHumanos/Vacaciones", data, {
                        onSuccess: () => {
                            this.reset(), this.chageClose(), this.alertSucces();
                        },
                    });
                }else{
                    console.log(FechaValida);
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

        update(data) {
            // console.log(data);
            data._method = "PUT";
            this.$inertia.post("/RecursosHumanos/Vacaciones/" + data.id, data, {
                onSuccess: () => {
                this.form2.id = '',
                this.form2.IdEmp = '',
                this.form2.Motivo = '',
                this.alertSucces();
                },
            });
        },

        vacaciones: function (data) {
            this.form = Object.assign({}, data);
            this.editMode = false;
            this.chageClose();
        },

        Historico: function (data) {
            this.form2.IdEmp = data.IdEmp;
            this.$inertia.get('/RecursosHumanos/Vacaciones',{ busca: data.IdEmp }, {
                onSuccess: () => {
                }, preserveState: true
            });
        },

        vacacion: function (data){
            this.form2.IdEmp = data.IdEmp;
            this.form2.id = data.id;
            this.form2.Dias = data.DiasTomados + data.DiasRestantes;
        }
    },
};
</script>
