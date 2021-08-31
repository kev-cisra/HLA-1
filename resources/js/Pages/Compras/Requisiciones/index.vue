<template>
  <app-layout>
    <div class="uppercase tw-mx-4">
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-user tw-ml-3 tw-mr-3"></i>
                        Mis Requisiciones
                </h3>
            </slot>
        </Header>

        <div class="tw-mt-8">
            <div class="tw-flex tw-justify-end">
                <div>
                    <jet-button @click="openModal" class="BtnNuevo">Nueva Requisición</jet-button>
                </div>
            </div>

            <div class="tw-overflow-x-auto tw-mx-2">
                {{ Requisicion }}
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
import TableGreen from "@/Components/TableGreen";
import Table from "@/Components/Table";
import JetButton from "@/Components/Button";
import JetCancelButton from "@/Components/CancelButton";
import Modal from "@/Jetstream/Modal";
import Pagination from "@/Components/pagination";
import JetInput from "@/Components/Input";
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
            form: {
                IdUser: this.Session.id,
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
        TableGreen,
        Table,
        JetButton,
        JetCancelButton,
        Modal,
        Pagination,
        JetInput,
        JetSelect,
    },

    props: {
        Session: Object,
        Requisicion: Object,
    },

    methods: {
        reset() {
            this.form = {
                IdUser: this.Session.id,
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
        $("#perfiles").DataTable().destroy();
            this.$inertia.get("/RecursosHumanos/PerfilesUsuarios", { busca: event.target.value },{ onSuccess: () => { this.tabla(); },});
        },

        save(data) {

        },

        edit: function (data) {

        },

        update(data) {

        },

        deleteRow: function (data) {

        },
    },
};
</script>
