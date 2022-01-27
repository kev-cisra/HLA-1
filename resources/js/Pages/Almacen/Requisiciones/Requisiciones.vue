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
            <!-- Indicadores -->
            <div class="tw-flex tw-items-center tw-justify-center tw-mt-4">
                <div class="tw-w-full tw-mx-auto tw-max-w-7xl sm:tw-px-8 lg:tw-px-10">
                    <div class="tw-flex tw-flex-col tw-w-full tw-mb-2 tw-space-y-8 lg:tw-flex-row lg:tw-space-x-10 lg:tw-space-y-0 lg:tw-mb-4">

                        <div class="tw-w-full tw-cursor-pointer lg:tw-w-1/4" @click="FiltroIndicadores(8)">
                            <div class="tw-w-full tw-p-2 tw-bg-white tw-border-l-4 tw-border-green-400 tw-rounded-lg tw-widget">
                                <div class="tw-flex tw-items-center">
                                    <div class="icon tw-w-10 tw-p-2 tw-bg-green-400 tw-text-white tw-rounded-full tw-mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                        </svg>
                                    </div>
                                    <div class="tw-flex tw-flex-col tw-justify-center">
                                        <div class="tw-text-lg">{{Almacen}}</div>
                                        <div class="tw-text-xs tw-text-gray-400">Artículos pendientes por Entregar</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tw-w-full tw-cursor-pointer lg:tw-w-1/4" @click="FiltroIndicadores(3)">
                            <div class="tw-w-full tw-p-2 tw-bg-white tw-border-l-4 tw-border-indigo-500 tw-rounded-lg tw-widget">
                                <div class="tw-flex tw-items-center">
                                    <div class="icon tw-w-10 tw-p-2 tw-bg-indigo-500 tw-text-white tw-rounded-full tw-mr-3">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <div class="tw-flex tw-flex-col tw-justify-center">
                                        <div class="tw-text-lg"> {{ Cotizacion }} </div>
                                        <div class="tw-text-xs tw-text-gray-400">Articulos Pendientes Por cotizar</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tw-w-full tw-cursor-pointer lg:tw-w-1/4" @click="FiltroIndicadores(6)">
                            <div class="tw-w-full tw-p-2 tw-bg-white tw-border-l-4 tw-border-fuchsia-600 tw-rounded-lg tw-widget">
                                <div class="tw-flex tw-items-center">
                                    <div class="icon tw-w-10 tw-p-2 tw-bg-fuchsia-600 tw-text-white tw-rounded-full tw-mr-3">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <div class="tw-flex tw-flex-col tw-justify-center">
                                        <div class="tw-text-lg"> {{ SinConfirmar }} </div>
                                        <div class="tw-text-xs tw-text-gray-400">Pendientes por Confirmar</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Filtros -->
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
            </div>

            <!-- Tablas -->
            <div class="tw-mx-4">
                <p class="tw-text-center tw-text-coolGray-400">VISUALIZACIÓN POR {{Visualizacion}}</p>
                <div v-if="Vista == 1">
                    <Table id="Requisiciones">
                        <template v-slot:TableHeader>
                            <th class="columna">ID</th>
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
                            <th class="columna">LLEGADA</th>
                            <th class="columna">ESTATUS</th>
                            <th class="columna">ACCIONES</th>
                        </template>

                        <template v-slot:TableFooter>
                            <tr class="fila" v-for="datos in Requisiciones" :key="datos.id">
                                <td>{{ datos.id }}</td>
                                <td>{{ datos.Fecha.substr(5) }}</td>
                                <td>{{ datos.articulos_requisicion.NumReq }}</td>
                                <td class="tw-text-center">{{ datos.articulos_requisicion.OrdenCompra }}</td>
                                <td>{{ datos.articulos_requisicion.requisicion_departamento.Nombre }}</td>
                                <td class="tw-text-center">{{ datos.articulos_requisicion.Codigo.substr(0,1)  }}</td>
                                <td class="tw-text-center">{{ datos.Cantidad }}</td>
                                <td>{{ datos.Unidad }}</td>
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
                                    <div v-else-if="datos.EstatusArt == 3 || datos.EstatusArt == 4">
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
                                <td>
                                    <div class="columnaIconos" v-if="datos.EstatusArt == 2">
                                        <div class="iconoEdit" @click="ArticuloCotizacion(datos)">
                                            <span tooltip="Envia Partida a Cotizacion" flow="left">
                                                <i class="fas fa-money-bill-wave"></i>
                                            </span>
                                        </div>
                                        <div class="iconoEdit" @click="ArticuloAlmacen(datos)">
                                            <span tooltip="Confirma Partida en Almacén" flow="left">
                                                <i class="ml-2 fas fa-check-circle"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="columnaIconos" v-else-if="datos.EstatusArt == 6">
                                        <div class="iconoEdit" @click="ArticuloAlmacen(datos)">
                                            <span tooltip="Confirma Partida en Almacén" flow="left">
                                                <i class="ml-2 fas fa-check-circle"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="columnaIconos" v-else>
                                        <div class="iconoEdit" >
                                            <span tooltip="En proceso" flow="left">
                                                <i class="ml-2 fas fa-spinner"></i>
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
                            <th class="columna">Id</th>
                            <th class="columna">FECHA</th>
                            <th class="columna">NUM</th>
                            <th class="columna">O.C</th>
                            <th class="columna">DEPARTAMENTO</th>
                            <th class="columna">CODIGO</th>
                            <th class="columna">MAQUINA</th>
                            <th class="columna">MARCA</th>
                            <th class="columna">TIPO COMPRA</th>
                            <th class="columna">OBSERVACIONES</th>
                            <th class="columna">SOLICITANTE</th>
                            <th class="columna">ESTATUS</th>
                            <th class="columna">ACCIONES</th>
                        </template>

                        <template v-slot:TableFooter>
                            <tr class="fila" v-for="datos in Requisiciones" :key="datos.id">
                                <td class="tw-text-center">{{ datos.id }}</td>
                                <td>{{ datos.Fecha.substr(5) }}</td>
                                <td>{{ datos.NumReq }}</td>
                                <td>{{ datos.OrdenCompra }}</td>
                                <td>{{ datos.requisicion_departamento.Nombre }}</td>
                                <td>{{ datos.Codigo.substr(0,1) }}</td>
                                <td>{{ datos.requisicion_maquina.Nombre }}</td>
                                <td>{{ datos.requisicion_marca.Nombre }}</td>
                                <td>{{ datos.TipCompra }}</td>
                                <td>{{ datos.Observaciones }}</td>
                                <td>{{ datos.requisiciones_perfil.Nombre }} {{ datos.requisiciones_perfil.ApPat }}</td>
                                <td>
                                    <div v-if="datos.Estatus == 2">
                                        <span tooltip="REQUSICIÓN SOLICITADA" flow="left">
                                            <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-violet-400 tw-rounded-full">SOLICITADO</span>
                                        </span>
                                    </div>
                                    <div v-else-if="datos.Estatus == 3 || datos.Estatus == 4">
                                        <span tooltip="REQUSICIÓN EN ESPERA DE COTIZACIÓN" flow="left">
                                            <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-indigo-500 tw-rounded-full">COTIZACION</span>
                                        </span>
                                    </div>
                                    <div v-else-if="datos.Estatus == 5">
                                        <span tooltip="EN ESPERA DE AUTORIZACIÓN" flow="left">
                                            <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-orange-600 tw-rounded-full">AUTORIZACION</span>
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
                                            <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-green-600 tw-rounded-full">ALMACEN</span>
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
                                    <div class="columnaIconos" v-if="datos.Estatus == 2">
                                        <div class="iconoDetails" @click="Partidas(datos)">
                                            <span tooltip="Visualiza Partidas" flow="left">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="iconoPurple" @click="EnviarCotizarRequisicion(datos)">
                                            <span tooltip="Envia Requisicion a Cotización" flow="left">
                                                <i class="fas fa-money-bill-wave"></i>
                                            </span>
                                        </div>
                                        <div class="iconoEdit" @click="RequisicionAlmacen(datos)">
                                            <span tooltip="Confirma existencia total en Almacén" flow="left">
                                                <i class="fas fa-check-circle"></i>
                                            </span>
                                        </div>
                                        <div class="iconoEdit" @click="IndicaProveedor(datos)">
                                            <span tooltip="Indica Provedor" flow="left">
                                                <i class="fas fa-shipping-fast"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="columnaIconos" v-else-if="datos.Estatus == 7">
                                        <div class="iconoDetails" @click="Partidas(datos)">
                                            <span tooltip="Visualiza Partidas" flow="left">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="iconoPurple" @click="RequisicionAlmacen(datos)">
                                            <span tooltip="Confirma Producto en Almacén" flow="left">
                                                <i class="ml-2 fas fa-box"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="columnaIconos" v-else-if="datos.Estatus == 8">
                                        <div class="iconoDetails" @click="Partidas(datos)">
                                            <span tooltip="Visualiza Partidas" flow="left">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="iconoLime" @click="EntregaProducto(datos)">
                                            <span tooltip="Entrega el Artículo" flow="left">
                                                <i class="fas fa-fingerprint"></i>
                                            </span>
                                        </div>
                                        <div class="iconoDetails" @click="Ticket(datos)" v-if="datos.Etiqueta == null">
                                            <span tooltip="Imprime Ticket" flow="left">
                                                <i class="fas fa-ticket-alt"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="columnaIconos" v-else>
                                        <div class="iconoDetails" @click="Partidas(datos)">
                                            <span tooltip="Visualiza Partidas" flow="left">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="iconoWhite">
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

            <modal :show="showPartidas" @close="chagePartidas" :maxWidth="tam">
                <div class="tw-mt-4 tw-mx-4">
                    <div class="tw-text-lg">
                        <div class="ModalHeader">
                            <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Articulos de requisición {{ Requi.NumReq }}</h3>
                        </div>
                    </div>
                </div>

                <div class="tw-mx-8">
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
                                <th class="columna">CORREO</th>
                            </template>
                            <template v-slot:TableFooter>
                                <tr class="fila">
                                    <td class="tw-text-center">{{ Requi.Fecha }}</td>
                                    <td class="tw-text-center">{{ Requi.NumReq }}</td>
                                    <td class="tw-text-center">{{ Requi.requisicion_departamento.Nombre }}</td>
                                    <td class="tw-text-center">{{ Requi.requisicion_maquina.Nombre }}</td>
                                    <td class="tw-text-center">{{ Requi.requisicion_marca.Nombre }}</td>
                                    <td class="tw-text-center">{{ Requi.Observaciones }}</td>
                                    <td class="tw-text-center">
                                        <div class="columnaIconos">
                                            <div class="iconoCorreoNoEnviado" v-if="Requi.CorreoEnviado == 0">
                                                <span tooltip="Envia Correo Proveedor" flow="left">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="tw-h-3 tw-w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="iconoCorreoEnviado" v-else>
                                                <span tooltip="Envia Correo Proveedor" flow="left">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="tw-h-3 tw-w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </Table>
                    </div>

                    <div v-if="Requi.requisicion_articulos[0].RecibidoPor == null">
                        <p class="tw-text-center tw-p-2 tw-text-coolGray-400 tw-text-xs"> -- Articulos --</p>
                        <Table>
                            <template v-slot:TableHeader>
                                <th class="columna">CANTIDAD</th>
                                <th class="columna">UNIDAD</th>
                                <th class="columna">DESCRIPCION</th>
                                <th class="columna">NUM PARTE</th>
                                <th class="columna">NOTA</th>
                                <th class="columna">ESTATUS</th>
                                <th class="columna">ACCIONES</th>
                            </template>

                            <template v-slot:TableFooter>
                                <tr class="fila" v-for="art in Requi.requisicion_articulos" :key="art.id">
                                    <td class="tw-text-center">{{ art.Cantidad }}</td>
                                    <td class="tw-text-center">{{ art.Unidad }}</td>
                                    <td class="tw-text-center">{{ art.Descripcion }}</td>
                                    <td class="tw-text-center">{{ art.NumParte }}</td>
                                    <td class="tw-text-center">{{ art.MotivoCancelacion }}</td>
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
                                        <div class="columnaIconos">
                                            <div class="iconoEdit" @click="ArticuloAlmacen(art)" v-if="art.EstatusArt == 2">
                                                <span tooltip="Confirma Partida en Almacén" flow="left">
                                                    <i class="ml-2 fas fa-check-circle"></i>
                                                </span>
                                            </div>
                                            <div class="iconoEdit" @click="ArticuloCotizacion(art)" v-if="art.EstatusArt == 2">
                                                <span tooltip="Envia Partida a Cotizacion" flow="left">
                                                    <i class="fas fa-money-bill-wave"></i>
                                                </span>
                                            </div>
                                            <div class="iconoEdit" @click="Parcialidad(art)">
                                                <span tooltip="Confirma Parcialidad" flow="left">
                                                    <i class="fas fa-box-open"></i>
                                                </span>
                                            </div>
                                            <div class="iconoPurple" @click="SolicitaReposicion(art)">
                                                <span tooltip="Solicita Reposición" flow="left">
                                                    <i class="fas fa-dolly"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </Table>
                    </div>

                    <div v-else-if="Requi.requisicion_articulos[0].RecibidoPor != ''">
                        <p class="tw-text-center tw-p-2 tw-text-coolGray-400 tw-text-xs"> -- Articulos --</p>
                        <Table>
                            <template v-slot:TableHeader>
                                <th class="columna">CANTIDAD</th>
                                <th class="columna">UNIDAD</th>
                                <th class="columna">DESCRIPCION</th>
                                <th class="columna">NUM PARTE</th>
                                <th class="columna">NOTA</th>
                                <th class="columna">RECIBIO</th>
                                <th class="columna">ESTATUS</th>
                                <th class="columna">ACCIONES</th>
                            </template>

                            <template v-slot:TableFooter>
                                <tr class="fila" v-for="art in Requi.requisicion_articulos" :key="art.id">
                                    <td class="tw-text-center">{{ art.Cantidad }}</td>
                                    <td class="tw-text-center">{{ art.Unidad }}</td>
                                    <td class="tw-text-center">{{ art.Descripcion }}</td>
                                    <td class="tw-text-center">{{ art.NumParte }}</td>
                                    <td class="tw-text-center">{{ art.MotivoCancelacion }}</td>
                                    <td class="tw-text-center">{{ art.RecibidoPor }}</td>
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
                                        <div class="columnaIconos">
                                            <div class="iconoEdit" @click="ArticuloAlmacen(art)" v-if="art.EstatusArt == 2">
                                                <span tooltip="Confirma Partida en Almacén" flow="left">
                                                    <i class="ml-2 fas fa-check-circle"></i>
                                                </span>
                                            </div>
                                            <div class="iconoEdit" @click="ArticuloCotizacion(art)" v-if="art.EstatusArt == 2">
                                                <span tooltip="Envia Partida a Cotizacion" flow="left">
                                                    <i class="fas fa-money-bill-wave"></i>
                                                </span>
                                            </div>
                                            <div class="iconoEdit" @click="Parcialidad(art)">
                                                <span tooltip="Confirma Parcialidad" flow="left">
                                                    <i class="fas fa-box-open"></i>
                                                </span>
                                            </div>
                                            <div class="iconoPurple" @click="SolicitaReposicion(art)">
                                                <span tooltip="Solicita Reposición" flow="left">
                                                    <i class="fas fa-dolly"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </Table>
                    </div>

                    <div v-if="Requi.requisiciones_vales != ''">
                        <p class="tw-text-center tw-p-2 tw-text-coolGray-400 tw-text-xs"> -- Vales de Salida --</p>
                        <Table>
                            <template v-slot:TableHeader>
                                <th class="columna">FOLIO</th>
                                <th class="columna">SALIDA</th>
                                <th class="columna">PROVEEDOR</th>
                                <th class="columna">ESTATUS</th>
                                <th class="columna">SALIDA</th>
                            </template>
                            <template v-slot:TableFooter>
                                <tr class="fila" v-for="vale in Requi.requisiciones_vales" :key="vale.id">
                                    <td class="tw-text-center">{{ vale.Folio }}</td>
                                    <td class="tw-text-center">{{ vale.Fecha }}</td>
                                    <td class="tw-text-center">{{ vale.NombreProveedor }}</td>
                                    <td class="tw-text-center">{{ vale.EstatusVale }}</td>
                                    <td class="tw-text-center">{{ vale.Salida }}</td>
                                </tr>
                            </template>
                        </Table>
                    </div>
                </div>

                <div class="ModalFooter">
                    <jet-CancelButton @click="chagePartidas">Cerrar</jet-CancelButton>
                </div>
            </modal>

            <modal :show="showModal" @close="chageClose" :maxWidth="tam">
                <div class="tw-px-4 tw-py-4">
                    <div class="tw-text-lg">
                        <div class="ModalHeader">
                            <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Crea Parcialidad {{ Requi.NumReq }}</h3>
                        </div>
                    </div>
                    <div class="tw-mx-8">

                    <div>
                        <p class="tw-text-center tw-p-2 tw-text-coolGray-400 tw-text-xs"> -- Articulos --</p>
                        <Table>
                            <template v-slot:TableHeader>
                                <th class="columna">CANTIDAD</th>
                                <th class="columna">UNIDAD</th>
                                <th class="columna">DESCRIPCION</th>
                                <th class="columna">NUM PARTE</th>
                                <th class="columna">PACIALIDAD</th>
                            </template>

                            <template v-slot:TableFooter>
                                <tr class="fila">
                                    <td class="tw-text-center">{{ form.Cant }}</td>
                                    <td class="tw-text-center">{{ form.Uni }}</td>
                                    <td class="tw-text-center">{{ form.Desc }}</td>
                                    <td class="tw-text-center">{{ form.NumParte }}</td>
                                    <td class="tw-text-center">
                                        <jet-input type="number" min="1" v-model="form.Parcialidad"></jet-input>
                                    </td>
                                </tr>
                            </template>
                        </Table>
                    </div>
                </div>
                </div>

                <div class="ModalFooter">
                    <jet-button type="button" @click="ConfirmaParcialidad(form)">Confirmar Parcialidad</jet-button>
                    <jet-CancelButton @click="chageClose">Cerrar</jet-CancelButton>
                </div>
            </modal>

            <modal :show="showRepo" @close="chageRepo" maxWidth="xl">
                <form>
                    <div class="tw-px-4 tw-py-4">
                        <div class="tw-text-lg">
                            <div class="ModalHeader">
                                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Solicita Reposicion de Stock {{Requi.NumReq}}</h3>
                            </div>
                        </div>

                        <div class="tw-mt-4">
                            <div class="tw-container tw-max-w-screen-lg tw-mx-auto">
                                <section class="tw-rounded-md">
                                    <h2 class="tw-uppercase tw-tracking-wide tw-text-md tw-font-semibold tw-text-gray-500 tw-my-2 tw-text-center">Solicita la reposicion del material para stock</h2>
                                    <fieldset class="tw-mb-3 tw-bg-white tw-flex tw-table-column tw-shadow-lg tw-rounded tw-text-gray-600">
                                        <div class="tw-flex tw-border-b tw-border-gray-200 tw-h-12 tw-py-3 tw-items-center">
                                            <div class="tw-w-1/3"><span class="tw-text-right tw-px-2">Número de requsición: </span></div>
                                            <div class="tw-w-2/3 tw-font-bold">{{Requi.NumReq}}</div>
                                        </div>
                                        <div class="tw-flex tw-border-b tw-border-gray-200 tw-h-12 tw-py-3 tw-items-center">
                                            <div class="tw-w-1/3"><span class="tw-text-right tw-px-2">Material: </span></div>
                                            <div class="tw-w-2/3 tw-font-bold">{{ Repo.Cantidad }} {{ Repo.Unidad }} {{ Repo.Descripcion }}</div>
                                        </div>
                                        <div class="tw-flex tw-border-b tw-border-gray-200 tw-h-12 tw-py-3 tw-items-center">
                                            <div class="tw-w-1/3"><span class="tw-text-right tw-px-2">Cantidad: </span></div>
                                            <div class="tw-w-2/3 tw-font-bold"><input type="text" class="tw-bg-gray-200 tw-rounded tw-w-16 tw-h-8" v-model="form.Cant"> {{ Repo.Unidad }}</div>
                                        </div>
                                        <div class="tw-flex tw-border-b tw-border-gray-200 tw-h-12 tw-py-3 tw-items-center">
                                            <div class="tw-w-1/3"><span class="tw-text-right tw-px-2">Núm Parte: </span></div>
                                            <div class="tw-w-2/3 tw-font-bold" v-if="Repo.NumParte != ''">{{ Repo.NumParte }}</div>
                                            <div class="tw-w-2/3 tw-font-bold" v-else>N/A</div>
                                        </div>
                                        <div class="tw-flex border-b tw-border-gray-200 tw-h-12 tw-py-3 tw-items-center">
                                            <div class="tw-w-1/3"><span class="tw-text-right tw-px-2">Observaciones:</span></div>
                                            <div class="tw-w-2/3 tw-font-bold">{{ Requi.Observaciones }}</div>
                                        </div>
                                    </fieldset>
                                </section>
                            </div>
                        </div>
                    </div>

                    <div class="ModalFooter">
                        <jet-button type="button" @click="GeneraReposicion(form)">Guardar</jet-button>
                        <jet-CancelButton @click="chageRepo">Cerrar</jet-CancelButton>
                    </div>
                </form>
            </modal>

            <modal :show="showFirma" @close="chageFirma" maxWidth="2xl">
                <form>
                    <div class="tw-px-4 tw-py-4">
                        <div class="tw-text-lg">
                            <div class="ModalHeader">
                                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Firma de Proveedor</h3>
                            </div>
                        </div>

                        <div class="tw-mt-4">
                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 tw-w-full md:tw-w-full md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Nombre Completo</jet-label>
                                    <jet-input type="text" :min="min" v-model="form.NomProveedor"></jet-input>
                                    <small v-if="errors.NomProveedor" class="validation-alert">{{errors.NomProveedor}}</small>
                                </div>
                            </div>
                            <div class="tw-mb-6 md:tw-flex">
                                <Canvas/>
                            </div>
                            <div class="tw-mb-6 md:tw-flex">
                            </div>
                        </div>
                    </div>

                    <div class="ModalFooter">
                        <jet-button type="button">Guardar</jet-button>
                        <jet-CancelButton @click="chageProveedor">Cerrar</jet-CancelButton>
                    </div>
                </form>
            </modal>

            <modal :show="showConfirm" @close="chageConfirm" maxWidth="2xl">
                <form>
                    <div class="tw-px-4 tw-py-4">
                        <div class="tw-text-lg">
                            <div class="ModalHeader">
                                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Acepta entrega del Producto</h3>
                            </div>
                        </div>

                        <div class="tw-mt-4">
                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Número Empleado</jet-label>
                                    <jet-input type="text" :min="min" v-model="form.User"></jet-input>
                                    <small v-if="errors.User" class="validation-alert">{{errors.User}}</small>
                                </div>

                                <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Contraseña</jet-label>
                                    <jet-input type="password" v-model="form.Pass"></jet-input>
                                    <small v-if="errors.Pass" class="validation-alert">{{errors.Pass}}</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ModalFooter">
                        <jet-button type="button" @click="AceptaProducto(form, 9)">Guardar</jet-button>
                        <jet-CancelButton @click="chageConfirm">Cerrar</jet-CancelButton>
                    </div>
                </form>
            </modal>

            <modal :show="showProveedor" @close="chageProveedor" maxWidth="2xl">
                <div class="tw-px-4 tw-py-4">
                    <div class="tw-text-lg">
                        <div class="ModalHeader">
                            <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>VALE DE SALIDA</h3>
                        </div>
                    </div>

                    <div class="tw-mt-4">
                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                                <jet-label><span class="required">*</span>Folio</jet-label>
                                <jet-input type="text" :min="min" v-model="ValeSalida.Folio"></jet-input>
                                <small v-if="errors.Folio" class="validation-alert">{{errors.Folio}}</small>
                            </div>

                            <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                                <jet-label><span class="required">*</span>Fecha Entrega</jet-label>
                                <jet-input type="date" v-model="ValeSalida.Fecha"></jet-input>
                                <small v-if="errors.FechaEn" class="validation-alert">{{errors.FechaEn}}</small>
                            </div>
                        </div>
                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                                <jet-label><span class="required">*</span>Proveedor</jet-label>
                                <select id="Jefe" v-model="ValeSalida.NombreProveedor"  class="InputSelect">
                                    <option v-for="select in Proveedores" :key="select.id" :value="select.Nombre" >{{ select.Nombre }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                                <jet-label><span class="required">*</span>Fecha Entrega</jet-label>
                                <jet-input type="date" v-model="ValeSalida.Salida"></jet-input>
                                <small v-if="errors.Salida" class="validation-alert">{{errors.Salida}}</small>
                            </div>

                            <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                                <jet-label><span class="required">*</span>Estatus</jet-label>
                                <select class="InputSelect" v-model="ValeSalida.EstatusVale">
                                    <option value="ENTREGADO">ENTREGADO</option>
                                    <option value="GARANTIA">GARANTIA</option>
                                    <option value="N/A">N/A</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ModalFooter">
                    <jet-button type="button" @click="GuardaProveedor(ValeSalida)">Guardar</jet-button>
                    <jet-CancelButton @click="chageProveedor">Cerrar</jet-CancelButton>
                </div>
            </modal>

            <!-- Impresion oculta -->
<!--             <div id="div_print">
                <div>
                    <p>Requisicion: <strong> {{ DatosTicket.NumReq }}</strong></p>
                    <p>Orden Compra: <strong>{{ DatosTicket.OrdenCompra }}</strong></p>
                    <p>Fecha <strong>{{ now }}</strong></p>
                </div>
                <div class="tw-p-2 tw-h-64 tw-h-64">
                    <div class="qrcode-style" id="qrcode"></div>
                </div>
            </div>

            <button type="button" @click="imprimirSeleccion('div_print')">Imprimir</button>
 -->
        </div>
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
import QRCode from "qrcodejs2";
 //datatable
import datatable from 'datatables.net-bs5';
require( 'datatables.net-buttons-bs5/js/buttons.bootstrap5' );
require( 'datatables.net-buttons/js/buttons.html5' );
require ( 'datatables.net-buttons/js/buttons.colVis' );
import BotonCarga from '../../../Components/BotonCarga.vue';
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
import Canvas from "@/Components/Canvas";

export default {
    data() {
        return {
            showPartidas: false,
            showFirma: false,
            showConfirm: false,
            showRepo: false,
            showProveedor: false,
            loading: false,
            min: moment().format("YYYY-MM-DD"),
            now: moment().format("YYYY-MM-DD"),
            anio: moment().format("YYYY"),
            tam: "5xl",
            color: "tw-bg-cyan-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            detalles: null,
            requisicion: [],
            form: {
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
                Accion: '',
                req_id: '',
                IdArt:  '',
                Parcialidad: '',
                NumReq: '',
                Dpto: '',
                Fecha: '',
                Cant: '',
                Uni: '',
                Desc: '',
                NumParte: '',
                Departamento_id: '',
                Maquina_id: '',
                Marca_id: '',
                TipCompra: '',
                User: '',
                Pass: '',
                NomProveedor: '',
                Obser: '',
                Codigo: '',
                Maq: '',
                Mar: '',
                TipCompra: '',
                Folio: '',
                FechaEn: '',
                Proveedor: '',
                Salida: '',
                EstatusServ: '',
            },
            ValeSalida:{
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
                Accion: 1,
                Folio: '',
                Fecha: '',
                NombreProveedor: '',
                EstatusVale: '',
                Salida: '',
                requisiciones_id: '',
            },
            params:{
                Year: 0,
                Month: 0,
                Status: 0,
                View: 1,
            },
            DatosTicket: {
                NumReq: 0,
                OrdenCompra: 0,
            },
            CambioVista: 1,
            Cambio: false,
            Requi: [], //Asignacion de requisicion para partidas
            Art: [],
            Repo: [],
            Visualizacion: 'PARTIDAS',
            Marcas: [],
        };
    },

    mounted() {
        // this.qrcode();
        this.params.Month = this.mes;
        this.tabla();
        this.params.Month = this.mes;
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
                if(pair[0] == 'Month') {
                    this.params.Month = pair[1];
                }
                if(pair[0] == 'Status') {
                    this.params.Status = pair[1];
                }
                if(pair[0] == 'Indicador') {
                    this.params.Indicador = pair[1];
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
        BotonCarga,
        Modal,
        Pagination,
        JetInput,
        JetLabel,
        JetSelect,
        Canvas,
    },

    props: {
        Session: Object,
        errors: Object,
        flash: Boolean,
        Requisiciones: Object,
        Proveedores: Object,
        Almacen: Number,
        Cotizacion: Number,
        SinConfirmar: Number,
        Vista: String,
        mes: String,
        datos: Object,
    },

    methods: {

        qrcode() {
            let qrcode = new QRCode("qrcode", {
                ancho: 200, // establece el ancho en píxeles
                height: 200, // establece la altura en píxeles
                text: "https://intranethlangeles.com/Compras/Requisiciones?Year=2022&Month=2&Status=0&View=1&Req=", // Establezca el contenido del código QR o la dirección de redireccionamiento,
                colorDark : "#64748B",
                colorLight : "#ffffff",
            });
        },

        Filtros(){ //Generacion de consulta aplicada con Filtros
            this.loading = true;
            $('#Requisiciones').DataTable().clear();
            $('#Requisiciones').DataTable().destroy();
            this.$inertia.get('/Almacen/Requisiciones', this.params , { //envio de variables por url
                onSuccess: () => {
                    this.loading = false;
                    this.tabla();
                    //Verifico si hubo un cambio en la vista
                    if(this.Cambio == true){
                        location.reload();
                    }
                }, preserveState: true})
        },

        FiltroIndicadores(value){
            //Filtro para consultar solo por el estatus

            //OBTENER VALOR DE FRILTRO DE LA URL
            var query  = window.location.search.substring(1);
            var vars = query.split("&");
                for (var i=0; i < vars.length; i++) {
                    var pair = vars[i].split("=");
                    if(pair[0] == 'View') {
                        this.params.View = pair[1];
                    }
            }

            this.params.Year = 0;
            this.params.Month = 0;
            this.params.Status = value;
            this.loading = true;

            $('#Requisiciones').DataTable().clear();
            $('#Requisiciones').DataTable().destroy();
            this.$inertia.get('/Almacen/Requisiciones', this.params , { //envio de variables por url
                onSuccess: () => {
                    this.loading = false;
                    // location.reload();
                    this.tabla();
                    //Verifico si hubo un cambio en la vista
                    if(this.Cambio == true){
                        location.reload();
                    }
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
                        { "width": "5%", "targets": [7] },
                        { "width": "3%", "targets": [1,2,3,5,6] },
                        { "width": "8%", "targets": [4] },
                        // { "width": "9%", "targets": [6] },
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

        ClearCanvas(){
            var c = document.getElementById("myCanvas");
            this.canvas.clearRect(0, 0, c.width, c.height);
        },

        GuardarCanvas(){
            console.log("Guardar Canvas");
            var c = document.getElementById("myCanvas");
            var dataUrl = c.toDataURL();
            // drawImage.setAttribute("src", dataUrl);
            console.log(dataUrl);
        },

        reset() {
            this.form = {
                Accion: '',
                req_id: '',
                IdArt:  '',
                Parcialidad: '',
                NumReq: '',
                Dpto: '',
                Fecha: '',
                Cant: '',
                Uni: '',
                Desc: '',
                User: '',
                Pass: '',
                NomProveedor: '',
                Obser: '',
                Codigo: '',
                Maq: '',
                Mar: '',
                TipCompra: '',
                Folio: '',
                FechaEn: '',
                Proveedor: '',
                Salida: '',
                EstatusServ: '',
            };

            this.ValeSalida = {
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
                Accion: 1,
                Folio: '',
                Fecha: '',
                NombreProveedor: '',
                EstatusVale: '',
                Salida: '',
                requisiciones_id: '',
            };
        },

        chageClose() {
            this.showModal = !this.showModal;
        },

        chageConfirm() {
            this.form.User = null,
            this.form.Pass = null,
            this.showConfirm = !this.showConfirm;
        },

        chagePartidas() {
            this.showPartidas = !this.showPartidas;
        },

        chageFirma(){
            this.showFirma = !this.showFirma;
        },

        chageRepo(){
            this.showRepo = !this.showRepo;
        },

        Parcialidad(data){
            this.Art = data;
            this.form.IdArt = data.id;
            this.form.NumReq = this.Requi.NumReq;
            this.form.Fecha = data.Fecha;
            this.form.Cant = data.Cantidad;
            this.form.Uni = data.Unidad;
            this.form.Desc = data.Descripcion;
            this.form.NumParte = data.NumParte;
            this.chageClose();
        },

        ConfirmaParcialidad(data) {
            data.metodo = 6;
            data._method = "PUT";
            this.$inertia.post("/Almacen/Requisiciones/" + data.id, data, {
                    onSuccess: () => {
                        this.reset(),
                        this.chageClose(),
                        this.alertSucces();
                    },
                });
        },

        SolicitaReposicion(data){
            this.Repo = data;
            this.form.req_id = this.Requi.id;
            this.form.NumReq = this.Requi.NumReq;
            this.form.Departamento_id = this.Requi.Departamento_id;
            this.form.Codigo = this.Requi.Codigo;
            this.form.Maquina_id = this.Requi.Maquina_id;
            this.form.Marca_id = this.Requi.Marca_id;
            this.form.TipCompra = this.Requi.TipCompra;

            this.form.IdArt = data.id;
            this.form.Fecha = data.Fecha;
            this.form.Cant = data.Cantidad;
            this.form.Uni = data.Unidad;
            this.form.Desc = data.Descripcion;
            this.form.NumParte = data.NumParte;
            this.chageRepo();
        },

        GeneraReposicion(data){
            this.form.Accion = 2;
            this.$inertia.post("/Almacen/Requisiciones", data, {
                onSuccess: () => {
                    this.reset(),
                    this.chageRepo(),
                    this.alertSucces();
                },
            });
        },

        PrecioProveedor(data){
            this.chageProveedor();
            this.form.IdArt = data.id;
        },

        Partidas(data){ //Visualizacion de partidas
            this.Requi = data;
            this.chagePartidas();
        },

        EnviarCotizarRequisicion(data){ //Enviar requisicion a cotizacion
            data.metodo = 1;
            data._method = "PUT";
            this.form.req_id = data.id;
            this.ValeSalida.requisiciones_id = data.id;
            this.$inertia.post("/Almacen/Requisiciones/" + data.id, data, {
                onSuccess: () => {
                    if(data.TipCompra == 'SERVICIOS EXTERNOS'){
                        this.chageProveedor();
                    }
                    this.alertSucces();
                },
            });
        },

        ArticuloCotizacion(data){
            data.metodo = 4;
            data._method = "PUT";
            this.$inertia.post("/Almacen/Requisiciones/" + data.id, data, {
                onSuccess: () => {
                    this.alertSucces();
                },
            });
        },

        RequisicionAlmacen(data){ //Confirmar requisicion en Almacen
            data.metodo = 2;
            data._method = "PUT";
            this.$inertia.post("/Almacen/Requisiciones/" + data.id, data, {
                onSuccess: () => {
                    this.alertSucces();
                },
            });
        },

        ArticuloAlmacen(data){
            data.metodo = 5;
            data._method = "PUT";
            this.$inertia.post("/Almacen/Requisiciones/" + data.id, data, {
                onSuccess: () => {
                    this.alertSucces();
                },
            });
        },

        EntregaProducto(data){ //Abre Modal para contraseña y Contraseña
            this.chageConfirm();
            this.form.IdArt = data.id;
            this.$inertia.get('/Almacen/Requisiciones', this.params , {preserveState: true })
        },

        AceptaProducto(data, metodo){ //Envia User y pass para su verificacion
            data.metodo = 3;
            data._method = "PUT";
            this.$inertia.post("/Almacen/Requisiciones/" + data.id, data, {
                preserveScroll : true ,
                resetOnSuccess : false ,
                onSuccess: () => {
                    this.alertSucces();
                    this.chageConfirm();
                },
            });
        },

        chageProveedor(){
            this.showProveedor = !this.showProveedor;
        },

        IndicaProveedor(data){
            this.form.Accion = 1;
            this.chageProveedor();
            this.ValeSalida.requisiciones_id = data.id;
        },

        GuardaProveedor(data){
            this.$inertia.post("/Almacen/Requisiciones", data, {
                onSuccess: () => {
                    this.chageProveedor();
                    this.alertSucces();
                    this.reset();
                },
            });
        },

        Ticket(data){
            console.log(data);
            var TotalRequisicion = 0;
            this.DatosTicket.NumReq = data.NumReq;
            this.DatosTicket.OrdenCompra = data.OrdenCompra;
            var ventana = window.open('', 'PRINT', 'height=400,width=600');
            ventana.document.write('<html><head><title>' + document.title + '</title>');
            ventana.document.write('<link rel="stylesheet" href="style.css" media="print">'); //Aquí agregué la hoja de estilos
            ventana.document.write('<style>');
            ventana.document.write('@media print { @page{margin: 0;} body{margin-left: 20px; margin-right: 20px; font-size: 12px; text-transform: uppercase;} }');
            ventana.document.write('</style>');
            ventana.document.write('</head><body>');
            ventana.document.write('<div>');
            ventana.document.write('<img width="180" height="40" style="margin-right: 170px; margin-left: 35px; margin-botton: 5px; margin-top: 0px; padding-top: 0px;" a src="data:image/png;base64,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">');
            ventana.document.write('<p>Departamento:<strong style="font-weight: bold;">'+' '+data.requisicion_departamento.Nombre+'</strong></p>');
            ventana.document.write('<p>Tipo Compra:<strong style="font-weight: bold;">'+' '+data.TipCompra+'</strong></p>');
            ventana.document.write('<p>Maquina:<strong style="font-weight: bold;">'+' '+data.requisicion_maquina.Nombre+'</strong></p>');
            ventana.document.write('<p>Orden Compra:<strong style="font-weight: bold;">'+' '+data.OrdenCompra+'</strong></p>');
            ventana.document.write('<p>Requisición: <strong style="font-weight: bold;">'+' '+data.NumReq+'</strong></p>');
            ventana.document.write('<p>Fecha Autorización: <strong style="font-weight: bold;">'+' '+data.FecAutorizacion+'</strong></p>');
            ventana.document.write('<p>Proveedor:<strong style="font-weight: bold;">'+' '+data.requisicion_articulos[0].articulo_precios[0].precio_proveedor.Nombre+'</strong></p>');
            data.requisicion_articulos.forEach(function (art) {
                    art.articulo_precios.forEach(function (pre) {
                        TotalRequisicion += Number(pre.Total);
                    });
            });
            const currency = function(number){
                return new Intl.NumberFormat('en-IN', {style: 'currency',currency: 'MXN', minimumFractionDigits: 2}).format(number);
            };
            var Total1 = currency(TotalRequisicion);
            var Total = Total1.substr(2,);
            console.log(Total);
            ventana.document.write('<p>Total:<strong style="font-weight: bold;">'+Total+'</strong></<p>');
            ventana.document.write('<p style="font-size: 11px; text-align: right; font-weight: bold;">'+ moment().format('DD/MM/YYYY HH:mm')+'</<p>');
            ventana.document.write('</div>');
            ventana.document.write('</body></html>');
            ventana.document.close();
            ventana.focus();

            var beforePrint = function() {
                console.log(data);
                ventana.close();
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                    toast.addEventListener("mouseenter", Swal.stopTimer);
                    toast.addEventListener("mouseleave", Swal.resumeTimer);
                    },
                });

                Toast.fire({
                    icon: "success",
                    title: "Impresión Exitosa",
                    // background: '#99F6E4',
                });
            };

            ventana.onload = function() {
                ventana.print();
                ventana.print();
                ventana.close();
                beforePrint();
            };
            return true;
        },

        imprimirSeleccion(nombre) { //Imprimir div oculto
            var ficha = document.getElementById(nombre);
            var ventana = window.open(' ', 'popimpr', 'height=400,width=600');
            ventana.document.write( ficha.innerHTML );
            ventana.document.close();
            ventana.print();
            ventana.close();
        },
    },

};
</script>
