<template>
    <app-layout>
        <!-- ****************************************** TITULO ********************************************* -->
        <section class="tw-uppercase tw-mx-4">
            <Header :class="[color, style]">
                <slot>
                    <h3 class="tw-p-2"><i class="fas fa-calendar-check tw-ml-3 tw-mr-3"></i>MANTENIMIENTOS PROGRAMADOS</h3>
                </slot>
            </Header>
        </section>
                <!-- ******************************* FILTROS ********************************************* -->
        <section class="tw-flex tw-justify-between tw-content-center tw-border tw-p-1 tw-my-8 tw-mx-8">
            <div class="tw-flex tw-gap-4 tw-mx-2">

            </div>
            <div>
                <jet-button @click="openModal" class="BtnNuevo">NUEVA INFORMACIÓN</jet-button>
            </div>
        </section>
        <!-- ****************************************** CONTENIDO ********************************************* -->
        <section class="tw-flex tw-justify-center tw-mx-8 tw-my-8 tw-uppercase">
            <div id="calendar"></div>
        </section>

        <!-- **************************************************** MODALES ****************************************************** -->
        <!-- -------- MODAL EVENTOS ----------- -->
        <modal :show="showModal" @close="chageClose" :maxWidth="tam">
            <div class="ModalHeader">
                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>REGISTRO DE INFORMACIÓN</h3>
            </div>

            <div class="ModalForm">
                <div class="FormSection">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label><span class="required">*</span>FECHA INICIO</jet-label>
                        <jet-input type="datetime-local" :min="min" v-model="form.start"></jet-input>
                    </div>
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label><span class="required">*</span>DURACION</jet-label>
                        <select class="InputSelect" v-model="form.Tiempo">
                            <option value="1">1 HORA</option>
                            <option value="2">2 HORAS</option>
                        </select>
                    </div>
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label><span class="required">*</span>PERIODO</jet-label>
                        <select class="InputSelect" v-model="form.Periodo">
                            <option value="1">1 MES</option>
                            <option value="6">6 MESES</option>
                            <option value="12">1 AÑO</option>
                        </select>
                    </div>
                </div>
                <div class="FormSection">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                        <jet-label><span class="required">*</span>EQUIPO ASIGNADO</jet-label>
                        <select class="InputSelect" v-model="form.Equipo">
                            <option v-for="Equ in EquiposAsignados" :key="Equ.id" :value="Equ" >
                                {{Equ.hardware.Nombre }} -
                                {{Equ.perfil.Nombre}}
                                {{Equ.perfil.ApPat}}
                                {{Equ.perfil.ApMat}}
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="ModalFooter">
                <jet-button type="button" @click="save(form)">Guardar</jet-button>
                <jet-CancelButton @click="chageClose">Cerrar</jet-CancelButton>
            </div>
        </modal>

        <!-- -------- MODAL MANTENIMIENTO ----------- -->
        <modal :show="showInfo" @close="chageInfo" :maxWidth="tam">
            <div class="ModalHeader">
                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>MANTENIMIENTOS PROGRAMADOS</h3>
            </div>

            <div class="ModalForm">
                <div v-if="evento == false">
                <Table id="Roles">
                    <template v-slot:TableHeader>
                        <th class="columna">MANTENIMEINTO</th>
                        <th class="columna">FECHA INICIO</th>
                        <th class="columna">FECHA FIN</th>
                        <th class="columna">PERIODO</th>
                        <th class="columna">COMENTARIO</th>
                        <th class="columna">ESTATUS</th>
                        <th class="columna">ACCIONES</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila" v-for="event in EventosCalendario.data" :key="event.id">
                            <td>{{event.title}}</td>
                            <td>{{event.start}}</td>
                            <td>{{event.end}}</td>
                            <td>{{event.Periodo}} MES</td>
                            <td>{{event.Comentarios}}</td>
                            <td>{{event.Estatus}}</td>
                            <td>
                                <div class="tw-flex tw-justify-center tw-items-center tw-gap-4">
                                    <div class="iconoEdit" @click="edit(event)">
                                        <span tooltip="Editar" flow="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="tw-h-4 tw-w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>
                </Table>
                </div>
                <div class="FormSection">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0" v-if="evento == true">
                        <jet-label><span class="required">*</span>FECHA INICIO</jet-label>
                        <jet-input type="datetime-local" v-model="form.start"></jet-input>
                    </div>
                </div>
            </div>

            <div class="ModalFooter">
                <jet-button type="button" @click="update(form)" v-if="evento == true">Actualizar</jet-button>
                <jet-CancelButton @click="chageInfo">Cerrar</jet-CancelButton>
            </div>
        </modal>

    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Welcome from "@/Jetstream/Welcome";
import Header from "@/Components/Header";
import Accions from "@/Components/Accions";
import Table from "@/Components/TableSky";
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
import moment, { now } from 'moment';
import axios from 'axios';
import 'moment/locale/es';

