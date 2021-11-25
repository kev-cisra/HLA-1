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

        <div class="tw-overflow-auto md:tw-flex md:tw-justify-center">
            <div class="tw-flex tw-items-center tw-mt-2 tw-text-center tw-text-white tw-border">
                <div class="tw-m-3" @click="FiltroMes(1)">
                    <button class="EneroActivo" v-if="mes == 1">
                        <span class="mx-auto">Enero</span>
                    </button>
                    <button class="Enero" v-else>
                        <span class="mx-auto">Enero</span>
                    </button>
                </div>

                <div class="tw-m-3" @click="FiltroMes(2)">
                    <button class="FebreroActivo" v-if="mes == 2">
                        <span class="mx-auto">Febrero</span>
                    </button>
                    <button class="Febrero" v-else>
                        <span class="mx-auto">Febrero</span>
                    </button>
                </div>

                <div class="tw-m-3" @click="FiltroMes(3)">
                    <button class="MarzoActivo" v-if="mes == 3">
                        <span class="mx-auto">Marzo</span>
                    </button>
                    <button class="Marzo" v-else>
                        <span class="mx-auto">Marzo</span>
                    </button>
                </div>

                <div class="tw-m-3" @click="FiltroMes(4)">
                    <button class="AbrilActivo" v-if="mes == 4">
                        <span class="mx-auto">Abril</span>
                    </button>
                    <button class="Abril" v-else>
                        <span class="mx-auto">Abril</span>
                    </button>
                </div>

                <div class="tw-m-3" @click="FiltroMes(5)">
                    <button class="MayoActivo" v-if="mes == 5">
                        <span class="mx-auto">Mayo</span>
                    </button>
                    <button class="Mayo" v-else>
                        <span class="mx-auto">Mayo</span>
                    </button>
                </div>

                <div class="tw-m-3" @click="FiltroMes(6)">
                    <button class="JunioActivo" v-if="mes == 6">
                        <span class="mx-auto">Junio</span>
                    </button>
                    <button class="Junio" v-else>
                        <span class="mx-auto">Junio</span>
                    </button>
                </div>

                <div class="tw-m-3" @click="FiltroMes(7)">
                    <button class="JulioActivo" v-if="mes == 7">
                        <span class="mx-auto">Julio</span>
                    </button>
                    <button class="Julio" v-else>
                        <span class="mx-auto">Julio</span>
                    </button>
                </div>

                <div class="tw-m-3" @click="FiltroMes(8)">
                    <button class="AgostoActivo" v-if="mes == 8">
                        <span class="mx-auto">Agosto</span>
                    </button>
                    <button class="Agosto" v-else>
                        <span class="mx-auto">Agosto</span>
                    </button>
                </div>

                <div class="tw-m-3" @click="FiltroMes(9)">
                    <button class="SeptiembreActivo" v-if="mes == 9">
                        <span class="mx-auto">Septiembre</span>
                    </button>
                    <button class="Septiembre" v-else>
                        <span class="mx-auto">Septiembre</span>
                    </button>
                </div>

                <div class="tw-m-3" @click="FiltroMes(10)">
                    <button class="OctubreActivo" v-if="mes == 10">
                        <span class="mx-auto">Octubre</span>
                    </button>
                    <button class="Octubre" v-else>
                        <span class="mx-auto">Octubre</span>
                    </button>
                </div>

                <div class="tw-m-3" @click="FiltroMes(11)">
                    <button class="NoviembreActivo" v-if="mes == 11">
                        <span class="mx-auto">Noviembre</span>
                    </button>
                    <button class="Noviembre" v-else>
                        <span class="mx-auto">Noviembre</span>
                    </button>
                </div>

                <div class="tw-m-3" @click="FiltroMes(12)">
                    <button class="DiciembreActivo" v-if="mes == 12">
                        <span class="mx-auto">Diciembre</span>
                    </button>
                    <button class="Diciembre" v-else>
                        <span class="mx-auto">Diciembre</span>
                    </button>
                </div>

            </div>
        </div>

        <div class="tw-flex tw-justify-between tw-px-4">
            <div class="tw-flex tw-flex-wrap tw-content-center">
                <select class="InputSelect" v-model="params.Estatus" @change="FiltroEstatus($event)">
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
            <div class="tw-flex tw-flex-wrap tw-content-center tw-text-center tw-text-gray-400">
                <div class="tw-flex tw-flex-col">
                    <div class="tw-text-center">
                        <p v-if="params.Partidas == true">Vista Partidas</p>
                        <p v-else>Vista Requisiciones</p>
                    </div>
                    <div>
                        <label class="switch">
                            <input type="checkbox" @click="Visualizacion">
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>
            <div>
                <jet-button @click="openModal" class="BtnNuevo">Nueva Requisición</jet-button>
            </div>
        </div>

        <div class="tw-overflow-x-auto tw-mx-2" v-if="params.Partidas == true">
            <Table id="Articulos">
                <template v-slot:TableHeader>
                    <th class="columna">FECHA</th>
                    <th class="columna"># REQ</th>
                    <th class="columna">DEPARTAMENTO</th>
                    <th class="columna">CÓDIGO</th>
                    <th class="columna">CANTIDAD</th>
                    <th class="columna">UNIDAD</th>
                    <th class="columna">DESCRIPCIÓN</th>
                    <th class="columna">MAQUINA</th>
                    <th class="columna">MARCA</th>
                    <th class="columna">TIPO COMPRA</th>
                    <th class="columna">OBSERVACIONES</th>
                    <th class="columna">SOLICITANTE</th>
                    <th class="columna">FECHA LLEGADA</th>
                    <th class="columna">ESTATUS</th>
                    <th class="columna">ACCIONES</th>
                </template>

                <template v-slot:TableFooter>
                    <tr class="fila" v-for="datos in ArticulosRequisiciones" :key="datos.id">
                        <td class="tw-p-2">{{ datos.Fecha }}</td>
                        <td class="tw-p-2">{{ datos.articulos_requisicion.NumReq }}</td>
                        <td class="tw-p-2">{{ datos.articulos_requisicion.requisicion_departamento.Nombre }}</td>
                        <td class="tw-p-2">{{ datos.articulos_requisicion.Codigo }}</td>
                        <td class="tw-p-2">{{ datos.Cantidad }}</td>
                        <td class="tw-p-2">{{ datos.Unidad }}</td>
                        <td class="tw-p-2">{{ datos.Descripcion }}</td>
                        <td class="tw-p-2">{{ datos.articulos_requisicion.requisicion_maquina.Nombre }}</td>
                        <td class="tw-p-2">{{ datos.articulos_requisicion.requisicion_marca.Nombre }}</td>
                        <td class="tw-p-2">{{ datos.articulos_requisicion.TipCompra }}</td>
                        <td class="tw-p-2">{{ datos.articulos_requisicion.Observaciones }}</td>
                        <td class="tw-p-2">{{ datos.articulos_requisicion.requisiciones_perfil.Nombre }} {{ datos.articulos_requisicion.requisiciones_perfil.ApPat }}</td>
                        <td class="tw-p-2">{{ datos.articulos_requisicion.Fechallegada }}</td>
                        <td class="tw-p-2">
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

        <div class="tw-overflow-x-auto tw-mx-2" v-else>
            <Table id="Requisicion">
                <template v-slot:TableHeader>
                    <th class="columna">FECHA</th>
                    <th class="columna"># REQ</th>
                    <th class="columna">DEPARTAMENTO</th>
                    <th class="columna">CODIGO</th>
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
                        <td class="tw-text-center">{{ datos.Fecha }}</td>
                        <td class="tw-text-center">{{ datos.NumReq }}</td>
                        <td class="tw-text-center">{{ datos.requisicion_departamento.Nombre }}</td>
                        <td class="tw-text-center">{{ datos.Codigo }}</td>
                        <td class="tw-text-center">{{ datos.requisicion_maquina.Nombre }}</td>
                        <td class="tw-text-center">{{ datos.requisicion_marca.Nombre }}</td>
                        <td class="tw-text-center">{{ datos.TipCompra }}</td>
                        <td>{{ datos.Observaciones }}</td>
                        <td>{{ datos.requisiciones_perfil.Nombre }} {{ datos.requisiciones_perfil.ApPat }}</td>
                        <td class="tw-text-center">{{ datos.requisicion_articulos.Fechallegada }}</td>
                        <td class="tw-text-center">
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
                                <jet-input type="number" min="0" v-model="form.Cantidad"></jet-input>
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
                    <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Articulos de requisición </h3>
                </div>
            </div>
        </div>

        <div class="tw-mx-4" v-if="ArticulosRequisicion != null">
            <div v-if=" ArticulosRequisicion[0].articulo_user != null ">
                <Table>
                    <template v-slot:TableHeader>
                        <th class="columna">CANTIDAD</th>
                        <th class="columna">UNIDAD</th>
                        <th class="columna">DESCRIPCION</th>
                        <th class="columna">NUM PARTE</th>
                        <th class="columna">RECIBIDO</th>
                        <th class="columna">ESTATUS</th>
                        <th class="columna">ACCIONES</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila" v-for="art in ArticulosRequisicion" :key="art.id">
                            <td class="tw-text-center">{{ art.Cantidad }}</td>
                            <td class="tw-text-center">{{ art.Unidad }}</td>
                            <td class="tw-text-center">{{ art.Descripcion }}</td>
                            <td class="tw-text-center">{{ art.NumParte }}</td>
                            <td class="tw-text-center" >{{ art.articulo_user.name }}</td>
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
                            <td>
                                <div class="columnaIconos" v-if="art.EstatusArt == 1">
                                    <div class="iconoEdit" @click="edit(art)">
                                        <span tooltip="Editar" flow="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                                <div class="columnaIconos" v-else-if="art.EstatusArt == 9">
                                    <div class="tw-w-4 tw-mr-2 tw-transform tw-cursor-pointer hover:tw-text-green-500 hover:tw-scale-125">
                                        <span tooltip="Articulo Adquirido" flow="left">
                                            <i class="fas fa-check-square"></i>
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
                <Table>
                    <template v-slot:TableHeader>
                        <th class="columna">CANTIDAD</th>
                        <th class="columna">UNIDAD</th>
                        <th class="columna">DESCRIPCION</th>
                        <th class="columna">NUM PARTE</th>
                        <th class="columna">ESTATUS</th>
                        <th class="columna">ACCIONES</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila" v-for="art in ArticulosRequisicion" :key="art.id">
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
                            <td>
                                <div class="columnaIconos" v-if="art.EstatusArt == 1">
                                    <div class="iconoEdit" @click="edit(art)">
                                        <span tooltip="Editar" flow="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                                <div class="columnaIconos" v-else-if="art.EstatusArt == 9">
                                    <div class="tw-w-4 tw-mr-2 tw-transform tw-cursor-pointer hover:tw-text-green-500 hover:tw-scale-125">
                                        <span tooltip="Articulo Adquirido" flow="left">
                                            <i class="fas fa-check-square"></i>
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
        </div>
        <div v-else>
            <p>Esta requisición no tiene partidas asignadas</p>
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
            Vista: true,
            showPartidas: false,
            showModal2: false,
            min: moment().format("YYYY-MM-DD"),
            now: moment().format("YYYY-MM-DD"),
            tam: "5xl",
            color: "tw-bg-cyan-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
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
                month: '',
                Estatus: '',
                Req: '',
                Partidas: true,
            },
            MaquinasDpto:[],
            Marcas: [],
        };
    },

    mounted() {
        this.tablaArticulos();
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
        Requisiciones: Object,
        ArticulosRequisiciones: Object,
        ArticulosRequisicion: Object,
        Departamentos: Object,
        Maquinas: Object,
        PerfilesUsuarios: Object,
        Almacen: Number,
        Cotizacion: Number,
        Autorizados: Number,
        Confirmado: Number,
        mes: String,
    },

    methods: {

        Visualizacion(){ //Cambio de visualizacion por partidas o articulos
            this.params.Partidas  = !this.params.Partidas;

            if (this.params.Partidas == true){
                $('#Articulos').DataTable().clear(); //limpio
                $('#Articulos').DataTable().destroy(); //destruyo tabla
                this.$inertia.get('/Compras/Requisiciones', this.params , { //envio de variables por url
                    onSuccess: () => {
                        this.tablaArticulos()
                    }, preserveState: true})
            }else{
                $('#Requisicion').DataTable().clear(); //limpio
                $('#Requisicion').DataTable().destroy(); //destruyo tabla
                this.$inertia.get('/Compras/Requisiciones', this.params , { //envio de variables por url
                    onSuccess: () => {
                        this.tabla() //regeneracion de tabla
                    }, preserveState: true})
            }
        },

        //Generacion de Tabla con Datatables
        tabla(){
            this.$nextTick(() => {
                $("#Requisicion").DataTable({
                    "language": this.español,
                    pageLength: 25,
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
            $("#Requisicion").DataTable().destroy();
                this.$inertia.get("/Compras/Requisiciones", { busca: event.target.value },{
                    onSuccess: () => {
                        this.tabla();
                    },
                });
        },

        //Generacion de Tabla con Datatables
        tablaArticulos(){
            this.$nextTick(() => {
                $("#Articulos").DataTable({
                    "language": this.español,
                    pageLength: 25,
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
                        'colvis'
                    ]
                });
            });
        },

        //Consulta para generar datos de la tabla
        verTablaArticulos(event) {
            $("#Articulos").DataTable().destroy();
                this.$inertia.get("/Compras/Requisiciones", { busca: event.target.value },{
                    onSuccess: () => {
                        this.tablaArticulos();
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

        FiltroMes(value){
            //Filtro para consultar por mes
            this.params.month = value;
            this.params.Estatus = ''; //limpio el estatus para consultar solo por Mes
            $('#Requisicion').DataTable().clear(); //limpio
            $('#Requisicion').DataTable().destroy(); //destruyo tabla
            this.$inertia.get('/Compras/Requisiciones', this.params , { //envio de variables por url
                onSuccess: () => {
                    this.tabla() //regeneracion de tabla
                }, preserveState: true})
        },

        FiltroEstatus(value){
            this.params.Estatus = event.target.value;

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
            //Visualizacion de articulos pertenecientes a la requisicion
            this.params.Req = data.id;
            this.form.ReqId = data.id;
            this.form.Codigo = data.Codigo;
            this.form.Departamento_id = data.Departamento_id;
            this.form.Fecha = data.Fecha;
            this.form.NumReq = data.NumReq;
            this.form.Maquina = data.Maquina_id;
            this.form.Tipo = data.TipCompra;
            this.form.Nombre = data.Perfil_id;
            this.form.Observaciones = data.Observaciones;

            axios.get('/Compras/Marcas',{
                params: {
                    Maquina: this.form.Maquina
                }
            })
            .then(response => this.Marcas = response.data.Marcas)
            .catch(error => console.log(error))

            this.$inertia.get('/Compras/Requisiciones', this.params , {
                onSuccess: () => {
                    this.chagePartidas();
                },preserveState: true})
        },

        save(data) {
            this.$inertia.post("/Compras/Requisiciones", data, {
                onSuccess: () => {
                    this.reset(),
                    this.chageClose(),
                    this.alertSucces();
                },
            });
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
