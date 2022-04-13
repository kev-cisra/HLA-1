<template>
  <app-layout>
    <div class="uppercase tw-mx-4">
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-calendar-check tw-ml-3 tw-mr-3"></i>
                    Autoriza Cancelacion de Vacaciones
                </h3>
            </slot>
        </Header>

        <div class="tw-mt-8">
            <div class="tw-overflow-x-auto tw-mx-4 tw-mt-4">
                <Table id="vacaciones">
                    <template v-slot:TableHeader>
                        <th class="columna">Núm. Empleado</th>
                        <th class="columna">Empresa</th>
                        <th class="columna">Nombre</th>
                        <th class="columna">Paterno</th>
                        <th class="columna">Materno</th>
                        <th class="columna">Puesto</th>
                        <th class="columna">Fecha Inicio</th>
                        <th class="columna">Fecha Fin</th>
                        <th class="columna">Dias Sol</th>
                        <th class="columna">Motivo Cancelacion</th>
                        <th class="columna">Estatus</th>
                        <th class="columna">Acciones</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila" v-for="datos in Vacaciones" :key="datos.id">
                            <td class="tw-p-2">{{ datos.IdEmp }}</td>
                            <td class="tw-p-2">{{ datos.Empresa }}</td>
                            <td class="tw-p-2">{{ datos.Nombre }}</td>
                            <td class="tw-p-2">{{ datos.ApPat }}</td>
                            <td class="tw-p-2">{{ datos.ApMat }}</td>
                            <td class="tw-p-2">{{ datos.Puesto }}</td>
                            <td class="tw-p-2">{{ datos.FechaInicio }}</td>
                            <td class="tw-p-2">{{ datos.FechaFin }}</td>
                            <td class="tw-p-2">{{ datos.DiasTomados }}</td>
                            <td class="tw-p-2">{{ datos.MotivoCancelacion }}</td>
                            <td class="tw-text-center">
                                <div v-if="datos.Estatus == 0">
                                    <span tooltip="Vacaciones Solicitadas" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-blueGray-400 tw-rounded-full">SOLICITADA</span>
                                    </span>
                                </div>
                                <div v-if="datos.Estatus == 1">
                                    <span tooltip="Vacaciones Aprovadas" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-green-600 tw-rounded-full">AUTORIZADA</span>
                                    </span>
                                </div>
                                <div v-else-if="datos.Estatus == 2">
                                    <span tooltip="Solicitud Rechazada" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-yellow-600 tw-rounded-full">RECHAZADA</span>
                                    </span>
                                </div>
                                <div v-else-if="datos.Estatus == 3">
                                    <span tooltip="En espera de devolucion de días por RH" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-orange-600 tw-rounded-full">EN CANCELACION</span>
                                    </span>
                                </div>
                                <div v-else-if="datos.Estatus == 4">
                                    <span tooltip="Vacaciones Canceladas (Días devueltos)" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-red-600 tw-rounded-full">CANCELADA</span>
                                    </span>
                                </div>
                                <div v-else-if="datos.Estatus == 5">
                                    <span tooltip="Peticion de vacaciones canceladas" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-red-600 tw-rounded-full">PETICION CANCELADA</span>
                                    </span>
                                </div>
                            </td>
                            <td class="fila">
                                <div class="columnaIconos" v-if="datos.Estatus == 0">
                                    <div class="iconoTeal" @click="AutorizaVacaciones(dato)">
                                        <span tooltip="Autoriza Vacaciones" flow="left">
                                            <i class="fa-solid fa-check"></i>
                                        </span>
                                    </div>
                                    <div class="iconoDelete" @click="RechazaVacaciones(dato)">
                                        <span tooltip="Rechaza Vacaciones" flow="left">
                                            <i class="fa-solid fa-ban"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="columnaIconos" v-else-if="datos.Estatus == 3">
                                    <div class="iconoDetails" @click="AutorizaCancelacion(datos)" >
                                        <span tooltip="Autoriza la cancelacion" flow="left">
                                            <i class="fas fa-user-check"></i>
                                        </span>
                                    </div>
                                    <div class="iconoDetails" @click="RechazaCancelacion(datos, 2)">
                                        <span tooltip="Rechaza la cancelacion" flow="left">
                                            <i class="fas fa-times-circle"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="columnaIconos" v-else-if="datos.Estatus == 5">
                                    <span tooltip="Rechaza la cancelacion" flow="left">
                                        <i class="fa-solid fa-ban"></i>
                                    </span>
                                </div>
                                <div class="columnaIconos" v-else>
                                    <div class="iconoDetails">
                                        <span tooltip="Vacaciones" flow="left">
                                            <i class="fas fa-thumbs-up"></i>
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

  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Welcome from "@/Jetstream/Welcome";
import Header from "@/Components/Header";
import Accions from "@/Components/Accions";
import TableBlue from "@/Components/TableGreen";
import Table from "@/Components/Table";
import JetButton from "@/Components/Button";
import JetTextArea from "@/Components/Textarea";
import JetCancelButton from "@/Components/CancelButton";
import Modal from "@/Jetstream/Modal";
import Pagination from "@/Components/pagination";
import JetInput from "@/Components/Input";
import JetSelect from "@/Components/Select";
import Alert from "@/Components/Alert";
//imports de datatables
import datatable from "datatables.net-bs5";
import $ from "jquery";
import moment from 'moment';
import 'moment/locale/es';

export default {
    data() {
        return {
            ModalCancelacion: false,
            color: "tw-bg-green-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            now: moment().format("YYYY-MM-DD"),
            tam: "2xl",
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
        TableBlue,
        Table,
        Alert,
        JetButton,
        JetCancelButton,
        Modal,
        Pagination,
        JetInput,
        JetSelect,
        JetTextArea,
    },

    props: {
        Session: Object,
        errors: Object,
        Vacaciones: Object,
    },

    methods: {
        //datatable
        tabla() {
        this.$nextTick(() => {
            $("#vacaciones").DataTable({
            language: this.español,
            });
        });
        },

        //consulta para generar datos de la tabla
        verTabla(event) {
            $('#vacaciones').DataTable().clear();
            $('#vacaciones').DataTable().destroy();
            this.$inertia.get(
                "/RecursosHumanos/PerfilesUsuarios",
                { busca: event.target.value },
                {
                onSuccess: () => {
                    this.tabla();
                },
                }
            );
        },

        AutorizaVacaciones(data){
            data._method = "PUT";
            data.metodo = 1;
            this.$inertia.post("/RecursosHumanos/CancelaVacaciones/" + data.id, data, {
                onSuccess: () => {
                    this.alertSucces();
                },
            });
        },

        AutorizaCancelacion(data) {
            Swal.fire({
            title: 'Confirma esta Acción',
            text: "No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Regresa los dias de vacaciones tomados',
            cancelButtonText: 'No, Cancela!',
            }).then((result) => {
                if (result.isConfirmed) {
                    data._method = "PUT";
                    data.metodo = 2;
                    this.$inertia.post("/RecursosHumanos/CancelaVacaciones/" + data.id, data, {
                        onSuccess: () => {
                            this.alertSucces();
                        },
                    });
                }
            })
        },

        RechazaCancelacion(data, metodo){
            Swal.fire({
                title: 'Confirma esta Acción',
                text: "No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Rechaza la petición',
                cancelButtonText: 'No, Cancela!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        data._method = "PUT";
                        data.metodo = 3;
                        this.$inertia.post("/RecursosHumanos/CancelaVacaciones/" + data.id, data, {
                            onSuccess: () => {
                                this.alertSucces();
                            },
                        });
                    }
                })
        }

    },
};
</script>
