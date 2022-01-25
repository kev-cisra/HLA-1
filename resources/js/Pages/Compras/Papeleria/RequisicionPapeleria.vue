<template>
    <app-layout>
        <div class="uppercase tw-mx-4">
            <Header :class="[color, style]">
                <slot>
                    <h3 class="tw-p-2">
                        <i class="fas fa-user tw-ml-3 tw-mr-3"></i>
                            Requisición Papeleria
                    </h3>
                </slot>
            </Header>

            <!-- Filtros -->
            <div class="tw-flex tw-justify-between tw-content-center tw-border tw-p-2 tw-my-4">
                <div class="tw-flex tw-gap-4">
                    <div>
                        <jet-label class="tw-text-center">Año</jet-label>
                        <select class="InputSelect" v-model="params.Year">
                            <option value="0"> TODOS --</option>
                            <option value="2021"> 2021 --</option>
                            <option value="2022"> 2022 -- </option>
                        </select>
                    </div>

                    <div>
                        <jet-label class="tw-text-center">Mes</jet-label>
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

                    <div class="tw-mt-4">
                        <jet-button v-if="loading == true" @click="Filtros" class="BtnFiltros">
                            <span class="tw-animate-ping tw-relative tw-inline-flex tw-rounded-full tw-h-2 tw-w-2 tw-mr-2 tw-bg-coolGray-100"></span>
                            <!-- <span class="spinner-grow spinner-grow-sm tw-mr-2" role="status" aria-hidden="true"></span> -->
                            <p class="tw-animate-pulse">Cargando </p>
                        </jet-button>
                        <jet-button v-else @click="Filtros" class="BtnFiltros"> <i class="fas fa-filter tw-mr-1"></i> Aplica Filtros
                        </jet-button>
                    </div>
                </div>
            </div>

            <div class="tw-mt-8">
                <div class="tw-flex tw-justify-end">
                    <div v-if="FinMes == true">
                        <jet-button @click="openModal" class="BtnNuevo">Solicita Papelería</jet-button>
                    </div>
                    <div class="tw-w-full" v-else>
                        <div class="tw-py-3 tw-text-center tw-mx-10 tw-px-5 tw-mb-4 tw-bg-cyan-100 tw-text-sky-900 tw-text-sm tw-rounded-md tw-border tw-border-teal-200" role="alert">
                            La papeleria solo puede ser solicitada posteriomente de dia 15 de cada mes hasta el fin de este mismo
                        </div>
                    </div>
                </div>

                <div class="tw-overflow-x-auto tw-mx-2">
                    <Table id="Papeleria">
                        <template v-slot:TableHeader>
                            <th class="columna">FECHA</th>
                            <th class="columna">FOLIO</th>
                            <th class="columna">DEPARTAMENTO</th>
                            <th class="columna">SOLICITADO</th>
                            <th class="columna">CANTIDAD</th>
                            <th class="columna">UNIDAD</th>
                            <th class="columna">MATERIAL</th>
                            <th class="columna">COMENTARIOS</th>
                            <th class="columna">ESTATUS</th>
                            <th class="columna">ACCIONES</th>
                        </template>

                        <template v-slot:TableFooter>
                            <tr class="fila" v-for="dato in Papeleria" :key="dato.id">
                                <td>{{ dato.articulos_papeleria.Fecha }}</td>
                                <td>{{ dato.articulos_papeleria.Folio }}</td>
                                <td>{{ dato.articulos_papeleria.requisicion_departamento.Nombre }}</td>
                                <td>{{ dato.articulos_papeleria.requisicion_perfil.Nombre }}</td>
                                <td>{{ dato.Cantidad }}</td>
                                <td>{{ dato.articulo_material.Unidad }}</td>
                                <td>{{ dato.articulo_material.Nombre }}</td>
                                <td>{{ dato.articulos_papeleria.Comentarios }}</td>
                                <td>
                                    <div v-if="dato.Estatus == 0">
                                        <span tooltip="Confirmar Solicitud de Papeleria" flow="left">
                                            <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-indigo-500 tw-rounded-full">SIN CONFIRMAR</span>
                                        </span>
                                    </div>
                                    <div v-else-if="dato.Estatus >= 1 && dato.Estatus < 4">
                                        <span tooltip="Confirmar Solicitud de Papeleria" flow="left">
                                            <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-teal-500 tw-rounded-full">SOLICITADO</span>
                                        </span>
                                    </div>
                                    <div v-if="dato.Estatus == 4">
                                        <span tooltip="Entrega Material" flow="left">
                                            <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-red-500 tw-rounded-full">RECHAZADO</span>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="columnaIconos" v-if="dato.Estatus == 0">
                                        <div class="iconoEdit" @click="edit(dato)">
                                            <span tooltip="Editar" flow="left">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="iconoEdit" @click="Confirma(dato, 1)">
                                            <span tooltip="Enviar Solicitud a Compra" flow="left">
                                                <i class="fas fa-check-circle"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="columnaIconos" v-else-if="dato.Estatus == 1">
                                        <div class="iconoPurple">
                                            <span tooltip="Material en proceso" flow="left">
                                                <i class="fas fa-info-circle"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="columnaIconos" v-else-if="dato.Estatus == 2">
                                        <div class="iconoPurple">
                                            <span tooltip="Pasar a recoger material" flow="left">
                                                <i class="fas fa-info-circle"></i>
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
                                <div class="tw-px-3 tw-mb-6 tw-w-full md:tw-mb-0">
                                    <jet-label><span class="required">*</span>DEPARTAMENTO</jet-label>
                                    <select id="Jefe" v-model="form.Departamento_id" class="InputSelect">
                                        <option v-for="dpto in Departamentos" :key="dpto.id" :value="dpto.id" > {{ dpto.Nombre }}</option>
                                    </select>
                                    <small v-if="errors.Departamento_id" class="validation-alert">{{errors.Departamento_id}}</small>
                                </div>
                            </div>
                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3">
                                    <input type="button" @click="addRow()" value="Añadir Material" class="BtnCancel">
                                </div>
                            </div>
                            <div class="tw-mb-6 md:tw-flex" v-for="(form) in form.Partida" :key="form.id">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>CANTIDAD</jet-label>
                                    <jet-input type="number" v-model="form.Cantidad" min="1"></jet-input>
                                    <small v-if="errors.Cantidad" class="validation-alert">{{errors.Cantidad}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-8/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>MATERIAL</jet-label>
                                    <Select2 v-model="form.Material" class="InputSelect" :settings="{class:'Select2',width: '100%', allowClear: true}" :options="BuscaNombre" />
                                    <small v-if="errors.Material" class="validation-alert">{{errors.Material}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                                    <button type="button" class="btn btn-primary" @click="removeRow(index)">Quitar</button>
                                </div>
                            </div>
                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                                    <jet-label>OBSERVACIONES</jet-label>
                                    <textarea name="" id="" cols="2" v-model="form.Comentarios" @input="(val) => (form.Comentarios = form.Comentarios.toUpperCase())" class="tw-bg-gray-200 tw-text-gray-500 tw-font-semibold focus:tw-outline-none focus:tw-shadow-outline tw-border tw-border-gray-300 tw-rounded-lg tw-py-2 tw-px-4 tw-block tw-w-full tw-appearance-none tw-shadow-sm"></textarea>
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

        <modal :show="showEdit" @close="chageCloseEdit" :maxWidth="tam">
            <form>
                <div class="tw-px-4 tw-py-4">
                    <div class="tw-text-lg">
                        <div class="ModalHeader">
                            <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Editar Solicitud Material</h3>
                        </div>
                    </div>

                    <div class="tw-mt-4">
                        <div class="ModalForm">
                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>DEPARTAMENTO</jet-label>
                                    <select id="Jefe" v-model="form.Departamento_id" class="InputSelect">
                                        <option v-for="dpto in Departamentos" :key="dpto.id" :value="dpto.id" > {{ dpto.Nombre }}</option>
                                    </select>
                                    <small v-if="errors.Departamento_id" class="validation-alert">{{errors.Departamento_id}}</small>
                                </div>
                            </div>
                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>CANTIDAD</jet-label>
                                    <jet-input type="number" v-model="form.Cantidad"></jet-input>
                                    <small v-if="errors.Cantidad" class="validation-alert">{{errors.Cantidad}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-8/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>MATERIAL</jet-label>
                                    <select id="Jefe" v-model="form.Material" class="InputSelect">
                                        <option v-for="dpto in Material" :key="dpto.id" :value="dpto.id" > {{ dpto.Nombre }}</option>
                                    </select>
                                    <small v-if="errors.Material" class="validation-alert">{{errors.Material}}</small>
                                </div>
                            </div>
                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                                    <jet-label><span class="required">*</span>OBSERVACIONES</jet-label>
                                    <textarea name="" id="" cols="2" v-model="form.Comentarios" @input="(val) => (form.Comentarios = form.Comentarios.toUpperCase())" class="tw-bg-gray-200 tw-text-gray-500 tw-font-semibold focus:tw-outline-none focus:tw-shadow-outline tw-border tw-border-gray-300 tw-rounded-lg tw-py-2 tw-px-4 tw-block tw-w-full tw-appearance-none tw-shadow-sm"></textarea>
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
import Table from "@/Components/TableCyan";
import JetButton from "@/Components/Button";
import JetCancelButton from "@/Components/CancelButton";
import Modal from "@/Jetstream/Modal";
import Pagination from "@/Components/pagination";
import JetLabel from '@/Jetstream/Label';
import JetInput from "@/Components/Input";
import JetSelect from "@/Components/Select";
import Select2 from 'vue3-select2-component';
//imports de datatables
import datatable from "datatables.net-bs5";
import $ from "jquery";
import moment from 'moment';
import 'moment/locale/es';

export default {
    mounted() {
        this.tabla();

        if(Date.parse(this.hoy) < Date.parse(this.Fin)) {

            var FechaFin = this.Fin;

            FechaFin = moment(FechaFin).format('YYYY-MM-DD');

            var Mitad = moment(FechaFin).subtract(15, 'd');
            var MitadMes = moment(Mitad).format('YYYY-MM-DD');

            if(Date.parse(this.hoy) >= Date.parse(MitadMes)){
                this.FinMes = true;
            }
        }
    },

    data() {
        return {
            showEdit: false,
            FinMes: true,
            loading: false,
            hoy: '2021-09-15',
            // hoy: moment().format('DD-MM-YYYY'),
            Ini: moment().startOf('month').format('YYYY-MM-DD hh:mm'),
            Fin: moment().endOf('month').format('YYYY-MM-DD hh:mm'),
            tam: "3xl",
            color: "tw-bg-teal-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            form: {
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
                Departamento_id: null,
                Partida: [{
                    Cantidad: null,
                    Material: null,
                    }],
                Comentarios: null,
                ReqId: null,
                ArtId: null,
            },
            params:{
                Year: this.anio,
                Month: this.mes,
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
        errors: Object,
        Session: Object,
        Departamentos: Object,
        Material: Object,
        Papeleria: Object,
        anio: String,
        mes: String,
    },

    methods: {
        reset() {
            this.form = {
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
                Departamento_id: null,
                Partida: [{
                    Cantidad: null,
                    Material: null,
                    }],
                Comentarios: null,
                ReqId: null,
                ArtId: null,
            };
        },

        Filtros(){
            this.loading = true;
            //Filtro para consultar por mes
            $('#Papeleria').DataTable().clear(); //limpio
            $('#Papeleria').DataTable().destroy(); //destruyo tabla
            this.$inertia.get('/Compras/RequisicionPapeleria', this.params , { //envio de variables por url
                onSuccess: () => {
                    this.loading = false;
                    this.tabla() //regeneracion de tabla
                }, preserveState: true})
        },

        //datatable
        tabla() {
            this.$nextTick(() => {
                $("#Papeleria").DataTable({
                language: this.español,
                });
            });
        },

        //consulta para generar datos de la tabla
        verTabla(event) {
            $("#Papeleria").DataTable().destroy();
                this.$inertia.get("/Compras/RequisicionPapeleria", { busca: event.target.value },{ onSuccess: () => { this.tabla(); },});
        },

        addRow: function () {
            this.form.Partida.push({Part: ""});
        },

        removeRow: function (row) {
            this.form.Partida.splice(row,1);
        },

        chageCloseEdit() {
            this.showEdit = !this.showEdit;
        },

        Confirma(data, metodo){
            data.metodo = 1;
            data._method = "PUT";
            this.$inertia.post("/Compras/RequisicionPapeleria/" + data.id, data, {
                onSuccess: () => {
                    this.alertSucces();
                },
            });
        },

        save(data) {
            this.$inertia.post("/Compras/RequisicionPapeleria", data, {
                onSuccess: () => {
                    this.reset(),
                    this.chageClose(),
                    this.alertSucces();
                },
            });
        },

        edit: function (data) {
            this.chageCloseEdit();
            this.form.ArtId = data.id,
            this.form.ReqId = data.papeleria_id,
            this.form.Departamento_id = data.articulos_papeleria.Departamento_id;
            this.form.Cantidad = data.Cantidad;
            this.form.Material = data.material_id;
            this.form.Comentarios = data.articulos_papeleria.Comentarios;
            this.editMode = true;
        },

        update(data) {
            data._method = 'PUT';
            this.$inertia.post('/Compras/RequisicionPapeleria/' + data.id, data, {
                onSuccess: () => {
                    this.alertSucces(),
                    this.reset(),
                    this.chageCloseEdit()
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
                        this.$inertia.post("/Compras/RequisicionPapeleria/" + data.id, data, {
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

    computed:{
            //Funcion de buscador
            BuscaNombre: function () {
                const Papeleria = [];
                this.Material.forEach(element => {
                    Papeleria.push({id: element.id, text: element.Nombre})
                });
                return Papeleria;
            }
        }
};
</script>
