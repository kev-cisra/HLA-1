<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

    // ************ USUARIOS PRUEBAS DEL SISTEMA *******************
        User::create([
            'IdEmp' => '5310',
            'name' => 'DEVELOPER',
            'Departamento' => 'ADMINISTRADOR',
            //'email' => 'desarrollador@intranethlangeles.com',
            'password' => bcrypt('1234')
        ])->assignRole('ONEPIECE');

        User::create([
            'IdEmp' => '10000',
            'name' => 'DEVELOPER 2',
            'Departamento' => 'ADMINISTRADOR',
            //'email' => 'desarrollador2@intranethlangeles.com',
            'password' => bcrypt('1234')
        ])->assignRole('Administrador');

        User::create([
            'IdEmp' => '10001',
            'name' => 'TESTER',
            'Departamento' => 'ADMINISTRADOR',
            'password' => bcrypt('12345678')
        ])->assignRole('Administrador');

        User::create([
            'IdEmp' => '10002',
            'name' => 'Recursos Humanos',
            'Departamento' => 'RECURSOS HUMANOS',
            'password' => bcrypt('12345678')
        ])->assignRole('RecursosHumanos');

        User::create([
            'IdEmp' => '10003',
            'name' => 'Almacen',
            'Departamento' => 'ALMACEN',
            'password' => bcrypt('12345678')
        ])->assignRole('Almacen');

        User::create([
            'IdEmp' => '10004',
            'name' => 'Compras',
            'Departamento' => 'COMPRAS',
            'password' => bcrypt('12345678')
        ])->assignRole('Compras');

        User::create([
            'IdEmp' => '10005',
            'name' => 'Sistemas',
            'Departamento' => 'SISTEMAS',
            //'email' => 'sistemas@intranet.com',
            'password' => bcrypt('12345678')
        ])->assignRole('Sistemas');

        User::create([
            'IdEmp' => '10006',
            'name' => 'Direccion',
            'Departamento' => 'Direccion',
            //'email' => 'Direccion@intranet.com',
            'password' => bcrypt('12345678')
        ])->assignRole('Direccion');

        User::create([
            'IdEmp' => '10007',
            'name' => 'Contabilidad',
            'Departamento' => 'Contabilidad',
            //'email' => 'Contabilidad@intranet.com',
            'password' => bcrypt('12345678')
        ])->assignRole('Contabilidad');

        User::create([
            'IdEmp' => '10008',
            'name' => 'Contabilidad',
            'Departamento' => 'Contabilidad',
            //'email' => 'Produccion@intranet.com',
            'password' => bcrypt('12345678')
        ])->assignRole('Produccion');

        User::create([
            'IdEmp' => '10009',
            'name' => 'DEPARTAMENTO X',
            'Departamento' => 'DEPARTAMENTO X',
            //'email' => 'departamento@intranet.com',
            'password' => bcrypt('12345678')
        ])->assignRole('Produccion');


        // ******** USUARIOS DEL SISTEMA *************

        User::create(['IdEmp' => '2','name' => 'MAXIMO CARRERA MARTINEZ','Departamento' => '2','password' => bcrypt('2')]);
        User::create(['IdEmp' => '3','name' => 'PEDRO ASENCION MUÑOZ CHAVEZ','Departamento' => '2','password' => bcrypt('3')]);
        User::create(['IdEmp' => '4','name' => 'GUADALUPE SALGADO NERI','Departamento' => '2','password' => bcrypt('4')]);
        User::create(['IdEmp' => '5','name' => 'MARIA ANTONIA LIMON TORRES','Departamento' => '2','password' => bcrypt('5')]);
        User::create(['IdEmp' => '6','name' => 'HUMBERTO MARTINEZ TRUJILLO','Departamento' => '1','password' => bcrypt('6')]);
        User::create(['IdEmp' => '8','name' => 'JANNINA RUIZ DEL SOL LEON','Departamento' => '1','password' => bcrypt('8')]);
        User::create(['IdEmp' => '10','name' => 'ARTURO RODRIGUEZ CARMONA','Departamento' => '1','password' => bcrypt('10')]);
        User::create(['IdEmp' => '12','name' => 'MARIA MARINA MORALES SANCHEZ','Departamento' => '1','password' => bcrypt('12')])->assignRole('RecursosHumanos');
        User::create(['IdEmp' => '13','name' => 'FRUMENCIA LEYDEN LOPEZ SILVA','Departamento' => '1','password' => bcrypt('13')]);
        User::create(['IdEmp' => '14','name' => 'EDILBERTO ROJAS MORALES','Departamento' => '1','password' => bcrypt('14')])->assignRole('Compras');
        User::create(['IdEmp' => '15','name' => 'FLOR ERENDIRA PEREZ ALTAMIRANO','Departamento' => '1','password' => bcrypt('15')]);
        User::create(['IdEmp' => '16','name' => 'ELIZABETH HERNANDEZ PEREZ','Departamento' => '1','password' => bcrypt('16')]);
        User::create(['IdEmp' => '17','name' => 'BEATRIZ EUGENIA LOPEZ LOZADA','Departamento' => '1','password' => bcrypt('17')])->assignRole('Compras');
        User::create(['IdEmp' => '21','name' => 'JOSE ALFONSO VENTURA ELIZAGA','Departamento' => '1','password' => bcrypt('21')]);
        User::create(['IdEmp' => '22','name' => 'RODOLFO REYES GARCIA','Departamento' => '2','password' => bcrypt('22')]);
        User::create(['IdEmp' => '27','name' => 'ROCIO BERENICE LIMON RAMIREZ','Departamento' => '1','password' => bcrypt('27')]);
        User::create(['IdEmp' => '28','name' => 'JUAN PABLO QUINTANA ELIZAGA','Departamento' => '1','password' => bcrypt('28')])->assignRole('Administrador');
        User::create(['IdEmp' => '32','name' => 'RICARDO CASTILLO OLIVER','Departamento' => '1','password' => bcrypt('32')])->assignRole('Administrador');
        User::create(['IdEmp' => '36','name' => 'MIGUEL ANGEL GARCIA QUIÑONES','Departamento' => '1','password' => bcrypt('36')])->assignRole('Administrador');
        User::create(['IdEmp' => '39','name' => 'MANUEL HUMBERTO RAMIREZ CASTILLO','Departamento' => '1','password' => bcrypt('39')]);
        User::create(['IdEmp' => '41','name' => 'JAVIER PEREZ GIL','Departamento' => '1','password' => bcrypt('41')]);
        User::create(['IdEmp' => '43','name' => 'GUADALUPE BEATRIZ JARAMILLO NOLASCO','Departamento' => '2','password' => bcrypt('43')]);
        User::create(['IdEmp' => '49','name' => 'JUAN JOSE MENDOZA PASTRANA','Departamento' => '1','password' => bcrypt('49')]);
        User::create(['IdEmp' => '53','name' => 'GERARDO BALTAZAR LOPEZ ROSALES','Departamento' => '2','password' => bcrypt('53')]);
        User::create(['IdEmp' => '57','name' => 'FEDERICO LOPEZ CARRASCO','Departamento' => '1','password' => bcrypt('57')]);
        User::create(['IdEmp' => '58','name' => 'ADRIAN JUAREZ REMEDIOS','Departamento' => '1','password' => bcrypt('58')]);
        User::create(['IdEmp' => '61','name' => 'SANTIAGO EDMUNDO TOLEDO MORA','Departamento' => '1','password' => bcrypt('61')]);
        User::create(['IdEmp' => '63','name' => 'MARIA ANDREA ZAVALA USCANGA','Departamento' => '1','password' => bcrypt('53')]);
        User::create(['IdEmp' => '64','name' => 'PATRICIA RODRIGUEZ NESME','Departamento' => '1','password' => bcrypt('64')]);
        User::create(['IdEmp' => '66','name' => 'KAREN ARELI ARMENDIA TELLEZ','Departamento' => '1','password' => bcrypt('66')]);
        User::create(['IdEmp' => '67','name' => 'MARIA SOLEDAD CANO ALVAREZ','Departamento' => '1','password' => bcrypt('67')]);
        User::create(['IdEmp' => '69','name' => 'LUIS HERNANDEZ GARCIA','Departamento' => '2','password' => bcrypt('69')]);
        User::create(['IdEmp' => '70','name' => 'DIANA LIZET MUÑOZ HERRERA','Departamento' => '2','password' => bcrypt('70')]);
        User::create(['IdEmp' => '71','name' => 'MARIELA MARTINEZ ZEPEDA','Departamento' => '1','password' => bcrypt('71')]);
        User::create(['IdEmp' => '72','name' => 'NORMA ANGELICA HERNANDES RESENDIZ','Departamento' => '1','password' => bcrypt('72')]);
        User::create(['IdEmp' => '73', 'name' =>'JOCELYN RODRIGUEZ LOPEZ','Departamento' => 1,'password' => bcrypt('73')]);
        User::create(['IdEmp' => '74', 'name' =>'OSIRIS YOSEF HERNANDEZ PEREZ','Departamento' => 1,'password' => bcrypt('74')]);
        User::create(['IdEmp' => '75', 'name' =>'GISELA LIZBETH JARAMILLO MARIN','Departamento' => 1,'password' => bcrypt('75')]);
        User::create(['IdEmp' => '76', 'name' =>'LUIS ENRIQUE GALVAN BARON','Departamento' => 1,'password' => bcrypt('76')])->assignRole('Almacen');;
        User::create(['IdEmp' => '78', 'name' =>'KEVIN CISNEROS RAMIREZ','Departamento' => 1,'password' => bcrypt('78')])->assignRole('Sistemas');
        User::create(['IdEmp' => '780', 'name' =>'IGNACIO MITRE RODRIGUEZ','Departamento' => 1,'password' => bcrypt('780')]);
        User::create(['IdEmp' => '870', 'name' =>'CARLOS GABRIEL LOPEZ MENDEZ','Departamento' => 1,'password' => bcrypt('870')]);
        User::create(['IdEmp' => '15', 'name' =>'MIGUEL PALACIOS SOSA','Departamento' => 3,'password' => bcrypt('15')]);
        User::create(['IdEmp' => '116', 'name' =>'MARIA BIOLA HERNANDEZ GARCIA','Departamento' => 3,'password' => bcrypt('116')]);
        User::create(['IdEmp' => '122', 'name' =>'BRIGIDA TERESA AMADOR ROMERO','Departamento' => 3,'password' => bcrypt('122')]);
        User::create(['IdEmp' => '139', 'name' =>'MA COLUMBA FRANCISCA DIAZ ABRIZ','Departamento' => 3,'password' => bcrypt('139')]);
        User::create(['IdEmp' => '628', 'name' =>'ELOY BONILLA XICOHTENCATL','Departamento' => 3,'password' => bcrypt('628')]);
        User::create(['IdEmp' => '875', 'name' =>'LORENA HERNANDEZ NAVARRO','Departamento' => 3,'password' => bcrypt('875')]);
        User::create(['IdEmp' => '963', 'name' =>'JONATHAN CRISOSTOMO OROZCO','Departamento' => 3,'password' => bcrypt('963')]);
        User::create(['IdEmp' => '973', 'name' =>'PRAXEDES FLORES DIAZ','Departamento' => 3,'password' => bcrypt('973')]);
        User::create(['IdEmp' => '1024', 'name' =>'ITZEL BELEN RAMIREZ REYES','Departamento' => 3,'password' => bcrypt('1024')]);
        User::create(['IdEmp' => '1059', 'name' =>'CLAUDIA CARMONA ROJAS','Departamento' => 3,'password' => bcrypt('1059')]);
        User::create(['IdEmp' => '1075', 'name' =>'M ALEJANDRA GUADALUP MARTINEZ CORONA','Departamento' => 3,'password' => bcrypt('1075')]);
        User::create(['IdEmp' => '1076', 'name' =>'ESTEFANIA ARELLANO CRUZ','Departamento' => 3,'password' => bcrypt('1076')]);
        User::create(['IdEmp' => '1077', 'name' =>'MELISSA MORALES CRUZ','Departamento' => 3,'password' => bcrypt('1077')]);
        User::create(['IdEmp' => '1099', 'name' =>'ANA LAURA DE LA LUZ GERMAN','Departamento' => 3,'password' => bcrypt('1099')]);
        User::create(['IdEmp' => '1108', 'name' =>'CANDELARIA SOSA DE JESUS','Departamento' => 3,'password' => bcrypt('1108')]);
        User::create(['IdEmp' => '1137', 'name' =>'MARIA DE JESUS MATIAS SEPULVEDA','Departamento' => 3,'password' => bcrypt('1137')]);
        User::create(['IdEmp' => '1138', 'name' =>'MARICRUZ MUÑOZ MUÑOZ','Departamento' => 3,'password' => bcrypt('1138')]);
        User::create(['IdEmp' => '1141', 'name' =>'DAGOBERTO SANCHEZ CARRERA','Departamento' => 3,'password' => bcrypt('1141')]);
        User::create(['IdEmp' => '1159', 'name' =>'MIRIAM AGUILAR ONTIVEROS','Departamento' => 3,'password' => bcrypt('1159')]);
        User::create(['IdEmp' => '1163', 'name' =>'PABLO RAMOS DIEGO','Departamento' => 3,'password' => bcrypt('1163')]);
        User::create(['IdEmp' => '1164', 'name' =>'NAZARIO FRANCISCO SALAZAR','Departamento' => 3,'password' => bcrypt('1164')]);
        User::create(['IdEmp' => '1248', 'name' =>'MARIA EUGENIA MARTINEZ MARTINEZ','Departamento' => 3,'password' => bcrypt('1248')]);
        User::create(['IdEmp' => '1249', 'name' =>'DANIEL ORTIZ RODRIGUEZ','Departamento' => 3,'password' => bcrypt('1249')]);
        User::create(['IdEmp' => '1251', 'name' =>'OSCAR PEREZ CONTRERAS','Departamento' => 3,'password' => bcrypt('1251')]);
        User::create(['IdEmp' => '1268', 'name' =>'KARINA SANTOS VAZQUEZ','Departamento' => 3,'password' => bcrypt('1268')]);
        User::create(['IdEmp' => '1272', 'name' =>'GEORGINA RAMIREZ ESTRADA','Departamento' => 3,'password' => bcrypt('1272')]);
        User::create(['IdEmp' => '83', 'name' =>'GERARDO ROJAS GARCIA','Departamento' => 7,'password' => bcrypt('1270')])->assignRole('Produccion','Cordinador');
        User::create(['IdEmp' => '500', 'name' =>'VICENTE SOSA PEÑA','Departamento' => 7,'password' => bcrypt('500')])->assignRole('Produccion','Encargado');
        User::create(['IdEmp' => '606', 'name' =>'ELEGARDO RODRIGUEZ ALVAREZ','Departamento' => 7,'password' => bcrypt('606')])->assignRole('Produccion','Operador');
        User::create(['IdEmp' => '686', 'name' =>'MARCO ANTONIO GALAN CHAVEZ','Departamento' => 7,'password' => bcrypt('686')])->assignRole('Produccion','Operador');
        User::create(['IdEmp' => '726', 'name' =>'ANTONIO MUNIVE CONTRERAS','Departamento' => 7,'password' => bcrypt('726')])->assignRole('Produccion','Operador');
        User::create(['IdEmp' => '792', 'name' =>'CESAR ROJAS MORALES','Departamento' => 7,'password' => bcrypt('792')])->assignRole('Produccion','Operador');
        User::create(['IdEmp' => '858', 'name' =>'FRANCISCO JAVIER MENDIETA RODRIGUEZ','Departamento' => 7,'password' => bcrypt('858')])->assignRole('Produccion','Operador');
        User::create(['IdEmp' => '862', 'name' =>'FELIPE PEREZ JUAREZ','Departamento' => 7,'password' => bcrypt('862')])->assignRole('Produccion','Operador');
        User::create(['IdEmp' => '924', 'name' =>'JAVIER MELENDEZ ROMERO','Departamento' => 7,'password' => bcrypt('924')])->assignRole('Produccion','Operador');
        User::create(['IdEmp' => '929', 'name' =>'JOSE MANUEL RAMIREZ CALDERON','Departamento' => 7,'password' => bcrypt('929')])->assignRole('Produccion','Lider');
        User::create(['IdEmp' => '930', 'name' =>'SERGIO BRANDON LOPEZ GONZALEZ','Departamento' => 7,'password' => bcrypt('930')])->assignRole('Produccion','Operador');
        User::create(['IdEmp' => '983', 'name' =>'CESAR VICTORIANO HERNANDEZ','Departamento' => 7,'password' => bcrypt('983')])->assignRole('Produccion','Operador');
        User::create(['IdEmp' => '994', 'name' =>'BERNARDO BERNALDINO HERNANDEZ','Departamento' => 7,'password' => bcrypt('994')])->assignRole('Produccion','Lider');
        User::create(['IdEmp' => '1004', 'name' =>'JUAN DAVID SERRANO HERNANDEZ','Departamento' => 7,'password' => bcrypt('1004')])->assignRole('Produccion','Operador');
        User::create(['IdEmp' => '1053', 'name' =>'JULIO ROJAS OLAYA','Departamento' => 7,'password' => bcrypt('1053')])->assignRole('Produccion','Operador');
        User::create(['IdEmp' => '1054', 'name' =>'EMILIO MUÑOZ XICOHTENCATL','Departamento' => 7,'password' => bcrypt('1054')])->assignRole('Produccion','Lider');
        User::create(['IdEmp' => '1098', 'name' =>'EDGAR IVAN AGUILAR FERNANDEZ','Departamento' => 7,'password' => bcrypt('1098')])->assignRole('Produccion','Operador');
        User::create(['IdEmp' => '1161', 'name' =>'PAULINO TORRES GUZMAN','Departamento' => 7,'password' => bcrypt('1161')])->assignRole('Produccion','Operador');
        User::create(['IdEmp' => '1166', 'name' =>'JUAN CARLOS OCHOA MARTINEZ','Departamento' => 7,'password' => bcrypt('1166')])->assignRole('Produccion','Operador');
        User::create(['IdEmp' => '1173', 'name' =>'JONATHAN AGUILAR CARO','Departamento' => 7,'password' => bcrypt('1173')])->assignRole('Produccion','Operador');
        User::create(['IdEmp' => '1193', 'name' =>'RAMIRO ISLAS CHAVEZ','Departamento' => 7,'password' => bcrypt('1193')])->assignRole('Produccion','Operador');
        User::create(['IdEmp' => '1210', 'name' =>'JUAN JOSE JARAMILLO SILVA','Departamento' => 7,'password' => bcrypt('1210')])->assignRole('Produccion','Operador');
        User::create(['IdEmp' => '1244', 'name' =>'EMMANUEL GUTIERREZ LOZADA','Departamento' => 7,'password' => bcrypt('1244')])->assignRole('Produccion','Operador');
        User::create(['IdEmp' => '22', 'name' =>'DANIEL FLORES ROJAS','Departamento' => 4,'password' => bcrypt('22')]);
        User::create(['IdEmp' => '57', 'name' =>'BENITO CORTES CRUZ','Departamento' => 4,'password' => bcrypt('57')]);
        User::create(['IdEmp' => '89', 'name' =>'NESTOR VALENCIA FLORES','Departamento' => 4,'password' => bcrypt('89')]);
        User::create(['IdEmp' => '126', 'name' =>'NESTOR CIRIO MORENO','Departamento' => 4,'password' => bcrypt('126')]);
        User::create(['IdEmp' => '140', 'name' =>'RICARDO RODRIGUEZ RODRIGUEZ','Departamento' => 4,'password' => bcrypt('140')]);
        User::create(['IdEmp' => '271', 'name' =>'BRAULIO GUZMAN TAPIA','Departamento' => 4,'password' => bcrypt('271')]);
        User::create(['IdEmp' => '291', 'name' =>'BENJAMIN GARCIA BONILLA','Departamento' => 4,'password' => bcrypt('291')]);
        User::create(['IdEmp' => '301', 'name' =>'JOSUE PEREZ ROMERO','Departamento' => 4,'password' => bcrypt('301')]);
        User::create(['IdEmp' => '340', 'name' =>'PABLO ENCARNACION ZAMORA','Departamento' => 4,'password' => bcrypt('340')]);
        User::create(['IdEmp' => '393', 'name' =>'JORGE CRUZ CERVANTES','Departamento' => 4,'password' => bcrypt('393')]);
        User::create(['IdEmp' => '401', 'name' =>'JOHNNY CALDERON CARVENTE','Departamento' => 4,'password' => bcrypt('401')]);
        User::create(['IdEmp' => '464', 'name' =>'JOSE VICENTE RAUL LIMA CASTILLO','Departamento' => 4,'password' => bcrypt('464')]);
        User::create(['IdEmp' => '537', 'name' =>'GUILLERMO HERNANDEZ MORALES','Departamento' => 4,'password' => bcrypt('537')]);
        User::create(['IdEmp' => '604', 'name' =>'FERMIN PEREZ XICOHTENCATL','Departamento' => 4,'password' => bcrypt('604')]);
        User::create(['IdEmp' => '755', 'name' =>'DAVID QUINTANILLA VERA','Departamento' => 4,'password' => bcrypt('755')]);
        User::create(['IdEmp' => '768', 'name' =>'MARCO ANTONIO SALAS ROJAS','Departamento' => 4,'password' => bcrypt('768')]);
        User::create(['IdEmp' => '777', 'name' =>'ARTURO MARTINEZ LIRA','Departamento' => 4,'password' => bcrypt('777')]);
        User::create(['IdEmp' => '795', 'name' =>'OMAR MONROY CRUZ','Departamento' => 4,'password' => bcrypt('795')]);
        User::create(['IdEmp' => '835', 'name' =>'JOSE TZONTECOMANI CORTES','Departamento' => 4,'password' => bcrypt('835')]);
        User::create(['IdEmp' => '852', 'name' =>'CRUZ VELAZQUEZ MARAVILLA','Departamento' => 4,'password' => bcrypt('852')]);
        User::create(['IdEmp' => '967', 'name' =>'MIGUEL SANCHEZ HERNANDEZ','Departamento' => 4,'password' => bcrypt('967')]);
        User::create(['IdEmp' => '1005', 'name' =>'SINAI MUÑOZ XICOHTENCATL','Departamento' => 4,'password' => bcrypt('1005')]);
        User::create(['IdEmp' => '1044', 'name' =>'JESUS FLORES DE LA CRUZ','Departamento' => 4,'password' => bcrypt('1044')]);
        User::create(['IdEmp' => '1095', 'name' =>'RUFINO BONILLA DE LA CRUZ','Departamento' => 4,'password' => bcrypt('1095')]);
        User::create(['IdEmp' => '1225', 'name' =>'MIGUEL ANGEL HERNANDEZ RODRIGUEZ','Departamento' => 4,'password' => bcrypt('1225')]);
        User::create(['IdEmp' => '1240', 'name' =>'JUAN DANIEL AMARO LUNA','Departamento' => 4,'password' => bcrypt('1240')]);
        User::create(['IdEmp' => '1255', 'name' =>'DAVID HERNANDEZ HERNANDEZ','Departamento' => 4,'password' => bcrypt('1255')]);
        User::create(['IdEmp' => '4', 'name' =>'FERNANDO MARTINEZ HERNANDEZ','Departamento' => 5,'password' => bcrypt('4')]);
        User::create(['IdEmp' => '167', 'name' =>'JOEL RAMIREZ SALAZAR','Departamento' => 5,'password' => bcrypt('167')]);
        User::create(['IdEmp' => '216', 'name' =>'EMILIO REYES Pérez','Departamento' => 5,'password' => bcrypt('216')]);
        User::create(['IdEmp' => '281', 'name' =>'RAYMUNDO CASTRO CORTES','Departamento' => 5,'password' => bcrypt('281')]);
        User::create(['IdEmp' => '286', 'name' =>'JUAN ROJAS JUAREZ','Departamento' => 5,'password' => bcrypt('286')]);
        User::create(['IdEmp' => '307', 'name' =>'RAUL QUINTERO OSORIO','Departamento' => 5,'password' => bcrypt('307')]);
        User::create(['IdEmp' => '327', 'name' =>'SALVADOR VICTORIANO GARCIA','Departamento' => 5,'password' => bcrypt('327')]);
        User::create(['IdEmp' => '483', 'name' =>'NORBERTO SANCHEZ CORTES','Departamento' => 5,'password' => bcrypt('483')]);
        User::create(['IdEmp' => '684', 'name' =>'JOSE DANIEL CRUZ HERNANDEZ','Departamento' => 5,'password' => bcrypt('684')]);
        User::create(['IdEmp' => '707', 'name' =>'JORGE LUIS LOPEZ SARMIENTO','Departamento' => 5,'password' => bcrypt('707')]);
        User::create(['IdEmp' => '764', 'name' =>'JESUS ISAHEL CARMONA ROJAS','Departamento' => 5,'password' => bcrypt('764')]);
        User::create(['IdEmp' => '887', 'name' =>'FRANCISCO VEGA MORENO','Departamento' => 5,'password' => bcrypt('887')]);
        User::create(['IdEmp' => '901', 'name' =>'DIEGO RIOS CASO','Departamento' => 5,'password' => bcrypt('901')]);
        User::create(['IdEmp' => '948', 'name' =>'JORGE URIEL QUINTERO FERNANDEZ','Departamento' => 5,'password' => bcrypt('948')]);
        User::create(['IdEmp' => '951', 'name' =>'ANGEL ARAMIS ROBLES MUÑOZ','Departamento' => 5,'password' => bcrypt('951')]);
        User::create(['IdEmp' => '1046', 'name' =>'JOSE EDGAR PEREZ SAUZ','Departamento' => 5,'password' => bcrypt('1046')]);
        User::create(['IdEmp' => '1065', 'name' =>'ABDIEL ELEAZAR GALLARDO VILLEGAS','Departamento' => 5,'password' => bcrypt('1065')]);
        User::create(['IdEmp' => '1243', 'name' =>'ANDRES MARTINEZ VARGUEZ','Departamento' => 5,'password' => bcrypt('1243')]);
        User::create(['IdEmp' => '169', 'name' =>'ROBERTO ROJAS CALDERON','Departamento' => 6,'password' => bcrypt('169')]);
        User::create(['IdEmp' => '182', 'name' =>'FELIPE PAISANO FLORES','Departamento' => 6,'password' => bcrypt('182')]);
        User::create(['IdEmp' => '274', 'name' =>'JOSE LUIS GARCIA VEGA','Departamento' => 6,'password' => bcrypt('274')]);
        User::create(['IdEmp' => '398', 'name' =>'ARMANDO DEL CORRAL CASTILLO','Departamento' => 6,'password' => bcrypt('398')]);
        User::create(['IdEmp' => '466', 'name' =>'J VICTOR REYES FLORES','Departamento' => 6,'password' => bcrypt('466')]);
        User::create(['IdEmp' => '547', 'name' =>'DARIO SOLAR CUEVAS','Departamento' => 6,'password' => bcrypt('547')]);
        User::create(['IdEmp' => '591', 'name' =>'MARTIN ABREGO HERNANDEZ','Departamento' => 6,'password' => bcrypt('591')]);
        User::create(['IdEmp' => '616', 'name' =>'HUGO CEREZO DIAZ','Departamento' => 6,'password' => bcrypt('616')]);
        User::create(['IdEmp' => '641', 'name' =>'BONY DANIEL GONZALEZ PAREDES','Departamento' => 6,'password' => bcrypt('641')]);
        User::create(['IdEmp' => '697', 'name' =>'ISAIAS ROMERO XICOHTENCATL','Departamento' => 6,'password' => bcrypt('697')]);
        User::create(['IdEmp' => '719', 'name' =>'GEOVANY AGUILAR RAMIREZ','Departamento' => 6,'password' => bcrypt('719')]);
        User::create(['IdEmp' => '751', 'name' =>'ENRIQUE MARTINEZ MARTINEZ','Departamento' => 6,'password' => bcrypt('751')]);
        User::create(['IdEmp' => '785', 'name' =>'RODRIGO RODRIGUEZ CORTES','Departamento' => 6,'password' => bcrypt('785')]);
        User::create(['IdEmp' => '815', 'name' =>'GIOVANI VEGA TELLEZ','Departamento' => 6,'password' => bcrypt('815')]);
        User::create(['IdEmp' => '849', 'name' =>'MARTIN BONILLA MENDOZA','Departamento' => 6,'password' => bcrypt('849')]);
        User::create(['IdEmp' => '878', 'name' =>'HECTOR GARCIA MARQUEZ','Departamento' => 6,'password' => bcrypt('878')]);
        User::create(['IdEmp' => '989', 'name' =>'OSCAR GARCIA CORONA','Departamento' => 6,'password' => bcrypt('989')]);
        User::create(['IdEmp' => '1018', 'name' =>'JULIO CESAR HERNANDEZ CUEVAS','Departamento' => 6,'password' => bcrypt('1018')]);
        User::create(['IdEmp' => '1118', 'name' =>'JOSE OMAR PEREZ LOPEZ','Departamento' => 6,'password' => bcrypt('1118')]);
        User::create(['IdEmp' => '1139', 'name' =>'MARCOS LIMON DOMINGUEZ','Departamento' => 6,'password' => bcrypt('1139')]);
        User::create(['IdEmp' => '1143', 'name' =>'BRAYAM ALEXIS MORALES PEREZ','Departamento' => 6,'password' => bcrypt('1143')]);
        User::create(['IdEmp' => '1145', 'name' =>'DAVID PEREZ GONZALEZ','Departamento' => 6,'password' => bcrypt('1145')]);
        User::create(['IdEmp' => '1148', 'name' =>'HELIODORO MARIN REYES','Departamento' => 6,'password' => bcrypt('1148')]);
        User::create(['IdEmp' => '1149', 'name' =>'LAZARO REYES FLORES','Departamento' => 6,'password' => bcrypt('1149')]);
        User::create(['IdEmp' => '1165', 'name' =>'EZEQUIEL LAZCANO PICHARDO','Departamento' => 6,'password' => bcrypt('1165')]);
        User::create(['IdEmp' => '1171', 'name' =>'ANTONIO RAMOS RUIZ','Departamento' => 6,'password' => bcrypt('1171')]);
        User::create(['IdEmp' => '1181', 'name' =>'OSCAR DAVID LEON RAMOS','Departamento' => 6,'password' => bcrypt('1181')]);
        User::create(['IdEmp' => '1187', 'name' =>'ROBERTO CARLOS TLALOLINI ROMERO','Departamento' => 6,'password' => bcrypt('1187')]);
        User::create(['IdEmp' => '1192', 'name' =>'RAUL GONZALEZ NICOLAS','Departamento' => 6,'password' => bcrypt('1192')]);
        User::create(['IdEmp' => '1196', 'name' =>'BERNARDO GUZMAN ROMERO','Departamento' => 6,'password' => bcrypt('1196')]);
        User::create(['IdEmp' => '1197', 'name' =>'JOSE CRUZ ELIOSA LARA','Departamento' => 6,'password' => bcrypt('1197')]);
        User::create(['IdEmp' => '163', 'name' =>'ARTURO ROJAS ROJAS','Departamento' => 8,'password' => bcrypt('163')]);
        User::create(['IdEmp' => '556', 'name' =>'MARTIN PEÑA BENAVIDES','Departamento' => 8,'password' => bcrypt('556')]);
        User::create(['IdEmp' => '571', 'name' =>'ALBERTO HERNANDEZ RAMIREZ','Departamento' => 8,'password' => bcrypt('571')]);
        User::create(['IdEmp' => '683', 'name' =>'LUIS RAMIREZ JUAREZ','Departamento' => 8,'password' => bcrypt('683')]);
        User::create(['IdEmp' => '756', 'name' =>'IVAN MENA PEREZ','Departamento' => 8,'password' => bcrypt('756')]);
        User::create(['IdEmp' => '773', 'name' =>'GREGORIO GUZMAN MARTINEZ','Departamento' => 8,'password' => bcrypt('773')]);
        User::create(['IdEmp' => '774', 'name' =>'JORGE URIEL AGUILAR CARO','Departamento' => 8,'password' => bcrypt('774')]);
        User::create(['IdEmp' => '821', 'name' =>'JOSE EDUARDO NERI ROJAS','Departamento' => 8,'password' => bcrypt('821')]);
        User::create(['IdEmp' => '854', 'name' =>'JULIO CESAR MUÑOZ MUÑOZ','Departamento' => 8,'password' => bcrypt('854')]);
        User::create(['IdEmp' => '861', 'name' =>'JESUS MUÑOZ XICOHTENCATL','Departamento' => 8,'password' => bcrypt('861')]);
        User::create(['IdEmp' => '865', 'name' =>'DAVID HERRERA CORTES','Departamento' => 8,'password' => bcrypt('865')]);
        User::create(['IdEmp' => '868', 'name' =>'FRANCISCO ZAMORA RODRIGUEZ','Departamento' => 8,'password' => bcrypt('868')]);
        User::create(['IdEmp' => '886', 'name' =>'DOLORES GOMEZ OLVERA','Departamento' => 8,'password' => bcrypt('886')]);
        User::create(['IdEmp' => '896', 'name' =>'JOSE MIGUEL GARCIA DE ANGEL','Departamento' => 8,'password' => bcrypt('896')]);
        User::create(['IdEmp' => '897', 'name' =>'RAUL BONILLA MENDOZA','Departamento' => 8,'password' => bcrypt('897')]);
        User::create(['IdEmp' => '898', 'name' =>'JOSE DE JESUS MINOR SALAS','Departamento' => 8,'password' => bcrypt('898')]);
        User::create(['IdEmp' => '903', 'name' =>'ARMANDO PALETA CARVENTE','Departamento' => 8,'password' => bcrypt('903')]);
        User::create(['IdEmp' => '932', 'name' =>'FERMIN TORRES REYES','Departamento' => 8,'password' => bcrypt('932')]);
        User::create(['IdEmp' => '935', 'name' =>'JUAN JESUS CEREZO DIAZ','Departamento' => 8,'password' => bcrypt('935')]);
        User::create(['IdEmp' => '938', 'name' =>'JOSE LUIS ALVARADO LOPEZ','Departamento' => 8,'password' => bcrypt('938')]);
        User::create(['IdEmp' => '954', 'name' =>'OSCAR ALVARADO TEPOXTECATL','Departamento' => 8,'password' => bcrypt('954')]);
        User::create(['IdEmp' => '972', 'name' =>'IVAN MENDEZ HERNANDEZ','Departamento' => 8,'password' => bcrypt('972')]);
        User::create(['IdEmp' => '998', 'name' =>'HECTOR JESUS GUEVARA LEAÑOS','Departamento' => 8,'password' => bcrypt('998')]);
        User::create(['IdEmp' => '1000', 'name' =>'JORGE PEREZ GONZALEZ','Departamento' => 8,'password' => bcrypt('1000')]);
        User::create(['IdEmp' => '1001', 'name' =>'JUAN CARLOS BONILLA DE LA CRUZ','Departamento' => 8,'password' => bcrypt('1001')]);
        User::create(['IdEmp' => '1007', 'name' =>'CRISTIAN JESUS ORTIZ FUENTES','Departamento' => 8,'password' => bcrypt('1007')]);
        User::create(['IdEmp' => '1013', 'name' =>'VICTOR ESTEBAN HERNANDEZ','Departamento' => 8,'password' => bcrypt('1013')]);
        User::create(['IdEmp' => '1014', 'name' =>'RAYMUNDO PEREZ VERGARA','Departamento' => 8,'password' => bcrypt('1014')]);
        User::create(['IdEmp' => '1015', 'name' =>'JUAN CARLOS GARCIA RAMOS','Departamento' => 8,'password' => bcrypt('1015')]);
        User::create(['IdEmp' => '1016', 'name' =>'DAVID CAMACHO GARCIA','Departamento' => 8,'password' => bcrypt('1016')]);
        User::create(['IdEmp' => '1036', 'name' =>'RICARDO ROSALES ROSETE','Departamento' => 8,'password' => bcrypt('1036')]);
        User::create(['IdEmp' => '1037', 'name' =>'RICARDO SOLIS LOPEZ','Departamento' => 8,'password' => bcrypt('1037')]);
        User::create(['IdEmp' => '1056', 'name' =>'BRANDON PEREZ RAMIREZ','Departamento' => 8,'password' => bcrypt('1056')]);
        User::create(['IdEmp' => '1074', 'name' =>'IGNACIO SANCHEZ HERNANDEZ','Departamento' => 8,'password' => bcrypt('1074')]);
        User::create(['IdEmp' => '1079', 'name' =>'JOSE DANIEL OLMEDO ROJAS','Departamento' => 8,'password' => bcrypt('1079')]);
        User::create(['IdEmp' => '1082', 'name' =>'OCTAVIO ROBLES PACHECO','Departamento' => 8,'password' => bcrypt('1082')]);
        User::create(['IdEmp' => '1094', 'name' =>'EDUARDO SALGADO CHEPE','Departamento' => 8,'password' => bcrypt('1094')]);
        User::create(['IdEmp' => '1114', 'name' =>'HUGO ARROYO TORRES','Departamento' => 8,'password' => bcrypt('1114')]);
        User::create(['IdEmp' => '1115', 'name' =>'ALEJANDRO HUERTA MARTINEZ','Departamento' => 8,'password' => bcrypt('1115')]);
        User::create(['IdEmp' => '1117', 'name' =>'ADRIAN ASAEL HERNANDEZ SANCHEZ','Departamento' => 8,'password' => bcrypt('1117')]);
        User::create(['IdEmp' => '1120', 'name' =>'JAIME HERNANDEZ HERNANDEZ','Departamento' => 8,'password' => bcrypt('1120')]);
        User::create(['IdEmp' => '1123', 'name' =>'JOSE FRANCISCO DE LUNA','Departamento' => 8,'password' => bcrypt('1123')]);
        User::create(['IdEmp' => '1130', 'name' =>'CARMELO VALENCIA ROJAS','Departamento' => 8,'password' => bcrypt('1130')]);
        User::create(['IdEmp' => '1151', 'name' =>'MIGUEL CARRILLO GUEVARA','Departamento' => 8,'password' => bcrypt('1151')]);
        User::create(['IdEmp' => '1156', 'name' =>'FERNANDO GONZALEZ DOMINGUEZ','Departamento' => 8,'password' => bcrypt('1156')]);
        User::create(['IdEmp' => '1202', 'name' =>'JONATAN HERNANDEZ CUEVAS','Departamento' => 8,'password' => bcrypt('1202')]);
        User::create(['IdEmp' => '1205', 'name' =>'OSCAR ARTURO SALDAÑA SANCHEZ','Departamento' => 8,'password' => bcrypt('1205')]);
        User::create(['IdEmp' => '1208', 'name' =>'DAVID ANTONIO VERA GONZALEZ','Departamento' => 8,'password' => bcrypt('1208')]);
        User::create(['IdEmp' => '1209', 'name' =>'BRYAN EDUARDO LEON LOPEZ','Departamento' => 8,'password' => bcrypt('1209')]);
        User::create(['IdEmp' => '1222', 'name' =>'ALAN GABRIEL RAMIREZ HERNANDEZ','Departamento' => 8,'password' => bcrypt('1222')]);
        User::create(['IdEmp' => '1223', 'name' =>'ISRAEL MUÑOZ SAUCEDO','Departamento' => 8,'password' => bcrypt('1223')]);
        User::create(['IdEmp' => '1226', 'name' =>'CRISTIAN BERNALDINO HERNANDEZ','Departamento' => 8,'password' => bcrypt('1226')]);
        User::create(['IdEmp' => '1227', 'name' =>'JULIAN MARTINEZ RAMIREZ','Departamento' => 8,'password' => bcrypt('1227')]);
        User::create(['IdEmp' => '1228', 'name' =>'FERNANDO YONATAN ZAMORA HERNANDEZ','Departamento' => 8,'password' => bcrypt('1228')]);
        User::create(['IdEmp' => '1229', 'name' =>'LUIS ENRIQUE RODRIGUEZ CABRERA','Departamento' => 8,'password' => bcrypt('1229')]);
        User::create(['IdEmp' => '1231', 'name' =>'FRANCISCO TORRES FLORES','Departamento' => 8,'password' => bcrypt('1231')]);
        User::create(['IdEmp' => '1232', 'name' =>'JOSE ALFREDO ALVARADO LOPEZ','Departamento' => 8,'password' => bcrypt('1232')]);
        User::create(['IdEmp' => '1235', 'name' =>'FERNANDO MADRIGAL RANGEL','Departamento' => 8,'password' => bcrypt('1235')]);
        User::create(['IdEmp' => '1237', 'name' =>'PEDRO GALVAN MAYEN','Departamento' => 8,'password' => bcrypt('1237')]);
        User::create(['IdEmp' => '1238', 'name' =>'ALAN MOISES TERCERO CAMARGO','Departamento' => 8,'password' => bcrypt('1238')]);
        User::create(['IdEmp' => '1239', 'name' =>'JOSE HUMBERTO PEREZ LUNA','Departamento' => 8,'password' => bcrypt('1239')]);
        User::create(['IdEmp' => '1250', 'name' =>'FERNANDO MENDOZA REYES','Departamento' => 8,'password' => bcrypt('1250')]);
        User::create(['IdEmp' => '1252', 'name' =>'MARCO ANTONIO ALDUCIN LOPEZ','Departamento' => 8,'password' => bcrypt('1252')]);
        User::create(['IdEmp' => '1257', 'name' =>'EDUARDO RENDON ROSAS','Departamento' => 8,'password' => bcrypt('1257')]);
        User::create(['IdEmp' => '1259', 'name' =>'CARLOS ARMANDO ROSAS DE LA LUZ','Departamento' => 8,'password' => bcrypt('1259')]);
        User::create(['IdEmp' => '1260', 'name' =>'JONATHAN HERNANDEZ GARCIA','Departamento' => 8,'password' => bcrypt('1260')]);
        User::create(['IdEmp' => '1261', 'name' =>'JUAN CARLOS DE LA ROSA CASTILLO','Departamento' => 8,'password' => bcrypt('1261')]);
        User::create(['IdEmp' => '1262', 'name' =>'JOSE DOLORES JIMENEZ COSTEÑO','Departamento' => 8,'password' => bcrypt('1262')]);
        User::create(['IdEmp' => '1264', 'name' =>'FRANCISCO SOSA CASTAÑEDA','Departamento' => 8,'password' => bcrypt('1264')]);
        User::create(['IdEmp' => '1269', 'name' =>'JORGE ALI CABALLERO DE LARA','Departamento' => 8,'password' => bcrypt('1269')]);
        User::create(['IdEmp' => '1270', 'name' =>'GEOVANY ZEPEDA OLMOS','Departamento' => 8,'password' => bcrypt('1270')]);
        User::create(['IdEmp' => '1271', 'name' =>'JOSE EDUARDO SANCHEZ BARONA','Departamento' => 8,'password' => bcrypt('1271')]);
        User::create(['IdEmp' => '1273', 'name' =>'CRISTIAN DE LA ROSA MARTINEZ','Departamento' => 8,'password' => bcrypt('1273')]);
        User::create(['IdEmp' => '328', 'name' =>'ISRAEL AGUSTIN JUAREZ SANCHEZ','Departamento' => 9,'password' => bcrypt('328')]);
        User::create(['IdEmp' => '820', 'name' =>'ALEX IVAN PAISANO PEREZ','Departamento' => 9,'password' => bcrypt('820')]);
        User::create(['IdEmp' => '1043', 'name' =>'GAEL BONILLA MENA','Departamento' => 9,'password' => bcrypt('1043')]);
        User::create(['IdEmp' => '1266', 'name' =>'JUAN MANUEL SALDIVAR ORTIZ','Departamento' => 9,'password' => bcrypt('1266')]);
        User::create(['IdEmp' => '149', 'name' =>'MAXIMINO OJEDA CONDE','Departamento' => 10,'password' => bcrypt('149')]);
        User::create(['IdEmp' => '265', 'name' =>'CARLOS ZAMORA RAMIREZ','Departamento' => 10,'password' => bcrypt('265')]);
        User::create(['IdEmp' => '970', 'name' =>'NARCISO GARCIA MESTIZO','Departamento' => 10,'password' => bcrypt('970')]);
        User::create(['IdEmp' => '1011', 'name' =>'GERARDO HERNANDEZ LOBATO','Departamento' => 10,'password' => bcrypt('1011')]);
        User::create(['IdEmp' => '1207', 'name' =>'GABRIEL SERGIO VAZQUEZ MENDIZABAL','Departamento' => 10,'password' => bcrypt('1207')]);
        User::create(['IdEmp' => '1215', 'name' =>'MOISES RAMIREZ SANCHEZ','Departamento' => 10,'password' => bcrypt('1215')]);
        User::create(['IdEmp' => '1263', 'name' =>'ISRAEL CORONA HERNANDEZ','Departamento' => 10,'password' => bcrypt('1263')]);
        User::create(['IdEmp' => '5', 'name' =>'JOSE SERGIO OTERO JIMENEZ','Departamento' => 11,'password' => bcrypt('5')]);
        User::create(['IdEmp' => '399', 'name' =>'LUCIANO GOMEZ GUTIERREZ','Departamento' => 11,'password' => bcrypt('399')]);
        User::create(['IdEmp' => '516', 'name' =>'RAFAEL PARRAGUIRRE GARCIA','Departamento' => 11,'password' => bcrypt('516')])->assignRole('Produccion');;
        User::create(['IdEmp' => '573', 'name' =>'ISMAEL ZAMBRANO PEREZ','Departamento' => 11,'password' => bcrypt('573')]);
        User::create(['IdEmp' => '666', 'name' =>'SALOMON PEREZ LUNA','Departamento' => 11,'password' => bcrypt('666')]);
        User::create(['IdEmp' => '736', 'name' =>'JUVENTINO HERNANDEZ ESPINOSA','Departamento' => 11,'password' => bcrypt('736')]);
        User::create(['IdEmp' => '884', 'name' =>'FRANCISCO JAVIER PRIMERO LOPEZ','Departamento' => 11,'password' => bcrypt('884')]);
        User::create(['IdEmp' => '910', 'name' =>'JUAN CARLOS PORTILLO SANCHEZ','Departamento' => 11,'password' => bcrypt('910')]);
        User::create(['IdEmp' => '937', 'name' =>'DAVID GIL CASELIN','Departamento' => 11,'password' => bcrypt('937')]);
        User::create(['IdEmp' => '950', 'name' =>'ERICK QUINTANILLA VERA','Departamento' => 11,'password' => bcrypt('950')]);
        User::create(['IdEmp' => '1052', 'name' =>'ALFREDO OSORIO ALVAREZ','Departamento' => 11,'password' => bcrypt('1052')]);
        User::create(['IdEmp' => '1107', 'name' =>'JOSE ARMANDO MUÑOZ LEON','Departamento' => 11,'password' => bcrypt('1107')]);
        User::create(['IdEmp' => '1152', 'name' =>'CARLOS HERNANDEZ FLORES','Departamento' => 11,'password' => bcrypt('1152')]);
        User::create(['IdEmp' => '1153', 'name' =>'HELIHU PALACIOS CHANTRES','Departamento' => 11,'password' => bcrypt('1153')]);
        User::create(['IdEmp' => '1221', 'name' =>'LUIS ANGEL GUEVARA ARENAS','Departamento' => 11,'password' => bcrypt('1221')]);
        User::create(['IdEmp' => '1224', 'name' =>'JESUS ROLDAN CELA','Departamento' => 11,'password' => bcrypt('1224')]);
        User::create(['IdEmp' => '1230', 'name' =>'RENE IVAN JUAREZ HUERTA','Departamento' => 11,'password' => bcrypt('1230')]);
        User::create(['IdEmp' => '1265', 'name' =>'JOSE ARTURO MATAMOROS HERNANDEZ','Departamento' => 11,'password' => bcrypt('1265')]);
        User::create(['IdEmp' => '190', 'name' =>'ROMAN MACHORRO ARENAS','Departamento' => 12,'password' => bcrypt('190')]);
        User::create(['IdEmp' => '881', 'name' =>'MIGUEL ANGEL CANALES ROJAS','Departamento' => 12,'password' => bcrypt('881')]);
        User::create(['IdEmp' => '1128', 'name' =>'URIEL BERNALDINO HERNANDEZ','Departamento' => 12,'password' => bcrypt('1128')]);
        User::create(['IdEmp' => '1167', 'name' =>'MARCO ANTONIO MANZANAREZ RIOS','Departamento' => 12,'password' => bcrypt('1167')]);
        User::create(['IdEmp' => '1247', 'name' =>'DIEGO MARTINEZ ANASTACIO','Departamento' => 12,'password' => bcrypt('1247')]);
        User::create(['IdEmp' => '326', 'name' =>'ESPERANZA ALVARADO PASILLAS','Departamento' => 13,'password' => bcrypt('326')]);
        User::create(['IdEmp' => '410', 'name' =>'MARIA EDITH PALAFOX FLORES','Departamento' => 13,'password' => bcrypt('410')]);
        User::create(['IdEmp' => '585', 'name' =>'OLIVIA MENESES BADILLO','Departamento' => 13,'password' => bcrypt('585')]);
        User::create(['IdEmp' => '876', 'name' =>'MARIA ARACELI SOSA JIMENEZ','Departamento' => 13,'password' => bcrypt('876')]);
        User::create(['IdEmp' => '943', 'name' =>'FORTINO HERNANDEZ HERNANDEZ','Departamento' => 13,'password' => bcrypt('943')]);
        User::create(['IdEmp' => '1057', 'name' =>'LOURDES MICAELA HERNANDEZ RODRIGUEZ','Departamento' => 13,'password' => bcrypt('1057')]);
        User::create(['IdEmp' => '1067', 'name' =>'LUCERO GONZALEZ HERNANDEZ','Departamento' => 13,'password' => bcrypt('1067')]);
        User::create(['IdEmp' => '1091', 'name' =>'RAFAEL SANCHEZ VAZQUEZ','Departamento' => 13,'password' => bcrypt('1091')]);
        User::create(['IdEmp' => '1100', 'name' =>'GLORIA VELEZ RODRIGUEZ','Departamento' => 13,'password' => bcrypt('1100')]);
        User::create(['IdEmp' => '1104', 'name' =>'DAVID ZAMBRANO SAUCEDO','Departamento' => 13,'password' => bcrypt('1104')]);
        User::create(['IdEmp' => '1109', 'name' =>'NOE RAMIREZ LEYVA','Departamento' => 13,'password' => bcrypt('1109')]);
        User::create(['IdEmp' => '1131', 'name' =>'YAQUELINE CASTILLO BADILLO','Departamento' => 13,'password' => bcrypt('1131')]);
        User::create(['IdEmp' => '1132', 'name' =>'MARIA COTZOMI LOPEZ','Departamento' => 13,'password' => bcrypt('1132')]);
        User::create(['IdEmp' => '1133', 'name' =>'MARIBEL GUTIERREZ ALTAMIRANO','Departamento' => 13,'password' => bcrypt('1133')]);
        User::create(['IdEmp' => '1134', 'name' =>'EMMA SALAS SOSA','Departamento' => 13,'password' => bcrypt('1134')]);
        User::create(['IdEmp' => '1135', 'name' =>'JESSICA SAUCEDO ROJAS','Departamento' => 13,'password' => bcrypt('1135')]);
        User::create(['IdEmp' => '1172', 'name' =>'GICELA ROMERO VEGA','Departamento' => 13,'password' => bcrypt('1172')]);
        User::create(['IdEmp' => '1176', 'name' =>'MAYRA AZUCENA SOLANO JUAREZ','Departamento' => 13,'password' => bcrypt('1176')]);
        User::create(['IdEmp' => '1177', 'name' =>'DIANA AGUILAR DIAZ','Departamento' => 13,'password' => bcrypt('1177')]);
        User::create(['IdEmp' => '1185', 'name' =>'ELISA AGUILAR LIMON','Departamento' => 13,'password' => bcrypt('1185')]);
        User::create(['IdEmp' => '1191', 'name' =>'URIEL FLORES GUZMAN','Departamento' => 13,'password' => bcrypt('1191')]);
        User::create(['IdEmp' => '1198', 'name' =>'ADRIANA NAJERA MATA','Departamento' => 13,'password' => bcrypt('1198')]);
        User::create(['IdEmp' => '1199', 'name' =>'MARICARMEN ROMERO VEGA','Departamento' => 13,'password' => bcrypt('1199')]);
        User::create(['IdEmp' => '1200', 'name' =>'ADRIANA CAMARGO ALBINO','Departamento' => 13,'password' => bcrypt('1200')]);
        User::create(['IdEmp' => '1217', 'name' =>'YOLANDA HERNANDEZ DIAZ','Departamento' => 13,'password' => bcrypt('1217')]);
        User::create(['IdEmp' => '1218', 'name' =>'MARIA IVONE HERNANDEZ CUELLAR','Departamento' => 13,'password' => bcrypt('1218')]);
        User::create(['IdEmp' => '1219', 'name' =>'FRANCISCA FLORES HERNANDEZ','Departamento' => 13,'password' => bcrypt('1219')]);
    }
}
