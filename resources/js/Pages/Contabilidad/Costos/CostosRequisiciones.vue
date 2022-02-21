<template>
    <app-layout>
        <!-- ****************************************** TITULO ********************************************* -->
        <section class="tw-uppercase tw-mx-4">
            <Header :class="[color, style]">
                <slot>
                    <h3 class="tw-p-2"><i class="fa-solid fa-dollar-sign tw-ml-3 tw-mr-3"></i>COSTOS REQUISICIONES</h3>
                </slot>
            </Header>
        </section>

        <!-- ******************************* FILTROS ********************************************* -->
        <section class="tw-my-4 tw-mx-4 lg:tw-flex lg:tw-gap-4 lg:tw-content-center lg:tw-border lg:tw-p-2 lg:tw-mb-4">
            <div class="lg:tw-flex lg:tw-gap-4">
                <div>
                    <jet-label class="tw-text-center">AÑO</jet-label>
                    <select class="InputSelect" v-model="params.Year">
                        <option value="0"> TODOS --</option>
                        <option value="2021"> 2021 --</option>
                        <option value="2022"> 2022 -- </option>
                    </select>
                </div>

                <div>
                    <jet-label class="tw-text-center">MES</jet-label>
                    <select class="InputSelect" v-model="params.Month">
                        <option value="0">TODOS</option>
                        <option value="1">ENERO</option>
                        <option value="2">FEBRERO</option>
                        <option value="3">MARZO</option>
                        <option value="4">ABRIL</option>
                        <option value="5">MAYO</option>
                        <option value="6">JUNIO</option>
                        <option value="7">JULIO</option>
                        <option value="8">AGOSTO</option>
                        <option value="9">SEPTIEMBRE</option>
                        <option value="10">OCTUBRE</option>
                        <option value="11">NOVIEMBRE</option>
                        <option value="12">DICIEMBRE</option>
                    </select>
                </div>

            </div>
            <div class="lg:tw-flex lg:tw-gap-40 lg:tw-content-center">
                <jet-button @click="openModal" class="BtnNuevo">NUEVA INFORMACIÓN</jet-button>
            </div>
        </section>

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
            tam: "4xl",
            color: "tw-bg-violet-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            params: {
                Year: 0,
                Month: 0,
            }
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
    },

    mounted() {
    },

    methods: {
    },

    computed:{
    }
};
</script>
