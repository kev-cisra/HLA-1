<template>
  <app-layout>
    <div class="uppercase tw-mx-4">
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-user tw-ml-3 tw-mr-3"></i>
                        Costos Empaques
                </h3>
            </slot>
        </Header>

        <div class="tw-mt-8">
            <div class="tw-flex tw-justify-end">
                <div>
                    <jet-button @click="openModal" class="BtnNuevo">Nueva Información</jet-button>
                </div>
            </div>

            <div class="tw-overflow-x-auto tw-mx-2">

            </div>
        </div>

        <modal :show="showModal" @close="chageClose" :maxWidth="tam">
        <form>
            <div class="tw-px-4 tw-py-4">
                <div class="tw-text-lg">
                    <div class="ModalHeader">
                        <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Registro de Información</h3>
                    </div>
                </div>

                <div class="tw-mt-4">
                    <div class="ModalForm">
                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>Fecha</jet-label>
                                <jet-input type="text" v-model="form.Fecha"></jet-input>
                                <small v-if="errors.Fecha" class="validation-alert">{{errors.variable}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>Material</jet-label>
                                <select id="Jefe" v-model="form.Material"  class="InputSelect">
                                    <option v-for="select in selects" :key="select.id" :value="select.id" >{{ select.variable2 }}</option>
                                </select>
                                <small v-if="errors.variable" class="validation-alert" >{{ errors.variable }}</small>
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

    </div>



  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Welcome from "@/Jetstream/Welcome";
import Header from "@/Components/Header";
import Accions from "@/Components/Accions";
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
import moment from 'moment';
import 'moment/locale/es';

export default {
    mounted() {
        // this.tabla();
    },

    data() {
        return {
            tam: "3xl",
            color: "tw-bg-cyan-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            showModal: false,
            form: {
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
            },
        };
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
        JetSelect,
    },

    props: {
        Session: Object,
    },

    methods: {
    },
};
</script>
