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
window.JSZip = jszip;
