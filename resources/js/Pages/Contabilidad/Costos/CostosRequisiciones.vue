<template>
    <app-layout>
        <!-- ****************************************** TITULO ********************************************* -->
        <section class="tw-uppercase tw-mx-4">
            <Header :class="[color, style]">
                <slot>
                    <h3 class="tw-p-2"><i class="fa-solid fa-dollar-sign tw-ml-3 tw-mr-3"></i>COSTOS REQUISICIONES</h3>
                </slot>
            </Header>
        </section>

        <!-- ********************************************* FILTROS ************************************************* -->
        <section class="tw-my-4 tw-mx-4 lg:tw-flex lg:tw-gap-4 lg:tw-content-center lg:tw-border lg:tw-p-2 lg:tw-mb-4">
            <div class="lg:tw-flex lg:tw-gap-4">
                <div>
                    <jet-label class="tw-text-center">AÑO</jet-label>
                    <select class="InputSelect" v-model="params.Year">
                        <option value="0"> TODOS --</option>
                        <option value="2021"> 2021 --</option>
                        <option value="2022"> 2022 -- </option>
                    </select>
                </div>

                <div>
                    <jet-label class="tw-text-center">MES</jet-label>
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

                <div>
                    <jet-label class="tw-text-center">Departamento</jet-label>
                    <select class="InputSelect" v-model="params.Dpto">
                        <option v-for="Dpto in Departamento" :key="Dpto.id" :value="Dpto.id"> {{ Dpto.Nombre }}</option>
                    </select>
                </div>
            </div>
            <div class="lg:tw-mt-4">
                <jet-button v-if="loading == true" @click="Filtros" class="BtnFiltros">
                    <span class="tw-animate-ping tw-relative tw-inline-flex tw-rounded-full tw-h-2 tw-w-2 tw-mr-2 tw-bg-coolGray-100"></span>
                    <p class="tw-animate-pulse">Cargando </p>
                </jet-button>
                <jet-button v-else @click="Filtros" class="BtnFiltros"> <i class="fas fa-filter tw-mr-1"></i> Aplica Filtros
                </jet-button>
            </div>
        </section>

LUIS RAMIREZ JUAREZ     	683
CRISTIAN JESUS ORTIZ FUENTES 	1007
JUAN JESUS CEREZO DIAZ 	935
JOSE DANIEL CRUZ HERNANDEZ	684
OCTAVIO ROBLES PACHECO 	1082
JOSÉ DANIEL OLMEDO ROJAS 	1079
OSCAR ARTURO SALDAÑA SANCHEZ	1205
JAIME HERNANDEZ HERNANDEZ	1120
DAVID ANTONIO VERA GONZALEZ	1208
CRISTIAN BERNALDINO HERNANDEZ	1226
JOSE LUIS ALVARADO LOPEZ 	938
DAVID HERRERA CORTEZ 	865
VACANTE	VACANTE
IGNACIO SANCHEZ HERNANDEZ 	1074
GREGORIO GUZMAN MARTINEZ 	773
JOSE DE JESUS MINOR SALAS 	898
FERMIN TORRES REYES	932
JONATHAN SAENZ HERNANDEZ	1352
FERNANDO GONZALEZ DOMINGUEZ	1156
HECTOR GARCIA CASTRO 	1280
VACANTE	VACANTE
MIGUEL ANTONIO SANCHEZ PEREZ	1357
GERARDO OMAR PEREZ CEREZO 	1341
FRANCISCO TORRES FLORES	1231
ARTURO ROJAS ROJAS 	163
JORGE CRUZ CERVANTES	393
ADRIAN ASAEL HERNANDEZ SANCHEZ	1117
EDUARDO SALGADO CHEPE 	1094
HUGO ARROYO TORRES	1114
RICARDO ROSALES ROSETE 	1036
JOEL RAMIREZ SALAZAR	167
IVAN MENA PEREZ	756
IVAN MENDEZ HERNANDEZ 	972
VACANTE	VACANTE
JORGE URIEL AGUILAR CARO   	774
JORGE PEREZ GONZALEZ	1000
BRYAN EDUARDO LEON LOPEZ	1209
NERI ROJAS SALOMON MARCOS	1369
JUAN MANUEL CARRILLO VIVAS
JESUS  MUÑOZ XICOTENCATL     	861
FERNANDO YONATAN ZAMORA HERNANDEZ	1228
VICTOR ESTEBAN HERNANDEZ 	1013
JOSÉ ISRAEL RAMOS JUAREZ
JORGE ALI CABALLERO 	1269
JORGE IBAÑEZ AGUILAR
OSCAR ALVARADO TEPOXTECATL 	954
VACANTE	VACANTE
FRANCISCO SOSA CASTAÑEDA	1264
JOSE EDUARDO NERI ROJAS     	821
JULIO CESAR MUÑOZ MUÑOZ   	854
DAVID CAMACHO GARCÍA	1016
RICARDO SOLIS LOPEZ	1037
FRANCISCO ZAMORA RODRIGUEZ     	868
JUAN CARLOS GARCÍA RAMOS 	1015
ALBERTO HERNANDEZ RAMIREZ	571
ARMANDO PALETA CARVENTE 	903
RAYMUNDO PEREZ VERGARA 	1014
ALEJANDRO HUERTA MARTINEZ	1115
JOSÉ FRANCISCO DE LUNA	1123
RAÚL BONILLA MENDOZA	897
ISRAEL MUÑOZ SAUCEDO	1223
JUAN CARLOS BONILLA DE LA CRUZ	1001
CARMELO VALENCIA ROJAS	1130
MIGUEL CARRILLO GUEVARA	1151
JONATHAN HERNANDEZ CUEVAS	1202
VACANTE	VACANTE
RIGOBERTO ANGEL CARRERA	1282
ALBERTO HERNANDEZ MICHIHUA 	1334
LUIS GUSTAVO PEREZ ROJAS 	1372
ISRAEL HUITZIL ORTEGA	1305
VACANTE	VACANTE
VICTOR REYES FLORES	466
LUIS ENRIQUE RODRIGUEZ CABRERA 	1229

    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Welcome from "@/Jetstream/Welcome";
import Header from "@/Components/Header";
import Accions from "@/Components/Accions";
import Table from "@/Components/TableGreen";
import JetButton from "@/Components/Button";
import JetTextArea from "@/Components/Textarea";
import JetCancelButton from "@/Components/CancelButton";
import Modal from "@/Jetstream/Modal";
import Pagination from "@/Components/pagination";
import JetInput from "@/Components/Input";
import JetLabel from '@/Jetstream/Label';
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
            tam: "4xl",
            color: "tw-bg-violet-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            loading: false,
            params: {
                Year: 0,
                Month: 0,
            },
        };
    },

    components: {
        AppLayout,
        Welcome,
        Header,
        Accions,
        Table,
        Alert,
        JetButton,
        JetCancelButton,
        Modal,
        Pagination,
        JetInput,
        JetLabel,
        JetSelect,
        JetTextArea,
    },

    props: {
        Session: Object,
        errors: Object,
        Departamentos: Object,
        PreciosRequisiciones: Object,
    },

    mounted() {
    },

    methods: {
        Filtros(){
            console.log(this.params);
        }
    },

    computed:{
        Departamento: function () {
            const Areas = []; //Declaracion del nuevo arreglo
                this.Departamentos.forEach(element => {
                    element.sub__departamentos.forEach( el => {
                        Areas.push(el)
                    })
                });
            return Areas;
        },

    }
};
</script>
