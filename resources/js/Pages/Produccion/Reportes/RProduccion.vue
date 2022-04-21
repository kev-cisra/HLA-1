<template>
    <app-layout>
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-folder-open"></i>
                        Reporte de  Producción
                </h3>
            </slot>
        </Header>
        <Accions>
            <template  v-slot:SelectB v-if="usuario.dep_pers.length != 1">
                <div class="sm:tw-flex tw-gap-3">
                    <select class="InputSelect sm:tw-w-full" v-model="S_Area">
                        <option value="" disabled>Selecciona un departamento</option>
                        <option v-for="o in opc" :key="o.value" :value="o.value">{{o.text}}</option>
                    </select>
                </div>
            </template>
            <template v-slot:BtnNuevo v-if="S_Area">
                <div class="md:tw-flex tw-gap-3">
                    <!-- boton de carga masiva -->
                    <div class="tw-m-3">
                        <button class="btn btn-primary tw-w-full" @click="openModalC">Carga masiva</button>
                    </div>
                    <!-- Boton de filtros -->
                    <div class="tw-m-3">
                        <button class="btn btn-primary tw-w-full" data-bs-toggle="collapse" data-bs-target="#filtro" aria-expanded="false" aria-controls="filtro"><i class="fas fa-filter"> </i> Filtros</button>
                    </div>
                    <div class="tw-m-3">
                        <button class="btn tw-bg-green-600 hover:tw-bg-green-700 tw-text-white hover:tw-text-white tw-w-full" data-bs-toggle="collapse" data-bs-target="#grafica" aria-expanded="false" aria-controls="grafica"><i class="fas fa-chart-pie"></i> Graficas</button>
                    </div>
                </div>
            </template>
        </Accions>

        <!------------------------------------ Muestra las opciones de filtros ------------------------------------------->
        <div class="collapse tw-p-6 tw-border tw-border-8 tw-border-blue-400 tw-bg-blueGray-500 tw-rounded-3xl tw-shadow-xl tw-absolute tw-z-10 tw-w-full lg:tw-left-0 lg:tw-w-8/12" id="filtro">
            <div class="tw-mb-6 lg:tw-flex lg:tw-flex-col tw-w-full">
                <div class="tw-mb-6 lg:tw-flex">
                    <!-- Tipo de reporte -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-mb-0">
                        <jet-label class="tw-text-white"><span class="required">*</span>Tipo de reporte</jet-label>
                        <div class="tw-flex tw-gap-5">
                            <div>
                                <input type="radio" id="uno" value="1" v-model="FoFiltro.TipRepo" @click="arrProdu()">
                                <label for="uno" class="tw-text-white"> Produccion</label>
                            </div>
                            <div>
                                <input type="radio" id="dos" value="2" v-model="FoFiltro.TipRepo" @click="arrParo()">
                                <label for="dos" class="tw-text-white"> Paros</label>
                            </div>
                        </div>
                    </div>
                    <!-- calculos -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-mb-0" v-if="FoFiltro.TipRepo == 1 & FoFiltro.iniDia != null & FoFiltro.rango == 1" >
                        <jet-label class="tw-text-white">Boton para Calcular Operaciones</jet-label>
                        <BotonCarga :verBot="vCal" :iconoV="'fas fa-calculator'" :textoV="'Calcular'" :textoOC="'Calculando...'" :class="'btn-success'" @click="calcula(form)"></BotonCarga>
                    </div>

                    <div class="tw-px-3 tw-mb-6 lg:tw-mb-0">
                        <jet-label class=" tw-text-gray-500">--</jet-label>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <BotonCarga v-if="FoFiltro.TipRepo == 1" :verBot="vTab" :textoV="'Consultar'" :textoOC="'Buscando...'" :class="'btn-primary'" @click="arrProdu()"></BotonCarga>
                            <BotonCarga v-if="FoFiltro.TipRepo == 2" :verBot="vTab" :textoV="'Consultar'" :textoOC="'Buscando...'" :class="'btn-primary'" @click="arrParo()"></BotonCarga>
                            <button class="btn btn-danger" data-bs-toggle="collapse" data-bs-target="#filtro" aria-expanded="false" aria-controls="filtro">Cerrar</button>
                        </div>

                    </div>
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0">
                        <jet-label class="tw-text-white">Opciones de consulta</jet-label>
                        <div class="tw-flex tw-gap-5">
                            <div>
                                <input type="radio" id="Rdia" value="1" v-model="FoFiltro.rango">
                                <label for="Rdia" class="tw-text-white"> Dia</label>
                            </div>
                            <div>
                                <input type="radio" id="Rrango" value="2" v-model="FoFiltro.rango">
                                <label for="Rrango" class="tw-text-white"> Rango</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tw-mb-6 lg:tw-flex">
                    <!-- mes -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0">
                        <jet-label class="tw-text-white"><span class="required">*</span>Mes</jet-label>
                        <jet-input type="month" class="form-control" @click="limInputs(3)" v-model="FoFiltro.mes"></jet-input>
                    </div>
                    <!-- semana -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0" v-if="FoFiltro.TipRepo == 1">
                        <jet-label class="tw-text-white"><span class="required">*</span>Semana</jet-label>
                        <jet-input type="week" class="form-control" @click="limInputs(2)" v-model="FoFiltro.semana"></jet-input>
                    </div>
                    <!-- dia -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0" v-if="FoFiltro.rango == 1">
                        <jet-label class="tw-text-white"><span class="required">*</span>Fecha Dia</jet-label>
                        <jet-input type="date" class="form-control" @click="limInputs(1.5)" @change="cambioFechas()" v-model="FoFiltro.iniDia"></jet-input>
                    </div>
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0" v-if="FoFiltro.rango == 2">
                        <jet-label class="tw-text-white"><span class="required">*</span>Fecha Inicial</jet-label>
                        <jet-input type="datetime-local" class="form-control" @click="limInputs(1.5)" v-model="FoFiltro.iniDia"></jet-input>
                    </div>
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0" v-if="FoFiltro.rango == 2">
                        <jet-label class="tw-text-white"><span class="required">*</span>Fecha Final</jet-label>
                        <jet-input type="datetime-local" class="form-control" @click="limInputs(1.5)" v-model="FoFiltro.finDia"></jet-input>
                    </div>
                </div>
            </div>
        </div>

        <!------------------------------------ Muestra las opciones de Graficas ------------------------------------------->
        <div class="collapse tw-p-6 tw-border tw-border-8 tw-border-green-400 tw-bg-blueGray-500 tw-rounded-3xl tw-shadow-xl tw-absolute tw-z-20 tw-w-full lg:tw-right-0 lg:tw-w-10/12" id="grafica">
            <div class="tw-mb-6 lg:tw-flex lg:tw-flex-col tw-w-full">
                <!-- arreglo de graficas -->
                <div class="tw-mb-6 lg:tw-flex">
                    <label  class="tw-text-white"><span class="required">*</span>Tipo de gráfica: </label>
                    <div class="tw-px-3 tw-mb-6 tw-gap-3 tw-flex">
                        <div>
                            <input type="checkbox" v-model="graTipo" value="Pastel" id="Pastel"> <label for="Pastel" class="tw-text-white"><i class="fas fa-chart-pie"></i> Gráfica de pastel</label>
                        </div>
                        <div>
                            <input type="checkbox" v-model="graTipo" value="Linea" id="Linea"> <label for="Linea" class="tw-text-white"><i class="fas fa-chart-line"></i> Gráfica lineal</label>
                        </div>
                        <div>
                            <input type="checkbox" v-model="graTipo" value="Barra" id="Barra"> <label for="Barra" class="tw-text-white"><i class="fas fa-chart-bar"></i> Gráfica de barra</label>
                        </div>
                        <div>
                            <input type="checkbox" v-model="graTipo" value="Combinado" id="Combinado"> <label for="Combinado" class="tw-text-white"><i class="fas fa-chart-area"></i> Gráfica de barrar y punto</label>
                        </div>
                    </div>
                    <button class="btn btn-warning" @click="ConGra()" data-bs-toggle="offcanvas" data-bs-target="#grafiGuar" aria-controls="grafiGuar">Graficas guardadas</button>
                </div>

                <!-- recorrido de los tipos de graficas -->
                <div v-for="tip in graTipo" :key="tip">
                    <!------------------------------------------- formulario para grafica de pie ------------------------------------->
                    <div v-if="tip == 'Pastel'" class="tw-mb-6 lg:tw-flex lg:tw-flex-col tw-rounded-xl tw-border-8 tw-border-blue-700 tw-p-10">
                        <!-- titulo y botones -->
                        <div class="sm:tw-flex lg:tw-m-5">
                            <div class="tw-w-full lg:tw-w-1/2 tw-text-2xl tw-text-center">
                                <h1 class="tw-text-white"><i class="fas fa-chart-pie"></i> Gráfica de Pastel</h1>
                            </div>

                            <div class="lg:tw-flex tw-w-full lg:tw-w-1/2">
                                <div class="sm:tw-flex tw-w-1/2 tw-m-auto">
                                    <a class="btn btn-info" href="#chart" @click="GraPaste(gPie)">Generar gráfica</a>
                                    <button class="btn btn-success" v-if="!gPie.update" @click="savePaste(gPie)" tooltip="Guardar gráfica" flow="right"><i class="fas fa-save"></i></button>
                                    <button class="btn btn-primary" v-else @click="updatePaste(gPie)" tooltip="Actualizar gráfica" flow="right"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger" @click="resetPastel()" tooltip="Borrar gráfica" flow="right"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </div>
                        </div>

                        <!-- formulario -->
                        <div class="lg:tw-flex ">

                            <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0 tw-gap-x-5">
                                <jet-label class="tw-text-white">Título</jet-label>
                                <jet-input type="text" class="form-control" v-model="gPie.titulo"></jet-input>

                                <div class="tw-gap-5">
                                    <div class="tw-w-full">
                                        <div v-if="gPie.tipo == 'efiTur' | gPie.tipo == 'efiDia' | gPie.tipo == 'generalTot'">
                                            <jet-label class="tw-text-white"><span class="required">*</span>Proceso</jet-label>
                                            <Select2 v-model="gPie.procesos" class="InputSelect" :settings="{width: '100%', multiple: true, allowClear: true}" :options="proGrafi" />
                                        </div>
                                        <div v-else>
                                            <jet-label class="tw-text-white"><span class="required">*</span>Maquinas</jet-label>
                                            <Select2 v-model="gPie.maquinas" class="InputSelect" :settings="{width: '100%', multiple: true, allowClear: true}" :options="opcMaq" />
                                        </div>
                                    </div>
                                    <div class="tw-w-full" v-if="gPie.propa == 1 & gPie.tipo == 'norma'">
                                        <jet-label class="tw-text-white">Normas</jet-label>
                                        <Select2 v-model="gPie.norma" class="InputSelect" :settings="{width: '100%', multiple: true, allowClear: true}" :options="opcNM" />
                                    </div>
                                </div>

                            </div>

                            <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">

                                <!-- Inputs radio-->
                                <div class="xl:tw-flex">

                                    <div class="tw-px-3 tw-mb-6 tw-w-full lg:tw-mb-0 tw-rounded-xl tw-border tw-border-white-800">
                                        <jet-label class="tw-text-white">Consuta par gráfica</jet-label>
                                        <div class="md:tw-flex tw-text-center">
                                            <div class="tw-m-5">
                                                <input type="radio" id="GPprodu" value="1" v-model="gPie.propa">
                                                <label class="tw-text-white" for="GPprodu"> Producción</label>
                                            </div>
                                            <div class="tw-m-5">
                                                <input type="radio" id="GPparo" value="2" v-model="gPie.propa">
                                                <label class="tw-text-white" for="GPparo"> Paro</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tw-px-3 tw-mb-6 tw-w-full lg:tw-mb-0 tw-rounded-xl tw-border tw-border-white-800">
                                        <jet-label class="tw-text-white">Opciones de consulta</jet-label>
                                        <div class="md:tw-flex tw-text-center">
                                            <div class=" tw-m-5">
                                                <input type="radio" id="GPdia" @click="limpiarGrafi()" value="1" v-model="gPie.rango">
                                                <label class="tw-text-white" for="GPdia"> Dia</label>
                                            </div>
                                            <div class=" tw-m-5">
                                                <input type="radio" id="GPrango" @click="limpiarGrafi()" value="2" v-model="gPie.rango">
                                                <label class="tw-text-white" for="GPrango"> Rango</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tw-px-3 tw-mb-6 tw-w-full lg:tw-mb-0" v-if="gPie.propa == 1">
                                    <jet-label class="tw-text-white">Tipo de gráfica</jet-label>
                                    <div class="lg:tw-flex tw-text-center">
                                        <Select2 v-model="gPie.tipo" class="InputSelect" :options="opcTipo" :settings="{width: '100%', allowClear: true}"></Select2>
                                    </div>
                                </div>

                                <div class="tw-w-full" v-else>
                                    <jet-label class="tw-text-white">Tipo de grafica</jet-label>
                                    <div class="lg:tw-flex tw-text-center">
                                        <select v-model="gPie.tipoParo" class="InputSelect">
                                            <option v-for="otp in opcTipoParo" :key="otp.id" :value="otp.id">{{otp.text}}</option>
                                        </select>
                                    </div>
                                    <!-- <jet-label class="tw-text-white">Paros</jet-label>
                                    <Select2 v-model="gPie.paro" class="InputSelect" :options="opcPR" :settings="{width: '100%', multiple: true, allowClear: true}"></Select2> -->
                                </div>

                                <!-- Input de fechas -->
                                <div v-if="gPie.rango == 1" class="">
                                    <jet-label class="tw-text-white"><span class="required">*</span>Fecha Dia</jet-label>
                                    <jet-input type="date" class="form-control" v-model="gPie.fecha"></jet-input>
                                </div>

                                <div v-if="gPie.rango == 2" class="lg:tw-flex">
                                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                                        <jet-label class="tw-text-white"><span class="required">*</span>Fecha Inicial</jet-label>
                                        <jet-input type="datetime-local" class="form-control" @click="limInputs(1.5)" v-model="gPie.iniDia"></jet-input>
                                    </div>
                                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                                        <jet-label class="tw-text-white"><span class="required">*</span>Fecha Final</jet-label>
                                        <jet-input type="datetime-local" class="form-control" @click="limInputs(1.5)" v-model="gPie.finDia"></jet-input>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!------------------------------------------- formulario para grafica de linea ------------------------------------->
                    <div v-if="tip == 'Linea'" class="tw-mb-6 lg:tw-flex tw-flex-col tw-rounded-xl tw-border-8 tw-border-green-700 tw-p-10">
                        <!-- titulo y botones -->
                        <div class="sm:tw-flex lg:tw-m-5">
                            <!-- titulo -->
                            <div class="tw-w-full lg:tw-w-1/2 tw-text-2xl tw-text-center">
                                <h1 class="tw-text-white"><i class="fas fa-chart-line"></i> Gráfica Lineal</h1>
                            </div>
                            <!-- boton -->
                            <div class="lg:tw-flex tw-w-full lg:tw-w-1/2">
                                <div class="sm:tw-flex tw-w-1/2 tw-m-auto">
                                    <a class="btn btn-info " href="#chart1" @click="GraLinea(gLinea)">Generar gráfica</a>
                                    <button class="btn btn-success" v-if="!gLinea.update" @click="saveLine(gLinea, 'Linea')" tooltip="Guardar gráfica" flow="right"><i class="fas fa-save"></i></button>
                                    <button class="btn btn-primary" v-else @click="updateLine(gLinea)" tooltip="Actualizar gráfica" flow="right"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger " @click="resetLinea()" tooltip="Borrar gráfica" flow="right"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </div>
                        </div>

                        <!-- formulario -->
                        <div class="lg:tw-flex">
                            <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0 tw-gap-x-5">
                                <!-- titulos para graficas -->
                                <div class="lg:tw-flex tw-gap-4">
                                    <!-- titulo -->
                                    <div class=" tw-w-full md:tw-w-1/2">
                                        <jet-label class="tw-text-white">Título</jet-label>
                                        <jet-input type="text" class="form-control" v-model="gLinea.titulo"></jet-input>
                                    </div>
                                    <!-- sub titulo -->
                                    <div class=" tw-w-full md:tw-w-1/2">
                                        <jet-label class="tw-text-white">Sub Título</jet-label>
                                        <jet-input type="text" class="form-control" v-model="gLinea.subtitulo"></jet-input>
                                    </div>
                                </div>

                                <!-- Select de procesos, maquinas y normas -->
                                <div class="xl:tw-flex tw-gap-5">
                                    <div class="tw-w-full">
                                        <div v-if="gLinea.tipo == 'efiTur' | gLinea.tipo == 'efiDia' | gLinea.tipo == 'generalTot'">
                                            <jet-label class="tw-text-white"><span class="required">*</span>Proceso</jet-label>
                                            <Select2 v-model="gLinea.procesos" class="InputSelect" :settings="{width: '100%', multiple: true, allowClear: true}" :options="proGrafi" />
                                        </div>
                                        <div v-else>
                                            <jet-label class="tw-text-white"><span class="required">*</span>Maquinas</jet-label>
                                            <Select2 v-model="gLinea.maquinas" class="InputSelect" :settings="{width: '100%', multiple: true, allowClear: true}" :options="opcMaq" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">

                                <!-- Rango o dia y tipo-->
                                <div class="xl:tw-flex">
                                    <div class="tw-px-3 tw-mb-6 lg:tw-w-full lg:tw-mb-0 tw-rounded-xl tw-border tw-border-white-800">
                                        <jet-label class="tw-text-white">Opciones de consulta</jet-label>
                                        <div class="tw-flex tw-flex-col lg:tw-flex-row">
                                            <div class=" tw-m-5">
                                                <input type="radio" id="GLdia" @click="lipiaLinea(1)" value="1" v-model="gLinea.rango">
                                                <label class="tw-text-white" for="GLdia"> Diario</label>
                                            </div>
                                            <div class=" tw-m-5">
                                                <input type="radio" id="GLsema" @click="lipiaLinea(3)" value="3" v-model="gLinea.rango">
                                                <label class="tw-text-white" for="GLsema"> Semana</label>
                                            </div>
                                            <div class=" tw-m-5">
                                                <input type="radio" id="GLmes" @click="lipiaLinea(2)" value="2" v-model="gLinea.rango">
                                                <label class="tw-text-white" for="GLmes"> Mes</label>
                                            </div>
                                            <div class=" tw-m-5">
                                                <input type="radio" id="GLano" @click="lipiaLinea(3)" value="4" v-model="gLinea.rango">
                                                <label class="tw-text-white" for="GLano"> Año</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Select de tipos de graficas -->
                                <div class="tw-px-3 tw-mb-6 tw-w-full lg:tw-mb-0">
                                    <jet-label class="tw-text-white">Tipo de grafica</jet-label>
                                    <div class="lg:tw-flex tw-text-center">
                                        <Select2 v-model="gLinea.tipo" class="InputSelect" :options="opcTipoOt" :settings="{width: '100%', allowClear: true}"></Select2>
                                    </div>
                                </div>

                                <!-- dias -->
                                <div class="lg:tw-flex tw-gap-4" v-if="gLinea.rango == 1">
                                    <div class=" tw-w-full md:tw-w-1/2">
                                        <jet-label class="tw-text-white">Fecha Inicio</jet-label>
                                        <jet-input type="date" v-model="gLinea.fecIni"></jet-input>
                                    </div>
                                    <div class=" tw-w-full md:tw-w-1/2">
                                        <jet-label class="tw-text-white">Fecha Fin</jet-label>
                                        <jet-input type="date" v-model="gLinea.fecFin"></jet-input>
                                    </div>
                                </div>
                                <!-- semana -->
                                <div class="lg:tw-flex tw-gap-4" v-else-if="gLinea.rango == 3">
                                    <div class=" tw-w-full md:tw-w-1/2">
                                        <jet-label class="tw-text-white">Fecha Inicio</jet-label>
                                        <jet-input type="week" v-model="gLinea.fecIni"></jet-input>
                                    </div>
                                    <div class=" tw-w-full md:tw-w-1/2">
                                        <jet-label class="tw-text-white">Fecha Fin</jet-label>
                                        <jet-input type="week" v-model="gLinea.fecFin"></jet-input>
                                    </div>
                                </div>
                                <!-- mes -->
                                <div class="lg:tw-flex tw-gap-4" v-else-if="gLinea.rango == 2">
                                    <div class=" tw-w-full md:tw-w-1/2">
                                        <jet-label class="tw-text-white">Fecha Inicio</jet-label>
                                        <jet-input type="month" v-model="gLinea.fecIni"></jet-input>
                                    </div>
                                    <div class=" tw-w-full md:tw-w-1/2">
                                        <jet-label class="tw-text-white">Fecha Fin</jet-label>
                                        <jet-input type="month" v-model="gLinea.fecFin"></jet-input>
                                    </div>
                                </div>
                                <!-- año -->
                                <div class="lg:tw-flex tw-gap-4" v-else-if="gLinea.rango == 4">
                                    <div class=" tw-w-full md:tw-w-1/2">
                                        <jet-label class="tw-text-white">Fecha Inicio</jet-label>
                                        <jet-input type="number" v-model="gLinea.fecIni"></jet-input>
                                    </div>
                                    <div class=" tw-w-full md:tw-w-1/2">
                                        <jet-label class="tw-text-white">Fecha Fin</jet-label>
                                        <jet-input type="number" v-model="gLinea.fecFin"></jet-input>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!------------------------------------------- formulario para grafica de barra ------------------------------------->
                    <div v-if="tip == 'Barra'" class="tw-mb-6 lg:tw-flex tw-flex-col tw-rounded-xl tw-border-8 tw-border-yellow-700 tw-p-10">
                        <!-- titulo y botones -->
                        <div class="sm:tw-flex lg:tw-m-5">
                            <!-- titulo -->
                            <div class="tw-w-full lg:tw-w-1/2 tw-text-2xl tw-text-center">
                                <h1 class="tw-text-white"><i class="fas fa-chart-bar"></i> Gráfica de Barra</h1>
                            </div>
                            <!-- boton -->
                            <div class="lg:tw-flex tw-w-full lg:tw-w-1/2">
                                <div class="sm:tw-flex tw-w-1/2 tw-m-auto">
                                    <a class="btn btn-info " href="#chart2" @click="GraBarra(gBarra)">Generar gráfica</a>
                                    <button class="btn btn-success" v-if="!gBarra.update" @click="saveLine(gBarra, 'Barra')" tooltip="Guardar gráfica" flow="right"><i class="fas fa-save"></i></button>
                                    <button class="btn btn-primary" v-else @click="updateLine(gBarra)" tooltip="Actualizar gráfica" flow="right"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger " @click="resetBarra()" tooltip="Borrar gráfica" flow="right"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </div>
                        </div>

                        <!-- Formulario -->
                        <div class="lg:tw-flex">
                            <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0 tw-gap-x-5">
                                <!-- titulos para graficas -->
                                <div class="lg:tw-flex tw-gap-4">
                                    <!-- titulo -->
                                    <div class=" tw-w-full md:tw-w-1/2">
                                        <jet-label class="tw-text-white">Título</jet-label>
                                        <jet-input type="text" class="form-control" v-model="gBarra.titulo"></jet-input>
                                    </div>
                                    <!-- sub titulo -->
                                    <div class=" tw-w-full md:tw-w-1/2">
                                        <jet-label class="tw-text-white">Sub Título</jet-label>
                                        <jet-input type="text" class="form-control" v-model="gBarra.subtitulo"></jet-input>
                                    </div>
                                </div>

                                <!-- Select de procesos, maquinas y normas -->
                                <div class="lg:tw-flex tw-gap-5">
                                    <div class="tw-w-full">
                                        <div v-if="gBarra.tipo == 'efiTur' | gBarra.tipo == 'efiDia' | gBarra.tipo == 'generalTot'">
                                            <jet-label class="tw-text-white"><span class="required">*</span>Proceso</jet-label>
                                            <Select2 v-model="gBarra.procesos" class="InputSelect" :settings="{width: '100%', multiple: true, allowClear: true}" :options="proGrafi" />
                                        </div>
                                        <div v-else>
                                            <jet-label class="tw-text-white"><span class="required">*</span>Maquinas</jet-label>
                                            <Select2 v-model="gBarra.maquinas" class="InputSelect" :settings="{width: '100%', multiple: true, allowClear: true}" :options="opcMaq" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">

                                <!-- Rango o dia y tipo-->
                                <div class="xl:tw-flex">
                                    <div class="tw-px-3 tw-mb-6 lg:tw-w-full lg:tw-mb-0 tw-rounded-xl tw-border tw-border-white-800">
                                        <jet-label class="tw-text-white">Opciones de consulta</jet-label>
                                        <div class="lg:tw-flex">
                                            <div class=" tw-m-5">
                                                <input type="radio" id="GBdia" @click="limpiaBarra(1)" value="1" v-model="gBarra.rango">
                                                <label class="tw-text-white" for="GBdia"> Diario</label>
                                            </div>
                                            <div class=" tw-m-5">
                                                <input type="radio" id="GBsema" @click="limpiaBarra(3)" value="3" v-model="gBarra.rango">
                                                <label class="tw-text-white" for="GBsema"> Semana</label>
                                            </div>
                                            <div class=" tw-m-5">
                                                <input type="radio" id="GBmes" @click="limpiaBarra(2)" value="2" v-model="gBarra.rango">
                                                <label class="tw-text-white" for="GBmes"> Mes</label>
                                            </div>
                                            <div class=" tw-m-5">
                                                <input type="radio" id="GBano" @click="limpiaBarra(3)" value="4" v-model="gBarra.rango">
                                                <label class="tw-text-white" for="GBano"> Año</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Select de tipos de graficas -->
                                <div class="tw-px-3 tw-mb-6 tw-w-full lg:tw-mb-0">
                                    <jet-label class="tw-text-white">Tipo de grafica</jet-label>
                                    <div class="lg:tw-flex tw-text-center">
                                        <Select2 v-model="gBarra.tipo" class="InputSelect" :options="opcTipoOt" :settings="{width: '100%', allowClear: true}"></Select2>
                                    </div>
                                </div>

                                <!-- dias -->
                                <div class="lg:tw-flex tw-gap-4" v-if="gBarra.rango == 1">
                                    <div class=" tw-w-full md:tw-w-1/2">
                                        <jet-label class="tw-text-white">Fecha Inicio</jet-label>
                                        <jet-input type="date" v-model="gBarra.fecIni"></jet-input>
                                    </div>
                                    <div class=" tw-w-full md:tw-w-1/2">
                                        <jet-label class="tw-text-white">Fecha Fin</jet-label>
                                        <jet-input type="date" v-model="gBarra.fecFin"></jet-input>
                                    </div>
                                </div>
                                <!-- semana -->
                                <div class="lg:tw-flex tw-gap-4" v-else-if="gBarra.rango == 3">
                                    <div class=" tw-w-full md:tw-w-1/2">
                                        <jet-label class="tw-text-white">Fecha Inicio</jet-label>
                                        <jet-input type="week" v-model="gBarra.fecIni"></jet-input>
                                    </div>
                                    <div class=" tw-w-full md:tw-w-1/2">
                                        <jet-label class="tw-text-white">Fecha Fin</jet-label>
                                        <jet-input type="week" v-model="gBarra.fecFin"></jet-input>
                                    </div>
                                </div>
                                <!-- mes -->
                                <div class="lg:tw-flex tw-gap-4" v-else-if="gBarra.rango == 2">
                                    <div class=" tw-w-full md:tw-w-1/2">
                                        <jet-label class="tw-text-white">Fecha Inicio</jet-label>
                                        <jet-input type="month" v-model="gBarra.fecIni"></jet-input>
                                    </div>
                                    <div class=" tw-w-full md:tw-w-1/2">
                                        <jet-label class="tw-text-white">Fecha Fin</jet-label>
                                        <jet-input type="month" v-model="gBarra.fecFin"></jet-input>
                                    </div>
                                </div>
                                <!-- año -->
                                <div class="lg:tw-flex tw-gap-4" v-else-if="gBarra.rango == 4">
                                    <div class=" tw-w-full md:tw-w-1/2">
                                        <jet-label class="tw-text-white">Fecha Inicio</jet-label>
                                        <jet-input type="number" v-model="gBarra.fecIni"></jet-input>
                                    </div>
                                    <div class=" tw-w-full md:tw-w-1/2">
                                        <jet-label class="tw-text-white">Fecha Fin</jet-label>
                                        <jet-input type="number" v-model="gBarra.fecFin"></jet-input>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!------------------------------------------- formulario para grafica combinada ------------------------------------->
                    <div v-if="tip == 'Combinado'" class="tw-mb-6 lg:tw-flex tw-flex-col tw-rounded-xl tw-border-8 tw-border-red-700 tw-p-10">
                        <!-- titulo y botones -->
                        <div class="sm:tw-flex lg:tw-m-5">
                            <!-- titulo -->
                            <div class="tw-w-full lg:tw-w-1/2 tw-text-2xl tw-text-center">
                                <h1 class="tw-text-white"><i class="fas fa-chart-area"></i> Gráfica Combinada</h1>
                            </div>
                            <!-- boton -->
                            <div class="lg:tw-flex tw-w-full lg:tw-w-1/2">
                                <div class="sm:tw-flex tw-w-1/2 tw-m-auto">
                                    <a class="btn btn-info " href="#chart3" @click="GraBaLi(gBaLi)">Generar gráfica</a>
                                    <button class="btn btn-success" v-if="!gBaLi.update" @click="saveCom(gBaLi, 'Combinado')" tooltip="Guardar gráfica" flow="right"><i class="fas fa-save"></i></button>
                                    <button class="btn btn-primary" v-else @click="updateCom(gBaLi)" tooltip="Actualizar gráfica" flow="right"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger " @click="resetBaLi()" tooltip="Borrar gráfica" flow="right"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </div>
                        </div>

                        <!-- formulario -->
                        <div class="lg:tw-flex">
                            <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0 tw-gap-x-5">
                                <!-- titulos para graficas -->
                                <div class="tw-gap-4">
                                    <!-- titulo -->
                                    <div class=" tw-w-full">
                                        <jet-label class="tw-text-white">Título</jet-label>
                                        <jet-input type="text" class="form-control" v-model="gBaLi.titulo"></jet-input>
                                    </div>
                                    <jet-label class="tw-text-white"><span class="required">*</span>Títulos laterales</jet-label>
                                    <!-- sub titulo -->
                                    <div class="tw-w-full tw-flex tw-gap-3">
                                        <div class="tw-w-full md:tw-w-1/2">
                                            <jet-label class="tw-text-white">Izquierdo</jet-label>
                                            <jet-input type="text" class="form-control" v-model="gBaLi.subIz"></jet-input>
                                        </div>
                                        <div class="tw-w-full md:tw-w-1/2">
                                            <jet-label class="tw-text-white">Derecho</jet-label>
                                            <jet-input type="text" class="form-control" v-model="gBaLi.subDe"></jet-input>
                                        </div>
                                    </div>
                                </div>

                                <!-- Select de procesos, maquinas y normas -->
                                <div class="lg:tw-flex tw-gap-5">
                                    <div class="tw-w-full">
                                        <div v-if="gBaLi.tipo == 'efiTur' | gBaLi.tipo == 'efiDia' | gBaLi.tipo == 'generalTot'">
                                            <jet-label class="tw-text-white"><span class="required">*</span>Proceso para Barra <i class="fas fa-chart-bar"></i></jet-label>
                                            <Select2 v-model="gBaLi.procesosBar" class="InputSelect" :settings="{width: '100%', multiple: true, allowClear: true}" :options="proGrafi" />
                                            <jet-label class="tw-text-white"><span class="required">*</span>Proceso para Linea <i class="fas fa-chart-line"></i></jet-label>
                                            <Select2 v-model="gBaLi.procesosLin" class="InputSelect" :settings="{width: '100%', multiple: true, allowClear: true}" :options="proGrafi" />
                                        </div>
                                        <div v-else>
                                            <jet-label class="tw-text-white"><span class="required">*</span>Maquinas para Barra <i class="fas fa-chart-bar"></i></jet-label>
                                            <Select2 v-model="gBaLi.maquinasBar" class="InputSelect" :settings="{width: '100%', multiple: true, allowClear: true}" :options="opcMaq" />
                                            <jet-label class="tw-text-white"><span class="required">*</span>Maquinas para Linea <i class="fas fa-chart-line"></i></jet-label>
                                            <Select2 v-model="gBaLi.maquinasLin" class="InputSelect" :settings="{width: '100%', multiple: true, allowClear: true}" :options="opcMaq" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">

                                <!-- Rango o dia y tipo-->
                                <div class="xl:tw-flex">
                                    <div class="tw-px-3 tw-mb-6 lg:tw-w-full lg:tw-mb-0 tw-rounded-xl tw-border tw-border-white-800">
                                        <jet-label class="tw-text-white">Opciones de consulta</jet-label>
                                        <div class="lg:tw-flex">
                                            <div class=" tw-m-5">
                                                <input type="radio" id="GBLdia" @click="limpiaCombi(1)" value="1" v-model="gBaLi.rango">
                                                <label class="tw-text-white" for="GBLdia"> Diario</label>
                                            </div>
                                            <div class=" tw-m-5">
                                                <input type="radio" id="GBLsema" @click="limpiaCombi(3)" value="3" v-model="gBaLi.rango">
                                                <label class="tw-text-white" for="GBLsema"> Semana</label>
                                            </div>
                                            <div class=" tw-m-5">
                                                <input type="radio" id="GBLmes" @click="limpiaCombi(2)" value="2" v-model="gBaLi.rango">
                                                <label class="tw-text-white" for="GBLmes"> Mes</label>
                                            </div>
                                            <div class=" tw-m-5">
                                                <input type="radio" id="GBLano" @click="limpiaCombi(4)" value="4" v-model="gBaLi.rango">
                                                <label class="tw-text-white" for="GBLano"> Año</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Select de tipos de graficas -->
                                <div class="tw-px-3 tw-mb-6 tw-w-full lg:tw-mb-0">
                                    <jet-label class="tw-text-white">Tipo de grafica</jet-label>
                                    <div class="lg:tw-flex tw-text-center">
                                        <Select2 v-model="gBaLi.tipo" class="InputSelect" :options="opcTipoOt" :settings="{width: '100%', allowClear: true}"></Select2>
                                    </div>
                                </div>
                                <!-- dias -->
                                <div class="lg:tw-flex tw-gap-4" v-if="gBaLi.rango == 1">
                                    <div class=" tw-w-full md:tw-w-1/2">
                                        <jet-label class="tw-text-white">Fecha Inicio</jet-label>
                                        <jet-input type="date" v-model="gBaLi.fecIni"></jet-input>
                                    </div>
                                    <div class=" tw-w-full md:tw-w-1/2">
                                        <jet-label class="tw-text-white">Fecha Fin</jet-label>
                                        <jet-input type="date" v-model="gBaLi.fecFin"></jet-input>
                                    </div>
                                </div>
                                <!-- semana -->
                                <div class="lg:tw-flex tw-gap-4" v-if="gBaLi.rango == 3">
                                    <div class=" tw-w-full md:tw-w-1/2">
                                        <jet-label class="tw-text-white">Fecha Inicio</jet-label>
                                        <jet-input type="week" v-model="gBaLi.fecIni"></jet-input>
                                    </div>
                                    <div class=" tw-w-full md:tw-w-1/2">
                                        <jet-label class="tw-text-white">Fecha Fin</jet-label>
                                        <jet-input type="week" v-model="gBaLi.fecFin"></jet-input>
                                    </div>
                                </div>
                                <!-- mes -->
                                <div class="lg:tw-flex tw-gap-4" v-else-if="gBaLi.rango == 2">
                                    <div class=" tw-w-full md:tw-w-1/2">
                                        <jet-label class="tw-text-white">Fecha Inicio</jet-label>
                                        <jet-input type="month" v-model="gBaLi.fecIni"></jet-input>
                                    </div>
                                    <div class=" tw-w-full md:tw-w-1/2">
                                        <jet-label class="tw-text-white">Fecha Fin</jet-label>
                                        <jet-input type="month" v-model="gBaLi.fecFin"></jet-input>
                                    </div>
                                </div>
                                <!-- año -->
                                <div class="lg:tw-flex tw-gap-4" v-else-if="gBaLi.rango == 4">
                                    <div class=" tw-w-full md:tw-w-1/2">
                                        <jet-label class="tw-text-white">Fecha Inicio</jet-label>
                                        <jet-input type="number" v-model="gBaLi.fecIni"></jet-input>
                                    </div>
                                    <div class=" tw-w-full md:tw-w-1/2">
                                        <jet-label class="tw-text-white">Fecha Fin</jet-label>
                                        <jet-input type="number" v-model="gBaLi.fecFin"></jet-input>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!------------------------------------ Graficas guardadas --------------------------------------------------------->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="grafiGuar" aria-labelledby="grafiGuarLabel">
            <div class="offcanvas-header">
                <div id="grafiGuarLabel" class=" tw-text-4xl"><strong>Graficas</strong></div>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body">
                <div class="tw-w-full">
                    <label for=""></label>
                </div>
                <div v-for="gg in GrafGua" :key="gg" class="tw-shadow-lg tw-rounded-2xl">
                    <div class="GraficaImg" @click="asigGrafi(gg)"  data-bs-dismiss="offcanvas">
                        <div :style="'background: linear-gradient(to left, rgba(255,255,255,0), rgba(255,255,255,1)), url('+imgGrafi(gg.graTipo)+'); background-size: 40% 95%;  background-repeat: no-repeat; background-position: right top;'">
                            <label class="tw-cursor-pointer tw-text-lg"><strong>Título:</strong> {{ gg.titulo }} </label><br>
                            <label class="tw-cursor-pointer tw-text-lg"><strong>Tipo de gráfica:</strong> {{gg.graTipo}}</label>
                        </div>
                    </div>
                    <div class="btn-group tw-w-full" role="group">
                        <!-- <button class="btn btn-outline-primary">Actualizar</button> -->
                        <button class="btn btn-outline-danger" @click="elimiGrafi(gg)">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>

        <!------------------------------------ Data table de carga de produccion ------------------------------------------------------->
        <div v-show="FoFiltro.TipRepo == 1" class="tw-m-auto" style="width: 98%">
            <Table id="t_repo">
                <template v-slot:TableHeader>
                    <th class="columna" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">Indice</th>
                    <th class="columna" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">Fecha</th>
                    <th class="columna">Proceso</th>
                    <th class="columna" v-show="FoFiltro.iniDia != null">Maquina</th>
                    <th class="columna" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">Nombre</th>
                    <th class="columna" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">Estatus</th>
                    <th class="columna" v-show="FoFiltro.iniDia != null">Equipo</th>
                    <th class="columna" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">Turno</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Partida</th>
                    <th class="columna">Norma</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Clave</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Descripción de clave</th>
                    <th class="columna">Producción</th>
                    <th class="columna" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">Cantidad producida</th>
                    <th class="columna" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">Departamento</th>
                    <th v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">
                        <button class="btn btn-danger" v-show="deli.elimiMasi.length > 0" @click="eliminaMasiva(deli)" >Eliminar</button>
                    </th>
                </template>
                <template v-slot:TableFooter >
                    <tr class="fila" v-for="ca in recoTabla" :key="ca.id">
                        <td v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">
                            <div v-if="ca.proceso.tipo == 1 | ca.proceso.tipo == 5 | ca.proceso.tipo == 3">
                                <input type="checkbox" :value="ca.id" v-model="deli.elimiMasi" class="tw-rounded-xl tw-bg-coolGray-300" :id="'indePro'+ca.id "/>
                                <label :for="'indePro'+ca.id" class="tw-px-3"> {{ca.id}} </label>
                            </div>
                            <div v-else>
                                {{ca.id}}
                            </div>
                        </td>
                        <td v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">{{ca.fecha}}</td>
                        <td class="">{{ca.proceso == null ? 'N/A' : ca.proceso.nompro}}</td>
                        <td v-show="FoFiltro.iniDia != null">{{ca.maq_pro == null ? 'N/A' : ca.maq_pro.maquinas.Nombre}}</td>
                        <td v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1" >
                            {{ca.dep_perf == null ? 'N/A' : ca.dep_perf.perfiles.Nombre}} {{ca.dep_perf == null ? 'N/A' : ca.dep_perf.perfiles.ApPat}} {{ca.dep_perf == null ? 'N/A' : ca.dep_perf.perfiles.ApMat}}
                        </td>
                        <td class=" tw-w-40" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-cyan-600 tw-rounded-full" v-if="ca.notaPen == 2">NOTA PENDIENTE</div>
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-blue-600 tw-rounded-full" v-if="ca.proceso.tipo == 3">CALCULOS</div>
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-indigo-600 tw-rounded-full" v-else-if="ca.proceso.tipo == 1 & ca.notaPen == 1">PRODUCCION</div>
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-yellow-600 tw-rounded-full" v-else-if="ca.proceso.tipo == 5 & ca.notaPen == 1">MERMA</div>
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-orange-600 tw-rounded-full" v-else-if="ca.proceso.tipo == 2 & ca.notaPen == 1">OBJETIVO</div>
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-teal-600 tw-rounded-full" v-if="ca.notaPen == 1 & ca.notas.length > 1"> - ACTUALIZADO</div>
                        </td>
                        <td  v-show="FoFiltro.iniDia != null">{{ca.equipo == null ? 'N/A' : ca.equipo.nombre}}</td>
                        <td  v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">{{ca.turno == null ? 'N/A' : ca.turno.nomtur}}</td>
                        <td  v-show="FoFiltro.iniDia">{{ca.partida == null ? 'N/A' : ca.partida}}</td>
                        <td >{{ca.dep_mat == null ? 'N/A' : ca.dep_mat.materiales.idmat+' - '+ca.dep_mat.materiales.nommat}}</td>
                        <td  v-show="FoFiltro.iniDia">{{ca.clave == null ? 'N/A' : ca.clave.CVE_ART}}</td>
                        <td  v-show="FoFiltro.iniDia">{{ca.clave == null ? 'N/A' : ca.clave.DESCR}}</td>
                        <td >{{this.formatoMexico(ca.valor)}}</td>
                        <td  v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1"> {{ca.VerInv}} </td>
                        <td v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1" >{{ca.dep_perf == null ? 'N/A' : ca.dep_perf.departamentos.Nombre}}</td>
                        <td v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">
                            <div class="columnaIconos" v-if="limiteFecha()">
                                <!-- editar objetivos -->
                                <div class="iconoEdit" v-if="ca.proceso.tipo == 2 & usuario.dep_pers.length == 0" @click="editCar(ca)">
                                    <span tooltip="Editar" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </span>
                                </div>
                                <!-- editar Produccion -->
                                <div class="iconoEdit" v-if="ca.proceso.tipo == 1 | ca.proceso.tipo == 5" @click="editCar(ca)">
                                    <span tooltip="Editar" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </span>
                                </div>
                                <!-- eliminar -->
                                <div class="iconoDelete" v-if="ca.proceso.tipo == 1 | ca.proceso.tipo == 5 | ca.proceso.tipo == 3" @click="deleteCar(ca)">
                                    <span tooltip="Eliminar" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <!-- Notas
                            <div class="columnaIconos">
                                <div class="iconoDetails tw-cursor-pointer" @click="VeNota(ca)" v-show="ca.notas.length != 0">
                                    <span tooltip="Ver notas" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            -->
                        </td>
                    </tr>
                </template>
                <template v-slot:Foother>
                    <th class="columna" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">Indice</th>
                    <th class="columna" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">Fecha</th>
                    <th class="columna">Proceso</th>
                    <th class="columna" v-show="FoFiltro.iniDia != null">Maquina</th>
                    <th class="columna" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">Nombre</th>
                    <th class="columna" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">Estatus</th>
                    <th class="columna" v-show="FoFiltro.iniDia != null">Equipo</th>
                    <th class="columna" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">Turno</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Partida</th>
                    <th class="columna">Norma</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Clave</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Descripción de clave</th>
                    <th class="columna">Producción</th>
                    <th class="columna" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">Cantidad producida</th>
                    <th class="columna" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">Departamento</th>
                    <th v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1"></th>
                </template>
            </Table>
        </div>

        <!------------------------------------- Data table de paros ------------------------------------------------------------------>
        <div v-show="FoFiltro.TipRepo == 2" class="tw-m-auto" style="width: 98%">
            <TableBlue id="t_repoPar">
                <template v-slot:TableHeader>
                    <th class="columna tw-text-center" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">Fecha</th>
                    <th class="columna tw-text-center" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">Orden</th>
                    <th class="columna tw-text-center">Maquina</th>
                    <th class="columna tw-text-center">Clave de paro</th>
                    <th class="columna tw-text-center">Nombre de paro</th>
                    <th class="columna tw-text-center" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">Descripción</th>
                    <th class="columna tw-text-center" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">Estatus</th>
                    <th class="columna tw-text-center" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">Abierto por</th>
                    <th class="columna tw-text-center" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">Cerrado por</th>
                    <th class="columna tw-text-center" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">Inicio</th>
                    <th class="columna tw-text-center" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">Final</th>
                    <th class="columna tw-text-center">Tiempo cargado</th>
                    <th class="columna tw-text-center" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">Plan de Acción</th>
                </template>
                <template v-slot:TableFooter>
                    <tr class="fila" v-for="ca in recoTablaParo" :key="ca">
                        <td class="tw-text-center" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">{{ca.fecha}}</td>
                        <td class="tw-text-center" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">{{ca.orden}}</td>
                        <td class="tw-text-center">{{ ca.maq_pro.length ? ca.maq_pro : ca.maq_pro.maquinas.Nombre}}</td>
                        <td class="tw-text-center">{{ca.paros.clave}}</td>
                        <td class="tw-text-center">{{ca.paros.descri}}</td>
                        <td class="tw-text-center" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">{{ca.descri}}</td>

                        <td class="tw-text-center" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-amber-600 tw-rounded-full" v-if="ca.estatus == 'Activo'">{{ca.estatus}}</div>
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-blue-600 tw-rounded-full" v-else-if="ca.estatus == 'En revisión'">{{ca.estatus}}</div>
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-green-600 tw-rounded-full" v-else-if="ca.estatus == 'Autorizado'">{{ca.estatus}}</div>
                        </td>

                        <td class="tw-text-center" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">{{ca.perfil_ini == null ? ca.perfil_ini : ca.perfil_ini.Nombre + ' ' + ca.perfil_ini.ApPat + ' ' + ca.perfil_ini.ApMat }} </td>
                        <td class="tw-text-center" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">{{ca.perfil_fin_id == null ? '' : ca.perfil_fin.Nombre+' '+ca.perfil_fin.ApPat+' '+ca.perfil_fin.ApMat}}</td>
                        <td class="tw-text-center" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">{{ca.iniFecha}}</td>
                        <td class="tw-text-center" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">{{ nuFin(ca) }}</td>
                        <td class="tw-text-center">{{tiempo(ca)}}</td>
                        <td class="tw-text-center" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">{{ca.pla_acci}}</td>
                    </tr>
                </template>
                <template v-slot:Foother>
                    <th class="columna tw-text-center" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">Fecha</th>
                    <th class="columna tw-text-center" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">Orden</th>
                    <th class="columna tw-text-center">Maquina</th>
                    <th class="columna tw-text-center">Clave de paro</th>
                    <th class="columna tw-text-center">Nombre de paro</th>
                    <th class="columna tw-text-center" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">Descripción</th>
                    <th class="columna tw-text-center" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">Estatus</th>
                    <th class="columna tw-text-center" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">Abierto por</th>
                    <th class="columna tw-text-center" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">Cerrado por</th>
                    <th class="columna tw-text-center" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">Inicio</th>
                    <th class="columna tw-text-center" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">Final</th>
                    <th class="columna tw-text-center">Tiempo cargado</th>
                    <th class="columna tw-text-center" v-show="FoFiltro.iniDia != null & FoFiltro.rango == 1">Plan de Acción</th>
                </template>
            </TableBlue>
        </div>

        <!------------------------------------ Graficas ------------------------------------------------------------------>
        <div class="tw-text-center tw-my-24 tw-m-auto" style="width: 98%">
            <div id="chart" class="tw-m-10"></div>
            <div id="chart1" class="tw-m-10"></div>
            <div id="chart2" class="tw-m-10"></div>
            <div id="chart3" class="tw-m-10"></div>
        </div>

        <!------------------------------------- Modal para carga de datos masivas ------------------------------------------------>
        <modal :show="showModalC" @close="chageCloseC">
            <div class="tw-px-4 tw-py-4">
                <div class="tw-text-lg">
                    <div class="ModalHeader">
                        <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Carga Masiva</h3>
                    </div>
                </div>

                <div class="tw-mt-4">
                    <div class="ModalForm">
                        <div v-if="S_Area == 7">
                            <!-- Input formulario -->
                            <div class="tw-mt-10 tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-2/3 md:tw-mb-0 tw-justify-center">
                                    <jet-label><span class="required">*</span>Carga masiva Producción</jet-label>
                                    <input type="file" class="" @input="docu.file = $event.target.files[0]" ref="file" accept=".xlsx">
                                    <br>
                                    <small v-if="errors.file" class="validation-alert">{{errors.file}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/3 md:tw-mb-0">
                                    <BotonCarga :verBot="vMasi" :textoV="'Guardar'" :textoOC="'Guardando...'" :class="'btn-primary'" @click="carMasi()"></BotonCarga>
                                </div>
                            </div>
                            <!-- archivo de descarga -->
                            <div class="tw-w-full tw-mt-6 tw-mb-6 md:tw-flex tw-m-auto">
                                <div class="tw-px-3 tw-mb-6 md:tw-mb-0">
                                    <a target="_blank" class="tw-text-blue-600 tw-text-xl" :href="descarga" download="Carga Masiva.xlsx">Descargar Archivo Producción</a>
                                </div>
                            </div>
                        </div>

                        <!------------------------------- Carga masiva -------------------------------->
                        <div v-else>
                            <!-- Input formulario -->
                            <div class="tw-mt-10 tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-2/3 md:tw-mb-0 tw-justify-center">
                                    <jet-label><span class="required">*</span>Carga masiva Producción</jet-label>
                                    <input type="file" class="" @input="docu2.file = $event.target.files[0]" ref="file" accept=".xlsx">
                                    <br>
                                    <small v-if="errors.file" class="validation-alert">{{errors.file}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/3 md:tw-mb-0">
                                    <BotonCarga :verBot="vMasi" :textoV="'Guardar'" :textoOC="'Guardando...'" :class="'btn-primary'" @click="carMatriObje()"></BotonCarga>
                                </div>
                            </div>
                            <!-- archivo de descarga -->
                            <div class="tw-w-full tw-mt-6 tw-mb-6 md:tw-flex tw-m-auto">
                                <div class="tw-px-3 tw-mb-6 md:tw-mb-0">
                                    <a target="_blank" class="tw-text-blue-600 tw-text-xl" :href="descarga2" download="Carga Masiva OE.xlsx">Descargar Archivo Producción</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </modal>

        <!------------------ Modal Editar Carga------------------------->
        <modal :show="showModalCar" @close="changeCloseCar">
            <div class="tw-px-4 tw-py-4">
                <div class="tw-text-lg">
                    <div class="ModalHeader">
                        <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Editar datos cargados</h3>
                    </div>
                </div>

                <div class="tw-mt-4">
                    <div class="ModalForm">
                        <!-- Información general -->
                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/4 md:tw-mb-0">
                                <jet-label>Numero de empleado</jet-label>
                                <p>{{carga.idemp}}</p>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/4 md:tw-mb-0">
                                <jet-label>Nombre del operador</jet-label>
                                <p>{{carga.nomOpe}}</p>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/4 md:tw-mb-0">
                                <jet-label>Turno</jet-label>
                                <p>{{carga.turno}}</p>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/4 md:tw-mb-0">
                                <jet-label>Equipo</jet-label>
                                <p>{{carga.equipo}}</p>
                            </div>
                        </div>
                        <!-- datos para editar Fecha, proceso, subproceso, maquinas -->
                        <div class="tw-md-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/4 md:tw-mb-0">
                                <jet-label>Fecha de la carga</jet-label>
                                <input type="datetime-local" v-model="carga.fecha" class="InputSelect">
                                <small v-if="errors.fecha" class="validation-alert">{{errors.fecha}}</small>
                            </div>
                            <!-- Select proceso principal -->
                            <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                                <jet-label><span class="required">*</span>Proceso proncipal</jet-label>
                                <select class="InputSelect" v-model="proc_prin" :disabled="editMode">
                                    <option value="" disabled>SELECCIONA</option>
                                    <option v-for="pp in opcPP" :key="pp" :value="pp.value" >{{pp.text}}</option>
                                </select>
                                <small v-if="errors.proc_prin" class="validation-alert">{{errors.proc_prin}}</small>
                            </div>
                            <!-- select Sub proceso -->
                            <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                                <jet-label><span class="required">*</span>Sub proceso </jet-label>
                                <select class="InputSelect" v-model="carga.proceso_id" :disabled="editMode">
                                    <option value="" disabled>SELECCIONA</option>
                                    <option v-for="sp in opcSP" :key="sp" :value="sp.id">{{sp.text}}</option>
                                </select>
                                <small v-if="errors.proceso_id" class="validation-alert">{{errors.proceso_id}}</small>
                            </div>
                            <!-- select Maquinas -->
                            <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                                <jet-label><span class="required">*</span>Maquinas</jet-label>
                                <select class="InputSelect" v-model="carga.maq_pro_id" :disabled="editMode">
                                    <option value="" disabled>SELECCIONA</option>
                                    <option v-for="mq in opcMQ" :key="mq.id" :value="mq.id">{{mq.text}}</option>
                                </select>
                                <small v-if="errors.maq_pro_id" class="validation-alert">{{errors.maq_pro_id}}</small>
                            </div>
                        </div>
                        <!-- datos para editar Norma, clave, partida, KG -->
                        <div class="tw-mb-6 md:tw-flex">
                            <!-- select norma -->
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>Norma</jet-label>
                                <select class="InputSelect" v-model="carga.norma">
                                    <option v-for="nm in opcNM" :key="nm" :value="nm.id">{{nm.text}}</option>
                                </select>
                                <small v-if="errors.norma" class="validation-alert">{{errors.norma}}</small>
                            </div>

                            <!-- select partida -->
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>Partida</jet-label>
                                <jet-input class="InputSelect" v-model="carga.partida"></jet-input>
                                <small v-if="errors.partida" class="validation-alert">{{errors.partida}}</small>
                            </div>
                            <!-- select value -->
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>Kg</jet-label>
                                <jet-input class="InputSelect" v-model="carga.valor"></jet-input>
                                <small v-if="errors.valor" class="validation-alert">{{errors.valor}}</small>
                            </div>
                        </div>
                        <div class="tw-mb-6 md:tw-flex">
                            <!-- select clave -->
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>Clave</jet-label>
                                <Select2 v-model="carga.clave_id"  :class="'InputSelect'" :options="opcCL"  :settings="{width: '100%'}" />
                                <small v-if="errors.clave_id" class="validation-alert">{{errors.clave_id}}</small>
                            </div>
                        </div>
                        <!-- notas -->
                        <div class="tw-mb-6 lg:tw-flex">
                            <div class="tw-px-3 tw-mb-6 lg:tw-w-1/3 tw-text-center tw-mx-auto lg:tw-mb-0 tw-bg-emerald-700 tw-bg-opacity-50 tw-rounded-lg">
                                <jet-label>Nota anterior</jet-label>
                                <jet-label v-html="nAnte"></jet-label>
                            </div>
                            <div class="tw-px-3 tw-mb-6 lg:tw-w-2/3 tw-text-center tw-mx-auto lg:tw-mb-0">
                                <jet-label><span class="required">*</span>Nota</jet-label>
                                <textarea class="InputSelect" v-model="carga.nota" maxlength="250" @input="(val) => (carga.nota = carga.nota.toUpperCase())" placeholder="Maximo 250 caracteres"></textarea>
                                <small v-if="errors.nota" class="validation-alert">{{errors.nota}}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ModalFooter">
                <button class="btn btn-outline-success" type="button" @click="updateCar(carga)">
                    Actualizar
                </button>
                <jet-CancelButton @click="changeCloseCar">Cerrar</jet-CancelButton>
            </div>
        </modal>

    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Header from '@/Components/Header'
    import Accions from '@/Components/Accions'
    import Table from '@/Components/Table';
    import TableBlue from '@/Components/TableBlue';
    import Modal from '@/Jetstream/Modal';
    import JetButton from '@/Components/Button';
    import JetCancelButton from '@/Components/CancelButton';
    import JetInput from '@/Components/Input';
    import JetLabel from '@/Jetstream/Label';
    import Select2 from 'vue3-select2-component';
    import moment from 'moment';
    import 'moment/locale/es';
    import ActionMessage from '@/Components/ActionMessage'
    //datatable
    import datatable from 'datatables.net-bs5';
    require( 'datatables.net-buttons-bs5/js/buttons.bootstrap5' );

    require( 'datatables.net-buttons/js/buttons.html5' );
    require ( 'datatables.net-buttons/js/buttons.colVis' );
    import print from 'datatables.net-buttons/js/buttons.print';
    import jszip from 'jszip/dist/jszip';
    import pdfMake from 'pdfmake/build/pdfmake';
    import pdfFonts from 'pdfmake/build/vfs_fonts';
    import $ from 'jquery';
    import axios from 'axios';
    import BotonCarga from '../../../Components/BotonCarga.vue';

    import Canvas from '@/Components/Canvas';

    pdfMake.vfs = pdfFonts.pdfMake.vfs;
    window.JSZip = jszip;

    var Highcharts = require('highcharts');
    // Load module after Highcharts is loaded
    require('highcharts/modules/exporting')(Highcharts);

    export default {
        props: [
            'usuario',
            'depa',
            'claParo',
            'errors'
        ],

        components: {
            AppLayout,
            Header,
            Accions,
            Table,
            BotonCarga,
            TableBlue,
            JetButton,
            JetInput,
            Modal,
            Select2,
            JetLabel,
            ActionMessage,
            Canvas,
            JetCancelButton
        },

        data() {
            return {
                color: "tw-bg-blue-600",
                descarga: "",
                descarga2: "",
                style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
                S_Area: '',
                procesos: [],
                materiales: [],
                editMode: false,
                showModalC: false,
                showModalCar: false,
                vMasi: true,
                vCal: true,
                vTab: true,
                GrafGua: [],
                hoy: moment().format('YYYY-MM-DD'),
                recoTabla: [],
                recoTablaParo: [],
                graTipo: [],
                proc_prin: '',
                deli:{
                    elimiMasi: []
                },
                docu: {
                    file: null
                },
                docu2: {
                    file: null
                },
                FoFiltro: {
                    TipRepo: 1,
                    rango: 1,
                    mes: null,
                    semana: null,
                    iniDia: null,
                    finDia: null,
                },
                form: {
                    fecha: null,
                    hoy: null,
                    mañana: null,
                    depa: this.S_Area
                },
                carga: {
                    id: null,
                    idemp: null,
                    noFecha: moment().format('YYYY-MM-DD HH:mm:ss'),
                    usu: this.usuario.id,
                    nomOpe: null,
                    fecha: null,
                    proceso_id: null,
                    maq_pro_id: null,
                    turno: null,
                    equipo: null,
                    norma: null,
                    clave_id: null,
                    partida: null,
                    valor: null,
                    nota: null
                },
                gPie: {
                    id: null,
                    borra: null,
                    rango: 1,
                    propa: 1,
                    tipo: 'generalMaq',
                    tipoParo: 'total',
                    fecha: null,
                    iniDia: null,
                    finDia: null,
                    titulo: null,
                    paro: [],
                    maquinas: [],
                    procesos: [],
                    norma: [],
                    Nmaquinas: [],
                    Nprocesos: [],
                    Nnorma: [],
                    update: false
                },
                gLinea: {
                    id: null,
                    borra: null,
                    titulo: null,
                    subtitulo: '',
                    rango: 1,
                    tipo: 'generalMaq',
                    fecIni: null,
                    fecFin: null,
                    maquinas: [],
                    procesos: [],
                    Nmaquinas: [],
                    Nprocesos: [],
                    norma: [],
                    update: false
                },
                gBarra: {
                    id: null,
                    borra: null,
                    titulo: null,
                    subtitulo: '',
                    rango: 1,
                    tipo: 'generalMaq',
                    fecIni: null,
                    fecFin: null,
                    maquinas: [],
                    procesos: [],
                    Nmaquinas: [],
                    Nprocesos: [],
                    norma: [],
                    update: false
                },
                gBaLi: {
                    id: null,
                    borra: null,
                    titulo: null,
                    subIz: '',
                    subDe: '',
                    rango: 1,
                    tipo: 'generalMaq',
                    fecIni: null,
                    fecFin: null,
                    maquinasBar: [],
                    procesosBar: [],
                    maquinasLin: [],
                    procesosLin: [],
                    NmaquinasBar: [],
                    NprocesosBar: [],
                    NmaquinasLin: [],
                    NprocesosLin: [],
                    norma: [],
                    update: false
                }
            }
        },

        mounted() {
            this.global();
        },

        methods: {
            /****************************** datatables ********************************************************/
            //datatable de carga de produccion
            tabla() {
                this.$nextTick(() => {
                    var table = $('#t_repo').DataTable({
                        "language": this.español,
                        "order": [[5, 'asc'],[1, 'asc']],
                        "dom": '<"row"<"col-sm-6 col-md-3"l><"col-sm-6 col-md-6"B><"col-sm-12 col-md-3"f>>'+
                                "<'row'<'col-sm-12'tr>>" +
                                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                        "scrollX": true,
                        "columnDefs": [
                            { "width": "10%", "targets": [1,2,3,4,5,11] },
                            { "width": "7%", "targets": [6,7,8,9,10,14] },
                            { "width": "5%", "targets": [12, 13] }
                        ],
                        //stateSave: true,
                        scrollY:        '40vh',
                        scrollCollapse: true,
                        paging:         false,
                        buttons: [
                            {
                                extend: 'copyHtml5',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
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
                        ],
                        initComplete: function () {
                            this.api().columns().every( function () {
                                var column = this;
                                var select = $('<select class="InputSelect tw-text-gray-900"><option value=""></option></select>')
                                    .appendTo( $(column.footer()).empty() )
                                    .on( 'change', function () {
                                        var val = $.fn.dataTable.util.escapeRegex(
                                            $(this).val()
                                        );

                                        column
                                            .search( val ? '^'+val+'$' : '', true, false )
                                            .draw();
                                    } );

                                column.cells('', column[0]).render('display').sort().unique().each( function ( d, j ) {
                                    var val = $('<div/>').html(d).text();
                                    if(column.search() === '^'+d+'$'){
                                        select.append( '<option value="' + val + '">' + val + '</option>' );
                                    } else {
                                        select.append( '<option value="' + val + '">' + val + '</option>' );
                                    }
                                    //select.append( '<option value="'+d+'">'+d+'</option>' )
                                } );
                            } );
                        }
                    })

                })
            },
            //datatable de paros
            tablaParo() {
                this.$nextTick(() => {
                    var table = $('#t_repoPar').DataTable({
                        "language": this.español,
                        "order": [[0, 'desc'],[1, 'asc']],
                        "dom": '<"row"<"col-sm-6 col-md-3"l><"col-sm-6 col-md-6"B><"col-sm-12 col-md-3"f>>'+
                                "<'row'<'col-sm-12'tr>>" +
                                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                        "columnDefs": [
                            { "width": "10%", "targets": [0,2,4,5,6,7,8,9,10,11,12] },
                            { "width": "2%", "targets": [1,3] }
                        ],
                        "scrollX": true,
                        //stateSave: true,
                        scrollY:        '40vh',
                        scrollCollapse: true,
                        paging:         false,
                        buttons: [
                            {
                                extend: 'copyHtml5',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
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
                        ],
                        initComplete: function () {
                            this.api().columns().every( function () {
                                var column = this;
                                var select = $('<select class="InputSelect tw-text-gray-900"><option value=""></option></select>')
                                    .appendTo( $(column.footer()).empty() )
                                    .on( 'change', function () {
                                        var val = $.fn.dataTable.util.escapeRegex(
                                            $(this).val()
                                        );

                                        column
                                            .search( val ? '^'+val+'$' : '', true, false )
                                            .draw();
                                    } );

                                column.cells('', column[0]).render('display').sort().unique().each( function ( d, j ) {
                                    var val = $('<div/>').html(d).text();
                                    if(column.search() === '^'+d+'$'){
                                        select.append( '<option value="' + val + '" selected="selected">' + val + '</option>' );
                                    } else {
                                        select.append( '<option value="' + val + '">' + val + '</option>' );
                                    }
                                    //select.append( '<option value="'+d+'">'+d+'</option>' )
                                } );
                            } );
                        }
                    })


                    /* $('#t_repoPar tfoot th').each( function () {
                        var title = $(this).text();
                        $(this).html( '<input type="text" class="InputSelect tw-text-gray-900" placeholder="'+title+'" />' );
                    } );
                    initComplete: function () {
                        // Apply the search
                        this.api().columns().every( function () {
                            var that = this;

                            $( 'input', this.footer() ).on( 'keyup change clear', function () {
                                if ( that.search() !== this.value ) {
                                    that
                                        .search( this.value )
                                        .draw();
                                }
                            } );
                        } );
                    } */


                })
            },
            /***************************** Carga Masiva ************************************/
            async carMasi(){
                this.vMasi = false;
                const form = this.docu;
                await this.$inertia.post('/Produccion/CargaExcel', form, {
                    onSuccess: (v) => { this.openModalC(), this.resetC(), this.alertSucces(), this.vMasi = true, this.arrProdu() },
                    onError: (e) => { this.vMasi = true },
                    preserveState: true
                });
            },
            /**************************** Carga Matriz Objetivos *****************************/
            async carMatriObje(){
                let form = this.docu2;
                await this.$inertia.post('/Produccion/impoMatriz', form, {
                    onSuccess: (v) => { this.openModalC(), this.resetC(), this.alertSucces(), this.arrProdu() },
                    onError: (e) => { this.vMasi = true },
                    preserveState: true
                });
                /* await axios.post('/Produccion/impoMatriz', this.docu)
                .then(eve => {console.log(eve.data)})
                .catch(err => {console.log(err.response.data.errors)}); */
            },
            /***************************** Calculos ******************************************/
            async calcula(form) {
                if (this.calcu != '' & this.S_Area != '') {
                    this.limpPro = false;
                    this.vCal = false;
                    //console.log(this.form)
                    //console.log(moment(this.form.fecha).isDST())

                    await this.$inertia.post('/Produccion/Calcula', form, {
                        onSuccess: (v) => {
                            this.alertSucces(),
                            this.vCal = true,
                            //this.reset(),
                            this.arrProdu()
                            //console.log(v)
                        },
                        onError: (e) => {
                            this.vCal = true
                        },
                        preserveState: true
                    });
                }else{
                    this.calcu == '' ? Swal.fire('Por favor selecciona una fecha') : '';
                    this.S_Area == '' ? Swal.fire('Por favor selecciona un departamento') : '';
                }

            },
            cambioFechas() {
                if (this.FoFiltro.iniDia) {
                    this.form.fecha = this.FoFiltro.iniDia
                    this.form.depa = this.S_Area;
                }
                if(this.S_Area == 7){
                    if (moment(this.form.fecha).isDST()) {
                        this.form.hoy = this.form.fecha+'T09:10';
                        this.form.mañana = moment(this.form.hoy).add(1, 'days').format("YYYY-MM-DD[T]HH:mm")
                        //console.log(moment(this.form.mañana).isDST())
                        if (moment(this.form.mañana).isDST() == false) {
                            this.form.mañana = moment(this.form.mañana).subtract(1, 'hours').format("YYYY-MM-DD[T]HH:mm")
                            //console.log(this.form.mañana)
                        }
                    }else{
                        this.form.hoy = this.form.fecha+'T08:10';
                        this.form.mañana = moment(this.form.hoy).add(1, 'days').format("YYYY-MM-DD[T]HH:mm")
                        //console.log(moment(this.form.mañana).isDST())
                        if (moment(this.form.mañana).isDST() == true) {
                            //console.log(this.form.mañana)
                            this.form.mañana = moment(this.form.mañana).add(1, 'hours').format("YYYY-MM-DD[T]HH:mm")
                            //console.log(this.form.mañana)
                        }
                    }
                }else{
                    this.form.hoy = this.form.fecha+'T07:00';
                    this.form.mañana = moment(this.form.hoy).add(1, 'days').format("YYYY-MM-DD[T]HH:mm")
                }
                //console.log(this.form)
            },
            formatoMexico (number){
                const exp = /(\d)(?=(\d{3})+(?!\d))/g;
                const rep = '$1,';
                let arr = number.toString().split('.');
                arr[0] = arr[0].replace(exp,rep);
                return arr[1] ? arr.join('.'): arr[0];
            },
            //reset de imputs
            reset() {
                this.form = {
                    fecha: null,
                    hoy: null,
                    mañana: null,
                    depa: this.S_Area
                }
            },
            /****************************** Funciones generales ****************************/
            formatoMexico (number){
                const exp = /(\d)(?=(\d{3})+(?!\d))/g;
                const rep = '$1,';
                let arr = number.toString().split('.');
                arr[0] = arr[0].replace(exp,rep);
                return arr[1] ? arr.join('.'): arr[0];
            },
            limiteFecha(){
                var inpDia = moment(this.FoFiltro.iniDia);
                var Dhoy = moment()
                var dife = Dhoy.diff(inpDia, 'days');
                return dife <= 3;
            },
            global(){
                this.descarga = this.URLactual.host != '192.168.11.3' ? this.path+'Archivos/FormatosExcel/Carga_Masiva.xlsx' : 'http://192.168.11.3/storage/Archivos/FormatosExcel/Carga_Masiva.xlsx';
                this.descarga2 = this.URLactual.host != '192.168.11.3' ? this.path+'Archivos/FormatosExcel/Carga_Masiva_OE.xlsx' : 'http://192.168.11.3/storage/Archivos/FormatosExcel/Carga_Masiva_OE.xlsx';
                if (this.usuario.dep_pers.length == 0) {
                    this.S_Area = 7;
                }else{
                    //Asigna el primer departamento
                    this.S_Area = this.usuario.dep_pers[0].departamento_id;
                    this.usuario.dep_pers.forEach(v => {
                        if (v.departamento_id = this.S_Area) {
                            //asigna
                            this.idDep = v.id;
                        }
                    })
                }
            },
            imgGrafi(data){
                //var URLactual = window.location;
                var nuPath = this.URLactual.host != '192.168.11.3' ? this.path : 'http://192.168.11.3/storage/';

                console.log(nuPath);
                console.log(this.URLactual.host)

                var img = nuPath+'Archivos/Pastel.png'
                if (data == 'Pastel') {
                    img = nuPath+'Archivos/Pastel.png';
                }else if(data == 'Linea'){
                    img = nuPath+'Archivos/Linea.png';
                }else if(data == 'Barra'){
                    img = nuPath+'Archivos/Barra.png';
                }else{
                    img = nuPath+'Archivos/Combinado.png';
                }
                return img;
            },
            asigGrafi(data){
                const tip = this.graTipo.find(el => el == data.graTipo)
                //Asigna los tipos de graficas para mostrarlos
                if (tip == undefined) {
                    this.graTipo.push(data.graTipo)
                }
                //Asigna la informacion general de cada grafica
                if (data.graTipo == "Pastel") {
                    this.gPie.id = data.id;
                    this.gPie.titulo = data.titulo;
                    this.gPie.propa = data.propa;
                    this.gPie.rango = data.rango;
                    this.gPie.tipo = data.tipo;
                    this.gPie.tipoParo = data.tipoParo;
                    this.gPie.update = true
                    //Asigana el tipo de dato
                    data.grafi_arrs.forEach(eve => {
                        //console.log(eve);
                        if (eve.maq_pro_id != null) {
                            this.gPie.maquinas.push(eve.maq_pro_id)
                            this.gPie.Nmaquinas.push(eve.maq_pro_id)
                        }
                        if (eve.proceso_id != null) {
                            this.gPie.procesos.push(eve.proceso_id)
                            this.gPie.Nprocesos.push(eve.proceso_id)
                        }
                        if (eve.material_id != null) {
                            this.gPie.norma.push(eve.material_id)
                            this.gPie.Nnorma.push(eve.material_id)
                        }
                    })
                }else if (data.graTipo == "Linea"){
                    this.gLinea.id = data.id;
                    this.gLinea.titulo = data.titulo;
                    this.gLinea.subtitulo = data.subtitulo;
                    this.gLinea.rango = data.rango;
                    this.gLinea.tipo = data.tipo;
                    this.gLinea.update = true
                    //Asigana el tipo de dato
                    data.grafi_arrs.forEach(eve => {
                        //console.log(eve);
                        if (eve.maq_pro_id != null) {
                            this.gLinea.maquinas.push(eve.maq_pro_id)
                            this.gLinea.Nmaquinas.push(eve.maq_pro_id)
                        }
                        if (eve.proceso_id != null) {
                            this.gLinea.procesos.push(eve.proceso_id)
                            this.gLinea.Nprocesos.push(eve.proceso_id)
                        }
                    })
                }else if (data.graTipo == "Barra") {
                    this.gBarra.id = data.id;
                    this.gBarra.titulo = data.titulo;
                    this.gBarra.subtitulo = data.subtitulo;
                    this.gBarra.rango = data.rango;
                    this.gBarra.tipo = data.tipo;
                    this.gBarra.update = true
                    //Asigana el tipo de dato
                    data.grafi_arrs.forEach(eve => {
                        //console.log(eve);
                        if (eve.maq_pro_id != null) {
                            this.gBarra.maquinas.push(eve.maq_pro_id)
                            this.gBarra.Nmaquinas.push(eve.maq_pro_id)
                        }
                        if (eve.proceso_id != null) {
                            this.gBarra.procesos.push(eve.proceso_id)
                            this.gBarra.Nprocesos.push(eve.proceso_id)
                        }
                    })
                }else{
                    this.gBaLi.id = data.id;
                    this.gBaLi.titulo = data.titulo;
                    this.gBaLi.subDe = data.subDe;
                    this.gBaLi.subIz = data.subIz;
                    this.gBaLi.rango = data.rango;
                    this.gBaLi.tipo = data.tipo;
                    this.gBaLi.update = true
                    //Asigana el tipo de dato
                    data.grafi_arrs.forEach(eve => {
                        //console.log(eve);
                        if (eve.maq_pro_id != null) {
                            this.gBaLi.maquinasBar.push(eve.maq_pro_id)
                            this.gBaLi.NmaquinasBar.push(eve.maq_pro_id)
                        }
                        if (eve.maq_pro_linea_id != null) {
                            this.gBaLi.maquinasLin.push(eve.maq_pro_linea_id)
                            this.gBaLi.NmaquinasLin.push(eve.maq_pro_linea_id)
                        }
                        if (eve.proceso_id != null) {
                            this.gBaLi.procesosBar.push(eve.proceso_id)
                            this.gBaLi.NprocesosBar.push(eve.proceso_id)
                        }
                        if (eve.proceso_linea_id != null) {
                            this.gBaLi.procesosLin.push(eve.proceso_linea_id)
                            this.gBaLi.NprocesosLin.push(eve.proceso_linea_id)
                        }
                    })
                }
                //console.log(data)
            },
            //muestra la utima fecha del paro
            nuFin(ar){
                //Si es es mes o semana
                if (ar.iniFecha == 'N/A') {
                    return 'N/A'
                }
                //si es un sub paro
                /* if (ar.paros_carga_id != null) {
                    //busca el id del paro princial
                    var busca = this.paros.find(e => e.id == ar.paros_carga_id);
                    //en caso de que no este el dato entonces pone la fecha generada
                    var data = busca == null ? ar.finFecha : busca.sub_paro[0].finFecha;
                    //consulta en caso de que aun no cierre el paro
                    var fecha = data == null ? moment().format("YYYY-MM-DD HH:mm:ss") : data;
                    return fecha;
                } */
                //si es uno  principal
                if (ar.sub_paro.length != 0) {
                    return ar.sub_paro[0].finFecha == null ? moment().format("YYYY-MM-DD HH:mm:ss") : ar.sub_paro[0].finFecha;
                }
                //en caso de que no sea ni subparo o principal
                if(ar.paros_carga_id == null || ar.sub_paro.length == 0){
                    return ar.finFecha == null ? moment().format("YYYY-MM-DD HH:mm:ss") : ar.finFecha;
                }
            },
            //calcula el tiempo
            tiempo(fec){

                var tini = '';
                var tfin = '';
                if (fec.iniFecha == null) {
                    tini = moment();
                    tfin = moment().add(fec.tiempo, 'minutes');
                    //return tfin.from(tini, true) + ' || ' + fec.tiempo+' minutos';
                }else{
                    tini = moment(fec.iniFecha);
                    tfin = fec.finFecha == null ? moment() : moment(fec.finFecha);
                    //return tfin.from(tini, true) + ' || ' +tfin.diff(tini, 'minutes')+' minutos' ;
                }

                return tfin.from(tini, true) + ' || ' +tfin.diff(tini, 'minutes')+' minutos' ;

            },
            /***************************** Modal de carga masiva ********************************************/
            //abrir modal carga masiva
            openModalC(){
                this.chageCloseC();
                this.resetC();
            },
            //abrir o cerrar modal procesos
            chageCloseC(){
                this.showModalC = !this.showModalC
            },
            //reset de file
            resetC(){
                this.docu.file = null;
                this.docu2.file = null
            },
            /***************************** Datos de procesos *******************************************/
            //Limpia los inputs de fechas
            limInputs(val){
                if(val == 1.5){
                    this.FoFiltro.semana = null;
                    this.FoFiltro.mes = null;
                }else if(val == 2){
                    this.FoFiltro.iniDia = null;
                    this.FoFiltro.finDia = null;
                    this.FoFiltro.mes = null;
                    this.horas = '07:00';
                    this.limpPro = true;
                }else if(val == 3){
                    this.FoFiltro.iniDia = null;
                    this.FoFiltro.finDia = null;
                    this.FoFiltro.semana = null;
                    this.horas = '07:00';
                    this.limpPro = true;
                }
                else{
                    this.FoFiltro.iniDia = null;
                    this.FoFiltro.finDia = null;
                    this.FoFiltro.semana = null;
                    this.FoFiltro.mes = null;
                    this.limpPro = true;
                }
                $('#t_repo').DataTable().clear();
            },
            //consulta la produccion para la tabla
            async arrProdu(){
                var datos = {}
                this.recoTabla = [];
                this.vTab = false;

                //input de fecha no nulo
                if(this.FoFiltro.iniDia != null){
                    //consulta el dia
                    if (this.FoFiltro.rango == 1) {
                        var ini = '';
                        var fin = '';
                        if (this.S_Area == 7){
                            if (moment(this.FoFiltro.iniDia).isDST()) {
                                //console.log('horario verano')
                                ini = this.FoFiltro.iniDia+' 09:10:00';
                                fin = moment(ini).add(24, 'hours').format('YYYY-MM-DD HH:mm:ss');
                                if (moment(fin).isDST() == false) {
                                    fin = moment(fin).subtract(1, 'hours').format("YYYY-MM-DD[T]HH:mm")
                                }
                            }else{
                                //console.log('horario invierno')
                                ini = this.FoFiltro.iniDia+' 08:10:00';
                                fin = moment(ini).add(24, 'hours').format('YYYY-MM-DD HH:mm:ss');
                                if (moment(fin).isDST() == true) {
                                    fin = moment(fin).add(1, 'hours').format("YYYY-MM-DD[T]HH:mm")
                                }
                            }
                        }//consulta por rango
                        else{
                            ini = this.FoFiltro.iniDia+' 07:00:00'
                            fin = moment(ini).add(24, 'hours').format('YYYY-MM-DD HH:mm:ss');
                        }

                        //Asigna el dato para la fecha final
                        datos = {'departamento_id': this.S_Area, 'tipo': 'dia', 'iniDia': ini, 'finDia': fin, 'semana': null, 'mes': null }
                    }else{
                        if (this.FoFiltro.iniDia == null) {
                            return Swal.fire('Selecciona la fecha de inicio.')
                        }
                        if (this.FoFiltro.finDia == null) {
                            return Swal.fire('Selecciona la fecha final.')
                        }
                        datos = {'departamento_id': this.S_Area, 'tipo': 'rango', 'iniDia': this.FoFiltro.iniDia, 'finDia': this.FoFiltro.finDia, 'semana': null, 'mes': null}
                    }
                }
                //input semana no nulo
                else if (this.FoFiltro.semana != null) {
                    datos = {'departamento_id': this.S_Area, 'tipo': 'semana', 'iniDia': null, 'finDia': null, 'semana': this.FoFiltro.semana, 'mes': null }
                }//input mes no nulo
                else if (this.FoFiltro.mes != null) {
                    datos = {'departamento_id': this.S_Area, 'tipo': 'mes', 'iniDia': null, 'finDia': null, 'semana': null, 'mes': this.FoFiltro.mes }
                }


                //asigna el recorrido
                let promesa = await axios.post('ReportesPro/ConPro', datos)
                this.recoTabla = promesa.data
                //recorre la tabla
                $('#t_repo').DataTable().clear();
                $('#t_repo').DataTable().destroy();
                this.tabla()
                this.vTab = true;
            },
            //consulta de paros
            async arrParo(){
                var datos = {}
                this.recoTablaParo = [];
                this.vTab = false;

                //input de fecha no nulo
                if(this.FoFiltro.iniDia != null){
                    //consulta el dia
                    if (this.FoFiltro.rango == 1) {
                        var ini = '';
                        var fin = '';
                        if (this.S_Area == 7){
                            if (moment(this.FoFiltro.iniDia).isDST()) {
                                ini = this.FoFiltro.iniDia+' 09:10:00';
                            }else{
                                ini = this.FoFiltro.iniDia+' 08:10:00';
                            }
                        }//consulta por rango
                        else{
                            ini = this.FoFiltro.iniDia+' 07:00:00'
                        }

                        //Asigna el dato para la fecha final
                        fin = moment(ini).add(24, 'hours').format('YYYY-MM-DD HH:mm:ss');
                        datos = {'departamento_id': this.S_Area, 'tipo': 'dia', 'iniDia': ini, 'finDia': fin, 'semana': null, 'mes': null }
                    }else{
                        if (this.FoFiltro.iniDia == null) {
                            return Swal.fire('Selecciona la fecha de inicio.')
                        }
                        if (this.FoFiltro.finDia == null) {
                            return Swal.fire('Selecciona la fecha final.')
                        }
                        datos = {'departamento_id': this.S_Area, 'tipo': 'rango', 'iniDia': this.FoFiltro.iniDia, 'finDia': this.FoFiltro.finDia, 'semana': null, 'mes': null}
                    }
                }
                //input semana no nulo
                else if (this.FoFiltro.semana != null) {
                    this.vTab = true;
                    return 'ya';
                    //datos = {'departamento_id': this.S_Area, 'tipo': 'semana', 'iniDia': null, 'finDia': null, 'semana': this.FoFiltro.semana, 'mes': null }
                }
                //input mes no nulo
                else if (this.FoFiltro.mes != null) {
                    datos = {'departamento_id': this.S_Area, 'tipo': 'mes', 'iniDia': null, 'finDia': null, 'semana': null, 'mes': this.FoFiltro.mes }
                }

                //asigna el recorrido
                let promesa = await axios.post('ReportesPro/ConParo', datos)
                this.recoTablaParo = promesa.data
                //Limpia el datatables
                $('#t_repoPar').DataTable().clear();
                $('#t_repoPar').DataTable().destroy();
                this.tablaParo();


                this.vTab = true;
            },
            //Eliminar produccion masiva
            eliminaMasiva(data){
                //console.log(data[0]);
                Swal.fire({
                    title: '¿Estás seguro de querer eliminar estos Registros?',
                    text: "¡Si se eliminan no se podrán revertir!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                        'Eliminadó!',
                        '¡Los registro se eliminaron correctamente!',
                        'success'
                        )
                        data._method = 'DELETE';
                        this.limpPro = false;
                        this.$inertia.post('/Produccion/ReportesPro/' + data.elimiMasi[0], data, {
                            onSuccess: () => { this.arrProdu(), this.alertDelete(), this.deli.elimiMasi = [] },
                            onError: () => {},
                            preserveState: true
                        });
                    }
                })
            },
            /**************************** Acciones de la carga ***********************************************/
            //Abrir modal
            openModalCar(){
                this.changeCloseCar();
                this.resetCar();
            },
            //eliminar carga
            deleteCar(data){
                //console.log(data)
                Swal.fire({
                    title: '¿Estás seguro de querer eliminar este Registro?',
                    text: "¡Si se elimina no se podrá revertir!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                        'Eliminadó!',
                        '¡El registro se eliminó correctamente!',
                        'success'
                        )
                        data._method = 'DELETE';
                        this.$inertia.post('/Produccion/Carga/' + data.id, data, {
                            onSuccess: () => { this.alertDelete(), this.limInputs('00') }, onError: () => {}, preserveState: true
                        });
                    }
                })
            },
            //abrir o cerrar modal para carga de datos
            changeCloseCar(){
                this.showModalCar = !this.showModalCar
            },
            //reset de carga
            resetCar(){
                this.carga.id = null,
                this.carga.idemp = null,
                this.carga.nomOpe = null,
                this.carga.fecha = null,
                this.carga.turno = null,
                this.carga.equipo = null,
                this.carga.norma = null,
                this.carga.clave_id = null,
                this.carga.partida = null,
                this.carga.valor = null,
                this.carga.notas = null
            },
            //editar carga
            editCar(data){
                this.openModalCar();
                this.proc_prin = data.proceso.proceso_id;
                this.carga.id = data.id;
                this.carga.idemp = data.dep_perf.perfiles.IdEmp;
                this.carga.nomOpe = data.dep_perf.perfiles.Nombre+' '+data.dep_perf.perfiles.ApPat+' '+data.dep_perf.perfiles.ApMat;
                this.carga.fecha = moment(data.fecha).format('YYYY-MM-DD[T]HH:mm:ss');
                this.carga.turno = data.turno.nomtur;
                this.carga.equipo = data.equipo.nombre;
                this.carga.norma = data.norma;
                this.carga.clave_id = `${data.clave_id}`;
                this.carga.partida = data.partida;
                this.carga.valor = data.valor;
                this.carga.proceso_id = data.proceso_id;
                this.carga.maq_pro_id = data.maq_pro_id;
                this.carga.nota = '';
                this.nAnte = data.notas.length == 0 ? '' : `<label class="tw-text-base tw-w-full tw-text-black">Fecha: ${data.notas[0].fecha}</label><label class="tw-text-base tw-w-full tw-text-black tw-capitalize"> ${data.notas[0].nota}</label>`;
            },
            async updateCar(data){
                this.limpPro = false;
                await this.$inertia.put('/Produccion/CarNor/' + data.id, data, {
                    onSuccess: (v) => {
                        this.resetCar(),
                        this.alertSucces(),
                        this.changeCloseCar(),
                        this.arrProdu()
                        //this.limInputs('00')
                    },
                    onError: (e) => { },
                    preserveState: true
                });
            },
            //Eliminar produccion masiva
            eliminaMasiva(data){
                //console.log(data[0]);
                Swal.fire({
                    title: '¿Estás seguro de querer eliminar estos Registros?',
                    text: "¡Si se eliminan no se podrán revertir!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                        'Eliminadó!',
                        '¡Los registro se eliminaron correctamente!',
                        'success'
                        )
                        data._method = 'DELETE';
                        this.limpPro = false;
                        this.$inertia.post('/Produccion/ReportesPro/' + data.elimiMasi[0], data, {
                            onSuccess: () => { this.alertDelete(), this.deli.elimiMasi = []},
                            onError: () => {},
                            preserveState: true
                        });
                    }
                })
            },
            /************************** Grafica de pastel ***************************************************/
            limpiarGrafi(){
                if (this.gPie.rango == 1) {
                    this.gPie.fecha = null
                }else{
                    this.gPie.iniDia = null
                    this.gPie.finDia = null
                }
            },
            limpMater(){
                this.gPie.norma = [];
            },
            /* metodos grafica pastel */
            async GraPaste(data){
                //variables internas
                var inicio = null;
                var fin = null;
                var prpa = null;
                const valor = [];

                //alertas de inputs vacios
                if (this.gPie.rango == 1 & data.fecha == null) {
                    //data.procesos.length <= 0 ? Swal.fire('Por favor selecciona un proceso.') : '';
                    data.fecha == null ? Swal.fire('Por favor selecciona una fecha.') : '';
                    return '';
                }
                if (this.gPie.rango == 2 & (data.iniDia == null | data.finDia == null)) {
                    //data.procesos.length <= 0 ? Swal.fire('Por favor selecciona un proceso.') : '';
                    data.iniDia == null ? Swal.fire('Por favor selecciona la fecha de inicio.') : '';
                    data.finDia == null ? Swal.fire('Por favor selecciona la fecha final.') : '';
                    return '';
                }

                //en caso de que los inputs sean llenados
                if (this.gPie.rango == 1) {
                    inicio = this.FoFiltro.iniDia+' 07:00:00'
                    if (this.S_Area == 7){
                        if (moment(data.fecha).isDST()) {
                            inicio = data.fecha+' 09:00:00';
                        }else{
                            inicio = data.fecha+' 08:00:00';
                        }
                    }
                    //Asigna el dato para la fecha final
                    fin = moment(inicio).add(24, 'hours').format('YYYY-MM-DD hh:mm:ss');

                }else{
                    inicio = data.iniDia;
                    fin = data.finDia;
                }

                //Asignacion de datos a un objeto
                var datos = {'departamento_id': this.S_Area, 'norma': data.norma, 'proceso': data.procesos, 'tipo': data.tipo, 'iniDia': inicio, 'finDia': fin, 'paros': data.paro, 'maquinas': data.maquinas, 'tipoParo': data.tipoParo};

                //consulta
                if (data.propa == 1) {
                    let promesa = await axios.post('ReportesPro/PaiGrafi', datos);
                    prpa = 'Producción';
                    promesa.data.forEach(dat => {
                        let mater = dat.dep_mat == null ? '' : dat.dep_mat.materiales.nommat + ' / ';
                        let part = dat.partida == null ? '' : dat.partida + ' / ';
                        let clave = dat.clave == null ? '' : dat.clave.CVE_ART + ' / ';
                        let equ = dat.equipo_id == null ? '' : dat.equipo.nombre + ' / ';
                        let tur = dat.turno_id == null ? '' : dat.turno.nomtur + ' / ';
                        let cate = dat.categoria == null ? '' : dat.categoria + ' / ';
                        let proce = dat.proceso_id == null ? 'General' : dat.proceso.nompro + ' / ';
                        let maqui = dat.maq_pro_id == null ? '' :dat.maq_pro.maquinas.Nombre + ' / ';
                        valor.push({name: proce, y: parseFloat(dat.valor), mate: mater, parti: part, cl: clave, eq: equ, tr: tur, cat: cate, maq: maqui});
                    })
                }else{
                    let promesa = await axios.post('ReportesPro/PrPaiGrafi', datos);
                    prpa = 'Paros en minutos';
                    promesa.data.forEach(dat => {
                        let proce = dat.proceso_id == null ? 'General' : dat.proceso.nompro + ' / ';
                        let mater = dat.maq_pro_id == null ? '' : dat.maq_pro.maquinas.Nombre + ' / ';
                        let part = dat.paro_id == null ? '' : dat.paros.clave+' - '+dat.paros.descri + ' / ';
                        valor.push({name: proce, y: parseInt(dat.tiempo), mate: mater, parti: part});
                    })
                }


                this.gPie.borra = Highcharts.chart('chart', {
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: this.gPie.titulo
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    plotOptions: {
                        pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name} {point.maq} {point.mate} {point.cat} {point.tr} {point.eq} {point.parti} {point.cl}</b>: {point.y} - {point.percentage:.1f}%'
                        }
                        }
                    },
                    series: [{
                        name: prpa,
                        colorByPoint: true,
                        data: valor
                    }]
                });
                $('#grafica').removeClass("show")
            },
            resetPastel(){
                if (this.gPie.borra != null) {
                    this.gPie.borra.destroy();
                }
                this.gPie.id = null
                this.gPie.borra = null
                this.gPie.rango = 1;
                this.gPie.propa = 1;
                this.gPie.tipo = 'generalMaq';
                this.gPie.tipoParo = 'total';
                this.gPie.fecha = null;
                this.gPie.iniDia = null;
                this.gPie.finDia = null;
                this.gPie.titulo = null;
                this.gPie.paro = [];
                this.gPie.maquinas = [];
                this.gPie.procesos = [];
                this.gPie.norma = [];
                this.gPie.Nmaquinas = [];
                this.gPie.Nprocesos = [];
                this.gPie.Nnorma = [];
                this.gPie.update = false
            },
            async savePaste(datos){
                if (datos.borra != null) {
                    datos.borra.destroy();
                }
                datos.borra = null;
                datos.graTipo = "Pastel";
                datos.departamento_id = this.S_Area;

                if (datos.propa == "2") {
                    datos.procesos = [];
                    datos.norma = [];
                }else{
                    if (datos.tipo == "generalTot") {
                        datos.maquinas = [];
                        datos.norma = [];
                    }else if(datos.tipo == "norma") {
                        datos.procesos = [];
                    }else{
                        datos.procesos = [];
                        datos.norma = [];
                    }
                }
                if (datos.titulo) {
                    await axios.post('ReportesPro/SaveGra', datos).then(resp => {this.alertSucces()})
                }else{
                    Swal.fire('Es necesario agregar un titulo')
                }
                //console.log(d)
            },
            async updatePaste(datos){
                if (datos.borra != null) {
                    datos.borra.destroy();
                }
                datos.borra = null;
                if (datos.propa == "2") {
                    datos.procesos = [];
                    datos.norma = [];
                }else{
                    if (datos.tipo == "generalTot") {
                        datos.maquinas = [];
                        datos.norma = [];
                    }else if(datos.tipo == "norma") {
                        datos.procesos = [];
                    }else{
                        datos.procesos = [];
                        datos.norma = [];
                    }
                }
                //console.log(datos)
                await axios.post('ReportesPro/UpdateGrafi', datos).then(resp => {this.alertSucces()})
            },
            /******************************************* Grafica en linea *****************************************************/
            lipiaLinea(dat){
                this.gLinea.fecIni = null;
                this.gLinea.fecFin = null;
                if (dat == 1) {
                    //console.log('es diario')
                }else if(dat == 2){
                    //console.log('es mes')
                }
                else{
                    this.gLinea.fecIni = moment().format('Y');
                    this.gLinea.fecFin = moment().format('Y');
                }
            },
            /* metodos grafica linea */
            async GraLinea(data){

                var inicio = moment(data.fecIni);
                var fin = moment(data.fecFin);
                const fechas = [];
                const titFec = [];
                var name = '';
                var dat = [];
                const serie = [];

                //alertas de inputs vacios
                if (data.fecIni == null || data.fecFin == null) {
                    data.finIni == null ? Swal.fire('Por favor selecciona la fecha de inicio.') : '';
                    data.fecFin == null ? Swal.fire('Por favor selecciona la fecha final.') : '';
                    return '';
                }

                //Consulta a las graficas
                var datos = {'departamento_id': this.S_Area, 'norma': data.norma, 'proceso': data.procesos, 'rango': data.rango, 'tipo': data.tipo, 'iniDia': data.fecIni, 'finDia': data.fecFin, 'maquinas': data.maquinas};

                let promesa = await axios.post('ReportesPro/LinGrafi', datos);

                //recorrido para fechas
                if (data.rango == 1) {
                    while (inicio.isSameOrBefore(fin, 'days')) {
                        titFec.push(inicio.format('YYYY-MM-DD'))
                        fechas.push(inicio.format('YYYY-MM-DD'))
                        inicio.add(1, 'days')
                    }
                }else if(data.rango == 2){
                    while (inicio.isSameOrBefore(fin, 'month')) {
                        titFec.push(inicio.format('MMMM-YYYY'))
                        fechas.push(inicio.format('YYYY-MM'))
                        inicio.add(1, 'month')
                    }
                }else if(data.rango == 3){
                    while (inicio.isSameOrBefore(fin, 'week')) {
                        titFec.push('Semana '+inicio.format('WW-YYYY'))
                        fechas.push(inicio.format('GGGG-[W]WW'))
                        inicio.add(1, 'week')
                    }
                }else{
                    while (inicio.isSameOrBefore(fin, 'year')) {
                        titFec.push(inicio.format('YYYY'))
                        fechas.push(inicio.format('YYYY'))
                        inicio.add(1, 'year')
                    }
                }

                //Manejo de tipo entre maquinas y procesos
                if (data.tipo == 'generalMaq') {
                    data.maquinas.forEach(proce => {
                        dat = [];
                        fechas.forEach(tiemp => {
                            let ver = promesa.data.find(tiem => tiem.fec == tiemp & tiem.maq_pro_id == proce )
                            if (ver) {
                                name = ver.proceso.nompro+': '+ver.maq_pro.maquinas.Nombre;
                                dat.push(parseFloat(ver.valor))
                            }else{
                                dat.push(null)
                            }
                        })
                        serie.push({name: name, data: dat})
                    })
                }else{
                    data.procesos.forEach(proce => {
                        dat = [];
                        fechas.forEach(tiemp => {
                            let ver = promesa.data.find(tiem => tiem.fec == tiemp & tiem.proceso_id == proce )
                            if (ver) {
                                name = ver.proceso.nompro;
                                dat.push(parseFloat(ver.valor))
                            }else{
                                dat.push(null)
                            }
                        })
                        serie.push({name: name, data: dat})
                    })
                }

                this.gLinea.borra = Highcharts.chart('chart1', {

                    chart: {
                        zoomType: 'x'
                    },

                    title: {
                        text: data.titulo
                    },

                    subtitle: {
                        text: data.subtitulo
                    },

                    yAxis: {
                        title: {
                        text: 'Producción'
                        }
                    },

                    xAxis: {
                        categories: titFec,
                        accessibility: {
                            rangeDescription: 'Range: '
                        }
                    },

                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle'
                    },

                    series: serie,

                    responsive: {
                        rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                            }
                        }
                        }]
                    }

                });
                $('#grafica').removeClass("show")

            },
            resetLinea(){
                if (this.gLinea.borra != null) {
                    this.gLinea.borra.destroy();
                }
                this.gLinea.id = null;
                this.gLinea.borra = null;
                this.gLinea.titulo = null;
                this.gLinea.subtitulo = '';
                this.gLinea.rango = 1;
                this.gLinea.tipo = 'generalMaq';
                this.gLinea.fecIni = null;
                this.gLinea.fecFin = null;
                this.gLinea.maquinas = [];
                this.gLinea.procesos = [];
                this.gLinea.norma = [];
                this.gLinea.Nmaquinas = [];
                this.gLinea.Nprocesos = [];
                this.gLinea.update = false
            },
            async saveLine(datos, titu){
                if (datos.borra != null) {
                    datos.borra.destroy();
                }
                datos.borra = null;
                datos.graTipo = titu
                datos.departamento_id = this.S_Area;

                if (datos.tipo == "generalTot") {
                    datos.maquinas = [];
                }else{
                    datos.procesos = [];
                }
                if (datos.titulo) {
                    await axios.post('ReportesPro/SaveGra', datos).then(resp => {this.alertSucces()})
                }else{
                    Swal.fire('Es necesario agregar un titulo')
                }
            },
            async updateLine(datos){
                if (datos.borra != null) {
                    datos.borra.destroy();
                }
                datos.borra = null;
                if (datos.tipo == "generalTot") {
                    datos.maquinas = [];
                }else{
                    datos.procesos = [];
                }

                await axios.post('ReportesPro/UpdateGrafi', datos).then(resp => {this.alertSucces()})
            },
            /****************************************** Grafica de barras **********************************************/
            limpiaBarra(dat){
                this.gBarra.fecIni = null;
                this.gBarra.fecFin = null;
                if (dat == 1) {
                    //console.log('es diario')
                }else if(dat == 2){
                    //console.log('es mes')
                }
                else{
                    this.gBarra.fecIni = moment().format('Y');
                    this.gBarra.fecFin = moment().format('Y');
                }
            },
            /* metodos grafica barra */
            async GraBarra(data){
                var inicio = moment(data.fecIni);
                var fin = moment(data.fecFin);
                const fechas = [];
                const titFec = [];
                var name = '';
                var dat = [];
                const serie = [];

                //alertas de inputs vacios
                if (data.fecIni == null || data.fecFin == null) {
                    data.finIni == null ? Swal.fire('Por favor selecciona la fecha de inicio.') : '';
                    data.fecFin == null ? Swal.fire('Por favor selecciona la fecha final.') : '';
                    return '';
                }

                //Consulta a las graficas
                var datos = {'departamento_id': this.S_Area, 'norma': data.norma, 'proceso': data.procesos, 'rango': data.rango, 'tipo': data.tipo, 'iniDia': data.fecIni, 'finDia': data.fecFin, 'maquinas': data.maquinas};

                let promesa = await axios.post('ReportesPro/LinGrafi', datos);

                //recorrido para fechas
                if (data.rango == 1) {
                    while (inicio.isSameOrBefore(fin, 'days')) {
                        titFec.push(inicio.format('YYYY-MM-DD'))
                        fechas.push(inicio.format('YYYY-MM-DD'))
                        inicio.add(1, 'days')
                    }
                }else if(data.rango == 2){
                    while (inicio.isSameOrBefore(fin, 'month')) {
                        titFec.push(inicio.format('MMMM-YYYY'))
                        fechas.push(inicio.format('YYYY-MM'))
                        inicio.add(1, 'month')
                    }
                }else if(data.rango == 3){
                    while (inicio.isSameOrBefore(fin, 'week')) {
                        titFec.push('Semana '+inicio.format('WW-YYYY'))
                        fechas.push(inicio.format('GGGG-[W]WW'))
                        inicio.add(1, 'week')
                    }
                }else{
                    while (inicio.isSameOrBefore(fin, 'year')) {
                        titFec.push(inicio.format('YYYY'))
                        fechas.push(inicio.format('YYYY'))
                        inicio.add(1, 'year')
                    }
                }

                //Manejo de tipo entre maquinas y procesos
                if (data.tipo == 'generalMaq') {
                    data.maquinas.forEach(proce => {
                        dat = [];
                        fechas.forEach(tiemp => {
                            let ver = promesa.data.find(tiem => tiem.fec == tiemp & tiem.maq_pro_id == proce )
                            if (ver) {
                                name = ver.proceso.nompro+': '+ver.maq_pro.maquinas.Nombre;
                                dat.push(parseFloat(ver.valor))
                            }else{
                                dat.push(null)
                            }
                        })
                        serie.push({name: name, data: dat})
                    })
                }else{
                    data.procesos.forEach(proce => {
                        dat = [];
                        fechas.forEach(tiemp => {
                            let ver = promesa.data.find(tiem => tiem.fec == tiemp & tiem.proceso_id == proce )
                            if (ver) {
                                name = ver.proceso.nompro;
                                dat.push(parseFloat(ver.valor))
                            }else{
                                dat.push(null)
                            }
                        })
                        serie.push({name: name, data: dat})
                    })
                }

                this.gBarra.borra = Highcharts.chart('chart2', {
                    chart: {
                        type: 'column',
                        zoomType: 'x'
                    },
                    title: {
                        text: this.gBarra.titulo
                    },
                    subtitle: {
                        text: this.gBarra.subtitulo
                    },
                    xAxis: {
                        categories: titFec,
                        crosshair: true
                    },
                    yAxis: {
                        title: {
                        text: 'Producción'
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                        }
                    },
                    series: serie
                });
                $('#grafica').removeClass("show")
            },
            resetBarra(){
                if (this.gBarra.borra != null) {
                    this.gBarra.borra.destroy();
                }
                this.gBarra.id = null;
                this.gBarra.borra = null;
                this.gBarra.titulo = null;
                this.gBarra.subtitulo = '';
                this.gBarra.rango = 1;
                this.gBarra.tipo = 'generalMaq';
                this.gBarra.fecIni = null;
                this.gBarra.fecFin = null;
                this.gBarra.maquinas = [];
                this.gBarra.procesos = [];
                this.gBarra.norma = [];
                this.gBarra.Nmaquinas = [];
                this.gBarra.Nprocesos = [];
                this.gBarra.update = false
            },
            /***************************************** Grafica combinada **********************************************/
            limpiaCombi(dat){
                this.gBaLi.fecIni = null;
                this.gBaLi.fecFin = null;
                if (dat == 1) {
                    //console.log('es diario')
                }else if(dat == 2){
                    //console.log('es mes')
                }
                else{
                    this.gBaLi.fecIni = moment().format('Y');
                    this.gBaLi.fecFin = moment().format('Y');
                }
            },
            /* metodo grafica combinada */
            async GraBaLi(data){
                var inicio = moment(data.fecIni);
                var fin = moment(data.fecFin);
                const fechas = [];
                const titFec = [];
                var name = '';
                var dat = [];
                const serie = [];
                var dire = 'ReportesPro/PaiGrafiRan';

                //recorrido para fechas
                if (data.rango == 1) {
                    while (inicio.isSameOrBefore(fin, 'days')) {
                        titFec.push(inicio.format('YYYY-MM-DD'))
                        fechas.push(inicio.format('YYYY-MM-DD'))
                        inicio.add(1, 'days')
                    }
                    dire = 'ReportesPro/PaiGrafi';
                }else if(data.rango == 2){
                    while (inicio.isSameOrBefore(fin, 'month')) {
                        titFec.push(inicio.format('MMMM-YYYY'))
                        fechas.push(inicio.format('YYYY-MM'))
                        inicio.add(1, 'month')
                    }
                }else if(data.rango == 3){
                    while (inicio.isSameOrBefore(fin, 'week')) {
                        titFec.push('Semana '+inicio.format('WW-YYYY'))
                        fechas.push(inicio.format('GGGG-[W]WW'))
                        inicio.add(1, 'week')
                    }
                }else{
                    while (inicio.isSameOrBefore(fin, 'year')) {
                        titFec.push(inicio.format('YYYY'))
                        fechas.push(inicio.format('YYYY'))
                        inicio.add(1, 'year')
                    }
                }

                //Consulta a las graficas
                var datosBa = {'departamento_id': this.S_Area, 'norma': data.norma, 'proceso': data.procesosBar, 'rango': data.rango, 'tipo': data.tipo, 'iniDia': data.fecIni, 'finDia': data.fecFin, 'maquinas': data.maquinasBar};

                //Consulta a las graficas
                var datosLin = {'departamento_id': this.S_Area, 'norma': data.norma, 'proceso': data.procesosLin, 'rango': data.rango, 'tipo': data.tipo, 'iniDia': data.fecIni, 'finDia': data.fecFin, 'maquinas': data.maquinasLin};

                let promesaBa = await axios.post('ReportesPro/LinGrafi', datosBa);

                let promesaLin = await axios.post('ReportesPro/LinGrafi', datosLin);


                //Manejo de tipo entre maquinas y procesos
                if (data.tipo == 'generalMaq') {
                    //Recorrido de barra
                    data.maquinasBar.forEach(proce => {
                        dat = [];
                        fechas.forEach(tiemp => {
                            let ver = promesaBa.data.find(tiem => tiem.fec == tiemp & tiem.maq_pro_id == proce )
                            if (ver) {
                                name = ver.proceso.nompro+': '+ver.maq_pro.maquinas.Nombre;
                                dat.push(parseFloat(ver.valor))
                            }else{
                                dat.push(null)
                            }
                        })
                        serie.push({type: 'column', name: name, yAxis: 1, data: dat})
                    })

                    //Recorrido de linea
                    data.maquinasLin.forEach(proce => {
                        dat = [];
                        fechas.forEach(tiemp => {
                            let ver = promesaLin.data.find(tiem => tiem.fec == tiemp & tiem.maq_pro_id == proce )
                            if (ver) {
                                name = ver.proceso.nompro+': '+ver.maq_pro.maquinas.Nombre;
                                dat.push(parseFloat(ver.valor))
                            }else{
                                dat.push(null)
                            }
                        })
                        serie.push({type: 'spline', name: name, data: dat})
                    })

                }else{
                    //Recorrido de barra
                    data.procesosBar.forEach(proce => {
                        dat = [];
                        fechas.forEach(tiemp => {
                            let ver = promesaBa.data.find(tiem => tiem.fec == tiemp & tiem.proceso_id == proce )
                            if (ver) {
                                name = ver.proceso.nompro;
                                dat.push(parseFloat(ver.valor))
                            }else{
                                dat.push(null)
                            }
                        })
                        serie.push({type: 'column', name: name, yAxis: 1, data: dat})
                    })

                    //Recorrido de linea
                    data.procesosLin.forEach(proce => {
                        dat = [];
                        fechas.forEach(tiemp => {
                            let ver = promesaLin.data.find(tiem => tiem.fec == tiemp & tiem.proceso_id == proce )
                            if (ver) {
                                name = ver.proceso.nompro;
                                dat.push(parseFloat(ver.valor))
                            }else{
                                dat.push(null)
                            }
                        })
                        serie.push({type: 'spline', name: name, data: dat})
                    })
                }

                let promesaPas = await axios.post(dire, datosBa);
                var dtPas = [];

                promesaPas.data.forEach(dat => {
                    let mater = dat.dep_mat == null ? '' : dat.dep_mat.materiales.nommat + ' / ';
                    let part = dat.partida == null ? '' : dat.partida + ' / ';
                    let clave = dat.clave == null ? '' : dat.clave.CVE_ART + ' / ';
                    let equ = dat.equipo_id == null ? '' : dat.equipo.nombre + ' / ';
                    let tur = dat.turno_id == null ? '' : dat.turno.nomtur + ' / ';
                    let cate = dat.categoria == null ? '' : dat.categoria + ' / ';
                    let proce = dat.proceso_id == null ? 'General' : dat.proceso.nompro + ' / ';
                    let maqui = dat.maq_pro_id == null ? '' :dat.maq_pro.maquinas.Nombre + ' / ';
                    let todo = proce+maqui+mater+part+clave+equ+tur+cate;
                    dtPas.push({name: todo, y: parseFloat(dat.valor)});
                })
                serie.push({type: 'pie', name: 'Total', data: dtPas, center: [80, 20], size: 100, showInLegend: false, dataLabels: { enabled: false }})

                this.gBaLi.borra = Highcharts.chart('chart3', {
                    title: {
                        text: this.gBaLi.titulo
                    },
                    xAxis: {
                        categories: titFec,
                        crosshair: true
                    },
                    yAxis: [{ // Secondary yAxis
                        title: {
                            text: data.subDe,
                            style: {
                                color: Highcharts.getOptions().colors[5]
                            }
                        },
                        labels: {
                            format: '{value}',
                            style: {
                                color: Highcharts.getOptions().colors[5]
                            }
                        },
                        opposite: true
                    },{ // Primary yAxis
                        labels: {
                            format: '{value}',
                            style: {
                                color: Highcharts.getOptions().colors[1]
                            }
                        },
                        title: {
                            text: data.subIz,
                            style: {
                                color: Highcharts.getOptions().colors[1]
                            }
                        }
                    }],
                    series: serie
                });

                $('#grafica').removeClass("show")
            },
            resetBaLi(){
                if (this.gBaLi.borra != null) {
                    this.gBaLi.borra.destroy();
                }
                this.gBaLi.id = null;
                this.gBaLi.borra = null;
                this.gBaLi.titulo = null;
                this.gBaLi.subIz = '';
                this.gBaLi.subDe = '';
                this.gBaLi.rango = 1;
                this.gBaLi.tipo = 'generalMaq';
                this.gBaLi.fecIni = null;
                this.gBaLi.fecFin = null;
                this.gBaLi.maquinasBar = [];
                this.gBaLi.procesosBar = [];
                this.gBaLi.maquinasLin = [];
                this.gBaLi.procesosLin = [];
                this.gBaLi.norma = [];
                this.gBaLi.NmaquinasBar = [];
                this.gBaLi.NprocesosBar = [];
                this.gBaLi.NmaquinasLin = [];
                this.gBaLi.NprocesosLin = [];
                this.gBaLi.update = false
            },
            async saveCom(datos, titu){
                if (datos.borra != null) {
                    datos.borra.destroy();
                }
                datos.borra = null;
                datos.graTipo = titu
                datos.departamento_id = this.S_Area;

                if (datos.tipo == "generalTot") {
                    datos.maquinasBar = [];
                    datos.maquinasLin = [];
                }else{
                    datos.procesosLin = [];
                    datos.procesosBar = [];
                }

                if (datos.titulo) {
                    await axios.post('ReportesPro/SaveGra', datos).then(resp => {this.alertSucces()})
                }else{
                    Swal.fire('Es necesario agregar un titulo')
                }
            },
            async updateCom(datos){
                if (datos.borra != null) {
                    datos.borra.destroy();
                }
                datos.borra = null;
                if (datos.tipo == "generalTot") {
                    datos.maquinasBar = [];
                    datos.maquinasLin = [];
                }else{
                    datos.procesosLin = [];
                    datos.procesosBar = [];
                }

                await axios.post('ReportesPro/UpdateGrafi', datos).then(resp => {this.alertSucces()})
            },
            /***************************************** Graficas guardadas ********************************************/
            //consulta las graficas guardadas
            async ConGra() {
                var datos = {'departamento_id': this.S_Area}
                var nuArr = await axios.post('ReportesPro/ConGrafi', datos)
                this.GrafGua = nuArr.data;
            },
            async elimiGrafi(data) {
                //console.log(data)
                await axios.post('ReportesPro/ElimiGra', data).then(eve => {this.ConGra()})
            }
        },

        computed: {
            //Opciones departamento
            opc: function() {
                const ar = [];
                this.depa.forEach(r => {
                    if (r.departamentos) {
                        ar.push({text: r.departamentos.Nombre, value: r.departamentos.id});
                    }else{
                        ar.push({text: r.Nombre, value: r.id});
                        r.sub__departamentos.forEach(rr => {
                            ar.push({text: rr.Nombre, value: rr.id});
                            //console.log(rr.Nombre);
                        })
                    }
                })
                return ar;
            },

            //Opciones Normas
            opcNM: function() {
                const nm = [];
                this.materiales.forEach(ma => {
                    nm.push({id: ma.id, text: ma.materiales.idmat+' - '+ma.materiales.nommat});
                })
                return nm;
            },

            //Opciones Claves
            opcCL: function() {
                const scl = [];
                /* this.form.clave_id = ''; */
                if (this.carga.norma != '') {
                    this.materiales.forEach(cl => {
                        if (this.carga.norma == cl.id) {
                            //console.log(cl.claves)
                            cl.claves.forEach(c => {
                                scl.push({id: c.id, text: c.CVE_ART+ ' - ' + c.DESCR})
                            })
                        }
                    })
                }
                return scl;
            },

            //Opciones procesos principales
            opcPP: function() {
                const ppi = [];
                this.procesos.forEach(pp =>{
                    if (pp.tipo == 0) {
                        ppi.push({text: pp.nompro, value: pp.id})
                    }
                });
                return ppi;
            },

            //Opciones subprocesos
            opcSP: function() {
                const ssp = [];
                //recorre y muestra los procesos
                this.procesos.forEach(sp =>{
                    if (sp.proceso_id == this.proc_prin) {
                        ssp.push({id: sp.id, text: sp.id+' - '+sp.nompro});
                    }
                })
                return ssp;
            },

            //Opciones de paros
            opcPR: function() {
                //select paros
                var pr = []
                this.claParo.forEach(pa => {
                    pr.push({id: pa.id, text: pa.clave+' - '+pa.descri });
                })
                return pr;
            },

            //Opciones maquinas de procesos
            opcMQ: function() {
                const mq = [];
                var mar = '';
                if (this.carga.proceso_id != '') {
                    this.procesos.forEach(pm => {
                        if (this.carga.proceso_id == pm.id) {
                            //console.log(pm.maq_pros.length)
                            pm.maq_pros.forEach(mp => {
                                mar = mp.maquinas.marca == null ? 'N/A' :  mp.maquinas.marca.Nombre
                                mq.push({id: mp.id, text: mp.id+' - '+mp.maquinas.Nombre + ' ' + mar});
                            })
                        }
                    })
                }
                return mq;
            },

            //Opciones Maquinas
            opcMaq: function() {
                const mq = [];
                var mar = '';
                this.procesos.forEach(pm => {
                    pm.maq_pros.forEach(mp => {
                        mar = mp.maquinas.marca == null ? 'N/A' :  mp.maquinas.marca.Nombre
                        mq.push({id: mp.id, text: pm.nompro + ': ' + mp.maquinas.Nombre + ' ' + mar})
                    })
                })
                return mq;
            },

            //procesos Graficas
            proGrafi: function() {
                var grafi = [];
                if (this.gPie.tipo == 'efiTur') {
                    this.procesos.forEach(gr => {
                        if (gr.tipo == 3 & gr.operacion == 'efi_tur') {
                            grafi.push({id: gr.id, text:gr.nompro})
                            //console.log(gr)
                        }
                    })
                }else if(this.gPie.tipo == 'efiDia'){
                    this.procesos.forEach(gr => {
                        if (gr.tipo == 3 & gr.operacion == 'efi_dia') {
                            console.log(gr)
                            grafi.push({id: gr.id, text:gr.nompro})
                            //console.log(gr)
                        }
                    })
                }else{
                    this.procesos.forEach(gr => {
                        if (gr.tipo != 0) {
                            grafi.push({id: gr.id, text:gr.nompro})
                        }
                    })
                }
                return grafi;
            },

            //Opciones de tipo
            opcTipo: function() {
                const arreg = [
                    {id: 'generalTot', text: 'General Procesos'},
                    {id: 'generalMaq', text: 'General Maquinas'},
                    {id: 'catego', text: 'Categoria'},
                    {id: 'norma', text: 'Norma'},
                    {id: 'partida', text: 'Partida'},
                    {id: 'equipo', text: 'Equipo'},
                    {id: 'efiTur', text: 'Eficiencia por equipo'},
                    {id: 'efiDia', text: 'Eficiencia General'}
                ]
                return arreg;
            },

            opcTipoOt: function() {
                const arreg = [
                    {id: 'generalTot', text: 'General Procesos'},
                    {id: 'generalMaq', text: 'General Maquinas'}
                ]
                return arreg;
            },

            opcTipoParo: function() {
                const arreg = [
                    {id: 'total', text: 'Total'},
                    {id: 'separa', text: 'Separado'}
                ]
                return arreg;
            }
        },

        watch: {
            S_Area: async function(b){
                this.FoFiltro.iniDia = this.hoy;

                this.arrProdu();
                this.arrParo();

                var datos = {'departamento_id': this.S_Area, 'modulo': 'repoPro'};

                //Produccion
                let produ = await axios.post('General/ConProduccion', datos)
                this.procesos = produ.data;

                //Materiales
                let mate = await axios.post('General/ConMateriales', datos)
                this.materiales = mate.data
            },
        }
    }
</script>
