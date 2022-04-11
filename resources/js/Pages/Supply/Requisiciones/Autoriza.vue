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

        <div class="tw-mx-4">
            <p class="tw-text-center tw-text-coolGray-400">VISUALIZACIÓN POR {{Visualizacion}}</p>
            <div v-if="Vista == 1">
                <Table id="Requisiciones">
                    <template v-slot:TableHeader>
                        <th class="columna">FECHA</th>
                        <th class="columna">FOLIO</th>
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
                            <td>R-{{ datos.articulos_requisicion.Folio }}</td>
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
                        <th class="columna">FOLIO</th>
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
                            <td>R-{{ datos.Folio }}</td>
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
                                    <div class="iconoCyan" @click="imprimir(datos)" v-if="datos.Estatus == 6">
                                        <span tooltip="Impresión de la requisición" flow="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
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
                        <th class="columna">NOTA</th>
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
                            <td class="tw-text-center">{{datos.precio_proveedor.Nombre}}</td>
                            <td class="tw-text-center">{{datos.Comentarios}}</td>
                            <td class="tw-text-center">{{datos.Precio}}</td>
                            <td class="tw-text-center">{{datos.Moneda}}</td>
                            <td class="tw-text-center">{{datos.TipoCambio}}</td>
                            <td class="tw-text-center">{{datos.Total}}</td>
                            <td>{{datos.precios_articulo.MotivoCancelacion}}</td>
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
            <!-- <jet-button type="button" @click="Correo(form)" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Envia Correo</jet-button> -->
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
                Partidas: true,
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
            console.log('VisualizaCotizacion');
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
            console.log(data);
            data._method = "PUT";
            data.metodo = 3;
            this.$inertia.post("/Supply/AutorizaRequisiciones/" + data.id, data, {
                onSuccess: () => {
                    this.alertSucces();
                    this.reset();
                },
            });
        },

        Correo(data){
            data._method = "PUT";
            data.metodo = 5;
            this.$inertia.post("/Supply/AutorizaRequisiciones/" + data.id, data, {
                onSuccess: () => {
                    this.alertSucces();
                },
            });
        },

        imprimir(data){
            //Asgino los valores de la requisicion a un nuevo arreglo
            this.requisicion = data;
            //Envio el id de la requisicion para generar una nueva consulta
            this.params.Req = data.id;
            var TotalRequisicion = 0;
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
                    console.log(this.PreciosRequisicion);
            }, preserveState: true })

            var canvas = window.open('', 'PRINT');
            canvas.document.write('<html><head><title>' + document.title + '</title>');
            canvas.document.write('<link rel="stylesheet" href="style.css" media="print">'); //Aquí agregué la hoja de estilos
            canvas.document.write('<style>');
            canvas.document.write('@media print { @page{margin: 0;} body{margin-left: 20px; margin-right: 20px; font-size: 10px; text-transform: uppercase;} }');
            canvas.document.write('</style>');
            canvas.document.write('</head><body>');

            canvas.document.write('<section style="margin: 15px; height: 100vh;">');

                canvas.document.write('<div style="height: 20vh; padding:5px; display:flex; flex-direction: column; justify-content: center; border-bottom: 2px solid;">');

                    canvas.document.write('<div style="display:flex; flex-direction: row; justify-content: center; gap:5px; margin-bottom: 5%;">');
                        canvas.document.write('<img width="260" height="55" style="margin-right: 100px; margin-left: 30px; margin-botton: 5px; margin-top: 0px; padding-top: 0px;" a src="data:image/png;base64,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">');
                        canvas.document.write('<h2 style="font-family: Bradley Hand, cursive;">REQUISICIÓN: &nbsp;<strong style="font-size:1.35rem;">R-'+data.Folio+'</strong></h2>');
                    canvas.document.write('</div>');

                    canvas.document.write('<div style="display:flex; flex-direction: row; justify-content: center; gap:5px;">');
                        canvas.document.write('<div style="padding: 3px; width:15%;"><span> <strong>FECHA: &nbsp;</strong>'+data.Fecha+'</span> </div>');
                        canvas.document.write('<div style="padding: 3px; width:25%;"><span> <strong>CÓDIGO: &nbsp;</strong>'+data.Codigo+'</span> </div>');
                        canvas.document.write('<div style="padding: 3px; width:40%;"><span> <strong>SOLICITANTE: &nbsp;</strong>'+data.requisiciones_perfil.Nombre+' '+data.requisiciones_perfil.ApPat+' '+data.requisiciones_perfil.ApMat+'</span> </div>');
                        canvas.document.write('<div style="padding: 3px; width:20%;"><span> <strong>ESTATUS: &nbsp;</strong>SOLICITADA</span> </div>');
                    canvas.document.write('</div>');

                    canvas.document.write('<div style="display:flex; flex-direction: row; justify-content: center; gap:5px;">');
                        canvas.document.write('<div style="padding: 3px; width:40%;"><span> <strong>ÁREA COSTO: &nbsp;</strong>'+data.requisicion_departamento.Nombre+'</span> </div>');
                        canvas.document.write('<div style="padding: 3px; width:40%;"><span> <strong>SERVICIO: &nbsp;</strong>'+data.requisicion_maquina.Nombre+' '+data.requisicion_marca.Nombre+'</span> </div>');
                        canvas.document.write('<div style="padding: 3px; width:20%;"><span> <strong>TIPO: &nbsp;</strong>'+data.TipCompra+'</span> </div>');
                    canvas.document.write('</div>');

                    canvas.document.write('<div style="display:flex; flex-direction: row; justify-content: center; gap:5px;">');
                        canvas.document.write('<div style="padding: 3px; width:20%;"><span> <strong>ESTATUS: &nbsp;</strong>PROBADA</span> </div>');
                        canvas.document.write('<div style="padding: 3px; width:20%;"><span> <strong>ORDEN COMPRA: &nbsp;</strong>'+data.OrdenCompra+'</span> </div>');
                    canvas.document.write('</div>');
                canvas.document.write('</div>');

                canvas.document.write('<div style="height: 60vh; width: 100%;">');
                    canvas.document.write('<div style="width: 100%; display: table; border-collapse: collapse; text-align: center; margin: 0 auto;">');
                        canvas.document.write('<div style="display: table-row; background: #ddd;">');
                            canvas.document.write('<div style="display: table-cell; vertical-align: middle; padding: 10px;">CANTIDAD</div>');
                            canvas.document.write('<div style="display: table-cell; vertical-align: middle; padding: 10px;">UNIDAD</div>');
                            canvas.document.write('<div style="display: table-cell; vertical-align: middle; padding: 10px;">NÚM. PARTE</div>');
                            canvas.document.write('<div style="display: table-cell; vertical-align: middle; padding: 10px;">ARTICULO</div>');
                            canvas.document.write('<div style="display: table-cell; vertical-align: middle; padding: 10px;">MARCA</div>');
                            canvas.document.write('<div style="display: table-cell; vertical-align: middle; padding: 10px;">PROVEEDOR</div>');
                            canvas.document.write('<div style="display: table-cell; vertical-align: middle; padding: 10px;">PRECIO UNITARIO</div>');
                            canvas.document.write('<div style="display: table-cell; vertical-align: middle; padding: 10px;">MONETA</div>');
                            canvas.document.write('<div style="display: table-cell; vertical-align: middle; padding: 10px;">CAMBIO</div>');
                            canvas.document.write('<div style="display: table-cell; vertical-align: middle; padding: 10px;">TOTAL</div>');
                        canvas.document.write('</div>');

                        this.PreciosRequisicion.forEach(e => {
                            canvas.document.write('<div style="display: table-row;">');
                                canvas.document.write('<div style="display: table-cell; vertical-align: middle; padding: 10px;">'+e.precios_articulo.Cantidad+'</div>');
                                canvas.document.write('<div style="display: table-cell; vertical-align: middle; padding: 10px;">'+e.precios_articulo.Unidad+'</div>');
                                canvas.document.write('<div style="display: table-cell; vertical-align: middle; padding: 10px;">'+e.precios_articulo.NumParte+'</div>');
                                canvas.document.write('<div style="display: table-cell; vertical-align: middle; padding: 10px;">'+e.precios_articulo.Descripcion+'</div>');
                                canvas.document.write('<div style="display: table-cell; vertical-align: middle; padding: 10px;">'+e.Marca+'</div>');
                                canvas.document.write('<div style="display: table-cell; vertical-align: middle; padding: 10px;">'+e.precio_proveedor.Nombre+'</div>');
                                canvas.document.write('<div style="display: table-cell; vertical-align: middle; padding: 10px;">'+e.Precio+'</div>');
                                canvas.document.write('<div style="display: table-cell; vertical-align: middle; padding: 10px;">'+e.Moneda+'</div>');
                                canvas.document.write('<div style="display: table-cell; vertical-align: middle; padding: 10px;">'+e.TipoCambio+'</div>');
                                canvas.document.write('<div style="display: table-cell; vertical-align: middle; padding: 10px; text-align: left;">$'+e.Total+'</div>');
                            canvas.document.write('</div>');
                        });

                        this.PreciosRequisicion.forEach(function (pre) {
                            TotalRequisicion += Number(pre.Precio);
                        });

                        const currency = function(number){
                            return new Intl.NumberFormat('en-IN', {style: 'currency',currency: 'MXN', minimumFractionDigits: 2}).format(number);
                        };
                        var Total1 = currency(TotalRequisicion);
                        var Total = Total1.substr(2,);

                    canvas.document.write('</div>');
                canvas.document.write('</div>');

                canvas.document.write('<div style="height: 5vh;">');
                    canvas.document.write('<div style="width:100%;">');
                        canvas.document.write('<h1 style="text-align: right; font-family: Bradley Hand, cursive;"> PRECIO TOTAL: &nbsp;'+Total+'</h1>');
                    canvas.document.write('</div>');
                canvas.document.write('</div>');

                canvas.document.write('<div style="height: 10vh; margin-top: 10px; border-top: 3px solid;">');
                    canvas.document.write('<div style="padding: 5px; width:100%;">');
                        canvas.document.write('<span> <strong>OBSERVACIONES: &nbsp;</strong>'+data.Observaciones+'</span>');
                    canvas.document.write('</div>');
                canvas.document.write('</div>');

            canvas.document.write('</section>');

            canvas.document.write('</body></html>');
            canvas.document.close();
            canvas.focus();

            var beforePrint = function() {
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

            canvas.onload = function() {
                canvas.print();
                canvas.close();
                beforePrint();
            };
            return true;
        },

    },
};
</script>
