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

                        <div class="tw-w-full tw-cursor-pointer lg:tw-w-1/4" @click="FiltroIndicadores(5)">
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
                                <td>
                                    <div class="columnaIconos">
                                        <div class="iconoEdit" @click="ArticuloAlmacen(datos)">
                                            <span tooltip="Confirma Partida en Almacén" flow="left">
                                                <i class="ml-2 fas fa-check-circle"></i>
                                            </span>
                                        </div>
                                        <div class="iconoEdit" @click="ArticuloCotizacion(datos)" v-if="datos.EstatusArt == 2">
                                            <span tooltip="Envia Partida a Cotizacion" flow="left">
                                                <i class="fas fa-money-bill-wave"></i>
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
                                        <div class="iconoEdit" @click="IndicaProveedor(datos)" v-if="datos.TipCompra == 'SERVICIOS EXTERNOS'">
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
                                        <div class="iconoDetails" @click="Ticket(datos)">
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
                                <th class="columna">ACCIONES</th>
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
                                <jet-input type="text" :min="min" v-model="form.Folio"></jet-input>
                                <small v-if="errors.Folio" class="validation-alert">{{errors.Folio}}</small>
                            </div>

                            <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                                <jet-label><span class="required">*</span>Fecha Entrega</jet-label>
                                <jet-input type="date" v-model="form.FechaEn"></jet-input>
                                <small v-if="errors.FechaEn" class="validation-alert">{{errors.FechaEn}}</small>
                            </div>
                        </div>
                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                                <jet-label><span class="required">*</span>Proveedor</jet-label>
                                <select id="Jefe" v-model="form.Proveedor"  class="InputSelect">
                                    <option v-for="select in Proveedores" :key="select.id" :value="select.Nombre" >{{ select.Nombre }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                                <jet-label><span class="required">*</span>Fecha Entrega</jet-label>
                                <jet-input type="date" v-model="form.Salida"></jet-input>
                                <small v-if="errors.Salida" class="validation-alert">{{errors.Salida}}</small>
                            </div>

                            <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                                <jet-label><span class="required">*</span>Estatus</jet-label>
                                <select class="InputSelect" v-model="form.EstatusServ">
                                    <option value="ENTREGADO">ENTREGADO</option>
                                    <option value="GARANTIA">GARANTIA</option>
                                    <option value="N/A">N/A</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ModalFooter">
                    <jet-button type="button" @click="IndicaProveedor(form)">Guardar</jet-button>
                    <jet-CancelButton @click="chageProveedor">Cerrar</jet-CancelButton>
                </div>
            </modal>
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
import Canvas from "@/Components/Canvas";

export default {
    data() {
        return {
            showPartidas: false,
            showFirma: false,
            showConfirm: false,
            showRepo: false,
            showProveedor: false,
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
            params:{
                Year: moment().format("YYYY"),
                Month: 0,
                Status: 0,
                View: 1,
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

        Filtros(){ //Generacion de consulta aplicada con Filtros
            $('#Requisiciones').DataTable().clear();
            $('#Requisiciones').DataTable().destroy();
            this.$inertia.get('/Almacen/Requisiciones', this.params , { //envio de variables por url
                onSuccess: () => {
                    this.tabla();
                    //Verifico si hubo un cambio en la vista
                    if(this.Cambio == true){
                        $('#Requisiciones').DataTable().clear();
                        $('#Requisiciones').DataTable().destroy();
                        this.tabla();
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

        FiltroIndicadores(value){
            //Filtro para consultar solo por el estatus

            //OBTENER VALOR DE FRILTRO DE LA URL
            var query  = window.location.search.substring(1);
            var vars = query.split("&");
                for (var i=0; i < vars.length; i++) {
                    var pair = vars[i].split("=");
                    if(pair[0] == 'Estatus') {
                        this.params.Partidas = pair[1];
                    }
            }

            this.params.Partidas = value;
            this.params.month = '';
            $('#Requisiciones').DataTable().clear(); //limpio
            $('#Requisiciones').DataTable().destroy(); //destruyo tabla
            this.$inertia.get('/Almacen/Requisiciones', this.params , { //envio de variables por url
                onSuccess: () => {
                    location.reload(); //Recargo pagina para evitar conflictos de la regeneracion de la tabla
                    this.tabla() //regeneracion de tabla
                }, preserveState: true})
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
            this.$inertia.post("/Almacen/Requisiciones/" + data.id, data, {
                onSuccess: () => {
                    this.chageProveedor();
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
            var ventana = window.open('', 'PRINT', 'height=400,width=600');
            ventana.document.write('<html><head><title>' + document.title + '</title>');
            ventana.document.write('<link rel="stylesheet" href="style.css">'); //Aquí agregué la hoja de estilos
            ventana.document.write('</head><body>');
            ventana.document.write('<div>');
            ventana.document.write('<p>Ticket de la orden de compra <strong>'+data.NumReq+'</strong></p>');
            ventana.document.write('<table>');
            ventana.document.write('<tr><td>Orden Compra:</td><td><strong>'+data.OrdenCompra+'</strong></td></tr>');
            data.requisicion_articulos.forEach(function (art) {
                ventana.document.write('<tr><td>Articulo:</td><td><strong>'+art.Descripcion+'</strong></td></tr>');
                    art.articulo_precios.forEach(function (pre) {
                        ventana.document.write('<tr><td>Marca:</td><td><strong>'+pre.Marca+'</strong></td></tr>');
                        ventana.document.write('<tr><td>Proveedor:</td><td><strong>'+pre.Proveedor+'</strong></td></tr>');
                        ventana.document.write('<tr><td>Total:</td><td><strong>'+pre.Total+'</strong></td></tr>');
                        ventana.document.write('<tr><td>Moneda:</td><td><strong>'+pre.Moneda+'</strong></td></tr>');
                        TotalRequisicion += Number(pre.Total);
                    });
            });
            ventana.document.write('<tr><td>Precio Total:</td><td><strong>'+TotalRequisicion+'</strong></td></tr>');
            ventana.document.write('</table>');
            ventana.document.write('</div>');
            ventana.document.write('</body></html>');
            ventana.document.close();
            ventana.focus();
            ventana.onload = function() {
                ventana.print();
                ventana.close();
            };
            return true;
        },
    },

};
</script>
