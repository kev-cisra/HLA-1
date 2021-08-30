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
                        <th class="columna">Autorizar</th>
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
                            <td class="tw-p-2 tw-flex tw-justify-center">
                                <div class="iconoDetails" @click="AutorizaCancelacion(datos)">
                                    <span tooltip="Autoriza la cancelacion" flow="left">
                                        <i class="fas fa-user-check"></i>
                                    </span>
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
        alertWarningDias() {
            const Toast = Swal.mixin({
                toast: true,
                position: "center",
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.stopTimer);
                toast.addEventListener("mouseleave", Swal.resumeTimer);
                },
            });

            Toast.fire({
                icon: "warning",
                title: "Dias de Vacaciones disponibles Excedidos",
                // background: '#FDBA74',
            });
        },

        reset() {
        },

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

        AutorizaCancelacion(data) {
            console.log(data);

            console.log(data.DiasTomados);

            data._method = "PUT";
            this.$inertia.post("/RecursosHumanos/CancelaVacaciones/" + data.id, data, {
                onSuccess: () => {
                    this.alertSucces();
                },
            });
        },


    },
};
</script>