import esLocale from "@fullcalendar/core/locales/es";
export default {

    data() {
        return {
            tam: "3xl",
            color: "tw-bg-sky-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            showModal: false,
            showInfo: false,
            evento: false,
            min: moment().format("YYYY-MM-DD"),
            EventosCalendario: Object,
            form: {
                IdUser: this.Session.id,
                id: '',
                Equipo: '',
                title: '',
                start: '',
                end: '',
                textColor: '',
                backgroundColor: '',
                FechaReal: '',
                Diferencia: '',
                Periodo: 1,
                Tiempo: 1,
                Estatus: '',
                Comentarios: '',
                Hardware_id: '',
                Perfil_id: '',
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
        Session: Object,
        EquiposAsignados: Object,
        FechaMantenimientos: Object,
        busca: Number,
    },

    mounted(){
        this.Calendario();
    },

    methods: {

        async Calendario(){
            var calendar = new window.Calendar($('#calendar').get(0), {
            plugins: [window.interaction, window.dayGridPlugin, window.timeGridPlugin, window.listPlugin],
            buttonText: { today: 'Hoy', month: 'Mes', week: 'Semana', day: 'Día', list: 'Lista'},
            selectable: false,
            droppable: true,
            editable: true,
            hiddenDays: [0, 6],
            height: "auto",
            initialView: 'dayGridMonth',
            allDaySlot: false,
            slotMinTime: "10:00:00",
            slotMaxTime: "16:00:00",
            headerToolbar: {
                left: 'prev,next,today',
                center: 'title',
                right: 'timeGridWeek,dayGridMonth,listWeek'
            },
            titleFormat: {
                year: 'numeric', month: 'long', day: 'numeric',
            },
            events: this.FechaMantenimientos, //Visualizacion de la informacion
            displayEventEnd: true,

            eventClick: info => {
                this.evento = false;
                this.form.id = info.event._def.publicId;
                var id = info.event._def.extendedProps.Hardware_id;
                this.form.title = info.event.title;
                this.form.start = moment(info.event.start).format('YYYY-MM-DD HH:MM:SS');
                this.form.end = moment(info.event.end).format('YYYY-MM-DD HH:MM:SS');

                let promesa = axios.post('CalendarioMantenimientos/Eventos', { busca: id }).then(promesa => {
                    this.EventosCalendario = promesa;

                    this.chageInfo();
                }).catch(e => {
                    alert('Mensaje del sistema: Ocurrio una excepción');
                });
            },
            eventDrop: info =>{
                console.log(info.event._def.extendedProps);
                console.log(info.event._def.extendedProps.Perfil_id )
                console.log(this.form.IdUser)
                if(info.event._def.extendedProps.Perfil_id == this.form.IdUser){
                    this.evento = true;
                    var id = info.event._def.publicId;
                    var today = moment(new Date()).format('YYYY-MM-DD');
                    this.form.id = id;
                    this.form.start = moment(info.event.start).format('YYYY-MM-DD HH:mm');
                    this.form.end = moment(info.event.end).format('YYYY-MM-DD HH:mm');


                    if (this.form.start >= today) { //Valido fecha posterior
                        var FechaValida = moment(info.event.start).diff(moment(new Date()), 'days');
                        if(FechaValida < 20){ //Validacion de dias posteriores
                            this.chageInfo();
                        }else{
                            this.alertFecha('Seleccione un dia anterior a 20 dias naturales');
                        }
                    }else{
                        this.alertFecha('Selecciona una fecha posterior');
                    }
                }
            },

            });
            calendar.setOption('locale', 'es');
            calendar.render();
        },

        reset() {
            this.form = {
                IdUser: this.Session.id,
                id: '',
                Equipo: '',
                title: '',
                start: '',
                end: '',
                textColor: '',
                backgroundColor: '',
                FechaReal: '',
                Diferencia: '',
                Periodo: 1,
                Tiempo: 1,
                Estatus: '',
                Comentarios: '',
                Hardware_id: '',
                Perfil_id: '',
            };
        },

        save(data){
            //Asigno un color aleatoriamente
            this.form.Perfil_id = data.Equipo.perfil.id;
            data.backgroundColor = this.colours[Math.floor(Math.random() * this.colours.length)];
            data.Hardware_id = data.Equipo.id; //Asigno el equipo
            data.title = data.Equipo.hardware.Nombre +' - '+ data.Equipo.perfil.Nombre + ' ' +data.Equipo.perfil.ApPat;
            this.$inertia.post("/Sistemas/CalendarioMantenimientos", data, {
                onSuccess: () => {
                    if(this.$attrs.jetstream.flash.type == 'Warning'){
                        this.alertInfo(this.$attrs.jetstream.flash.message);
                    }else{
                        this.alertSucces();
                    }
                    this.Calendario();
                    this.reset();
                    this.chageClose();
                },
            });
        },

        chageInfo() {
            this.showInfo = !this.showInfo;
        },

        edit: function (data) {
            this.form = Object.assign({}, data);
            this.evento = true;
        },

        dateCompare(time1,time2) {
            var t1 = new Date();
            var parts = time1.split(":");
            t1.setHours(parts[0],parts[1],parts[2],0);
            var t2 = new Date();
            parts = time2.split(":");
            t2.setHours(parts[0],parts[1],parts[2],0);

            // returns 1 if greater, -1 if less and 0 if the same
            if (t1.getTime()>=t2.getTime()){
                return 1;
            } else{
                return 0;
            }
        },

        update(data) {
            data._method = "PUT";
            var HoraIni = moment(data.start).format("HH:mm:ss")
            let Ini = this.dateCompare(HoraIni,"09:00:00");
            let Fin = this.dateCompare("16:45:00", HoraIni);

            if(Ini == 0 || Fin == 0){
                this.alertInfo('Hoario valido es de 9 a 16:30');
            }else{
                this.$inertia.post("/Sistemas/CalendarioMantenimientos/" + data.id, data, {
                    onSuccess: () => {
                        if(this.$attrs.jetstream.flash.type == 'Warning'){
                            this.alertInfo(this.$attrs.jetstream.flash.message);
                        }else{
                            this.alertSucces();
                        }
                        this.editEvent = false;
                        this.chageInfo();
                        this.Calendario();
                    },
                });
            }

        },

        alertFecha(Text) {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-center",
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.stopTimer);
                toast.addEventListener("mouseleave", Swal.resumeTimer);
                },
            });

            Toast.fire({
                icon: "info",
                title: Text,
                // background: '#99F6E4',
            });
        },
    },

    computed: {

    },
};
</script>
