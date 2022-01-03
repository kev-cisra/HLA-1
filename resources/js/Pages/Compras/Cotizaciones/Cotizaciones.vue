<template>
  <app-layout>
    <div class="uppercase tw-mx-4">
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-user tw-ml-3 tw-mr-3"></i>
                        Requisiciones Solicitadas
                </h3>
            </slot>
        </Header>
    </div>

    <div class="tw-flex tw-items-center tw-justify-center tw-mt-4">
        <div class="tw-w-full tw-mx-auto tw-max-w-7xl sm:tw-px-8 lg:tw-px-10">
            <div class="tw-flex tw-flex-col tw-w-full tw-mb-2 tw-space-y-8 lg:tw-flex-row lg:tw-space-x-10 lg:tw-space-y-0 lg:tw-mb-4">

                <div class="tw-w-full tw-cursor-pointer lg:tw-w-1/4">
                    <div class="tw-w-full tw-p-2 tw-bg-white tw-border-l-4 tw-border-violet-500 tw-rounded-lg tw-widget">
                        <div class="tw-flex tw-items-center">
                            <div class="icon tw-w-10 tw-p-2 tw-bg-violet-500 tw-text-white tw-rounded-full tw-mr-3">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="tw-flex tw-flex-col tw-justify-center">
                                <div class="tw-text-lg"> {{ Cotizacion }} </div>
                                <div class="tw-text-xs tw-text-gray-400">Pendientes Por cotizar</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tw-w-full tw-cursor-pointer lg:tw-w-1/4">
                    <div class="tw-w-full tw-p-2 tw-bg-white tw-border-l-4 tw-border-blue-600 tw-rounded-lg tw-widget">
                        <div class="tw-flex tw-items-center">
                            <div class="icon tw-w-10 tw-p-2 tw-bg-blue-600 tw-text-white tw-rounded-full tw-mr-3">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="tw-flex tw-flex-col tw-justify-center">
                                <div class="tw-text-lg"> {{ SinConfirmar }} </div>
                                <div class="tw-text-xs tw-text-gray-400">Sin Confirmar</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tw-w-full tw-cursor-pointer lg:tw-w-1/5" @click="FiltroIndicadores(5)">
                    <div class="tw-w-full tw-p-2 tw-bg-white tw-border-l-4 tw-border-orange-500 tw-rounded-lg tw-widget">
                        <div class="tw-flex tw-items-center">
                            <div class="icon tw-w-10 tw-p-2 tw-bg-orange-400 tw-text-white tw-rounded-full tw-mr-3">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="tw-flex tw-flex-col tw-justify-center">
                                <div class="tw-text-lg"> {{ EnCotizacion }} </div>
                                <div class="tw-text-xs tw-text-gray-400">Pendientes por Autorizar</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="tw-flex tw-justify-between tw-content-center tw-border tw-p-2 tw-mb-4 tw-mx-4">
        <div class="tw-flex tw-gap-4">
            <div>
                <jet-label class="tw-text-center">AÑO</jet-label>
                <select class="InputSelect" v-model="params.Year">
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
                <jet-label class="tw-text-center">Vista</jet-label>
                <select class="InputSelect" v-model="params.View" @change="TipoVista">
                    <option value="1">PARTIDAS</option>
                    <option value="2">REQUISICION</option>
                </select>
            </div>

            <div class="tw-mt-4">
                <jet-button @click="Filtros" class="BtnFiltros"><i class="fas fa-filter tw-mr-1"></i>Aplica Filtros</jet-button>
            </div>
        </div>
    </div>

