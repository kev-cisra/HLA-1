<template>
    <app-layout>
        <!-- ****************************************** TITULO ********************************************* -->
        <section class="tw-uppercase tw-mx-4">
            <Header :class="[color, style]">
                <slot>
                    <h3 class="tw-p-2"><i class="fa-solid fa-desktop tw-ml-3 tw-mr-3"></i>Asignación de equipos de cómputo</h3>
                </slot>
            </Header>
        </section>
        <!-- ******************************* FILTROS ********************************************* -->
        <section class="tw-flex tw-justify-end tw-content-center tw-p-1 tw-my-8 tw-mx-4">
            <div>
                <jet-button @click="openModal" class="BtnNuevo">ASIGNAR EQUIPO</jet-button>
            </div>
        </section>
        <!-- ****************************************** CONTENIDO ********************************************* -->
        <section class="tw-mx-2">
            <Table id="datos">
                <template v-slot:TableHeader>
                    <th class="columna">Fecha Asignacion</th>
                    <th class="columna">SubArea</th>
                    <th class="columna">Ubicacion</th>
                    <th class="columna">Comentarios</th>
                    <th class="columna">Estatus</th>
                    <th class="columna">Equipo Asignado</th>
                    <th class="columna">Asignado a</th>
                    <th class="columna">ACCIONES</th>
                </template>

                <template v-slot:TableFooter>
                    <tr class="fila" v-for="data in EquiposAsignados" :key="data.id">
                        <td class="tw-p-2">{{data.FechaAsignacion}}</td>
                        <td class="tw-p-2">{{data.SubArea}}</td>
                        <td class="tw-p-2">{{data.Ubicacion}}</td>
                        <td class="tw-p-2">{{data.Comentarios}}</td>
                        <td class="tw-p-2">{{data.Estatus}}</td>
                        <td class="tw-p-2">{{data.hardware.Nombre}}</td>
                        <td class="tw-p-2">{{data.perfil.Nombre}} {{data.perfil.ApPat}} {{data.perfil.ApMat}}</td>
                        <td>
                            <div class="tw-flex tw-justify-center tw-items-center tw-gap-4">
                                <div class="iconoEdit" @click="edit(data)">
                                    <span tooltip="Editar" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                </template>
            </Table>
        </section>
        <!-- **************************************************** MODALES ****************************************************** -->
        <modal :show="showModal" @close="chageClose" :maxWidth="tam">
            <div class="ModalHeader">
                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Equipos Computo</h3>
            </div>
            <div class="ModalForm">
                <div class="tw-mb-6 md:tw-flex">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/4 md:tw-mb-0">
                        <jet-label><span class="required">*</span>FECHA ASIGNACIÓN</jet-label>
                        <jet-input type="date" v-model="form.FechaAsignacion"></jet-input>
                    </div>
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/4 md:tw-mb-0">
                        <jet-label><span class="required">*</span>SUBAREA</jet-label>
                        <jet-input type="text" v-model="form.SubArea" @input="(val) => (form.SubArea = form.SubArea.toUpperCase())"></jet-input>
                    </div>
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label>UBICACIÓN</jet-label>
                        <jet-input type="text" v-model="form.Ubicacion" @input="(val) => (form.Ubicacion = form.Ubicacion.toUpperCase())"></jet-input>
                    </div>
                </div>
                <div class="tw-mb-6 md:tw-flex">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label><span class="required">*</span>Persona</jet-label>
                        <select class="InputSelect" v-model="form.Perfil_id">
                            <option v-for="Perf in Perfiles" :key="Perf.id" :value="Perf.id" > {{ Perf.IdEmp }}-{{ Perf.Nombre }} {{ Perf.ApPat }} {{ Perf.ApMat }}</option>
                        </select>
                        <!-- <small v-if="errors.obj" class="validation-alert">{{errors.obj}}</small> -->
                    </div>
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                    <jet-label><span class="required">*</span>Equipo</jet-label>
                        <select class="InputSelect" v-model="form.Hardware_id">
                            <option v-for="Har in Hardware" :key="Har.id" :value="Har.id" > {{ Har.Nombre }}</option>
                        </select>
                        <!-- <small v-if="errors.obj" class="validation-alert">{{errors.obj}}</small> -->
                    </div>
                </div>
                <div class="tw-mb-6 md:tw-flex">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                        <jet-label>COMENTARIOS</jet-label>
                        <textarea cols="2" v-model="form.Comentarios" @input="(val) => (form.Comentarios = form.Comentarios.toUpperCase())" class="tw-bg-gray-200 tw-text-gray-500 tw-font-semibold focus:tw-outline-none focus:tw-shadow-outline tw-border tw-border-gray-300 tw-rounded-lg tw-py-2 tw-px-4 tw-block tw-w-full tw-appearance-none tw-shadow-sm"></textarea>
                    </div>
                </div>
            </div>
            <div class="ModalFooter">
                <jet-button type="button" @click="save(form)" v-show="!editMode">Guardar</jet-button>
                <jet-button type="button" @click="update(form)" v-show="editMode">Actualizar</jet-button>
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
import moment from 'moment';
import 'moment/locale/es';


export default {

    data() {
        return {
            tam: "4xl",
            color: "tw-bg-sky-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            form: {
                IdUser: this.Session.id,
                FechaAsignacion: '',
                SubArea: '',
                Ubicacion: '',
                Perfil_id: '',
                Hardware_id: 1,
                Comentarios: '',
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
        Hardware: Object,
        Perfiles: Object,
        EquiposAsignados: Object,
    },

    mounted(){
    },

    methods: {
        reset() {
            this.form = {
                IdUser: this.Session.id,
                FechaAsignacion: '',
                SubArea: '',
                Ubicacion: '',
                Perfil_id: '',
                Hardware_id: '',
                Comentarios: '',
            };
        },

        save(data){
            this.$inertia.post("/Sistemas/EquiposAsignados", data, {
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
            this.$inertia.post("/Sistemas/EquiposAsignados/" + data.id, data, {
                onSuccess: () => {
                this.reset(), this.chageClose(), this.alertSucces();
                },
            });
        },
    },
};
</script>
