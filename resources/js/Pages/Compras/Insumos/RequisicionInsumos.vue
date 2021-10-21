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
            <div class="tw-flex tw-gap-4">
                <div class="tw-w-1/3 tw-overflow-y-auto tw-p-2" style="height: 43rem;">
                    <ul class="tw-divide-y-2 tw-divide-black tw-divide-opacity-25 tw-text-sm" v-if="Session.roles[0].name == 'ONEPIECE' || Session.roles[0].name == 'Administrador'">
                        <li>Administrador</li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins1" class="tw-w-20 tw-h-8"><span class="tw-text-xs tw-font-bold">8/1  BOBINA CILINDRICA ENG. AMARILLO</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins2" class="tw-w-20 tw-h-8"><span class="tw-text-xs tw-font-bold">12/1  BOBINA CILINDRICA ENG. NEGRO</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins3" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">16/1  BOBINA CILINDRICA ENG. VERDE</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins4" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">20/1  BOBINA CILINDRICA ENG. AZUL</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins5" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">BOBINA CILINDRICA ENG. NATURAL NUEVA</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins6" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">BOBINA CILINDRICA ENG. DE PUNTA RECTA NATURAL</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins7" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">BOLSA EMPAQUE POLIPAPEL 72X1.30C/250</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins8" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">BOLSA EMPAQUE POLIPAPEL 75X1.30C/280</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins9" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">BOLSA EMPAQUE POLIPAPEL 65X1.30C/250</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins10" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">BOLSA P/POLVO POLIPAPEL. 100 X 180 CAL. 250</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins11" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">BOLSA EMPAQUE POLIPAPEL 45X50C/60</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins12" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">ROLLO DE POLIETILENO ABIERTO CAL.200</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins13" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CINTA ADHESIVA TRANSPARENTE DE 48 /150</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins14" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">12/1 CONO ENG CARTON  4.20º X 170MM NEGRO (ESLOGAN)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins15" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">16/1 CONO ENG. CARTON 4.20* X 170 MM VERDE O. (ESOGAN)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins16" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">ETIQUETAS TERMICAS DE PRODUCCION (ROLLO DE 1000 PZA.)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins17" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">ETIQUETAS TERMICAS PZAS ( rollos de  500 piezas)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins18" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">ETIQUETA TECOYAR  (rollos de 1000 pzas)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins19" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">ANTIESTATICO FIBERMATE FLD</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins20" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">ANTIESTATICO FIBERMATE (LA AR-125 HLA)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins21" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">ANTIESTATICO CHENSOLL</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins22" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">GRAPAS PARA FLEJE</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins23" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">LAZO  DE RAFIA POLYSNOP 75 CON ALMA</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins24" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">POLIESTRECH MANUAL</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins25" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">POLIESTRECH PARA PALETIZADORA (6,000 MTS)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins26" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CAJAS DE PARAFINA DE 20KG C/U (rieter 903 y 923)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins27" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CAJAS DE PARAFINA DE 20KG C/U</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins28" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CAJAS DE PARAFINA DE 20KG C/U (open end ACO9)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins29" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">ROLLO DE FLEJE  PARA PALETS</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins30" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">SEPARADOR DE CARTON 60 X 100 RECICLADO</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins31" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">SEPARADOR DE CARTON 50 X 95 RECICLADO</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins32" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">BROCHAS PARA OPENERO</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins33" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">TARIMA DE MADERA ESTÁNDAR</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins34" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CONO ENG. CARTON 4°20X170 MM VERDE (BARRA)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins35" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CONO ENG. CARTON 4°20X170 MM NARANJA (BARRA)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins36" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CONO ENG. CARTON 4°20X170 MM NEGRO (BARRA)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins37" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CONO ENG. CARTON 4°20X170 MM NATURAL (ANILLO)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins38" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CAJAS DE PARAFINA DE 20 KG C/U (murata blue 7/8)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins39" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CAJAS DE PARAFINA DE 20 KG C/U (murata blue 3/4)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins40" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CAJA DUPONT</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins41" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CAJA FILSPEC</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins42" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">TARIMA DUPONT</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins43" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">TARIMA FILSPEC</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins44" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">BOLSA NEGRA DE POLIETILENO 40X40 CAL. 200</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins45" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">BOLSA NEGRA DE POLIERTILENO 75X130 CAL. 600</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins46" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">BOLSA NEGRA DE POLIETILENO 50X130 CAL. 400</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins47" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">HIL FOLSPEC ANTIBACTERIAL</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins48" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">FIBRA DE PLATA</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins49" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CONO ENG. CARTON 5°57 (COBITEL)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins50" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CAJA PARA CUBRE BOCAS 100 pzs</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins51" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">RESORTE BLANCO</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins52" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">RESORTE NEGRO</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins53" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">ELASTICO TRENZADO POLIESTER CRUDO 06 DE 4MM</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins54" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">BOLSA DE CELOFAN PARA CUBRE BOCA 12X18CM (MILLAR)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins55" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">FOIL COLOR NEGRO DE 40X240 MTS</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins56" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CONO DE HILO DURALON BLANCO</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins57" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CONO DE HLO DURALON NEGRO</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins58" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CAJA DE CARTON RM 12</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins59" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">AJUSTADOR NASAL DE CUBRE BOCA (IMPOR. CHINA)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins60" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CAJA DE CARTON PARA MANGA LARGO 63, ANCHO 43 ALTO 39CM</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins61" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CONO DE HILO DURALON AMARILLO</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins62" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">ETIQUETA TERMICA PARA IMPRESORA 100X25MM (AZUL)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins63" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">ETIQUETA TERMICA PARA IMPRESORA 100X25MM (BLANCA) MILLAR</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins64" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">ETIQUETA PARA MANGA TEJIDA</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins65" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">ETIQUETA METALIZADA (MILLARES)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins66" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">FIELTRO PARA CUBRE BOCAS (ROLLO)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins67" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">HILO TEXTURIZADO AMARILLO</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins68" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CAJA PARA CUBRE BOCAS INDIVIDUAL (F. AHORRO) NF</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins69" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">HOJA DE PRECENTACION PEQUEÑA (NUEVA)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins70" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CAJA PARA CUBRE BOCAS 55X50X23</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins71" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CAJA PARA CUBRE BOCAS INDIBIDUAL NV</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins72" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CAJA PARA CUBRE BOCA INFLATIL SHIELDTEX</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins73" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">RIBBON PARA ETIQUETA METALIZADA</span></li>
                    </ul>
                     <!-- APERTURA -->
                    <ul class="tw-divide-y-2 tw-divide-black tw-divide-opacity-25 tw-text-sm" v-else-if="Session.Departamento == 7">
                        <li>APERTURA</li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins1" class="tw-w-20 tw-h-8"><span class="tw-text-xs tw-font-bold">8/1  BOBINA CILINDRICA ENG. AMARILLO</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins2" class="tw-w-20 tw-h-8"><span class="tw-text-xs tw-font-bold">12/1  BOBINA CILINDRICA ENG. NEGRO</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins3" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">16/1  BOBINA CILINDRICA ENG. VERDE</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins4" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">20/1  BOBINA CILINDRICA ENG. AZUL</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins5" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">BOBINA CILINDRICA ENG. NATURAL NUEVA</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins6" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">BOBINA CILINDRICA ENG. DE PUNTA RECTA NATURAL</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins7" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">BOLSA EMPAQUE POLIPAPEL 72X1.30C/250</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins8" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">BOLSA EMPAQUE POLIPAPEL 75X1.30C/280</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins9" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">BOLSA EMPAQUE POLIPAPEL 65X1.30C/250</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins10" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">BOLSA P/POLVO POLIPAPEL. 100 X 180 CAL. 250</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins11" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">BOLSA EMPAQUE POLIPAPEL 45X50C/60</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins12" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">ROLLO DE POLIETILENO ABIERTO CAL.200</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins13" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CINTA ADHESIVA TRANSPARENTE DE 48 /150</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins14" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">12/1 CONO ENG CARTON  4.20º X 170MM NEGRO (ESLOGAN)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins15" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">16/1 CONO ENG. CARTON 4.20* X 170 MM VERDE O. (ESOGAN)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins16" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">ETIQUETAS TERMICAS DE PRODUCCION (ROLLO DE 1000 PZA.)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins17" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">ETIQUETAS TERMICAS PZAS ( rollos de  500 piezas)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins18" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">ETIQUETA TECOYAR  (rollos de 1000 pzas)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins19" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">ANTIESTATICO FIBERMATE FLD</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins20" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">ANTIESTATICO FIBERMATE (LA AR-125 HLA)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins21" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">ANTIESTATICO CHENSOLL</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins22" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">GRAPAS PARA FLEJE</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins23" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">LAZO  DE RAFIA POLYSNOP 75 CON ALMA</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins24" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">POLIESTRECH MANUAL</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins25" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">POLIESTRECH PARA PALETIZADORA (6,000 MTS)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins26" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CAJAS DE PARAFINA DE 20KG C/U (rieter 903 y 923)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins27" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CAJAS DE PARAFINA DE 20KG C/U</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins28" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CAJAS DE PARAFINA DE 20KG C/U (open end ACO9)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins29" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">ROLLO DE FLEJE  PARA PALETS</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins30" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">SEPARADOR DE CARTON 60 X 100 RECICLADO</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins31" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">SEPARADOR DE CARTON 50 X 95 RECICLADO</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins32" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">BROCHAS PARA OPENERO</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins33" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">TARIMA DE MADERA ESTÁNDAR</span></li>
                    </ul>
                    <!-- HILATURA DE ANILLO -->
                    <ul class="tw-divide-y-2 tw-divide-black tw-divide-opacity-25 tw-text-sm" v-else-if="Session.Departamento == 8">
                        <li>HILATURA DE ANILLO</li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins34" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CONO ENG. CARTON 4°20X170 MM VERDE (BARRA)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins35" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CONO ENG. CARTON 4°20X170 MM NARANJA (BARRA)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins36" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CONO ENG. CARTON 4°20X170 MM NEGRO (BARRA)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins37" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CONO ENG. CARTON 4°20X170 MM NATURAL (ANILLO)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins38" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CAJAS DE PARAFINA DE 20 KG C/U (murata blue 7/8)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins39" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CAJAS DE PARAFINA DE 20 KG C/U (murata blue 3/4)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins40" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CAJA DUPONT</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins41" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CAJA FILSPEC</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins42" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">TARIMA DUPONT</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins43" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">TARIMA FILSPEC</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins44" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">BOLSA NEGRA DE POLIETILENO 40X40 CAL. 200</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins45" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">BOLSA NEGRA DE POLIERTILENO 75X130 CAL. 600</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins46" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">BOLSA NEGRA DE POLIETILENO 50X130 CAL. 400</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins47" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">HIL FOLSPEC ANTIBACTERIAL</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins48" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">FIBRA DE PLATA</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins49" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CONO ENG. CARTON 5°57 (COBITEL)</span></li>
                    </ul>
                    <!-- TEJIDO -->
                    <ul class="tw-divide-y-2 tw-divide-black tw-divide-opacity-25 tw-text-sm" v-else-if="Session.Departamento == 13">
                        <li>TEJIDO</li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins50" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CAJA PARA CUBRE BOCAS 100 pzs</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins51" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">RESORTE BLANCO</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins52" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">RESORTE NEGRO</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins53" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">ELASTICO TRENZADO POLIESTER CRUDO 06 DE 4MM</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins54" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">BOLSA DE CELOFAN PARA CUBRE BOCA 12X18CM (MILLAR)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins55" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">FOIL COLOR NEGRO DE 40X240 MTS</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins56" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CONO DE HILO DURALON BLANCO</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins57" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CONO DE HLO DURALON NEGRO</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins58" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CAJA DE CARTON RM 12</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins59" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">AJUSTADOR NASAL DE CUBRE BOCA (IMPOR. CHINA)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins60" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CAJA DE CARTON PARA MANGA LARGO 63, ANCHO 43 ALTO 39CM</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins61" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CONO DE HILO DURALON AMARILLO</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins62" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">ETIQUETA TERMICA PARA IMPRESORA 100X25MM (AZUL)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins63" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">ETIQUETA TERMICA PARA IMPRESORA 100X25MM (BLANCA) MILLAR</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins64" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">ETIQUETA PARA MANGA TEJIDA</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins65" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">ETIQUETA METALIZADA (MILLARES)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins66" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">FIELTRO PARA CUBRE BOCAS (ROLLO)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins67" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">HILO TEXTURIZADO AMARILLO</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins68" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CAJA PARA CUBRE BOCAS INDIVIDUAL (F. AHORRO) NF</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins69" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">HOJA DE PRECENTACION PEQUEÑA (NUEVA)</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins70" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CAJA PARA CUBRE BOCAS 55X50X23</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins71" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CAJA PARA CUBRE BOCAS INDIBIDUAL NV</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins72" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">CAJA PARA CUBRE BOCA INFLATIL SHIELDTEX</span></li>
                        <li class="tw-p-1"><input type="text" min="1" v-model="form.Ins73" class="tw-w-20 tw-h-8"> <span class="tw-text-xs tw-font-bold">RIBBON PARA ETIQUETA METALIZADA</span></li>
                    </ul>

                    <div class="tw-flex tw-gap-2 tw-p-2 tw-justify-center">
                        <jet-button type="button" @click="save(form)" v-show="!editMode"> <i class="far fa-save tw-mr-2"></i> Guardar</jet-button>
                        <jet-button type="button" @click="reset()"><i class="fas fa-eraser tw-mr-2"></i> Limpiar</jet-button>
                    </div>
                </div>

                <div class="tw-overflow-x-auto tw-w-2/3">
                    <Table id="Insumos">
                        <template v-slot:TableHeader>
                            <th class="columna">CANTIDAD</th>
                            <th class="columna">MATERIAL</th>
                            <th class="columna">UNIDAD</th>
                            <th class="columna">DEPARTAMENTO</th>
                            <th class="columna">SOLICITANTE</th>
                            <th class="columna">ESTATUS</th>
                            <th class="columna">ACCIONES</th>
                        </template>

                        <template v-slot:TableFooter>
                            <tr class="fila" v-for="dato in ReqInsumos" :key="dato.id">
                                <td class="tw-p-2">{{ dato.Cantidad }}</td>
                                <td class="tw-p-2">{{ dato.requisiciones_insumos_material.Nombre }}</td>
                                <td class="tw-p-2">{{ dato.requisiciones_insumos_material.Unidad }}</td>
                                <td class="tw-p-2">{{ dato.requisicion_insumos_departamento.Nombre}}</td>
                                <td class="tw-p-2">{{ dato.requisiciones_insumos_perfil.Nombre }} {{ dato.requisiciones_insumos_perfil.ApPat }}</td>
                                <td class="tw-p-2">{{ dato.Estatus}}</td>
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
                    </Table>
                </div>
            </div>
        </div>
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
//imports de datatables
import datatable from "datatables.net-bs5";
import $ from "jquery";
import moment from 'moment';
import 'moment/locale/es';

export default {
    mounted() {
        this.tabla();
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
        ReqInsumos: Object,
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
                $("#Insumos").DataTable({
                language: this.español,
                });
            });
        },

        save(data) {

            this.clean(data); //Funcion para limpiar nulos y vacios
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
