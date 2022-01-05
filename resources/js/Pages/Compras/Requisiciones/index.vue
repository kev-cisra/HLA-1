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

        <div class="tw-flex tw-items-center tw-justify-center tw-mt-4">
            <div class="tw-w-full tw-mx-auto tw-max-w-7xl sm:tw-px-8 lg:tw-px-10">
                <div class="tw-flex tw-flex-col tw-w-full tw-mb-2 tw-space-y-8 lg:tw-flex-row lg:tw-space-x-10 lg:tw-space-y-0 lg:tw-mb-4">

                    <div class="tw-w-full tw-cursor-pointer lg:tw-w-1/4" @click="FiltroIndicadores(8)">
                        <div class="tw-w-full tw-p-2 tw-bg-white tw-border-l-4 tw-border-green-400 tw-rounded-lg tw-widget">
                            <div class="tw-flex tw-items-center">
                                <div class="icon tw-w-10 tw-p-2 tw-bg-green-400 tw-text-white tw-rounded-full tw-mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
                                    </svg>
                                </div>
                                <div class="tw-flex tw-flex-col tw-justify-center">
                                    <div class="tw-text-lg">{{Almacen}}</div>
                                    <div class="tw-text-xs tw-text-gray-400">Pendientes por recoger en almacén</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tw-w-full tw-cursor-pointer lg:tw-w-1/4" @click="FiltroIndicadores(3)">
                        <div class="tw-w-full tw-p-2 tw-bg-white tw-border-l-4 tw-border-indigo-400 tw-rounded-lg tw-widget">
                            <div class="tw-flex tw-items-center">
                                <div class="icon tw-w-10 tw-p-2 tw-bg-indigo-400 tw-text-white tw-rounded-full tw-mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
                                    </svg>
                                </div>
                                <div class="tw-flex tw-flex-col tw-justify-center">
                                    <div class="tw-text-lg"> {{ Cotizacion }} </div>
                                    <div class="tw-text-xs tw-text-gray-400">Requisiciones en Cotización</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tw-w-full tw-cursor-pointer lg:tw-w-1/4" @click="FiltroIndicadores(6)">
                        <div class="tw-w-full tw-p-2 tw-bg-white tw-border-l-4 tw-border-cyan-600 tw-rounded-lg tw-widget">
                            <div class="tw-flex tw-items-center">
                                <div class="icon tw-w-10 tw-p-2 tw-bg-cyan-600 tw-text-white tw-rounded-full tw-mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
                                    </svg>
                                </div>
                                <div class="tw-flex tw-flex-col tw-justify-center">
                                    <div class="tw-text-lg"> {{ Autorizados }} </div>
                                    <div class="tw-text-xs tw-text-gray-400">Requisiciones Autorizados</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tw-w-full tw-cursor-pointer lg:tw-w-1/4" @click="FiltroIndicadores(7)">
                        <div class="tw-w-full tw-p-2 tw-bg-white tw-border-l-4 tw-border-fuchsia-600 tw-rounded-lg tw-widget">
                            <div class="tw-flex tw-items-center">
                                <div class="icon tw-w-10 tw-p-2 tw-bg-fuchsia-600 tw-text-white tw-rounded-full tw-mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
                                    </svg>
                                </div>
                                <div class="tw-flex tw-flex-col tw-justify-center">
                                    <div class="tw-text-lg"> {{ Confirmado }} </div>
                                    <div class="tw-text-xs tw-text-gray-400">En proceso de Pago</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="tw-flex tw-justify-between tw-content-center tw-border tw-p-2 tw-mb-4">
            <div class="tw-flex tw-gap-4">
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
                    <jet-label class="tw-text-center">ESTATUS</jet-label>
                    <select class="InputSelect" v-model="params.Status">
                        <option value="0">TODOS</option>
                        <option value="1">SIN ENVIAR</option>
                        <option value="2">SOLICITADO</option>
                        <option value="3">EN COTIZACION</option>
                        <option value="5">EN AUTORIZACION</option>
                        <option value="6">AUTORIZADO</option>
                        <option value="7">CONFIRMADOS</option>
                        <option value="8">EN ALMACEN</option>
                        <option value="9">ENTREGADO</option>
                    </select>
                </div>

                <div>
                    <jet-label class="tw-text-center">VISTA</jet-label>
                    <select class="InputSelect" v-model="params.View" @change="TipoVista">
                        <option value="1">PARTIDAS</option>
                        <option value="2">REQUISICION</option>
                    </select>
                </div>

                <div class="tw-mt-4">
                    <jet-button v-if="loading == true" @click="Filtros" class="BtnFiltros">
                        <span class="tw-animate-ping tw-relative tw-inline-flex tw-rounded-full tw-h-2 tw-w-2 tw-mr-2 tw-bg-coolGray-100"></span>
                        <!-- <span class="spinner-grow spinner-grow-sm tw-mr-2" role="status" aria-hidden="true"></span> -->
                        <p class="tw-animate-pulse">Cargando </p>
                    </jet-button>
                    <jet-button v-else @click="Filtros" class="BtnFiltros"> <i class="fas fa-filter tw-mr-1"></i> Aplica Filtros
                    </jet-button>
                </div>
            </div>

            <div>
                <div>
                    <jet-button @click="openModal" class="BtnNuevo">Nueva Requisición</jet-button>
                </div>
            </div>
        </div>

        <div class="tw-mx-2">
            <p class="tw-text-center tw-text-coolGray-400">VISUALIZACIÓN POR {{Visualizacion}}</p>
            <div v-if="Vista == 1">
                <Table id="Requisiciones">
                    <template v-slot:TableHeader>
                        <th class="columna">FECHA</th>
                        <th class="columna">REQ</th>
                        <th class="columna">O.C</th>
                        <th class="columna">DEPARTAMENTO</th>
                        <th class="columna">COD</th>
                        <th class="columna">CANT</th>
                        <th class="columna">UNIDAD</th>
                        <th class="columna">DESCRIPCIÓN</th>
                        <th class="columna">MAQUINA</th>
                        <th class="columna">MARCA</th>
                        <th class="columna">TIPO COMPRA</th>
                        <th class="columna">OBSERVACIONES</th>
                        <th class="columna">SOLICITANTE</th>
                        <th class="columna">LLEGADA</th>
                        <th class="columna">ESTATUS</th>
                        <th class="columna">ACCIONES</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila" v-for="datos in Requisiciones" :key="datos.id">
                            <td>{{ datos.Fecha.substr(5) }}</td>
                            <td>{{ datos.articulos_requisicion.NumReq }}</td>
                            <td>{{ datos.articulos_requisicion.OrdenCompra }}</td>
                            <td>{{ datos.articulos_requisicion.requisicion_departamento.Nombre }}</td>
                            <td class="tw-text-center">{{ datos.articulos_requisicion.Codigo.substr(0,1) }}</td>
                            <td class="tw-text-center">{{ datos.Cantidad }}</td>
                            <td class="tw-text-center">{{ datos.Unidad }}</td>
                            <td>{{ datos.Descripcion }}</td>
                            <td>{{ datos.articulos_requisicion.requisicion_maquina.Nombre }}</td>
                            <td>{{ datos.articulos_requisicion.requisicion_marca.Nombre }}</td>
                            <td>{{ datos.articulos_requisicion.TipCompra }}</td>
                            <td>{{ datos.articulos_requisicion.Observaciones }}</td>
                            <td>{{ datos.articulos_requisicion.requisiciones_perfil.Nombre }} {{ datos.articulos_requisicion.requisiciones_perfil.ApPat }}</td>
                            <td>{{ datos.articulos_requisicion.Fechallegada }}</td>
                            <td>
                                <div v-if="datos.EstatusArt == 1">
                                    <span tooltip="SIN ENVIAR" flow="left">
                                        <span class="tw-inline-flex tw-text-xxs tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-gray-400 tw-rounded-full">
                                            SIN ENVIAR</span>
                                    </span>
                                </div>
                                <div v-else-if="datos.EstatusArt == 2">
                                    <span tooltip="Solicitada" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-text-xxs tw-h-6 tw-px-3 tw-text-white tw-bg-violet-400 tw-rounded-full">SOLICITADO</span>
                                    </span>
                                </div>
                                <div v-else-if="datos.EstatusArt == 3 || datos.Estatus == 4">
                                    <span tooltip="En Espera de Cotización" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-text-xxs tw-h-6 tw-px-3 tw-text-white tw-bg-violet-600 tw-rounded-full">COTIZACIÓN</span>
                                    </span>
                                </div>
                                <div v-else-if="datos.EstatusArt == 5">
                                    <span tooltip="EN ESPERA DE AUTORIZACIÓN" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-text-xxs tw-h-6 tw-px-3 tw-text-white tw-bg-orange-600 tw-rounded-full">AUTORIZACION</span>
                                    </span>
                                </div>
                                <div v-else-if="datos.EstatusArt == 6">
                                    <span tooltip="ARTICULO AUTORIZADO" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-cyan-600 tw-rounded-full">AUTORIZADO</span>
                                    </span>
                                </div>
                                <div v-else-if="datos.EstatusArt == 7">
                                    <span tooltip="ARTICULO AUTORIZADO" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-fuchsia-600 tw-rounded-full">CONFIRMADO</span>
                                    </span>
                                </div>
                                <div v-else-if="datos.EstatusArt == 8">
                                    <span tooltip="Pasa por el articulo a almacén" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-green-600 tw-rounded-full">ALMACEN</span>
                                    </span>
                                </div>
                                <div v-else-if="datos.EstatusArt == 9">
                                    <span tooltip="Entregado" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-font-semibold tw-text-white tw-bg-teal-600 tw-rounded-full">ENTREGADO</span>
                                    </span>
                                </div>
                                <div v-else-if="datos.EstatusArt == 10">
                                    <span tooltip="Cotizacion Rechazada" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-font-semibold tw-text-white tw-bg-red-500 tw-rounded-full">COTIZACION RECHAZADA</span>
                                    </span>
                                </div>
                            </td>
                            <td class="fila">
                                <div class="columnaIconos" v-if="datos.EstatusArt == 1">
                                    <div class="iconoPurple" @click="ConfirmaReq(datos)">
                                        <span tooltip="Confirmar Requisición" flow="left">
                                            <i class="fas fa-check-circle"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="columnaIconos" v-else>
                                    <div class="tw-w-4 tw-mr-2 tw-transform tw-cursor-pointer hover:tw-text-green-500 hover:tw-scale-125">
                                        <span tooltip="En proceso" flow="left">
                                            <i class="fas fa-thumbs-up"></i>
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>
                </Table>
            </div>

            <div v-else>
                <Table id="Requisiciones">
                    <template v-slot:TableHeader>
                        <th class="columna">FECHA</th>
                        <th class="columna">REQ</th>
                        <th class="columna">O.C</th>
                        <th class="columna">DEPARTAMENTO</th>
                        <th class="columna">COD</th>
                        <th class="columna">MAQUINA</th>
                        <th class="columna">MARCA</th>
                        <th class="columna">TIPO COMPRA</th>
                        <th class="columna">OBSERVACIONES</th>
                        <th class="columna">SOLICITANTE</th>
                        <th>FEC LLEGADA</th>
                        <th class="columna">ESTATUS</th>
                        <th class="columna">ACCIONES</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila" v-for="datos in Requisiciones" :key="datos.id">
                            <td>{{ datos.Fecha.substr(5) }}</td>
                            <td>{{ datos.NumReq }}</td>
                            <td>{{ datos.OrdenCompra }}</td>
                            <td>{{ datos.requisicion_departamento.Nombre }}</td>
                            <td class="tw-text-center">{{ datos.Codigo.substr(0,1) }}</td>
                            <td>{{ datos.requisicion_maquina.Nombre }}</td>
                            <td>{{ datos.requisicion_marca.Nombre }}</td>
                            <td>{{ datos.TipCompra }}</td>
                            <td>{{ datos.Observaciones }}</td>
                            <td>{{ datos.requisiciones_perfil.Nombre }} {{ datos.requisiciones_perfil.ApPat }}</td>
                            <td>{{ datos.requisicion_articulos.Fechallegada }}</td>
                            <td>
                                <div v-if="datos.Estatus == 1">
                                    <span tooltip="SIN ENVIAR" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-gray-400 tw-rounded-full">
                                            SIN ENVIAR</span>
                                    </span>
                                </div>
                                <div v-else-if="datos.Estatus == 2">
                                    <span tooltip="Solicitada" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-violet-400 tw-rounded-full">SOLICITADO</span>
                                    </span>
                                </div>
                                <div v-else-if="datos.Estatus == 3 || datos.Estatus == 4">
                                    <span tooltip="En Espera de Cotización" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-violet-600 tw-rounded-full">EN COTIZACIÓN</span>
                                    </span>
                                </div>
                                <div v-else-if="datos.Estatus == 5">
                                    <span tooltip="EN ESPERA DE AUTORIZACIÓN" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-orange-600 tw-rounded-full">EN AUTORIZACION</span>
                                    </span>
                                </div>
                                <div v-else-if="datos.Estatus == 6">
                                    <span tooltip="ARTICULO AUTORIZADO" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-cyan-600 tw-rounded-full">AUTORIZADO</span>
                                    </span>
                                </div>
                                <div v-else-if="datos.Estatus == 7">
                                    <span tooltip="ARTICULO AUTORIZADO" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-fuchsia-600 tw-rounded-full">CONFIRMADO</span>
                                    </span>
                                </div>
                                <div v-else-if="datos.Estatus == 8">
                                    <span tooltip="Pasa por el articulo a almacén" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-green-600 tw-rounded-full">EN ALMACEN</span>
                                    </span>
                                </div>
                                <div v-else-if="datos.Estatus == 9">
                                    <span tooltip="Entregado" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-font-semibold tw-text-white tw-bg-teal-600 tw-rounded-full">ENTREGADO</span>
                                    </span>
                                </div>
                                <div v-else-if="datos.Estatus == 10">
                                    <span tooltip="Cotizacion Rechazada" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-font-semibold tw-text-white tw-bg-red-500 tw-rounded-full">COTIZACION RECHAZADA</span>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="columnaIconos">
                                    <div class="iconoDetails" @click="Partidas(datos)">
                                        <span tooltip="Visualización de Partidas de la Requisicion" flow="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="iconoPurple" @click="ConfirmaRequicision(datos, 2)" v-if="datos.Estatus == 1">
                                        <span tooltip="Confirmar Requisición" flow="left">
                                            <i class="fas fa-check-circle"></i>
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
                                <jet-input type="date" :min="min" v-model="form.Fecha"></jet-input>
                                <small v-if="errors.Fecha" class="validation-alert">{{errors.Fecha}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>AREA</jet-label>
                                <select id="Departamento" v-model="form.Departamento_id" class="InputSelect" @change="loadMaquinas($event)">
                                    <option v-for="dpto in Departamentos" :key="dpto.id" :value="dpto.id" > {{ dpto.Nombre }}</option>
                                </select>
                                <small v-if="errors.Departamento_id" class="validation-alert">{{errors.Departamento_id}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>Num Requisicion</jet-label>
                                <jet-input type="text" v-model="form.NumReq"></jet-input>
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
                                    <option v-for="maq in MaquinasDpto" :key="maq.id" :value="maq.id"> {{ maq.Nombre }}</option>
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
                            <div class="tw-px-3">
                                <input type="button" @click="addRow()" value="Añadir Partida" class="BtnCancel">
                            </div>
                        </div>
                        <div class="tw-mb-6 md:tw-flex" v-for="(form) in form.Partida" :key="form.id">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                                <jet-label><span class="required">*</span>CANTIDAD</jet-label>
                                <jet-input type="number" min="1" v-model="form.Cantidad"></jet-input>
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
                                    <option value="CUBETA">CUBETA</option>
                                    <option value="OTRO">OTRO</option>
                                </select>
                                <small v-if="errors.Unidad" class="validation-alert">{{errors.Unidad}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                                <jet-label>NÚM PARTE</jet-label>
                                <jet-input type="text" v-model="form.NumParte" @input="(val) => (form.NumParte = form.NumParte.toUpperCase())"></jet-input>
                                <small v-if="errors.NumParte" class="validation-alert">{{errors.NumParte}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-5/12 md:tw-mb-0">
                                <jet-label><span class="required">*</span>DESCRIPCIÓN</jet-label>
                                <jet-input type="text" v-model="form.Descripcion" @input="(val) => (form.Descripcion = form.Descripcion.toUpperCase())"></jet-input>
                                <small v-if="errors.Descripcion" class="validation-alert">{{errors.Descripcion}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/12 md:tw-mb-0">
                                <button type="button" class="btn btn-primary" @click="removeRow(index)">Quitar</button>
                            </div>
                        </div>
                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                                <jet-label><span class="required">*</span>OBSERVACIONES</jet-label>
                                <textarea name="" id="" cols="2" v-model="form.Observaciones" @input="(val) => (form.Observaciones = form.Observaciones.toUpperCase())" class="tw-bg-gray-200 tw-text-gray-500 tw-font-semibold focus:tw-outline-none focus:tw-shadow-outline tw-border tw-border-gray-300 tw-rounded-lg tw-py-2 tw-px-4 tw-block tw-w-full tw-appearance-none tw-shadow-sm"></textarea>
                                <small v-if="errors.Observaciones" class="validation-alert">{{errors.Observaciones}}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ModalFooter">
                <jet-button type="button" @click="save(form)" v-show="!editMode">Guardar</jet-button>
                <jet-CancelButton @click="chageClose">Cerrar</jet-CancelButton>
            </div>
        </form>
    </modal>

    <modal :show="showModal2" @close="chageClose2" :maxWidth="tam">
        <form>
            <div class="tw-px-4 tw-py-4">
                <div class="tw-text-lg">
                    <div class="ModalHeader">
                        <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Edita Partida de la Requisición</h3>
                    </div>
                </div>

                <div class="tw-mt-4">
                    <div class="ModalForm">
                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>FECHA</jet-label>
                                <jet-input type="date" :min="min" v-model="form.Fecha"></jet-input>
                                <small v-if="errors.Fecha" class="validation-alert">{{errors.Fecha}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>AREA</jet-label>
                                <select  v-model="form.Departamento_id" class="InputSelect">
                                    <option v-for="dpto in Departamentos" :key="dpto.id" :value="dpto.id" > {{ dpto.Nombre }}</option>
                                </select>
                                <small v-if="errors.Fecha" class="validation-alert">{{errors.Fecha}}</small>
                            </div>
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                                <jet-label><span class="required">*</span>Num Requisicion</jet-label>
                                <jet-input type="text" v-model="form.NumReq"></jet-input>
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
                            <div class="tw-px-3 tw-mb-6 md:tw-w-8/12 md:tw-mb-0">
                                <jet-label><span class="required">*</span>DESCRIPCIÓN</jet-label>
                                <jet-input type="text" v-model="form.Descripcion" @input="(val) => (form.Descripcion = form.Descripcion.toUpperCase())"></jet-input>
                                <small v-if="errors.Descripcion" class="validation-alert">{{errors.Descripcion}}</small>
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
                <jet-button type="button" @click="update(form)">Actualizar</jet-button>
                <jet-CancelButton @click="chageClose">Cerrar</jet-CancelButton>
            </div>
        </form>
    </modal>

    <modal :show="showPartidas" @close="chagePartidas" :maxWidth="tam">
        <div class="tw-px-4 tw-py-4">
            <div class="tw-text-lg">
                <div class="ModalHeader">
                    <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Articulos de requisición {{ Requi.NumReq }}</h3>
                </div>
            </div>
        </div>

        <div class="tw-mx-4">
            <div>
                <p class="tw-text-center tw-p-2 tw-text-coolGray-400 tw-text-xs"> -- Requisición --</p>
                <Table>
                    <template v-slot:TableHeader>
                        <th class="columna">FECHA</th>
                        <th class="columna">NUM REQ</th>
                        <th class="columna">DEPARTAMENTO</th>
                        <th class="columna">MAQUINA</th>
                        <th class="columna">MARCA</th>
                        <th class="columna">OBSERVACIONES</th>
                    </template>
                    <template v-slot:TableFooter>
                        <tr class="fila">
                            <td class="tw-text-center">{{ Requi.Fecha }}</td>
                            <td class="tw-text-center">{{ Requi.NumReq }}</td>
                            <td class="tw-text-center">{{ Requi.requisicion_departamento.Nombre }}</td>
                            <td class="tw-text-center">{{ Requi.requisicion_maquina.Nombre }}</td>
                            <td class="tw-text-center">{{ Requi.requisicion_marca.Nombre }}</td>
                            <td class="tw-text-center">{{ Requi.Observaciones }}</td>
                        </tr>
                    </template>
                </Table>
            </div>

            <div>
                <p class="tw-text-center tw-p-2 tw-text-coolGray-400 tw-text-xs"> -- Articulos --</p>
                <Table>
                    <template v-slot:TableHeader>
                        <th class="columna">CANTIDAD</th>
                        <th class="columna">UNIDAD</th>
                        <th class="columna">DESCRIPCION</th>
                        <th class="columna">NUM PARTE</th>
                        <th class="columna">ESTATUS</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila" v-for="art in Requi.requisicion_articulos" :key="art.id">
                            <td class="tw-text-center">{{ art.Cantidad }}</td>
                            <td class="tw-text-center">{{ art.Unidad }}</td>
                            <td class="tw-text-center">{{ art.Descripcion }}</td>
                            <td class="tw-text-center">{{ art.NumParte }}</td>
                            <td class="tw-text-center">
                                <div v-if="art.EstatusArt == 1">
                                    <span tooltip="SIN ENVIAR" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-gray-400 tw-rounded-full">
                                            SIN ENVIAR</span>
                                    </span>
                                </div>
                                <div v-else-if="art.EstatusArt == 2">
                                    <span tooltip="Solicitada" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-violet-400 tw-rounded-full">SOLICITADO</span>
                                    </span>
                                </div>
                                <div v-else-if="art.EstatusArt == 3 || art.EstatusArt == 4">
                                    <span tooltip="En Espera de Cotización" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-violet-600 tw-rounded-full">EN COTIZACIÓN</span>
                                    </span>
                                </div>
                                <div v-else-if="art.EstatusArt == 5">
                                    <span tooltip="EN ESPERA DE AUTORIZACIÓN" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-orange-600 tw-rounded-full">EN AUTORIZACION</span>
                                    </span>
                                </div>
                                <div v-else-if="art.EstatusArt == 6">
                                    <span tooltip="ARTICULO AUTORIZADO" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-cyan-600 tw-rounded-full">AUTORIZADO</span>
                                    </span>
                                </div>
                                <div v-else-if="art.EstatusArt == 7">
                                    <span tooltip="ARTICULO AUTORIZADO" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-fuchsia-600 tw-rounded-full">CONFIRMADO</span>
                                    </span>
                                </div>
                                <div v-else-if="art.EstatusArt == 8">
                                    <span tooltip="Pasa por el articulo a almacén" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-green-600 tw-rounded-full">EN ALMACEN</span>
                                    </span>
                                </div>
                                <div v-else-if="art.EstatusArt == 9">
                                    <span tooltip="Entregado" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-font-semibold tw-text-white tw-bg-teal-600 tw-rounded-full">ENTREGADO</span>
                                    </span>
                                </div>
                                <div v-else-if="art.EstatusArt == 10">
                                    <span tooltip="Cotizacion Rechazada" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-font-semibold tw-text-white tw-bg-red-500 tw-rounded-full">COTIZACION RECHAZADA</span>
                                    </span>
                                </div>
                            </td>
                        </tr>
                    </template>
                </Table>
            </div>
        </div>

        <div class="ModalFooter">
            <jet-CancelButton @click="chagePartidas">Cerrar</jet-CancelButton>
        </div>
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
import JetLabel from '@/Jetstream/Label';
import JetInput from "@/Components/Input";
import JetSelect from "@/Components/Select";
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
window.JSZip = jszip
//Moment Js
import moment from 'moment';
import 'moment/locale/es';
import throttle from 'lodash/throttle'
export default {

    data() {
        return {
            showPartidas: false,
            showModal2: false,
            loading: false,
            min: moment().format("YYYY-MM-DD"),
            now: moment().format("YYYY-MM-DD"),
            anio: moment().format("YYYY"),
            tam: "5xl",
            color: "tw-bg-cyan-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            opc: '<option value="" disabled>Año</option>',
            detalles: '',
            form: {
                ReqId: '',
                ArtId: '',
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
                Fecha: new Date(),
                Departamento_id: '',
                NumReq: '',
                Codigo: '',
                Maquina: '',
                Marca: '',
                Tipo: '',
                Nombre: '',
                Partida: [{
                    Cantidad: '',
                    Unidad: '',
                    Descripcion: '',
                    NumParte: '',
                    }],
                Observaciones: '',
            },
            params:{
                Year: moment().format("YYYY"),
                Month: this.mes,
                Status: 0,
                View: 1,
                Req: '',
            },
            CambioVista: 1,
            Cambio: false,
            Visualizacion: 'PARTIDAS',
            MaquinasDpto:[], //Arreglo para select dinamico
            Marcas: [], //Arreglo para select dinamico
            Requi: [], //Arreglo para asignar detallle de Requisicion
        };
    },

    Created(){
        this.params.Month = this.mes;
    },

    mounted() {
        this.$nextTick(() => {
            this.tabla();
        });

        var query  = window.location.search.substring(1);
        var vars = query.split("&");
            for (var i=0; i < vars.length; i++) {
                var pair = vars[i].split("=");
                if(pair[0] == 'View') {
                    this.params.View = pair[1];
                }
        }

        if(this.params.View == 1){
            this.Visualizacion = 'PARTIDAS';
        }else{
            this.Visualizacion = 'REQUISICIÓN';
        }
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
    },

    props: {
        Session: Object,
        errors: Object,
        Requisiciones: Object,
        Departamentos: Object,
        Maquinas: Object,
        PerfilesUsuarios: Object,
        Almacen: Number,
        Cotizacion: Number,
        Autorizados: Number,
        Confirmado: Number,
        mes: String,
        Vista: String,
    },

    methods: {

        TipoVista(){
            //Obtengo la variable de la URl
            var query  = window.location.search.substring(1);
            var vars = query.split("&");
                for (var i=0; i < vars.length; i++) {
                    var pair = vars[i].split("=");
                    if(pair[0] == 'View') {
                        this.CambioVista = pair[1];
                    }
            }
            //Verifico si coincide el cambio
            if(this.CambioVista != this.params.View){
                this.Cambio = true;
            }else{
                this.Cambio = false;
            }
        },

        Filtros(){
            this.loading = true;
            $('#Requisiciones').DataTable().clear();
            $('#Requisiciones').DataTable().destroy();
            this.$inertia.get('/Compras/Requisiciones', this.params , { //envio de variables por url
                onSuccess: () => {
                    this.loading = false;
                    this.tabla();
                    //Verifico si hubo un cambio en la vista
/*                     if(this.Cambio == true){
                        location.reload();
                    } */
                }, preserveState: true})
        },

        //Generacion de Tabla con Datatables
        tabla(){
            this.$nextTick(() => {
                $("#Requisiciones").DataTable({
                    "language": this.español,
                    paging: true,
                    "scrollX": true,
                    scrollY:  '40vh',
                    "order": [0, 'desc'],
                    "columnDefs": [
                        { "width": "1%", "targets": [0] },
                        { "width": "5%", "targets": [4] },
                        { "width": "3%", "targets": [1,2,3,5,6,7] },
                        // { "width": "9%", "targets": [6,7] },
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
                });
            });
        },

        //Consulta para generar datos de la tabla
        verTabla(event) {
            $("#Requisiciones").DataTable().destroy();
                this.$inertia.get("/Compras/Requisiciones", { busca: event.target.value },{
                    onSuccess: () => {
                        this.tabla();
                    },
                });
        },

        openModal2() {
            this.chageClose2();
            this.editMode2 = false;
        },

        chageClose2() {
            this.showModal2 = !this.showModal2;
        },

        chagePartidas() {
            this.showPartidas = !this.showPartidas;
        },

        reset() {
            this.form = {
                editId: '',
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
                Fecha: new Date(),
                Departamento_id: '',
                NumReq: '',
                Codigo: '',
                Maquina: '',
                Marca: '',
                Tipo: '',
                Nombre: '',
                Partida: [{
                    Cantidad: '',
                    Unidad: '',
                    Descripcion: '',
                    NumParte: '',
                    }],
                Observaciones: '',
            };
        },

        loadMaquinas(event) {
            //Funcion para extraer de un controlador externo las maquinas pertenecientes al Departamento
            axios.get('/Compras/Maquinas',{
                params: {
                    Departamento: event.target.value
                }
            })
            .then(response => this.MaquinasDpto = response.data.Marcas)
            .catch(error => console.log(error))
        },

        loadMarcas(event) {
            // Funcion para extraer de un controlador externo las marcas pertenecientes a la maquina
            axios.get('/Compras/Marcas',{
                params: {
                    Maquina: event.target.value
                }
            })
            .then(response => this.Marcas = response.data.Marcas)
            .catch(error => console.log(error))
        },

        FiltroIndicadores(value){
            //Filtro para consultar solo por el estatus
            this.params.Estatus = value;
            this.params.month = '';
            $('#Requisicion').DataTable().clear(); //limpio
            $('#Requisicion').DataTable().destroy(); //destruyo tabla
            this.$inertia.get('/Compras/Requisiciones', this.params , { //envio de variables por url
                onSuccess: () => {
                    location.reload(); //Recargo pagina para evitar conflictos de la regeneracion de la tabla
                    this.tabla() //regeneracion de tabla
                }, preserveState: true})
        },

        addRow: function () {
            //Funcion para añadir inputs dinamicos
            this.form.Partida.push({Part: ""});
        },

        removeRow: function (row) {
            //Quitar del arreglo los inputs dinamicos
            this.form.Partida.splice(row,1);
        },

        Partidas(data){
            this.Requi = data;
            this.chagePartidas();
        },

        save(data) {
            var fechaForm = moment(data.Fecha).format("YYYY");
            if(this.anio == fechaForm){
                this.$inertia.post("/Compras/Requisiciones", data, {
                    onSuccess: () => {
                        // location.reload();
                        this.reset(),
                        this.chageClose(),
                        this.alertSucces();
                    },
                });
            }else{
                Swal.fire({
                    icon: 'info',
                    title: 'Oops...',
                    text: 'FECHA CORRESPONDIENTE AL AÑO PASADO!',
                })
            }
        },

        edit: function (data) {
            this.form.ArtId = data.id;
            this.form.Cantidad = data.Cantidad;
            this.form.Unidad = data.Unidad;
            this.form.Descripcion = data.Descripcion;
            this.chagePartidas();
            this.chageClose2();
        },

        update(data) {
            data.metodo = 1;
            data._method = "PUT";
            this.$inertia.post("/Compras/Requisiciones/" + data.id, data, {
                onSuccess: () => {
                    this.reset(),
                    this.chageClose2(),
                    this.alertSucces();
                },
            });
        },

        ConfirmaRequicision(data, metodo){ //Confirma Requisicion total
            data.metodo = 2;
            data._method = "PUT";
            this.$inertia.post("/Compras/Requisiciones/" + data.id, data, {
                onSuccess: () => {
                    this.alertSucces();
                },
            });
        },

        ConfirmaReq(data){ //Confirma Requisicion completa por Partida
            data.metodo = 3;
            data._method = "PUT";
            this.$inertia.post("/Compras/Requisiciones/" + data.id, data, {
                onSuccess: () => {
                    this.alertSucces();
                },
            });
        }

    },

};
</script>
