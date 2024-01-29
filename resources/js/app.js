require('./bootstrap');
import $ from "jquery";
window.$ = $;
import 'bootstrap';
import swal from 'sweetalert2';
window.Swal = swal;

require('./web/template');
require('./web/main');
