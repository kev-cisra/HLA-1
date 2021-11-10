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
                                    <div class="tw-text-xs tw-text-gray-400">Articulos Pendientes Por cotizar</div>
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
                                    <div class="tw-text-xs tw-text-gray-400">Pendientes por agregar Fecha Entrega</div>
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
                                    <div class="tw-text-lg"> {{ CotizacionMes }} </div>
                                    <div class="tw-text-xs tw-text-gray-400">Pendientes por Cotizar de <strong>{{params.MesLetra}}</strong> </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="tw-overflow-auto md:tw-flex md:tw-justify-center">
            <div class="tw-flex tw-items-center tw-mt-2 tw-text-center tw-text-white tw-border">
                <div class="tw-m-3" @click="FiltroPorMes(1)">
                    <button class="EneroActivo" v-if="mes == 1">
                        <span class="mx-auto">Enero</span>
                    </button>
                    <button class="Enero" v-else>
                        <span class="mx-auto">Enero</span>
                    </button>
                </div>

                <div class="tw-m-3" @click="FiltroPorMes(2)">
                    <button class="FebreroActivo" v-if="mes == 2">
                        <span class="mx-auto">Febrero</span>
                    </button>
                    <button class="Febrero" v-else>
                        <span class="mx-auto">Febrero</span>
                    </button>
                </div>

                <div class="tw-m-3" @click="FiltroPorMes(3)">
                    <button class="MarzoActivo" v-if="mes == 3">
                        <span class="mx-auto">Marzo</span>
                    </button>
                    <button class="Marzo" v-else>
                        <span class="mx-auto">Marzo</span>
                    </button>
                </div>

                <div class="tw-m-3" @click="FiltroPorMes(4)">
                    <button class="AbrilActivo" v-if="mes == 4">
                        <span class="mx-auto">Abril</span>
                    </button>
                    <button class="Abril" v-else>
                        <span class="mx-auto">Abril</span>
                    </button>
                </div>

                <div class="tw-m-3" @click="FiltroPorMes(5)">
                    <button class="MayoActivo" v-if="mes == 5">
                        <span class="mx-auto">Mayo</span>
                    </button>
                    <button class="Mayo" v-else>
                        <span class="mx-auto">Mayo</span>
                    </button>
                </div>

                <div class="tw-m-3" @click="FiltroPorMes(6)">
                    <button class="JunioActivo" v-if="mes == 6">
                        <span class="mx-auto">Junio</span>
                    </button>
                    <button class="Junio" v-else>
                        <span class="mx-auto">Junio</span>
                    </button>
                </div>

                <div class="tw-m-3" @click="FiltroPorMes(7)">
                    <button class="JulioActivo" v-if="mes == 7">
                        <span class="mx-auto">Julio</span>
                    </button>
                    <button class="Julio" v-else>
                        <span class="mx-auto">Julio</span>
                    </button>
                </div>

                <div class="tw-m-3" @click="FiltroPorMes(8)">
                    <button class="AgostoActivo" v-if="mes == 8">
                        <span class="mx-auto">Agosto</span>
                    </button>
                    <button class="Agosto" v-else>
                        <span class="mx-auto">Agosto</span>
                    </button>
                </div>

                <div class="tw-m-3" @click="FiltroPorMes(9)">
                    <button class="SeptiembreActivo" v-if="mes == 9">
                        <span class="mx-auto">Septiembre</span>
                    </button>
                    <button class="Septiembre" v-else>
                        <span class="mx-auto">Septiembre</span>
                    </button>
                </div>

                <div class="tw-m-3" @click="FiltroPorMes(10)">
                    <button class="OctubreActivo" v-if="mes == 10">
                        <span class="mx-auto">Octubre</span>
                    </button>
                    <button class="Octubre" v-else>
                        <span class="mx-auto">Octubre</span>
                    </button>
                </div>

                <div class="tw-m-3" @click="FiltroPorMes(11)">
                    <button class="NoviembreActivo" v-if="mes == 11">
                        <span class="mx-auto">Noviembre</span>
                    </button>
                    <button class="Noviembre" v-else>
                        <span class="mx-auto">Noviembre</span>
                    </button>
                </div>

                <div class="tw-m-3" @click="FiltroPorMes(12)">
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
                        <option value="5">SIN AUTORIZAR</option>
                        <option value="6">AUTORIZADO</option>
                        <option value="7">CONFIRMADOS</option>
                        <option value="8">EN ALMACEN</option>
                        <option value="9">ENTREGADO</option>
                    </select>
                </div>
                <div>

                </div>
            </div>
            <div class="tw-overflow-x-auto tw-mx-2">
                <Table>
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
                        <th class="columna">PARTIDAS</th>
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
                            <td class="tw-text-center">{{ datos.Estatus }}</td>
                            <td>
                                <div class="columnaIconos" v-if="datos.Estatus == 5">
                                    <div class="iconoDetails" @click="Partidas(datos)">
                                        <span tooltip="Visualiza Partidas" flow="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </span>
                                    </div>
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

            <div class="tw-overflow-x-auto tw-mx-28 tw-mt-12" v-if="Art != null">
                <Table>
                    <template v-slot:TableHeader>
                        <th class="columna">Fecha</th>
                        <th class="columna">Cantidad</th>
                        <th class="columna">Unidad</th>
                        <th class="columna">Descripcion</th>
                        <th class="columna">NumParte</th>
                        <th class="columna">EstatusArt</th>
                        <th class="columna">RecibidoPor</th>
                        <th class="columna">Acciones</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila" v-for="datos in Art" :key="datos.id">
                            <td class="tw-text-center">{{ datos.Fecha }}</td>
                            <td class="tw-text-center">{{ datos.Cantidad }}</td>
                            <td class="tw-text-center">{{ datos.Unidad }}</td>
                            <td class="tw-text-center">{{ datos.Descripcion }}</td>
                            <td class="tw-text-center">{{ datos.NumParte }}</td>
                            <td class="tw-text-center">{{ datos.EstatusArt }}</td>
                            <td class="tw-text-center">{{ datos.RecibidoPor }}</td>
                            <td>
                                <div class="columnaIconos" v-if="datos.EstatusArt == 4">
                                    <div class="iconoEdit" @click="EditaPrecio(datos)">
                                        <span tooltip="Editar Precio" flow="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                                <div class="columnaIconos" v-else-if="datos.EstatusArt == 7">
                                    <div class="iconoPurple" @click="ProductoAlmacen(datos, 8)">
                                        <span tooltip="Confirma Producto en Almacén" flow="left">
                                            <i class="ml-2 fas fa-box"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="columnaIconos" v-else-if="datos.EstatusArt == 8">
                                    <div class="iconoLime" @click="EntregaProducto(datos)">
                                        <span tooltip="Entrega el Artículo" flow="left">
                                            <i class="fas fa-fingerprint"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="columnaIconos" v-else-if="datos.EstatusArt == 9">
                                    <div class="iconoGreen" v-if="datos.articulos_requisicion.NumReq.endsWith('-S') != true" @click="SolicitaReposicion(datos)">
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
        </div>
    </div>

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

    <modal :show="showRechazo" @close="chageCloseRechazo" :maxWidth="tam">
        <form>
            <div class="tw-px-4 tw-py-4">
                <div class="tw-text-lg">
                    <div class="ModalHeader">
                        <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Rechazo de Cotizacion</h3>
                    </div>
                </div>

                <div class="tw-mt-4">
                    <div class="ModalForm">
                        <div class="tw-mb-6 md:tw-flex">
                            <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                                <jet-label><span class="required">*</span>Motivo Rechazo</jet-label>
                                <textarea name="" id="" cols="2" v-model="Rechazo.ComentarioRechazo" @input="(val) => (Rechazo.ComentarioRechazo = Rechazo.ComentarioRechazo.toUpperCase())" class="tw-bg-gray-200 tw-text-gray-500 tw-font-semibold focus:tw-outline-none focus:tw-shadow-outline tw-border tw-border-gray-300 tw-rounded-lg tw-py-2 tw-px-4 tw-block tw-w-full tw-appearance-none tw-shadow-sm"></textarea>
                                <small v-if="errors.ComentarioRechazo" class="validation-alert">{{errors.ComentarioRechazo}}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ModalFooter">
                <jet-button type="button" @click="Rechaza(datos, 10)">Guardar</jet-button>
                <jet-CancelButton @click="chageClose">Cerrar</jet-CancelButton>
            </div>
        </form>
    </modal>

    <modal :show="showPreciosRequisicion" @close="chagePreciosRequisicion" :maxWidth="tam">
        <div class="tw-px-4 tw-py-4">
            <div class="tw-text-lg">
                <div class="ModalHeader">
                    <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Autoriza Cotización</h3>
                </div>
            </div>

            <div class="tw-mx-8">
                <Table>
                    <template v-slot:TableHeader>
                        <th class="columna">FECHA</th>
                        <th class="columna">NÚM REQ</th>
                        <th class="columna">DEPARTAMENTO</th>
                        <th class="columna">CODIGO</th>
                        <th class="columna">MAQUINA</th>
                        <th class="columna">MARCA</th>
                        <th class="columna">ESTATUS</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila" v-for="datos in PreciosRequisicion" :key="datos.id">
                            <td class="tw-text-center">{{datos.Fecha}}</td>
                            <td class="tw-text-center">{{datos.NumReq}}</td>
                            <td class="tw-text-center">{{datos.requisicion_departamento.Nombre}}</td>
                            <td class="tw-text-center">{{datos.Codigo}}</td>
                            <td class="tw-text-center">{{datos.requisicion_maquina.Nombre}}</td>
                            <td class="tw-text-center">{{datos.requisicion_marca.Nombre}}</td>
                            <td class="tw-text-center">{{datos.Estatus}}</td>

                        </tr>
                    </template>
                </Table>
            </div>

        <div class="tw-my-4">
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
                    <th class="columna">TOTAL</th>
                    <th class="columna">ARCHIVO</th>
                </template>

                <template v-slot:TableFooter>
                    <tr class="fila tw-bg-gray-200" v-for="datos in Articulos" :key="datos.id">
                        <td class="tw-text-center">{{datos.Cantidad}}</td>
                        <td class="tw-text-center">{{datos.Unidad}}</td>
                        <td class="tw-text-center">{{datos.Descripcion}}</td>
                        <td>
                            <tr class="tw-text-center" v-for="Pre in datos.articulo_precios" :key="Pre">
                                {{Pre.Marca}}
                            </tr>
                        </td>
                        <td>
                            <tr class="tw-text-center" v-for="Pre in datos.articulo_precios" :key="Pre">
                                {{Pre.Proveedor}}
                            </tr>
                        </td>
                        <td>
                            <tr class="tw-text-center" v-for="Pre in datos.articulo_precios" :key="Pre">
                                {{  Pre.Comentarios }}
                            </tr>
                        </td>
                        <td>
                            <tr class="tw-text-center" v-for="Pre in datos.articulo_precios" :key="Pre">
                                $ {{Pre.Precio}}
                            </tr>
                        </td>
                        <td>
                            <tr v-for="Pre in datos.articulo_precios" :key="Pre">
                                {{Pre.Moneda}}
                            </tr>
                        </td>
                        <td>
                            <tr v-for="Pre in datos.articulo_precios" :key="Pre">
                                $ {{Pre.TipoCambio}}
                            </tr>
                        </td>
                        <td>
                            <tr v-for="Pre in datos.articulo_precios" :key="Pre">
                                $ {{Pre.Total}}
                            </tr>
                        </td>
                        <td>
                            <tr class="tw-p-1" v-for="Pre in datos.articulo_precios" :key="Pre">
                                <a target="_blank" :href="path + Pre.Archivo" style="color:black;">
                                    <i class="far fa-file-image"></i>
                                </a>
                            </tr>
                        </td>
                    </tr>
                </template>
            </Table>
        </div>
        </div>

        <div class="ModalFooter">
            <jet-button type="button" @click="AutorizaCotizacion(form)" v-show="!editMode" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Autoriza Cotizacion</jet-button>
            <jet-button type="button" @click="AutorizaCotizacion2(form)" v-if="NumCotizaciones == 2" v-show="!editMode" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Autoriza 2° Cotizacion</jet-button>
            <jet-CancelButton @click="chagePreciosRequisicion">Cerrar</jet-CancelButton>
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
            showDetalle: false,
            showRechazo: false,
            showPreciosRequisicion: false,
            min: moment().format("YYYY-MM-DD"),
            now: moment().format("YYYY-MM-DD"),
            tam: "5xl",
            color: "tw-bg-sky-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            detalles: null,
            form: {
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
                action: '',
                requisicion_id: '',
            },
            Rechazo: {
                ComentarioRechazo: null,
                rechazo: null,
                articulo_id: null,
            },
            Cotizacion:{
                Cot: null,
            },
            PreciosArt: {
            },
            params:{
                month: moment().format("MM"),
                Estatus: null,
                Proveedor: null,
                MesLetra: null,
                Cot: null,
                Req: null,
                Art: null,
            },
        };
    },

    mounted() {
        this.tabla();
        this.MesALetra();
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
        ArticuloRequisicion: Object,
        PreciosCotizacion: Object,
        Proveedores: Object,
        PerfilesUsuarios: Object,
        Cotizacion: Object,
        Pendientes: Object,
        Confirmar: Object,
        PendientesMes: Object,
        CotizacionMes: Object,
        mes: Object,
        Requisiciones: Object,
        Articulos: Object,
        PreciosRequisicion: Object,
        NumCotizaciones: Object,
    },

    methods: {

        reset() {
            this.form = {
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
                IdArt: null,
                requisicion_id: null,
                NumReq:  null,
                Folio: null,
                Area: null,
                Observacioens: null,
                Cantidad: null,
                Unidad: null,
                Descripcion: null,
                Comentarios: null,
                MotivoCancelacion: null,

                Precios: [{
                Precio: null,
                Total: null,
                Marca: null,
                Proveedor: null,
                archivo: null,
                }],
            };
            this.Rechazo = {
                ComentarioRechazo: null,
                rechazo: null,
                articulo_id: null,
            };
        },

        //datatable
        tabla() {
            this.$nextTick(() => {
                $("#Articulos").DataTable({
                language: this.español,
                pageLength: 50,
                bLengthChange: false,
                });
            });
        },

        //consulta para generar datos de la tabla
        verTabla(event) {
            $("#Articulos").DataTable().destroy();
                this.$inertia.get("/Supply/AutorizaRequisiciones", { busca: event.target.value },{ onSuccess: () => { this.tabla(); },});
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

        chageCloseRechazo() {
            this.showRechazo = !this.showRechazo;
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
            $('#Articulos').DataTable().clear(); //limpio
            $('#Articulos').DataTable().destroy(); //destruyo tabla
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

        FiltroIndicadores(value){
            $('#Articulos').DataTable().clear(); //limpio
            $('#Articulos').DataTable().destroy(); //destruyo tabla
            this.params.Estatus = value;
            this.$inertia.get('/Supply/AutorizaRequisiciones', this.params , { //envio de variables por url
            onSuccess: () => {
                location.reload();
                this.tabla() //regeneracion de tabla
            }, preserveState: true})
        },

        FiltroIndicadorMensual(value){
            $('#Articulos').DataTable().clear(); //limpio
            $('#Articulos').DataTable().destroy(); //destruyo tabla
            this.params.Estatus = value;
            this.$inertia.get('/Supply/AutorizaRequisiciones', this.params , { //envio de variables por url
            onSuccess: () => {
                location.reload();
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

            this.$inertia.get('/Supply/AutorizaRequisiciones', this.params , { //envio de variables por url
                onSuccess: () => {
            }, preserveState: true })
        },

        VisualizaCotizacion(data){
            this.params.Req = data.id;
            this.form.requisicion_id = data.id;
            console.log(data);
            this.$inertia.get('/Supply/AutorizaRequisiciones', this.params , {preserveState: true })
            this.chagePreciosRequisicion();
        },

        AutorizaCotizacion(data){
            data._method = "PUT";
            this.form.action = 1;
            this.$inertia.post("/Supply/AutorizaRequisiciones/" + data.id, data, {
                onSuccess: () => {
                    this.alertSucces();
                },
            });
        },

        AutorizaCotizacion2(data){
            data._method = "PUT";
            this.form.action = 2;
            this.$inertia.post("/Supply/AutorizaRequisiciones/" + data.id, data, {
                onSuccess: () => {
                    this.alertSucces();
                },
            });
        },

    },
};
</script>
