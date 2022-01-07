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

        <div class="tw-flex tw-items-center tw-justify-center tw-mt-4">
            <div class="tw-w-full tw-mx-auto sm:tw-px-8 lg:tw-px-10">
                <div class="tw-flex tw-flex-col tw-w-full tw-mb-2 tw-space-y-8 lg:tw-flex-row lg:tw-space-x-10 lg:tw-space-y-0 lg:tw-mb-4">

                    <div class="tw-w-full tw-cursor-pointer lg:tw-w-1/5">
                        <div class="tw-w-full tw-p-2 tw-bg-white tw-border-l-4 tw-border-indigo-500 tw-rounded-lg tw-widget">
                            <div class="tw-flex tw-items-center">
                                <div class="icon tw-w-10 tw-p-2 tw-bg-indigo-500 tw-text-white tw-rounded-full tw-mr-3">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div class="tw-flex tw-flex-col tw-justify-center">
                                    <div class="tw-text-lg"> {{ Cotizacion }} </div>
                                    <div class="tw-text-xs tw-text-gray-400">Pendientes por cotizar</div>
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
                                    <div class="tw-text-lg"> {{ Pendientes }} </div>
                                    <div class="tw-text-xs tw-text-gray-400">Pendientes por Autorizar</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tw-w-full tw-cursor-pointer lg:tw-w-1/5" @click="FiltroIndicadores(6)">
                        <div class="tw-w-full tw-p-2 tw-bg-white tw-border-l-4 tw-border-cyan-600 tw-rounded-lg tw-widget">
                            <div class="tw-flex tw-items-center">
                                <div class="icon tw-w-10 tw-p-2 tw-bg-cyan-600 tw-text-white tw-rounded-full tw-mr-3">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div class="tw-flex tw-flex-col tw-justify-center">
                                    <div class="tw-text-lg"> {{ Confirmar }} </div>
                                    <div class="tw-text-xs tw-text-gray-400">Pendientes Fecha Entrega</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tw-w-full tw-cursor-pointer lg:tw-w-1/5" @click="FiltroIndicadorMensual(5)">
                        <div class="tw-w-full tw-p-2 tw-bg-white tw-border-l-4 tw-border-orange-600 tw-rounded-lg tw-widget">
                            <div class="tw-flex tw-items-center">
                                <div class="icon tw-w-10 tw-p-2 tw-bg-orange-600 tw-text-white tw-rounded-full tw-mr-3">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div class="tw-flex tw-flex-col tw-justify-center">
                                    <div class="tw-text-lg"> {{ PendientesMes }} </div>
                                    <div class="tw-text-xs tw-text-gray-400">Pendientes por Autorizar de <strong>{{params.MesLetra}}</strong></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tw-w-full tw-cursor-pointer lg:tw-w-1/5">
                        <div class="tw-w-full tw-p-2 tw-bg-white tw-border-l-4 tw-border-indigo-600 tw-rounded-lg tw-widget">
                            <div class="tw-flex tw-items-center">
                                <div class="icon tw-w-10 tw-p-2 tw-bg-indigo-600 tw-text-white tw-rounded-full tw-mr-3">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div class="tw-flex tw-flex-col tw-justify-center">
                                    <div class="tw-text-lg"> {{ ICotizacionMes }} </div>
                                    <div class="tw-text-xs tw-text-gray-400">Pendientes por Cotizar de <strong>{{params.MesLetra}}</strong> </div>
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
                        <option value="5">SIN AUTORIZAR</option>
                        <option value="6">AUTORIZADOS</option>
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
<!--         <div class="tw-mt-8">
            <div class="tw-overflow-x-auto tw-mx-2" v-if="params.Partidas == true">
                <Table id="Articulos">
                    <template v-slot:TableHeader>
                        <th class="columna">FECHA</th>
                        <th class="columna">REQ</th>
                        <th class="columna">DEPARTAMENTO</th>
                        <th class="columna">CÓDIGO</th>
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
                        <tr class="fila" v-for="datos in ArticulosRequisiciones" :key="datos.id">
                            <td>{{ datos.Fecha.substr(5) }}</td>
                            <td class="tw-text-center">{{ datos.articulos_requisicion.NumReq }}</td>
                            <td>{{ datos.articulos_requisicion.requisicion_departamento.Nombre }}</td>
                            <td class="tw-text-center">{{ datos.articulos_requisicion.Codigo.substr(0,1) }}</td>
                            <td class="tw-text-center">{{ datos.Cantidad }}</td>
                            <td class="tw-text-center">{{ datos.Unidad }}</td>
                            <td>{{ datos.Descripcion }}</td>
                            <td>{{ datos.articulos_requisicion.requisicion_maquina.Nombre }}</td>
                            <td>{{ datos.articulos_requisicion.requisicion_marca.Nombre }}</td>
                            <td class="tw-text-center">{{ datos.articulos_requisicion.TipCompra }}</td>
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
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-text-xxs tw-h-6 tw-px-3 tw-text-white tw-bg-orange-600 tw-rounded-full">AUTORIZAR</span>
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
                                    <div class="iconoDetails" @click="VisualizaCotizacion(datos.articulos_requisicion)">
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
            <div class="tw-overflow-x-auto tw-mx-2" v-else>
                <Table id="Requisiciones">
                    <template v-slot:TableHeader>
                        <th>FECHA</th>
                        <th>REQ</th>
                        <th>DEPARTAMENTO</th>
                        <th>CODIGO</th>
                        <th>MAQUINA</th>
                        <th>MARCA</th>
                        <th>TIPO</th>
                        <th>OBSERVACIONES</th>
                        <th>SOLICITANTE</th>
                        <th>O.C</th>
                        <th>ESTATUS</th>
                        <th>ACCIONES</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila" v-for="datos in Requisiciones" :key="datos.id">
                            <td class="tw-text-center">{{ datos.Fecha.substr(5) }}</td>
                            <td class="tw-text-center">{{ datos.NumReq }}</td>
                            <td class="tw-text-center">{{ datos.requisicion_departamento.Nombre }}</td>
                            <td class="tw-text-center">{{ datos.Codigo.substr(0,1) }}</td>
                            <td class="tw-text-center">{{ datos.requisicion_maquina.Nombre }}</td>
                            <td class="tw-text-center">{{ datos.requisicion_marca.Nombre }}</td>
                            <td class="tw-text-center">{{ datos.TipCompra }}</td>
                            <td>{{ datos.Observaciones }}</td>
                            <td class="tw-text-center">{{ datos.requisiciones_perfil.Nombre }} {{ datos.requisiciones_perfil.ApPat }}</td>
                            <td>{{ datos.OrdenCompra }}</td>
                            <td>
                                <div v-if="datos.Estatus == 2">
                                    <span tooltip="REQUSICIÓN SOLICITADA" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-violet-400 tw-rounded-full">SOLICITADO</span>
                                    </span>
                                </div>
                                <div v-else-if="datos.Estatus == 3 || datos.Estatus == 4">
                                    <span tooltip="REQUSICIÓN EN ESPERA DE COTIZACIÓN" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-indigo-500 tw-rounded-full">EN COTIZACION</span>
                                    </span>
                                </div>
                                <div v-else-if="datos.Estatus == 5">
                                    <span tooltip="EN ESPERA DE AUTORIZACIÓN" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-orange-600 tw-rounded-full">AUTORIZAR</span>
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
                                <div class="columnaIconos" v-if="datos.Estatus > 4">
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
                        <th class="columna">COMENTARIO</th>
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
                            <td>{{ datos.articulos_requisicion.MotivoCancelacion }}</td>
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
                                    <span tooltip="POR AUTORIZAR" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-text-xxs tw-h-6 tw-px-3 tw-text-white tw-bg-orange-600 tw-rounded-full">AUTORIZAR</span>
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
                                    <div class="iconoDetails" @click="VisualizaCotizacion(datos.articulos_requisicion)">
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
                        <th>LLEGADA</th>
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
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-orange-600 tw-rounded-full">AUTORIZAR</span>
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
                                <div class="columnaIconos" v-if="datos.Estatus > 4">
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

    </div>

    <modal :show="showPartidas" @close="chagePartidas" :maxWidth="tam">
        <div class="tw-px-4 tw-py-4">
            <div class="tw-text-lg">
                <div class="ModalHeader">
                    <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Articulos de requisición </h3>
                </div>
            </div>
        </div>

        <div class="tw-mx-4">
            <Table>
                <template v-slot:TableHeader>
                    <th class="columna">CANTIDAD</th>
                    <th class="columna">UNIDAD</th>
                    <th class="columna">DESCRIPCION</th>
                    <th class="columna">NUM PARTE</th>
                    <th class="columna">RECIBIDO</th>
                    <th class="columna">ACCIONES</th>
                </template>

                <template v-slot:TableFooter>
                    <tr class="fila" v-for="art in ArticulosRequisiciones" :key="art.id">
                        <td>{{ art.Cantidad }}</td>
                        <td>{{ art.Unidad }}</td>
                        <td>{{ art.Descripcion }}</td>
                        <td>{{ art.NumParte }}</td>
                        <td>{{ art.RecibidoPor }}</td>
                        <td>
                            <div class="columnaIconos" v-if="art.EstatusArt == 4">
                                <div class="iconoEdit" @click="EditaPrecio(art)">
                                    <span tooltip="Editar Precio" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="columnaIconos" v-else-if="art.EstatusArt == 7">
                                <div class="iconoPurple" @click="ProductoAlmacen(art, 8)">
                                    <span tooltip="Confirma Producto en Almacén" flow="left">
                                        <i class="ml-2 fas fa-box"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="columnaIconos" v-else-if="art.EstatusArt == 8">
                                <div class="iconoLime" @click="EntregaProducto(art)">
                                    <span tooltip="Entrega el Artículo" flow="left">
                                        <i class="fas fa-fingerprint"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="columnaIconos" v-else-if="art.EstatusArt == 9">
                                <div class="iconoGreen" v-if="art.articulos_requisicion.NumReq.endsWith('-S') != true" @click="SolicitaReposicion(art)">
                                    <span tooltip="Solicitar Reposicion" flow="left">
                                        <i class="fas fa-dolly"></i>
                                    </span>
                                </div>
                                <div class="iconoGreen" v-else>
                                    <span tooltip="Articulo Adquirido" flow="left">
                                        <i class="fas fa-check-square"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="columnaIconos" v-else>
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

        <div class="ModalFooter">
            <jet-button type="button" @click="save(form)" v-show="!editMode2">Confirmar Requisición</jet-button>
            <jet-CancelButton @click="chageClose">Cerrar</jet-CancelButton>
        </div>
    </modal>

    <modal :show="showPreciosRequisicion" @close="chagePreciosRequisicion" :maxWidth="tam">
        <div class="tw-px-4 tw-py-2">
            <div class="tw-text-lg">
                <div class="ModalHeader">
                    <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Autoriza Cotización de Requisición <strong>{{requisicion.NumReq}}</strong></h3>
                </div>
            </div>
            <div class="tw-mx-4">
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
            <div class="tw-my-2 tw-mx-4" v-if="PreciosRequisicion != null">
                <Table>
                    <template v-slot:TableHeader>
                        <th class="columna">COTIZACION</th>
                        <th class="columna">CANTIDAD</th>
                        <th class="columna">UNIDAD</th>
                        <th class="columna">DESCRIPCION</th>
                        <th class="columna">MARCA</th>
                        <th class="columna">PROVEEDOR</th>
                        <th class="columna">COMENTARIOS</th>
                        <th class="columna">PRECIO UNITARIO</th>
                        <th class="columna">MONEDA</th>
                        <th class="columna">CAMBIO</th>
                        <th class="columna">TOTAL</th>
                        <th class="columna">COMENTARIO</th>
                        <th class="columna">ARCHIVO</th>
                        <th class="columna">AUTORIZADO</th>
                        <th class="columna">ACCIONES</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila tw-bg-gray-200" v-for="datos in PreciosRequisicion" :key="datos.id">
                            <td class="tw-text-center">{{datos.NumCotizacion}}</td>
                            <td class="tw-text-center">{{datos.precios_articulo.Cantidad}}</td>
                            <td class="tw-text-center">{{datos.precios_articulo.Unidad}}</td>
                            <td class="tw-text-center">{{datos.precios_articulo.Descripcion}}</td>
                            <td class="tw-text-center">{{datos.Marca}}</td>
                            <td class="tw-text-center">{{datos.Proveedor}}</td>
                            <td class="tw-text-center">{{datos.Comentarios}}</td>
                            <td class="tw-text-center">{{datos.Precio}}</td>
                            <td class="tw-text-center">{{datos.Moneda}}</td>
                            <td class="tw-text-center">{{datos.TipoCambio}}</td>
                            <td class="tw-text-center">{{datos.Total}}</td>
                            <td>{{datos.MotivoCancelacion}}</td>
                            <td class="tw-flex tw-justify-center">
                                <div class="columnaIconos">
                                    <a target="_blank" :href="path + datos.Archivo" style="color:black;">
                                        <i class="far fa-file-image"></i>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <div class="columnaIconos" v-if="datos.Autorizado == 1">
                                    <span tooltip="Precio no Autorizado" flow="left">
                                        <span class="tw-inline-flex tw-text-xxs tw-items-center tw-justify-center tw-text-white tw-bg-red-400 tw-rounded-full">No Autorizado</span>
                                    </span>
                                </div>
                                <div class="columnaIconos" v-else-if="datos.Autorizado == 2">
                                    <span tooltip="Precio Autorizado" flow="left">
                                        <span class="tw-inline-flex tw-text-xxs tw-items-center tw-justify-center tw-text-white tw-bg-green-400 tw-rounded-full">Autorizado</span>
                                    </span>
                                </div>
                            </td>
                            <td class="tw-text-center">
                                <div class="columnaIconos" v-if="PreciosRequisicion[0].precios_articulo.MotivoCancelacion == null">
                                    <div class="iconoEdit">
                                        <span tooltip="Autorizar" flow="left" @click="AgregaComentarioAutorizacion(datos)">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="iconoEdit">
                                        <span tooltip="Rechazar Partida" flow="left" @click="AgregaComentarioRechazo(datos)">
                                                <i class="fas fa-times"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="columnaIconos" v-else>
                                    <div class="iconoEdit">
                                        <span tooltip="Autorizar" flow="left" @click="AutorizaPartida(datos)">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="iconoEdit">
                                        <span tooltip="Rechazar Partida" flow="left" @click="RechazaPartida(datos)">
                                                <i class="fas fa-times"></i>
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>
                </Table>
            </div>
        </div>

        <div class="ModalFooter">
            <jet-button type="button" @click="AutorizaCotizacion(form)" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Autoriza 1° Cotizacion</jet-button>
            <jet-button type="button" @click="AutorizaCotizacion2(form)" v-if="NumCot > 0" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Autoriza 2° Cotizacion</jet-button>
            <jet-CancelButton @click="chagePreciosRequisicion">Cerrar</jet-CancelButton>
        </div>
    </modal>

    <modal :show="showModal" @close="chageClose" :maxWidth="tam">
        <form>
            <div class="tw-px-4 tw-py-4">
                <div class="tw-text-lg">
                    <div class="ModalHeader">
                        <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Autoriza Cotización</h3>
                    </div>
                </div>

                <div class="tw-mt-4">
                    <Table>
                        <template v-slot:TableHeader>
                            <th class="columna">CANTIDAD</th>
                            <th class="columna">UNIDAD</th>
                            <th class="columna">DESCRIPCIÓN</th>
                            <th class="columna">PRECIO UNITARIO</th>
                            <th class="columna">MONEDA</th>
                            <th class="columna">TIPO CAMBIO</th>
                            <th class="columna">TOTAL</th>
                            <th class="columna">MARCA</th>
                            <th class="columna">PROVEEDOR</th>
                            <th class="columna">COMENTARIOS</th>
                            <th class="columna">ESTATUS</th>
                            <th class="columna">ACCIONES</th>
                        </template>
                        <template v-slot:TableFooter>
                            <tr class="fila" v-for="datos in PreciosCotizacion" :key="datos">
                                <td class="tw-p-2">{{ datos.precios_articulo.Cantidad }}</td>
                                <td class="tw-p-2">{{ datos.precios_articulo.Unidad }}</td>
                                <td class="tw-p-2">{{ datos.precios_articulo.Descripcion }}</td>
                                <td class="tw-p-2">${{ datos.Precio }}</td>
                                <td class="tw-p-2">{{ datos.Moneda }}</td>
                                <td class="tw-p-2">${{  datos.TipoCambio  }}</td>
                                <td class="tw-p-2">${{ datos.Total }}</td>
                                <td class="tw-p-2">{{ datos.Marca }}</td>
                                <td class="tw-p-2">{{ datos.Proveedor }}</td>
                                <td class="tw-p-2">{{ datos.Comentarios }}</td>
                                <td class="fila">
                                    <div class="columnaIconos" v-if="datos.Autorizado == 0">
                                        <div class="iconoCyan" @click="Autoriza(datos)">
                                            <span tooltip="Autoriza" flow="left">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="iconoCyan" @click="ModalRechaza(datos)">
                                            <span tooltip="Cancela Cotizacion" flow="left">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="columnaIconos" v-else-if="datos.Autorizado == 1">
                                        <span tooltip="Precio no Autorizado" flow="left">
                                            <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-red-400 tw-rounded-full">No Autorizado</span>
                                        </span>
                                    </div>
                                    <div class="columnaIconos" v-else-if="datos.Autorizado == 2">
                                        <span tooltip="Precio Autorizado" flow="left">
                                            <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-green-400 tw-rounded-full">Autorizado</span>
                                        </span>
                                    </div>
                                </td>
                                <td class="fila">
                                    <div class="columnaIconos">
                                        <div class="iconoCyan">
                                            <span tooltip="Visualiza Archivo Adjunto" flow="left">
                                                <a target="_blank" :href="path + datos.Archivo" style="color:black;">
                                                    <i class="far fa-file-image"></i>
                                                </a>
                                            </span>
                                        </div>
                                        <div class="iconoCyan" @click="HabilitaResguardo(datos, 0)">
                                            <span tooltip="Habilita Resguardo" flow="left">
                                                <i class="fas fa-user-shield"></i>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </Table>
                </div>
            </div>

            <div class="ModalFooter">
                <jet-CancelButton @click="chageClose">Cerrar</jet-CancelButton>
            </div>
        </form>
    </modal>

    <modal :show="showComentarios" @close="chageCloseComentarios" maxWidth="3xl">
        <div class="tw-px-4 tw-py-4">
            <div class="tw-text-lg">
                <div class="ModalHeader">
                    <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Agrega Comentarios</h3>
                </div>
            </div>

            <div class="tw-mt-4">
                <div class="ModalForm">
                    <div class="tw-mb-6 md:tw-flex">
                        <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                            <jet-label><span class="required">*</span>Comentarios de Requisicion</jet-label>
                            <textarea name="" id="" cols="4" v-model="form.Comentario" @input="(val) => (form.Comentario = form.Comentario.toUpperCase())" class="tw-bg-gray-200 tw-text-gray-500 tw-font-semibold focus:tw-outline-none focus:tw-shadow-outline tw-border tw-border-gray-300 tw-rounded-lg tw-py-2 tw-px-4 tw-block tw-w-full tw-appearance-none tw-shadow-sm"></textarea>
                            <small v-if="errors.Comentario" class="validation-alert">{{errors.Comentario}}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ModalFooter">
            <jet-button type="button" @click="AutorizaPartidaComentario(form)" v-if="form.TipoComentario == 1">Guardar</jet-button>
            <jet-button type="button" @click="RechazaPartidaComentario(form)" v-else-if="form.TipoComentario == 2">Rechazar</jet-button>
            <jet-CancelButton @click="chageCloseComentarios">Cerrar</jet-CancelButton>
        </div>
    </modal>

    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Welcome from "@/Jetstream/Welcome";
