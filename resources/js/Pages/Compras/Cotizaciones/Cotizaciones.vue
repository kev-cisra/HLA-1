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
            <div class="tw-w-full tw-mx-auto tw-max-w-7xl sm:tw-px-8 lg:tw-px-10">
                <div class="tw-flex tw-flex-col tw-w-full tw-mb-2 tw-space-y-8 lg:tw-flex-row lg:tw-space-x-10 lg:tw-space-y-0 lg:tw-mb-4">

                    <div class="tw-w-full tw-cursor-pointer lg:tw-w-1/4" @click="FiltroIndicadores(8)">
                        <div class="tw-w-full tw-p-2 tw-bg-white tw-border-l-4 tw-border-green-600 tw-rounded-lg tw-widget">
                            <div class="tw-flex tw-items-center">
                                <div class="icon tw-w-10 tw-p-2 tw-bg-green-600 tw-text-white tw-rounded-full tw-mr-3">
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

                    <div class="tw-w-full tw-cursor-pointer lg:tw-w-1/4" @click="FiltroIndicadores(4)">
                        <div class="tw-w-full tw-p-2 tw-bg-white tw-border-l-4 tw-border-emerald-600 tw-rounded-lg tw-widget">
                            <div class="tw-flex tw-items-center">
                                <div class="icon tw-w-10 tw-p-2 tw-bg-emerald-600 tw-text-white tw-rounded-full tw-mr-3">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div class="tw-flex tw-flex-col tw-justify-center">
                                    <div class="tw-text-lg"> {{ SinConfirmar }} </div>
                                    <div class="tw-text-xs tw-text-gray-400">Pendientes por enviar a Autorizar</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tw-w-full tw-cursor-pointer lg:tw-w-1/4" @click="FiltroIndicadores(6)">
                        <div class="tw-w-full tw-p-2 tw-bg-white tw-border-l-4 tw-border-cyan-600 tw-rounded-lg tw-widget">
                            <div class="tw-flex tw-items-center">
                                <div class="icon tw-w-10 tw-p-2 tw-bg-cyan-600 tw-text-white tw-rounded-full tw-mr-3">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div class="tw-flex tw-flex-col tw-justify-center">
                                    <div class="tw-text-lg"> {{ Confirmar }} </div>
                                    <div class="tw-text-xs tw-text-gray-400">Pendientes por agregar Fecha</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tw-overflow-auto md:tw-flex md:tw-justify-center tw-mb-2">
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
                <select class="InputSelect" v-model="params.Estatus">
                        <option value="3">SIN COTIZACION</option>
                        <option value="4">SIN ENVIAR</option>
                        <option value="5">EN AUTORIZACION</option>
                        <option value="6">AUTORIZADO</option>
                        <option value="7">CONFIRMADOS</option>
                        <option value="8">EN ALMACEN</option>
                        <option value="9">ENTREGADO</option>
                </select>
            </div>
        </div>

        <div class="tw-overflow-x-auto tw-mx-2">
            <div class="tw-overflow-x-auto tw-mx-2">
                <Table id="Requisiciones">
                    <template v-slot:TableHeader>
                        <th class="columna">NUM</th>
                        <th class="columna">FECHA</th>
                        <th class="columna">DEPARTAMENTO</th>
                        <th class="columna">JEFE AREA</th>
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
                            <td class="tw-text-center">{{ datos.NumReq }}</td>
                            <td class="tw-text-center">{{ datos.Fecha }}</td>
                            <td class="tw-text-center">{{ datos.requisicion_departamento.Nombre }}</td>
                            <td class="tw-text-center">{{ datos.requisicion_jefe.Nombre }}</td>
                            <td class="tw-text-center">{{ datos.Codigo }}</td>
                            <td class="tw-text-center">{{ datos.requisicion_maquina.Nombre }}</td>
                            <td class="tw-text-center">{{ datos.requisicion_marca.Nombre }}</td>
                            <td class="tw-text-center">{{ datos.TipCompra }}</td>
                            <td>{{ datos.Observaciones }}</td>
                            <td class="tw-text-center">{{ datos.requisiciones_perfil.Nombre }} {{ datos.requisiciones_perfil.ApPat }}</td>
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
                                <div class="columnaIconos" v-if="datos.Estatus == 3">
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
                                <div class="columnaIconos" v-if="datos.Estatus == 4">
                                    <div class="iconoDetails" @click="Partidas(datos)">
                                        <span tooltip="Visualiza Partidas" flow="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="iconoEdit" @click="ConfirmaRequisicionCotizada(datos, 5)">
                                        <span tooltip="Enviar Cotizacion para Autorización" flow="left">
                                            <i class="fas fa-check-circle"></i>
                                        </span>
                                    </div>
                                    <div class="iconoPurple" @click="CotizarReq(datos, 4)">
                                        <span tooltip="Realizar Otra Cotizacion" flow="left">
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
                    <th class="columna">ESTATUS</th>
                    <th class="columna">ACCIONES</th>
                </template>

                <template v-slot:TableFooter>
                    <tr class="fila" v-for="art in ArticulosRequisiciones" :key="art.id">
                        <td class="tw-text-center">{{ art.Cantidad }}</td>
                        <td class="tw-text-center">{{ art.Unidad }}</td>
                        <td class="tw-text-center">{{ art.Descripcion }}</td>
                        <td class="tw-text-center">{{ art.NumParte }}</td>
                        <td class="tw-text-center">{{ art.RecibidoPor }}</td>
                        <td class="tw-text-center">{{ art.EstatusArt }}</td>
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

    <modal :show="showModal" @close="chageClose" :maxWidth="tam">

        <form>
            <div class="tw-px-4 tw-py-4">
                <div class="tw-text-lg">
                    <div class="ModalHeader">
                        <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Realiza Cotización # {{form.NumReq}}</h3>
                    </div>
                </div>

                <div class="tw-mt-4">
                    <div class="ModalForm">
                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-1/ md:tw-mb-0">
                                <jet-label><span class="required">*</span>PRECIO UNITARIO</jet-label>
                                <jet-input type="text" v-model="form.Precio" @change="ConversionMoneda($event)"></jet-input>
                                <small v-if="errors.Precio" class="validation-alert">{{errors.Precio}}</small>
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
                                <jet-label>ARCHIVO</jet-label>
                                <label class="tw-flex tw-justify-center tw-gap-4 tw-w-52 tw-h-11 tw-w-full tw-p-2 tw-font-bold tw-tracking-wide tw-text-center tw-text-blueGray-600 tw-uppercase tw-bg-gray-200 tw-border tw-rounded-lg tw-cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="tw-w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    <span class="tw-mt-2 tw-text-xxs" v-if="form.archivo == null">Selecciona un Archivo</span>
                                    <span class="tw-mt-2 tw-text-xxs tw-text-teal-500 tw-font-bold" v-if="form.archivo != null">{{  form.archivo.name }}</span>
                                    <input type='file' class="tw-hidden" @input="form.archivo = $event.target.files[0]"/>
                                </label>
                                <span v-if="form.ImagenServidor != null">{{form.archivo}}</span>
                                <small v-if="errors.archivo" class="validation-alert">{{errors.archivo}}</small>
                            </div>
                        </div>

                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                                <jet-label><span class="required">*</span>COMENTARIOS</jet-label>
                                <textarea name="" id="" cols="2" v-model="form.Comentarios" @input="(val) => (form.Comentarios = form.Comentarios.toUpperCase())" class="tw-bg-gray-200 tw-text-gray-500 tw-font-semibold focus:tw-outline-none focus:tw-shadow-outline tw-border tw-border-gray-300 tw-rounded-lg tw-py-2 tw-px-4 tw-block tw-w-full tw-appearance-none tw-shadow-sm"></textarea>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="ModalFooter">
                <jet-button type="button" @click="RealizaCotizacion(form)" v-show="!editMode" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Guardar</jet-button>
                <jet-button type="button" @click="update(form)" v-show="editMode" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Actualizar</jet-button>
                <jet-CancelButton @click="chageClose">Cerrar</jet-CancelButton>
            </div>
        </form>
    </modal>

    <modal :show="showDetalle" @close="chageDetalle" :maxWidth="tam">

        <form>
            <div class="tw-px-4 tw-py-4">
                <div class="tw-text-lg">
                    <div class="ModalHeader">
                        <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Detalle de Cotización</h3>
                    </div>
                </div>
                <div class="">
                    <div class="tw-flex tw-flex-col tw-flex-1 tw-h-full tw-w-full sm:tw-px-0">
                        <div class="tw-flex tw-rounded-lg tw-shadow-lg tw-w-full tw-bg-white sm:tw-mx-0">
                            <div class="tw-flex tw-flex-col tw-w-full md:tw-w-1/2 tw-p-4">
                                <div class="tw-flex tw-flex-col tw-flex-1 tw-justify-center tw-mb-8">
                                    <div class="tw-flex tw-flex-col tw-mt-4">
                                        <div class="tw-flex tw-flex-col tw-mt-4">
                                            <div class="tw-relative tw-p-1 tw-transition-all tw-duration-500 tw-border tw-rounded">
                                                <div class="tw-absolute tw-px-1 tw--mt-4 tw-text-xs tw-tracking-wider tw-uppercase">
                                                    <p><label for="name" class="tw-px-1 tw-text-gray-600 tw-bg-white">Número de Requisición</label></p>
                                                </div>
                                                    <p><input id="name" autocomplete="false" type="text" class="InfoRow" v-model="form.NumReq"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tw-w-full tw-mt-4 tw-flex tw-gap-2">
                                            <div class="tw-relative tw-p-1 tw-transition-all tw-duration-500 tw-border tw-rounded">
                                                <div class="tw-absolute tw-px-1 tw--mt-4 tw-text-xs tw-tracking-wider tw-uppercase">
                                                    <p><label for="name" class="tw-px-1 tw-text-gray-600 tw-bg-white">Cantidad</label></p>
                                                </div>
                                                    <p><input id="name" autocomplete="false" type="text" class="InfoRow" v-model="form.Cantidad"></p>
                                            </div>
                                            <div class="tw-relative tw-p-1 tw-transition-all tw-duration-500 tw-border tw-rounded">
                                                <div class="tw-absolute tw-px-1 tw--mt-4 tw-text-xs tw-tracking-wider tw-uppercase">
                                                    <p><label for="name" class="tw-px-1 tw-text-gray-600 tw-bg-white">Unidad</label></p>
                                                </div>
                                                    <p><input id="name" autocomplete="false" type="text" class="InfoRow" v-model="form.Unidad"></p>
                                            </div>
                                            <div class="tw-relative tw-p-1 tw-transition-all tw-duration-500 tw-border tw-rounded">
                                                <div class="tw-absolute tw-px-1 tw--mt-4 tw-text-xs tw-tracking-wider tw-uppercase">
                                                    <p><label for="name" class="tw-px-1 tw-text-gray-600 tw-bg-white">Descripción</label></p>
                                                </div>
                                                    <p><input id="name" autocomplete="false" type="text" class="InfoRow" v-model="form.Descripcion"></p>
                                            </div>
                                    </div>

                                    <div class="tw-w-full tw-mt-4 tw-flex tw-gap-2">
                                        <div class="tw-relative tw-p-1 tw-transition-all tw-duration-500 tw-border tw-rounded">
                                            <div class="tw-absolute tw-px-1 tw--mt-4 tw-text-xs tw-tracking-wider tw-uppercase">
                                                <p><label for="name" class="tw-px-1 tw-text-gray-600 tw-bg-white">Precio</label></p>
                                            </div>
                                                <p><input id="name" autocomplete="false" type="text" class="InfoRow" v-model="form.Precio"></p>
                                        </div>
                                        <div class="tw-relative tw-p-1 tw-transition-all tw-duration-500 tw-border tw-rounded">
                                            <div class="tw-absolute tw-px-1 tw--mt-4 tw-text-xs tw-tracking-wider tw-uppercase">
                                                <p><label for="name" class="tw-px-1 tw-text-gray-600 tw-bg-white">Total</label></p>
                                            </div>
                                                <p><input id="name" autocomplete="false" type="text" class="InfoRow" v-model="form.Total"></p>
                                        </div>
                                    </div>

                                    <div class="tw-w-full tw-mt-4 tw-flex tw-gap-2">
                                        <div class="tw-relative tw-p-1 tw-transition-all tw-duration-500 tw-border tw-rounded">
                                            <div class="tw-absolute tw-px-1 tw--mt-4 tw-text-xs tw-tracking-wider tw-uppercase">
                                                <p><label for="name" class="tw-px-1 tw-text-gray-600 tw-bg-white">Marca</label></p>
                                            </div>
                                                <p><input id="name" autocomplete="false" type="text" class="InfoRow" v-model="form.Marca"></p>
                                        </div>
                                        <div class="tw-relative tw-p-1 tw-transition-all tw-duration-500 tw-border tw-rounded">
                                            <div class="tw-absolute tw-px-1 tw--mt-4 tw-text-xs tw-tracking-wider tw-uppercase">
                                                <p><label for="name" class="tw-px-1 tw-text-gray-600 tw-bg-white">Proveedor</label></p>
                                            </div>
                                                <p><input id="name" autocomplete="false" type="text" class="InfoRow" v-model="form.Proveedor"></p>
                                        </div>
                                    </div>

                                    <div class="tw-flex tw-flex-col tw-mt-4">
                                        <div class="tw-flex tw-flex-col tw-mt-4">
                                            <div class="tw-relative tw-p-1 tw-transition-all tw-duration-500 tw-border tw-rounded">
                                                <div class="tw-absolute tw-px-1 tw--mt-4 tw-text-xs tw-tracking-wider tw-uppercase">
                                                    <p><label for="name" class="tw-px-1 tw-text-gray-600 tw-bg-white">Comentarios</label></p>
                                                </div>
                                                    <p><input id="name" autocomplete="false" type="text" class="InfoRow" v-model="form.Comentarios"></p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="tw-hidden md:tw-block md:tw-w-1/2 tw-p-2 tw-mt-2">
                                <p>{{ path + form.archivo }}</p>
                                <iframe :src="path + form.archivo" style="width: 100%; height: 350px; border: none;">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </modal>

    <modal :show="showPrecios" @close="chagePrecios" :maxWidth="tam">
        <form>
            <div class="tw-px-4 tw-py-4">
                <div class="tw-text-lg">
                    <div class="ModalHeader">
                        <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Precio Autorizado</h3>
                    </div>
                </div>

                <div class="tw-mt-4">
                    <Table>
                        <template v-slot:TableHeader>
                            <th class="columna">CANTIDAD</th>
                            <th class="columna">UNIDAD</th>
                            <th class="columna">DESCRIPCIÓN</th>
                            <th class="columna">PRECIO UNITARIO</th>
                            <th class="columna">TOTAL</th>
                            <th class="columna">MARCA</th>
                            <th class="columna">COMENTARIOS</th>
                            <th class="columna">ESTATUS</th>
                            <th class="columna">ACCIONES</th>
                        </template>
                        <template v-slot:TableFooter>
                            <tr class="fila" v-for="datos in PreciosCotizacion" :key="datos">
                                <td class="tw-p-2">{{ datos.precios_articulo.Cantidad }}</td>
                                <td class="tw-p-2">{{ datos.precios_articulo.Unidad }}</td>
                                <td class="tw-p-2">{{ datos.precios_articulo.Descripcion }}</td>
                                <td class="tw-p-2">{{ datos.Precio }}</td>
                                <td class="tw-p-2">{{ datos.Total }}</td>
                                <td class="tw-p-2">{{ datos.Autorizado }}</td>
                                <td class="tw-p-2">{{ datos.Autorizado }}</td>
                                <td class="fila">
                                    <div class="columnaIconos" v-if="datos.Autorizado == 0">
                                        <div class="iconoCyan" @click="Autoriza(datos)">
                                            <span tooltip="Autoriza" flow="left">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
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
                                        <div class="iconoCyan" @click="HabilitaResguardo(datos)">
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
                <jet-CancelButton @click="chagePrecios">Cerrar</jet-CancelButton>
            </div>
        </form>
    </modal>

    <modal :show="showFecha" @close="chageFecha" :maxWidth="tam2">
        <form>
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
                <jet-button type="button" @click="Confirma(form, metodo)">Guardar</jet-button>
                <jet-CancelButton @click="chageFecha">Cerrar</jet-CancelButton>
            </div>
        </form>
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
                        <TableSky>
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
                                        <input type="number" v-model="match.PrecioUnitario" @change="ConversionMoneda($event)" class="tw-bg-gray-200 tw-text-gray-500 tw-font-semibold focus:tw-outline-none focus:tw-shadow-outline tw-border tw-border-gray-300 tw-rounded-lg tw-block tw-w-1/2 tw-appearance-none tw-shadow-sm">
                                    </td>
                                </tr>
                            </template>
                        </TableSky>
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
            <jet-button type="button" @click="RealizaCotizacion(form)" v-show="!editMode" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Guardar</jet-button>
            <!-- <jet-button type="button" @click="update(form)" v-show="editMode" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Actualizar</jet-button> -->
            <jet-CancelButton @click="chageCotizar">Cerrar</jet-CancelButton>
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
                    <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                        <h3 class="tw-text-center tw-font-extrabold">Articulos</h3>
                        <TableSky>
                            <template v-slot:TableHeader>
                                <th>CANTIDAD</th>
                                <th>UNIDAD</th>
                                <th>DESCRIPCION</th>
                                <th>PRECIO UNITARIO</th>
                            </template>

                            <template v-slot:TableFooter>
                                <tr v-for="match in Pre" :key="match">
                                    <td class="tw-text-center">{{ match.Cantidad }}</td>
                                    <td class="tw-text-center">{{ match.Unidad }}</td>
                                    <td>{{ match.Descripcion }}</td>
                                    <td><input type="text" v-model="form.Precio"></td>
                                </tr>
                            </template>
                        </TableSky>
                        <div v-if="PreCount > 1">
                            <TableSky>
                                <template v-slot:TableHeader>
                                    <th>CANTIDAD</th>
                                    <th>UNIDAD</th>
                                    <th>DESCRIPCION</th>
                                    <th>PRECIO UNITARIO</th>
                                </template>

                                <template v-slot:TableFooter>
                                    <tr v-for="match in Pre" :key="match">
                                        <td class="tw-text-center">{{ match.Cantidad }}</td>
                                        <td class="tw-text-center">{{ match.Unidad }}</td>
                                        <td>{{ match.Descripcion }}</td>
                                        <td><input type="text" v-model="form.Precio2"></td>
                                    </tr>
                                </template>
                            </TableSky>
                        </div>
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
            </div>

        </div>

        <div class="ModalFooter">
            <jet-button type="button" @click="ActualizaCotizacion(form)" v-show="!editMode" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Actualiza</jet-button>
            <jet-CancelButton @click="chageEditarPre">Cerrar</jet-CancelButton>
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
import TableSky from "@/Components/TableSky";
import JetButton from "@/Components/Button";
import JetCancelButton from "@/Components/CancelButton";
import Modal from "@/Jetstream/Modal";
import Pagination from "@/Components/pagination";
import JetInput from "@/Components/Input";
import JetSelect from "@/Components/Select";
//imports de datatables
import datatable from "datatables.net-bs5";
import $ from "jquery";
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
            showPrecios: false,
            showCotizar: false,
            showFecha: false,
            showEditarPre: false,
            SegundoPrecio: 0,
            hoy: moment().format("YYYY-MM-DD"),
            min: moment().format("YYYY-MM-DD"),
            now: moment().format("YYYY-MM-DD"),
            tam: "5xl",
            tam2: "xl",
            color: "tw-bg-teal-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            detalles: null,
            Cotizacion:{
                Cot: null,
            },
            form: {
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
                IdPre: null,
                IdArt: null,
                IdPre: null,
                IdPre2: null,
                requisicion_id: null,
                NumReq:  null,
                Cantidad: null,
                Unidad: null,
                Precio: null,
                Precio2: null,
                PrecioInteger: null,
                Total: null,
                TotalInteger: null,
                Moneda: null,
                TipoCambio: null,
                Descripcion: null,
                archivo: null,
                Comentarios: null,
                Comentariollegada: null,
                Fechallegada: null,
                ImagenServidor: null,
                PrecioCotizacion: [],
            },
            PreUni: [],
            params:{
                month: null,
                Estatus: null,
                Proveedor: null,
                Req: null,
                Art: null,
            },
        };
    },

    mounted() {
        this.tabla();
    },

    components: {
        AppLayout,
        Welcome,
        Header,
        Accions,
        Table,
        TableSky,
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
        PreciosCotizacion: Object,
        PreciosRequisicion: Object,
        NumCot: Object,
        Req: Object,
        Precios: Object,
        Proveedores: Object,
        PerfilesUsuarios: Object,
        Almacen: Object,
        Cotizacion: Object,
        SinConfirmar: Object,
        Confirmar: Object,
        Autorizados: Object,
        mes: Object,
    },

    created() {
    },

    methods: {
        reset() {
            this.form = {
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
                IdArt: null,
                requisicion_id: null,
                IdPre: null,
                NumReq:  null,
                Cantidad: null,
                Unidad: null,
                Precio: null,
                PrecioInteger: null,
                Total: null,
                TotalInteger: null,
                Moneda: null,
                TipoCambio: null,
                Descripcion: null,
                archivo: null,
                Comentarios: null,
                Comentariollegada: null,
                Fechallegada: null,
                ImagenServidor: null,
            };
        },

        //datatable
        tabla() {
            this.$nextTick(() => {
                $("#Requisiciones").DataTable({
                language: this.español,
                });
            });
        },

        //consulta para generar datos de la tabla
        verTabla(event) {
            $("#Requisiciones").DataTable().destroy();
                this.$inertia.get("/Compras/Requisiciones", { busca: event.target.value },{ onSuccess: () => { this.tabla(); },});
        },

        chagePartidas() {
            this.showPartidas = !this.showPartidas;
        },

        formatoMexico (number){
            const exp = /(\d)(?=(\d{3})+(?!\d))/g;
            const rep = '$1,';
            let arr = number.toString().split('.');
            arr[0] = arr[0].replace(exp,rep);
            return arr[1] ? arr.join('.'): arr[0];
        },

        ConversionMoneda(){
            this.form.PrecioInteger = this.form.Precio; //Sin formatear para calculos
            this.form.Precio = this.formatoMexico(this.form.Precio);
        },

        chageClose() {
            this.showModal = !this.showModal;
        },

        chagePrecios() {
            this.showPrecios = !this.showPrecios;
        },

        chageDetalle() {
            this.showDetalle = !this.showDetalle;
        },

        chageFecha() {
            this.showFecha = !this.showFecha;
        },

        chageEditarPre(){
            this.showEditarPre = !this.showEditarPre;
        },

        CalculaRetraso(Fecha){
            var fecha1 = moment(Fecha);
            var hoy  = moment();
            var di = hoy.diff(fecha1, 'days');
            return  di;
        },

        FiltroIndicadores(value){
            //Filtro para consultar solo por el estatus
            this.params.Estatus = value;
            this.params.month = '';
            $('#Requisiciones').DataTable().clear(); //limpio
            $('#Requisiciones').DataTable().destroy(); //destruyo tabla
            this.$inertia.get('/Compras/Cotizaciones', this.params , { //envio de variables por url
                onSuccess: () => {
                    location.reload(); //Recargo pagina para evitar conflictos de la regeneracion de la tabla
                    this.tabla() //regeneracion de tabla
                }, preserveState: true})
        },

        FiltroMes(value){
            //Filtro para consultar por mes
            this.params.month = value;
            this.params.Estatus = ''; //limpio el estatus para consultar solo por Mes
            $('#Requisiciones').DataTable().clear(); //limpio
            $('#Requisiciones').DataTable().destroy(); //destruyo tabla
            this.$inertia.get('/Compras/Cotizaciones', this.params , { //envio de variables por url
                onSuccess: () => {
                    this.tabla() //regeneracion de tabla
                }, preserveState: true})
        },

        Cotizar(data, metodo){
            this.chageClose();
            this.reset();
            this.editMode = false;
            this.form.IdArt = data.id;
            this.form.requisicion_id = data.requisicion_id;
            this.form.NumReq = data.articulos_requisicion.NumReq;
            this.form.Folio = data.articulos_requisicion.Folio;
            this.form.Area = data.articulos_requisicion.requisicion_departamento.Nombre;
            this.form.Nombre = data.articulos_requisicion.requisiciones_perfil.Nombre + " " + data.articulos_requisicion.requisiciones_perfil.ApPat + " " + data.articulos_requisicion.requisiciones_perfil.ApMat;
            this.form.Observaciones = data.articulos_requisicion.Observaciones;

            this.form.Cantidad = data.Cantidad;
            this.form.Unidad = data.Unidad;
            this.form.Descripcion = data.Descripcion;
        },

        ConfirmaCotizacion(data, metodo){
            data.metodo = 5;
            data._method = "PUT";
            this.$inertia.post("/Compras/Cotizaciones/" + data.id, data, {
                onSuccess: () => {
                    this.alertSucces();
                },
            });
        },

        save(data) {
            if(this.form.Moneda == 'MXN'){
                this.form.Total = this.form.Cantidad * this.form.PrecioInteger;
            }else if(this.form.Moneda == 'USD'){
                var Conversion = Math.round(this.form.TipoCambio * this.form.PrecioInteger, 2);
                this.form.TotalInteger = Conversion * this.form.Cantidad;
                this.form.Total = this.formatoMexico(this.form.TotalInteger);
            }
            this.$inertia.post("/Compras/Cotizaciones", data, {
                onSuccess: () => {
                    location.reload();
                    this.reset(),
                    this.chageClose(),
                    this.alertSucces();
                },
            });
        },

        edit: function (data) {
            this.editMode = true;
            this.form.IdArt = data.id;
            this.form.requisicion_id = data.requisicion_id;
            this.form.NumReq = data.articulos_requisicion.NumReq;
            this.form.Folio = data.articulos_requisicion.Folio;
            this.form.Area = data.articulos_requisicion.requisicion_departamento.Nombre;
            this.form.Nombre = data.articulos_requisicion.requisiciones_perfil.Nombre + " " + data.articulos_requisicion.requisiciones_perfil.ApPat + " " + data.articulos_requisicion.requisiciones_perfil.ApMat;
            this.form.Observaciones = data.articulos_requisicion.Observaciones;

            this.form.Cantidad = data.Cantidad;
            this.form.Unidad = data.Unidad;
            this.form.Descripcion = data.Descripcion;

            this.form.IdPre = data.articulo_precios[0].id;
            this.form.Precio = data.articulo_precios[0].Precio;
            this.form.Total = data.articulo_precios[0].Total;
            this.form.Moneda = data.articulo_precios[0].Moneda;
            this.form.TipoCambio = data.articulo_precios[0].TipoCambio;
            this.form.Marca = data.articulo_precios[0].Marca;
            this.form.Proveedor = data.articulo_precios[0].Proveedor;
            this.form.archivo = data.articulo_precios[0].Archivo;
            this.form.Comentarios = data.articulo_precios[0].Comentarios;
            this.form.ImagenServidor = data.articulo_precios[0].Archivo;

            this.form.PrecioInteger = this.form.Precio.replace(/[,.]/g,'');
            this.chageClose();
        },

        update(data) {
            data.metodo = 0;
            data._method = "PUT";

            if(this.form.Moneda == 'MXN'){
                this.form.Total = this.form.Cantidad * this.form.PrecioInteger;
            }else if(this.form.Moneda == 'USD'){
                var Conversion = Math.round(this.form.TipoCambio * this.form.PrecioInteger, 2);
                this.form.TotalInteger = Conversion * this.form.Cantidad;
                this.form.Total = this.formatoMexico(this.form.TotalInteger);
            }
            this.$inertia.post("/Compras/Cotizaciones/" + data.id, data, {
                onSuccess: () => {
                this.reset(), this.chageClose(), this.alertSucces();
                },
            });
        },

        Detalle(data){
            console.log(data);
            this.chageDetalle();
            this.reset();
            this.editMode = false;
            this.form.requisicion_id = data.requisicion_id;
            this.form.IdArt = data.articulos_requisicion.id;
            this.form.NumReq = data.articulos_requisicion.NumReq;
            this.form.Folio = data.articulos_requisicion.Folio;
            this.form.Area = data.articulos_requisicion.requisicion_departamento.Nombre;
            this.form.Nombre = data.articulos_requisicion.requisiciones_perfil.Nombre + " " + data.articulos_requisicion.requisiciones_perfil.ApPat + " " + data.articulos_requisicion.requisiciones_perfil.ApMat;
            this.form.Observaciones = data.articulos_requisicion.Observaciones;

            this.form.Cantidad = data.Cantidad;
            this.form.Unidad = data.Unidad;
            this.form.Descripcion = data.Descripcion;

            this.form.Precio = data.articulo_precios[0].Precio;
            this.form.Total = data.articulo_precios[0].Total;
            this.form.Marca = data.articulo_precios[0].Marca;
            this.form.Proveedor = data.articulo_precios[0].Proveedor;
            this.form.archivo = data.articulo_precios[0].Archivo;
            this.form.Comentarios = data.articulo_precios[0].Comentarios;

        },

        Precios(data){
            this.Cotizacion.Cot = data.id;
            this.$inertia.get('/Compras/Cotizaciones', this.Cotizacion , { //envio de variables por url
                onSuccess: () => {
                    this.chagePrecios();
            }, preserveState: true })
        },

        CapturaFecha(data){
            this.chageFecha();
            this.form.IdArt = data.id;
        },

        Confirma(data, metodo){
            data.metodo = 7;
            data._method = "PUT";
            this.$inertia.post("/Compras/Cotizaciones/" + data.id, data, {
                onSuccess: () => {
                    this.form.Fechallegada = null,
                    this.form.Comentariollegada = null;
                    this.chageFecha();
                    this.alertSucces();
                },
            });
        },

        PrimerCotizacion(){
            this.SegundoPrecio = 0;
        },

        SegundaCotizacion(){
            this.SegundoPrecio = 1;
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
            this.chagePartidas();
            this.$inertia.get('/Compras/Cotizaciones', this.params , { preserveState: true })
        },

        chageCotizar() {
            this.showCotizar = !this.showCotizar;
        },

        CotizarReq(data){
            this.params.Req = data.id;
            this.$inertia.get('/Compras/Cotizaciones', this.params , {
                onSuccess: () => {

                    this.reset();

                    if(this.ArticulosRequisiciones != null){
                        this.PreUni = [];
                        this.form.PrecioCotizacion = [];

                        this.ArticulosRequisiciones.forEach(Art => {
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
                        this.chageCotizar();
                    }

                },preserveState: true })
        },

        RealizaCotizacion(data) {
            this.$inertia.post("/Compras/Cotizaciones", data, {
                onSuccess: () => {
                this.reset();
                this.PreUni = [];
                this.form.PrecioCotizacion = [];
                    this.chageCotizar();
                    this.alertSucces();
                },
            });
        },

        EditaCotizacion(data){
            this.params.Req = data.id;
            this.$inertia.get('/Compras/Cotizaciones', this.params , { //envio de variables por url
                onSuccess: () => {
            }, preserveState: true })
        },

        EditaPrecio(data){
            var query  = window.location.search.substring(1);
            var vars = query.split("&");
                for (var i=0; i < vars.length; i++) {
                    var pair = vars[i].split("=");
                    if(pair[0] == 'Req') {
                        this.params.Req = pair[1];
                    }
            }
            this.params.Art = data.id;

            this.form.IdPre = this.PreciosRequisicion[0].id;

            this.form.Marca = this.PreciosRequisicion[0].Marca;
            this.form.Proveedor = this.PreciosRequisicion[0].Proveedor;
            this.form.Precio = this.PreciosRequisicion[0].Precio;

            this.form.Moneda = this.PreciosRequisicion[0].Moneda;
            this.form.TipoCambio = this.PreciosRequisicion[0].TipoCambio;
            this.form.Comentarios = this.PreciosRequisicion[0].Comentarios;
            this.form.Archivo = this.PreciosRequisicion[0].Archivo;

            if(this.NumCot >= 1){
                this.form.IdPre2 = this.PreciosRequisicion[1].id;
                this.form.Precio2 = this.PreciosRequisicion[1].Precio;
            }

            this.form.Cantidad = this.ArticulosRequisiciones[0].Cantidad;
            this.form.NumReq = this.Req[0].NumReq;
            this.chageEditarPre();
        },

        ActualizaCotizacion(data){
            data.metodo = 1;
            data._method = "PUT";
            console.log(data);
            this.$inertia.post("/Compras/Cotizaciones/" + data.id, data, {
                onSuccess: () => {
                    this.reset(),
                    this.chageEditarPre(),
                    this.alertSucces();
                },
            });
        },

        ConfirmaRequisicionCotizada(data, metodo){
            data.metodo = 2;
            data._method = "PUT";
            this.$inertia.post("/Compras/Cotizaciones/" + data.id, data, {
                onSuccess: () => {
                    this.alertSucces();
                },
            });
        },
    },
};
</script>
