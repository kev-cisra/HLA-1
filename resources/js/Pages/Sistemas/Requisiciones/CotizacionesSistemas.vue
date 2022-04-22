<template>
    <app-layout>
        <section class="uppercase tw-mx-4">
            <Header :class="[color, style]">
                <slot>
                    <h3 class="tw-p-2"><i class="fas fa-user tw-ml-3 tw-mr-3"></i> COTIZACIONES SISTEMAS </h3>
                </slot>
            </Header>
        </section>
        <!-- ******************************* FILTROS ********************************************* -->
        <section class="tw-flex tw-justify-between tw-content-center tw-border tw-p-2 tw-my-8 tw-mx-8">
            <div class="tw-flex tw-gap-4 tw-mx-2">
                <div>
                    <jet-button @click="openReportes" class="BtnNuevo">COSTOS</jet-button>
                </div>
            </div>
            <div>
                <jet-button @click="openModal" class="BtnNuevo">NUEVA REQUISICION</jet-button>
            </div>
        </section>
        <!-- ********************************* TABLAS ********************************************* -->
        <section class="tw-mx-8">
            <Table id="Requisiciones">
                <template v-slot:TableHeader>
                    <th class="columna">FECHA</th>
                    <th class="columna">FOLIO</th>
                    <th class="columna">SOLICITANTE</th>
                    <th class="columna">DEPARTAMENTO</th>
                    <th class="columna">ARTICULOS</th>
                    <th class="columna">COMENTARIOS</th>
                    <th class="columna">ESTATUS</th>
                    <th class="columna">ACCIONES</th>
                </template>

                <template v-slot:TableFooter>
                    <tr class="fila" v-for="data in RequisicionesSistemas" :key="data.id">
                        <td>{{data.Fecha}}</td>
                        <td>S-{{data.Folio}}</td>
                        <td>{{data.perfil.Nombre}} {{data.perfil.ApPat}} {{data.perfil.ApMat}} </td>
                        <td>{{data.departamento.Nombre}}</td>
                        <td>
                            <p v-for="art in data.articulos" :key="art.id">
                                -{{art.Cantidad }} {{art.Unidad }} {{art.Dispositivo }}
                            </p>
                        </td>
                        <td>{{data.Comentarios}}</td>
                        <td>
                            <div class="FlexCenter">
                                <div v-if="data.Estatus == 0">
                                    <span tooltip="Cotizacion Rechazada" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-rose-500 tw-rounded-full">RECHAZADA</span>
                                    </span>
                                </div>
                                <div v-if="data.Estatus == 2">
                                    <span tooltip="Solicitado" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-emerald-500 tw-rounded-full">COTIZAR</span>
                                    </span>
                                </div>
                                <div v-if="data.Estatus == 3">
                                    <span tooltip="Cotizado" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-cyan-500 tw-rounded-full">COTIZADO</span>
                                    </span>
                                </div>
                                <div v-if="data.Estatus == 4">
                                    <span tooltip="En Autorización" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-violet-500 tw-rounded-full">AUTORIZACIÓN</span>
                                    </span>
                                </div>
                                <div v-if="data.Estatus == 5">
                                    <span tooltip="Autorizado" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-fuchsia-500 tw-rounded-full">APROBADO</span>
                                    </span>
                                </div>
                                <div v-if="data.Estatus == 6">
                                    <span tooltip="Material Adquirido" flow="left">
                                        <span class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-bg-blue-500 tw-rounded-full">STOCK</span>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="tw-flex tw-justify-center tw-items-center" >
                                <div class="iconoPurple" @click="CotizarReq(data)" v-if="data.Estatus == 2">
                                    <span tooltip="Realizar Cotización" flow="left">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </span>
                                </div>
                                <div class="iconoGreen" @click="ConfirmaMaterial(data)" v-if="data.Estatus == 2 || data.Estatus == 5">
                                    <span tooltip="Confirma Material" flow="left">
                                        <i class="fa-solid fa-box-open"></i>
                                    </span>
                                </div>
                                <div class="iconoEdit" @click="edit(data)" v-if="data.Estatus == 3">
                                    <span tooltip="Editar" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="iconoTeal" @click="ConfirmaCotizacion(data)" v-else-if="data.Estatus == 3 || data.Estatus == 0">
                                    <span tooltip="Confirma Cotización" flow="left">
                                        <i class="fa-solid fa-circle-check"></i>
                                    </span>
                                </div>
                                <div class="iconoCyan" @click="VisualizaCotizacion(data)" v-if="data.Estatus > 2">
                                    <span tooltip="Visualiza Cotización" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="iconoLime" @click="CambiarTipoPago(data)" v-if="data.Estatus > 2">
                                    <span tooltip="Cambiar Tipo Pago" flow="left">
                                        <i class="fa-solid fa-hand-holding-dollar"></i>
                                    </span>
                                </div>
                                <div class="iconoPurple" @click="imprimir(data)" v-if="data.Estatus > 2">
                                    <span tooltip="Imprimir" flow="left">
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
        </section>
        <!-- ***************************************** MODALES ****************************************************** -->
        <!-- --------------------- Modal registrar Solicitud -------------------------- -->
        <modal :show="showModal" @close="chageClose" :maxWidth="tam">
            <div class="ModalHeader">
                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>NUEVA REQUISICIÓN</h3>
            </div>

            <div class="ModalForm">
                <div class="FormSection">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/3 md:tw-mb-0">
                        <jet-label><span class="required">*</span>FECHA</jet-label>
                        <jet-input type="date" :min="Today" v-model="Sol.Fecha"></jet-input>
                        <small v-if="errors.Fecha" class="validation-alert">{{errors.Fecha}}</small>
                    </div>
                    <div class="tw-px-3 tw-mb-6 md:tw-w-2/3 md:tw-mb-0">
                        <jet-label><span class="required">*</span>DEPARTAMENTO</jet-label>
                        <Select2 v-model="Sol.Departamento_id" class="InputSelect" :settings="{width: '100%',allowClear: true}" element="background: '#e5e7eb'" :options="BuscaDepartamento" />
                        <small v-if="errors.Departamento_id" class="validation-alert" >{{ errors.Proveedor }}</small>
                    </div>
                </div>
                <div class="FormSection">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                        <jet-label><span class="required">*</span>SOLICITANTE</jet-label>
                        <Select2 v-model="Sol.Perfil_id" class="InputSelect" :settings="{width: '100%',allowClear: true}" element="background: '#e5e7eb'" :options="BuscaPerfil" />
                        <small v-if="errors.Perfil_id" class="validation-alert" >{{ errors.Perfil_id }}</small>
                    </div>
                </div>
                <div class="FormSection">
                    <div class="tw-px-3">
                        <input type="button" @click="addRow()" value="Añadir Partida" class="BtnCancel">
                    </div>
                </div>
                <div class="FormSection" v-for="(Sol) in Sol.Partida" :key="Sol.id">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                        <jet-label><span class="required">*</span>CANTIDAD</jet-label>
                        <jet-input type="number" min="1" v-model="Sol.Cantidad"></jet-input>
                        <small v-if="errors.Cantidad" class="validation-alert">{{errors.Cantidad}}</small>
                    </div>
                    <div class="tw-px-3 tw-mb-6 md:tw-w-3/12 md:tw-mb-0">
                        <jet-label><span class="required">*</span>UNIDAD</jet-label>
                        <select id="Unidad" v-model="Sol.Unidad" class="InputSelect">
                            <option value="PZ">PIEZA</option>
                            <option value="SERVICIO">SERVICIO</option>
                            <option value="MT">METRO</option>
                            <option value="CAJA">CAJA</option>
                        </select>
                        <small v-if="errors.Unidad" class="validation-alert">{{errors.Unidad}}</small>
                    </div>
                    <div class="tw-px-3 tw-mb-6 md:tw-w-6/12 md:tw-mb-0">
                        <jet-label><span class="required">*</span>MATERIAL</jet-label>
                        <jet-input type="text" v-model="Sol.Dispositivo" @input="(val) => (Sol.Dispositivo = Sol.Dispositivo.toUpperCase())"></jet-input>
                        <small v-if="errors.Dispositivo" class="validation-alert">{{errors.Dispositivo}}</small>
                    </div>
                    <div class="tw-mt-6 md:tw-w-1/12 md:tw-mb-0">
                        <button type="button" class="btn btn-primary" @click="removeRow(index)">Quitar</button>
                    </div>
                </div>
                <div class="FormSection">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                        <jet-label><span class="required">*</span>COMENTARIOS</jet-label>
                        <textarea name="" id="" cols="2" v-model="Sol.Comentarios" @input="(val) => (Sol.Comentarios = Sol.Comentarios.toUpperCase())" class="tw-bg-gray-200 tw-text-gray-500 tw-font-semibold focus:tw-outline-none focus:tw-shadow-outline tw-border tw-border-gray-300 tw-rounded-lg tw-py-2 tw-px-4 tw-block tw-w-full tw-appearance-none tw-shadow-sm"></textarea>
                    </div>
                </div>
            </div>

            <div class="ModalFooter">
                <jet-button type="button" @click="save(Sol)">Guardar</jet-button>
                <jet-CancelButton @click="chageClose">Cerrar</jet-CancelButton>
            </div>
        </modal>
        <!-- --------------------- Modal registrar Cotizacion -------------------------- -->
        <modal :show="showDetalle" @close="chageDetalle" maxWidth="3xl">
            <div class="ModalHeader">
                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>REQUISICIÓN RSIS-0{{form.Folio}}</h3>
            </div>

            <div class="ModalForm">
                <div class="FormSection">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label><span class="required">*</span>MONEDA</jet-label>
                        <select class="InputSelect" v-model="form.Moneda">
                            <option value="MXN">MXN</option>
                            <option value="USD">USD</option>
                            <option value="EUR">EUR</option>
                        </select>
                        <small v-if="errors.Moneda" class="validation-alert">{{errors.Moneda}}</small>
                    </div>
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0" v-if="form.Moneda == 'USD' || form.Moneda == 'EUR'">
                        <jet-label><span class="required">*</span>TIPO CAMBIO</jet-label>
                        <jet-input type="text"  v-model="form.TipoCambio"></jet-input>
                    </div>
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label><span class="required">*</span>TIPO PAGO</jet-label>
                        <select class="InputSelect" v-model="form.TipoPago">
                            <option value="REM">REMISIÓN</option>
                            <option value="FAC">FACTURADO</option>
                        </select>
                        <small v-if="errors.TipoPago" class="validation-alert">{{errors.TipoPago}}</small>
                    </div>
                    <div class="tw-px-3 tw-mb-6 md:tw-w-1/2 md:tw-mb-0">
                        <jet-label><span class="required">*</span>Proveedor</jet-label>
                        <select class="InputSelect" v-model="form.Proveedor_Sistemas_id">
                            <option v-for="prov in ProveedoresSistemas" :key="prov.id" :value="prov.id" > {{ prov.Nombre }}</option>
                        </select>
                        <small v-if="errors.Proveedor_Sistemas_id" class="validation-alert">{{errors.Proveedor_Sistemas_id}}</small>
                    </div>
                </div>
                <Table id="Articulos">
                    <template v-slot:TableHeader>
                        <th class="columna">CANTIDAD</th>
                        <th class="columna">UNIDAD</th>
                        <th class="columna">EQUIPO</th>
                        <th class="columna">PRECIO</th>
                        <th class="columna">MARCA EQUIPO</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila" v-for="match in form.DatosCotizacion" :key="match">
                            <td class="tw-text-center">{{match.Cantidad}}</td>
                            <td class="tw-text-center">{{match.Unidad}}</td>
                            <td class="tw-text-center">{{match.Dispositivo}} </td>
                            <td>
                                <input type="number" min="1" class="InputDinamico" v-model="match.PrecioUnitario">
                            </td>
                            <td>
                                <input type="text" class="InputDinamico" v-model="match.Marca" @input="(val) => (match.Marca = match.Marca.toUpperCase())">
                            </td>
                        </tr>
                    </template>
                </Table>
                <div class="FormSection">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                        <jet-label>costo extra</jet-label>
                        <input type="text"  class="InputDinamico" v-model="form.CostoExtra" @change="Moneda(form.CostoExtra)">
                    </div>
                </div>
                <div class="FormSection">
                    <div class="tw-px-3 tw-mb-6 md:tw-w-full md:tw-mb-0">
                        <jet-label>COMENTARIOS</jet-label>
                        <textarea name="" id="" cols="2" v-model="form.Comentario" @input="(val) => (form.Comentario = form.Comentario.toUpperCase())" class="tw-bg-gray-200 tw-text-gray-500 tw-font-semibold focus:tw-outline-none focus:tw-shadow-outline tw-border tw-border-gray-300 tw-rounded-lg tw-py-2 tw-px-4 tw-block tw-w-full tw-appearance-none tw-shadow-sm"></textarea>
                    </div>
                </div>
                <div class="FormSection">
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
                        <div v-if="form.archivo != null">
                            <!-- <iframe :src="path + form.archivo" title="description" ></iframe> -->
                            <span class="tw-text-green-600">{{form.archivo}}</span>
                        </div>

                    </div>
                </div>
            </div>

            <div class="ModalFooter">
                <jet-button type="button" @click="RealizaCotizacion(form)" v-show="!editMode" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Guardar</jet-button>
                <jet-button type="button" @click="EditaCotizacion(form)" v-show="editMode" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Actualizar</jet-button>
                <jet-CancelButton @click="chageDetalle">Cerrar</jet-CancelButton>
            </div>
        </modal>

        <modal :show="showCotizacion" @close="chageCotizacion" maxWidth="3xl">
            <div class="ModalHeader">
                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Cotización S-{{RequisicionSistemas.Folio}}</h3>
            </div>

            <div class="ModalForm">
                <p class="tw-text-center tw-p-2 tw-text-coolGray-400 tw-text-xs"> -- Requisición --</p>
                <Table>
                    <template v-slot:TableHeader>
                        <th class="columna">FECHA</th>
                        <th class="columna">SOLICITANTE</th>
                        <th class="columna">FOLIO</th>
                        <th class="columna">DEPARTAMENTO</th>
                        <th class="columna">COMENTARIOS</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila" >
                            <td class="tw-text-center">{{RequisicionSistemas.Fecha}}</td>
                            <td class="tw-text-center">{{RequisicionSistemas.perfil.Nombre}} {{RequisicionSistemas.perfil.ApPat}} {{RequisicionSistemas.perfil.ApMat}}</td>
                            <td class="tw-text-center">S-{{RequisicionSistemas.Folio}}</td>
                            <td class="tw-text-center">{{RequisicionSistemas.departamento.Nombre}}</td>
                            <td class="tw-text-center">{{RequisicionSistemas.Comentarios}}</td>
                        </tr>
                    </template>
                </Table>
                <div v-for="data in RequisicionSistemas.cotizacion" :key="data.id">
                    <p class="tw-text-center tw-p-2 tw-text-coolGray-400 tw-text-xs"> -- Cotización --</p>
                    <div :class="{'tw-p-2 tw-border-4 tw-border-teal-700 tw-bg-teal-600': data.Aprobado == 1}">
                        <Table>
                            <template v-slot:TableHeader>
                                <th class="columna">TIPO PAGO</th>
                                <th class="columna">MONEDA</th>
                                <th class="columna">TIPO CAMBIO</th>
                                <th class="columna">COSTO EXTRA</th>
                                <th class="columna">PROVEEDOR</th>
                                <th class="columna">ARCHIVO</th>
                                <th class="columna">APROVADO</th>
                                <th class="columna">COMENTARIOS</th>
                            </template>

                            <template v-slot:TableFooter>
                                <tr class="fila">
                                    <td class="tw-text-center">{{data.TipoPago}}</td>
                                    <td class="tw-text-center">{{data.Moneda}}</td>
                                    <td class="tw-text-center">${{data.TipoCambio}}</td>
                                    <td class="tw-text-center">${{data.CostoExtra}}</td>
                                    <td class="tw-text-center">{{data.proveedor.Nombre}}</td>
                                    <td class="tw-text-center">
                                        <div class="FlexCenter">
                                            <a target="_blank" :href="path + data.Archivo" style="color:black;">
                                                <i class="far fa-file-image"></i>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="FlexCenter">
                                            <div class="IconAproved"  v-if="data.Aprobado == 1">
                                                <span tooltip="APROBADO" flow="left">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="IconDenied" v-else>
                                                <span tooltip="DENEGADO" flow="left">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="tw-text-center">{{data.Comentario}}</td>
                                </tr>
                            </template>
                        </Table>

                        <Table>
                            <template v-slot:TableHeader>
                                <th class="columna">CANTIDAD</th>
                                <th class="columna">UNIDAD</th>
                                <th class="columna">DISPOSITIVO</th>
                                <th class="columna">MARCA</th>
                                <th class="columna">PRECIO</th>
                                <th class="columna">TOTAL</th>
                                <th class="columna">ACCIONES</th>
                            </template>

                            <template v-slot:TableFooter>
                                <tr class="fila" v-for="pre in data.precios" :key="pre.id">
                                    <td class="tw-text-center">{{pre.articulos.Cantidad}}</td>
                                    <td class="tw-text-center">{{pre.articulos.Unidad}}</td>
                                    <td class="tw-text-center">{{pre.articulos.Dispositivo}}</td>
                                    <td class="tw-text-center">{{pre.Marca}}</td>
                                    <td class="tw-text-center">${{pre.Precio}}</td>
                                    <td class="tw-text-center">${{pre.Total}}</td>
                                    <td>
                                        <div class="FlexCenter">
                                            <div class="iconoEdit" @click="edit(data)" v-if="Estatus == 2 || Estatus == 10">
                                                <span tooltip="Editar" flow="left">
                                                    <svg xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="IconProcess" v-if="Estatus >= 3 && Estatus < 10">
                                                <span tooltip="En proceso ..." flow="left">
                                                    <i class="fa-solid fa-spinner"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </Table>
                    </div>
                </div>
                <p class="tw-text-center tw-p-2 tw-text-coolGray-400 tw-text-xs"> -- Total de requisición --</p>
                <span class="tw-text-center tw-font-bold"> {{ TotalRequisicion }} </span>
            </div>

            <div class="ModalFooter">
                <jet-CancelButton @click="chageCotizacion">Cerrar</jet-CancelButton>
            </div>
        </modal>

        <!-- --- Modal de costos ---- -->
        <modal :show="showReporte" @close="chageReporte" :maxWidth="tam">
            <div class="ModalHeader">
                <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>COSTOS REQUISICIONES SISTEMAS</h3>
            </div>

            <div class="ModalForm">
                <Table id="datos">
                    <template v-slot:TableHeader>
                        <th class="columna">HILATURAS</th>
                        <th class="columna">HILESA</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr>
                            <td>
                                <span class="tw-tracking-wider tw-text-white tw-bg-blue-500 tw-px-4 tw-py-1 tw-text-sm tw-rounded tw-leading-loose tw-mx-2 tw-font-semibold" title="">
                                    <i class="fa-solid fa-money-bill"></i> Costo Anual Hilaturas ${{ Costos.CostoAnualHLA }}
                                </span>
                            </td>
                            <td>
                                <span class="tw-tracking-wider tw-text-white tw-bg-blue-500 tw-px-4 tw-py-1 tw-text-sm tw-rounded tw-leading-loose tw-mx-2 tw-font-semibold" title="">
                                    <i class="fa-solid fa-money-bill"></i> Costo Anual Hilesa ${{ Costos.CostoAnualHilesa }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="tw-tracking-wider tw-text-white tw-bg-blue-500 tw-px-4 tw-py-1 tw-text-sm tw-rounded tw-leading-loose tw-mx-2 tw-font-semibold" title="">
                                    <i class="fa-solid fa-money-bill"></i> Costo del Mes Hilaturas ${{ Costos.CostoMensualHLA }}
                                </span>
                            </td>
                            <td>
                                <span class="tw-tracking-wider tw-text-white tw-bg-blue-500 tw-px-4 tw-py-1 tw-text-sm tw-rounded tw-leading-loose tw-mx-2 tw-font-semibold" title="">
                                    <i class="fa-solid fa-money-bill"></i> Costo del Mes Hilesa ${{ Costos.CostoMensualHilesa }}
                                </span>
                            </td>
                        </tr>
                    </template>
                </Table>
                <div id="chart" class="tw-m-10"></div>
            </div>

            <div class="ModalFooter">
                <jet-CancelButton @click="chageReporte">Cerrar</jet-CancelButton>
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
import Select2 from 'vue3-select2-component';
//imports de datatables
import datatable from "datatables.net-bs5";
import $ from "jquery";
// Highcharts
var Highcharts = require('highcharts');
require('highcharts/modules/exporting')(Highcharts);
//Moment Js
import moment from 'moment';
import 'moment/locale/es';

export default {
    data() {
        return {
            now: moment().format("YYYY-MM-DD"),
            tam: "4xl",
            color: "tw-bg-sky-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            showDetalle: false,
            showCotizacion: false,
            showEdit: false,
            showReporte: false,
            Estatus: 0,
            form: {
                IdUser: this.Session.id,
                requisicion_sistemas_id: '',
                Cotizacion_id: '',
                Folio: '',
                Fecha: '',
                Departamento_id: '',
                Proveedor_Sistemas_id: '',
                CostoExtra: 0,
                Estatus: '',
                Moneda: '',
                TipoCambio: 1,
                TipoPago: '',
                Comentario: '',
                archivo: '',
                TotalRequisicion: 0,
                DatosCotizacion: [], //Arreglo vacio que contendra inputs dinamicos
            },
            Sol: {
                IdUser: this.Session.id,
                Fecha: '',
                Folio: '',
                Perfil_id: '',
                Departamento_id: '',
                Estatus: '',
                Partida: [{
                    Cantidad: '',
                    Unidad: '',
                    Dispositivo: '',
                }],
                requisicion_sistemas_id: '',
                Comentarios: '',
            },
            Costos:{
                CostoAnualHLA: 0,
                CostoMensualHLA: 0,
                CostoAnualHilesa: 0,
                CostoMensualHilesa: 0,
                HilesaAnual: 0,
                HilesaMensual: 0,
                HilaturaAnual: 0,
                HilaturaMensual: 0,
            },
        };
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
        Select2,
    },

    props: {
        Session: Object,
        errors: Object,
        Departamentos: Object,
        ProveedoresSistemas: Object,
        Perfiles: Object,
        RequisicionesSistemas: Object, //Consulta inicial
        RequisicionSistemas: Object, //Requisicion con Cotizacion
        Cotizacion: Object,
        CostosHLA: Object,
        CostosHilesa: Object,
        CostoAñoHLA: Object,
        CostoAñoHilesa: Object,
    },

    mounted() {
        this.tabla();
    },

    methods: {

        formatoMexico (number) {
            const exp = /(\d)(?=(\d{3})+(?!\d))/g;
            const rep = '$1,';
            let arr = number.toString().split('.');
            arr[0] = arr[0].replace(exp,rep);
            return arr[1] ? arr.join('.'): arr[0];
        },

        Moneda(data){
            // var moneda = new Intl.NumberFormat('es-MX', {style: 'currency',currency: 'MXN', minimumFractionDigits: 2}).format(data);
            // console.log(moneda);
            // console.log(this.form.CostoExtra);
            this.form.CostoExtra = this.formatoMexico(data);
        },
       //Generacion de Tabla con Datatables
        tabla(){
            this.$nextTick(() => {
                $("#Requisiciones").DataTable({
                    destroy: true,
                    stateSave: true,
                    language: this.español,
                    paging: true,
                    pageLength : 20,
                    scrollX: true,
                    scrollY:  '40vh',
                    order: [0, 'desc'],
                    columnDefs: [
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
                }).draw();
            });
        },

        reset() {
            this.form = {
                IdUser: this.Session.id,
                requisicion_sistemas_id: '',
                Cotizacion_id: '',
                Folio: '',
                Fecha: '',
                Departamento_id: '',
                Proveedor_Sistemas_id: '',
                CostoExtra: 0,
                Estatus: '',
                Moneda: '',
                TipoCambio: 1,
                TotalRequisicion: 0,
                TipoPago: '',
                Comentario: '',
                archivo: '',
                DatosCotizacion: [],
            };
            this.Sol= {
                IdUser: this.Session.id,
                Fecha: '',
                Folio: '',
                Perfil_id: '',
                Departamento_id: '',
                Estatus: '',
                Partida: [{
                    Cantidad: '',
                    Unidad: '',
                    Dispositivo: '',
                }],
                requisicion_sistemas_id: '',
                Comentarios: '',
            };
        },

        chageDetalle(){
            this.showDetalle  = !this.showDetalle;
        },

        addRow: function () { //Agregar Campos dinamicamente
            //Funcion para añadir inputs dinamicos
            this.Sol.Partida.push({Part: ""});
        },

        removeRow: function (row) { //Quitar Campos dinamicamente
            //Quitar del arreglo los inputs dinamicos
            this.Sol.Partida.splice(row,1);
        },

        save(data){ //Guardar Requisicion
            data.metodo = 1;
            data.Estatus = 0;
            this.$inertia.post("/Sistemas/CotizacionSistemas", data, {
                onSuccess: () => {
                    if(this.$attrs.jetstream.flash.type == 'Warning'){
                        this.alertInfo(this.$attrs.jetstream.flash.message);
                    }else{
                        this.alertSucces();
                        this.reset();
                        this.chageClose();
                    }
                },
            });
        },

        CotizarReq(data){ //GAsigna datos para realizar cotizacion
            this.reset();
            this.chageDetalle();
            this.form.requisicion_sistemas_id = data.id;
            this.form.Folio = data.Folio;
            this.form.Fecha = data.Fecha;
            this.form.Departamento_id = data.Departamento_id;
            this.ArticulosReq = data.articulos;
            this.form.Estatus = data.Estatus;
            // ----- Genracion de inputs dinamicos -----------
            this.form.DatosCotizacion = []; //Vacio arreglo de inputs
            data.articulos.forEach(Art => { //Generacion de inputs apartir del objeto a recorrer
                this.form.DatosCotizacion.push({ //Añado mas campos a visualizar
                    id: Art.id,
                    Cantidad: Art.Cantidad,
                    Unidad: Art.Unidad,
                    Dispositivo: Art.Dispositivo,
                    PrecioUnitario: null,
                    Marca: null,
                })
            })
        },

        RealizaCotizacion(data){ //Guarda la cotizacion realizada
            data.metodo = 2;
            this.$inertia.post("/Sistemas/CotizacionSistemas", data, {
                onSuccess: () => {
                    if(this.$attrs.jetstream.flash.type == 'Warning'){
                        this.alertInfo(this.$attrs.jetstream.flash.message);
                    }else{
                        this.alertSucces();
                        this.reset();
                        this.chageDetalle();
                    }
                },
            });
        },

        ConfirmaCotizacion(data){ //Envia la cotizacion para autorizacion
            data.Metodo = 1;
            data._method = "PUT";
            this.$inertia.post("/Sistemas/CotizacionSistemas/" + data.id, data, {
                onSuccess: () => {
                    this.reset();
                if(this.$attrs.jetstream.flash.type == 'Warning'){
                    this.alertInfo(this.$attrs.jetstream.flash.message);
                }else if(this.$attrs.jetstream.flash.type == 'Success'){
                    this.alertSuccess(this.$attrs.jetstream.flash.message);
                }
                },
            });
        },

        ConfirmaMaterial(data){ //Confirma que existe el material
            data.Metodo = 2;
            data._method = "PUT";
            this.$inertia.post("/Sistemas/CotizacionSistemas/" + data.id, data, {
                onSuccess: () => {
                    this.reset();
                    this.alertSucces();
                },
            });
        },

        chageCotizacion(){
            this.showCotizacion  = !this.showCotizacion;
        },

        VisualizaCotizacion(data){ //Visualiza los datos de la cotizacion
            let PreciosArticulos = 0;
            let CostoExtra = 0;
            let TotalRequisicion = 0;

            this.$inertia.get('/Sistemas/CotizacionSistemas', { Req: data.id }, { //envio de variables por url
            onSuccess: () => {
                this.RequisicionSistemas.cotizacion.forEach(e => {
                    CostoExtra = parseFloat(e.CostoExtra);
                    e.precios.forEach(pre => {
                        pre.Total = pre.Total.replace(/,/g, "");
                        var PreciosArt = parseFloat(pre.Total);
                        PreciosArticulos = PreciosArticulos + PreciosArt;
                    });
                });

                TotalRequisicion = PreciosArticulos + CostoExtra;
                this.TotalRequisicion = new Intl.NumberFormat('es-MX', {style: 'currency',currency: 'MXN', minimumFractionDigits: 2}).format(TotalRequisicion);
                this.chageCotizacion();
                this.Estatus = this.RequisicionSistemas.Estatus;
            }, preserveState: true })
        },

        edit(data){
            this.$inertia.get('/Sistemas/CotizacionSistemas', { Req: data.id }, { //envio de variables por url
            onSuccess: () => {
                this.editMode = true;
                this.chageDetalle();
                this.form.Moneda = this.Cotizacion.Moneda;
                this.form.TipoPago = this.Cotizacion.TipoPago;
                this.form.Proveedor_Sistemas_id = this.Cotizacion.Proveedor_Sistemas_id;
                this.form.CostoExtra = this.Cotizacion.CostoExtra;
                this.form.Archivo = this.Cotizacion.Archivo;
                this.form.Comentario = this.Cotizacion.Comentario;

                this.form.DatosCotizacion = []; //Vacio arreglo de inputs
                this.Cotizacion.precios.forEach(Pre => { //Generacion de inputs apartir del objeto a recorrer
                    this.form.DatosCotizacion.push({ //Añado mas campos a visualizar
                        Cot_id: Pre.id,
                        id: Pre.id,
                        Marca: Pre.Marca,
                        PrecioUnitario: Pre.Precio,
                        Cantidad: Pre.articulos.Cantidad,
                        Unidad: Pre.articulos.Unidad,
                        Dispositivo: Pre.articulos.Dispositivo
                    })
                })

            }, preserveState: true })
        },

        EditaCotizacion(data){ //Actualiza los datos de la cotizacion
            data.Metodo = 3;
            data._method = "PUT";
            this.$inertia.post("/Sistemas/CotizacionSistemas/" + data.id, data, {
                onSuccess: () => {
                    this.editMode = false;
                    this.chageDetalle();
                    this.reset();
                    this.alertSucces();
                },
            });
        },

        CambiarTipoPago(data){
            data.Metodo = 4;
            data._method = "PUT";
            this.$inertia.post("/Sistemas/CotizacionSistemas/" + data.id, data, {
                onSuccess: () => {
                    this.reset();
                    this.alertSucces();
                },
            });
        },

        chageReporte(){
            this.showReporte  = !this.showReporte;
        },

        openReportes(){ //Aabre modal de Costos
            this.chageReporte();
            this.$inertia.get('/Sistemas/CotizacionSistemas', this.params , { //envio de variables por url
                onSuccess: () => {
                    this.Suma();
                }, preserveState: true})
        },

        GraficaCostos(){ //Genera Grafica de highcharts
            //variables internas
            Highcharts.chart('chart', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Comparación de Costos'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name} {point.maq} {point.mate} {point.cat} {point.tr} {point.eq} {point.parti} {point.cl}</b>: {point.y} - {point.percentage:.1f}%'
                    }
                    }
                },
                series: [{
                    name: 'prpa',
                    colorByPoint: true,
                    data: [{
                        name: 'Hilaturas',
                        y: this.Costos.HilaturaMensual,
                        sliced: true,
                        selected: true
                    },{
                        name: 'Hilesa',
                        y: this.Costos.HilesaMensual
                    }]
                }]
            });
        },

        Suma() { //Realiza el calculo de costos por requisicion
            var Costo1 = 0;
            this.CostosHLA.forEach(e => { //Recorre el arreglo consultado
                Costo1 = e.CostoReq.replace(/,/g, ""); //Quita los caracteres no númericos de la cadena devuelta
                var CostosRequi = parseFloat(Costo1); //Convierte a numero la cadena procesada
                this.Costos.HilaturaMensual = this.Costos.HilaturaMensual + CostosRequi; //Calcula el total de las requisiciones
            });
            this.Costos.CostoMensualHLA = this.MonedaMexico(this.Costos.HilaturaMensual); //Convierte a formato moneda

            var Costo2 = 0;
            this.CostosHilesa.forEach(e => {
                Costo2 = e.CostoReq.replace(/,/g, "");
                var CostosRequi = parseFloat(Costo2);
                this.Costos.HilesaMensual = this.Costos.HilesaMensual + CostosRequi;
            });
            this.Costos.CostoMensualHilesa = this.MonedaMexico(this.Costos.HilesaMensual);

            var CostoAnio1 = 0;
            this.CostoAñoHLA.forEach(e => {
                CostoAnio1 = e.CostoReq.replace(/,/g, "");
                var CostosRequi = parseFloat(CostoAnio1);
                this.Costos.HilaturaAnual = this.Costos.HilaturaAnual + CostosRequi;
            });
            this.Costos.CostoAnualHLA = this.MonedaMexico(this.Costos.HilaturaAnual);

            var CostoAnio2 = 0;
            this.CostoAñoHilesa.forEach(e => {
                CostoAnio2 = e.CostoReq.replace(/,/g, "");
                var CostosRequi = parseFloat(CostoAnio2);
                this.Costos.HilesaAnual = this.Costos.HilesaAnual + CostosRequi;
            });
            this.Costos.CostoAnualHilesa = this.MonedaMexico(this.Costos.HilesaAnual);

            if(this.Costos.Hilesa != '' && this.Costos.Hilatura != ''){
                this.GraficaCostos();
            }
        },

        imprimir(data){
            console.log(data);
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
                        canvas.document.write('<div style="display:flex; flex-direction: column;">');
                            canvas.document.write('<div><span style="font-size:0.85rem;">SOLICITUD: &nbsp;<strong style="font-size:1.25rem;">'+' S-'+data.Folio+'</strong></span></div>');
                            canvas.document.write('<div><span style="font-size:0.85rem;">COSTO TOTAL: &nbsp;<strong style="font-size:1.25rem;">$'+data.CostoReq+'</strong></span></div>');
                        canvas.document.write('</div>');
                    canvas.document.write('</div>');

                    canvas.document.write('<div style="display:flex; flex-direction: row; justify-content: center; gap:5px;">');
                        canvas.document.write('<div style="padding: 3px; width:20%;"><span> <strong>FECHA: &nbsp;</strong>'+data.Fecha+'</span> </div>');
                        canvas.document.write('<div style="padding: 3px; width:35%;"><span> <strong>DEPARTAMENTO: &nbsp;</strong>'+data.departamento.Nombre+'</span> </div>');
                        canvas.document.write('<div style="padding: 3px; width:45%;"><span> <strong>SOLICITANTE: &nbsp;</strong>'+data.perfil.Nombre+' '+data.perfil.ApPat+' '+data.perfil.ApMat+'</span> </div>');
                    canvas.document.write('</div>');

                    data.cotizacion.forEach(e => {
                        canvas.document.write('<div style="display:flex; flex-direction: row; justify-content: center; gap:5px; margin-top: 2%;">');
                            canvas.document.write('<div style="padding: 3px; width:25%;"><span> <strong>TIPO PAGO: &nbsp;</strong>'+e.TipoPago+'</span> </div>');
                            canvas.document.write('<div style="padding: 3px; width:25%;"><span> <strong>MONEDA: &nbsp;</strong>'+e.Moneda+'</span> </div>');
                            canvas.document.write('<div style="padding: 3px; width:25%;"><span> <strong>TIPO CAMBIO: &nbsp;</strong>$'+e.TipoCambio+'</span> </div>');
                            canvas.document.write('<div style="padding: 3px; width:25%;"><span> <strong>COSTO EXTRA: &nbsp;</strong>$'+e.CostoExtra+'</span> </div>');
                        canvas.document.write('</div>');
                        canvas.document.write('<div style="display:flex; flex-direction: row; gap:5px; margin-top: 1%;">');
                            canvas.document.write('<div style="padding: 3px; width:50%;"><span> <strong>COMENTARIO COTIZACION: &nbsp;</strong>'+e.Comentario+'</span> </div>');
                            canvas.document.write('<div style="padding: 3px; width:50%;"><span> <strong>PROVEEDOR: &nbsp;</strong>'+e.proveedor.Nombre+'</span> </div>');
                        canvas.document.write('</div>');
                    });

                canvas.document.write('</div>');

                canvas.document.write('<div style="height: 60vh; width: 100%; border-bottom: 2px solid;">');
                    canvas.document.write('<div style="width: 100%; display: table; border-collapse: collapse; text-align: center; margin: 0 auto;">');
                        canvas.document.write('<div style="display: table-row; background: #ddd;">');
                            canvas.document.write('<div style="display: table-cell; vertical-align: middle; padding: 10px;">CANTIDAD</div>');
                            canvas.document.write('<div style="display: table-cell; vertical-align: middle; padding: 10px;">UNIDAD</div>');
                            canvas.document.write('<div style="display: table-cell; vertical-align: middle; padding: 10px;">ARTICULO</div>');
                            canvas.document.write('<div style="display: table-cell; vertical-align: middle; padding: 10px;">MARCA</div>');
                            canvas.document.write('<div style="display: table-cell; vertical-align: middle; padding: 10px;">PRECIO</div>');
                            canvas.document.write('<div style="display: table-cell; vertical-align: middle; padding: 10px;">TOTAL</div>');
                        canvas.document.write('</div>');

                        data.cotizacion.forEach(cot => {
                            cot.precios.forEach(pre => {
                                canvas.document.write('<div style="display: table-row;">');
                                    canvas.document.write('<div style="display: table-cell; vertical-align: middle; padding: 10px;">'+pre.articulos.Cantidad+'</div>');
                                    canvas.document.write('<div style="display: table-cell; vertical-align: middle; padding: 10px;">'+pre.articulos.Unidad+'</div>');
                                    canvas.document.write('<div style="display: table-cell; vertical-align: middle; padding: 10px;">'+pre.articulos.Dispositivo+'</div>');
                                    canvas.document.write('<div style="display: table-cell; vertical-align: middle; padding: 10px;">'+pre.Marca+'</div>');
                                    canvas.document.write('<div style="display: table-cell; vertical-align: middle; padding: 10px;">$'+pre.Precio+'</div>');
                                    canvas.document.write('<div style="display: table-cell; vertical-align: middle; padding: 10px;">$'+pre.Total+'</div>');
                                canvas.document.write('</div>');
                            });
                        });
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

    computed:{
        //Funcion de buscador
        BuscaPerfil: function () {
            const PerfilesUsu = [];
            this.Perfiles.forEach(element => {
                PerfilesUsu.push({id: element.id, text: element.IdEmp + '-'+ element.Nombre+' '+element.ApPat+' '+element.ApMat})
            });
            return PerfilesUsu;
        },

        //Funcion de buscador
        BuscaDepartamento: function () {
            const BusquedaSelect = [];
            this.Departamentos.forEach(element => {
                BusquedaSelect.push({id: element.id, text: element.Nombre})
            });
            return BusquedaSelect;
        },
    },

    watch: {
    },
};
</script>