import Header from "@/Components/Header";
import Accions from "@/Components/Accions";
import Table from "@/Components/TableSky";
import JetButton from "@/Components/Button";
import JetCancelButton from "@/Components/CancelButton";
import Modal from "@/Jetstream/Modal";
import Pagination from "@/Components/pagination";
import JetInput from "@/Components/Input";
import JetLabel from '@/Jetstream/Label';
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
import { Inertia } from '@inertiajs/inertia';

export default {
    data() {
        return {
            showPartidas: false,
            showDetalle: false,
            showComentarios: false,
            showPreciosRequisicion: false,
            min: moment().format("YYYY-MM-DD"),
            now: moment().format("YYYY-MM-DD"),
            tam: "7xl",
            color: "tw-bg-sky-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            detalles: null,
            requisicion: [],
            RechazaArticulo: 0,
            Visualizacion: 'PARTIDAS',
            Cambio: false,
            form: {
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
                action: '',
                requisicion_id: '',
                articulo_id: '',
                precio_id: '',
                Comentario: '',
                rechazo: '',
                TipoComentario: 1,
                NumCotizacion: '',
            },
            Cotizacion:{
                Cot: null,
            },
            PreciosArt: {
            },
            params:{
                Year: moment().format("YYYY"),
                Month: this.mes,
                Status: 0,
                View: 1,
                Req: '',
                Art: '',
                NumCot: 0,
                Partidas: true,
                Proveedor: '',
                MesLetra: '',
                Cot: '',
                Req: '',
                Art: '',
            },
        };
    },

    mounted() {
        this.tabla();
        this.MesALetra();
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
        Modal,
        Pagination,
        JetInput,
        JetLabel,
        JetSelect,
    },

    props: {
        Session: Object,
        errors: Object,
        PerfilesUsuarios: Object,
        Requisiciones: Object, //Visualizacion de Requisiciones
        PreciosRequisicion: Object, //Precios asignados a una requisicion
        ArticulosRequisiciones: Object,
        PreciosRequisicion: Object,
        ArticulosPrecios: Object,
        Req: Object,
        Proveedores: Object,
        Cotizacion: Number,
        Pendientes: Number,
        Confirmar: Number,
        PendientesMes: Number,
        ICotizacionMes: Number,
        NumCot: Number,
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

        //datatable
        tabla() {
            this.$nextTick(() => {
                $("#Requisiciones").DataTable({
                    "language": this.español,
                    pageLength : 20,
                    "order": [10, 'asc'],
                    scrollY: '40vh',
                    scrollCollapse: true,
                    paging: true,
                    "columnDefs": [
                        { "width": "3%", "targets": [0] },
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
                this.$inertia.get("/Supply/AutorizaRequisiciones", { busca: event.target.value },{ onSuccess: () => { this.tabla(); },});
        },

        Filtros(){
            $('#Requisiciones').DataTable().clear();
            $('#Requisiciones').DataTable().destroy();
            this.$inertia.get('/Supply/AutorizaRequisiciones', this.params , { //envio de variables por url
                onSuccess: () => {
                    location.reload();
                }, preserveState: true})
        },

        FiltroIndicadores(value){
            $('#Requisiciones').DataTable().clear();
            $('#Requisiciones').DataTable().destroy();

            this.params.Status = 5;
            this.params.Month = 0;
            this.params.Year = 0;

            this.$inertia.get('/Supply/AutorizaRequisiciones', this.params , { //envio de variables por url
                onSuccess: () => {
                    location.reload();
                }, preserveState: true})
        },

        FiltroIndicadorMensual(value){
            this.params.Status = 5;

            $('#Requisiciones').DataTable().clear();
            $('#Requisiciones').DataTable().destroy();

            this.$inertia.get('/Supply/AutorizaRequisiciones', this.params , { //envio de variables por url
                onSuccess: () => {
                    location.reload();
                }, preserveState: true})
        },

        Visualizacion(){ //Cambio de visualizacion por partidas o articulos
            this.params.Partidas  = !this.params.Partidas;

            if (this.params.Partidas == true){
                $('#Articulos').DataTable().clear(); //limpio
                $('#Articulos').DataTable().destroy(); //destruyo tabla
                this.$inertia.get('/Supply/AutorizaRequisiciones', this.params , { //envio de variables por url
                    onSuccess: () => {
                        this.tablaArticulos()
                    }, preserveState: true})
            }else{
                $('#Requisiciones').DataTable().clear(); //limpio
                $('#Requisiciones').DataTable().destroy(); //destruyo tabla
                this.$inertia.get('/Supply/AutorizaRequisiciones', this.params , { //envio de variables por url
                    onSuccess: () => {
                        this.tabla() //regeneracion de tabla
                    }, preserveState: true})
            }
        },

        reset() {
            this.form = {
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
                IdArt: '',
                requisicion_id: '',
                NumReq:  '',
                Folio: '',
                Area: '',
                Observacioens: '',
                Cantidad: '',
                Unidad: '',
                Descripcion: '',
                Comentarios: '',
                MotivoCancelacion: '',
                ComentarioRechazo: '',
                rechazo: '',
                articulo_id: '',

                Precios: [{
                Precio: '',
                Total: '',
                Marca: '',
                Proveedor: '',
                archivo: '',
                }],
            };
        },

        show(id){
            this.detalles = id;
        },

        hidden(id){
            this.detalles = null;
        },

        chageClose() {
            this.showModal = !this.showModal;
        },

        chageCloseComentarios() {
            this.showComentarios = !this.showComentarios;
        },

        MesALetra(){
            switch (this.params.month) {
                case '1':
                    this.params.MesLetra = 'Enero';
                    break;
                case '2':
                    this.params.MesLetra = 'Febrero';
                    break;
                case '3':
                    this.params.MesLetra = 'Marzo';
                    break;
                case '4':
                    this.params.MesLetra = 'Abril';
                    break;
                case '5':
                    this.params.MesLetra = 'Mayo';
                    break;
                case '6':
                    this.params.MesLetra = 'Junio';
                    break;
                case '7':
                    this.params.MesLetra = 'Julio';
                    break;
                case '8':
                    this.params.MesLetra = 'Agosto';
                    break;
                case '9':
                    this.params.MesLetra = 'Septiembre';
                    break;
                case '10':
                    this.params.MesLetra = 'Octubre';
                    break;
                case '11':
                    this.params.MesLetra = 'Noviembre';
                    break;
                case '12':
                    this.params.MesLetra = 'Diciembre';
                    break;
            }
        },

        FiltroPorMes(value){
            $('#Requisiciones').DataTable().clear(); //limpio
            $('#Requisiciones').DataTable().destroy(); //destruyo tabla
            this.params.month = value;
            switch (this.params.month) {
                case 1:
                    this.params.MesLetra = 'Enero';
                    break;
                case 2:
                    this.params.MesLetra = 'Febrero';
                    break;
                case 3:
                    this.params.MesLetra = 'Marzo';
                    break;
                case 4:
                    this.params.MesLetra = 'Abril';
                    break;
                case 5:
                    this.params.MesLetra = 'Mayo';
                    break;
                case 6:
                    this.params.MesLetra = 'Junio';
                    break;
                case 7:
                    this.params.MesLetra = 'Julio';
                    break;
                case 8:
                    this.params.MesLetra = 'Agosto';
                    break;
                case 9:
                    this.params.MesLetra = 'Septiembre';
                    break;
                case 10:
                    this.params.MesLetra = 'Octubre';
                    break;
                case 11:
                    this.params.MesLetra = 'Noviembre';
                    break;
                case 12:
                    this.params.MesLetra = 'Diciembre';
                    break;
            }
            this.$inertia.get('/Supply/AutorizaRequisiciones', this.params , { //envio de variables por url
            onSuccess: () => {
                this.tabla() //regeneracion de tabla
            }, preserveState: true})
        },

        Precios(data){
            this.params.Cot = data.id;
            var query  = window.location.search.substring(1);
            var vars = query.split("&");
                for (var i=0; i < vars.length; i++) {
                    var pair = vars[i].split("=");
                    if(pair[0] == 'Estatus') {
                        this.params.Estatus = pair[1];
                    }
            }
            this.$inertia.get('/Supply/AutorizaRequisiciones', this.params , { //envio de variables por url
                onSuccess: () => {
                    this.chageClose();
            }, preserveState: true })
        },

        Autoriza(data){
            data._method = "PUT";
            this.$inertia.post("/Supply/AutorizaRequisiciones/" + data.id, data, {
                onSuccess: () => {
                    this.alertSucces();
                },
            });
        },

        ModalRechaza(data){
            this.Rechazo.articulo_id = data.articulos_requisiciones_id;
            this.chageCloseRechazo();
        },

        Rechaza(data, rechazo){
            this.Rechazo.rechazo = 10;
            data = this.Rechazo;
            Swal.fire({
            title: '¿Estas seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí Cancelar',
            cancelButtonText: 'No, Cancelar!',
            }).then((result) => {
            if (result.isConfirmed) {
                data._method = "PUT";
                console.log(data)
                this.$inertia.post("/Supply/AutorizaRequisiciones/" + data.id, data, {
                    onSuccess: () => {
                        Swal.fire(
                        'COTIZACION CANCELADA',
                        'Cotización cancelada con exito',
                        'success'
                        )
                    this.chageCloseRechazo();
                    },
                });
            }
            })
        },

        HabilitaResguardo(data, resguardo){
            data.resguardo = 0;
            data._method = "PUT";
            this.$inertia.post("/Supply/AutorizaRequisiciones/" + data.id, data, {
                onSuccess: () => {
                    this.chageClose();
                    this.alertSucces();
                },
            });
        },

        chagePreciosRequisicion(){
            this.showPreciosRequisicion = !this.showPreciosRequisicion;
        },

        chagePartidas() {
            this.showPartidas = !this.showPartidas;
        },

        Partidas(data){
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
            this.chagePartidas();
            this.$inertia.get('/Supply/AutorizaRequisiciones', this.params , { //envio de variables por url
                onSuccess: () => {
            }, preserveState: true })
        },

        VisualizaCotizacion(data){
            //Asgino los valores de la requisicion a un nuevo arreglo
            this.requisicion = data;
            //Envio el id de la requisicion para generar una nueva consulta
            this.params.Req = data.id;

            //OBTENER VALOR DE FILTRO DE LA URL (Mantengo el estatus del filtro)
            var query  = window.location.search.substring(1);
            var vars = query.split("&");
                for (var i=0; i < vars.length; i++) {
                    var pair = vars[i].split("=");
                    if(pair[0] == 'Status') {
                        this.params.Status = pair[1];
                    }
            }

            this.form.requisicion_id = data.id;
                this.$inertia.get('/Supply/AutorizaRequisiciones', this.params , { //envio de variables por url
                onSuccess: () => {
                    this.chagePreciosRequisicion();
            }, preserveState: true })
        },

        AutorizaCotizacion(data){ //Autoriza cotizacion completa
            data._method = "PUT";
            this.form.action = 1;
            this.$inertia.post("/Supply/AutorizaRequisiciones/" + data.id, data, {
                onSuccess: () => {
                    this.chagePreciosRequisicion();
                    this.alertSucces();
                },
            });
        },

        AutorizaCotizacion2(data){ //Autoriza segunda cotizacion de Requisicion completa
            data._method = "PUT";
            this.form.action = 2;
            this.$inertia.post("/Supply/AutorizaRequisiciones/" + data.id, data, {
                onSuccess: () => {
                    this.chagePreciosRequisicion();
                    this.alertSucces();
                },
            });
        },

        AgregaComentario(data){
            this.chageCloseComentarios();
            this.form.articulo_id = data.id;
            this.form.TipoComentario = 2;
        },

        AgregaComentarioAutorizacion(data){
            console.log(data);
            this.form.precio_id = data.id;
            this.form.articulo_id = data.articulos_requisiciones_id;
            this.form.NumCotizacion = data.NumCotizacion;
            this.chageCloseComentarios();
            this.form.TipoComentario = 1;
        },

        AutorizaPartidaComentario(data){ //Envia partida a autorizacion
        this.form.TipoComentario = 1;
            data._method = "PUT";
            data.metodo = 1;
            this.$inertia.post("/Supply/AutorizaRequisiciones/" + data.id, data, {
                onSuccess: () => {
                    this.chageCloseComentarios();
                    this.alertSucces();
                    this.reset();
                },
            });
        },

        AgregaComentarioRechazo(data){
            this.Precio = data;
            this.form.precio_id = data.id;
            this.form.TipoComentario = 2;
            this.chageCloseComentarios();
        },

        RechazaPartidaComentario(data){ //Rechaza partida
            data._method = "PUT";
            data.metodo = 2;
            this.$inertia.post("/Supply/AutorizaRequisiciones/" + data.id, data, {
                onSuccess: () => {
                    this.chageCloseComentarios();
                    this.alertSucces();
                    this.reset();
                },
            });
        },

        AutorizaPartida(data){
            console.log('Autoriza sin comentario');
            this.form.precio_id = data.id;
            data._method = "PUT";
            data.metodo = 4;
            this.$inertia.post("/Supply/AutorizaRequisiciones/" + data.id, data, {
                onSuccess: () => {
                    this.alertSucces();
                    this.reset();
                },
            });
        },

        RechazaPartida(data){
            data._method = "PUT";
            data.metodo = 3;
            this.$inertia.post("/Supply/AutorizaRequisiciones/" + data.id, data, {
                onSuccess: () => {
                    this.alertSucces();
                    this.reset();
                },
            });
        },

    },
};
</script>
