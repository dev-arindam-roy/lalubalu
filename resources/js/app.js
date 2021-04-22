require('./bootstrap');

window.Vue = require('vue').default;
Vue.config.productionTip = true;

//Vuelidate
import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)


//Smooth Scroll
import VueSmoothScroll from 'vue2-smooth-scroll'
Vue.use(VueSmoothScroll, {
  duration: 600,
  offset: -10,
  updateHistory: false,
})


//Toastr
import CxltToastr from 'cxlt-vue2-toastr'
import 'cxlt-vue2-toastr/dist/css/cxlt-vue2-toastr.css'

var toastrConfigs = {
    position: 'top right',
    showDuration: 1000,
    timeOut: 5000,
    closeButton: true,
    showMethod: 'fadeIn',
    hideMethod: 'fadeOut',
    //progressBar: true
}
Vue.use(CxltToastr, toastrConfigs)


//Sweet Alert2
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
const options = {
    confirmButtonColor: '#1BA39C',
    cancelButtonColor: '#cc1f00',
};
Vue.use(VueSweetalert2, options);


//Html2Canvas
import VueHtml2Canvas from 'vue-html2canvas';
Vue.use(VueHtml2Canvas);


//Bootstrap DateTime Picker 
jQuery.extend(true, jQuery.fn.datetimepicker.defaults, {
    icons: {
      time: 'far fa-clock',
      date: 'far fa-calendar',
      up: 'fas fa-arrow-up',
      down: 'fas fa-arrow-down',
      previous: 'fas fa-chevron-left',
      next: 'fas fa-chevron-right',
      today: 'fas fa-calendar-check',
      clear: 'far fa-trash-alt',
      close: 'far fa-times-circle'
    }
});

// import routes
import webRoutes from './route/route';

// import components
Vue.component('page-loader', require('./components/pageLoadingComponent.vue').default);
import appIndex from './components/appIndexComponent'

const app = new Vue({
    data() {
        return {
            isPageLoadingActive: false,
            isHeaderNavShow: true,
        }
    },
    components: {
        appIndex
    },
    methods: {

    },
    mounted() {
        
    },
    el: '#app',
    router: webRoutes
});
