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
                    <select class="InputSelect sm:tw-w-full" @change="verTabla()" v-model="S_Area">
                        <option value="" disabled>Selecciona un departamento</option>
                        <option v-for="o in opc" :key="o.value" :value="o.value">{{o.text}}</option>
                    </select>
                </div>
            </template>
            <template v-slot:BtnNuevo>
                <div class="md:tw-flex tw-gap-3 tw-mr-10">
                    <!-- boton de carga masiva -->
                    <div>
                        <jet-button class="BtnNuevo tw-w-full" @click="openModalC">Carga masiva</jet-button>
                    </div>
                    <!-- boton de calculos
                    <div>
                        <jet-button class="BtnNuevo tw-w-full" @click="openModal">Calculos</jet-button>
                    </div> -->
                    <!-- Boton de filtros -->
                    <div>
                        <jet-button class="BtnNuevo tw-w-full" data-bs-toggle="collapse" data-bs-target="#filtro" aria-expanded="false" aria-controls="filtro"><i class="fas fa-filter"> </i> Filtros</jet-button>
                    </div>
                    <div>
                        <jet-button class="BtnNuevo tw-w-full" data-bs-toggle="collapse" data-bs-target="#grafica" aria-expanded="false" aria-controls="grafica"><i class="fas fa-chart-pie"></i> Graficas</jet-button>
                    </div>
                </div>
            </template>
        </Accions>

        <!------------------------------------ Muestra las opciones de filtros ------------------------------------------->
        <div class="collapse md:tw-ml-10 tw-p-6 tw-bg-blue-300 tw-rounded-3xl tw-shadow-xl tw-m-10" id="filtro">
            <div class="tw-mb-6 lg:tw-flex lg:tw-flex-col tw-w-full">
                <div class="tw-mb-6 lg:tw-flex">
                    <!-- Año -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0">
                        <jet-label><span class="required">*</span>Año</jet-label>
                        <jet-input type="number" class="form-control" v-model="ano" :max="estAño"></jet-input>
                    </div>
                    <!-- Tipo de reporte -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0">
                        <jet-label><span class="required">*</span>Tipo de reporte</jet-label>
                        <div class="tw-flex tw-gap-5">
                            <div>
                                <input type="radio" id="uno" value="1" v-model="FoFiltro.TipRepo">
                                <label for="uno"> Produccion</label>
                            </div>
                            <div>
                                <input type="radio" id="dos" value="2" v-model="FoFiltro.TipRepo">
                                <label for="dos"> Paros</label>
                            </div>
                        </div>
                    </div>
                    <!-- calculos -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0">
                        <jet-label>Boton para Calcular Operaciones</jet-label>
                        <button v-show="vCal" class="btn btn-success" type="button" id="button-addon2" v-if="FoFiltro.iniDia" @click="calcula(form)">
                            <i class="fas fa-calculator" ></i> Calcular
                        </button>
                        <button v-show="!vCal" class="btn btn-success" type="button" disabled>
                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                            Calculando...
                        </button>
                    </div>
                </div>
                <div class="tw-mb-6 lg:tw-flex">
                    <!-- mes -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0">
                        <jet-label><span class="required">*</span>Mes</jet-label>
                        <jet-input type="month" class="form-control" @click="limInputs(3)" v-model="FoFiltro.mes"></jet-input>
                    </div>
                    <!-- semana -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0">
                        <jet-label><span class="required">*</span>Semana</jet-label>
                        <jet-input type="week" class="form-control" @click="limInputs(2)" v-model="FoFiltro.semana"></jet-input>
                    </div>
                    <!-- dia -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0">
                        <jet-label><span class="required">*</span>Fecha Dia</jet-label>
                        <jet-input type="date" class="form-control" @click="limInputs(1.5)" @change="cambioFechas()" v-model="FoFiltro.iniDia" :max="treDia"></jet-input>
                    </div>
                </div>
            </div>
        </div>

        <!------------------------------------ Muestra las opciones de Graficas ------------------------------------------->
        <div class="collapse md:tw-ml-10 tw-p-6 tw-bg-teal-300 tw-rounded-3xl tw-shadow-xl tw-m-10" id="grafica">
            <div class="tw-mb-6 lg:tw-flex lg:tw-flex-col tw-w-full">
                <div class="tw-mb-6 lg:tw-flex">
                    <div class="tw-px-3 tw-mb-6 tw-gap-3 tw-flex">
                        <label><span class="required">*</span>Tipo de gráfica: </label>
                        <div>
                            <input type="checkbox" v-model="graTipo" value="pie" id="pie"> <label for="pie">Gráfica de pie</label>
                        </div>
                        <div>
                            <input type="checkbox" v-model="graTipo" value="punto" id="punto"> <label for="punto">Gráfica de punto</label>
                        </div>
                        <div>
                            <input type="checkbox" v-model="graTipo" value="barra" id="barra"> <label for="barra">Gráfica de barra</label>
                        </div>
                        <div>
                            <input type="checkbox" v-model="graTipo" value="ambos" id="ambos"> <label for="ambos">Gráfica de barar y punto</label>
                        </div>
                    </div>
                    <!-- Año
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0">
                        <jet-label><span class="required">*</span>Año</jet-label>
                        <jet-input type="number" class="form-control" v-model="ano" :max="estAño"></jet-input>
                    </div> -->
                    <!-- Tipo de reporte
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0">
                        <jet-label><span class="required">*</span>Tipo de reporte</jet-label>
                        <div class="tw-flex tw-gap-5">
                            <div>
                                <input type="radio" id="uno" value="1" v-model="FoFiltro.TipRepo">
                                <label for="uno"> Produccion</label>
                            </div>
                            <div>
                                <input type="radio" id="dos" value="2" v-model="FoFiltro.TipRepo">
                                <label for="dos"> Paros</label>
                            </div>
                        </div>
                    </div> -->
                    <!-- calculos
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0">
                        <jet-label>Boton para Calcular Operaciones</jet-label>
                        <button v-show="vCal" class="btn btn-success" type="button" id="button-addon2" v-if="FoFiltro.iniDia" @click="calcula(form)">
                            <i class="fas fa-calculator" ></i> Calcular
                        </button>
                        <button v-show="!vCal" class="btn btn-success" type="button" disabled>
                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                            Calculando...
                        </button>
                    </div> -->
                </div>
                <div v-for="tip in graTipo" :key="tip">
                    <div v-if="tip == 'pie'" class="tw-mb-6 lg:tw-flex tw-flex-col">
                        <div class="tw-flex tw-m-5">
                            <div class="tw-w-1/2 tw-text-2xl tw-text-center">
                                <h1>Gráfica de pie</h1>
                            </div>

                            <div class="tw-w-1/2">
                                <button class="btn btn-outline-success " @click="GraPaste(gPie)">Generar gráfica</button>
                            </div>
                        </div>
                        <div class="tw-flex ">
                            <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                                <jet-label><span class="required">*</span>Fecha Dia</jet-label>
                                <jet-input type="date" class="form-control" v-model="gPie.fecha" :max="treDia"></jet-input>
                            </div>
                            <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                                <jet-label><span class="required">*</span>Procesos</jet-label>
                                <div class="tw-overflow-auto" style="height: 10rem">
                                    <div v-for="pro in proGrafi" :key="pro" class="hover:tw-bg-teal-100">
                                        <input type="checkbox" v-model="gPie.procesos" :value="pro.value" :id="'pie'+pro.value">
                                        <label :for="'pie'+pro.value" class="tw-w-11/12">{{pro.text}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- mes
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0">
                        <jet-label><span class="required">*</span>Mes</jet-label>
                        <jet-input type="month" class="form-control" @click="limInputs(3)" v-model="FoFiltro.mes"></jet-input>
                    </div> -->
                    <!-- semana
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0">
                        <jet-label><span class="required">*</span>Semana</jet-label>
                        <jet-input type="week" class="form-control" @click="limInputs(2)" v-model="FoFiltro.semana"></jet-input>
                    </div> -->
                    <!-- dia
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0">
                        <jet-label><span class="required">*</span>Fecha Dia</jet-label>
                        <jet-input type="date" class="form-control" @click="limInputs(1.5)" @change="cambioFechas()" v-model="FoFiltro.iniDia" :max="treDia"></jet-input>
                    </div> -->
                </div>
            </div>
        </div>

        <!------------------------------------ Data table de carga de produccion ------------------------------------------------------->
        <div v-show="FoFiltro.TipRepo == 1" class="tw-m-auto" style="width: 99%">
            <Table id="t_repo">
                <template v-slot:TableHeader>
                    <th class="columna">Indice</th>
                    <th class="columna">Fecha</th>
                    <th class="columna">Proceso</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Maquina</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Nombre</th>
                    <th class="columna">Estatus</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Equipo</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Turno</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Partida</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Norma</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Clave</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Descripción de clave</th>
                    <th class="columna">Producción</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Cantidad producida</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Departamento</th>
                    <th v-show="FoFiltro.iniDia">
                        <button class="btn btn-danger" v-show="deli.elimiMasi.length > 0" @click="eliminaMasiva(deli)" >Eliminar</button>
                    </th>
                </template>
                <template v-slot:TableFooter >
                    <tr class="fila" v-for="ca in recoTabla" :key="ca.id">
                        <td>
                            <div v-if="ca.proceso.tipo == 1 | ca.proceso.tipo == 5 | ca.proceso.tipo == 3">
                                <input type="checkbox" :value="ca.id" v-model="deli.elimiMasi" class="tw-rounded-xl tw-bg-coolGray-300" :id="'indePro'+ca.id "/>
                                <label :for="'indePro'+ca.id" class="tw-px-3"> {{ca.id}} </label>
                            </div>
                            <div v-else>
                                {{ca.id}}
                            </div>
                        </td>
                        <td>{{ca.fecha}}</td>
                        <td class="">{{ca.proceso == null ? 'N/A' : ca.proceso.nompro}}</td>
                        <td v-show="FoFiltro.iniDia">{{ca.maq_pro == null ? 'N/A' : ca.maq_pro.maquinas.Nombre}}</td>
                        <td v-show="FoFiltro.iniDia" >
                            {{ca.dep_perf == null ? 'N/A' : ca.dep_perf.perfiles.Nombre}} {{ca.dep_perf == null ? 'N/A' : ca.dep_perf.perfiles.ApPat}} {{ca.dep_perf == null ? 'N/A' : ca.dep_perf.perfiles.ApMat}}</td>
                        <td class=" tw-w-40">
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-cyan-600 tw-rounded-full" v-if="ca.notaPen == 2">NOTA PENDIENTE</div>
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-blue-600 tw-rounded-full" v-if="ca.proceso.tipo == 3">CALCULOS</div>
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-indigo-600 tw-rounded-full" v-else-if="ca.proceso.tipo == 1 & ca.notaPen == 1">PRODUCCION</div>
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-yellow-600 tw-rounded-full" v-else-if="ca.proceso.tipo == 5 & ca.notaPen == 1">MERMA</div>
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-orange-600 tw-rounded-full" v-else-if="ca.proceso.tipo == 2 & ca.notaPen == 1">OBJETIVO</div>
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-teal-600 tw-rounded-full" v-if="ca.notaPen == 1 & ca.notas.length > 1"> - ACTUALIZADO</div>
                        </td>
                        <td  v-show="FoFiltro.iniDia">{{ca.equipo == null ? 'N/A' : ca.equipo.nombre}}</td>
                        <td  v-show="FoFiltro.iniDia">{{ca.turno == null ? 'N/A' : ca.turno.nomtur}}</td>
                        <td  v-show="FoFiltro.iniDia">{{ca.partida == null ? 'N/A' : ca.partida}}</td>
                        <td  v-show="FoFiltro.iniDia">{{ca.dep_mat == null ? 'N/A' : ca.dep_mat.materiales.idmat+' - '+ca.dep_mat.materiales.nommat}}</td>
                        <td  v-show="FoFiltro.iniDia">{{ca.clave == null ? 'N/A' : ca.clave.CVE_ART}}</td>
                        <td  v-show="FoFiltro.iniDia">{{ca.clave == null ? 'N/A' : ca.clave.DESCR}}</td>
                        <td >{{this.formatoMexico(ca.valor)}}</td>
                        <td  v-show="FoFiltro.iniDia"> {{ca.VerInv}} </td>
                        <td v-show="FoFiltro.iniDia" >{{ca.dep_perf == null ? 'N/A' : ca.dep_perf.departamentos.Nombre}}</td>
                        <td v-show="FoFiltro.iniDia">
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
                            <div class="columnaIconos">
                                <!-- Notas -->
                                <div class="iconoDetails tw-cursor-pointer" @click="VeNota(ca)" v-show="ca.notas.length != 0">
                                    <span tooltip="Ver notas" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                </template>
                <template v-slot:Foother>
                    <th class="columna">Indice</th>
                    <th class="columna">Fecha</th>
                    <th class="columna">Proceso</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Maquina</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Nombre</th>
                    <th class="columna">Estatus</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Equipo</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Turno</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Partida</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Norma</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Clave</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Descripción de clave</th>
                    <th class="columna">Producción</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Cantidad producida</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Departamento</th>
                    <th v-show="FoFiltro.iniDia"></th>
                </template>
            </Table>
        </div>

        <!------------------------------------- Data table de paros ------------------------------------------------------------------>
        <div v-show="FoFiltro.TipRepo == 2" class="tw-m-auto" style="width: 99%">
            <TableBlue id="t_repoPar">
                <template v-slot:TableHeader>
                    <th class="columna tw-text-center">Fecha</th>
                    <th class="columna tw-text-center" v-show="FoFiltro.iniDia">Orden</th>
                    <th class="columna tw-text-center">Maquina</th>
                    <th class="columna tw-text-center">Clave de paro</th>
                    <th class="columna tw-text-center">Nombre de paro</th>
                    <th class="columna tw-text-center" v-show="FoFiltro.iniDia">Descripción</th>
                    <th class="columna tw-text-center">Estatus</th>
                    <th class="columna tw-text-center" v-show="FoFiltro.iniDia">Abierto por</th>
                    <th class="columna tw-text-center" v-show="FoFiltro.iniDia">Cerrado por</th>
                    <th class="columna tw-text-center" v-show="FoFiltro.iniDia">Inicio</th>
                    <th class="columna tw-text-center" v-show="FoFiltro.iniDia">Final</th>
                    <th class="columna tw-text-center">Tiempo cargado</th>
                    <th class="columna tw-text-center" v-show="FoFiltro.iniDia">Plan de Acción</th>
                </template>
                <template v-slot:TableFooter>
                    <tr class="fila" v-for="ca in recoTablaParo" :key="ca">
                        <td class="tw-text-center">{{ca.fecha}}</td>
                        <td class="tw-text-center" v-show="FoFiltro.iniDia">{{ca.orden}}</td>
                        <td class="tw-text-center">{{ ca.maq_pro.length ? ca.maq_pro : ca.maq_pro.maquinas.Nombre}}</td>
                        <td class="tw-text-center">{{ca.paros.clave}}</td>
                        <td class="tw-text-center">{{ca.paros.descri}}</td>
                        <td class="tw-text-center" v-show="FoFiltro.iniDia">{{ca.descri}}</td>

                        <td class="tw-text-center">
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-amber-600 tw-rounded-full" v-if="ca.estatus == 'Activo'">{{ca.estatus}}</div>
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-blue-600 tw-rounded-full" v-else-if="ca.estatus == 'En revisión'">{{ca.estatus}}</div>
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-green-600 tw-rounded-full" v-else-if="ca.estatus == 'Autorizado'">{{ca.estatus}}</div>
                        </td>

                        <td class="tw-text-center" v-show="FoFiltro.iniDia">{{ca.perfil_ini == 'N/A' ? ca.perfil_ini : ca.perfil_ini.Nombre + ' ' + ca.perfil_ini.ApPat + ' ' + ca.perfil_ini.ApMat }} </td>
                        <td class="tw-text-center" v-show="FoFiltro.iniDia">{{ca.perfil_fin_id == null ? '' : ca.perfil_fin.Nombre+' '+ca.perfil_fin.ApPat+' '+ca.perfil_fin.ApMat}}</td>
                        <td class="tw-text-center" v-show="FoFiltro.iniDia">{{ca.iniFecha}}</td>
                        <td class="tw-text-center" v-show="FoFiltro.iniDia">{{ nuFin(ca) }}</td>
                        <td class="tw-text-center">{{tiempo(ca)}}</td>
                        <td class="tw-text-center" v-show="FoFiltro.iniDia">{{ca.pla_acci}}</td>
                    </tr>
                </template>
                <template v-slot:Foother>
                    <th class="columna tw-text-center">Fecha</th>
                    <th class="columna tw-text-center" v-show="FoFiltro.iniDia">Orden</th>
                    <th class="columna tw-text-center">Maquina</th>
                    <th class="columna tw-text-center">Clave de paro</th>
                    <th class="columna tw-text-center">Nombre de paro</th>
                    <th class="columna tw-text-center" v-show="FoFiltro.iniDia">Descripción</th>
                    <th class="columna tw-text-center">Estatus</th>
                    <th class="columna tw-text-center" v-show="FoFiltro.iniDia">Abierto por</th>
                    <th class="columna tw-text-center" v-show="FoFiltro.iniDia">Cerrado por</th>
                    <th class="columna tw-text-center" v-show="FoFiltro.iniDia">Inicio</th>
                    <th class="columna tw-text-center" v-show="FoFiltro.iniDia">Final</th>
                    <th class="columna tw-text-center">Tiempo cargado</th>
                    <th class="columna tw-text-center" v-show="FoFiltro.iniDia">Plan de Acción</th>
                </template>
            </TableBlue>
        </div>

        <!------------------------------------ Graficas ------------------------------------------------------------------>
        <div class="tw-text-center tw-m-auto" style="width: 99%">
            <div id="chart"></div>
            <div id="chart1"></div>
            <div id="chart2"></div>
            <div id="chart3"></div>
        </div>

        <pre>
            {{  }}
        </pre>

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
                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <a target="_blank" href="../public/FormatosExcel/FileNotFound404.jpg" download="not.jpg">Link de descarga</a>
                            </div>
                        </div>

                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-2/3 md:tw-mb-0">
                                <jet-label><span class="required">*</span>Fecha de inicio de carga</jet-label>
                                <input type="file" @input="docu.file = $event.target.files[0]" ref="file" accept=".xlsx">
                                <br>
                                <small v-if="errors.file" class="validation-alert">{{errors.file}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/3 md:tw-mb-0">
                                <jet-button class="" v-show="vMasi" @click="carMasi">Guardar</jet-button>
                                <jet-button v-show="!vMasi" disabled>
                                    <span class="spinner-grow spinner-grow-sm" v-show="!vMasi" role="status" aria-hidden="true"></span>
                                    Guardando...
                                </jet-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </modal>

        <!------------------ Modal Calculos------------------------->
        <modal :show="showModal" @close="chageClose">
            <form>
                <div class="tw-px-4 tw-py-4">
                    <div class="tw-text-lg">
                        <div class="ModalHeader">
                            <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Calculos</h3>
                        </div>
                    </div>

                    <div class="tw-mt-4">
                        <div class="ModalForm">
                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Fecha a guardar</jet-label>
                                    <jet-input type="date" v-model="form.fecha" @change="cambioFechas()" :max="hoy"></jet-input>
                                    <small v-if="errors.fecha" class="validation-alert">{{errors.fecha}}</small>
                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Fecha de inicio de carga</jet-label>
                                    <jet-input type="datetime-local" v-model="form.hoy" :max="form.mañana" disabled></jet-input>
                                    <small v-if="errors.hoy" class="validation-alert">{{errors.hoy}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Fecha final de carga</jet-label>
                                    <jet-input type="datetime-local" v-model="form.mañana" :min="form.hoy" disabled></jet-input>
                                    <small v-if="errors.mañana" class="validation-alert">{{errors.mañana}}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ModalFooter">
                    <button v-show="vCal" class="btn btn-outline-success" type="button" id="button-addon2" @click="calcula(form)">
                        <i class="fas fa-calculator" ></i> Calcular
                    </button>
                    <button v-show="!vCal" class="btn btn-success" type="button" disabled>
                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                        Calculando...
                    </button>
                    <jet-CancelButton @click="chageClose">Cerrar</jet-CancelButton>
                </div>
            </form>
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
                                    <option v-for="mq in opcMQ" :key="mq.value" :value="mq.value">{{mq.text}}</option>
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
                                    <option v-for="nm in opcNM" :key="nm" :value="nm.value">{{nm.text}}</option>
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
                                <!-- <Select2  v-model="carga.clave_id" class="InputSelect" :options="opcCL" /> -->
                                <!-- <select class="InputSelect" v-model="carga.clave_id">
                                    <option v-for="cl in opcCL" :key="cl" :value="cl.id">{{cl.text}}</option>
                                </select> -->
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


    pdfMake.vfs = pdfFonts.pdfMake.vfs;
    window.JSZip = jszip;

    export default {
        props: [
            'usuario',
            'depa',
            'paros',
            'cargas',
            'materiales',
            'maquinas',
            'procesos',
            'claParo',
            'errors'
        ],

        components: {
            AppLayout,
            Header,
            Accions,
            Table,
            TableBlue,
            JetButton,
            JetCancelButton,
            JetInput,
            Modal,
            Select2,
            JetLabel
        },

        data() {
            return {
                color: "tw-bg-blue-600",
                style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
                S_Area: '',
                fechaC: '',
                limp: 1,
                nAnte: null,
                horas: '07:00',
                estAño: moment().format('Y'),
                ano: moment().format('Y'),
                hoy: moment().format('YYYY-MM-DD'),
                treDia: moment().add(3, 'days').format('YYYY-MM-DD'),
                editMode: false,
                carMode: false,
                showModal: false,
                showModalC: false,
                showModalCar: false,
                limpPro: true,
                proc_prin: '',
                vMasi: true,
                vCal: true,
                deli:{
                    elimiMasi: []
                },
                docu: {
                    file: null
                },
                FoFiltro: {
                    TipRepo: 1,
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
                graTipo: [],
                gPie: {
                    fecha: null,
                    procesos: []
                },


                series: [44, 55, 13, 43, 22],
                chartOptions: {
                    chart: {
                        width: 380,
                        type: 'pie',
                    },
                    labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                            width: 200
                            },
                            legend: {
                            position: 'bottom'
                            }
                        }
                    }]
                },
            }
        },

        mounted() {
            this.global();
        },

        methods: {
            limiteFecha(){
                var inpDia = moment(this.FoFiltro.iniDia);
                var Dhoy = moment()
                var dife = Dhoy.diff(inpDia, 'days');
                return dife <= 3;
            },

            /***************************** Carga Masiva ************************************/
            carMasi(){
                const form = this.docu;
                //this.vMasi = false;
                this.$inertia.post('/Produccion/CargaExcel', form, {
                    onSuccess: (v) => { this.openModalC(), this.resetC(), this.alertSucces(), this.vMasi = true }, onError: (e) => { this.vMasi = true }, preserveState: true
                });
            },

            /***************************** Calculos ******************************************/
            calcula(form) {
                if (this.calcu != '' & this.S_Area != '') {
                    this.limpPro = false;
                    this.vCal = false;
                    this.$inertia.post('/Produccion/Calcula', form, {
                        onSuccess: (v) => {
                            this.alertSucces(),
                            this.vCal = true,
                            this.reset()
                            //this.chageClose()
                            //this.limInputs('00')
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
                    }else{
                        this.form.hoy = this.form.fecha+'T08:10';
                        this.form.mañana = moment(this.form.hoy).add(1, 'days').format("YYYY-MM-DD[T]HH:mm")
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

            /****************************** Globales **********************************************************/
            global(){
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
            verTabla() {
                this.limpPro = true;
            },
            //muestra la utima fecha del paro
            nuFin(ar){
                //Si es es mes o semana
                if (ar.iniFecha == 'N/A') {
                    return 'N/A'
                }
                //si es un sub paro
                if (ar.paros_carga_id != null) {
                    //busca el id del paro princial
                    var busca = this.paros.find(e => e.id == ar.paros_carga_id);
                    //en caso de que no este el dato entonces pone la fecha generada
                    var data = busca == null ? ar.finFecha : busca.sub_paro[0].finFecha;
                    //consulta en caso de que aun no cierre el paro
                    var fecha = data == null ? moment().format("YYYY-MM-DD HH:mm:ss") : data;
                    return fecha;
                }
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
                if (fec.iniFecha == 'N/A') {
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
            /****************************** Modal y acciones *************************************************/
            //abrir y reset del modal procesos
            openModal() {
                this.chageClose();
                this.reset();
                this.editMode = false;
            },
            //abrir o cerrar modal procesos
            chageClose(){
                this.showModal = !this.showModal
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
            //ver notas
            VeNota(data) {
                console.log(data.notas.length)
            },
            /***************************** Crea nuevos arreglos dependiendo de el tipo de reporte ******************/
            //Nuevo arreglo Parar mostrar la produccion
            NuArrayPro() {
                const rt = [];
                var inicio = null;
                var fin = null;
                //consulta del dia
                if(this.FoFiltro.iniDia != null){
                    inicio = this.FoFiltro.iniDia+' 07:00:00'
                    if (this.S_Area == 7){
                        if (moment(this.FoFiltro.iniDia).isDST()) {
                            inicio = this.FoFiltro.iniDia+' 09:10:00';
                        }else{
                            inicio = this.FoFiltro.iniDia+' 08:10:00';
                        }
                    }
                    //console.log(inicio)
                    //Asigna el dato para la fecha final
                    fin = moment(inicio).add(24, 'hours');

                    //Limpia el datatables
                    if (this.limpPro) {
                        $('#t_repo').DataTable().clear();
                    }
                    $('#t_repo').DataTable().destroy();
                    this.tabla();

                    //hace el recorrido y asigna el Array
                    this.cargas.forEach(fec => {
                        if ( moment(fec.fecha).isSameOrAfter(inicio, 'minutes') & moment(fec.fecha).isBefore(fin, 'minutes') & fec.departamento_id == this.S_Area ) {
                            rt.push(fec);
                        }
                    });
                }
                //consulta de la semana
                if(this.FoFiltro.semana != null){

                    //Limpia el datatables
                    if (this.limpPro) {
                        $('#t_repo').DataTable().clear();
                    }
                    $('#t_repo').DataTable().destroy();
                    this.tabla();

                    //hace el recorrido y asigna el Array
                    this.cargas.forEach(fec => {
                        //console.log(fec.proceso.operacion)
                        if ( this.FoFiltro.semana == fec.semana & fec.proceso.operacion != null) {
                            if(fec.proceso.operacion.includes("sem_") & fec.departamento_id == this.S_Area){
                                rt.push(fec);
                            }
                        }
                    });
                }
                //Consulta del mes
                if(this.FoFiltro.mes != null){

                    //Limpia el datatables
                    if (this.limpPro) {
                        $('#t_repo').DataTable().clear();
                    }
                    $('#t_repo').DataTable().destroy();
                    this.tabla();

                    //hace el recorrido y asigna el Array
                    this.cargas.forEach(fec => {
                        //console.log(fec.fecha)
                        if ( fec.fecha.includes(this.FoFiltro.mes) & fec.proceso.operacion != null ) {
                            if(fec.proceso.operacion.includes("mes_") & fec.departamento_id == this.S_Area){
                                rt.push(fec);
                            }
                        }
                    });
                }
                return rt;
            },
            //Nuevo arrego para los paros
            NuArrayParo() {
                const rtP = [];
                this.limpPro = true;
                var inicio = null;
                var fin = null;
                //consulta del dia
                if(this.FoFiltro.iniDia != null){
                    inicio = this.FoFiltro.iniDia+' 7:00'
                    if (this.S_Area == 7){
                        if (moment(this.FoFiltro.iniDia).isDST()) {
                            inicio = this.FoFiltro.iniDia+' 09:00';
                        }else{
                            inicio = this.FoFiltro.iniDia+' 08:00';
                        }
                    }

                    //Asigna el dato para la fecha final
                    fin = moment(inicio).add(24, 'hours');
                    //Limpia el datatables
                    $('#t_repoPar').DataTable().clear();
                    $('#t_repoPar').DataTable().destroy();
                    this.tablaParo();
                    //hace el recorrido y asigna el Array
                    this.paros.forEach(fec => {
                        if ( moment(fec.fecha).isSameOrAfter(inicio, 'minutes') & moment(fec.fecha).isBefore(fin, 'minutes') & fec.departamento_id == this.S_Area ) {
                            rtP.push(fec);
                        }
                    });
                }
                //consulta semanal
                if (this.FoFiltro.semana != null) {
                    //console.log(this.FoFiltro.semana)
                    //Limpia el datatables
                    $('#t_repoPar').DataTable().clear();
                    $('#t_repoPar').DataTable().destroy();
                    this.tablaParo();
                    //variables
                    var semana = 'Semana '+moment(this.FoFiltro.semana).format('WW');
                    var maquina = '';
                    var suma = 0;
                    const paroNu = []
                    this.paros.forEach(nue => {
                        if(moment(nue.fecha).format('YYYY-[W]WW') == this.FoFiltro.semana){
                            paroNu.push(nue);
                        }
                    })

                    //console.log(paroNu);
                    //se recorren las claves que existen de los paros
                    this.claParo.forEach(cla => {
                        //hace el recorrido y asigna el Array
                        this.maquinas.forEach(maq => {
                            suma = 0;
                            maquina = maq.Nombre+' '+maq.marca.Nombre;

                            paroNu.forEach(fec => {
                                if (fec.paro_id == cla.id & fec.tiempo != null & maq.id == fec.maq_pro.maquina_id & fec.departamento_id == this.S_Area) {
                                    suma += parseInt(fec.tiempo, 10);
                                    //console.log(maquina+' - '+fec.paros.clave + ' - ' + fec.tiempo + ' - ' + suma + ' || ')
                                }
                            })
                            //si la suma es diferente de 0 entonces crea el nuevo array
                            if (suma > 0) {
                                rtP.push({fecha: semana, orden: 'N/A', maq_pro: maquina, paros: {clave: cla.clave, descri: cla.descri}, estatus: 'Autorizado', perfil_ini: 'N/A', iniFecha: 'N/A', finFecha: 'N/A', pla_acci: 'N/A', perfil_fin_id: null, tiempo: suma})
                                //console.log(cla.clave + ' - ' + suma);
                            }
                        });
                    })
                }
                //consulta mensual
                if (this.FoFiltro.mes != null) {
                    //Limpia el datatables
                    $('#t_repoPar').DataTable().clear();
                    $('#t_repoPar').DataTable().destroy();
                    this.tablaParo();
                    //variables
                    var mes = moment(this.FoFiltro.mes).format('MMMM');
                    var suma = 0;
                    var maquina = '';
                    const paroNu = []
                    this.paros.forEach(nue => {
                        if(nue.fecha.includes(this.FoFiltro.mes)){
                            paroNu.push(nue);
                        }
                    })

                    this.claParo.forEach(cla => {
                        this.maquinas.forEach(maq => {
                            suma = 0;
                            maquina = maq.Nombre+' '+maq.marca.Nombre;
                            //hace el recorrido y asigna el Array
                            paroNu.forEach(fec => {
                                if (fec.paro_id == cla.id & fec.tiempo != null & maq.id == fec.maq_pro.maquina_id & fec.departamento_id == this.S_Area) {
                                    suma += parseInt(fec.tiempo, 10);
                                    //console.log(fec.paros)
                                }
                            })
                            //si la suma es diferente de 0 entonces crea el nuevo array
                            if (suma > 0) {
                                rtP.push({fecha: mes, orden: 'N/A', maq_pro: maquina, paros: {clave: cla.clave, descri: cla.descri}, estatus: 'Autorizado', perfil_ini: 'N/A', iniFecha: 'N/A', finFecha: 'N/A', pla_acci: 'N/A', perfil_fin_id: null, tiempo: suma})
                                //console.log(cla.clave + ' - ' + suma);
                            }
                        })
                    })
                }
                //console.log(rtP)
                return rtP;
            },
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
                this.deli.elimiMasi = [];
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
                this.docu.file = null
                //this.$refs.file.type='text';
                //this.$refs.file.type='file';
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
            updateCar(data){
                this.limpPro = false;
                this.$inertia.put('/Produccion/CarNor/' + data.id, data, {
                    onSuccess: (v) => {
                        this.resetCar(),
                        this.alertSucces(),
                        this.changeCloseCar()
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
            /************************************* Grafica **********************************************/
            GraPaste(data){
                var inicio = null;
                var fin = null;
                var valor = [];
                var texto = [];
                const gr = []

                data.fecha == null ? Swal.fire('Por favor selecciona una fecha.') : '';
                data.procesos.length <= 0 ? Swal.fire('Por favor selecciona un proceso.') : '';

                if (data.fecha != null & data.procesos.length > 0) {
                    inicio = this.FoFiltro.iniDia+' 07:00:00'
                    if (this.S_Area == 7){
                        if (moment(data.fecha).isDST()) {
                            inicio = data.fecha+' 09:10:00';
                        }else{
                            inicio = data.fecha+' 08:10:00';
                        }
                    }
                    //Asigna el dato para la fecha final
                    fin = moment(inicio).add(24, 'hours');


                    this.cargas.forEach(reco => {
                        if ( moment(reco.fecha).isSameOrAfter(inicio, 'minutes') & moment(reco.fecha).isBefore(fin, 'minutes') & reco.departamento_id == this.S_Area ) {
                            gr.push(reco);
                        }
                    })

                    gr.forEach(grp =>{
                        data.procesos.forEach(pro => {
                            if (grp.proceso_id == pro) {
                                valor.push(grp.valor);
                                texto.push(grp.proceso.nompro)
                                console.log(grp)
                            }
                        })
                    })


                    var options3 = {
                        series: valor,
                        chart: {
                            width: 500,
                            type: 'pie',
                        },
                        labels: texto,
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                chart: {
                                    width: 500
                                },
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }]
                    };

                    var chart3 = new ApexCharts(document.querySelector("#chart3"), options3);
                    chart3.render();
                }
            },
            GraBarra(){
                var options = {
                    series: [{
                        name: 'Net Profit',
                        data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
                    }, {
                    name: 'Revenue',
                    data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
                    }, {
                        name: 'Free Cash Flow',
                        data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
                    }],
                    chart: {
                    type: 'bar',
                    height: 350
                    },
                    plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                    },
                    dataLabels: {
                    enabled: false
                    },
                    stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                    },
                    xaxis: {
                        categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
                    },
                    yaxis: {
                        title: {
                            text: '$ (thousands)'
                        }
                    },
                    fill: {
                    opacity: 1
                    },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                            return "$ " + val + " thousands"
                            }
                        }
                    }
                };

                var chart = new ApexCharts(document.querySelector("#chart"), options);
                chart.render();
            },
            GraLinea(){
                var options2 = {
                    series: [{
                        name: "Session Duration",
                        data: [45, 52, 38, 24, 33, 26, 21, 20, 6, 8, 15, 10]
                    },
                    {
                        name: "Page Views",
                        data: [35, 41, 62, 42, 13, 18, 29, 37, 36, 51, 32, 35]
                    },
                    {
                        name: 'Total Visits',
                        data: [87, 57, 74, 99, 75, 38, 62, 47, 82, 56, 45, 47]
                    }
                    ],
                    chart: {
                    height: 350,
                    type: 'line',
                    zoom: {
                        enabled: false
                    },
                    },
                    dataLabels: {
                    enabled: false
                    },
                    stroke: {
                    width: [5, 7, 5],
                    curve: 'straight',
                    dashArray: [0, 8, 5]
                    },
                    title: {
                    text: 'Page Statistics',
                    align: 'left'
                    },
                    legend: {
                    tooltipHoverFormatter: function(val, opts) {
                        return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
                    }
                    },
                    markers: {
                    size: 0,
                    hover: {
                        sizeOffset: 6
                    }
                    },
                    xaxis: {
                    categories: ['01 Jan', '02 Jan', '03 Jan', '04 Jan', '05 Jan', '06 Jan', '07 Jan', '08 Jan', '09 Jan',
                        '10 Jan', '11 Jan', '12 Jan'
                    ],
                    },
                    tooltip: {
                    y: [
                        {
                        title: {
                            formatter: function (val) {
                            return val + " (mins)"
                            }
                        }
                        },
                        {
                        title: {
                            formatter: function (val) {
                            return val + " per session"
                            }
                        }
                        },
                        {
                        title: {
                            formatter: function (val) {
                            return val;
                            }
                        }
                        }
                    ]
                    },
                    grid: {
                    borderColor: '#f1f1f1',
                    }
                };

                var chart2 = new ApexCharts(document.querySelector("#chart2"), options2);
                chart2.render();
            },
            GraBaLi(){
                var options1 = {
                    series: [{
                        name: 'Website Blog',
                        type: 'column',
                        data: [440, 505, 414, 671, 227, 413, 201, 352, 752, 320, 257, 160]
                    }, {
                        name: 'Social Media',
                        type: 'line',
                        data: [23, 42, 35, 27, 43, 22, 17, 31, 22, 22, 12, 16]
                    }],
                        chart: {
                        height: 350,
                        type: 'line',
                    },
                    stroke: {
                        width: [0, 4]
                    },
                    title: {
                        text: 'Traffic Sources'
                    },
                    dataLabels: {
                        enabled: true,
                        enabledOnSeries: [1]
                    },
                    labels: ['01 Jan 2001', '02 Jan 2001', '03 Jan 2001', '04 Jan 2001', '05 Jan 2001', '06 Jan 2001', '07 Jan 2001', '08 Jan 2001', '09 Jan 2001', '10 Jan 2001', '11 Jan 2001', '12 Jan 2001'],
                    xaxis: {
                        type: 'datetime'
                    },
                    yaxis: [{
                        title: {
                            text: 'Website Blog',
                        },

                    }, {
                        opposite: true,
                        title: {
                            text: 'Social Media'
                        }
                    }]
                };

                var chart1 = new ApexCharts(document.querySelector("#chart1"), options1);
                chart1.render();
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
                    nm.push({value: ma.id, text: ma.materiales.idmat+' - '+ma.materiales.nommat});
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

            //Opciones maquinas
            opcMQ: function() {
                const mq = [];
                var mar = '';
                if (this.carga.proceso_id != '') {
                    this.procesos.forEach(pm => {
                        if (this.carga.proceso_id == pm.id) {
                            //console.log(pm.maq_pros.length)
                            pm.maq_pros.forEach(mp => {
                                mar = mp.maquinas.marca == null ? 'N/A' :  mp.maquinas.marca.Nombre
                                mq.push({value: mp.id, text: mp.id+' - '+mp.maquinas.Nombre + ' ' + mar});
                            })
                        }
                    })
                }
                return mq;
            },

            //recorrido para la tabla de produccion
            recoTabla: function() {
                if (this.FoFiltro.TipRepo == 1) {
                    return this.NuArrayPro();
                }
            },

            //recorrido para la tabla de paros
            recoTablaParo: function() {
                if (this.FoFiltro.TipRepo == 2) {
                    //console.log('entro a paro')
                    return this.NuArrayParo();
                }
            },

            //procesos Graficas
            proGrafi: function() {
                var grafi = [];
                this.procesos.forEach(gr => {
                    if (gr.tipo != 0) {
                        grafi.push({value: gr.id, text:gr.nompro})
                        //console.log(gr)
                    }
                })
                return grafi;
            }
        },

        watch: {
            S_Area: function(b){
                //$('#t_repo').DataTable().destroy();

                this.$inertia.get('/Produccion/ReportesPro',{ busca: b, ano: this.ano }, {
                    onSuccess: () => { this.FoFiltro.iniDia = this.hoy }, onError: () => { }, preserveState: true
                });
            },

            ano: function(a) {
                this.$inertia.get('/Produccion/ReportesPro',{ busca: this.S_Area, ano: a }, {
                    onSuccess: () => { console.log('año') }, onError: () => { }, preserveState: true
                });

            },
        }
    }
</script>