<!--     <div class="tw-mx-4">
        <p class="tw-text-center tw-text-coolGray-400">VISUALIZACIÓN POR {{Visualizacion}}</p>
        <div>
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
                    <th class="columna">TIPO</th>
                    <th class="columna">OBSERVACIONES</th>
                    <th class="columna">SOLICITANTE</th>
                    <th class="columna">FECHA LLEGADA</th>
                    <th class="columna">ESTATUS</th>
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
                    </tr>
                </template>
            </Table>
        </div>

        <div>
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
                            <div v-if="datos.Estatus == 2">
                                <span tooltip="REQUSICIÓN SOLICITADA" flow="left">
                                    <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-violet-400 tw-rounded-full">SOLICITADO</span>
                                </span>
                            </div>
                            <div v-else-if="datos.Estatus == 3">
                                <span tooltip="REQUSICIÓN EN ESPERA DE COTIZACIÓN" flow="left">
                                    <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-indigo-500 tw-rounded-full">COTIZAR</span>
                                </span>
                            </div>
                            <div v-else-if="datos.Estatus == 4">
                                <span tooltip="AÑADIR OTRA COTIZACION" flow="left">
                                    <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-blue-500 tw-rounded-full">COTIZADO</span>
                                </span>
                            </div>
                            <div v-else-if="datos.Estatus == 5">
                                <span tooltip="EN ESPERA DE AUTORIZACIÓN" flow="left">
                                    <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-orange-600 tw-rounded-full">EN AUTORIZACION</span>
                                </span>
                            </div>
                            <div v-else-if="datos.Estatus == 6">
                                <span tooltip="REQUISICIÓN AUTORIZADA" flow="left">
                                    <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-cyan-600 tw-rounded-full">AUTORIZADO</span>
                                </span>
                            </div>
                            <div v-else-if="datos.Estatus == 7">
                                <span tooltip="REQUISICIÓN AUTORIZADA" flow="left">
                                    <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-fuchsia-600 tw-rounded-full">CONFIRMADO</span>
                                </span>
                            </div>
                            <div v-else-if="datos.Estatus == 8">
                                <span tooltip="REQUISICIÓN EN ALMACÉN" flow="left">
                                    <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-green-600 tw-rounded-full">EN ALMACEN</span>
                                </span>
                            </div>
                            <div v-else-if="datos.Estatus == 9">
                                <span tooltip="REQUSICIÓN ENTREGADA" flow="left">
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
                            <div class="columnaIconos" v-if="datos.Estatus <= 3">
                                <div class="iconoDetails" @click="Partidas(datos)">
                                    <span tooltip="Visualiza Partidas" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="iconoPurple" @click="CotizarReq(datos)">
                                    <span tooltip="Realizar Cotizacion" flow="left">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="columnaIconos" v-else-if="datos.Estatus == 4">
                                <div class="iconoDetails" @click="VisualizaCotizacion(datos)">
                                    <span tooltip="Visualiza Cotizacion" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="iconoEdit" @click="ConfirmaRequisicionCotizada(datos, 5)" >
                                    <span tooltip="Enviar Cotizacion para Autorización" flow="left">
                                        <i class="fas fa-check-circle"></i>
                                    </span>
                                </div>
                                <div class="iconoPurple" @click="CotizarOtraReq(datos)">
                                    <span tooltip="Realizar Otra Cotizacion" flow="left">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </span>
                                </div>
                                <div class="iconoPurple" @click="Partidas(datos)">
                                    <span tooltip="Edita Precios" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="columnaIconos" v-else-if="datos.Estatus == 5">
                                <div class="iconoDetails" @click="VisualizaCotizacion(datos)">
                                    <span tooltip="Visualiza Cotizacion" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="columnaIconos" v-else-if="datos.Estatus == 6">
                                <div class="iconoPurple" @click="CapturaFecha(datos)">
                                    <span tooltip="Confirma Fecha de Entrega" flow="left">
                                        <i class="fas fa-shipping-fast"></i>
                                    </span>
                                </div>
                                <div class="iconoDetails" @click="VisualizaCotizacion(datos)">
                                    <span tooltip="Visualiza Cotizacion" flow="left">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="columnaIconos" v-else-if="datos.Estatus > 6">
                                <div class="iconoDetails" @click="VisualizaCotizacion(datos)">
                                    <span tooltip="Visualiza Cotizacion" flow="left">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                </template>
            </Table>
        </div>
    </div> -->

    <div class="tw-mx-4">
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
                        <td class="tw-text-center">{{ datos.NumReq }}</td>
                        <td class="tw-text-center">{{ datos.OrdenCompra }}</td>
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
                            <div class="columnaIconos" v-if="datos.Estatus <= 3">
                                <div class="iconoDetails" @click="Partidas(datos)">
                                    <span tooltip="Visualiza Partidas" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="iconoPurple" @click="CotizarReq(datos)">
                                    <span tooltip="Realizar Cotizacion" flow="left">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="columnaIconos" v-else-if="datos.Estatus == 4">
                                <div class="iconoDetails" @click="VisualizaCotizacion(datos)">
                                    <span tooltip="Visualiza Cotizacion" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="iconoEdit" @click="ConfirmaRequisicionCotizada(datos, 5)" >
                                    <span tooltip="Enviar Cotizacion para Autorización" flow="left">
                                        <i class="fas fa-check-circle"></i>
                                    </span>
                                </div>
                                <div class="iconoPurple" @click="CotizarOtraReq(datos)">
                                    <span tooltip="Realizar Otra Cotizacion" flow="left">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </span>
                                </div>
                                <div class="iconoPurple" @click="Partidas(datos)">
                                    <span tooltip="Edita Precios" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="columnaIconos" v-else-if="datos.Estatus == 5">
                                <div class="iconoDetails" @click="VisualizaCotizacion(datos)">
                                    <span tooltip="Visualiza Cotizacion" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="columnaIconos" v-else-if="datos.Estatus == 6">
                                <div class="iconoPurple" @click="CapturaFecha(datos)">
                                    <span tooltip="Confirma Fecha de Entrega" flow="left">
                                        <i class="fas fa-shipping-fast"></i>
                                    </span>
                                </div>
                                <div class="iconoDetails" @click="VisualizaCotizacion(datos)">
                                    <span tooltip="Visualiza Cotizacion" flow="left">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="columnaIconos" v-else-if="datos.Estatus > 6">
                                <div class="iconoDetails" @click="VisualizaCotizacion(datos)">
                                    <span tooltip="Visualiza Cotizacion" flow="left">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                </template>
            </Table>
        </div>
    </div>

    <modal :show="showPartidas" @close="chagePartidas" :maxWidth="tam">
        <div class="tw-px-2 tw-py-2">
            <div class="tw-text-lg">
                <div class="ModalHeader">
                    <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Articulos de requisición</h3>
                </div>
            </div>
        </div>
        <div class="tw-mx-4" v-if="ArticulosRequisicion != null">
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
                            <td class="tw-text-center">{{ requisicion.Fecha }}</td>
                            <td class="tw-text-center">{{ requisicion.NumReq }}</td>
                            <td class="tw-text-center">{{ requisicion.requisicion_departamento.Nombre }}</td>
                            <td class="tw-text-center">{{ requisicion.requisicion_maquina.Nombre }}</td>
                            <td class="tw-text-center">{{ requisicion.requisicion_marca.Nombre }}</td>
                            <td class="tw-text-center">{{ requisicion.Observaciones }}</td>
                        </tr>
                    </template>
                </Table>
            </div>
            <div v-if=" ArticulosRequisicion[0].articulo_user != null">
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
                            <td class="tw-text-center">
                                <div v-if="art.EstatusArt == 2">
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
                            <td class="tw-text-center">
                                <div class="columnaIconos">
                                    <div class="iconoPurple" @click="EdtarPrecio(art)">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </div>
                                    <div class="iconoPurple" @click="CancelarArticulo(art)">
                                        <i class="fas fa-ban"></i>
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
                            <td class="tw-text-center">
                                <div class="columnaIconos" v-if="art.EstatusArt == 3">
                                    <div class="iconoPurple" @click="EdtarPrecio(art)">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </div>
                                    <div class="iconoPurple" @click="CancelarArticulo(art)">
                                        <i class="fas fa-ban"></i>
                                    </div>
                                </div>
                                <div class="columnaIconos" v-if="art.EstatusArt == 4">
                                    <div class="iconoPurple" @click="EdtarPrecio(art)">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>
                </Table>
            </div>
        </div>
        <div v-else>
            <p>No hay Articulos Asignados a esta requisición</p>
        </div>

        <div class="ModalFooter">
            <jet-CancelButton @click="chagePartidas">Cerrar</jet-CancelButton>
        </div>
    </modal>

    <modal :show="showCotizar" @close="chageCotizar" :maxWidth="tam">
        <div class="tw-px-4 tw-py-4">
            <div class="tw-text-lg">
                <div class="ModalHeader">
                    <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Realiza Cotización # {{form.NumReq}}</h3>
                </div>
            </div>

            <div class="tw-mt-4">
                <div class="ModalForm">
                    <div class="tw-mb-6 md:tw-flex">
                        <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                            <jet-label><span class="required">*</span>MARCA</jet-label>
                            <jet-input type="text" v-model="form.Marca" @input="(val) => (form.Marca = form.Marca.toUpperCase())"></jet-input>
                            <small v-if="errors.Marca" class="validation-alert">{{errors.Marca}}</small>
                        </div>
                        <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                            <jet-label><span class="required">*</span>PROVEEDOR</jet-label>
                            <select id="Jefe" v-model="form.Proveedor"  class="InputSelect">
                                <option v-for="select in Proveedores" :key="select.id" :value="select.Nombre" >{{ select.Nombre }}</option>
                            </select>
                            <small v-if="errors.Proveedor" class="validation-alert" >{{ errors.Proveedor }}</small>
                        </div>
                        <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                            <jet-label><span class="required">*</span>TIPO MONEDA</jet-label>
                            <select id="Jefe" v-model="form.Moneda"  class="InputSelect">
                                <option value="MXN" >MXN</option>
                                <option value="USD" >USD</option>
                                <option value="EUR" >EUR</option>
                            </select>
                        </div>

                        <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-if="form.Moneda == 'USD' || form.Moneda == 'EUR'">
                            <jet-label>Tipo Cambio</jet-label>
                            <jet-input type="text" v-model="form.TipoCambio"></jet-input>
                            <small v-if="errors.TipoCambio" class="validation-alert">{{errors.TipoCambio}}</small>
                        </div>
                    </div>
                    <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                        <h3 class="tw-text-center tw-font-extrabold">Articulos</h3>
                        <Table>
                            <template v-slot:TableHeader>
                                <th>CANTIDAD</th>
                                <th>UNIDAD</th>
                                <th>DESCRIPCION</th>
                                <th>PRECIO UNITARIO</th>
                            </template>

                            <template v-slot:TableFooter>
                                <tr v-for="match in form.PrecioCotizacion" :key="match">
                                    <td class="tw-text-center">{{ match.Cantidad }}</td>
                                    <td class="tw-text-center">{{ match.Unidad }}</td>
                                    <td>{{ match.Descripcion }}</td>
                                    <td class="tw-flex tw-justify-center">
                                        <input type="number" v-model="match.PrecioUnitario" class="tw-bg-gray-200 tw-text-gray-500 tw-font-semibold focus:tw-outline-none focus:tw-shadow-outline tw-border tw-border-gray-300 tw-rounded-lg tw-block tw-w-1/2 tw-appearance-none tw-shadow-sm">
                                    </td>
                                </tr>
                            </template>
                        </Table>
                    </div>
                    <div class="tw-mb-6 md:tw-flex">
                        <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                            <jet-label><span class="required">*</span>COMENTARIOS</jet-label>
                            <textarea name="" id="" cols="2" v-model="form.Comentarios" @input="(val) => (form.Comentarios = form.Comentarios.toUpperCase())" class="tw-bg-gray-200 tw-text-gray-500 tw-font-semibold focus:tw-outline-none focus:tw-shadow-outline tw-border tw-border-gray-300 tw-rounded-lg tw-py-2 tw-px-4 tw-block tw-w-full tw-appearance-none tw-shadow-sm"></textarea>
                        </div>
                    </div>
                    <div class="tw-mb-6 md:tw-flex">
                        <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                            <jet-label>ARCHIVO</jet-label>
                            <div class='tw-flex tw-items-center tw-justify-center tw-w-full'>
                                <label class='tw-flex tw-flex-col tw-border-4 tw-border-dashed tw-w-full tw-h-24 hover:tw-bg-gray-100 hover:tw-border-indigo-300 tw-group'>
                                    <div class='tw-flex tw-flex-col tw-items-center tw-justify-center tw-pt-4'>
                                        <svg class="tw-w-8 tw-h-8 tw-text-indigo-400 group-hover:tw-text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <p class='tw-lowercase tw-text-sm tw-text-gray-400 group-hover:tw-text-indigo-600 tw-mt-2 tw-tracking-wider' v-if="form.archivo == null">Seleccion un Archivo</p>
                                        <span class="tw-mt-2 tw-text-xxs tw-text-teal-500 tw-font-bold" v-if="form.archivo != null">{{  form.archivo.name }}</span>
                                    </div>
                                <input type='file' class="tw-hidden" @input="form.archivo = $event.target.files[0]"/>
                                </label>
                            </div>
                            <span v-if="form.ImagenServidor != null">{{form.archivo}}</span>
                            <small v-if="errors.archivo" class="validation-alert">{{errors.archivo}}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ModalFooter">
            <jet-button type="button" @click="RealizaCotizacion(form)" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Guardar</jet-button>
            <jet-CancelButton @click="chageCotizar">Cerrar</jet-CancelButton>
        </div>
    </modal>

    <modal :show="showOtraCotizacion" @close="chageOtraCotizacion" :maxWidth="tam">
        <div class="tw-px-4 tw-py-4">
            <div class="tw-text-lg">
                <div class="ModalHeader">
                    <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Realiza Cotización # {{form.NumReq}}</h3>
                </div>
            </div>

            <div class="tw-mt-4">
                <div class="ModalForm">
                    <div class="tw-mb-6 md:tw-flex">
                        <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                            <jet-label><span class="required">*</span>MARCA</jet-label>
                            <jet-input type="text" v-model="form.Marca" @input="(val) => (form.Marca = form.Marca.toUpperCase())"></jet-input>
                            <small v-if="errors.Marca" class="validation-alert">{{errors.Marca}}</small>
                        </div>
                        <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                            <jet-label><span class="required">*</span>PROVEEDOR</jet-label>
                            <select id="Jefe" v-model="form.Proveedor"  class="InputSelect">
                                <option v-for="select in Proveedores" :key="select.id" :value="select.Nombre" >{{ select.Nombre }}</option>
                            </select>
                            <small v-if="errors.Proveedor" class="validation-alert" >{{ errors.Proveedor }}</small>
                        </div>
                        <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                            <jet-label><span class="required">*</span>TIPO MONEDA</jet-label>
                            <select id="Jefe" v-model="form.Moneda"  class="InputSelect">
                                <option value="MXN" >MXN</option>
                                <option value="USD" >USD</option>
                                <option value="EUR" >EUR</option>
                            </select>
                        </div>

                        <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-if="form.Moneda == 'USD' || form.Moneda == 'EUR'">
                            <jet-label>Tipo Cambio</jet-label>
                            <jet-input type="text" v-model="form.TipoCambio"></jet-input>
                            <small v-if="errors.TipoCambio" class="validation-alert">{{errors.TipoCambio}}</small>
                        </div>
                    </div>
                    <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                        <h3 class="tw-text-center tw-font-extrabold">Articulos</h3>
                        <Table>
                            <template v-slot:TableHeader>
                                <th>CANTIDAD</th>
                                <th>UNIDAD</th>
                                <th>DESCRIPCION</th>
                                <th>PRECIO UNITARIO</th>
                            </template>

                            <template v-slot:TableFooter>
                                <tr v-for="match in form.PrecioCotizacion" :key="match">
                                    <td class="tw-text-center">{{ match.Cantidad }}</td>
                                    <td class="tw-text-center">{{ match.Unidad }}</td>
                                    <td>{{ match.Descripcion }}</td>
                                    <td class="tw-flex tw-justify-center">
                                        <input type="number" v-model="match.PrecioUnitario" class="tw-bg-gray-200 tw-text-gray-500 tw-font-semibold focus:tw-outline-none focus:tw-shadow-outline tw-border tw-border-gray-300 tw-rounded-lg tw-block tw-w-1/2 tw-appearance-none tw-shadow-sm">
                                    </td>
                                </tr>
                            </template>
                        </Table>
                    </div>
                    <div class="tw-mb-6 md:tw-flex">
                        <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                            <jet-label><span class="required">*</span>COMENTARIOS</jet-label>
                            <textarea name="" id="" cols="2" v-model="form.Comentarios" @input="(val) => (form.Comentarios = form.Comentarios.toUpperCase())" class="tw-bg-gray-200 tw-text-gray-500 tw-font-semibold focus:tw-outline-none focus:tw-shadow-outline tw-border tw-border-gray-300 tw-rounded-lg tw-py-2 tw-px-4 tw-block tw-w-full tw-appearance-none tw-shadow-sm"></textarea>
                        </div>
                    </div>
                    <div class="tw-mb-6 md:tw-flex">
                        <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                            <jet-label>ARCHIVO</jet-label>
                            <div class='tw-flex tw-items-center tw-justify-center tw-w-full'>
                                <label class='tw-flex tw-flex-col tw-border-4 tw-border-dashed tw-w-full tw-h-24 hover:tw-bg-gray-100 hover:tw-border-indigo-300 tw-group'>
                                    <div class='tw-flex tw-flex-col tw-items-center tw-justify-center tw-pt-4'>
                                        <svg class="tw-w-8 tw-h-8 tw-text-indigo-400 group-hover:tw-text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <p class='tw-lowercase tw-text-sm tw-text-gray-400 group-hover:tw-text-indigo-600 tw-mt-2 tw-tracking-wider' v-if="form.archivo == null">Seleccion un Archivo</p>
                                        <span class="tw-mt-2 tw-text-xxs tw-text-teal-500 tw-font-bold" v-if="form.archivo != null">{{  form.archivo.name }}</span>
                                    </div>
                                <input type='file' class="tw-hidden" @input="form.archivo = $event.target.files[0]"/>
                                </label>
                            </div>
                            <span v-if="form.ImagenServidor != null">{{form.archivo}}</span>
                            <small v-if="errors.archivo" class="validation-alert">{{errors.archivo}}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ModalFooter">
            <jet-button type="button" @click="RealizaCotizacion(form)" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Guardar</jet-button>
            <jet-CancelButton @click="chageOtraCotizacion">Cerrar</jet-CancelButton>
        </div>
    </modal>

    <modal :show="showPreciosRequisicion" @close="chagePreciosRequisicion" maxWidth="7xl">
        <div class="tw-px-4 tw-py-4">
            <div class="tw-text-lg">
                <div class="ModalHeader">
                    <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Precios de Cotización <strong></strong></h3>
                </div>
            </div>
            <div class="tw-my-4" v-if="ArticulosPrecios != null">
                <Table>
                    <template v-slot:TableHeader>
                        <th class="columna">CANTIDAD</th>
                        <th class="columna">UNIDAD</th>
                        <th class="columna">DESCRIPCION</th>
                        <th class="columna">MARCA</th>
                        <th class="columna">PROVEEDOR</th>
                        <th class="columna">COMENTARIOS</th>
                        <th class="columna">PRECIO UNITARIO</th>
                        <th class="columna">TIPO MONEDA</th>
                        <th class="columna">TIPO CAMBIO</th>
                        <th class="columna">PRECIO TOTAL</th>
                        <th class="columna">ARCHIVO</th>
                        <th class="columna">AUTORIZADO</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila tw-bg-gray-200" v-for="datos in ArticulosPrecios" :key="datos.id">
                            <td class="tw-text-center">{{datos.Cantidad}}</td>
                            <td class="tw-text-center">{{datos.Unidad}}</td>
                            <td>{{datos.Descripcion}}</td>
                            <td>
                                <tr v-for="Pre in datos.articulo_precios" :key="Pre">
                                    {{Pre.Marca}}
                                </tr>
                            </td>
                            <td>
                                <tr v-for="Pre in datos.articulo_precios" :key="Pre">
                                    {{Pre.Proveedor}}
                                </tr>
                            </td>
                            <td>
                                <tr v-for="Pre in datos.articulo_precios" :key="Pre">
                                    {{  Pre.Comentarios }}
                                </tr>
                            </td>
                            <td class="tw-text-center">
                                <tr v-for="Pre in datos.articulo_precios" :key="Pre">
                                    $ {{Pre.Precio}}
                                </tr>
                            </td>
                            <td class="tw-text-center">
                                <tr v-for="Pre in datos.articulo_precios" :key="Pre">
                                    {{Pre.Moneda}}
                                </tr>
                            </td>
                            <td class="tw-text-center">
                                <tr v-for="Pre in datos.articulo_precios" :key="Pre">
                                    $ {{Pre.TipoCambio}}
                                </tr>
                            </td>
                            <td class="tw-text-center">
                                <tr v-for="Pre in datos.articulo_precios" :key="Pre">
                                    $ {{Pre.Total}}
                                </tr>
                            </td>
                            <td class="tw-flex tw-justify-center">
                                <tr class="tw-p-1" v-for="Pre in datos.articulo_precios" :key="Pre">
                                    <div class="columnaIconos">
                                        <a target="_blank" :href="path + Pre.Archivo" style="color:black;">
                                            <i class="far fa-file-image"></i>
                                        </a>
                                    </div>
                                </tr>
                            </td>
                            <td>
                                <tr class="tw-text-center" v-for="Pre in datos.articulo_precios" :key="Pre">
                                    <div class="columnaIconos" v-if="Pre.Autorizado == 1">
                                        <span tooltip="Precio no Autorizado" flow="left">
                                            <span class="tw-inline-flex tw-text-xxs tw-items-center tw-justify-center tw-text-white tw-bg-red-400 tw-rounded-full">No Autorizado</span>
                                        </span>
                                    </div>
                                    <div class="columnaIconos" v-else-if="Pre.Autorizado == 2">
                                        <span tooltip="Precio Autorizado" flow="left">
                                            <span class="tw-inline-flex tw-text-xxs tw-items-center tw-justify-center tw-text-white tw-bg-green-400 tw-rounded-full">Autorizado</span>
                                        </span>
                                    </div>
                                </tr>
                            </td>
                        </tr>
                    </template>
                </Table>
            </div>
        </div>

        <div class="ModalFooter">
            <jet-button type="button" @click="Editar(form)"  :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Editar</jet-button>
            <jet-CancelButton @click="chagePreciosRequisicion">Cerrar</jet-CancelButton>
        </div>
    </modal>

    <modal :show="showEditarPre" @close="chageEditarPre" :maxWidth="tam">
        <div class="tw-px-4 tw-py-4">
            <div class="tw-text-lg">
                <div class="ModalHeader">
                    <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Edita Precio Cotización # {{form.NumReq}}</h3>
                </div>
            </div>
            <div class="tw-mt-4">
                <div class="ModalForm">
                    <div class="tw-mb-6 md:tw-flex">
                        <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                            <jet-label><span class="required">*</span>NÚMERO DE COTIZACION</jet-label>
                            <select id="NumCot" v-model="form.Cot"  class="InputSelect" @change="NumeroCot()">
                                <option value="0" >Cotizacion 1</option>
                                <option value="1" >Cotizacion 2</option>
                            </select>
                        </div>
                        <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                            <jet-label><span class="required">*</span>MARCA</jet-label>
                            <jet-input type="text" v-model="form.Marca" @input="(val) => (form.Marca = form.Marca.toUpperCase())"></jet-input>
                            <small v-if="errors.Marca" class="validation-alert">{{errors.Marca}}</small>
                        </div>
                        <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                            <jet-label><span class="required">*</span>PROVEEDOR</jet-label>
                            <select id="Jefe" v-model="form.Proveedor"  class="InputSelect">
                                <option v-for="select in Proveedores" :key="select.id" :value="select.Nombre" >{{ select.Nombre }}</option>
                            </select>
                            <small v-if="errors.Proveedor" class="validation-alert" >{{ errors.Proveedor }}</small>
                        </div>
                        <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                            <jet-label><span class="required">*</span>TIPO MONEDA</jet-label>
                            <select id="Jefe" v-model="form.Moneda"  class="InputSelect">
                                <option value="MXN" >MXN</option>
                                <option value="USD" >USD</option>
                            </select>
                        </div>
                        <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-if="form.Moneda == 'USD' || form.Moneda == 'EUR'">
                            <jet-label>Tipo Cambio</jet-label>
                            <jet-input type="text" v-model="form.TipoCambio"></jet-input>
                            <small v-if="errors.TipoCambio" class="validation-alert">{{errors.TipoCambio}}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                <h3 class="tw-text-center tw-font-extrabold">Articulos</h3>
                <Table>
                    <template v-slot:TableHeader>
                        <th>CANTIDAD</th>
                        <th>UNIDAD</th>
                        <th>DESCRIPCION</th>
                        <th>PRECIO UNITARIO</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr v-for="match in Precio" :key="match">
                            <td class="tw-text-center">{{ match.Cantidad }}</td>
                            <td class="tw-text-center">{{ match.Unidad }}</td>
                            <td class="tw-text-center">{{ match.Descripcion }}</td>
                            <td class="tw-flex tw-justify-center"><input type="text" v-model="form.Precio"></td>
                        </tr>
                    </template>
                </Table>
            </div>
            <div class="tw-mb-6 md:tw-flex">
                <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                    <jet-label><span class="required">*</span>COMENTARIOS</jet-label>
                    <textarea name="" id="" cols="2" v-model="form.Comentarios" @input="(val) => (form.Comentarios = form.Comentarios.toUpperCase())" class="tw-bg-gray-200 tw-text-gray-500 tw-font-semibold focus:tw-outline-none focus:tw-shadow-outline tw-border tw-border-gray-300 tw-rounded-lg tw-py-2 tw-px-4 tw-block tw-w-full tw-appearance-none tw-shadow-sm"></textarea>
                </div>
            </div>
            <div class="tw-mb-6 md:tw-flex">
                <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                    <jet-label>ARCHIVO</jet-label>
                    <a >{{ form.Archivo }}</a>
                    <div class='tw-flex tw-items-center tw-justify-center tw-w-full'>
                        <label class='tw-flex tw-flex-col tw-border-4 tw-border-dashed tw-w-full tw-h-24 hover:tw-bg-gray-100 hover:tw-border-indigo-300 tw-group'>
                            <div class='tw-flex tw-flex-col tw-items-center tw-justify-center tw-pt-4'>
                                <svg class="tw-w-8 tw-h-8 tw-text-indigo-400 group-hover:tw-text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <p class='tw-lowercase tw-text-sm tw-text-gray-400 group-hover:tw-text-indigo-600 tw-mt-2 tw-tracking-wider' v-if="form.archivo == null">Seleccion un Archivo</p>
                                <span class="tw-mt-2 tw-text-xxs tw-text-teal-500 tw-font-bold" v-if="form.archivo != null">{{  form.archivo.name }}</span>
                            </div>
                        <input type='file' class="tw-hidden" @input="form.archivo = $event.target.files[0]"/>
                        </label>
                    </div>
                    <span v-if="form.ImagenServidor != null">{{form.archivo}}</span>
                    <small v-if="errors.archivo" class="validation-alert">{{errors.archivo}}</small>
                </div>
            </div>
        </div>

        <div class="ModalFooter">
            <jet-button type="button" @click="ActualizaCotizacion(form)"  :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Actualiza</jet-button>
            <jet-CancelButton @click="chageEditarPre">Cerrar</jet-CancelButton>
        </div>
    </modal>

    <modal :show="showCancelar" @close="chageCancelar" :maxWidth="tam">
        <div class="tw-px-4 tw-py-4">
            <div class="tw-text-lg">
                <div class="ModalHeader">
                    <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Cancela Partida</h3>
                </div>
            </div>
            <div class="tw-mt-4">
                <div class="ModalForm">
                    <div class="tw-mb-6 md:tw-flex">
                        <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                            <jet-label><span class="required">*</span>MOTIVO CANCELACION</jet-label>
                            <textarea name="" id="" cols="2" v-model="form.MotivoCancelacion" @input="(val) => (form.MotivoCancelacion = form.MotivoCancelacion.toUpperCase())" class="tw-bg-gray-200 tw-text-gray-500 tw-font-semibold focus:tw-outline-none focus:tw-shadow-outline tw-border tw-border-gray-300 tw-rounded-lg tw-py-2 tw-px-4 tw-block tw-w-full tw-appearance-none tw-shadow-sm"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ModalFooter">
            <jet-button type="button" @click="ConfirmaCancelacion(form)"  :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Actualiza</jet-button>
            <jet-CancelButton @click="chageCancelar">Cerrar</jet-CancelButton>
        </div>
    </modal>

    <modal :show="showFecha" @close="chageFecha" :maxWidth="tam2">
        <div class="tw-px-4 tw-py-4">
            <div class="tw-text-lg">
                <div class="ModalHeader">
                    <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Confirma fecha aproximada de entrega</h3>
                </div>
            </div>

            <div class="tw-mt-4">
                <div class="tw-mb-6 md:tw-flex">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                        <jet-label><span class="required">*</span>FECHA</jet-label>
                        <jet-input type="date" :min="min" v-model="form.Fechallegada"></jet-input>
                        <small v-if="errors.Fechallegada" class="validation-alert">{{errors.Fechallegada}}</small>
                    </div>
                </div>
                <div class="tw-mb-6 md:tw-flex">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                        <jet-label>COMENTARIOS</jet-label>
                        <textarea name="" id="" cols="2" v-model="form.Comentariollegada" @input="(val) => (form.Comentariollegada = form.Comentariollegada.toUpperCase())" class="tw-bg-gray-200 tw-text-gray-500 tw-font-semibold focus:tw-outline-none focus:tw-shadow-outline tw-border tw-border-gray-300 tw-rounded-lg tw-py-2 tw-px-4 tw-block tw-w-full tw-appearance-none tw-shadow-sm"></textarea>
                        <small v-if="errors.Comentariollegada" class="validation-alert">{{errors.Comentariollegada}}</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="ModalFooter">
            <jet-button type="button" @click="ConfirmaFecha(form)">Guardar</jet-button>
            <jet-CancelButton @click="chageFecha">Cerrar</jet-CancelButton>
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
import JetLabel from '@/Jetstream/Label';
import JetInput from "@/Components/Input";
import JetSelect from "@/Components/Select";
//imports de datatables
import datatable from "datatables.net-bs5";
import $ from "jquery";
import moment from 'moment';
import 'moment/locale/es';

