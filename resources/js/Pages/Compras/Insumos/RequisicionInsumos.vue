<template>
  <app-layout>
    <div class="uppercase tw-mx-4">
        <Header :class="[color, style]">
            <slot>
                <h3 class="tw-p-2">
                    <i class="fas fa-store tw-ml-3 tw-mr-3"></i>
                        Requisiciones de Insumos
                </h3>
            </slot>
        </Header>

        <div class="tw-mt-8">
            <div class="tw-flex tw-justify-end">
                <div>
                    <jet-button @click="openInsumos" class="BtnNuevo">Solicita Insumos</jet-button>
                </div>
            </div>

            <div class="tw-overflow-x-auto tw-mx-2">
<!--                 <Table id="perfiles">
                    <template v-slot:TableHeader>
                        <th class="columna">dato</th>
                        <th class="columna">Acciones</th>
                    </template>

                    <template v-slot:TableFooter>
                        <tr class="fila" v-for="dato in datos" :key="dato.id">
                            <td class="tw-p-2">{{ dato.var }}</td>
                            <td class="fila">
                                <div class="columnaIconos">
                                    <div class="iconoDetails" @click="show(dato)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <span tooltip="Detalles" flow="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="iconoEdit" @click="edit(dato)">
                                        <span tooltip="Editar" flow="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="iconoDelete" @click="deleteRow(dato)">
                                        <span tooltip="Eliminar" flow="left">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>
                </Table> -->
            </div>
