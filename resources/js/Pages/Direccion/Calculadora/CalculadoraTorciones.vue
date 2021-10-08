<template>
  <app-layout>
    <div class="uppercase tw-mx-4">
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-user tw-ml-3 tw-mr-3"></i>
                        Calculadora Torciones
                </h3>
            </slot>
        </Header>

        <div class="tw-overflow-x-auto tw-mx-16 md:tw-mx-4 tw-my-8 tw-text-center tw-bg-blueGray-300 tw-font-bold tw-rounded-sm tw-p-2 tw-shadow md:tw-flex">
            <div class="tw-px-3 tw-mb-6 md:tw-w-1/4 md:tw-mb-0">
                <jet-label>TITULO</jet-label>
                <jet-input type="text" v-model="NI"></jet-input>
            </div>
            <div class="tw-px-3 tw-mb-6 md:tw-w-1/4 md:tw-mb-0">
                <jet-label>TORCIONES POR METRO</jet-label>
                <jet-input type="text" v-model="TPI"></jet-input>
            </div>
            <div class="tw-px-3 tw-mb-6 md:tw-w-1/4 md:tw-mb-0">
                <jet-label>TORCIONES POR PULGADA</jet-label>
                <jet-input type="text" v-model="TPP"></jet-input>
            </div>
            <div class="tw-px-3 tw-mb-6 md:tw-w-1/4 md:tw-mb-0">
                <jet-label>COEFICIENTE INGLES</jet-label>
                <jet-input type="text" v-model="CIC"></jet-input>
            </div>
            <div class="tw-px-3 tw-mb-6 md:tw-w-1/4 md:tw-mb-0">
                <jet-label>COEFICIENTE METRICO</jet-label>
                <jet-input type="text" v-model="CMC"></jet-input>
            </div>
            <div class="tw-gap-2 tw-flex tw-flex-column md:tw-flex-row md:tw-gap-4 tw-items-center">
                <div class="tw-inline-block tw-align-middle">
                    <jet-button type="button" @click="Calcular">Calular</jet-button>
                </div>
                <div class="tw-inline-block tw-align-middle">
                    <jet-button type="button" @click="Limpiar">Limpiar</jet-button>
                </div>
            </div>

        </div>

<!--         <div class="tw-mt-8">
            <div class="tw-overflow-x-auto tw-mx-16">
                <Table id="calculadora">
                    <template v-slot:TableHeader>
                        <th class="columna">TITULO</th>
                        <th class="columna">TORCIONES POR METRO</th>
                        <th class="columna">TORCIONES POR PULGADA</th>
                        <th class="columna">COEFICIENTE INGLES </th>
                        <th class="columna">COEFICIENTE METRICO </th>
                        <th class="columna">ACCIONES</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila">
                            <td class="tw-p-2"> <jet-input type="text" v-model="NI"></jet-input> </td>
                            <td class="tw-p-2"> <jet-input type="text" v-model="TPI"></jet-input> </td>
                            <td class="tw-p-2"> <jet-input type="text" v-model="TPP"></jet-input> </td>
                            <td class="tw-p-2"> <jet-input type="text" v-model="CIC"></jet-input> </td>
                            <td class="tw-p-2"> <jet-input type="text" v-model="CMC"></jet-input> </td>
                            <td class="fila">
                                <div class="columnaIconos">
                                    <div class="tw-flex tw-gap-4">
                                        <jet-button type="button" @click="Calcular">Calular</jet-button>
                                        <jet-button type="button" @click="Limpiar">Limpiar</jet-button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>
                </Table>
            </div>
        </div> -->

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
import JetInput from "@/Components/Input";
import JetSelect from "@/Components/Select";

import moment from 'moment';
import 'moment/locale/es';

export default {
    mounted() {
    },

    data() {
        return {
            color: "tw-bg-cyan-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            IdUser: this.Session.id,
            IdEmp: this.Session.IdEmp,
            NI: null,
            TPI: null,
            TPP: null,
            CIC: null,
            CIP: null,
            CMC: null,
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
        JetInput,
        JetSelect,
    },

    props: {
        Session: Object,
    },

    methods: {

        Limpiar(){
            this.Ni = '';
            this.TPI = '';
            this.TPP = '';
            this.CIC = '';
            this.CIP = '';
            this.CMC = '';
        },

        Calcular(){

            if(this.NI != '' && this.TPP != ''){
                //Coeficiente Ingles
                //Coeficiente de torcion = TorcionesPorPulgada(TPP)/raiz(NumeroIngles(Titulo));
                console.log('Coeficiente Ingles');
                this.CIC = Math.round(this.TPP / Math.sqrt(this.NI), 2);
                this.TPI = Math.round((39.37 * this.TPP), 2); //Torciones por metro
                this.CMC = Math.round( (this.CIC / 0.033), 2 ); //Coeficiente Metros

            }else if(this.NI != '' && this.CIC != ''){
                console.log('Torciones Por pulgada');
                //Torciones Por pulgada
                //TorcionesPorPulgada = Coefici9enteTorcion X raiz(NumeroIngles (Titulo))
                this.TPP = Math.round( this.CIC * Math.sqrt(this.NI) );
                this.TPI = Math.round(39.37*this.TPP, 2); //Conversion a metros
                this.CMC = Math.round( this.CIC / 0.033 ); //Coeficiente Metros

            }else if(this.NI != '' && this.CIP != ''){
                console.log('Torciones Por pulgada');
                //Torciones Por pulgada
                //TorcionesPorPulgada = Coefici9enteTorcion X raiz(NumeroIngles (Titulo))
                this.TPP = Math.round( this.CIP * Math.sqrt($this.NI) );
                this.TPI = Math.round(39.37*this.TPP, 2); //Conversion a metros
                this.CMP = Math.round( this.CIP / 0.033 ); //Coeficiente Metros
            }

        }
    },
};
</script>
