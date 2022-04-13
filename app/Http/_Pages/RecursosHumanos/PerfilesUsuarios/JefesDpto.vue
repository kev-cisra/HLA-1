<template>
    <app-layout>
        <section class="uppercase tw-mx-4">
            <Header :class="[color, style]">
                <slot>
                    <h3 class="tw-p-2">
                        <i class="fas fa-user tw-ml-3 tw-mr-3"></i>
                            JEFES DE DEPARTAMENTO
                    </h3>
                </slot>
            </Header>
        </section>
        <!-- ******************************* FILTROS ********************************************* -->
        <section class="tw-flex tw-justify-between tw-content-center tw-border tw-p-2 tw-my-8 tw-mx-2">
            <div class="tw-flex tw-gap-4 tw-mx-2">
            </div>
            <div>
                <jet-button @click="openModal" class="BtnNuevo">ASIGNA NUEVO JEFE</jet-button>
            </div>
        </section>
        <!-- ********************************* TABLAS ********************************************* -->


         <!-- **************************************************** MODALES ****************************************************** -->
        <modal :show="showModal" @close="chageClose" :maxWidth="tam">
            <div class="ModalHeader">
                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Asigna Jefe a un departamento</h3>
            </div>

            <div class="ModalForm">
                <div class="FormSection">
                    <div class="tw-px-3 tw-mb-6 tw-w-full md:tw-mb-0">
                        <jet-label><span class="required">*</span>PERFIL</jet-label>
                        <Select2 v-model="form.Perfil_id" class="InputSelect" :settings="{width: '100%',allowClear: true}" element="background: '#e5e7eb'" :options="BuscaPerfil" />
                        <!-- <small v-if="errors.obj" class="validation-alert">{{errors.obj}}</small> -->
                    </div>
                </div>
                <div class="FormSection">
                    <div class="tw-px-3 tw-mb-6 tw-w-full md:tw-mb-0">
                        <jet-label><span class="required">*</span>DEPARTAMENTO</jet-label>
                        <select class="InputSelect" v-model="form.Departamento_id">
                            <option v-for="Dpto in Departamentos" :key="Dpto.id" :value="Dpto.id" > {{ Dpto.Nombre }}</option>
                        </select>
                        <!-- <small v-if="errors.obj" class="validation-alert">{{errors.obj}}</small> -->
                    </div>
                </div>
                <div class="FormSection">
                    <div class="tw-px-3 tw-mb-6 tw-w-full md:tw-mb-0">
                        <jet-label><span class="required">*</span>CATEGORIA</jet-label>
                        <select class="InputSelect" v-model="form.Cargo">
                            <option value="1">JEFE</option>
                            <option value="2">COORDINADOR/ENCARGADO</option>
                            <option value="3">LIDER</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="ModalFooter">
                <jet-button type="button" @click="save(form)" v-show="!editMode" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Guardar</jet-button>
                <jet-button type="button" @click="update(form)" v-show="editMode" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Actualizar</jet-button>
                <jet-CancelButton @click="chageClose">Cerrar</jet-CancelButton>
            </div>
        </modal>
        <pre>
            {{ Jefes }}
        </pre>
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
import JetInput from "@/Components/Input";
import JetLabel from '@/Jetstream/Label';
import JetSelect from "@/Components/Select";
import Select2 from 'vue3-select2-component';
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
            tam: "xl",
            color: "tw-bg-green-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            form: {
                IdUser: this.Session.id,
                Perfil_id: '',
                Departamento_id: '',
                Cargo: '',
            },
            params: {
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
        JetLabel,
        JetSelect,
        Select2,
    },

    props: {
        Session: Object,
        Departamentos: Object,
        Perfiles: Object,
        Jefes: Object,
    },

    mounted() {
    },

    methods: {
        reset() {
            this.form = {
                IdUser: this.Session.id,
                Perfil_id: '',
                Departamento_id: '',
                Cargo: '',
            };
        },

        save(data){
            this.$inertia.post("/RecursosHumanos/JefeDpto", data, {
                onSuccess: () => {
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
            this.$inertia.post("/RecursosHumanos/JefeDpto/" + data.id, data, {
                onSuccess: () => {
                    this.reset(),
                    this.chageClose(),
                    this.alertSucces();
                },
            });
        },

       //Generacion de Tabla con Datatables
        tabla(){
            this.$nextTick(() => {
                $("#tabla").DataTable({
                    destroy: true,
                    stateSave: true,
                    language: this.español,
                    paging: true,
                    pageLength : 20,
                    scrollX: true,
                    scrollY:  '40vh',
                    order: [0, 'desc'],
                    columnDefs: [
                        { "width": "3%", "targets": [0] },
                    ],
                    "dom": '<"row"<"col-sm-6 col-md-3"l><"col-sm-6 col-md-6"B><"col-sm-12 col-md-3"f>>'+
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        'colvis'
                    ]
                }).draw();
            });
        },
    },

    computed:{
        //Funcion de buscador
        BuscaPerfil: function () {
            const PerfilesUsu = [];
            this.Perfiles.forEach(element => {
                PerfilesUsu.push({id: element.id, text: element.IdEmp + '-'+ element.Nombre+' '+element.ApPat+' '+element.ApMat})
            });
            return PerfilesUsu;
        },
    }
};
</script>
