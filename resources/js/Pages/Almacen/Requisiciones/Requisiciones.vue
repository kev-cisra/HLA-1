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

            <div class="tw-mt-8">
                <div class="tw-flex tw-justify-between tw-px-4">
                    <div class="tw-flex tw-flex-wrap tw-content-center">
                        <select class="InputSelect" v-model="params.Estatus">
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

                    </div>
                </div>
            </div>

            <div class="tw-overflow-x-auto tw-mx-2">
                <Table id="Requisiciones">
                    <template v-slot:TableHeader>
                        <th class="columna">Id</th>
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
                        <th class="columna">O.C</th>
                        <th class="columna">ESTATUS</th>
                        <th class="columna">ACCIONES</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila" v-for="datos in Requisiciones" :key="datos.id">
                            <td class="tw-text-center">{{ datos.id }}</td>
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
                            <td class="tw-text-center">{{ datos.OrdenCompra }}</td>
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
                                        <span tooltip="Confirma existencia toal en Almacén" flow="left">
                                            <i class="fas fa-check-circle"></i>
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

            <modal :show="showModal" @close="chageClose" :maxWidth="tam">
                <div class="tw-px-4 tw-py-4">
                    <div class="tw-text-lg">
                        <div class="ModalHeader">
                            <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Crea Parcialidad</h3>
                        </div>
                    </div>

                    <div class="tw-mt-4">
                        <div class="ModalForm">
                            <div class="tw-flex tw-items-center tw-justify-center tw-uppercase">
                                <div class="tw-w-full tw-bg-white tw-rounded-lg tw-shadow-xl">
                                    <div class="tw-p-2 tw-ml-4 tw-space-y-1 tw-border-b md:tw-grid md:tw-grid-cols-3 tw-justify-items-stretch hover:tw-bg-gray-50 md:tw-space-y-0">
                                        <div class="tw-justify-self-start">
                                            <p class="tw-text-gray-600">Número de requisición</p>
                                            <input type="text" class="InfoData" v-model="form.NumReq" disabled/>
                                        </div>
                                        <div class="tw-justify-self-start">
                                            <p class="tw-text-gray-600">Fecha</p>
                                            <input type="text" class="InfoData" v-model="form.Fecha" disabled/>
                                        </div>
                                    </div>
                                    <div class="tw-p-2 tw-ml-4 tw-space-y-1 tw-border-b md:tw-grid md:tw-grid-cols-3 tw-justify-items-stretch hover:tw-bg-gray-50 md:tw-space-y-0">
                                        <div class="tw-justify-self-start">
                                            <p class="tw-text-gray-600">Cantidad</p>
                                            <input type="text" class="InfoData" v-model="form.Cant" disabled/>
                                        </div>
                                        <div class="tw-justify-self-start">
                                            <p class="tw-text-gray-600">Unidad</p>
                                            <input type="text" class="InfoData" v-model="form.Uni" disabled/>
                                        </div>
                                        <div class="tw-justify-self-start">
                                            <p class="tw-text-gray-600">descripción</p>
                                            <input type="text" class="InfoData" v-model="form.Desc" disabled/>
                                        </div>
                                    </div>
                                    <div class="tw-flex tw-flex-col tw-justify-center tw-text-center tw-uppercase tw-rounded">
                                        <div class="tw-p-4">
                                            <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                                                <jet-label><span class="required">*</span>Confirma Parcialidad</jet-label>
                                                <jet-input type="number" v-model="form.Parcialidad"></jet-input>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ModalFooter">
                    <jet-button type="button" @click="update(form, 3.1)">Guardar</jet-button>
                    <jet-CancelButton @click="chageClose">Cerrar</jet-CancelButton>
                </div>
            </modal>

            <modal :show="showRepo" @close="chageRepo" maxWidth="xl">
                <form>
                    <div class="tw-px-4 tw-py-4">
                        <div class="tw-text-lg">
                            <div class="ModalHeader">
                                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Solicita Reposicion de Stock</h3>
                            </div>
                        </div>

                        <div class="tw-mt-4">
                            <div class="tw-container tw-max-w-screen-lg tw-mx-auto">
                                <section class="tw-rounded-md">
                                    <h2 class="tw-uppercase tw-tracking-wide tw-text-md tw-font-semibold tw-text-gray-500 tw-my-2 tw-text-center">Solicita la reposicion del material para stock</h2>
                                    <fieldset class="tw-mb-3 tw-bg-white tw-flex tw-table-column tw-shadow-lg tw-rounded tw-text-gray-600">
                                        <div class="tw-flex tw-border-b tw-border-gray-200 tw-h-12 tw-py-3 tw-items-center">
                                            <div class="tw-w-1/3"><span class="tw-text-right tw-px-2">Número de requsición: </span></div>
                                            <div class="tw-w-2/3 tw-font-bold">{{form.NumReq}}</div>
                                        </div>
                                        <div class="tw-flex tw-border-b tw-border-gray-200 tw-h-12 tw-py-3 tw-items-center">
                                            <div class="tw-w-1/3"><span class="tw-text-right tw-px-2">Material: </span></div>
                                            <div class="tw-w-2/3 tw-font-bold">{{ form.Cant }} {{ form.Uni }} {{ form.Desc }}</div>
                                        </div>
                                        <div class="tw-flex tw-border-b tw-border-gray-200 tw-h-12 tw-py-3 tw-items-center">
                                            <div class="tw-w-1/3"><span class="tw-text-right tw-px-2">Núm Parte: </span></div>
                                            <div class="tw-w-2/3 tw-font-bold" v-if="form.NumParte != null">{{ form.NumParte }}</div>
                                            <div class="tw-w-2/3 tw-font-bold" v-else>N/A</div>
                                        </div>
                                        <div class="tw-flex border-b tw-border-gray-200 tw-h-12 tw-py-3 tw-items-center">
                                            <div class="tw-w-1/3"><span class="tw-text-right tw-px-2">Observaciones:</span></div>
                                            <div class="tw-w-2/3 tw-font-bold">{{ form.Obser }}</div>
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

            <modal :show="showProveedor" @close="chageProveedor" maxWidth="2xl">
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

            <modal :show="showPartidas" @close="chagePartidas" :maxWidth="tam">
                <div class="tw-px-4 tw-py-4">
                    <div class="tw-text-lg">
                        <div class="ModalHeader">
                            <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Articulos de requisición </h3>
                        </div>
                    </div>
                </div>

                <div class="tw-mx-4" v-if="ArticulosRequisiciones != null">
                    <div v-if=" ArticulosRequisiciones[0].articulo_user != null">
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
                                        <div class="columnaIconos">
                                            <div class="iconoEdit" @click="ArticuloAlmacen(art)">
                                                <span tooltip="Confirma Partida en Almacén" flow="left">
                                                    <i class="ml-2 fas fa-check-circle"></i>
                                                </span>
                                            </div>
                                            <div class="iconoEdit" @click="ArticuloCotizacion(art)">
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
                                <tr class="fila" v-for="art in ArticulosRequisiciones" :key="art.id">
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
                                            <div class="iconoEdit" @click="ArticuloAlmacen(art)">
                                                <span tooltip="Confirma Partida en Almacén" flow="left">
                                                    <i class="ml-2 fas fa-check-circle"></i>
                                                </span>
                                            </div>
                                            <div class="iconoEdit" @click="ArticuloCotizacion(art)">
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
                </div>
                <div v-else>
                    <p>No hay Articulos Asignados a esta requisición</p>
                </div>

                <div class="ModalFooter">
                    <jet-CancelButton @click="chagePartidas">Cerrar</jet-CancelButton>
                </div>
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
            showProveedor: false,
            showConfirm: false,
            showRepo: false,
            min: moment().format("YYYY-MM-DD"),
            now: moment().format("YYYY-MM-DD"),
            tam: "5xl",
            color: "tw-bg-cyan-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            detalles: null,
            form: {
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
            },
            params:{
                month: null,
                Estatus: null,
            },
            Marcas: [],
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
        JetButton,
        JetCancelButton,
        Modal,
        Pagination,
        JetInput,
        JetSelect,
        Canvas,
    },

    props: {
        Session: Object,
        errors: Object,
        flash: Object,
        Requisiciones: Object,
        ArticulosRequisiciones: Object,
        Departamentos: Object,
        Maquinas: Object,
        PerfilesUsuarios: Object,
        Almacen: Object,
        Cotizacion: Object,
        SinConfirmar: Object,
        mes: Object,
    },

    methods: {

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
            };
        },

        //datatable
        tabla() {
            this.$nextTick(() => {
                $("#Requisiciones").DataTable({
                    "language": this.español,
                    "columnDefs": [
                        {
                            "targets": [ 0 ],
                            "visible": false,
                            "searchable": false
                        },
                    ],
                    "order": [0, 'desc'],
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
            this.$inertia.get("/Compras/Requisiciones", { busca: event.target.value },{ onSuccess: () => { this.tabla(); },});
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

        chageProveedor(){
            this.showProveedor = !this.showProveedor;
        },

        chageRepo(){
            this.showRepo = !this.showRepo;
        },

        Parcialidad(data){
            this.form.IdArt = data.id;
            this.form.NumReq = data.articulos_requisicion.NumReq;
            this.form.Fecha = data.Fecha;
            this.form.Cant = data.Cantidad;
            this.form.Uni = data.Unidad;
            this.form.Desc = data.Descripcion;
            this.chageClose();
            this.editMode = false;
        },

        FiltroIndicadores(value){
            //Filtro para consultar solo por el estatus
            this.params.Estatus = value;
            this.params.month = '';
            $('#Requisiciones').DataTable().clear(); //limpio
            $('#Requisiciones').DataTable().destroy(); //destruyo tabla
            this.$inertia.get('/Almacen/Requisiciones', this.params , { //envio de variables por url
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
            this.$inertia.get('/Almacen/Requisiciones', this.params , { //envio de variables por url
                onSuccess: () => {
                    this.tabla() //regeneracion de tabla
                }, preserveState: true})
        },

        update(data, metodo) {
            data.metodo = "Parcialidad";
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
            this.chageRepo();
            this.form.NumReq = data.articulos_requisicion.NumReq;
            this.form.Obser = data.articulos_requisicion.Observaciones;
            this.form.Codigo = data.articulos_requisicion.Codigo;
            this.form.Maq = data.articulos_requisicion.Maquina_id;
            this.form.Mar = data.articulos_requisicion.Marca_id;
            this.form.TipCompra = data.articulos_requisicion.TipCompra;
            this.form.Cant = data.Cantidad;
            this.form.Uni = data.Unidad;
            this.form.Desc = data.Descripcion;
            this.form.NumParte = data.NumParte;
            this.form.Fecha = moment().format("YYYY-MM-DD");
            this.form.Dpto = this.Session.Departamento;
            this.form.IdEmp = this.Session.IdEmp;
        },

        GeneraReposicion(data){
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

            this.$inertia.get('/Almacen/Requisiciones', this.params , {
                preserveState: true,
                    onSuccess: () => {
                        this.chagePartidas();
                    },
                })
        },

        EnviarCotizarRequisicion(data){ //Enviar requisicion a cotizacion
            data.metodo = 1;
            data._method = "PUT";
            this.$inertia.post("/Almacen/Requisiciones/" + data.id, data, {
                onSuccess: () => {
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
    },

};
</script>
