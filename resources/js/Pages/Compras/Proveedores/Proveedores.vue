<template>
  <app-layout>
    <div class="uppercase tw-mx-4">
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-user tw-ml-3 tw-mr-3"></i>
                        Alta de Proveedores
                </h3>
            </slot>
        </Header>

        <div class="tw-mt-8">
            <div class="tw-flex tw-justify-end">
                <div>
                    <jet-button @click="openModal" class="BtnNuevo">Nueva Proveedor</jet-button>
                </div>
            </div>

            <div class="tw-overflow-x-auto tw-mx-2">
                <Table id="Proveedores">
                    <template v-slot:TableHeader>
                        <th class="columna">Nombre</th>
                        <th class="columna">Area</th>
                        <th class="columna">Tipo Pago</th>
                        <th class="columna">Acciones</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila" v-for="dato in Proveedores" :key="dato.id">
                            <td class="tw-p-2">{{ dato.Nombre }}</td>
                            <td class="tw-p-2">{{ dato.proveedor_departamento.Nombre }}</td>
                            <td class="tw-p-2">{{ dato.TipoPago }}</td>
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
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>NOMBRE</jet-label>
                                <jet-input type="text" v-model="form.Nombre" @input="(val) => (form.Nombre = form.Nombre.toUpperCase())"></jet-input>
                                <small v-if="errors.Nombre" class="validation-alert">{{errors.Nombre}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>DEPARTAMENTO</jet-label>
                                <select id="Jefe" v-model="form.Departamentos_id" class="InputSelect">
                                    <option v-for="dpto in Departamentos" :key="dpto.id" :value="dpto.id" > {{ dpto.Nombre }}</option>
                                </select>
                                <small v-if="errors.Departamentos_id" class="validation-alert">{{errors.Departamentos_id}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>TIPO PAGO</jet-label>
                                <select id="Jefe" v-model="form.TipoPago" class="InputSelect">
                                    <option value="REMISION">REMISIÓN</option>
                                    <option value="FACTURADO">FACTURADO</option>
                                </select>
                                <small v-if="errors.TipoPago" class="validation-alert">{{errors.TipoPago}}</small>
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
import Table from "@/Components/TableTeal";
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
        this.tabla();
    },

    data() {
        return {
            tam: "3xl",
            color: "tw-bg-teal-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            form: {
                Nombre: null,
                Departamentos_id: null,
                TipoPago: null,
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
        errors: Object,
        Session: Object,
        Proveedores: Object,
        Departamentos: Object,
    },

    methods: {
        reset() {
            this.form = {
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
                Nombre: null,
                Departamentos_id: null,
                TipoPago: null,
            };
        },

        //datatable
        tabla() {
            this.$nextTick(() => {
                $("#Proveedores").DataTable({
                language: this.español,
                });
            });
        },

        //consulta para generar datos de la tabla
        verTabla(event) {
            $("#Proveedores").DataTable().destroy();
                this.$inertia.get("/Compras/Proveedores", { busca: event.target.value },{ onSuccess: () => { this.tabla(); },});
        },

        save(data) {
            console.log(data);
            this.$inertia.post("/Compras/Proveedores", data, {
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
            data._method = 'PUT';
            this.$inertia.post('/Compras/Proveedores/' + data.id, data, {
                onSuccess: () => {
                    this.alertSucces(),
                    this.reset(),
                    this.chageClose()
                },
            });
        },

        deleteRow: function (data) {
            Swal.fire({
                title: '¿Estas seguro de querer eliminar esta información',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, bórralo!',
                cancelButtonText: 'No, Cancelar!',
                }).then((result) => {
                    if (result.isConfirmed) {

                        data._method = "DELETE";
                        this.$inertia.post("/Compras/Proveedores/" + data.id, data, {
                            onSuccess: () => {
                                Swal.fire(
                                    'Eliminado!',
                                    'El registro fue eliminado con éxito',
                                    'success'
                                )
                            },
                        });
                    }
                })
        }

    },
};
</script>
