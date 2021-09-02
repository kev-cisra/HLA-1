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
                <Table id="Articulos">
                    <template v-slot:TableHeader>
                        <th class="columna">FECHA</th>
                        <th class="columna"># REQUISICIÓN</th>
                        <th class="columna">CÓDIGO</th>
                        <th class="columna">CANTIDAD</th>
                        <th class="columna">UNIDAD</th>
                        <th class="columna">DESCRIPCIÓN</th>
                        <th class="columna">MAQUINA</th>
                        <th class="columna">MARCA</th>
                        <th class="columna">ESTATUS</th>
                        <th class="columna">FECHA LLEGADA</th>
                        <th class="columna">ACCIONES</th>
                        <th class="columna">DETALLES</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila" v-for="datos in ArticuloRequisicion" :key="datos.id">
                            <td class="tw-p-2">{{ datos.articulos_requisicion.Fecha }}</td>
                            <td class="tw-p-2">{{ datos.articulos_requisicion.NumReq }}</td>
                            <td class="tw-p-2">{{ datos.articulos_requisicion.Codigo }}</td>
                            <td class="tw-p-2">{{ datos.Cantidad }}</td>
                            <td class="tw-p-2">{{ datos.Unidad }}</td>
                            <td class="tw-p-2">{{ datos.Descripcion }}</td>
                            <td class="tw-p-2">{{ datos.articulos_requisicion.requisicion_maquina.Nombre }}</td>
                            <td class="tw-p-2">{{ datos.articulos_requisicion.requisicion_marca.Nombre }}</td>
                            <td class="tw-p-2">{{ datos.articulos_requisicion.Estatus }}</td>
                            <td class="tw-p-2">{{ datos.articulos_requisicion.Fecha }}</td>
                            <td class="fila">
                                <div class="columnaIconos">
                                    <div class="iconoEdit" @click="edit(datos)">
                                        <span tooltip="Editar" flow="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="iconoDelete" @click="deleteRow(datos)">
                                        <span tooltip="Eliminar" flow="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="tw-p-2">
                                <div class="tw-flex tw-justify-center">
                                    <div class="iconoDetails" v-if="detalles != datos.id" @click="show(datos.id)">
                                        <span tooltip="Detalles" flow="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <div v-if="detalles == datos.id" class="tw-w-80">
                                        <div class="border-b">
                                            <h2 class="tw-text-sm tw-text-center">Requisición <strong>#{{datos.articulos_requisicion.NumReq}}</strong> </h2>
                                        </div>
                                        <div>
                                            <div class="tw-text-xs tw-border-b md:tw-grid md:tw-grid-cols-2 hover:tw-bg-gray-50">
                                                <p class="tw-text-gray-600">FOLIO</p>
                                                <p class="tw-font-semibold">{{datos.articulos_requisicion.Folio}}</p>
                                            </div>
                                            <div class="tw-text-xs tw-border-b md:tw-grid md:tw-grid-cols-2 hover:tw-bg-gray-50">
                                                <p class="tw-text-gray-600">NOMBRE DEL SOLICITANTE</p>
                                                <p class="tw-font-semibold">{{datos.articulos_requisicion.requisiciones_perfil.Nombre}} {{datos.articulos_requisicion.requisiciones_perfil.ApPat}} {{datos.articulos_requisicion.requisiciones_perfil.ApMat}}</p>
                                            </div>
                                            <div class="tw-text-xs tw-border-b md:tw-grid md:tw-grid-cols-2 hover:tw-bg-gray-50">
                                                <p class="tw-text-gray-600">OBSERVACIONES</p>
                                                <p class="tw-font-semibold">{{datos.articulos_requisicion.Observaciones}}</p>
                                            </div>
                                            <div class="tw-text-xs tw-border-b md:tw-grid md:tw-grid-cols-2 hover:tw-bg-gray-50">
                                                <p class="tw-text-gray-600">Comentarios.</p>
                                                <p class="tw-font-semibold">{{datos.articulos_requisicion.Folio}}</p>
                                            </div>
                                            <div class="tw-flex tw-justify-center">
                                                <div @click="hidden()" class="tw-w-4 tw-mr-2 tw-transform tw-cursor-pointer hover:tw-text-red-500 hover:tw-scale-125">
                                                    <i class="fas fa-window-close"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>
                </Table>
            </div>
        </div>

         <datepicker></datepicker>
    </div>

    <modal :show="showModal" @close="chageClose" :maxWidth="tam">
        <form>
            <div class="tw-px-4 tw-py-4">
                <div class="tw-text-lg">
                    <div class="ModalHeader">
                        <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Nueva Requisición</h3>
                    </div>
                </div>

                <div class="tw-mt-4">
                    <div class="ModalForm">
                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>FECHA</jet-label>
                                <jet-input type="date" v-model="form.Fecha"></jet-input>
                                <small v-if="errors.Fecha" class="validation-alert">{{errors.Fecha}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>AREA</jet-label>
                                <select id="Jefe" v-model="form.Departamento_id" class="InputSelect">
                                    <option v-for="dpto in Departamentos" :key="dpto.id" :value="dpto.id" > {{ dpto.Nombre }}</option>
                                </select>
                                <small v-if="errors.Fecha" class="validation-alert">{{errors.Fecha}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>Num Requisicion</jet-label>
                                <jet-input type="number" v-model="form.NumReq"></jet-input>
                                <small v-if="errors.NumReq" class="validation-alert">{{errors.NumReq}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>Código</jet-label>
                                <select id="Empresa" v-model="form.Codigo" class="InputSelect">
                                    <option value="A - EXTRAORDINARIA">A - EXTRAORDINARIA</option>
                                    <option value="B - REGULAR">B - REGULAR</option>
                                    <option value="C - PRESUPUESTO">C - PRESUPUESTO</option>
                                </select>
                                <small v-if="errors.Codigo" class="validation-alert">{{errors.Codigo}}</small>
                            </div>
                        </div>
                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>MÁQUINA</jet-label>
                                <select id="Maquina" v-model="form.Maquina" name="Maquina" class="InputSelect" @change="loadMarcas($event)">
                                    <option v-for="maq in Maquinas" :key="maq.id" :value="maq.id"> {{ maq.Nombre }}</option>
                                </select>
                                <small v-if="errors.Maquina" class="validation-alert">{{errors.Maquina}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>MARCA</jet-label>
                                <select id="Marca" v-model="form.Marca" class="InputSelect">
                                    <option v-for="maq in Marcas" :key="maq.id" :value="maq.id" > {{ maq.Nombre }}</option>
                                </select>
                                <small v-if="errors.Marca" class="validation-alert">{{errors.Marca}}</small>
                            </div>
                        </div>
                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>TIPO DE COMPRA</jet-label>
                                <select id="Tipo" v-model="form.Tipo" class="InputSelect">
                                    <option value="REQUISICIÓN">REQUISICIÓN</option>
                                    <option value="REFACCIONES">REFACCIONES</option>
                                    <option value="SERVICIOS EXTERNOS">SERVICIOS EXTERNOS</option>
                                    <option value="ORDEN DE TRABAJO">ORDEN DE TRABAJO</option>
                                    <option value="PRODUCTOS AUXILIARES">PRODUCTOS AUXILIARES</option>
                                    <option value="MODIFICACIONES Y PROYECTOS">MODIFICACIONES Y PROYECTOS</option>
                                </select>
                                <small v-if="errors.Tipo" class="validation-alert">{{errors.Tipo}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>NOMBRE SOLICITANTE</jet-label>
                                <select id="Nombre" v-model="form.Nombre" class="InputSelect">
                                    <option v-for="per in PerfilesUsuarios" :key="per.id" :value="per.id" > {{ per.Nombre }} {{per.ApPat}} {{per.ApMat}}</option>
                                </select>
                                <small v-if="errors.Nombre" class="validation-alert">{{errors.Nombre}}</small>
                            </div>
                        </div>
                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                                <jet-label><span class="required">*</span>CANTIDAD</jet-label>
                                <jet-input type="number" v-model="form.Cantidad"></jet-input>
                                <small v-if="errors.Cantidad" class="validation-alert">{{errors.Cantidad}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                                <jet-label><span class="required">*</span>UNIDAD</jet-label>
                                <select id="Unidad" v-model="form.Unidad" class="InputSelect">
                                    <option value="PZ">PIEZAS</option>
                                    <option value="LTS">LITROS</option>
                                    <option value="KG">KILOGRAMOS</option>
                                    <option value="MT">METROS</option>
                                    <option value="SERVICIO">SERVICIO</option>
                                    <option value="CAJA">CAJA</option>
                                    <option value="OTRO">OTRO</option>
                                </select>
                                <small v-if="errors.Unidad" class="validation-alert">{{errors.Unidad}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-6/12 md:tw-mb-0">
                                <jet-label><span class="required">*</span>DESCRIPCIÓN</jet-label>
                                <jet-input type="text" v-model="form.Descripcion" @input="(val) => (form.Descripcion = form.Descripcion.toUpperCase())"></jet-input>
                                <small v-if="errors.Descripcion" class="validation-alert">{{errors.Descripcion}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                                <jet-CancelButton @click="addRow()">Añadir Partida</jet-CancelButton>
                            </div>
                        </div>
                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                                <jet-label><span class="required">*</span>OBSERVACIONES</jet-label>
                                <textarea name="" id="" cols="2" v-model="form.Observaciones" @input="(val) => (form.Observaciones = form.Observaciones.toUpperCase())" class="tw-bg-gray-200 tw-text-gray-500 tw-font-semibold focus:tw-outline-none focus:tw-shadow-outline tw-border tw-border-gray-300 tw-rounded-lg tw-py-2 tw-px-4 tw-block tw-w-full tw-appearance-none tw-shadow-sm"></textarea>
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
import JetInput from "@/Components/Input";
import JetSelect from "@/Components/Select";
//imports de datatables
import datatable from "datatables.net-bs5";
import $ from "jquery";
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
//Moment Js
import moment from 'moment';
import 'moment/locale/es';

export default {
    data() {
        return {
            now: moment().format("YYYY-MM-DD"),
            tam: "5xl",
            color: "tw-bg-cyan-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            detalles: null,
            form: {
                IdUser: this.Session.id,
                Fecha: new Date(),
                Departamento_id: null,
                NumReq: null,
                Codigo: null,
                Maquina: null,
                Marca: null,
                Tipo: null,
                Nombre: null,
                Cantidad: null,
                Marca: null,
                Unidad: null,
                Descripcion: null,
                Observaciones: null,
            },
            Marcas: [],
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
        Table,
        JetButton,
        JetCancelButton,
        Modal,
        Pagination,
        JetInput,
        JetSelect,
        DatePicker,
    },

    props: {
        Session: Object,
        errors: Object,
        ArticuloRequisicion: Object,
        Departamentos: Object,
        Maquinas: Object,
        PerfilesUsuarios: Object,
    },

    methods: {
        reset() {
            this.form = {
                IdUser: this.Session.id,
            };
        },

        loadMarcas(event) {
            axios.get('/Compras/Marcas',{
                params: {
                    Maquina: event.target.value
                }
            })
            .then(response => this.Marcas = response.data.Marcas)
            .catch(error => console.log(error))
        },

        //datatable
        tabla() {
        this.$nextTick(() => {
            $("#Articulos").DataTable({
            language: this.español,
            });
        });
        },

        //consulta para generar datos de la tabla
        verTabla(event) {
        $("#Articulos").DataTable().destroy();
            this.$inertia.get("/Compras/Requisiciones", { busca: event.target.value },{ onSuccess: () => { this.tabla(); },});
        },

        show(id){
            this.detalles = id;
            console.log(this.detalles);
        },

        hidden(id){
            this.detalles = null;
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
