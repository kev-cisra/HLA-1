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
        <!-- ****************************************** CONTENIDO ********************************************* -->
        <section class="tw-flex tw-justify-center tw-mx-4">
            <div class="tw-w-1/2 tw-h-1/2">
                <div id="calendar"></div>
            </div>
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

export default {

    data() {
        return {
            color: "tw-bg-sky-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
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
            selectable: true,
            initialView: 'dayGridMonth',
            eventBorderColor: 'white',

            });

            calendar.render();
        },

    },
};
</script>