export default {

    data() {
        return {
            tam: "5xl",
            tam2: "xl",
            color: "tw-bg-teal-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            showPartidas: false,
            showCotizar: false,
            showOtraCotizacion: false,
            showPreciosRequisicion: false,
            showEditarPre: false,
            showCancelar: false,
            showFecha: false,
            min: moment().format("YYYY-MM-DD"),
            requisicion: [],
            Visualizacion: 'PARTIDAS',
            Cambio: false,
            form: {
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
                IdPre: '',
                IdArt: '',
                requisicion_id: '',
                NumReq:  '',
                Cantidad: '',
                Unidad: '',
                Marca: '',
                Proveedor: '',
                Precio: '',
                Cot: 0,
                NumCot: '',
                NumCot2: '',
                PrecioInteger: '',
                Total: '',
                TotalInteger: '',
                Moneda: '',
                TipoCambio: '',
                Descripcion: '',
                archivo: '',
                Comentarios: '',
                Comentariollegada: '',
                MotivoCancelacion: '',
                Fechallegada: '',
                ImagenServidor: '',
                PrecioCotizacion: [],
            },
            params:{
                Year: moment().format("YYYY"),
                Month: this.mes,
                Status: 0,
                View: 1,
                Req: '',
                Art: '',
                NumCot: 0,
            },
        };
    },

    mounted() {
        this.tabla();

        var query  = window.location.search.substring(1);
        var vars = query.split("&");
            for (var i=0; i < vars.length; i++) {
                var pair = vars[i].split("=");
                if(pair[0] == 'View') {
                    this.params.View = pair[1];
                }
                if(pair[0] == 'Year') {
                    this.params.Year = pair[1];
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
        JetLabel,
        JetInput,
        JetSelect,
    },

    props: {
        Session: Object,
        errors: Object,
        Req: Object, //Obtengo el num de requisicion
        NumCot: Number, //Numero de cotizacions realizadas a la requisicion
        Precio: Object,
        ArtPre: Object,
        PrecioEdit: Object,
        Proveedores: Object, //Catalogo
        Requisiciones: Object, //Vista por requisiciones
        ArticulosRequisiciones: Object, //Vista por Articulos
        ArticulosRequisicion: Object, //Partidas
        ArticulosCotizar: Object, //Objeto para generacion de inputs dinamicos para cotizar
        ArticulosPrecios: Object, //Visualizacion de cotizacion
        PreciosRequisicion: Object,
        Cotizacion: Number,
        SinConfirmar: Number,
        EnCotizacion: Number,
        Vista: String,
        mes: String,
    },

    methods: {

        reset() {
            this.form = {
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
                IdPre: '',
                IdArt: '',
                requisicion_id: '',
                NumReq:  '',
                Cantidad: '',
                Unidad: '',
                Marca: '',
                Proveedor: '',
                Precio: '',
                Cot: 0,
                NumCot: '',
                NumCot2: '',
                PrecioInteger: '',
                Total: '',
                TotalInteger: '',
                Moneda: '',
                TipoCambio: '',
                Descripcion: '',
                archivo: '',
                Comentarios: '',
                Comentariollegada: '',
                MotivoCancelacion: '',
                Fechallegada: '',
                ImagenServidor: '',
                PrecioCotizacion: [],
            };
        },

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
            $('#Requisiciones').DataTable().clear();
            $('#Requisiciones').DataTable().destroy();
            this.$inertia.get('/Compras/Cotizaciones', this.params , { //envio de variables por url
                onSuccess: () => {
                    this.tabla();
                    //Verifico si hubo un cambio en la vista
                    if(this.Cambio == true){
                        location.reload();
                    }
                }, preserveState: true})
        },

        Visualizacion(){ //Cambio de visualizacion por partidas o articulos
            this.params.Partidas  = !this.params.Partidas;
            if (this.params.Partidas == true){
                $('#Articulos').DataTable().clear(); //limpio
                $('#Articulos').DataTable().destroy(); //destruyo tabla
                this.$inertia.get('/Compras/Cotizaciones', this.params , { //envio de variables por url
                    onSuccess: () => {
                        this.tablaArticulos()
                    }, preserveState: true})
            }else if(this.params.Partidas == false){
                $('#Requisiciones').DataTable().clear(); //limpio
                $('#Requisiciones').DataTable().destroy(); //destruyo tabla
                this.$inertia.get('/Compras/Cotizaciones', this.params , { //envio de variables por url
                    onSuccess: () => {
                        this.tabla() //regeneracion de tabla
                    }, preserveState: true})
            }
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
                        { "width": "5%", "targets": [1, 4] },
                        { "width": "3%", "targets": [2,3] },
                        { "width": "9%", "targets": [6,7] },
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

        //consulta para generar datos de la tabla
        verTabla(event) {
            $("#Requisiciones").DataTable().destroy();
                this.$inertia.get("/Compras/Cotizaciones", { busca: event.target.value },{ onSuccess: () => { this.tabla(); },});
        },

        //Generacion de Tabla con Datatables
        tablaArticulos(){
            this.$nextTick(() => {
                $("#Articulos").DataTable({
                    "language": this.español,
                    paging: true,
                    "scrollX": true,
                    scrollY:  '40vh',
                    "order": [0, 'desc'],
                    "columnDefs": [
                        { "width": "1%", "targets": [0] },
                        { "width": "3%", "targets": [1,2] },
                        { "width": "2%", "targets": [5] },
                        {
                            "targets": [ 0 ],
                            "visible": false,
                            "searchable": false
                        },
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
                        'colvis'
                    ]
                });
            });
        },

        //Consulta para generar datos de la tabla
        verTablaArticulos(event) {
            $("#Articulos").DataTable().destroy();
                this.$inertia.get("/Compras/Cotizaciones", { busca: event.target.value },{
                    onSuccess: () => {
                        this.tablaArticulos();
                    },
                });
        },

        chagePartidas() { //Modal de partidas
            this.showPartidas = !this.showPartidas;
        },

        Partidas(data){ //Visualizacion de partidas
            this.reset();
            this.form.editId = data.id;
            this.form.NumReq = data.NumReq;
            this.form.Fecha = data.Fecha;
            this.form.Departamento_id = data.Departamento_id;
            this.form.Codigo = data.Codigo;
            this.form.Maquina = data.Maquina_id;
            this.form.Marca = data.Marca_id;
            this.form.Tipo = data.TipCompra;
            this.form.Nombre = data.Perfil_id;
            this.form.Observaciones = data.Observaciones;
            this.params.Req = data.id;
            this.form.Precio = null;

            this.requisicion = data;

            this.$inertia.get('/Compras/Cotizaciones', this.params , {
                onSuccess: () => {
                    this.chagePartidas();
                },preserveState: true })
        },

        chageCotizar() {
            this.showCotizar = !this.showCotizar;
        },

        CotizarReq(data){ //Abre modal y general inputs dinamicos de cotizacion
            this.params.Req = data.id;
            this.params.NumCot = 1;
            this.$inertia.get('/Compras/Cotizaciones', this.params , {
                onSuccess: () => {

                    this.reset();

                    if(this.ArticulosCotizar != null){
                        this.PreUni = [];
                        this.form.PrecioCotizacion = []; //Arreglo de inputs para precios

                        this.ArticulosCotizar.forEach(Art => { //Generacion de inputs apartir del objeto
                            this.PreUni.push({ //Añado mas campos a visualizar
                                IdArt: Art.id,
                                requisicion_id: Art.requisicion_id,
                                Cantidad: Art.Cantidad,
                                Unidad: Art.Unidad,
                                Descripcion: Art.Descripcion,
                                PrecioUnitario: null
                                })
                        })
                        this.form.PrecioCotizacion = this.PreUni;
                        this.chageCotizar();
                    }
                },preserveState: true })
        },

        RealizaCotizacion(data) { //Guardado de la informacion para cotizar
            this.$inertia.post("/Compras/Cotizaciones", data, {
                onSuccess: () => {
                this.reset();
                this.PreUni = [];
                this.form.PrecioCotizacion = [];
                    if(this.params.NumCot == 1){
                        this.chageCotizar();
                    }else{
                        this.chageOtraCotizacion();
                    }
                    this.alertSucces();
                },
            });
        },

        chageOtraCotizacion() {
            this.showOtraCotizacion = !this.showOtraCotizacion;
        },

        CotizarOtraReq(data){ //Agregar mas cotizaciones
            this.params.Req = data.id;
            this.params.NumCot = 2;
            this.$inertia.get('/Compras/Cotizaciones', this.params , {
                onSuccess: () => {

                    this.reset();

                    if(this.ArticulosCotizar != null){
                        this.PreUni = [];
                        this.form.PrecioCotizacion = [];

                        this.ArticulosCotizar.forEach(Art => {
                            this.PreUni.push({
                                IdArt: Art.id,
                                requisicion_id: Art.requisicion_id,
                                Cantidad: Art.Cantidad,
                                Unidad: Art.Unidad,
                                Descripcion: Art.Descripcion,
                                PrecioUnitario: null
                                })
                        })
                        this.form.PrecioCotizacion = this.PreUni;
                        this.chageOtraCotizacion();
                    }

                },preserveState: true })
        },

        chageEditarPre(){
            this.showEditarPre = !this.showEditarPre;
        },

        EdtarPrecio(data){ //Abre modal y consulta los precios del articulo
            this.params.Art = data.id;
            this.form.Cot = 0;

            var query  = window.location.search.substring(1);
            var vars = query.split("&");
                for (var i=0; i < vars.length; i++) {
                    var pair = vars[i].split("=");
                    if(pair[0] == 'Req') {
                        this.params.Req = pair[1];
                    }
            }

            this.$inertia.get('/Compras/Cotizaciones', this.params , { //envio de variables por url
                onSuccess: () => {
                    this.form.editId = this.PrecioEdit[0].id;

                    this.form.Marca = this.PrecioEdit[0].Marca;
                    this.form.Proveedor = this.PrecioEdit[0].Proveedor;
                    this.form.Moneda = this.PrecioEdit[0].Moneda;
                    this.form.TipoCambio = this.PrecioEdit[0].TipoCambio;
                    this.form.Precio = this.PrecioEdit[0].Precio;

                    this.form.Comentarios = this.PrecioEdit[0].Comentarios;
                    this.form.Archivo = this.PrecioEdit[0].Archivo;

                    this.chageEditarPre();

            }, preserveState: true })
        },

        NumeroCot(){ //Cambio de los datos del numero de Cotizacion
            this.form.editId = this.PrecioEdit[this.form.Cot].id;

            this.form.Marca = this.PrecioEdit[this.form.Cot].Marca;
            this.form.Proveedor = this.PrecioEdit[this.form.Cot].Proveedor;
            this.form.Moneda = this.PrecioEdit[this.form.Cot].Moneda;
            this.form.TipoCambio = this.PrecioEdit[this.form.Cot].TipoCambio;
            this.form.Precio = this.PrecioEdit[this.form.Cot].Precio;

            this.form.Comentarios = this.PrecioEdit[this.form.Cot].Comentarios;
            this.form.Archivo = this.PrecioEdit[this.form.Cot].Archivo;
        },

        ActualizaCotizacion(data){
            data.metodo = 1;
            data._method = "PUT";
            this.$inertia.post("/Compras/Cotizaciones/" + data.id, data, {
                onSuccess: () => {
                    this.reset(),
                    this.chageEditarPre(),
                    this.alertSucces();
                },
            });
        },

        ConfirmaRequisicionCotizada(data, metodo){ //Metodo para enviar cotizacion a Autorizacion
            data.metodo = 2;
            data._method = "PUT";
            this.$inertia.post("/Compras/Cotizaciones/" + data.id, data, {
                onSuccess: () => {
                    this.alertSucces();
                },
            });
        },

        chagePreciosRequisicion(){
            this.showPreciosRequisicion = !this.showPreciosRequisicion;
        },

        VisualizaCotizacion(data){ //Visualiza Precios de cotizacion
            this.params.Req = data.id;

            //OBTENER VALOR DE FRILTRO DE LA URL
            var query  = window.location.search.substring(1);
            var vars = query.split("&");
                for (var i=0; i < vars.length; i++) {
                    var pair = vars[i].split("=");
                    if(pair[0] == 'Estatus') {
                        this.params.Estatus = pair[1];
                    }
            }

            this.form.requisicion_id = data.id;
                this.$inertia.get('/Compras/Cotizaciones', this.params , { //envio de variables por url
                onSuccess: () => {
                    this.chagePreciosRequisicion();
            }, preserveState: true })
        },

        chageCancelar(){ //Modal para cancelar partida
            this.showCancelar = !this.showCancelar;
        },

        CancelarArticulo(data){
            this.params.Art = data.id;
            this.form.IdArt = data.id;
            this.$inertia.get('/Compras/Cotizaciones', this.params , { //envio de variables por url
                onSuccess: () => {
                    this.chageCancelar();
            }, preserveState: true })
        },

        ConfirmaCancelacion(data){
            data.metodo = 4;
            data._method = "PUT";
            this.$inertia.post("/Compras/Cotizaciones/" + data.id, data, {
                onSuccess: () => {
                    this.chageCancelar();
                    this.alertSucces();
                },
            });
        },

        chageFecha() {
            this.showFecha = !this.showFecha;
            this.form.Fechallegada = '',
            this.form.Comentariollegada = '';
        },

        CapturaFecha(data){
            this.chageFecha();
            this.form.requisicion_id = data.id;
        },

        ConfirmaFecha(data){
            data.metodo = 3;
            data._method = "PUT";
            this.$inertia.post("/Compras/Cotizaciones/" + data.id, data, {
                onSuccess: () => {
                    this.form.Fechallegada = '',
                    this.form.Comentariollegada = '';
                    this.chageFecha();
                    this.alertSucces();
                },
            });
        }

    },
};
</script>