<!--
            <div class="tw-flex tw-justify-center">
            <div class="tw-w-auto tw-px-4 tw-mb-12 tw-place-items-center">
                <div class="flex tw-relative tw-flex-col tw-w-full tw-min-w-0 tw-mb-6 tw-text-white tw-break-words tw-bg-cyan-600 tw-rounded tw-shadow-lg">
                    <div class="tw-px-4 tw-py-3 tw-mb-0 tw-border-0 tw-rounded-t">
                        <div class="tw-flex tw-flex-wrap tw-items-center">
                            <div class="tw-relative tw-flex-1 tw-flex-grow tw-w-full tw-max-w-full tw-px-4 ">
                                <h3 class="tw-text-lg tw-font-semibold tw-text-white">Card Tables</h3>
                            </div>
                        </div>
                    </div>
                    <div class="tw-block tw-w-full tw-overflow-x-auto ">
                    <table class="tw-items-center tw-w-full tw-bg-transparent tw-border-collapse">
                        <thead>
                        <tr>
                            <th class="tw-px-6 tw-align-middle tw-border tw-border-solid tw-py-3 tw-text-xs tw-uppercase tw-border-l-0 tw-border-r-0 tw-whitespace-nowrap tw-font-semibold tw-text-left tw-bg-cyan-800 tw-text-cyan-300 tw-border-cyan-700">CANTIDAD</th>
                            <th class="tw-px-6 tw-align-middle tw-border tw-border-solid tw-py-3 tw-text-xs tw-uppercase tw-border-l-0 tw-border-r-0 tw-whitespace-nowrap tw-font-semibold tw-text-left tw-bg-cyan-800 tw-text-cyan-300 tw-border-cyan-700">MATERIAL</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td class="tw-border-t-0 tw-px-6 tw-align-middle tw-border-l-0 tw-border-r-0 tw-text-xs tw-whitespace-nowrap tw-p-4"><input type="number" class="tw-w-20 tw-text-blueGray-900"></td>
                            <td class="tw-border-t-0 tw-px-6 tw-align-middle tw-border-l-0 tw-border-r-0 tw-text-xs tw-whitespace-nowrap tw-p-4"><label for="">Lorem ipsum dolor sit amet.</label></td>
                        </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
            </div>
 -->
            <div class="tw-flex tw-flex-wrap">
                <div class="tw-w-1/3 tw-overflow-y-auto tw-p-2" style="height: 43rem;">
                    <ul class="tw-divide-y-2 tw-divide-black tw-divide-opacity-25 tw-text-sm" v-if="Session.roles[0].name == 'ONEPIECE' || Session.roles[0].name == 'Administrador'">
                        <li>Administrador</li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins1" class="tw-w-20"> <span>8/1  BOBINA CILINDRICA ENG. AMARILLO</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins2" class="tw-w-20"> <span>12/1  BOBINA CILINDRICA ENG. NEGRO</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins3" class="tw-w-20"> <span>16/1  BOBINA CILINDRICA ENG. VERDE</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins4" class="tw-w-20"> <span>20/1  BOBINA CILINDRICA ENG. AZUL</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins5" class="tw-w-20"> <span>BOBINA CILINDRICA ENG. NATURAL NUEVA</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins6" class="tw-w-20"> <span>BOBINA CILINDRICA ENG. DE PUNTA RECTA NATURAL</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins7" class="tw-w-20"> <span>BOLSA EMPAQUE POLIPAPEL 72X1.30C/250</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins8" class="tw-w-20"> <span>BOLSA EMPAQUE POLIPAPEL 75X1.30C/280</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins9" class="tw-w-20"> <span>BOLSA EMPAQUE POLIPAPEL 65X1.30C/250</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins10" class="tw-w-20"> <span>BOLSA P/POLVO POLIPAPEL. 100 X 180 CAL. 250</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins11" class="tw-w-20"> <span>BOLSA EMPAQUE POLIPAPEL 45X50C/60</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins12" class="tw-w-20"> <span>ROLLO DE POLIETILENO ABIERTO CAL.200</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins13" class="tw-w-20"> <span>CINTA ADHESIVA TRANSPARENTE DE 48 /150</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins14" class="tw-w-20"> <span>12/1 CONO ENG CARTON  4.20º X 170MM NEGRO (ESLOGAN)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins15" class="tw-w-20"> <span>16/1 CONO ENG. CARTON 4.20* X 170 MM VERDE O. (ESOGAN)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins16" class="tw-w-20"> <span>ETIQUETAS TERMICAS DE PRODUCCION (ROLLO DE 1000 PZA.)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins17" class="tw-w-20"> <span>ETIQUETAS TERMICAS PZAS ( rollos de  500 piezas)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins18" class="tw-w-20"> <span>ETIQUETA TECOYAR  (rollos de 1000 pzas)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins19" class="tw-w-20"> <span>ANTIESTATICO FIBERMATE FLD</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins20" class="tw-w-20"> <span>ANTIESTATICO FIBERMATE (LA AR-125 HLA)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins21" class="tw-w-20"> <span>ANTIESTATICO CHENSOLL</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins22" class="tw-w-20"> <span>GRAPAS PARA FLEJE</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins23" class="tw-w-20"> <span>LAZO  DE RAFIA POLYSNOP 75 CON ALMA</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins24" class="tw-w-20"> <span>POLIESTRECH MANUAL</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins25" class="tw-w-20"> <span>POLIESTRECH PARA PALETIZADORA (6,000 MTS)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins26" class="tw-w-20"> <span>CAJAS DE PARAFINA DE 20KG C/U (rieter 903 y 923)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins27" class="tw-w-20"> <span>CAJAS DE PARAFINA DE 20KG C/U</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins28" class="tw-w-20"> <span>CAJAS DE PARAFINA DE 20KG C/U (open end ACO9)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins29" class="tw-w-20"> <span>ROLLO DE FLEJE  PARA PALETS</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins30" class="tw-w-20"> <span>SEPARADOR DE CARTON 60 X 100 RECICLADO</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins31" class="tw-w-20"> <span>SEPARADOR DE CARTON 50 X 95 RECICLADO</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins32" class="tw-w-20"> <span>BROCHAS PARA OPENERO</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins33" class="tw-w-20"> <span>TARIMA DE MADERA ESTÁNDAR</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins34" class="tw-w-20"> <span>CONO ENG. CARTON 4°20X170 MM VERDE (BARRA)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins35" class="tw-w-20"> <span>CONO ENG. CARTON 4°20X170 MM NARANJA (BARRA)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins36" class="tw-w-20"> <span>CONO ENG. CARTON 4°20X170 MM NEGRO (BARRA)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins37" class="tw-w-20"> <span>CONO ENG. CARTON 4°20X170 MM NATURAL (ANILLO)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins38" class="tw-w-20"> <span>CAJAS DE PARAFINA DE 20 KG C/U (murata blue 7/8)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins39" class="tw-w-20"> <span>CAJAS DE PARAFINA DE 20 KG C/U (murata blue 3/4)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins40" class="tw-w-20"> <span>CAJA DUPONT</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins41" class="tw-w-20"> <span>CAJA FILSPEC</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins42" class="tw-w-20"> <span>TARIMA DUPONT</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins43" class="tw-w-20"> <span>TARIMA FILSPEC</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins44" class="tw-w-20"> <span>BOLSA NEGRA DE POLIETILENO 40X40 CAL. 200</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins45" class="tw-w-20"> <span>BOLSA NEGRA DE POLIERTILENO 75X130 CAL. 600</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins46" class="tw-w-20"> <span>BOLSA NEGRA DE POLIETILENO 50X130 CAL. 400</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins47" class="tw-w-20"> <span>HIL FOLSPEC ANTIBACTERIAL</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins48" class="tw-w-20"> <span>FIBRA DE PLATA</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins49" class="tw-w-20"> <span>CONO ENG. CARTON 5°57 (COBITEL)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins50" class="tw-w-20"> <span>CAJA PARA CUBRE BOCAS 100 pzs</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins51" class="tw-w-20"> <span>RESORTE BLANCO</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins52" class="tw-w-20"> <span>RESORTE NEGRO</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins53" class="tw-w-20"> <span>ELASTICO TRENZADO POLIESTER CRUDO 06 DE 4MM</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins54" class="tw-w-20"> <span>BOLSA DE CELOFAN PARA CUBRE BOCA 12X18CM (MILLAR)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins55" class="tw-w-20"> <span>FOIL COLOR NEGRO DE 40X240 MTS</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins56" class="tw-w-20"> <span>CONO DE HILO DURALON BLANCO</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins57" class="tw-w-20"> <span>CONO DE HLO DURALON NEGRO</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins58" class="tw-w-20"> <span>CAJA DE CARTON RM 12</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins59" class="tw-w-20"> <span>AJUSTADOR NASAL DE CUBRE BOCA (IMPOR. CHINA)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins60" class="tw-w-20"> <span>CAJA DE CARTON PARA MANGA LARGO 63, ANCHO 43 ALTO 39CM</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins61" class="tw-w-20"> <span>CONO DE HILO DURALON AMARILLO</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins62" class="tw-w-20"> <span>ETIQUETA TERMICA PARA IMPRESORA 100X25MM (AZUL)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins63" class="tw-w-20"> <span>ETIQUETA TERMICA PARA IMPRESORA 100X25MM (BLANCA) MILLAR</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins64" class="tw-w-20"> <span>ETIQUETA PARA MANGA TEJIDA</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins65" class="tw-w-20"> <span>ETIQUETA METALIZADA (MILLARES)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins66" class="tw-w-20"> <span>FIELTRO PARA CUBRE BOCAS (ROLLO)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins67" class="tw-w-20"> <span>HILO TEXTURIZADO AMARILLO</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins68" class="tw-w-20"> <span>CAJA PARA CUBRE BOCAS INDIVIDUAL (F. AHORRO) NF</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins69" class="tw-w-20"> <span>HOJA DE PRECENTACION PEQUEÑA (NUEVA)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins70" class="tw-w-20"> <span>CAJA PARA CUBRE BOCAS 55X50X23</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins71" class="tw-w-20"> <span>CAJA PARA CUBRE BOCAS INDIBIDUAL NV</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins72" class="tw-w-20"> <span>CAJA PARA CUBRE BOCA INFLATIL SHIELDTEX</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins73" class="tw-w-20"> <span>RIBBON PARA ETIQUETA METALIZADA</span></li>
                    </ul>
                     <!-- APERTURA -->
                    <ul class="tw-divide-y-2 tw-divide-black tw-divide-opacity-25 tw-text-sm" v-else-if="Session.Departamento == 7">
                        <li>APERTURA</li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins1" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">8/1  BOBINA CILINDRICA ENG. AMARILLO</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins2" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">12/1  BOBINA CILINDRICA ENG. NEGRO</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins3" class="tw-w-20"> <span>16/1  BOBINA CILINDRICA ENG. VERDE</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins4" class="tw-w-20"> <span>20/1  BOBINA CILINDRICA ENG. AZUL</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins5" class="tw-w-20"> <span>BOBINA CILINDRICA ENG. NATURAL NUEVA</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins6" class="tw-w-20"> <span>BOBINA CILINDRICA ENG. DE PUNTA RECTA NATURAL</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins7" class="tw-w-20"> <span>BOLSA EMPAQUE POLIPAPEL 72X1.30C/250</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins8" class="tw-w-20"> <span>BOLSA EMPAQUE POLIPAPEL 75X1.30C/280</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins9" class="tw-w-20"> <span>BOLSA EMPAQUE POLIPAPEL 65X1.30C/250</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins10" class="tw-w-20"> <span>BOLSA P/POLVO POLIPAPEL. 100 X 180 CAL. 250</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins11" class="tw-w-20"> <span>BOLSA EMPAQUE POLIPAPEL 45X50C/60</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins12" class="tw-w-20"> <span>ROLLO DE POLIETILENO ABIERTO CAL.200</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins13" class="tw-w-20"> <span>CINTA ADHESIVA TRANSPARENTE DE 48 /150</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins14" class="tw-w-20"> <span>12/1 CONO ENG CARTON  4.20º X 170MM NEGRO (ESLOGAN)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins15" class="tw-w-20"> <span>16/1 CONO ENG. CARTON 4.20* X 170 MM VERDE O. (ESOGAN)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins16" class="tw-w-20"> <span>ETIQUETAS TERMICAS DE PRODUCCION (ROLLO DE 1000 PZA.)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins17" class="tw-w-20"> <span>ETIQUETAS TERMICAS PZAS ( rollos de  500 piezas)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins18" class="tw-w-20"> <span>ETIQUETA TECOYAR  (rollos de 1000 pzas)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins19" class="tw-w-20"> <span>ANTIESTATICO FIBERMATE FLD</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins20" class="tw-w-20"> <span>ANTIESTATICO FIBERMATE (LA AR-125 HLA)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins21" class="tw-w-20"> <span>ANTIESTATICO CHENSOLL</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins22" class="tw-w-20"> <span>GRAPAS PARA FLEJE</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins23" class="tw-w-20"> <span>LAZO  DE RAFIA POLYSNOP 75 CON ALMA</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins24" class="tw-w-20"> <span>POLIESTRECH MANUAL</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins25" class="tw-w-20"> <span>POLIESTRECH PARA PALETIZADORA (6,000 MTS)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins26" class="tw-w-20"> <span>CAJAS DE PARAFINA DE 20KG C/U (rieter 903 y 923)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins27" class="tw-w-20"> <span>CAJAS DE PARAFINA DE 20KG C/U</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins28" class="tw-w-20"> <span>CAJAS DE PARAFINA DE 20KG C/U (open end ACO9)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins29" class="tw-w-20"> <span>ROLLO DE FLEJE  PARA PALETS</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins30" class="tw-w-20"> <span>SEPARADOR DE CARTON 60 X 100 RECICLADO</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins31" class="tw-w-20"> <span>SEPARADOR DE CARTON 50 X 95 RECICLADO</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins32" class="tw-w-20"> <span>BROCHAS PARA OPENERO</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins33" class="tw-w-20"> <span>TARIMA DE MADERA ESTÁNDAR</span></li>
                    </ul>
                    <!-- HILATURA DE ANILLO -->
                    <ul class="tw-divide-y-2 tw-divide-black tw-divide-opacity-25 tw-text-sm" v-else-if="Session.Departamento == 8">
                        <li>HILATURA DE ANILLO</li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins34" class="tw-w-20"> <span>CONO ENG. CARTON 4°20X170 MM VERDE (BARRA)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins35" class="tw-w-20"> <span>CONO ENG. CARTON 4°20X170 MM NARANJA (BARRA)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins36" class="tw-w-20"> <span>CONO ENG. CARTON 4°20X170 MM NEGRO (BARRA)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins37" class="tw-w-20"> <span>CONO ENG. CARTON 4°20X170 MM NATURAL (ANILLO)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins38" class="tw-w-20"> <span>CAJAS DE PARAFINA DE 20 KG C/U (murata blue 7/8)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins39" class="tw-w-20"> <span>CAJAS DE PARAFINA DE 20 KG C/U (murata blue 3/4)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins40" class="tw-w-20"> <span>CAJA DUPONT</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins41" class="tw-w-20"> <span>CAJA FILSPEC</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins42" class="tw-w-20"> <span>TARIMA DUPONT</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins43" class="tw-w-20"> <span>TARIMA FILSPEC</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins44" class="tw-w-20"> <span>BOLSA NEGRA DE POLIETILENO 40X40 CAL. 200</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins45" class="tw-w-20"> <span>BOLSA NEGRA DE POLIERTILENO 75X130 CAL. 600</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins46" class="tw-w-20"> <span>BOLSA NEGRA DE POLIETILENO 50X130 CAL. 400</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins47" class="tw-w-20"> <span>HIL FOLSPEC ANTIBACTERIAL</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins48" class="tw-w-20"> <span>FIBRA DE PLATA</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins49" class="tw-w-20"> <span>CONO ENG. CARTON 5°57 (COBITEL)</span></li>
                    </ul>
                    <!-- TEJIDO -->
                    <ul class="tw-divide-y-2 tw-divide-black tw-divide-opacity-25 tw-text-sm" v-else-if="Session.Departamento == 13">
                        <li>TEJIDO</li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins50" class="tw-w-20"> <span>CAJA PARA CUBRE BOCAS 100 pzs</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins51" class="tw-w-20"> <span>RESORTE BLANCO</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins52" class="tw-w-20"> <span>RESORTE NEGRO</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins53" class="tw-w-20"> <span>ELASTICO TRENZADO POLIESTER CRUDO 06 DE 4MM</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins54" class="tw-w-20"> <span>BOLSA DE CELOFAN PARA CUBRE BOCA 12X18CM (MILLAR)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins55" class="tw-w-20"> <span>FOIL COLOR NEGRO DE 40X240 MTS</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins56" class="tw-w-20"> <span>CONO DE HILO DURALON BLANCO</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins57" class="tw-w-20"> <span>CONO DE HLO DURALON NEGRO</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins58" class="tw-w-20"> <span>CAJA DE CARTON RM 12</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins59" class="tw-w-20"> <span>AJUSTADOR NASAL DE CUBRE BOCA (IMPOR. CHINA)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins60" class="tw-w-20"> <span>CAJA DE CARTON PARA MANGA LARGO 63, ANCHO 43 ALTO 39CM</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins61" class="tw-w-20"> <span>CONO DE HILO DURALON AMARILLO</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins62" class="tw-w-20"> <span>ETIQUETA TERMICA PARA IMPRESORA 100X25MM (AZUL)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins63" class="tw-w-20"> <span>ETIQUETA TERMICA PARA IMPRESORA 100X25MM (BLANCA) MILLAR</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins64" class="tw-w-20"> <span>ETIQUETA PARA MANGA TEJIDA</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins65" class="tw-w-20"> <span>ETIQUETA METALIZADA (MILLARES)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins66" class="tw-w-20"> <span>FIELTRO PARA CUBRE BOCAS (ROLLO)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins67" class="tw-w-20"> <span>HILO TEXTURIZADO AMARILLO</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins68" class="tw-w-20"> <span>CAJA PARA CUBRE BOCAS INDIVIDUAL (F. AHORRO) NF</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins69" class="tw-w-20"> <span>HOJA DE PRECENTACION PEQUEÑA (NUEVA)</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins70" class="tw-w-20"> <span>CAJA PARA CUBRE BOCAS 55X50X23</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins71" class="tw-w-20"> <span>CAJA PARA CUBRE BOCAS INDIBIDUAL NV</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins72" class="tw-w-20"> <span>CAJA PARA CUBRE BOCA INFLATIL SHIELDTEX</span></li>
                        <li class="tw-p-2"><input type="number" min="1" v-model="form.Ins73" class="tw-w-20"> <span>RIBBON PARA ETIQUETA METALIZADA</span></li>
                    </ul>

                    <jet-button type="button" @click="save(form)" v-show="!editMode">Guardar</jet-button>
                     <jet-button type="button" @click="reset()">Limpiar</jet-button>
                </div>
                <div class="tw-w-2/3">

                </div>
            </div>

        </div>

        <modal :show="showModalInsumos" @close="chageCloseInsumos" :maxWidth="tam">
            <form>
                <div class="tw-px-4 tw-py-4">
                    <div class="tw-text-lg">
                        <div class="ModalHeader">
                            <h3 class="tw-p-2"><i class="tw-ml-3 tw-mr-3 fas fa-scroll"></i>Registro de Información     {{ NumInsumos }}</h3>
                        </div>
                    </div>

                    <div class="tw-mt-4">
                        <div class="ModalForm tw-overflow-y-auto tw-h-96">

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Cantidad</jet-label>
                                    <jet-input type="number" min="1" v-model="form.Ins1"></jet-input>
                                    <small v-if="errors.Ins1" class="validation-alert">{{errors.Ins1}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-10/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Material</jet-label>
                                    <jet-input type="text" min="1" value="8/1  BOBINA CILINDRICA ENG. AMARILLO"></jet-input>
                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Cantidad</jet-label>
                                    <jet-input type="number" min="1" v-model="form.Ins2"></jet-input>
                                    <small v-if="errors.Ins2" class="validation-alert">{{errors.Ins2}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-10/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Material</jet-label>
                                    <jet-input type="text" min="1" value="12/1  BOBINA CILINDRICA ENG. NEGRO"></jet-input>
                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Cantidad</jet-label>
                                    <jet-input type="number" min="1" v-model="form.Ins3"></jet-input>
                                    <small v-if="errors.Ins3" class="validation-alert">{{errors.Ins3}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-10/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Material</jet-label>
                                    <jet-input type="text" min="1" value="16/1  BOBINA CILINDRICA ENG. VERDE"></jet-input>
                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Cantidad</jet-label>
                                    <jet-input type="number" min="1" v-model="form.Ins4"></jet-input>
                                    <small v-if="errors.Ins4" class="validation-alert">{{errors.Ins4}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-10/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Material</jet-label>
                                    <jet-input type="text" min="1" value="20/1  BOBINA CILINDRICA ENG. AZUL"></jet-input>
                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Cantidad</jet-label>
                                    <jet-input type="number" min="1" v-model="form.Ins5"></jet-input>
                                    <small v-if="errors.Ins5" class="validation-alert">{{errors.Ins5}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-10/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Material</jet-label>
                                    <jet-input type="text" min="1" value="BOBINA CILINDRICA ENG. NATURAL NUEVA"></jet-input>
                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Cantidad</jet-label>
                                    <jet-input type="number" min="1" v-model="form.Ins6"></jet-input>
                                    <small v-if="errors.Ins6" class="validation-alert">{{errors.Ins6}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-10/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Material</jet-label>
                                    <jet-input type="text" min="1" value="BOBINA CILINDRICA ENG. DE PUNTA RECTA NATURAL"></jet-input>
                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Cantidad</jet-label>
                                    <jet-input type="number" min="1" v-model="form.Ins7"></jet-input>
                                    <small v-if="errors.Ins7" class="validation-alert">{{errors.Ins7}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-10/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Material</jet-label>
                                    <jet-input type="text" min="1" value="BOLSA EMPAQUE POLIPAPEL 72X1.30C/250"></jet-input>
                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Cantidad</jet-label>
                                    <jet-input type="number" min="1" v-model="form.Ins8"></jet-input>
                                    <small v-if="errors.Ins8" class="validation-alert">{{errors.Ins8}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-10/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Material</jet-label>
                                    <jet-input type="text" min="1" value="BOLSA EMPAQUE POLIPAPEL 75X1.30C/280"></jet-input>
                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Cantidad</jet-label>
                                    <jet-input type="number" min="1" v-model="form.Ins9"></jet-input>
                                    <small v-if="errors.Ins9" class="validation-alert">{{errors.Ins9}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-10/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Material</jet-label>
                                    <jet-input type="text" min="1" value="BOLSA EMPAQUE POLIPAPEL 65X1.30C/250"></jet-input>
                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Cantidad</jet-label>
                                    <jet-input type="number" min="1" v-model="form.Ins10"></jet-input>
                                    <small v-if="errors.Ins10" class="validation-alert">{{errors.Ins10}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-10/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Material</jet-label>
                                    <jet-input type="text" min="1" value="BOLSA P/POLVO POLIPAPEL. 100 X 180 CAL. 250"></jet-input>
                                </div>
                            </div>

                            <div class="tw-mb-6 md:tw-flex">
                                <div class="tw-px-3 tw-mb-6 md:tw-w-2/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Cantidad</jet-label>
                                    <jet-input type="number" min="1" v-model="form.Ins10"></jet-input>
                                    <small v-if="errors.Ins10" class="validation-alert">{{errors.Ins10}}</small>
                                </div>
                                <div class="tw-px-3 tw-mb-6 md:tw-w-10/12 md:tw-mb-0">
                                    <jet-label><span class="required">*</span>Material</jet-label>
                                    <jet-input type="text" min="1" value="BOLSA P/POLVO POLIPAPEL. 100 X 180 CAL. 250"></jet-input>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ModalFooter">
                    <jet-button type="button" @click="save(form)" v-show="!editMode">Guardar</jet-button>
                    <jet-button type="button" @click="update(form)" v-show="editMode">Actualizar</jet-button>
                    <jet-CancelButton @click="chageClose">Cerrar</jet-CancelButton>
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
import Table from "@/Components/Table";
import JetButton from "@/Components/Button";
import JetCancelButton from "@/Components/CancelButton";
import Modal from "@/Jetstream/Modal";
import Pagination from "@/Components/pagination";
import JetInput from "@/Components/Input";
import JetSelect from "@/Components/Select";
//imports de datatables
import datatable from "datatables.net-bs5";
import $ from "jquery";
import moment from 'moment';
import 'moment/locale/es';

export default {
    mounted() {
        // this.tabla();
    },

    data() {
        return {
            tam: "3xl",
            color: "tw-bg-cyan-600",
            style: "tw-mt-2 tw-text-center tw-text-white tw-shadow-xl tw-rounded-2xl",
            showModalInsumos: false,
            form: {
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
                Ins1: null,
                Ins2: null,
                Ins3: null,
                Ins4: null,
                Ins5: null,
                Ins6: null,
                Ins7: null,
                Ins8: null,
                Ins9: null,
                Ins10: null,
                Ins11: null,
                Ins12: null,
                Ins13: null,
                Ins14: null,
                Ins15: null,
                Ins16: null,
                Ins17: null,
                Ins18: null,
                Ins19: null,
                Ins20: null,
                Ins21: null,
                Ins22: null,
                Ins23: null,
                Ins24: null,
                Ins25: null,
                Ins26: null,
                Ins27: null,
                Ins28: null,
                Ins29: null,
                Ins30: null,
                Ins31: null,
                Ins32: null,
                Ins33: null,
                Ins34: null,
                Ins35: null,
                Ins36: null,
                Ins37: null,
                Ins38: null,
                Ins39: null,
                Ins40: null,
                Ins41: null,
                Ins42: null,
                Ins43: null,
                Ins44: null,
                Ins45: null,
                Ins46: null,
                Ins47: null,
                Ins48: null,
                Ins49: null,
                Ins50: null,
                Ins51: null,
                Ins52: null,
                Ins53: null,
                Ins54: null,
                Ins55: null,
                Ins56: null,
                Ins57: null,
                Ins58: null,
                Ins59: null,
                Ins60: null,
                Ins61: null,
                Ins62: null,
                Ins63: null,
                Ins64: null,
                Ins65: null,
                Ins66: null,
                Ins67: null,
                Ins68: null,
                Ins69: null,
                Ins70: null,
                Ins71: null,
                Ins72: null,
                Ins73: null,
                Ins74: null,
                Ins75: null,
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
        JetSelect,
    },

    props: {
        Session: Object,
        errors: Object,
        Insumos: Object,
        NumInsumos: Object,
    },

    methods: {
        reset() {
            this.form = {
                IdUser: this.Session.id,
                IdEmp: this.Session.IdEmp,
                Ins1: null,
                Ins2: null,
                Ins3: null,
                Ins4: null,
                Ins5: null,
                Ins6: null,
                Ins7: null,
                Ins8: null,
                Ins9: null,
                Ins10: null,
                Ins11: null,
                Ins12: null,
                Ins13: null,
                Ins14: null,
                Ins15: null,
                Ins16: null,
                Ins17: null,
                Ins18: null,
                Ins19: null,
                Ins20: null,
                Ins21: null,
                Ins22: null,
                Ins23: null,
                Ins24: null,
                Ins25: null,
                Ins26: null,
                Ins27: null,
                Ins28: null,
                Ins29: null,
                Ins30: null,
                Ins31: null,
                Ins32: null,
                Ins33: null,
                Ins34: null,
                Ins35: null,
                Ins36: null,
                Ins37: null,
                Ins38: null,
                Ins39: null,
                Ins40: null,
                Ins41: null,
                Ins42: null,
                Ins43: null,
                Ins44: null,
                Ins45: null,
                Ins46: null,
                Ins47: null,
                Ins48: null,
                Ins49: null,
                Ins50: null,
                Ins51: null,
                Ins52: null,
                Ins53: null,
                Ins54: null,
                Ins55: null,
                Ins56: null,
                Ins57: null,
                Ins58: null,
                Ins59: null,
                Ins60: null,
                Ins61: null,
                Ins62: null,
                Ins63: null,
                Ins64: null,
                Ins65: null,
                Ins66: null,
                Ins67: null,
                Ins68: null,
                Ins69: null,
                Ins70: null,
                Ins71: null,
                Ins72: null,
                Ins73: null,
                Ins74: null,
                Ins75: null,
            };
        },

        openInsumos() {
            this.chageCloseInsumos();
            this.reset();
            this.editMode = false;
        },

        chageCloseInsumos() {
            this.showModalInsumos = !this.showModalInsumos;
        },

        //datatable
        tabla() {
            this.$nextTick(() => {
                $("#Papeleria").DataTable({
                language: this.español,
                });
            });
        },

        addRow: function () {
            this.form.Partida.push({Part: ""});
        },

        removeRow: function (row) {
            this.form.Partida.splice(row,1);
        },

        save(data) {
            console.log(data);
            this.$inertia.post("/Compras/Insumos", data, {
                onSuccess: () => {
                    this.reset(),
                    this.chageClose(),
                    this.alertSucces();
                },
            });
        },
    },
};
</script>
