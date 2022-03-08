<template>
    <app-layout>
        <Header :class="['tw-bg-blue-600', 'tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl']">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-clipboard"></i>
                        Carga de objetivos
                </h3>
            </slot>
        </Header>
        <Accions>
            <template  v-slot:SelectB v-if="usuario.dep_pers.length != 1">
                <div class="sm:tw-flex tw-gap-3">
                    <select class="InputSelect sm:tw-w-full" v-model="S_Area">
                        <option value="" disabled>Selecciona un departamento</option>
                        <option v-for="o in opc" :key="o.value" :value="o.value">{{o.text}}</option>
                    </select>
                </div>
            </template>
            <template v-slot:BtnNuevo v-if="S_Area">
                <div class="md:tw-flex tw-gap-3">
                    <!-- BTN Paquetes de Coordiandor -->
                    <div class="tw-m-3">
                        <button class="btn btn-primary tw-w-full" type="button" data-bs-toggle="offcanvas" data-bs-target="#paqCor" aria-controls="paqCor" @click="resetOB()">Paquetes Objetivos</button>
                    </div>
                    <div class="tw-m-3" v-if="S_Area == 7">
                        <button class="btn btn-success tw-w-full" type="button" @click="openModal()">Carga objetivos</button>
                    </div>
                    <div class="tw-m-3" v-if="S_Area != 7">
                        <button class="btn btn-success tw-w-full" type="button" @click="openModal2()">Carga objetivos</button>
                    </div>
                </div>
            </template>
        </Accions>

        <!------------------------------------ Data table de carga ------------------------------------------------------->
        <div class="tw-m-auto" style="width: 98%">
            <Table id="t_carg">
                <template v-slot:TableHeader>
                    <th class="columna">Índice</th>
                    <th class="columna">Fecha</th>
                    <th class="columna">Nombre</th>
                    <th class="columna">Departamento</th>
                    <th class="columna">Proceso</th>
                    <th class="columna">Estatus</th>
                    <th class="columna">Equipo</th>
                    <th class="columna">Turno</th>
                    <th class="columna">Partida</th>
                    <th class="columna">Norma</th>
                    <th class="columna">Clave</th>
                    <th class="columna">Descripción de clave</th>
                    <th class="columna">Maquina</th>
                    <th class="columna">KG</th>
                    <th></th>
                </template>
                <template v-slot:TableFooter >
                    <tr v-for="ca in cargas" :key="ca.id"  class="fila">
                        <td class="tw-text-center"> {{ ca.id }} </td>
                        <td>{{ca.fecha}}</td>
                        <td class="">{{ca.dep_perf == null ? 'N/A' : ca.dep_perf.perfiles.Nombre}} {{ca.dep_perf == null ? 'N/A' : ca.dep_perf.perfiles.ApPat}} {{ca.dep_perf == null ? 'N/A' : ca.dep_perf.perfiles.ApMat}}</td>
                        <td class="">{{ca.dep_perf == null ? 'N/A' : ca.dep_perf.departamentos.Nombre}}</td>
                        <td class="">{{ca.proceso.nompro}}</td>
                        <td class=" tw-w-40">
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-emerald-600 tw-rounded-full" v-if="ca.notaPen == 2 & ca.proceso.tipo == 2">NOTA COORDINADOR</div>
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-cyan-600 tw-rounded-full" v-else-if="ca.notaPen == 2 & (ca.dep_perf.ope_puesto == 'ope' | ca.dep_perf.ope_puesto == 'lid')">NOTA OPERADOR</div>
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-coolGray-600 tw-rounded-full" v-if="ca.notaPen == 1 & ca.notas.length <= 1">SIN NOTA</div>
                            <div class="tw-inline-flex tw-items-center tw-justify-center tw-h-6 tw-px-3 tw-text-white tw-w-full tw-bg-blue-600 tw-rounded-full" v-if="ca.notaPen == 1 & ca.notas.length > 1">ACTUALIZADO</div>
                        </td>
                        <td class="">{{ca.equipo == null ? 'N/A' : ca.equipo.nombre}}</td>
                        <td class="">{{ca.turno == null ? 'N/A' : ca.turno.nomtur}}</td>
                        <td class="">{{ca.partida == null ? 'N/A' : ca.partida}}</td>
                        <td class="">{{ca.dep_mat == null ? 'N/A' : ca.dep_mat.materiales.idmat+' - '+ca.dep_mat.materiales.nommat}}</td>
                        <td class="">{{ca.clave == null ? 'N/A' : ca.clave.CVE_ART}}</td>
                        <td class="">{{ca.clave == null ? 'N/A' : ca.clave.DESCR}}</td>
                        <td class="">{{ca.maq_pro == null ? 'N/A' : ca.maq_pro.maquinas.Nombre}}</td>
                        <td class="">{{ca.valor}}</td>
                        <td class="">
                            <div class="columnaIconos">
                                <!-- nota objetivos -->
                                <a class="iconoDetails tw-cursor-pointer" href="#agPer" @click="notaOB(ca)" v-show="usuario.dep_pers.length != 0 & (ca.proceso.tipo == 2 & ca.notaPen == 1)">
                                    <span tooltip="Agregar nota" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </td>
                    </tr>
                </template>
                <template v-slot:Foother>
                    <th class="columna">Índice</th>
                    <th class="columna">Fecha</th>
                    <th class="columna">Nombre</th>
                    <th class="columna">Departamento</th>
                    <th class="columna">Proceso</th>
                    <th class="columna">Estatus</th>
                    <th class="columna">Equipo</th>
                    <th class="columna">Turno</th>
                    <th class="columna">Partida</th>
                    <th class="columna">Norma</th>
                    <th class="columna">Clave</th>
                    <th class="columna">Descripción de clave</th>
                    <th class="columna">Maquina</th>
                    <th class="columna">KG</th>
                    <th></th>
                </template>
            </Table>
        </div>

        <!------------------------------------- Carga de paquetes Objetivos -------------------------------->
        <div class="offcanvas offcanvas-bottom tw-h-3/4" data-bs-scroll="true" tabindex="-1" id="paqCor" aria-labelledby="paqCorLabel">
            <div class="offcanvas-header tw-bg-blue-700">
                <h3 class="offcanvas-title tw-text-xl tw-text-blueGray-50" id="offcanvasBottomLabel">Paquetes para coordinador</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <!-- Body -->
            <div class="offcanvas-body small" >
                <div id="Fobje"></div>
                <!----------------------------- Formulario para coordinador ------------------------------------------->
                <div class="m-5 tw-p-6 tw-bg-blue-600 tw-rounded-3xl tw-shadow-xl">
                    <div class="tw-mb-6 lg:tw-flex">
                        <!-- Select proceso principal -->
                        <div class="tw-px-3 tw-mb-6 lg:tw-w-1/6 lg:tw-mb-0">
                            <jet-label class="tw-text-white"><span class="required">*</span>Proceso proncipal</jet-label>
                            <select class="InputSelect" v-model="proc_prin">
                                <option value="" disabled>SELECCIONA</option>
                                <option v-for="pp in opcPPO" :key="pp" :value="pp.value" >{{pp.text}}</option>
                            </select>
                            <small v-if="errors.proc_prin" class="validation-alert">{{errors.proc_prin}}</small>
                        </div>
                        <!-- select Sub proceso -->
                        <div class="tw-px-3 tw-mb-6 lg:tw-w-1/6 lg:tw-mb-0" v-if="opcSP">
                            <jet-label class="tw-text-white"><span class="required">*</span>Sub proceso </jet-label>
                            <select class="InputSelect" v-model="formObje.proceso_id">
                                <option value="" disabled>SELECCIONA</option>
                                <option v-for="sp in opcSP" :key="sp" :value="sp.id">{{sp.text}}</option>
                            </select>
                            <small v-if="errors.proceso_id" class="validation-alert">{{errors.proceso_id}}</small>
                        </div>
                        <!-- select Maquinas -->
                        <div class="tw-px-3 tw-mb-6 lg:tw-w-1/6 lg:tw-mb-0">
                            <jet-label class="tw-text-white"><span class="required">*</span>Maquinas</jet-label>
                            <select class="InputSelect" v-model="formObje.maq_pro_id" :disabled="editMode">
                                <option value="" disabled>SELECCIONA</option>
                                <option v-for="mq in opcMQO" :key="mq.value" :value="mq.value">{{mq.text}}</option>
                            </select>
                            <small v-if="errors.maq_pro_id" class="validation-alert">{{errors.maq_pro_id}}</small>
                        </div>
                        <!-- Select Normas -->
                        <div class="tw-px-3 tw-mb-6 lg:tw-w-1/6 lg:tw-mb-0">
                            <jet-label class="tw-text-white"><span class="required">*</span>Norma</jet-label>
                            <select class="InputSelect" v-model="formObje.norma" :disabled="editMode">
                                <option value="" disabled>SELECCIONA</option>
                                <option v-for="nm in opcNM" :key="nm" :value="nm.value">{{nm.text}}</option>
                            </select>
                            <small v-if="errors.norma" class="validation-alert">{{errors.norma}}</small>
                        </div>
                        <!-- select Clave -->
                        <div class="tw-px-3 tw-mb-6 lg:tw-w-1/6 lg:tw-mb-0" v-if="S_Area == 7">
                            <jet-label class="tw-text-white"><span class="required">*</span>Clave</jet-label>
                            <Select2 v-model="formObje.clave_id" class="InputSelect tw-w-full" style="z-index: 1500" :settings="{width: '100%', allowClear: true}" :options="opcCLO" />
                            <small v-if="errors.clave_id" class="validation-alert">{{errors.clave_id}}</small>
                        </div>
                        <!-- input produccion -->
                        <div class="tw-px-3 tw-mb-6 lg:tw-w-1/6 lg:tw-mb-0">
                            <jet-label class="tw-text-white"><span class="required">*</span>Produccion por hora</jet-label>
                            <jet-input type="number" v-model="formObje.pro_hora"></jet-input>
                            <small v-if="errors.pro_hora" class="validation-alert">{{errors.pro_hora}}</small>
                        </div>
                    </div>
                    <!-- Botones -->
                    <div class="w-100 tw-mx-auto tw-gap-4 tw-flex tw-justify-center">
                        <div v-if="btnOff & !editModeOB">
                            <button type="button" class="btn btn-success" @click="savePObje(formObje)">Guardar</button>
                            <!-- <jet-button type="button" @click="savePObje(form)">Guardar</jet-button> -->
                        </div>
                        <div v-if="btnOff & editModeOB">
                            <button type="button" class="btn btn-success" @click="updateOB(formObje)">Actualizar</button>
                            <!-- <jet-button type="button" @click="savePObje(form)">Guardar</jet-button> -->
                        </div>
                        <div v-show="!btnOff">
                            <button type="button" class="btn btn-success tw-mx-auto" disabled>
                                <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                Guardando...
                            </button>
                        </div>
                    </div>
                </div>
                <!----------------------------- Data Table ------------------------------------------------------------>
                <div>
                    <TableBlue id="t_ob" style="width:100%">
                        <template v-slot:TableHeader>
                            <th class="columna">Índice</th>
                            <th class="columna tw-text-center">Proceso</th>
                            <th class="columna tw-text-center">Maquina</th>
                            <th class="columna tw-text-center">Norma</th>
                            <th class="columna tw-text-center">Clave</th>
                            <th class="columna tw-text-center">Producción/Hora</th>
                            <th class="columna tw-text-center"></th>
                        </template>
                        <template v-slot:TableFooter>
                            <tr class="fila" v-for="obje in objetivos" :key="obje.id">
                                <td class="tw-text-center"> {{ obje.id }} </td>
                                <td class="tw-text-center"> {{ obje.proceso.nompro }} </td>
                                <td class="tw-text-center"> {{ obje.maq_pro.maquinas.Nombre }} {{ obje.maq_pro.maquinas.marca.Nombre }} </td>
                                <td class="tw-text-center"> {{ obje.dep_mat.materiales.idmat }} - {{ obje.dep_mat.materiales.nommat }} </td>
                                <td class="tw-text-center"> {{ obje.clave_id == null ? '' : obje.clave.CVE_ART }} - {{ obje.clave_id == null ? '' : obje.clave.DESCR }} </td>
                                <td class="tw-text-center"> {{ obje.pro_hora }} </td>
                                <td class="tw-text-center">
                                    <div class="columnaIconos" v-if="this.usuario.dep_pers.length == 0">
                                        <!-- editar objetivos -->
                                        <a class="iconoEdit" @click="editOB(obje)" href="#Fobje">
                                            <span tooltip="Editar" flow="left">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </span>
                                        </a>
                                        <div class="iconoDelete" @click="deleteOB(obje)">
                                            <span tooltip="Eliminar" flow="left">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </TableBlue>
                </div>
            </div>
        </div>

        <!-- abrir modal de carga de objetivos Apertura -->
        <modal :show="showModal" @close="chageClose" maxWidth="5xl">
            <div class="tw-px-4 tw-py-4">
                <div class="tw-text-lg">
                    <div class="ModalHeader">
                        <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Carga de Objetivos</h3>
                    </div>
                </div>
                <div class="tw-mt-4">
                    <div class="ModalForm">
                        <!-- Formulas -->
                        <div class="tw-mb-6 lg:tw-flex">
                            <!-- Fecha -->
                            <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                                <!--  :min="hoy" -->
                                <jet-label class=""><span class="required">*</span>Fecha</jet-label>
                                <input type="datetime-local" class="InputSelect" v-model="form.fecha" :min="hoy" :max="treDia">
                                <small v-if="errors.fecha" class="validation-alert">{{errors.fecha}}</small>
                            </div>
                            <!-- select turno -->
                            <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0" >
                                <jet-label class=""><span class="required">*</span>Turnos</jet-label>
                                <select class="InputSelect" v-model="form.turno_id">
                                    <option value="" disabled>SELECCIONA</option>
                                    <option v-for="tu in opcTur" :key="tu.value" :value="tu.value">{{tu.text}}</option>
                                </select>
                                <small v-if="errors.turno_id" class="validation-alert">{{errors.turno_id}}</small>
                            </div>
                            <!-- select equipo -->
                            <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                                <jet-label class=""><span class="required">*</span>Equipo</jet-label>
                                <select class="InputSelect" v-model="form.equipo_id">
                                    <option value="" disabled>SELECCIONA</option>
                                    <option v-for="eq in opcEqu" :key="eq.value" :value="eq.value">{{eq.text}}</option>
                                </select>
                                <small v-if="errors.equipo_id" class="validation-alert">{{errors.equipo_id}}</small>
                            </div>
                        </div>
                        <div class="tw-mb-6 lg:tw-flex">
                            <!-- select operador -->
                            <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0" v-if="usuario.dep_pers.length == 0">
                                <jet-label class=""><span class="required">*</span>Operador</jet-label>
                                <select class="InputSelect" @change="eq_tu" v-model="form.dep_perf_id">
                                    <option value="" disabled>SELECCIONA</option>
                                    <option v-for="pe in opcPE" :key="pe" :value="pe.value">{{pe.text}}</option>
                                </select>
                                <small v-if="errors.dep_perf_id" class="validation-alert">{{errors.dep_perf_id}}</small>
                            </div>

                            <!-- boton para agregar maquinas -->
                            <div class="tw-flex tw-justify-center tw-w-full">
                                <button type="button" class="btn btn-info tw-w-1/3 " @click="addRow()">Agregar Nuevo Objetivo</button>
                            </div>
                        </div>
                        <div>
                            <!-- recorrido para carga de objetivos -->
                            <div class="tw-overflow-auto" style="height: 30rem">
                                <div v-for="(f, index) in form.paquet" :key="index" class="tw-m-5 tw-border tw-border-4 tw-border-gray-600 tw-rounded-md tw-p-5" >
                                    <div class="lg:tw-flex">
                                        <!-- paquete de objetivos -->
                                        <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                                            <jet-label class=""><span class="required">*</span>Paquete Objetivos</jet-label>
                                            <Select2 v-model="f.paqObjetivo" class="InputSelect" @select="calObje(f)" :settings="{width: '100%'}" :options="opcPaOb"/>
                                        </div>
                                        <!-- tiempo -->
                                        <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0">
                                            <jet-label class=""><span class="required">*</span>Horas a trabajar</jet-label>
                                            <jet-input v-model="f.calcuObje" @change="inputHoraObje(f)" type="number" min="0" max="12" step=".5"></jet-input>
                                        </div>
                                        <!-- tiempo punta -->
                                        <div class="tw-px-3 tw-mb-6 lg:tw-w-1/4 lg:tw-mb-0" v-show="S_Area == 7">
                                            <jet-label class=""><span class="required">*</span>Horas a trabajar punta</jet-label>
                                            <jet-input v-model="f.calcuPunta" @change="inputHoraPunta(f)" type="number" min="0" max="12" step=".5"></jet-input>
                                        </div>
                                    </div>
                                    <div class="lg:tw-flex">
                                        <!-- Input partida -->
                                        <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                                            <jet-label class=""><span class="required">*</span>Partida</jet-label>
                                            <jet-input class="InputSelect" v-model="f.partida" @input="(val) => (f.partida = f.partida.toUpperCase())"></jet-input>
                                        </div>
                                        <!-- Input kilogramos -->
                                        <div class="tw-px-3 tw-mb-6 tw-w-full lg:tw-w-1/4 lg:tw-mb-0">
                                            <jet-label class=""><span class="required">*</span>Producción horas laborales</jet-label>
                                            <jet-input type="number" min="0" class="InputSelect tw-bg-lime-300" v-model="f.valor" disabled></jet-input>
                                        </div>
                                        <!-- Input kilogramos punta -->
                                        <div class="tw-px-3 tw-mb-6 tw-w-full lg:tw-w-1/4 lg:tw-mb-0" v-show="S_Area == 7">
                                            <jet-label class=""><span class="required">*</span>Producción horario punta</jet-label>
                                            <jet-input type="number" min="0" class="InputSelect tw-bg-lime-300" v-model="f.valorP" disabled></jet-input>
                                        </div>
                                    </div>
                                    <div class="lg:tw-flex tw-mt-5">
                                        <div class="tw-m-auto">
                                            <button class="btn btn-block btn-outline-danger" @click="removeRow(index)">Quitar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="m-auto">
                            <button class="btn btn-success" @click="saveOB(form)">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </modal>

        <!-- abrir modal de carga de objetivos -->
        <modal :show="showModal2" @close="chageClose2" maxWidth="5xl">
            <div class="tw-px-4 tw-py-4">
                <div class="tw-text-lg">
                    <div class="ModalHeader">
                        <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Carga de Objetivos</h3>
                    </div>
                </div>
                <div class="tw-mt-4">
                    <div class="ModalForm">
                        <!-- Formulas -->
                        <div class="tw-mb-6 lg:tw-flex">
                            <!-- Fecha -->
                            <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                                <jet-label class=""><span class="required">*</span>Fecha</jet-label>
                                <input type="datetime-local" class="InputSelect" v-model="form2.fecha" :min="hoy" :max="treDia">
                                <small v-if="errors.fecha" class="validation-alert">{{errors.fecha}}</small>
                            </div>
                            <!-- select turno -->
                            <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0" >
                                <jet-label class=""><span class="required">*</span>Turnos</jet-label>
                                <select class="InputSelect" v-model="form2.turno_id">
                                    <option value="" disabled>SELECCIONA</option>
                                    <option v-for="tu in opcTur" :key="tu.value" :value="tu.value">{{tu.text}}</option>
                                </select>
                                <small v-if="errors.turno_id" class="validation-alert">{{errors.turno_id}}</small>
                            </div>
                            <!-- select equipo -->
                            <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                                <jet-label class=""><span class="required">*</span>Equipo</jet-label>
                                <select class="InputSelect" v-model="form2.equipo_id">
                                    <option value="" disabled>SELECCIONA</option>
                                    <option v-for="eq in opcEqu" :key="eq.value" :value="eq.value">{{eq.text}}</option>
                                </select>
                                <small v-if="errors.equipo_id" class="validation-alert">{{errors.equipo_id}}</small>
                            </div>
                        </div>
                        <div class="tw-mb-6 lg:tw-flex">
                            <!-- select operador -->
                            <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0" v-if="usuario.dep_pers.length == 0">
                                <jet-label class=""><span class="required">*</span>Operador</jet-label>
                                <select class="InputSelect" @change="eq_tu" v-model="form2.dep_perf_id">
                                    <option value="" disabled>SELECCIONA</option>
                                    <option v-for="pe in opcPE" :key="pe" :value="pe.value">{{pe.text}}</option>
                                </select>
                                <small v-if="errors.dep_perf_id" class="validation-alert">{{errors.dep_perf_id}}</small>
                            </div>
                        </div>
                        <div>
                            <!-- boton para agregar maquinas -->
                            <div class="tw-flex tw-justify-center">
                                <button type="button" class="btn btn-info tw-w-1/3 " @click="addRow2()">Agregar Nuevo Objetivo</button>
                            </div>
                            <!-- recorrido para carga de objetivos -->
                            <div class="tw-overflow-auto" style="height: 30rem">
                                <div v-for="(f, index) in form2.paquet" :key="index" class="tw-m-5 tw-border tw-border-4 tw-border-gray-600 tw-rounded-md tw-p-5" >
                                    <div class="lg:tw-flex">
                                        <!-- paquete de objetivos -->
                                        <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                                            <jet-label class=""><span class="required">*</span>Paquete Objetivos</jet-label>
                                            <Select2 v-model="f.paqObjetivo" class="InputSelect" @select="calObje2(f)" :settings="{width: '100%'}" :options="opcPaOb"/>
                                        </div>
                                        <!-- Claves -->
                                        <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                                            <jet-label class=""><span class="required">*</span>Claves</jet-label>
                                            <Select2 v-model="f.clave_id" class="InputSelect tw-w-full" style="z-index: 1500" :settings="{width: '100%', allowClear: true}" :options="recoClave(f.paqObjetivo)" />
                                        </div>
                                    </div>
                                    <div class="lg:tw-flex">
                                        <!-- Input partida -->
                                        <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                                            <jet-label class=""><span class="required">*</span>Partida</jet-label>
                                            <jet-input class="InputSelect" v-model="f.partida" @input="(val) => (f.partida = f.partida.toUpperCase())"></jet-input>
                                        </div>
                                        <!-- tiempo -->
                                        <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                                            <jet-label class=""><span class="required">*</span>Horas a trabajar</jet-label>
                                            <jet-input v-model="f.calcuObje2" @change="inputHoraObjeGene(f)" type="number" min="0" max="12" step=".5"></jet-input>
                                        </div>
                                        <!-- Input kilogramos -->
                                        <div class="tw-px-3 tw-mb-6 tw-w-full lg:tw-w-1/3 lg:tw-mb-0">
                                            <jet-label class=""><span class="required">*</span>Producción horas laborales</jet-label>
                                            <jet-input type="number" min="0" class="InputSelect tw-bg-lime-300" v-model="f.valor" disabled></jet-input>
                                        </div>
                                        <div class="tw-m-auto">
                                            <button class="btn btn-block btn-outline-danger" @click="removeRow2(index)">Quitar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="m-auto">
                            <button class="btn btn-success" @click="saveOB2(form2)">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </modal>
    </app-layout>
