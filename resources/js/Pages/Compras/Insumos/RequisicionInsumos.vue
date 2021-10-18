<template>
  <app-layout>
    <div class="uppercase tw-mx-4">
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-store tw-ml-3 tw-mr-3"></i>
                        Requisiciones de Insumos
                </h3>
            </slot>
        </Header>

        <div class="tw-mt-8">
            <div class="tw-flex tw-justify-end">
                <div>
                    <jet-button @click="openInsumos" class="BtnNuevo">Solicita Insumos</jet-button>
                </div>
            </div>

            <div class="tw-overflow-x-auto tw-mx-2">
<!--                 <Table id="perfiles">
                    <template v-slot:TableHeader>
                        <th class="columna">dato</th>
                        <th class="columna">Acciones</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila" v-for="dato in datos" :key="dato.id">
                            <td class="tw-p-2">{{ dato.var }}</td>
                            <td class="fila">
                                <div class="columnaIconos">
                                    <div class="iconoDetails" @click="show(dato)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <span tooltip="Detalles" flow="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="iconoEdit" @click="edit(dato)">
                                        <span tooltip="Editar" flow="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="iconoDelete" @click="deleteRow(dato)">
                                        <span tooltip="Eliminar" flow="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>
                </Table> -->
            </div>
        </div>

        <modal :show="showModalInsumos" @close="chageCloseInsumos" :maxWidth="tam">
            <form>
                <div class="tw-px-4 tw-py-4">
                    <div class="tw-text-lg">
                        <div class="ModalHeader">
                            <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Registro de Información     {{ NumInsumos }}</h3>
                        </div>
                    </div>

                    <div class="tw-mt-4">
                        <div class="ModalForm tw-overflow-y-auto tw-h-96">

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Cantidad</jet-label>
                                    <jet-input type="number" min="1" v-model="form.Ins1"></jet-input>
                                    <small v-if="errors.Ins1" class="validation-alert">{{errors.Ins1}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-10/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Material</jet-label>
                                    <jet-input type="text" min="1" value="8/1  BOBINA CILINDRICA ENG. AMARILLO"></jet-input>
                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Cantidad</jet-label>
                                    <jet-input type="number" min="1" v-model="form.Ins2"></jet-input>
                                    <small v-if="errors.Ins2" class="validation-alert">{{errors.Ins2}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-10/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Material</jet-label>
                                    <jet-input type="text" min="1" value="12/1  BOBINA CILINDRICA ENG. NEGRO"></jet-input>
                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Cantidad</jet-label>
                                    <jet-input type="number" min="1" v-model="form.Ins3"></jet-input>
                                    <small v-if="errors.Ins3" class="validation-alert">{{errors.Ins3}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-10/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Material</jet-label>
                                    <jet-input type="text" min="1" value="16/1  BOBINA CILINDRICA ENG. VERDE"></jet-input>
                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Cantidad</jet-label>
                                    <jet-input type="number" min="1" v-model="form.Ins4"></jet-input>
                                    <small v-if="errors.Ins4" class="validation-alert">{{errors.Ins4}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-10/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Material</jet-label>
                                    <jet-input type="text" min="1" value="20/1  BOBINA CILINDRICA ENG. AZUL"></jet-input>
                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Cantidad</jet-label>
                                    <jet-input type="number" min="1" v-model="form.Ins5"></jet-input>
                                    <small v-if="errors.Ins5" class="validation-alert">{{errors.Ins5}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-10/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Material</jet-label>
                                    <jet-input type="text" min="1" value="BOBINA CILINDRICA ENG. NATURAL NUEVA"></jet-input>
                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Cantidad</jet-label>
                                    <jet-input type="number" min="1" v-model="form.Ins6"></jet-input>
                                    <small v-if="errors.Ins6" class="validation-alert">{{errors.Ins6}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-10/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Material</jet-label>
                                    <jet-input type="text" min="1" value="BOBINA CILINDRICA ENG. DE PUNTA RECTA NATURAL"></jet-input>
                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Cantidad</jet-label>
                                    <jet-input type="number" min="1" v-model="form.Ins7"></jet-input>
                                    <small v-if="errors.Ins7" class="validation-alert">{{errors.Ins7}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-10/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Material</jet-label>
                                    <jet-input type="text" min="1" value="BOLSA EMPAQUE POLIPAPEL 72X1.30C/250"></jet-input>
                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Cantidad</jet-label>
                                    <jet-input type="number" min="1" v-model="form.Ins8"></jet-input>
                                    <small v-if="errors.Ins8" class="validation-alert">{{errors.Ins8}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-10/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Material</jet-label>
                                    <jet-input type="text" min="1" value="BOLSA EMPAQUE POLIPAPEL 75X1.30C/280"></jet-input>
                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Cantidad</jet-label>
                                    <jet-input type="number" min="1" v-model="form.Ins9"></jet-input>
                                    <small v-if="errors.Ins9" class="validation-alert">{{errors.Ins9}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-10/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Material</jet-label>
                                    <jet-input type="text" min="1" value="BOLSA EMPAQUE POLIPAPEL 65X1.30C/250"></jet-input>
                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Cantidad</jet-label>
                                    <jet-input type="number" min="1" v-model="form.Ins10"></jet-input>
                                    <small v-if="errors.Ins10" class="validation-alert">{{errors.Ins10}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-10/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Material</jet-label>
                                    <jet-input type="text" min="1" value="BOLSA P/POLVO POLIPAPEL. 100 X 180 CAL. 250"></jet-input>
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
            showModalInsumos: false,
            form: {
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
                Ins1: null,
                Ins2: null,
                Ins3: null,
                Ins4: null,
                Ins5: null,
                Ins6: null,
                Ins7: null,
                Ins8: null,
                Ins9: null,
                Ins10: null,
                Ins11: null,
                Ins12: null,
                Ins13: null,
                Ins14: null,
                Ins15: null,
                Ins16: null,
                Ins17: null,
                Ins18: null,
                Ins19: null,
                Ins20: null,
                Ins21: null,
                Ins22: null,
                Ins23: null,
                Ins24: null,
                Ins25: null,
                Ins26: null,
                Ins27: null,
                Ins28: null,
                Ins29: null,
                Ins30: null,
                Ins31: null,
                Ins32: null,
                Ins33: null,
                Ins34: null,
                Ins35: null,
                Ins36: null,
                Ins37: null,
                Ins38: null,
                Ins39: null,
                Ins40: null,
                Ins41: null,
                Ins42: null,
                Ins43: null,
                Ins44: null,
                Ins45: null,
                Ins46: null,
                Ins47: null,
                Ins48: null,
                Ins49: null,
                Ins50: null,
                Ins51: null,
                Ins52: null,
                Ins53: null,
                Ins54: null,
                Ins55: null,
                Ins56: null,
                Ins57: null,
                Ins58: null,
                Ins59: null,
                Ins60: null,
                Ins61: null,
                Ins62: null,
                Ins63: null,
                Ins64: null,
                Ins65: null,
                Ins66: null,
                Ins67: null,
                Ins68: null,
                Ins69: null,
                Ins70: null,
                Ins71: null,
                Ins72: null,
                Ins73: null,
                Ins74: null,
                Ins75: null,
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
        errors: Object,
        Insumos: Object,
        NumInsumos: Object,
    },

    methods: {
        reset() {
            this.form = {
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
                Ins1: null,
                Ins2: null,
                Ins3: null,
                Ins4: null,
                Ins5: null,
                Ins6: null,
                Ins7: null,
                Ins8: null,
                Ins9: null,
                Ins10: null,
                Ins11: null,
                Ins12: null,
                Ins13: null,
                Ins14: null,
                Ins15: null,
                Ins16: null,
                Ins17: null,
                Ins18: null,
                Ins19: null,
                Ins20: null,
                Ins21: null,
                Ins22: null,
                Ins23: null,
                Ins24: null,
                Ins25: null,
                Ins26: null,
                Ins27: null,
                Ins28: null,
                Ins29: null,
                Ins30: null,
                Ins31: null,
                Ins32: null,
                Ins33: null,
                Ins34: null,
                Ins35: null,
                Ins36: null,
                Ins37: null,
                Ins38: null,
                Ins39: null,
                Ins40: null,
                Ins41: null,
                Ins42: null,
                Ins43: null,
                Ins44: null,
                Ins45: null,
                Ins46: null,
                Ins47: null,
                Ins48: null,
                Ins49: null,
                Ins50: null,
                Ins51: null,
                Ins52: null,
                Ins53: null,
                Ins54: null,
                Ins55: null,
                Ins56: null,
                Ins57: null,
                Ins58: null,
                Ins59: null,
                Ins60: null,
                Ins61: null,
                Ins62: null,
                Ins63: null,
                Ins64: null,
                Ins65: null,
                Ins66: null,
                Ins67: null,
                Ins68: null,
                Ins69: null,
                Ins70: null,
                Ins71: null,
                Ins72: null,
                Ins73: null,
                Ins74: null,
                Ins75: null,
            };
        },

        openInsumos() {
            this.chageCloseInsumos();
            this.reset();
            this.editMode = false;
        },

        chageCloseInsumos() {
            this.showModalInsumos = !this.showModalInsumos;
        },

        //datatable
        tabla() {
            this.$nextTick(() => {
                $("#Papeleria").DataTable({
                language: this.español,
                });
            });
        },

        addRow: function () {
            this.form.Partida.push({Part: ""});
        },

        removeRow: function (row) {
            this.form.Partida.splice(row,1);
        },

        save(data) {
            console.log(data);
            this.$inertia.post("/Compras/Insumos", data, {
                onSuccess: () => {
                    this.reset(),
                    this.chageClose(),
                    this.alertSucces();
                },
            });
        },
    },
};
</script>
