<template>
    <app-layout>
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-clipboard-list"></i>
                        Carga de Producción
                </h3>
            </slot>
        </Header>
        <Accions>
            <template  v-slot:SelectB v-if="usuario.dep_pers.length != 1">
                <select class="InputSelect sm:tw-w-full" @change="verTabla()" v-model="S_Area">
                    <option value="" disabled>Selecciona un departamento</option>
                    <option v-for="o in opc" :key="o.value" :value="o.value">{{o.text}}</option>
                </select>
            </template>
            <template v-slot:BtnNuevo>
                <div class="md:tw-flex tw-gap-3 tw-mr-10">
                    <!-- BTN Paquete de Operador -->
                    <div v-if="usuario.dep_pers.length == 0 | noCor == 'cor' | noCor == 'enc' | noCor == 'lid'">
                        <button class="btn tw-bg-teal-600 hover:tw-bg-teal-700 tw-text-white hover:tw-text-white tw-w-full" type="button" data-bs-toggle="offcanvas" data-bs-target="#pacOpe" aria-controls="pacOpe" @click="resetPO()">Paquete de operativos</button>
                        <!-- <jet-button class="BtnNuevo tw-w-full" type="button" data-bs-toggle="offcanvas" data-bs-target="#pacOpe" aria-controls="pacOpe" @click="resetCA()">Paquete de operativos</jet-button> -->
                    </div>
                    <!-- BTN Paquetes de Coordiandor -->
                    <div v-if="usuario.dep_pers.length == 0 | noCor == 'cor' | noCor == 'enc'">
                        <button class="btn btn-primary tw-w-full" type="button" data-bs-toggle="offcanvas" data-bs-target="#paqCor" aria-controls="paqCor" @click="resetOB()">Paquetes Objetivos</button>
                        <!-- <jet-button class="BtnNuevo tw-w-full" type="button" data-bs-toggle="offcanvas" data-bs-target="#paqCor" aria-controls="paqCor" @click="resetCA()">Paquetes para coordinador</jet-button> -->
                    </div>
                    <!-- BTN Paquetes de normas -->
                    <div v-if="usuario.dep_pers.length == 0 | noCor == 'cor' | noCor == 'enc' | noCor == 'lid'">
                        <button class="btn tw-bg-cyan-600 hover:tw-bg-cyan-700 tw-w-full tw-text-white hover:tw-text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#pacNorma" aria-controls="pacNorma" @click="resetCA()">Paquete de Normas</button>
                        <!-- <jet-button class="BtnNuevo tw-w-full" type="button" data-bs-toggle="offcanvas" data-bs-target="#pacNorma" aria-controls="pacNorma" @click="resetCA()">Paquete de Normas</jet-button> -->
                    </div>
                    <!-- BTN Carga Objetivos -->
                    <div v-if="usuario.dep_pers.length == 0 | noCor == 'cor' | noCor == 'enc'">
                        <button class="btn btn-warning tw-w-full" data-bs-toggle="collapse" data-bs-target="#agObjec" aria-expanded="false" aria-controls="agObjec" @click="resetCA()">Carga de Objetivos</button>
                        <!-- <jet-button class="BtnNuevo tw-w-full" type="button" data-bs-toggle="offcanvas" data-bs-target="#paqCor" aria-controls="paqCor" @click="resetCA()">Paquetes para coordinador</jet-button> -->
                    </div>
                    <!-- BTN Carga de produccion -->
                    <div>
                        <button class="btn btn-success tw-w-full" data-bs-toggle="collapse" data-bs-target="#agPer" aria-expanded="false" aria-controls="agPer" @click="resetCA()">Carga de Produccion</button>
                        <!-- <jet-button class="BtnNuevo tw-bg-green-600 tw-w-full" data-bs-toggle="collapse" data-bs-target="#agPer" aria-expanded="false" aria-controls="agPer" @click="resetCA()">Carga de Produccion</jet-button> -->
                    </div>
                </div>
            </template>
        </Accions>

        <!------------------------------------ Carga de objetivos -------------------------------------------------->
        <div class="collapse tw-p-6 tw-bg-blueGray-500 tw-border tw-border-yellow-500 tw-border-8 tw-rounded-3xl tw-shadow-xl tw-absolute tw-z-10 lg:tw-mx-14 lg:tw-w-11/12 tw-w-full" id="agObjec">
            <!-- Formulas -->
            <div class="tw-mb-6 lg:tw-flex" v-if="(form.notaPen == 1 & !editMode )| editMode">
                <!-- Fecha -->
                <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                    <jet-label class="tw-text-white"><span class="required">*</span>Fecha</jet-label>
                    <input type="datetime-local" class="InputSelect" v-model="form.fecha" :min="hoy" :max="treDia">
                    <small v-if="errors.fecha" class="validation-alert">{{errors.fecha}}</small>
                </div>
                <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                    <jet-label class="tw-text-white"><span class="required">*</span>Paquete Objetivos</jet-label>
                    <Select2 v-model="paqObjetivo" class="InputSelect" :settings="{width: '100%'}" :options="opcPaOb"/>
                </div>
                <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                    <jet-label class="tw-text-white"><span class="required">*</span>Horas a trabajar</jet-label>
                    <jet-input v-model="calcuObje" type="number" min="0" max="12" step=".5"></jet-input>
                </div>
                <!-- select operador -->
                <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0" v-if="usuario.dep_pers.length == 0">
                    <jet-label class="tw-text-white"><span class="required">*</span>Operador</jet-label>
                    <select class="InputSelect" @change="eq_tu" v-model="form.dep_perf_id">
                        <option value="" disabled>SELECCIONA</option>
                        <option v-for="pe in opcPE" :key="pe" :value="pe.value">{{pe.text}}</option>
                    </select>
                    <small v-if="errors.dep_perf_id" class="validation-alert">{{errors.dep_perf_id}}</small>
                </div>
                <!-- select turno -->
                <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0" >
                    <jet-label class="tw-text-white"><span class="required">*</span>Turnos</jet-label>
                    <select class="InputSelect" v-model="form.turno_id">
                        <option value="" disabled>SELECCIONA</option>
                        <option v-for="tu in opcTur" :key="tu.value" :value="tu.value">{{tu.text}}</option>
                    </select>
                    <small v-if="errors.maq_pro_id" class="validation-alert">{{errors.maq_pro_id}}</small>
                </div>
            </div>
            <div class="tw-mb-6 lg:tw-flex" v-if="(form.notaPen == 1 & !editMode )| editMode" v-on:keyup.enter="saveCA(form)">
                <!-- select equipo -->
                <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                    <jet-label class="tw-text-white"><span class="required">*</span>Equipo</jet-label>
                    <select class="InputSelect" v-model="form.equipo_id">
                        <option value="" disabled>SELECCIONA</option>
                        <option v-for="eq in opcEqu" :key="eq.value" :value="eq.value">{{eq.text}}</option>
                    </select>
                    <small v-if="errors.maq_pro_id" class="validation-alert">{{errors.maq_pro_id}}</small>
                </div>
                <!-- Inout partida -->
                <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                    <jet-label class="tw-text-white">Partida</jet-label>
                    <jet-input class="InputSelect" v-model="form.partida" @input="(val) => (form.partida = form.partida.toUpperCase())"></jet-input>
                    <small v-if="errors.partida" class="validation-alert">{{errors.partida}}</small>
                </div>
                <!-- Input kilogramos -->
                <div class="tw-px-3 tw-mb-6 tw-w-full lg:tw-w-1/2 lg:tw-mb-0">
                    <jet-label class="tw-text-white"><span class="required">*</span>{{ uni_me }}</jet-label>
                    <jet-input type="number" min="0" class="InputSelect tw-bg-lime-300" v-model="form.valor" disabled></jet-input>
                    <small v-if="errors.valor" class="validation-alert">{{errors.valor}}</small>
                </div>
            </div>
            <!-- Notas -->
            <div class="tw-mb-6 lg:tw-flex" v-if="form.notaPen == 2">
                <div class="tw-px-3 tw-mb-6 lg:tw-w-1/3 tw-text-center tw-mx-auto lg:tw-mb-0 tw-bg-emerald-700 tw-bg-opacity-50 tw-rounded-lg" v-if="editMode">
                    <jet-label class="tw-text-white">Nota anterior</jet-label>
                    <jet-label v-html="nAnte"></jet-label>
                </div>
                <div class="tw-px-3 tw-mb-6 lg:tw-w-2/3 tw-text-center tw-mx-auto lg:tw-mb-0">
                    <jet-label class="tw-text-white"><span class="required">*</span>Nota</jet-label>
                    <textarea class="InputSelect" v-model="form.nota" maxlength="250" @input="(val) => (form.nota = form.nota.toUpperCase())" placeholder="Maximo 250 caracteres"></textarea>
                    <small v-if="errors.nota" class="validation-alert">{{errors.nota}}</small>
                </div>
            </div>
            <!-- Botones -->
            <div class="w-100 tw-mx-auto tw-gap-4 tw-flex tw-justify-center">
                <div>
                    <jet-button type="button" class="tw-mx-auto" v-if="form.notaPen == 2 & !editMode" v-show="btnOff" @click="saveNot(form)">Agregar</jet-button>
                </div>
                <div>
                    <jet-button type="button" class="tw-mx-auto" v-if="form.notaPen == 1 & !editMode" v-show="btnOff" @click="saveCA(form)">Guardar</jet-button>
                </div>
                <div v-show="!btnOff">
                    <jet-button type="button" class="tw-mx-auto" disabled>
                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                        Guardando...
                    </jet-button>
                </div>
                <!-- <div>
                    <jet-button type="button" class="tw-mx-auto" v-if="editMode" @click="updateCA(form)">Actualizar</jet-button>
                </div> -->
                <div>
                    <jet-button class="tw-bg-red-700 hover:tw-bg-red-500" data-bs-toggle="collapse" data-bs-target="#agObjec" aria-expanded="false" aria-controls="agObjec" @click="resetCA()" v-if="editMode">CANCELAR</jet-button>
                </div>
            </div>
        </div>

        <!------------------------------------ carga de datos de produccion ---------------------------------------->
        <div class="collapse tw-p-6 tw-bg-blueGray-500 tw-border tw-border-green-700 tw-border-8 tw-rounded-3xl tw-shadow-xl tw-absolute tw-z-10 lg:tw-mx-14 lg:tw-w-11/12 tw-w-full" id="agPer">
            <!-------------------------------------------- Paquetes ---------------------------------------------->
            <div class="tw-mb-6 lg:tw-flex lg:tw-flex-col tw-w-full" v-if="noCor == 'lid' | noCor == 'ope'">
                <!-- formulario -->
                <div class="tw-mb-6 lg:tw-flex" v-if="(form.notaPen == 1 & !editMode )| editMode"  v-on:keyup.enter="saveCA(form)">
                    <!-- select Paquetes de operadores -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/3 lg:tw-mb-0">
                        <jet-label class="tw-text-white"><span class="required">*</span>Paquete de operadores</jet-label>
                        <Select2 v-model="paqOpera" class="InputSelect" :settings="{width: '100%'}" :options="opcPaOp" />
                    </div>
                    <!-- select Paquetes de Normas partida y clave -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/3 lg:tw-mb-0">
                        <jet-label class="tw-text-white"><span class="required">*</span>Paquete de Norma, partida y clave</jet-label>
                        <Select2 v-model="paqNorma" class="InputSelect" :settings="{width: '100%'}" :options="opcPaNo" />
                    </div>
                    <!-- Input kilogramos -->
                    <div class="tw-px-3 tw-mb-6 tw-w-full lg:tw-w-1/3 lg:tw-mb-0">
                        <jet-label class="tw-text-white"><span class="required">*</span> {{ uni_me }} </jet-label>
                        <jet-input type="number" min="0" class="InputSelect tw-bg-lime-300" v-model="form.valor"></jet-input>
                        <small v-if="errors.valor" class="validation-alert">{{errors.valor}}</small>
                    </div>
                </div>

                <!-- Notas -->
                <div class="tw-mb-6 lg:tw-flex" v-if="form.notaPen == 2">
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/3 tw-text-center tw-mx-auto lg:tw-mb-0 tw-bg-emerald-700 tw-bg-opacity-50 tw-rounded-lg" v-if="editMode">
                        <jet-label class="tw-text-white">Nota anterior</jet-label>
                        <jet-label v-html="nAnte"></jet-label>
                    </div>
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-2/3 tw-text-center tw-mx-auto lg:tw-mb-0">
                        <jet-label class="tw-text-white"><span class="required">*</span>Nota</jet-label>
                        <textarea class="InputSelect" v-model="form.nota" maxlength="250" @input="(val) => (form.nota = form.nota.toUpperCase())" placeholder="Maximo 250 caracteres"></textarea>
                        <small v-if="errors.nota" class="validation-alert">{{errors.nota}}</small>
                    </div>
                </div>
                <!-- Botones -->
                <div class="w-100 tw-mx-auto tw-gap-4 tw-flex tw-justify-center">
                    <div>
                        <jet-button type="button" class="tw-mx-auto" v-if="form.notaPen == 2 & !editMode" v-show="btnOff" @click="saveNot(form)">Agregar</jet-button>
                    </div>
                    <div>
                        <jet-button type="button" class="tw-mx-auto" v-if="form.notaPen == 1 & !editMode" v-show="btnOff" @click="saveCA(form)">Guardar</jet-button>
                    </div>
                    <div>
                        <jet-button type="button" class="tw-mx-auto" v-if="editMode" v-show="btnOff" @click="updateCA(form)">Actualizar</jet-button>
                    </div>
                    <div v-show="!btnOff">
                        <jet-button type="button" class="tw-mx-auto" disabled>
                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                            Guardando...
                        </jet-button>
                    </div>
                    <div>
                        <jet-button class="tw-bg-red-700 hover:tw-bg-red-500" data-bs-toggle="collapse" data-bs-target="#agPer" aria-expanded="false" aria-controls="agPer" @click="resetCA()" v-if="editMode">CANCELAR</jet-button>
                    </div>
                </div>
            </div>
            <!-------------------------------------------- Carga normal ------------------------------------------>
            <div v-if="usuario.dep_pers.length == 0 | noCor == 'cor' | noCor == 'enc'">
                <!-- Proceso proncipal, sub procesos, operador -->
                <div class="tw-mb-6 lg:tw-flex" v-if="(form.notaPen == 1 & !editMode )| editMode">
                    <!-- Fecha -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                        <jet-label class="tw-text-white"><span class="required">*</span>Fecha</jet-label>
                        <input type="datetime-local" class="InputSelect" v-model="form.fecha" :min="twoF" :max="hoy">
                        <small v-if="errors.fecha" class="validation-alert">{{errors.fecha}}</small>
                    </div>
                    <!-- Select proceso principal -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                        <jet-label class="tw-text-white"><span class="required">*</span>Proceso proncipal</jet-label>
                        <select class="InputSelect" v-model="proc_prin">
                            <option value="" disabled>SELECCIONA</option>
                            <option v-for="pp in opcPP" :key="pp" :value="pp.value" >{{pp.text}}</option>
                        </select>
                        <small v-if="errors.proc_prin" class="validation-alert">{{errors.proc_prin}}</small>
                    </div>
                    <!-- select Sub proceso -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0" v-if="opcSP">
                        <jet-label class="tw-text-white"><span class="required">*</span>Sub proceso </jet-label>
                        <select class="InputSelect" v-model="form.proceso_id">
                            <option value="" disabled>SELECCIONA</option>
                            <option v-for="sp in opcSP" :key="sp" :value="sp.id">{{sp.text}}</option>
                        </select>
                        <small v-if="errors.proceso_id" class="validation-alert">{{errors.proceso_id}}</small>
                    </div>
                    <!-- select operador -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0" v-if="(noCor != 'lid' & noCor != 'ope') | editMode">
                        <jet-label class="tw-text-white"><span class="required">*</span>Operador</jet-label>
                        <select class="InputSelect" @change="eq_tu" v-model="form.dep_perf_id">
                            <option value="" disabled>SELECCIONA</option>
                            <option v-for="pe in opcPE" :key="pe" :value="pe.value">{{pe.text}}</option>
                        </select>
                        <small v-if="errors.dep_perf_id" class="validation-alert">{{errors.dep_perf_id}}</small>
                    </div>
                </div>
                <!-- Maquinas, Normas, Claves, Partida, Kilogramos -->
                <div class="tw-mb-6 lg:tw-flex" v-if="(form.notaPen == 1 & form.proceso_id != '') | editMode">
                    <!-- select turno -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/3 lg:tw-mb-0">
                        <jet-label class="tw-text-white"><span class="required">*</span>Turnos</jet-label>
                        <select class="InputSelect" v-model="form.turno_id">
                            <option value="" disabled>SELECCIONA</option>
                            <option v-for="tu in opcTur" :key="tu.value" :value="tu.value">{{tu.text}}</option>
                        </select>
                        <small v-if="errors.maq_pro_id" class="validation-alert">{{errors.maq_pro_id}}</small>
                    </div>
                    <!-- select equipo -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/3 lg:tw-mb-0">
                        <jet-label class="tw-text-white"><span class="required">*</span>Equipo</jet-label>
                        <select class="InputSelect" v-model="form.equipo_id">
                            <option value="" disabled>SELECCIONA</option>
                            <option v-for="eq in opcEqu" :key="eq.value" :value="eq.value">{{eq.text}}</option>
                        </select>
                        <small v-if="errors.maq_pro_id" class="validation-alert">{{errors.maq_pro_id}}</small>
                    </div>
                    <!-- select Maquinas -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/3 lg:tw-mb-0">
                        <jet-label class="tw-text-white"><span class="required">*</span>Maquinas</jet-label>
                        <select class="InputSelect" v-model="form.maq_pro_id">
                            <option value="" disabled>SELECCIONA</option>
                            <option v-for="mq in opcMQ" :key="mq.value" :value="mq.value">{{mq.text}}</option>
                        </select>
                        <small v-if="errors.maq_pro_id" class="validation-alert">{{errors.maq_pro_id}}</small>
                    </div>
                    <!-- select Paquetes de Normas partida y clave -->
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/3 lg:tw-mb-0">
                        <jet-label class="tw-text-white"><span class="required">*</span>Paquete de Norma, partida y clave</jet-label>
                        <Select2 v-model="paqNorma" class="InputSelect" :options="opcPaNo"  :settings="{width: '100%'}"/>
                        <!-- <select class="InputSelect" v-model="paqNorma">
                            <option value="" disabled>SELECCIONA</option>
                            <option v-for="no in opcPaNo" :key="no.id" :value="no.value">{{no.text}}</option>
                        </select> -->
                    </div>
                    <!-- Input kilogramos -->
                    <div class="tw-px-3 tw-mb-6 tw-w-full lg:tw-w-1/3 lg:tw-mb-0">
                        <jet-label class="tw-text-white"><span class="required">*</span>{{ uni_me }}</jet-label>
                        <jet-input type="number" min="0" class="InputSelect tw-bg-lime-300" v-model="form.valor"></jet-input>
                        <small v-if="errors.valor" class="validation-alert">{{errors.valor}}</small>
                    </div>
                </div>
                <!-- Notas -->
                <div class="tw-mb-6 lg:tw-flex" v-if="form.notaPen == 2">
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-1/3 tw-text-center tw-mx-auto lg:tw-mb-0 tw-bg-emerald-700 tw-bg-opacity-50 tw-rounded-lg" v-if="editMode">
                        <jet-label class="tw-text-white">Nota anterior</jet-label>
                        <jet-label v-html="nAnte"></jet-label>
                    </div>
                    <div class="tw-px-3 tw-mb-6 lg:tw-w-2/3 tw-text-center tw-mx-auto lg:tw-mb-0">
                        <jet-label class="tw-text-white"><span class="required">*</span>Nota</jet-label>
                        <textarea class="InputSelect" v-model="form.nota" maxlength="250" @input="(val) => (form.nota = form.nota.toUpperCase())" placeholder="Maximo 250 caracteres"></textarea>
                        <small v-if="errors.nota" class="validation-alert">{{errors.nota}}</small>
                    </div>
                </div>
                <!-- Botones -->
                <div class="w-100 tw-mx-auto tw-gap-4 tw-flex tw-justify-center">
                    <div>
                        <jet-button type="button" class="tw-mx-auto" v-if="form.notaPen == 2 & !editMode" v-show="btnOff" @click="saveNot(form)">Agregar</jet-button>
                    </div>
                    <div>
                        <jet-button type="button" class="tw-mx-auto" v-if="form.notaPen == 1 & !editMode" v-show="btnOff" @click="saveCA(form)">Guardar</jet-button>
                    </div>
                    <div>
                        <jet-button type="button" class="tw-mx-auto" v-if="editMode" v-show="btnOff" @click="updateCA(form)">Actualizar</jet-button>
                    </div>
                    <div v-show="!btnOff">
                        <jet-button type="button" class="tw-mx-auto" disabled>
                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                            Guardando...
                        </jet-button>
                    </div>
                    <div>
                        <jet-button class="tw-bg-red-700 hover:tw-bg-red-500" data-bs-toggle="collapse" data-bs-target="#agPer" aria-expanded="false" aria-controls="agPer" @click="resetCA()" v-if="editMode">CANCELAR</jet-button>
                    </div>
                </div>
            </div>

        </div>

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
                    <tr v-for="ca in v" :key="ca.id"  class="fila">
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
                                <!-- nota operador -->
                                <a class="iconoDetails tw-cursor-pointer" href="#agPer" @click="notaCA(ca)" v-show="usuario.dep_pers.length != 0 & ((noCor == 'lid' | noCor == 'ope') & ca.equipo_id != null & ca.notaPen == 1)">
                                    <span tooltip="Agregar nota" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </span>
                                </a>
                                <!-- nota objetivos -->
                                <a class="iconoDetails tw-cursor-pointer" href="#agPer" @click="notaOB(ca)" v-show="usuario.dep_pers.length != 0 & ((noCor == 'cor' | noCor == 'enc') & ca.proceso.tipo == 2 & ca.notaPen == 1)">
                                    <span tooltip="Agregar nota" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </span>
                                </a>
                                <a class="iconoEdit tw-cursor-pointer" href="#agPer" @click="editCA(ca)" v-show="usuario.dep_pers.length == 0 | (ca.proceso.tipo != 2 & (noCor == 'cor' | noCor == 'enc'))">
                                    <span tooltip="Editar" flow="left">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
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

        <!------------------------------------- Carga de paquetes de operativos ------------------------------------------>
        <div class="offcanvas offcanvas-start sm:tw-w-9/12 lg:tw-w-6/12" tabindex="-1" id="pacOpe" aria-labelledby="pacOpeLabel">
            <div class="offcanvas-header tw-bg-teal-700">
                <h3 class="offcanvas-title tw-text-xl tw-text-blueGray-50" id="pacOpeLabel">Paquetes de Operativos</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <!-------------------------------- formularia y tabla ------------------------------------------------------->
            <div class="offcanvas-body">
                <!------------------------------------ Paquete de operadores ---------------------------------------->
                <div class="m-5 tw-p-6 tw-bg-teal-600 tw-rounded-3xl tw-shadow-xl">
                    <!-- Proceso proncipal, sub procesos, operador -->
                    <div class="tw-mb-6 lg:tw-flex">
                        <!-- Select proceso principal -->
                        <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                            <jet-label><span class="required">*</span>Proceso proncipal</jet-label>
                            <select class="InputSelect" v-model="proc_prin" :disabled="editMode">
                                <option value="" disabled>SELECCIONA</option>
                                <option v-for="pp in opcPP" :key="pp" :value="pp.value" >{{pp.text}}</option>
                            </select>
                            <small v-if="errors.proc_prin" class="validation-alert">{{errors.proc_prin}}</small>
                        </div>
                        <!-- select Sub proceso -->
                        <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                            <jet-label><span class="required">*</span>Sub proceso </jet-label>
                            <select class="InputSelect" v-model="formPacOpe.proceso_id" :disabled="editMode">
                                <option value="" disabled>SELECCIONA</option>
                                <option v-for="sp in opcSP" :key="sp" :value="sp.id">{{sp.text}}</option>
                            </select>
                            <small v-if="errors.proceso_id" class="validation-alert">{{errors.proceso_id}}</small>
                        </div>
                    </div>
                    <!-- Maquinas, Normas, Claves, Partida, Kilogramos -->
                    <div class="tw-mb-6 lg:tw-flex">
                        <!-- select operador -->
                        <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                            <jet-label><span class="required">*</span>Operador</jet-label>
                            <select class="InputSelect" @change="eq_tu" v-model="formPacOpe.dep_perf_id" :disabled="editMode">
                                <option value="" disabled>SELECCIONA</option>
                                <option v-for="pe in opcPE" :key="pe" :value="pe.value">{{pe.text}}</option>
                            </select>
                            <small v-if="errors.dep_perf_id" class="validation-alert">{{errors.dep_perf_id}}</small>
                        </div>
                        <!-- select Maquinas -->
                        <div class="tw-px-3 tw-mb-6 lg:tw-w-1/2 lg:tw-mb-0">
                            <jet-label><span class="required">*</span>Maquinas</jet-label>
                            <select class="InputSelect" v-model="formPacOpe.maq_pro_id" :disabled="editMode">
                                <option value="" disabled>SELECCIONA</option>
                                <option v-for="mq in opcMQ" :key="mq.value" :value="mq.value">{{mq.text}}</option>
                            </select>
                            <small v-if="errors.maq_pro_id" class="validation-alert">{{errors.maq_pro_id}}</small>
                        </div>

                    </div>

                    <!-- Botones -->
                    <div class="w-100 tw-mx-auto tw-gap-4 tw-flex tw-justify-center">
                        <div v-if="btnOff & !editModePo">
                            <jet-button type="button" class="tw-mx-auto" @click="savePO(formPacOpe)">Guardar</jet-button>
                        </div>
                        <div v-if="btnOff & editModePo">
                            <jet-button type="button" class="tw-mx-auto" @click="updatePO(formPacOpe)">Actualizar</jet-button>
                        </div>
                        <div v-show="!btnOff">
                            <jet-button type="button" class="tw-mx-auto" disabled>
                                <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                Guardando...
                            </jet-button>
                        </div>
                    </div>
                </div>
                <!-- tabla para paquetes operador -->
                <div>
                    <TableGreen id="t_op">
                        <template v-slot:TableHeader>
                            <th class="columna">Índice</th>
                            <th class="columna">Nombre del operador</th>
                            <th class="columna">Sub procesos</th>
                            <th class="columna">Maquina</th>
                            <th class="columna">Equipo</th>
                            <th class="columna">Turno</th>
                            <th class="columna"><button class="btn btn-danger" v-show="formPacOpe.ElMaOP.length > 0" @click="deletePO(formPacOpe)">Eliminar</button></th>
                        </template>
                        <template v-slot:TableFooter>
                            <tr v-for="pOpe in paqope" :key="pOpe" class="fila">
                                <td class="tw-text-center">
                                    <input type="checkbox" :value="pOpe.id" v-model="formPacOpe.ElMaOP" class="tw-rounded-xl tw-bg-coolGray-300" :id="'idOP'+pOpe.id"/>
                                    <label :for="'idOP'+pOpe.id" class="tw-px-3">{{ pOpe.id }}</label>
                                </td>
                                <td> {{pOpe.dep_per == null ? 'N/A' : pOpe.dep_per.perfiles.Nombre}} {{pOpe.dep_per == null ? 'N/A' : pOpe.dep_per.perfiles.ApPat}} {{pOpe.dep_per == null ? 'N/A' : pOpe.dep_per.perfiles.ApMat}}</td>
                                <td>{{pOpe.proceso == null ? 'N/A' : pOpe.proceso.nompro}}</td>
                                <td> {{pOpe.maq_pro.maquinas.Nombre}} </td>
                                <td> {{pOpe.dep_per.equipo_id == null ? 'N/A' : pOpe.dep_per.equipo.nombre}} </td>
                                <td> {{pOpe.dep_per.equipo_id == null ? 'N/A' : pOpe.dep_per.equipo.turnos.nomtur}} </td>
                                <td>
                                    <div class="columnaIconos">
                                        <!-- editar objetivos -->
                                        <div class="iconoEdit" @click="editPO(pOpe)">
                                            <span tooltip="Editar" flow="left">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="iconoDelete" @click="deletePO(pOpe)">
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
                    </TableGreen>
                </div>
            </div>
        </div>

        <!------------------------------------- Carga de paquetes Norma, Claves y partida -------------------------------->
        <div class="offcanvas offcanvas-end sm:tw-w-9/12 lg:tw-w-6/12"  data-bs-scroll="true" tabindex="-1" id="pacNorma" aria-labelledby="pacNormaLabel">
            <div class="offcanvas-header tw-bg-cyan-700">
                <h3 class="offcanvas-title tw-text-xl tw-text-blueGray-50" id="pacNormaLabel">Paquetes para Normas, Claves y Partidas</h3>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <!-------------------------------- formularia y tabla ------------------------------------------------------->
            <div class="offcanvas-body">
                <!---------------------------- Formulario de paquete para normas, claves y partida ---------------------->
                <div class="m-5 tw-p-6 tw-bg-cyan-600 tw-rounded-3xl tw-shadow-xl">
                    <!-- Proceso proncipal, sub procesos, operador -->
                    <div class="tw-mb-6 lg:tw-flex">
                        <!-- Select Normas -->
                        <div class="tw-px-3 tw-mb-6 lg:tw-w-1/3 lg:tw-mb-0">
                            <jet-label><span class="required">*</span>Norma</jet-label>
                            <select class="InputSelect" v-model="form.norma" :disabled="editMode">
                                <option value="" disabled>SELECCIONA</option>
                                <option v-for="nm in opcNM" :key="nm" :value="nm.value">{{nm.text}}</option>
                            </select>
                            <small v-if="errors.norma" class="validation-alert">{{errors.norma}}</small>
                        </div>
                        <!-- select Clave -->
                        <div class="tw-px-3 tw-mb-6 lg:tw-w-1/3 lg:tw-mb-0">
                            <jet-label><span class="required">*</span>Clave</jet-label>
                            <Select2 v-model="form.clave_id" class="InputSelect tw-w-full" style="z-index: 1500" :settings="{width: '100%', allowClear: true}" :options="opcCL" />
                            <!-- <select class="InputSelect" v-model="form.clave_id">
                                <option value="" disabled>SELECCIONA</option>
                                <option v-for="cl in opcCL" :key="cl" :value="cl.id">{{cl.text}}</option>
                            </select> -->
                            <small v-if="errors.clave_id" class="validation-alert">{{errors.clave_id}}</small>
                        </div>
                        <!-- Inout partida -->
                        <div class="tw-px-3 tw-mb-6 lg:tw-w-1/3 lg:tw-mb-0">
                            <jet-label>Partida</jet-label>
                            <jet-input class="InputSelect" v-model="form.partida" @input="(val) => (form.partida = form.partida.toUpperCase())"></jet-input>
                            <small v-if="errors.partida" class="validation-alert">{{errors.partida}}</small>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="w-100 tw-mx-auto tw-gap-4 tw-flex tw-justify-center">
                        <div v-show="btnOff">
                            <jet-button type="button" @click="savePN(form)">Guardar</jet-button>
                        </div>

                        <div v-show="!btnOff">
                            <jet-button type="button" class="tw-mx-auto" disabled>
                                <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                Guardando...
                            </jet-button>
                        </div>
                    </div>

                </div>
                <!---------------------------- Datatable de paquetes ---------------------------------------------------->
                <div>
                    <TableCyan id="t_pn">
                        <template v-slot:TableHeader>
                            <th class="columna">Índice</th>
                            <th class="columna">Norma</th>
                            <th class="columna">Clave</th>
                            <th class="columna">Descripcion</th>
                            <th class="columna">Partida</th>
                            <th class="columna"><button class="btn btn-danger" v-show="formPacNor.ElMaPN.length > 0" @click="deletePN(formPacNor)">Eliminar</button></th>
                        </template>
                        <template v-slot:TableFooter>
                            <tr v-for="pNor in paqnor" :key="pNor" class="fila">
                                <td class="tw-text-center">
                                    <input type="checkbox" :value="pNor.id" v-model="formPacNor.ElMaPN" class="tw-rounded-xl tw-bg-coolGray-300" :id="'idPN'+pNor.id"/>
                                    <label :for="'idPN'+pNor.id" class=" tw-px-3">{{ pNor.id }}</label>
                                </td>
                                <td> {{pNor.dep_mat.materiales.nommat}}</td>
                                <td >{{pNor.clave.CVE_ART}}</td>
                                <td > {{pNor.clave.DESCR}}</td>
                                <td > {{pNor.partida}} </td>
                                <td >
                                    <div class="columnaIconos">
                                        <div class="iconoDelete" @click="deletePN(pNor)">
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
                    </TableCyan>
                </div>
            </div>
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
                        <div class="tw-px-3 tw-mb-6 lg:tw-w-1/6 lg:tw-mb-0">
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
                    <TableBlue id="t_ob">
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
                                    <div class="columnaIconos">
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

    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Header from '@/Components/Header'
    import Accions from '@/Components/Accions'
    import Table from '@/Components/Table';
    import TableCyan from '@/Components/TableCyan';
    import TableGreen from '@/Components/TableTeal';
    import TableBlue from '@/Components/TableBlue';
    import JetButton from '@/Components/Button';
    import JetCancelButton from '@/Components/CancelButton';
    import JetInput from '@/Components/Input';
    import JetBanner from '@/Components/Banner';
    import JetLabel from '@/Jetstream/Label';
    import Select2 from 'vue3-select2-component';
    //datatable
    import datatable from 'datatables.net-bs5';
    import $ from 'jquery';

    import moment from 'moment';
    import 'moment/locale/es';
