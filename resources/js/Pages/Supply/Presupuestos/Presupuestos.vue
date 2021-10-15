<template>
  <app-layout>
    <div class="uppercase tw-mx-4">
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-user tw-ml-3 tw-mr-3"></i>
                    Presupuestos
                </h3>
            </slot>
        </Header>


        <div class="tw-mt-8">
            <div class="tw-flex tw-justify-between tw-px-4">
                <div class="tw-flex tw-flex-wrap tw-content-center">
                    <select class="InputSelect" @change="verTabla" v-model="dpto" v-html="opc"></select>
                </div>
                <div>
                    <jet-button @click="openModal" class="BtnNuevo">Nueva Información</jet-button>
                </div>
            </div>

            <div class="tw-overflow-x-auto tw-mx-2">
                <Table id="presupuestos">
                    <template v-slot:TableHeader>
                        <th class="columna">id</th>
                        <th class="columna">Mes</th>
                        <th class="columna">Departamento</th>
                        <th class="columna">Presupuesto</th>
                        <th class="columna">Acciones</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila" v-for="dato in Presupuestos" :key="dato.id">
                            <td class="tw-p-2">{{ dato.id }}</td>
                            <td class="tw-p-2">{{ dato.Mes }}</td>
                            <td class="tw-p-2">{{ dato.presupuesto_departamento.Nombre }}</td>
                            <td class="tw-p-2">{{ dato.Presupuesto }}</td>
                            <td class="fila">
                                <div class="columnaIconos">
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
                </Table>
            </div>
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
                            <div class="tw-px-3 tw-mb-6 md:tw-w-2/4 md:tw-mb-0">
                                <jet-label><span class="required">*</span>DEPARTAMENTO</jet-label>
                                <select id="Jefe" v-model="form.Departamento_id" class="InputSelect">
                                    <option v-for="dpto in Departamentos" :key="dpto.id" :value="dpto.id" > {{ dpto.Nombre }}</option>
                                </select>
                                <small v-if="errors.Departamento_id" class="validation-alert">{{errors.Departamento_id}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/4 md:tw-mb-0">
                                <jet-label><span class="required">*</span>MES</jet-label>
                                <select id="Jefe" v-model="form.Mes"  class="InputSelect">
                                    <option value="ENERO">ENERO</option>
                                    <option value="FEBRERO">FEBRERO</option>
                                    <option value="MARZO">MARZO</option>
                                    <option value="ABRIL">ABRIL</option>
                                    <option value="MAYO">MAYO</option>
                                    <option value="JUNIO">JUNIO</option>
                                    <option value="JULIO">JULIO</option>
                                    <option value="AGOSTO">AGOSTO</option>
                                    <option value="SEPTIEMBRE">SEPTIEMBRE</option>
                                    <option value="OCTUBRE">OCTUBRE</option>
                                    <option value="NOVIEMBRE">NOVIEMBRE</option>
                                    <option value="DICIEMBRE">DICIEMBRE</option>
                                </select>
                                <small v-if="errors.Mes" class="validation-alert">{{errors.Mes}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/4 md:tw-mb-0">
                                <jet-label><span class="required">*</span>PRESUPUESTO</jet-label>
                                <jet-input type="text" v-model="form.Presupuesto"></jet-input>
                                <small v-if="errors.Presupuesto" class="validation-alert">{{errors.Presupuesto}}</small>
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
import JetInput from "@/Components/Input";
import JetSelect from "@/Components/Select";
//imports de datatables
import datatable from "datatables.net-bs5";
import $ from "jquery";
import moment from 'moment';
import 'moment/locale/es';
import throttle from 'lodash/throttle'

export default {
    mounted() {
        this.mostSelect();
        this.tabla();
    },

    data() {
        return {
            tam: "3xl",
            color: "tw-bg-sky-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            opc: '<option value="" disabled>Selecciona un departamento </option>',
            dpto: '',
            form: {
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
                Departamento_id: null,
                Mes: null,
                Presupuesto: null,
            },
            params:{
                dpto: null,
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
        flash: Object,
        Departamentos: Object,
        Presupuestos: Object,
    },

    methods: {
        mostSelect() {
            this.$nextTick(() => {
                this.Departamentos.forEach(r => {
                    this.opc += `<option value="${r.id}"> ${r.Nombre} </option>`;
                })
            });
        },

        reset() {
            this.dpto = '',
            this.form = {
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
                Departamento_id: null,
                Mes: null,
                Presupuesto: null,
            };
        },

        //datatable
        tabla() {
            this.$nextTick(() => {
                $("#presupuestos").DataTable({language: this.español,});
            });
        },

        //consulta para generar datos de la tabla
        verTabla(event) {
            // $('#presupuestos').DataTable().clear(); //limpio
            $('#presupuestos').DataTable().destroy(); //destruyo tabla
                this.$inertia.get('/Supply/Presupuestos',{ dpto: event.target.value }, {
                onSuccess: () => { this.tabla(); }, preserveState: true
            });
        },

        save(data) {
            this.$inertia.post('/Supply/Presupuestos', data, {
                onSuccess: () => {
                    console.log(this.flash);
                    switch (this.flash) {
                        case 0:
                            this.reset(),
                            this.chageClose(),
                            this.alertSucces()
                            break;
                        case 1:
                            Swal.fire(
                            'Datos Inválidos',
                            'El presupuesto correspondiente al Mes ya se encuentra registrado',
                            'error'
                            )
                        break;
                    }
                    },
            });
        },

        edit: function (data) {
            this.form = Object.assign({}, data);
            this.editMode = true;
            this.chageClose();
        },

        update(data) {
            data._method = 'PUT';
            this.$inertia.post('/Supply/Presupuestos/' + data.id, data, {
                onSuccess: () => {
                    this.reset(),
                    this.alertSucces()
                    this.chageClose()
                    },
            });
        },

        deleteRow: function (data) {
            if (!confirm('¿Estas seguro de querer eliminar el presupuesto Asignado?')) return;
            data._method = 'DELETE';
            this.$inertia.post('/Supply/Presupuestos/' + data.id, data, {
                onSuccess: () => {
                    this.alertDelete()
                    },
            });
        }
    },

    watch: {
        params: {
        deep: true,
            handler: throttle(function() {
                $('#presupuestos').DataTable().clear(); //limpio
                $('#presupuestos').DataTable().destroy(); //destruyo tabla
                this.$inertia.get('/Supply/Presupuestos', this.params , {
                    onSuccess: () => {
                        this.tabla() //regeneracion de tabla
                    }, preserveState: true})
            }, 150),
        },
    },
};
</script>
