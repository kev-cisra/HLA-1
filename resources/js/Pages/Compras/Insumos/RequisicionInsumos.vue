<template>
    <app-layout>
        <section class="uppercase tw-mx-4">
            <Header :class="[color, style]">
                <slot>
                    <h3 class="tw-p-2">
                        <i class="fas fa-user tw-ml-3 tw-mr-3"></i>PEDIDO DE INSUMOS
                    </h3>
                </slot>
            </Header>
        </section>
        <!-- ******************************* FILTROS ********************************************* -->
        <section class="tw-flex tw-justify-between tw-content-center tw-border tw-p-2 tw-my-8 tw-mx-2 md:tw-mx-10">
            <div>
                <jet-button @click="openModal" class="BtnNuevo">NUEVO PEDIDO</jet-button>
            </div>
        </section>
        <!-- ********************************* TABLAS ********************************************* -->
        <section class="tw-mx-2 md:tw-mx-10">
            <Table id="Insumos">
                <template v-slot:TableHeader>
                    <th class="columna">Folio</th>
                    <th class="columna">Fecha</th>
                    <th class="columna">Solicitante</th>
                    <th class="columna">Departamento</th>
                    <th class="columna">Lista Insumos</th>
                    <th class="columna">Estatus</th>
                    <th class="columna">ACCIONES</th>
                </template>

                <template v-slot:TableFooter>
                    <tr class="fila" v-for="data in RequisicionesInsumos" :key="data.id">
                        <td>RI-{{data.Folio}}</td>
                        <td>{{data.Fecha}}</td>
                        <td>{{data.perfil.Nombre}} {{data.perfil.ApPat}} {{data.perfil.ApMat}}</td>
                        <td>{{data.departamento.Nombre}}</td>
                        <td>
                            <p v-for="art in data.articulos" :key="art.id">
                                -{{art.Cantidad }} {{art.insumo.Clave }} {{art.insumo.Insumo }} {{art.insumo.Unidad }}
                            </p>
                        </td>
                        <td>
                            <div class="FlexCenter">
                                <div v-if="data.Estatus == 0">
                                    <span tooltip="Solicitud Rechazada" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-rose-400 tw-rounded-full">RECHAZADO</span>
                                    </span>
                                </div>
                                <div v-if="data.Estatus == 1">
                                    <span tooltip="Pendiente por Confirmar" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-blueGray-400 tw-rounded-full">REGISTRADO</span>
                                    </span>
                                </div>
                                <div v-if="data.Estatus == 2">
                                    <span tooltip="Material Solicitado" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-emerald-500 tw-rounded-full">SOLICITADA</span>
                                    </span>
                                </div>
                                <div v-if="data.Estatus == 3">
                                    <span tooltip="Articulos pendientes por entregar" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-orange-500 tw-rounded-full">PARCIAL</span>
                                    </span>
                                </div>
                                <div v-if="data.Estatus == 4">
                                    <span tooltip="Solicitud entregada" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-violet-500 tw-rounded-full">ENTREGADO</span>
                                    </span>
                                </div>
                                <div v-if="data.Estatus == 5">
                                    <span tooltip="Material Adquirido" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-purple-500 tw-rounded-full">STOCK</span>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="FlexCenter">
                                <div class="iconoEdit" @click="Confirma(data)" v-if="data.Estatus == 1">
                                    <span tooltip="Enviar Solicitud a Compra" flow="left">
                                        <i class="fa-solid fa-check"></i>
                                    </span>
                                </div>
                                <div class="iconoDetails" @click="view(data)" >
                                    <span tooltip="Visualiza Partidas" >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
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
        <!-- --------------- Modal para guardado de datos ------------ -->
        <modal :show="showModal" @close="chageClose" :maxWidth="tam">
            <div class="ModalHeader">
                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>SOLICITUD DE INSUMOS</h3>
            </div>

            <div class="ModalForm">
                <div class="FormSection">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                        <jet-label><span class="required">*</span>DEPARTAMENTO</jet-label>
                        <select class="InputSelect" @change="loadInsumos($event)" v-model="form.Departamento_id">
                            <option v-for="dpto in Departamentos" :key="dpto.id" :value="dpto.id" > {{ dpto.Nombre }}</option>
                        </select>
                    </div>
                </div>
                <div class="FormSection">
                    <div class="tw-px-3">
                        <input type="button" @click="addRow()" value="Añadir Partida" class="BtnCancel">
                    </div>
                </div>
                <div class="FormSection" v-for="(form) in form.Partida" :key="form.id">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                        <jet-label><span class="required">*</span>CANTIDAD</jet-label>
                        <jet-input type="number" min="1" v-model="form.Cantidad"></jet-input>
                        <!-- <small v-if="errors.Cantidad" class="validation-alert">{{errors.Cantidad}}</small> -->
                    </div>
                    <div class="tw-px-3 tw-mb-6 md:tw-w-8/12 md:tw-mb-0">
                        <jet-label><span class="required">*</span>INSUMOS</jet-label>
                        <Select2 v-model="form.insumo_id" class="InputSelect" :settings="{width: '100%',allowClear: true}" element="background: '#e5e7eb'" :options="BuscaInsumo" />
                    </div>
                    <div class="tw-mt-6 md:tw-w-2/12 md:tw-mb-0">
                        <button type="button" class="btn btn-primary" @click="removeRow(index)">Quitar</button>
                    </div>
                </div>
            </div>

            <div class="ModalFooter">
                <jet-button type="button" @click="save(form)" v-show="!editMode" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Guardar</jet-button>
                <jet-button type="button" @click="update(form)" v-show="editMode" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Actualizar</jet-button>
                <jet-CancelButton @click="chageClose">Cerrar</jet-CancelButton>
            </div>
        </modal>

        <!-- --------------- Modal visualizacion partidas ------------ -->
        <modal :show="showArticulos" @close="chageArticulos" :maxWidth="tam">
            <div class="ModalHeader">
                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>LISTA DE INSUMOS RI-{{form.Folio}}</h3>
            </div>

            <div class="ModalForm">
                <Table>
                    <template v-slot:TableHeader>
                        <th class="columna">Folio</th>
                        <th class="columna">Fecha</th>
                        <th class="columna">Solicitante</th>
                        <th class="columna">Departamento</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila">
                            <td class="tw-text-center tw-font-black">RI-{{form.Folio}}</td>
                            <td class="tw-text-center">{{form.Fecha}}</td>
                            <td class="tw-text-center">{{form.Perfil}}</td>
                            <td class="tw-text-center">{{form.Departamento}}</td>
                        </tr>
                    </template>
                </Table>

                <Table>
                    <template v-slot:TableHeader>
                        <th class="columna">Cantidad</th>
                        <th class="columna">Clave</th>
                        <th class="columna">Insumo</th>
                        <th class="columna">Estatus</th>
                        <th class="columna">Acciones</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila" v-for="data in ArticulosReq" :key="data.id">
                            <td class="tw-text-center">{{data.Cantidad}}</td>
                            <td class="tw-text-center">{{data.insumo.Clave}}</td>
                            <td class="tw-text-center">{{data.insumo.Nombre}}</td>
                            <td>
                                <div class="FlexCenter">
                                    <div v-if="data.Estatus == 2">
                                        <span tooltip="Material Solicitado" flow="left">
                                            <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-emerald-500 tw-rounded-full">SOLICITADO</span>
                                        </span>
                                    </div>
                                    <div v-if="data.Estatus == 3">
                                        <span tooltip="Material Entregado" flow="left">
                                            <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-cyan-500 tw-rounded-full">ENTREGADO</span>
                                        </span>
                                    </div>
                                    <div v-if="data.Estatus == 4">
                                        <span tooltip="Autorizado" flow="left">
                                            <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-violet-500 tw-rounded-full">APROBADO</span>
                                        </span>
                                    </div>
                                    <div v-if="data.Estatus == 5">
                                        <span tooltip="Material Adquirido" flow="left">
                                            <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-fuchsia-500 tw-rounded-full">STOCK</span>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="FlexCenter">
                                    <div class="iconoEdit" @click="Confirma(data)">
                                        <span tooltip="Entrega Material" flow="left">
                                            <i class="fa-solid fa-check"></i>
                                        </span>
                                    </div>
                                    <div class="iconoPurple" @click="EntregaParcial(data)">
                                        <span tooltip="Entrega Material Parcial" flow="left">
                                            <i class="fa-solid fa-box-open"></i>
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>
                </Table>

                <Table v-if="Parcialidad == true">
                    <template v-slot:TableHeader>
                        <th class="columna">Cantidad Solicitada</th>
                        <th class="columna">Insumo</th>
                        <th class="columna">Cantidad Disponible</th>
                        <th class="columna">Cantidad Faltante</th>
                        <th class="columna">Acciones</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila">
                            <td class="tw-text-center">{{ Parcial.Cantidad }}</td>
                            <td class="tw-text-center">{{ Parcial.Insumo }}</td>
                            <td class="tw-text-center"><jet-input type="text" v-model="Parcial.CantidadParcial"></jet-input></td>
                            <td class="tw-text-center">{{ Calcula }}</td>
                            <td>
                                <div class="FlexCenter">
                                    <div class="iconoGreen" @click="GeneraParcialidad(Parcial)">
                                        <span tooltip="Guarda Parcialidad" flow="left">
                                            <i class="fa-regular fa-floppy-disk"></i>
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>
                </Table>
            </div>

            <div class="ModalFooter">
                <jet-CancelButton @click="chageArticulos">Cerrar</jet-CancelButton>
            </div>
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
            tam: "2xl",
            color: "tw-bg-teal-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            showRequisicion: false,
            form: {
                IdUser: this.Session.id,
                Req_id: '',
                Fecha: moment().format("YYYY-MM-DD"),
                Estatus: '',
                Departamento_id: '',
                Partida: [{
                    Art_id: '',
                    Cantidad: '',
                    insumo_id: '',
                }],
            },
            InsumosDpto: [], //Arreglo dinamico
            params: {
            },
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
        JetLabel,
        JetSelect,
        Select2,
    },

    props: {
        Session: Object,
        Departamentos: Object,
        Insumos: Object,
        RequisicionesInsumos: Object,
        RequisicionInsumo: Object,
    },

    methods: {
        reset() {
            this.form = {
                IdUser: this.Session.id,
                Req_id: '',
                Fecha: moment().format("YYYY-MM-DD"),
                Estatus: '',
                Departamento_id: '',
                Partida: [{
                    Art_id: '',
                    Cantidad: '',
                    insumo_id: '',
                }],
            };
        },

       //Generacion de Tabla con Datatables
        tabla(){
            this.$nextTick(() => {
                $("#Insumos").DataTable({
                    destroy: true,
                    stateSave: true,
                    language: this.español,
                    paging: true,
                    pageLength : 20,
                    scrollX: true,
                    scrollY:  '40vh',
                    order: [0, 'desc'],
                    columnDefs: [
                        { "width": "5%", "targets": [0,1,5] },
                        { "width": "10%", "targets": [6] },
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

        loadInsumos(event) { //Disparador que carga Maquinas
            this.InsumosDpto = [];
            //Funcion para extraer de un controlador externo las maquinas pertenecientes al Departamento
            axios.get('/Compras/CatalogoInsumos',{
                params: {
                    Insumo: event.target.value
                }
            })
            .then(response => this.InsumosDpto = response.data.Insumos)
            .catch(error => console.log(error))
        },

        addRow: function () { //Agregar Campos dinamicamente
            //Funcion para añadir inputs dinamicos
            this.form.Partida.push({Part: ""});
        },

        removeRow: function (row) { //Quitar Campos dinamicamente
            //Quitar del arreglo los inputs dinamicos
            this.form.Partida.splice(row,1);
        },

        save(data){
            console.log(data);
            this.$inertia.post("/Compras/RequisicionesInsumos", data, {
                onSuccess: () => {
                    this.reset(),
                    this.chageClose(),
                    this.alertSucces();
                },
            });
        },

        Confirma(data){
            data.Metodo = 1;
            data._method = "PUT";
            this.$inertia.post("/Compras/RequisicionesInsumos/" + data.id, data, {
                onSuccess: () => {
                    this.alertSucces();
                },
            });
        },

        chageRequisicion(){
            this.showRequisicion  = !this.showRequisicion;
        },

        view(data){
            this.$inertia.get('/Compras/RequisicionesInsumos', { Req: data.id }, { //envio de variables por url
                onSuccess: () => {
                    this.chageClose();
                    this.editMode = true;
                    this.form.Req_id = this.RequisicionInsumo.id;
                    this.form.Fecha = this.RequisicionInsumo.Fecha;
                    this.form.Departamento_id = this.RequisicionInsumo.Departamento_id;

                    axios.get('/Compras/CatalogoInsumos',{
                        params: {
                            Insumo: this.form.Departamento_id
                        }
                    })
                    .then(response => this.InsumosDpto = response.data.Insumos)
                    .catch(error => console.log(error))

                    this.form.Partida = []; //Vacio arreglo de inputs

                    this.RequisicionInsumo.articulos.forEach(Part => { //Generacion de inputs apartir del objeto a recorrer
                        this.form.Partida.push({ //Añado mas campos a visualizar
                            Art_id: Part.id,
                            Cantidad: Part.Cantidad,
                            insumo_id: Part.insumo_id,
                        })
                    })
            }, preserveState: true })
        },

        update(data) {
            data.Metodo = 2;
            data._method = "PUT";
            this.$inertia.post("/Compras/RequisicionesInsumos/" + data.id, data, {
                onSuccess: () => {
                    this.editMode = false;
                    this.reset(),
                    this.chageClose(),
                    this.alertSucces();
                },
            });
        },
    },

    computed:{
        //Funcion de buscador
        BuscaInsumo: function () {
            const Insumos = [];
            this.InsumosDpto.forEach(element => {
                Insumos.push({id: element.id, text: element.Nombre +' - '+element.Cantidad+' '+element.Unidad})
            });
            return Insumos;
        },
    }
};
</script>
