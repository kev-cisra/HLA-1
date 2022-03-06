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
            form: {

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

    },

    mounted(){
        this.Calendario();
    },

    methods: {

        Calendario(){
            var calendar = new window.Calendar($('#calendar').get(0), {
            plugins: [window.interaction, window.dayGridPlugin, window.timeGridPlugin, window.listPlugin],
            locale: esLocale,
            selectable: true,
            height: "auto",
            initialView: 'timeGridWeek',
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
            eventBorderColor: 'white',
                eventClick: info => {
                    console.log('evenClik');
                },
                dateClick: info => {
                    console.log('dateClick');
                    this.showModal = true;
                },
                select: info => {
                    console.log('select');
                },

                events: [
                ]
            });
            // calendar.setOption('locale', 'es');
            calendar.render();
        },

        reset() {
            this.form = {
            };
        },
    },
};
</script>