</template>
<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Header from '@/Components/Header'
    import Accions from '@/Components/Accions'
    import Table from '@/Components/Table';
    import TableBlue from '@/Components/TableBlue';
    import Modal from '@/Jetstream/Modal';
    import JetButton from '@/Components/Button';
    import JetCancelButton from '@/Components/CancelButton';
    import JetInput from '@/Components/Input';
    import JetLabel from '@/Jetstream/Label';
    import Select2 from 'vue3-select2-component';
    import moment from 'moment';
    import 'moment/locale/es';
    import ActionMessage from '@/Components/ActionMessage'
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
    import axios from 'axios';

    pdfMake.vfs = pdfFonts.pdfMake.vfs;
    window.JSZip = jszip;

    var Highcharts = require('highcharts');
    // Load module after Highcharts is loaded
    require('highcharts/modules/exporting')(Highcharts);
    export default {
        props: [
            'usuario',
            'depa'
        ],

        components: {
            AppLayout,
            Header,
            Accions,
            Table,
            TableBlue,
            JetButton,
            JetInput,
            Modal,
            Select2,
            JetLabel,
            ActionMessage,
            JetCancelButton
        },

        data() {
            return {
                S_Area: '',
                personal: [],
                turnos: [],
                procesos: [],
                materiales: [],
                objetivos: [],
                cargas: [],
                errors: [],
                proc_prin: '',
                editMode: false,
                editModeOB: false,
                showModal: false,
                showModal2: false,
                limp: 1,
                paqObjetivo: '',
                btnOff: true,
                hoy: moment().format('YYYY-MM-DD[T]HH:mm:ss'),
                treDia: moment().add(3, 'days').format('YYYY-MM-DD[T]HH:mm:ss'),
                form: {
                    id: null,
                    fecha: null,
                    semana: null,
                    departamento_id: this.S_Area,
                    usu: this.usuario.id,
                    per_carga: this.usuario.id,
                    dep_perf_id: '',
                    equipo_id: '',
                    paquet: [{ paqObjetivo: "", calcuObje: 0, calcuPunta: 12, valor: 0, valorP: 0, partida: null }],
                    turno_id: '',
                    notaPen: 1,
                    nota: '',
                    agNot: 0,
                },
                form2: {
                    id: null,
                    fecha: null,
                    semana: null,
                    departamento_id: this.S_Area,
                    usu: this.usuario.id,
                    per_carga: this.usuario.id,
                    dep_perf_id: '',
                    equipo_id: '',
                    turno_id: '',
                    notaPen: 1,
                    nota: '',
                    agNot: 0,
                    paquet: [{ paqObjetivo: "", calcuObje2: 0, clave_id: "", valor: 0, valorP: 0, partida: null }],
                },
                formObje:{
                    id: null,
                    departamento_id: this.S_Area,
                    proceso_id: '',
                    maq_pro_id: '',
                    norma: '',
                    clave_id: '',
                    pro_hora: null
                },
            }
        },

        mounted() {
            this.global();
        },

        methods: {
            /******************************** Consuta de objetivos ***************************/
            //consulta de carga de objetivos
            async ConProduccion(){
                var datos = {'departamento_id': this.S_Area, 'modulo': 'carPro'};

                $('#t_carg').DataTable().clear();
                let ve = await axios.post('Carga/CarProdu', datos)//.then((eve) => {ve = eve.data});
                //console.log(ve.data)
                ve.data.forEach(ca => {
                    if (ca.dep_perf != null){
                        if (ca.proceso.tipo == 2) {
                            this.cargas.push(ca);
                        }
                    }
                })

                $('#t_carg').DataTable().destroy();
                this.tabla()
            },
            //consulta de paquetes objetivos
            async ConObjeti(lim = false){
                var datos = {'departamento_id': this.S_Area, 'modulo': 'carPro'};
                if (lim) {
                    $('#t_ob').DataTable().clear();
                }
                let ve = await axios.post('Carga/CarObje', datos);
                //console.log(ve.data)
                this.objetivos = ve.data;

                $('#t_ob').DataTable().destroy();
                this.tablaObje()
            },
            /****************************** Globales **********************************************************/
            global(){
                if (this.usuario.dep_pers.length == 0) {
                    this.S_Area = 7;
                }else{
                    //Asigna el primer departamento
                    this.S_Area = this.usuario.dep_pers[0].departamento_id;

                }
            },
            /****************************** datatables ********************************************************/
            //datatable de carga
            tabla() {
                this.$nextTick(() => {
                    // Setup - add a text input to each footer cell
                    $('#t_carg tfoot th').each( function () {
                        var title = $(this).text();
                        $(this).html( '<input type="text" class="InputSelect tw-text-gray-900" placeholder="'+title+'" />' );
                    } );
                    $('#t_carg').DataTable({
                        "language": this.español,
                        "order": [[5, 'asc'], [1, 'desc']],
                        "scrollX": true,
                        "dom": '<"row"<"col-sm-6 col-md-9"l><"col-sm-12 col-md-3"f>>'+
                                "<'row'<'col-sm-12'tr>>" +
                                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                        scrollY:        '50vh',
                        scrollCollapse: true,
                        paging:         false,
                        buttons: [
                            {
                                extend: 'copyHtml5',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
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
                        ],
                        initComplete: function () {
                            // Apply the search
                            this.api().columns().every( function () {
                                var that = this;

                                $( 'input', this.footer() ).on( 'keyup change clear', function () {
                                    if ( that.search() !== this.value ) {
                                        that
                                            .search( this.value )
                                            .draw();
                                    }
                                } );
                            } );
                        },
                    })
                })
            },
            //Datattable de objetivos para coordinador
            tablaObje() {
                this.$nextTick(() => {
                    $('#t_ob').DataTable( {
                        "language": this.español,
                        "scrollX": true,
                        scrollY: '50vh',
                        scrollCollapse: true,
                        paging: false
                    } );
                })
            },
            /****************************** Selects de muestra ************************************************/
            //equipo y turno
            eq_tu(event){
                this.personal.forEach(sp => {
                    if (sp.id == event.target.value) {
                        /* console.log(sp) */
                        this.form.equipo_id = sp.equipo == null ? '' : sp.equipo.id;
                        this.form.turno_id = sp.equipo == null ? '' : sp.equipo.turno_id;
                    }
                })
            },
            /************************************* Opciones modal Apertura *******************************************/
            //calcula los objetivos select paquetes
            calObje(caO){
                this.limp = 2;
                const resu = this.objetivos.find(obje => obje.id == caO.paqObjetivo);
                caO.valor = resu.pro_hora * caO.calcuObje;
                caO.valorP = resu.pro_hora * (parseFloat(caO.calcuObje, 10) + parseFloat(caO.calcuPunta, 10));
            },
            //horarios apertura
            inputHoraObje(obje){
                obje.calcuPunta = 12 - parseFloat(obje.calcuObje, 10);
                if(obje.calcuObje <= 0 || obje.calcuObje > 12){
                    obje.calcuObje = 0;
                    obje.calcuPunta = 12
                }
                if(obje.paqObjetivo){
                    const resu = this.objetivos.find(obj => obj.id == obje.paqObjetivo);
                    obje.valor = resu.pro_hora * parseFloat(obje.calcuObje, 10)
                    obje.valorP = resu.pro_hora * (parseFloat(obje.calcuObje, 10) + parseFloat(obje.calcuPunta, 10));
                }
            },
            //horario externo punta
            inputHoraPunta(pun){
                let nu = 12 - pun.calcuObje;
                if (pun.calcuPunta < 0 || pun.calcuPunta > nu) {
                    pun.calcuObje = 0;
                    pun.calcuPunta = nu;
                }
                //console.log(pun)
                if(pun.paqObjetivo){
                    const resu = this.objetivos.find(obj => obj.id == pun.paqObjetivo);
                    pun.valor = resu.pro_hora * parseFloat(pun.calcuObje, 10);
                    pun.valorP = resu.pro_hora * (parseFloat(pun.calcuObje, 10) + parseFloat(pun.calcuPunta, 10));
                }
            },
            //Horarios generales
            inputHoraObjeGene(obje){
                if (obje.calcuObje2 <= 0 || obje.calcuObje2 > 12) {
                    obje.calcuObje2 = 0;
                }
                //console.log(obje)
                if(obje.paqObjetivo){
                    const resu = this.objetivos.find(obj => obj.id == obje.paqObjetivo);
                    obje.valor = resu.pro_hora * parseFloat(obje.calcuObje2, 10)
                }
            },
            //abrir modal
            openModal(){
                this.chageClose();
                this.resetCO();
            },
            chageClose(){
                this.showModal = !this.showModal;
            },
            resetCO(){
                this.limp = 1;
                this.calcuObje = 0;
                this.calcuPunta = 12;
                this.paqObjetivo = '';
                this.paqOpera = '';
                this.paqNorma = '';
                this.proc_prin = '';
                this.editMode = false;
                this.form.fecha = this.hoy;
                this.form.agNot = 0;
                this.form.notaPen = 1;
                this.form.nota = '';
                this.form.usu = this.usuario.id;
                this.form.departamento_id = this.S_Area;
                this.form.paquet = [{ paqObjetivo: "", calcuObje: 0, calcuPunta: 12, valor: 0, valorP: 0, partida: null }]
                this.errors = [];

                if (this.usuario.dep_pers.length != 0) {
                    this.usuario.dep_pers.forEach(v => {
                        if (v.departamento_id = this.S_Area) {
                            this.form.dep_perf_id = v.id != null ? v.id : null;
                            this.form.turno_id = v.equipo_id != null ? v.equipo.turno_id : '';
                            this.form.equipo_id = v.equipo_id != null ? v.equipo_id : '';
                        }
                    })
                }else{
                    this.form.dep_perf_id = null;
                    this.form.turno_id = '';
                    this.form.equipo_id = '';
                }
            },
            addRow(){
                this.form.paquet.push({paqObjetivo: '', calcuObje: 0, calcuPunta: 12, valor: 0, valorP: 0, partida: null})
            },
            removeRow(row){
                this.form.paquet.splice(row,1);
            },
            /************************************* Carga de objetivos **************************************/
            async saveOB(data){
                //data.calcuObje = this.calcuObje;
                //data.calcuPunta = this.calcuPunta;
                data.semana = moment(data.fecha).format("GGGG-[W]WW");

                const reco =  this.form.paquet.find(ele => {
                    return ele.partida == null;
                })

                //console.log(data);

                if (reco == undefined) {
                    await axios.post('ObjeCordi/storeProObje', data)
                    .then(eve => {this.ConProduccion(), this.openModal()})
                    .catch(error => {this.errors = error.response.data.errors});
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Aun no se han llenado todas las partidas!!',
                    })
                }


                //console.log(ve)
            },
            /****************************** Carga de paquetes para objetivos *******************************/
            async savePObje(form){
                this.btnOff = false;
                await this.$inertia.post('/Produccion/ObjeCordi', form, {
                    onSuccess: (v) => { this.ConObjeti(), this.resetOB(), this.alertSucces(), this.btnOff = true},
                    onError: (e) => { this.ConObjeti(), this.btnOff = true}, preserveState: true
                });
            },
            resetOB(){
                this.limp = 1;
                this.editModeOB = false;
                this.formObje.id = null;
                this.formObje.departamento_id = this.S_Area;
                this.formObje.proceso_id = '';
                this.formObje.maq_pro_id = '';
                this.formObje.norma = '';
                this.formObje.clave_id = '';
                this.formObje.pro_hora = null;
            },
            editOB(form){
                this.limp = 2;
                this.editModeOB = true;
                this.formObje.id = form.id;
                this.proc_prin = form.proceso.proceso_id;
                this.formObje.proceso_id = form.proceso_id;
                this.formObje.maq_pro_id = form.maq_pro_id;
                this.formObje.norma = form.norma;
                this.formObje.clave_id = form.clave_id;
                this.formObje.pro_hora = form.pro_hora;
            },
            async updateOB(data){
                //console.log(data)
                this.btnOff = false;
                await this.$inertia.put('/Produccion/ObjeCordi/' + data.id, data, {
                    onSuccess: (v) => { this.resetOB(), this.alertSucces(), this.ConObjeti(), this.btnOff = true},
                    onError: (e) => { this.ConObjeti(), this.btnOff = true},
                    preserveState: true
                });
            },
            deleteOB(data){
                data._method = 'DELETE';
                this.$inertia.post('/Produccion/ObjeCordi/' + data.id, data, {
                    onSuccess: () => { this.ConObjeti(), this.alertDelete() }, onError: () => {this.ConObjeti()}, preserveState: true
                });
            },
            /************************************* Opciones modal General *******************************************/
            //calcula los objetivos
            calObje2(caOG){
                this.limp = 2;
                const resu = this.objetivos.find(obje => obje.id == caOG.paqObjetivo);
                caOG.valor = resu.pro_hora * caOG.calcuObje2;
                /* this.form2.paquet.forEach(eve => {
                    if(eve.paqObjetivo){

                        //eve.valorP = resu.pro_hora * (parseFloat(this.calcuObje, 10) + parseFloat(this.calcuPunta, 10));
                    }
                }) */
            },
            //abrir modal
            openModal2(){
                this.chageClose2();
                this.resetCO2();
            },
            chageClose2(){
                this.showModal2 = !this.showModal2;
            },
            resetCO2(){
                this.limp = 1;
                //this.calcuObje2 = 0;
                this.paqObjetivo = '';
                this.paqOpera = '';
                this.paqNorma = '';
                this.proc_prin = '';
                this.editMode = false;
                this.form2.fecha = this.hoy;
                this.form2.agNot = 0;
                this.form2.notaPen = 1;
                this.form2.nota = '';
                this.form2.usu = this.usuario.id;
                this.form2.departamento_id = this.S_Area;
                this.form2.paquet = [{ paqObjetivo: "", calcuObje2: 0, clave_id: "", valor: 0, valorP: 0, partida: null }];
                this.errors = [];
                //asigna equipos y turnos
                if (this.usuario.dep_pers.length != 0) {
                    this.usuario.dep_pers.forEach(v => {
                        if (v.departamento_id = this.S_Area) {
                            this.form2.dep_perf_id = v.id != null ? v.id : null;
                            this.form2.turno_id = v.equipo_id != null ? v.equipo.turno_id : '';
                            this.form2.equipo_id = v.equipo_id != null ? v.equipo_id : '';
                        }
                    })
                }else{
                    this.form2.dep_perf_id = null;
                    this.form2.turno_id = '';
                    this.form2.equipo_id = '';
                }
            },
            recoClave(paq){
                const scl = [];
                if(paq){
                    let nuAr = this.objetivos.find(eve => {return eve.id == paq});
                    const nuMat = this.materiales.find(mate => {return mate.id == nuAr.norma})
                    nuMat.claves.forEach(c => {
                        //console.log(cl)
                        scl.push({id: c.id, text: c.CVE_ART+ ' - ' + c.DESCR})
                    })
                    //console.log(nuMat)
                    return scl;
                }
            },
            addRow2(){
                this.form2.paquet.push({paqObjetivo: "", clave_id: "", valor: 0, valorP: 0, partida: null})
            },
            removeRow2(row){
                this.form2.paquet.splice(row,1);
            },
            /************************************* Carga de objetivos 2 **************************************/
            async saveOB2(data){
                /* console.log(data); */
                //data.calcuObje2 = this.calcuObje2;
                data.semana = moment(data.fecha).format("GGGG-[W]WW");

                const reco =  this.form2.paquet.find(ele => {
                    return ele.partida == null;
                })

                //console.log(data);

                if (reco == undefined) {
                    await axios.post('ObjeCordi/storeProObje', data)
                    .then(eve => {this.ConProduccion(), this.openModal2(), console.log(eve.data)})
                    .catch(error => {this.errors = error.response.data.errors});
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Aun no se han llenado todas las partidas!!',
                    })
                }


                //console.log(ve)
            },
        },

        computed: {
            //Opciones departamento
            opc: function() {
                const ar = [];
                this.depa.forEach(r => {
                    if (r.departamentos) {
                        ar.push({text: r.departamentos.Nombre, value: r.departamentos.id});
                    }else{
                        ar.push({text: r.Nombre, value: r.id});
                        r.sub__departamentos.forEach(rr => {
                            ar.push({text: rr.Nombre, value: rr.id});
                            //console.log(rr.Nombre);
                        })
                    }
                })
                return ar;
            },
            //Opciones Normas
            opcNM: function() {
                const nm = [];
                this.materiales.forEach(ma => {
                    nm.push({value: ma.id, text: ma.materiales.idmat+' - '+ma.materiales.nommat});
                })
                return nm;
            },
            //Opciones procesos principales
            opcPPO: function() {
                const ppi = [];
                this.procesos.forEach(pp =>{
                    if (pp.tipo == 0 & pp.tipo_carga == 'pro-cor') {
                        ppi.push({text: pp.nompro, value: pp.id})
                    }
                });
                return ppi;
            },
            //Opciones Personal
            opcPE: function() {
                const spe = [];
                //asignacion de select personal
                this.personal.forEach(pe => {
                    spe.push({value: pe.id, text: pe.perfiles.IdEmp +' - '+ pe.perfiles.Nombre+' '+pe.perfiles.ApPat+' '+pe.perfiles.ApMat});
                })
                return spe;
            },
            //Opciones maquinas Objetivos
            opcMQO: function() {
                this.limp == 1 ? this.formObje.maq_pro_id = '' : '';
                const mq = [];
                var mar = '';
                if (this.formObje.proceso_id != '') {
                    this.procesos.forEach(pm => {
                        if (this.formObje.proceso_id == pm.id) {
                            //console.log(pm.maq_pros.length)
                            pm.maq_pros.forEach(mp => {
                                mar = mp.maquinas.marca == null ? 'N/A' :  mp.maquinas.marca.Nombre
                                mq.push({value: mp.id, text: mp.id+' - '+mp.maquinas.Nombre + ' ' + mar});
                            })
                        }
                    })
                }
                return mq;
            },
            //Opciones Claves Objetivos
            opcCLO: function() {
                const scl = [];
                /* this.form.clave_id = ''; */
                if (this.formObje.norma != '') {
                    this.materiales.forEach(cl => {
                        if (this.formObje.norma == cl.id) {
                            //console.log(cl.claves)
                            cl.claves.forEach(c => {
                                scl.push({id: c.id, text: c.CVE_ART+ ' - ' + c.DESCR})
                            })
                        }
                    })
                }
                return scl;
            },
            //opciones Paquetes Objetivos
            opcPaOb: function() {
                const ob = [];
                var clave = '';
                this.objetivos.forEach(po => {
                    if (po.departamento_id == this.S_Area) {
                        clave = po.clave_id == null ? 'N/A' : po.clave.CVE_ART
                        ob.push({id: po.id, text: po.maq_pro.maquinas.Nombre+' '+po.maq_pro.maquinas.marca.Nombre+' - '+clave})
                    }
                })
                return ob;
            },
            //opciones de turnos
            opcTur: function() {
                const tur = [];
                this.turnos.forEach(t => {
                    if (t.nomtur != 'Vacío') {
                        tur.push({value: t.id, text: t.nomtur});
                    }
                })
                return tur;
            },
            //opciones de equipo
            opcEqu: function() {
                const equ = [];
                this.turnos.forEach(t => {
                    t.equipos.forEach(eq => {
                        equ.push({value: eq.id, text: eq.nombre});
                    })
                })
                return equ;
            },
            //Opciones subprocesos
            opcSP: function() {
                const ssp = [];
                //recorre y muestra los procesos
                this.procesos.forEach(sp =>{
                    if (sp.proceso_id == this.proc_prin) {
                        ssp.push({id: sp.id, text: sp.id+' - '+sp.nompro});
                    }
                })
                return ssp;
            },
            //unidad de medida de las claves
            uni_me: function() {
                var uni = '--';
                /* if (this.form.clave_id != '') {
                    this.materiales.forEach(cl => {
                        if (this.form.norma == cl.id) {
                            cl.claves.forEach(c => {
                                uni = c.UNI_MED;
                            })
                        }
                    })
                } */
                return uni;
            }
        },

        watch: {
            S_Area: async function(b){

                this.ConObjeti(true);
                this.ConProduccion();

                var datos = {'departamento_id': this.S_Area, 'modulo': 'repoPro'};

                //Personal
                let per = await axios.post('General/ConPerso', datos);
                this.personal = per.data;

                //Turnos
                let tur = await axios.post('General/ConTurno', datos)
                this.turnos = tur.data;

                //Produccion
                let produ = await axios.post('General/ConProduccion', datos)
                this.procesos = produ.data;

                //Materiales
                let mate = await axios.post('General/ConMateriales', datos)
                this.materiales = mate.data
            },
        }
    }
</script>
