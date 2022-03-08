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
        <modal :show="showModal" @close="chageClose" :maxWidth="tam">
            <div class="ModalHeader">
                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>REGISTRO DE INFORMACIÓN</h3>
            </div>


            <div class="ModalForm">
                <div class="FormSection">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label><span class="required">*</span>FECHA INICIO</jet-label>
                        <jet-input type="datetime-local" v-model="form.start"></jet-input>
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

import esLocale from "@fullcalendar/core/locales/es";
export default {

    data() {
        return {
            tam: "3xl",
            color: "tw-bg-sky-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            showModal: false,
            EventosCalendario: Object,
            form: {
                IdUser: this.Session.id,
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
            }
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
    },

    mounted(){
        this.Calendario();
    },

    methods: {
        Calendario(){
            var calendar = new window.Calendar($('#calendar').get(0), {
            plugins: [window.interaction, window.dayGridPlugin, window.timeGridPlugin, window.listPlugin],
            buttonText: { today: 'Hoy', month: 'Mes', week: 'Semana', day: 'Día', list: 'Lista'},
            selectable: true,
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
            customButtons:{
                AgregaEvento:{
                    text: "Nuevo Mantenimiento",
                    click: function () {
                        console.log("Modal");
                    }
                }
            },
            events: this.FechaMantenimientos, //Visualizacion de la informacion
            displayEventEnd: true,
            eventClick: info => {
                console.log(info);
            },
            dateClick: info => {
                console.log('dateClick');
                this.showModal = true;
            },
            select: info => {
                console.log('select');
            },

            });
            calendar.setOption('locale', 'es');
            calendar.render();
        },

        reset() {
            this.form = {
                IdUser: this.Session.id,
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
            };
        },

        save(data){
            var FechaIni = moment(data.start);
            data.start = FechaIni.format('YYYY-MM-DD HH:MM:SS');
            var FechaFin = FechaIni.add(data.Tiempo, 'h');
            data.end = FechaFin.format('YYYY-MM-DD HH:MM:SS');
            data.backgroundColor = this.colours[Math.floor(Math.random() * this.colours.length)];
            data.Hardware_id = data.Equipo.id;
            data.Estatus = 0;
            data.title = data.Equipo.hardware.Nombre +' - '+ data.Equipo.perfil.Nombre + ' ' +data.Equipo.perfil.ApPat;
            this.$inertia.post("/Sistemas/CalendarioMantenimientos", data, {
                onSuccess: () => {
                    this.Calendario();
                    this.reset(),
                    this.chageClose(),
                    this.alertSucces();
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
            this.$inertia.post("/Sistemas/EquiposAsignados/" + data.id, data, {
                onSuccess: () => {
                this.reset(), this.chageClose(), this.alertSucces();
                },
            });
        },
    },
    computed: {

    },
};
</script>