import axios from 'axios';

    //

    export default {
        props: [
            'turnos',
            'usuario',
            'paqope',
            'paqnor',
            'objetivos',
            'depa',
            'cargas',
            'procesos',
            'materiales',
            'personal',
            'errors'
        ],
        components: {
            Select2,
            JetBanner,
            TableCyan,
            TableGreen,
            TableBlue,
            AppLayout,
            Header,
            Accions,
            Table,
            JetButton,
            JetCancelButton,
            JetInput,
            JetLabel
        },
        data() {
            return {
                color: "tw-bg-blue-600",
                style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
                S_Area: '',
                noCor: '',
                calcuObje: '',
                proc_prin: '',
                paqOpera: '',
                paqNorma: '',
                paqObjetivo: '',
                btnOff: true,
                v: [],
                calcu: '',
                idDep: '',
                limp: 1,
                hoy: moment().format('YYYY-MM-DD[T]HH:mm:ss'),
                treDia: moment().add(3, 'days').format('YYYY-MM-DD[T]HH:mm:ss'),
                twoF: moment().subtract(2, 'days').format('YYYY-MM-DD[T]HH:mm:ss'),
                editMode: false,
                editModePo: false,
                editModeOB: false,
                nAnte: '',
                formPacNor: {
                    ElMaPN: []
                },
                formPacOpe:{
                    id: null,
                    proceso_id: '',
                    dep_perf_id: '',
                    maq_pro_id: '',
                    ElMaOP: [],
                    departamento_id: this.S_Area
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
                form: {
                    id: null,
                    fecha: null,
                    semana: null,
                    departamento_id: this.S_Area,
                    usu: this.usuario.id,
                    per_carga: this.usuario.id,
                    proceso_id: '',
                    dep_perf_id: '',
                    maq_pro_id: '',
                    partida: '',
                    valor: '',
                    norma: '',
                    equipo_id: '',
                    clave_id: '',
                    turno_id: '',
                    notaPen: 1,
                    nota: '',
                    agNot: 0,
                }
            }
        },
        mounted() {
            this.global();
            /* this.tabla(); */
            this.reCarga();
        },
        methods: {
            //consulta para generar datos de la tabla
            verTabla(event){
                $('#t_op').DataTable().clear();
                $('#t_pn').DataTable().clear();
                $('#t_carg').DataTable().clear();
            },
            /****************************** Globales **********************************************************/
            global(){
                this.form.fecha = this.hoy;
                if (this.usuario.dep_pers.length == 0) {
                    this.S_Area = 7;
                }else{
                    //Asigna el primer departamento
                    this.S_Area = this.usuario.dep_pers[0].departamento_id;
                    this.usuario.dep_pers.forEach(v => {
                        if (v.departamento_id = this.S_Area) {
                            //asigna el puesto a una variable
                            this.noCor = v.ope_puesto;
                            //asigna
                            this.idDep = v.id;
                        }
                    })

                }
            },
            /****************************** Selects de muestra ************************************************/
            //equipo y turno
            eq_tu(event){
                this.personal.forEach(sp => {
                    if (sp.id == event.target.value) {
                        /* console.log(sp) */
                        this.form.equipo_id = sp.equipo == null ? '' : sp.equipo.id;
                        this.form.vacio = sp.equipo == null ? 'N/A' : sp.equipo.turnos.nomtur;
                        this.form.turno_id = sp.equipo == null ? '' : sp.equipo.turno_id;
                    }
                })
            },
            //reordana los datos para mostrar la información en el datatable
            reCarga(){
                this.v = [];
                this.cargas.forEach(ca => {
                    if (ca.dep_perf != null){
                        if (this.usuario.dep_pers.length != 0) {
                            if (this.noCor != 'cor' & this.noCor != 'enc') {
                                if (ca.proceso.tipo != 2) {
                                    this.v.push(ca);
                                }
                            }else{
                                this.v.push(ca);
                            }
                        }else{
                            this.v.push(ca)
                        }
                    }


                })
                //console.log(this.v)
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
            //datatable de paquetes operador
            tablaOpe() {
                this.$nextTick(() => {
                    $('#t_op').DataTable( {
                        "language": this.español,
                        "scrollX": true,
                        scrollY:        '50vh',
                        scrollCollapse: true,
                        paging:         false
                    } );
                })
            },
            //datatable de paquetes Norma, partida y clave
            tablaNor() {
                this.$nextTick(() => {
                    $('#t_pn').DataTable( {
                        "language": this.español,
                        "scrollX": true,
                        scrollY:        '50vh',
                        scrollCollapse: true,
                        paging:         false
                    } );
                })
            },
            //Datattable de objetivos para coordinador
            tablaObje() {
                this.$nextTick(() => {
                    $('#t_ob').DataTable( {
                        "language": this.español,
                        "scrollX": true,
                        scrollY:        '50vh',
                        scrollCollapse: true,
                        paging:         false
                    } );
                })
            },
            /****************************** carga de carga de datos ******************************************/
            saveCA(form){
                //form.fecha = form.fecha;
                form.semana = moment(form.fecha).format("GGGG-[W]WW");
                this.form.departamento_id = this.S_Area;
                this.btnOff = false;
                //Asigna si es horario de verano o no
                form.VerInv = this.calcuObje != '' ? this.calcuObje : '1';
                //revisa si el usuario es lider o operador
                if (this.noCor == 'lid' | this.noCor == 'ope') {
                    //revisa si tienen equipo
                    if (form.equipo_id == null) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'No tienes asignado ningún equipo, Por favor solicite que le agreguen un equipo',
                        })
                        this.btnOff = true
                    }else{
                        //revisa si el turno es vacio
                        var vacio = '';
                        this.turnos.forEach(t => {
                            if (t.id == form.turno_id) {
                                vacio = t.nomtur;
                            }
                        });
                        if (vacio == 'Vacío') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Te encuentras en un turno vacío, Por favor solicite cambiar su turno',
                            })
                            this.btnOff = true
                        }else{
                            //$('#t_carg').DataTable().clear();
                            $('#t_carg').DataTable().destroy();
                            this.$inertia.post('/Produccion/Carga', form, {
                                onSuccess: (v) => { this.reCarga(), this.tabla(), this.resetCA(), this.alertSucces(), this.btnOff = true}, onError: (e) => { this.tabla(), this.btnOff = true}, preserveState: true
                            });
                        }
                    }
                }else{
                    //si el carga el dato pasa de lo contraro verifica
                    if (this.idDep == form.dep_perf_id) {
                        //$('#t_carg').DataTable().clear();
                        $('#t_carg').DataTable().destroy();
                        this.$inertia.post('/Produccion/Carga', form, {
                            onSuccess: (v) => { this.reCarga(), this.tabla(), this.resetCA(), this.alertSucces(), this.btnOff = true}, onError: (e) => { this.tabla(), this.btnOff = true}, preserveState: true
                        });
                    }else{
                        //revisa si tienen equipo
                        if (form.equipo_id == null) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'No tienes asignado ningún equipo, Por favor solicite que le agreguen un equipo',
                            })
                            this.btnOff = true
                        }else{
                            //revisa si el turno es vacio
                            var vacio = '';
                            this.turnos.forEach(t => {
                                if (t.id == form.turno_id) {
                                    vacio = t.nomtur;
                                }
                            });
                            if (vacio == 'Vacío') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Te encuentras en un turno vacío, Por favor solicite cambiar su turno',
                                })
                                this.btnOff = true
                            }else{
                                //$('#t_carg').DataTable().clear();
                                $('#t_carg').DataTable().destroy();
                                this.$inertia.post('/Produccion/Carga', form, {
                                    onSuccess: (v) => { this.reCarga(), this.tabla(), this.resetCA(), this.alertSucces(), this.btnOff = true}, onError: (e) => { this.tabla(), this.btnOff = true}, preserveState: true
                                });
                            }
                        }
                    }
                }

                //console.log(form);
            },
            resetCA(){
                this.limp = 1;
                this.calcuObje = '';
                this.paqObjetivo = '';
                this.paqOpera = '';
                this.paqNorma = '';
                this.proc_prin = '';
                this.editMode = false;
                this.form.fecha = this.hoy;
                this.form.valor = '';
                this.form.norma = '';
                this.form.partida = '';
                this.form.maq_pro_id = '';
                this.form.clave_id = '';
                this.form.agNot = 0;
                this.form.notaPen = 1;
                this.form.nota = '';
                this.form.usu = this.usuario.id;
                this.form.departamento_id = this.S_Area;
                this.formPacNor.ElMaPN = [];

                if (this.usuario.dep_pers.length != 0) {
                    this.usuario.dep_pers.forEach(v => {
                        if (v.departamento_id = this.S_Area) {
                            this.form.dep_perf_id = v.id != null ? v.id : null;
                            this.form.turno_id = v.equipo_id != null ? v.equipo.turno_id : '';
                            this.form.equipo_id = v.equipo_id != null ? v.equipo_id : '';
                            //asigna el puesto a una variable
                            this.noCor = v.ope_puesto;
                            //asigna
                            this.idDep = v.id;
                        }
                    })
                }else{
                    this.form.dep_perf_id = null;
                    this.form.turno_id = '';
                    this.form.equipo_id = '';
                }
            },
            editCA(form){
                //console.log(form)
                this.limp = 2;
                this.proc_prin = form.proceso.proceso_id;
                this.form.dep_perf_id = form.dep_perf_id;
                this.form.turno_id = form.turno_id;
                this.form.equipo_id = form.equipo_id;
                this.form.proceso_id = form.proceso_id;
                this.form.id = form.id;
                this.form.valor = form.valor;
                this.form.maq_pro_id = form.maq_pro_id;
                this.paqnor.forEach(pn => {
                    if (pn.partida == form.partida & pn.clave_id == form.clave_id) {
                        this.paqNorma = pn.id;
                    }
                })

                this.form.norma = form.norma;
                this.form.partida = form.partida;
                this.form.clave_id = form.clave_id;
                this.form.notaPen = 2;
                this.form.nota = '';
                this.editMode = true;
                this.nAnte = form.notas.length == 0 ? '' : `<label class="tw-text-base tw-w-full tw-text-black">Fecha: ${form.notas[0].fecha}</label><label class="tw-text-base tw-w-full tw-text-black tw-capitalize"> ${form.notas[0].nota}</label>`;
                $('#agPer').addClass('show')
            },
            updateCA(data){
                //console.log(data)
                this.btnOff = false;
                if (data.nota != '' & data.clave_id != '' & data.valor != '') {
                    //$('#t_carg').DataTable().clear();
                    $('#t_carg').DataTable().destroy();
                }
                this.$inertia.put('/Produccion/Carga/' + data.id, data, {
                    onSuccess: () => {this.reCarga(), this.tabla(), this.resetCA(), this.alertSucces(), this.btnOff = true}, onError: () => {this.tabla(), this.btnOff = true}
                });
            },
            //***************************** Carga de paquetes de operativos **********************************/
            savePO(form){
                this.btnOff = false;
                //formPacOpe.departamento_id = this.S_Area;
                //console.log(form)
                //$('#t_op').DataTable().clear();
                $('#t_op').DataTable().destroy();
                this.$inertia.post('/Produccion/CarOpe', form, {
                    onSuccess: (v) => { this.tablaOpe(), this.resetPO(), this.alertSucces(), this.btnOff = true}, onError: (e) => { this.tablaOpe(), this.btnOff = true}, preserveState: true
                });
            },
            resetPO(){
                this.limp = 1;
                this.editModePo = false;
                this.formPacOpe.id = null;
                this.formPacOpe.proceso_id = '';
                this.formPacOpe.dep_perf_id = '';
                this.formPacOpe.maq_pro_id = '';
                this.formPacOpe.ElMaOP = [];
                this.formPacOpe.departamento_id = this.S_Area;
            },
            deletePO(data) {
                Swal.fire({
                    title: '¿Estás seguro de querer eliminar este Registro?',
                    text: "¡Si se elimina no se podrá revertir!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                        'Eliminadó!',
                        '¡El registro se eliminó correctamente!',
                        'success'
                        )
                        data._method = 'DELETE';
                        var id = data.id ? data.id : data.ElMaOP[0];
                        //console.log(id)
                        $('#t_op').DataTable().clear();
                        $('#t_op').DataTable().destroy()
                        this.$inertia.post('/Produccion/CarOpe/' + id, data, {
                            onSuccess: () => { this.tablaOpe(), this.alertDelete() },
                            onError: () => {this.tablaOpe()},
                            preserveState: true
                        });
                    }
                })
            },
            editPO(form){
                this.limp = 2;
                this.editModePo = true;
                this.proc_prin = form.proceso.proceso_id;
                this.formPacOpe.id = form.id;
                this.formPacOpe.proceso_id = form.proceso_id;
                this.formPacOpe.dep_perf_id = form.dep_perf_id;
                this.formPacOpe.maq_pro_id = form.maq_pro_id;
            },
            updatePO(data){
                this.btnOff = false;
                //console.log(data)
                $('#t_op').DataTable().destroy();
                this.$inertia.put('/Produccion/CarOpe/' + data.id, data, {
                    onSuccess: () => {this.reCarga(), this.tablaOpe(), this.resetPO(), this.alertSucces(), this.btnOff = true}, onError: () => {this.tablaOpe(), this.btnOff = true}
                });
            },
            /***************************** Carga de paquetes de norma, claves y partida *********************/
            savePN(form){
                this.btnOff = false;
                //console.log(form)
                form.departamento_id = this.S_Area;
                //$('#t_pn').DataTable().clear();
                $('#t_pn').DataTable().destroy();
                this.$inertia.post('/Produccion/CarNor', form, {
                    onSuccess: (v) => { this.tablaNor(), this.resetCA(), this.alertSucces(), this.btnOff = true}, onError: (e) => { this.tablaNor(), this.btnOff = true}, preserveState: true
                });
            },
            deletePN(data){
                Swal.fire({
                    title: '¿Estás seguro de querer eliminar este Registro?',
                    text: "¡Si se elimina no se podrá revertir!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                        'Eliminadó!',
                        '¡El registro se eliminó correctamente!',
                        'success'
                        )
                        data._method = 'DELETE';
                        var id = !data.ElMaPN ? data.id : data.ElMaPN[0];
                        /* console.log(data)
                        console.log(id) */
                        $('#t_pn').DataTable().clear();
                        $('#t_pn').DataTable().destroy()
                        this.$inertia.post('/Produccion/CarNor/' + id, data, {
                            onSuccess: () => { this.tablaNor(), this.alertDelete() }, onError: () => {this.tablaNor()}, preserveState: true
                        });
                    }
                })
            },
            /****************************** Carga de notas *************************************************/
            notaCA(form){
                //console.log(form)
                this.resetCA();
                this.form.id = form.id;
                this.form.agNot = 1;
                this.form.notaPen = 2;
                this.form.nota = '';
                $('#agPer').addClass('show')

            },
            notaOB(form){
                this.resetCA();
                this.form.id = form.id;
                this.form.agNot = 1;
                this.form.notaPen = 2;
                this.form.nota = '';
                $('#agObjec').addClass('show')
            },
            saveNot(data){
                this.btnOff = false;
                $('#t_carg').DataTable().clear();
                $('#t_carg').DataTable().destroy();
                this.$inertia.put('/Produccion/Nota/' + data.id, data, {
                    onSuccess: () => {this.reCarga(), this.resetCA(), this.tabla(), this.alertSucces(), this.btnOff = true}, onError: () => {this.tabla(), this.btnOff = true},
                });
            },
            /****************************** Carga de paquetes para objetivos *******************************/
            savePObje(form){
                this.btnOff = false;
                $('#t_ob').DataTable().destroy();
                this.$inertia.post('/Produccion/ObjeCordi', form, {
                    onSuccess: (v) => { this.resetOB(), this.alertSucces(), this.btnOff = true, this.tablaObje()},
                    onError: (e) => { this.btnOff = true, this.tablaObje()},
                    preserveState: true
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
            updateOB(data){
                //console.log(data)
                $('#t_ob').DataTable().destroy();
                this.btnOff = false;
                this.$inertia.put('/Produccion/ObjeCordi/' + data.id, data, {
                    onSuccess: (v) => { this.resetOB(), this.alertSucces(), this.tablaObje(), this.btnOff = true},
                    onError: (e) => { this.tablaObje(), this.btnOff = true},
                    preserveState: true
                });
            },
            deleteOB(data){
                //console.log(data)
                $('#t_ob').DataTable().destroy();
                data._method = 'DELETE';
                this.$inertia.post('/Produccion/ObjeCordi/' + data.id, data, {
                    onSuccess: () => { this.tablaObje(), this.alertDelete() }, onError: () => {this.tablaObje()}, preserveState: true
                });
            }
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
            //Opciones procesos principales
            opcPP: function() {
                const ppi = [];
                this.procesos.forEach(pp =>{
                    if (pp.tipo == 0 & pp.tipo_carga == 'pro') {
                        ppi.push({text: pp.nompro, value: pp.id})
                    }
                });
                return ppi;
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
            //Opciones Normas
            opcNM: function() {
                const nm = [];
                this.materiales.forEach(ma => {
                    nm.push({value: ma.id, text: ma.materiales.idmat+' - '+ma.materiales.nommat});
                })
                return nm;
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
            //Opciones maquinas
            opcMQ: function() {
                if (this.limp == 1) {
                    this.form.maq_pro_id = ''
                    this.formPacOpe.maq_pro_id = ''
                }
                const mq = [];
                var mar = '';
                if (this.form.proceso_id != '' | this.formPacOpe.proceso_id != '') {
                    this.procesos.forEach(pm => {
                        if (this.form.proceso_id == pm.id | this.formPacOpe.proceso_id ==  pm.id ) {
                            pm.maq_pros.forEach(mp => {
                                mar = mp.maquinas.marca == null ? 'N/A' :  mp.maquinas.marca.Nombre
                                mq.push({value: mp.id, text: mp.id+' - '+mp.maquinas.Nombre + ' ' + mar});
                            })
                        }
                    })
                }
                return mq;
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
            //Opciones Claves
            opcCL: function() {
                const scl = [];
                /* this.form.clave_id = ''; */
                if (this.form.norma != '') {
                    this.materiales.forEach(cl => {
                        if (this.form.norma == cl.id) {
                            //console.log(cl.claves)
                            cl.claves.forEach(c => {
                                scl.push({id: c.id, text: c.CVE_ART+ ' - ' + c.DESCR})
                            })
                        }
                    })
                }
                return scl;
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
            //opciones Paquetes Operador
            opcPaOp: function() {
                const po = [];
                if (this.usuario.dep_pers.length != 0) {
                    this.paqope.forEach(op => {
                        this.usuario.dep_pers.forEach(dep => {
                            if (dep.departamento_id == this.S_Area) {
                                if (op.dep_perf_id == dep.id) {
                                    //console.log(op)
                                    po.push({id: op.id, text: op.proceso.nompro+' - '+op.maq_pro.maquinas.Nombre+' '+op.maq_pro.maquinas.marca.Nombre})
                                }
                            }
                        });
                    })
                }
                return po;
            },
            //opciones Paquetes Norma
            opcPaNo: function() {
                const no = [];
                this.paqnor.forEach(pn => {
                    if (pn.departamento_id == this.S_Area) {
                        no.push({id: pn.id, text: pn.partida+' / '+pn.dep_mat.materiales.idmat+' / '+pn.clave.DESCR});
                    }
                })
                return no;
            },
            //opciones Paquetes Objetivos
            opcPaOb: function() {
                const ob = [];
                var clave = '';
                this.objetivos.forEach(po => {
                    if (po.departamento_id == this.S_Area) {
                        clave = po.clave_id == null ? 'N/A' : po.clave.CVE_ART
                        ob.push({id: po.id, text: po.proceso.nompro+' || '+po.maq_pro.maquinas.Nombre+' '+po.maq_pro.maquinas.marca.Nombre+' || '+po.dep_mat.materiales.idmat+' || '+clave})
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
            //unidad de medida de las claves
            uni_me: function() {
                var uni = '--';
                if (this.form.clave_id != '') {
                    this.materiales.forEach(cl => {
                        if (this.form.norma == cl.id) {
                            cl.claves.forEach(c => {
                                uni = c.UNI_MED;
                            })
                        }
                    })
                }
                return uni;
            }
        },
        watch: {
            S_Area: function(b){
                $('#t_op').DataTable().destroy();
                $('#t_pn').DataTable().destroy();
                $('#t_carg').DataTable().destroy();
                $('#t_ob').DataTable().destroy();
                this.resetCA();
                this.resetOB();
                this.proc_prin = '';
                /* await axios.get('/Produccion/Carga',{ busca: b })
                .then(() => { this.reCarga(), this.tabla(), this.tablaOpe(), this.tablaNor(), this.tablaObje() })
                .catch(err => { this.tabla(), this.tablaOpe(), this.tablaNor(), this.tablaObje() }) */
                this.$inertia.get('/Produccion/Carga',{ busca: b }, {
                    onSuccess: () => { this.reCarga(), this.tabla(), this.tablaOpe(), this.tablaNor(), this.tablaObje() }, onError: () => {this.tabla(), this.tablaOpe(), this.tablaNor(), this.tablaObje()  }, preserveState: true
                });
            },
            proc_prin: function(v) {
                //cuando no se edita
                if (!this.editMode) {
                    this.form.proceso_id = '';
                    this.form.maq_pro_id = '';
                    this.form.clave_id = '';
                    this.form.norma = '';
                }
            },
            paqNorma: function(paN) {
                //console.log(paN)
                if (paN == '') {
                    this.form.partida = '';
                    this.form.norma = '';
                    this.form.clave_id = '';
                }else{
                    this.paqnor.forEach(pn => {
                        if (pn.id == paN) {
                            this.form.partida = pn.partida;
                            this.form.norma = pn.norma;
                            this.form.clave_id = pn.clave_id;
                        }
                    })
                }
            },
            paqOpera: function(paO) {
                //console.log(paO)
                if (paO == '') {
                    this.form.id = null;
                    this.form.proceso_id = '';
                    this.form.dep_perf_id = '';
                    this.form.maq_pro_id = '';
                }else{
                    this.paqope.forEach(po => {
                        if (po.id == paO) {
                            this.limp = 2;
                            this.form.proceso_id = po.proceso_id;
                            this.form.dep_perf_id = po.dep_perf_id;
                            this.form.maq_pro_id = po.maq_pro_id;
                        }
                    })
                }
            },
            paqObjetivo: function(paOb){
                if (paOb == '') {
                    this.form.proceso_id = '';
                    this.form.maq_pro_id = '';
                    this.form.norma = '';
                    this.form.clave_id = '';
                }else{
                    this.calcuObje = 0;
                    this.form.valor = '';
                    const resu = this.objetivos.find(obje => obje.id == paOb);
                    this.limp = 2;
                    this.form.departamento_id = this.S_Area;
                    this.form.proceso_id = resu.proceso_id;
                    this.form.maq_pro_id = resu.maq_pro_id;
                    this.form.norma = resu.norma;
                    this.form.clave_id = resu.clave_id;
                }
            },
            calcuObje: function(calObj) {
                if (calObj <= 0 || calObj > 12) {
                    this.form.valor = '';
                    this.calcuObje = '';
                }
                if (this.paqObjetivo != '' & calObj != '') {
                    const resu = this.objetivos.find(obje => obje.id == this.paqObjetivo);
                    this.form.valor = resu.pro_hora * calObj;
                    //console.log(this.form.valor)
                }
            }
        }
    }
</script>
