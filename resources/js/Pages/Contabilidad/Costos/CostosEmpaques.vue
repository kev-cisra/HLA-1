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
            <div class="tw-flex tw-justify-end tw-content-center tw-gap-8">
                <div>
                    <jet-label class="tw-font-medium">Selecciona un Departamento</jet-label>
                    <select v-model="form.Base" @change="SeleccionaBase"  class="InputSelect">
                        <option value="APERTURA">APERTURA</option>
                        <option value="HILATURA">HILATURA</option>
                    </select>
                </div>
                <div v-if="form.Base == 'APERTURA'">
                    <jet-label class="tw-font-medium">Selecciona un Material</jet-label>
                    <select v-model="form.Material"  class="InputSelect">
                        <option value="RAFIA">RAFIA</option>
                        <option value="ETIQUETA TERMICA">ETIQUETA TERMICA</option>
                    </select>
                </div>
                <div v-else-if="form.Base == 'HILATURA'">
                    <jet-label class="tw-font-medium">Selecciona un Material</jet-label>
                    <select v-model="form.Material"  class="InputSelect">
                        <option value="ETIQUETA TERMICA">ETIQUETA TERMICA</option>
                        <option value="BOLSA POLIPAPEL">BOLSA POLIPAPEL</option>
                        <option value="LAMINA CARTON">LAMINA CARTON</option>
                        <option value="CONO">CONO</option>
                    </select>
                </div>
                <div v-else>
                    <jet-label class="tw-font-medium">Selecciona un Material</jet-label>
                    <select v-model="form.Material"  class="InputSelect">
                        <option default >Selecciona un Departamento</option>
                    </select>
                </div>
                <div>
                    <jet-button @click="openModal2" class="BtnNuevo">Nueva Información</jet-button>
                </div>
            </div>

            <div class="tw-overflow-x-auto tw-mx-2">
                <Table id="CostosEmpaques">
                    <template v-slot:TableHeader>
                        <th class="columna">Fecha</th>
                        <th class="columna">NumFactura</th>
                        <th class="columna">Proveedor</th>
                        <th class="columna">Concepto</th>
                        <th class="columna">Moneda</th>
                        <th class="columna">Importe</th>
                        <th class="columna">TipoCambio</th>
                        <th class="columna">Conversion</th>
                        <th class="columna">ImporteKilo</th>
                        <th class="columna">Costo100G</th>
                        <th class="columna">KilosPorBorra</th>
                        <th class="columna">CostoUnitario</th>
                        <th class="columna">Acciones</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila" v-for="dato in Rafia" :key="dato.id">
                            <td class="tw-p-2">{{ dato.Fecha }}</td>
                            <td class="tw-p-2">{{ dato.NumFactura }}</td>
                            <td class="tw-p-2">{{ dato.Proveedor }}</td>
                            <td class="tw-p-2">{{ dato.Concepto }}</td>
                            <td class="tw-p-2">{{ dato.Moneda }}</td>
                            <td class="tw-p-2">{{ dato.Importe }}</td>
                            <td class="tw-p-2">{{ dato.TipoCambio }}</td>
                            <td class="tw-p-2">{{ dato.Conversion }}</td>
                            <td class="tw-p-2">{{ dato.ImporteKilo }}</td>
                            <td class="tw-p-2">{{ dato.Costo100G }}</td>
                            <td class="tw-p-2">{{ dato.KilosPorBorra }}</td>
                            <td class="tw-p-2">{{ dato.CostoUnitario }}</td>
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
                </Table>
            </div>
        </div>

        <modal :show="showModal" @close="chageClose2" :maxWidth="tam">
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
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/4 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Fecha</jet-label>
                                    <jet-input type="date" v-model="form.Fecha"></jet-input>
                                    <small v-if="errors.Fecha" class="validation-alert">{{errors.Fecha}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/4 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Núm Factura</jet-label>
                                    <jet-input type="number" min="1" v-model="form.NumFactura"></jet-input>
                                    <small v-if="errors.NumFactura" class="validation-alert">{{errors.NumFactura}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Proveedor</jet-label>
                                    <jet-input type="text" v-model="form.Proveedor"></jet-input>
                                    <small v-if="errors.Proveedor" class="validation-alert">{{errors.Proveedor}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Concepto</jet-label>
                                    <jet-input type="text" v-model="form.Concepto"></jet-input>
                                    <small v-if="errors.Concepto" class="validation-alert">{{errors.Concepto}}</small>
                                </div>
                            </div>
                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Moneda</jet-label>
                                    <select v-model="form.Moneda"  class="InputSelect">
                                        <option value="MXN">MXN</option>
                                        <option value="USD">USD</option>
                                    </select>
                                    <small v-if="errors.Moneda" class="validation-alert">{{errors.Moneda}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Importe</jet-label>
                                    <jet-input type="text" v-model="form.Importe"></jet-input>
                                    <small v-if="errors.Importe" class="validation-alert">{{errors.Importe}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-if="form.Moneda == 'USD'">
                                    <jet-label><span class="required">*</span>Tipo Cambio</jet-label>
                                    <jet-input type="text" v-model="form.TipoCambio" @change="Conversion"></jet-input>
                                    <small v-if="errors.TipoCambio" class="validation-alert">{{errors.TipoCambio}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-if="form.Moneda == 'USD'">
                                    <jet-label><span class="required">*</span>Importe Final</jet-label>
                                    <jet-input type="text" v-model="form.Conversion" readonly></jet-input>
                                    <small v-if="errors.Conversion" class="validation-alert">{{errors.Conversion}}</small>
                                </div>
                            </div>
                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-if="form.Material == 'RAFIA'">
                                    <jet-label><span class="required">*</span>Rafia Kilogramo</jet-label>
                                    <jet-input type="number" min="1" v-model="form.ImporteKilo"></jet-input>
                                    <small v-if="errors.ImporteKilo" class="validation-alert">{{errors.ImporteKilo}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-else-if="form.Material == 'ETIQUETA TERMICA'">
                                    <jet-label><span class="required">*</span>Etiqueta Térmica</jet-label>
                                    <jet-input type="number" min="1" v-model="form.Etiqueta"></jet-input>
                                    <small v-if="errors.Etiqueta" class="validation-alert">{{errors.Etiqueta}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-else-if="form.Material == 'BOLSA POLIPAPEL'">
                                    <jet-label><span class="required">*</span>Bolsa Polipapel</jet-label>
                                    <jet-input type="number" min="1" v-model="form.BolsaPolipapel"></jet-input>
                                    <small v-if="errors.BolsaPolipapel" class="validation-alert">{{errors.BolsaPolipapel}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-else-if="form.Material == 'LAMINA CARTON'">
                                    <jet-label><span class="required">*</span>Lámina Cartón</jet-label>
                                    <jet-input type="number" min="1" v-model="form.LaminaCarton"></jet-input>
                                    <small v-if="errors.LaminaCarton" class="validation-alert">{{errors.LaminaCarton}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-else-if="form.Material == 'CONO'">
                                    <jet-label><span class="required">*</span>Cono</jet-label>
                                    <jet-input type="number" min="1" v-model="form.Cono"></jet-input>
                                    <small v-if="errors.Cono" class="validation-alert">{{errors.Cono}}</small>
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
        this.tabla();
    },

    data() {
        return {
            showModal2: false,
            tam: "4xl",
            color: "tw-bg-violet-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            form: {
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
                Base: null,
                Fecha: null,
                NumFactura: null,
                Proveedor: null,
                Concepto: null,
                Importe: null,
                Moneda: null,
                TipoCambio: null,
                Conversion: null,
                ImporteKilo: null,
                Etiqueta: null,
                BolsaPolipapel: null,
                LaminaCarton: null,
                Cono: null,
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
        Rafia: Object,
    },

    methods: {
        reset() {
            this.form = {
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
            };
        },

        SeleccionaBase(){
        },

        //datatable
        tabla() {
            this.$nextTick(() => {
                $("#CostosEmpaques").DataTable({
                language: this.español,
                });
            });
        },

        openModal2() {
            this.chageClose();
            this.editMode = false;
        },

        chageClose2() {
            this.showModal2 = !this.showModal2;
        },

        Conversion(){
            var Conversion =  this.form.Importe * this.form.TipoCambio;
            this.form.Convesion = parseFloat(Conversion).toFixed(2);
        },

        save(data) {
            console.log(data);
            this.$inertia.post("/Contabilidad/CostosEmpaques", data, {
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
    },
};
</script>
