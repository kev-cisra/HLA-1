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
                <div class="md:tw-flex tw-gap-3 tw-mr-10">
                    <!-- boton de carga masiva -->
                    <div>
                        <jet-button class="BtnNuevo tw-w-full" @click="openModalC">Carga masiva</jet-button>
                    </div>
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
                    <!-- Año
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0">
                        <jet-label><span class="required">*</span>Año</jet-label>
                        <jet-input type="number" class="form-control" v-model="ano" :max="estAño"></jet-input>
                    </div> -->
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
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0" v-if="FoFiltro.TipRepo == 1 & FoFiltro.iniDia != null & FoFiltro.rango == 1" >
                        <jet-label>Boton para Calcular Operaciones</jet-label>
                        <button v-show="vCal" class="btn btn-success" type="button" id="button-addon2" @click="calcula(form)">
                            <i class="fas fa-calculator" ></i> Calcular
                        </button>
                        <button v-show="!vCal" class="btn btn-success" type="button" disabled>
                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                            Calculando...
                        </button>
                    </div>
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0">
                        <jet-label>Opciones de consulta</jet-label>
                        <div class="tw-flex tw-gap-5">
                            <div>
                                <input type="radio" id="Rdia" value="1" v-model="FoFiltro.rango">
                                <label for="Rdia"> Dia</label>
                            </div>
                            <div>
                                <input type="radio" id="Rrango" value="2" v-model="FoFiltro.rango">
                                <label for="Rrango"> Rango</label>
                            </div>
                        </div>
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
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0" v-if="FoFiltro.rango == 1">
                        <jet-label><span class="required">*</span>Fecha Dia</jet-label>
                        <jet-input type="date" class="form-control" @click="limInputs(1.5)" v-model="FoFiltro.iniDia"></jet-input>
                    </div>
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0" v-if="FoFiltro.rango == 2">
                        <jet-label><span class="required">*</span>Fecha Dia</jet-label>
                        <jet-input type="datetime-local" class="form-control" @click="limInputs(1.5)" v-model="FoFiltro.iniDia"></jet-input>
                    </div>
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0" v-if="FoFiltro.rango == 2">
                        <jet-label><span class="required">*</span>Fecha Dia</jet-label>
                        <jet-input type="datetime-local" class="form-control" @click="limInputs(1.5)" v-model="FoFiltro.finDia"></jet-input>
                    </div>
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0">
                        <jet-button v-if="FoFiltro.TipRepo == 1" @click="arrProdu()">Consultar Produccion</jet-button>
                        <jet-button v-if="FoFiltro.TipRepo == 2" @click="arrParo()">Consultar Paros</jet-button>
                    </div>
                </div>
            </div>
        </div>

        <!------------------------------------ Data table de carga de produccion ------------------------------------------------------->
        <div v-show="FoFiltro.TipRepo == 1" class="tw-m-auto" style="width: 99%">
            <Table id="t_repo">
                <template v-slot:TableHeader>
                    <th class="columna" v-show="FoFiltro.iniDia | FoFiltro.rango == 1">Indice</th>
                    <th class="columna" v-show="FoFiltro.iniDia | FoFiltro.rango == 1">Fecha</th>
                    <th class="columna">Proceso</th>
                    <th class="columna" v-show="FoFiltro.iniDia | FoFiltro.rango == 1">Maquina</th>
                    <th class="columna" v-show="FoFiltro.iniDia | FoFiltro.rango == 1">Nombre</th>
                    <th class="columna" v-show="FoFiltro.iniDia | FoFiltro.rango == 1">Estatus</th>
                    <th class="columna" v-show="FoFiltro.iniDia | FoFiltro.rango == 1">Equipo</th>
                    <th class="columna" v-show="FoFiltro.iniDia | FoFiltro.rango == 1">Turno</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Partida</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Norma</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Clave</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Descripción de clave</th>
                    <th class="columna">Producción</th>
                    <th class="columna" v-show="FoFiltro.iniDia | FoFiltro.rango == 1">Cantidad producida</th>
                    <th class="columna" v-show="FoFiltro.iniDia | FoFiltro.rango == 1">Departamento</th>
                    <th v-show="FoFiltro.iniDia | FoFiltro.rango == 1">
                        <button class="btn btn-danger" v-show="deli.elimiMasi.length > 0" @click="eliminaMasiva(deli)" >Eliminar</button>
                    </th>
                </template>
                <template v-slot:TableFooter >
                    <tr class="fila" v-for="ca in recoTabla" :key="ca.id">
                        <td v-show="FoFiltro.iniDia | FoFiltro.rango == 1">
                            <div v-if="ca.proceso.tipo == 1 | ca.proceso.tipo == 5 | ca.proceso.tipo == 3">
                                <input type="checkbox" :value="ca.id" v-model="deli.elimiMasi" class="tw-rounded-xl tw-bg-coolGray-300" :id="'indePro'+ca.id "/>
                                <label :for="'indePro'+ca.id" class="tw-px-3"> {{ca.id}} </label>
                            </div>
                            <div v-else>
                                {{ca.id}}
                            </div>
                        </td>
                        <td v-show="FoFiltro.iniDia | FoFiltro.rango == 1">{{ca.fecha}}</td>
                        <td class="">{{ca.proceso == null ? 'N/A' : ca.proceso.nompro}}</td>
                        <td v-show="FoFiltro.iniDia | FoFiltro.rango == 1">{{ca.maq_pro == null ? 'N/A' : ca.maq_pro.maquinas.Nombre}}</td>
                        <td v-show="FoFiltro.iniDia | FoFiltro.rango == 1" >
                            {{ca.dep_perf == null ? 'N/A' : ca.dep_perf.perfiles.Nombre}} {{ca.dep_perf == null ? 'N/A' : ca.dep_perf.perfiles.ApPat}} {{ca.dep_perf == null ? 'N/A' : ca.dep_perf.perfiles.ApMat}}
                        </td>
                        <td class=" tw-w-40" v-show="FoFiltro.iniDia | FoFiltro.rango == 1">
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-cyan-600 tw-rounded-full" v-if="ca.notaPen == 2">NOTA PENDIENTE</div>
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-blue-600 tw-rounded-full" v-if="ca.proceso.tipo == 3">CALCULOS</div>
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-indigo-600 tw-rounded-full" v-else-if="ca.proceso.tipo == 1 & ca.notaPen == 1">PRODUCCION</div>
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-yellow-600 tw-rounded-full" v-else-if="ca.proceso.tipo == 5 & ca.notaPen == 1">MERMA</div>
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-orange-600 tw-rounded-full" v-else-if="ca.proceso.tipo == 2 & ca.notaPen == 1">OBJETIVO</div>
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-teal-600 tw-rounded-full" v-if="ca.notaPen == 1 & ca.notas.length > 1"> - ACTUALIZADO</div>
                        </td>
                        <td  v-show="FoFiltro.iniDia | FoFiltro.rango == 1">{{ca.equipo == null ? 'N/A' : ca.equipo.nombre}}</td>
                        <td  v-show="FoFiltro.iniDia | FoFiltro.rango == 1">{{ca.turno == null ? 'N/A' : ca.turno.nomtur}}</td>
                        <td  v-show="FoFiltro.iniDia">{{ca.partida == null ? 'N/A' : ca.partida}}</td>
                        <td  v-show="FoFiltro.iniDia">{{ca.dep_mat == null ? 'N/A' : ca.dep_mat.materiales.idmat+' - '+ca.dep_mat.materiales.nommat}}</td>
                        <td  v-show="FoFiltro.iniDia">{{ca.clave == null ? 'N/A' : ca.clave.CVE_ART}}</td>
                        <td  v-show="FoFiltro.iniDia">{{ca.clave == null ? 'N/A' : ca.clave.DESCR}}</td>
                        <td >{{this.formatoMexico(ca.valor.toFixed(2))}}</td>
                        <td  v-show="FoFiltro.iniDia | FoFiltro.rango == 1"> {{ca.VerInv}} </td>
                        <td v-show="FoFiltro.iniDia | FoFiltro.rango == 1" >{{ca.dep_perf == null ? 'N/A' : ca.dep_perf.departamentos.Nombre}}</td>
                        <td v-show="FoFiltro.iniDia | FoFiltro.rango == 1">
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
                    <th class="columna" v-show="FoFiltro.iniDia | FoFiltro.rango == 1">Indice</th>
                    <th class="columna" v-show="FoFiltro.iniDia | FoFiltro.rango == 1">Fecha</th>
                    <th class="columna">Proceso</th>
                    <th class="columna" v-show="FoFiltro.iniDia | FoFiltro.rango == 1">Maquina</th>
                    <th class="columna" v-show="FoFiltro.iniDia | FoFiltro.rango == 1">Nombre</th>
                    <th class="columna" v-show="FoFiltro.iniDia | FoFiltro.rango == 1">Estatus</th>
                    <th class="columna" v-show="FoFiltro.iniDia | FoFiltro.rango == 1">Equipo</th>
                    <th class="columna" v-show="FoFiltro.iniDia | FoFiltro.rango == 1">Turno</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Partida</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Norma</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Clave</th>
                    <th class="columna" v-show="FoFiltro.iniDia">Descripción de clave</th>
                    <th class="columna">Producción</th>
                    <th class="columna" v-show="FoFiltro.iniDia | FoFiltro.rango == 1">Cantidad producida</th>
                    <th class="columna" v-show="FoFiltro.iniDia | FoFiltro.rango == 1">Departamento</th>
                    <th v-show="FoFiltro.iniDia | FoFiltro.rango == 1"></th>
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
import { watch } from '@vue/runtime-core';
import axios from 'axios';

    pdfMake.vfs = pdfFonts.pdfMake.vfs;
    window.JSZip = jszip;

    var Highcharts = require('highcharts');
    // Load module after Highcharts is loaded
    require('highcharts/modules/exporting')(Highcharts);

    export default {
        props: [
            'usuario',
            'depa',
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
            JetInput,
            Modal,
            Select2,
            JetLabel,
        },

        data() {
            return {
                color: "tw-bg-blue-600",
                style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
                S_Area: '',
                showModalC: false,
                vMasi: true,
                vCal: true,
                hoy: moment().format('YYYY-MM-DD'),
                recoTabla: [],
                recoTablaParo: [],
                deli:{
                    elimiMasi: []
                },
                docu: {
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
            carMasi(){
                const form = this.docu;
                this.$inertia.post('/Produccion/CargaExcel', form, {
                    onSuccess: (v) => { this.openModalC(), this.resetC(), this.alertSucces(), this.vMasi = true, this.arrProdu() },
                    onError: (e) => { this.vMasi = true },
                    preserveState: true
                });
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
            },
            //consulta la produccion para la tabla
            async arrProdu(){
                var datos = {}
                this.recoTabla = [];

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
                        datos = {'departamento_id': this.S_Area, 'tipo': 'rango', 'iniDia': this.FoFiltro.iniDia, 'finDia': this.FoFiltro.finDia, 'semana': null, 'mes': null}
                    }
                }
                //input semana no nulo
                else if (this.FoFiltro.semana != null) {
                    datos = {'departamento_id': this.S_Area, 'tipo': 'semana', 'iniDia': null, 'finDia': null, 'semana': this.FoFiltro.semana, 'mes': null }
                }//input mes no nulo
                else if (this.FoFiltro.mes) {
                    datos = {'departamento_id': this.S_Area, 'tipo': 'mes', 'iniDia': null, 'finDia': null, 'semana': null, 'mes': this.FoFiltro.mes }
                }


                //asigna el recorrido
                let pomesa = await axios.post('Produccion/ReportesPro/ConPro', datos)
                console.log(pomesa.data)
                this.recoTabla = pomesa.data
                //recorre la tabla
                $('#t_repo').DataTable().clear();
                $('#t_repo').DataTable().destroy();
                this.tabla()
            },
            //consulta de paros
            async arrParo(){
                console.log('paro')
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
                            onSuccess: () => { this.alertDelete(), this.deli.elimiMasi = [], this.arrProdu() },
                            onError: () => {},
                            preserveState: true
                        });
                        /* await axios.post('/Produccion/ReportesPro/' + data.elimiMasi[0], data).then(() => {this.alertDelete(), this.deli.elimiMasi = [], this.arrProdu()}) */
                    }
                })
            },
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
        },

        watch: {
            S_Area: async function(b){
                await axios.get('/Produccion/ReportesPro',{ busca: b, ano: this.ano })
                .then(() => { this.FoFiltro.iniDia = this.hoy, this.arrProdu() })
                /* await this.$inertia.get('/Produccion/ReportesPro',{ busca: b, ano: this.ano }, {
                    onSuccess: (data) => {  },
                    onError: (err) => { console.log(err)},
                    preserveState: true
                }); */
            },
        }
    }
</script>
