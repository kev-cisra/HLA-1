<template>
  <app-layout>
    <div class="uppercase tw-mx-4">
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-user tw-ml-3 tw-mr-3"></i>
                        Pruebas del Sistema.
                </h3>
            </slot>
        </Header>
    </div>

    <div class="tw-flex tw-gap-4">
        <div>
            <jet-label><span class="required">*</span>NombreRol</jet-label>
            <jet-input type="text" v-model="form.NombreRol"></jet-input>
            <jet-button type="button" @click="NuevoRol(form)">Guardar</jet-button>
        </div>

        <div>
            <ul v-for="dato in Roles" :key="dato.id">
                <li> {{ dato.name }} </li>
            </ul>
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
            tam: "3xl",
            color: "tw-bg-cyan-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            form: {
                NombreRol: '',
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
        Roles: Object,
    },

    methods: {
        NuevoRol(data){
            console.log(data);
            this.$inertia.post("/Admin/AdminPanel", data, {
                    onSuccess: () => {
                        this.alertSucces();
                    },
            });
        },
    },
};
</script>
