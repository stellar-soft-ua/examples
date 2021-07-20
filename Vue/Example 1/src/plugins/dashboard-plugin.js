import '@/polyfills';

import Notifications from '@/components/NotificationPlugin';

import { configure } from 'vee-validate';

import GlobalComponents from './globalComponents';

import GlobalDirectives from './globalDirectives';


import GlobalMixins from './globalMixins';

import VueMoment from 'vue-moment';

import VueCookies from 'vue-cookies';

import VueClipboard from 'vue-clipboard2';

import axios from './axios';
import VueAxios from 'vue-axios';

import SideBar from '@/components/SidebarPlugin';

import lang from 'element-ui/lib/locale/lang/en';
import locale from 'element-ui/lib/locale';
locale.use(lang);

import VueLoading from 'vue-loading-overlay';

// asset imports
import '@/assets/sass/argon.scss';
import '@/assets/css/nucleo/css/nucleo.css';
import { extend } from 'vee-validate';
import * as rules from 'vee-validate/dist/rules';
import { messages } from 'vee-validate/dist/locale/en.json';

Object.keys(rules).forEach(rule => {
    extend(rule, {
        ...rules[rule], // copies rule configuration
        message: messages[rule] // assign message
    });
});

export default {
    install(Vue) {
        Vue.use(GlobalComponents);
        Vue.use(VueMoment);
        Vue.use(VueAxios, axios);
        Vue.use(GlobalDirectives);
        Vue.use(GlobalMixins);
        Vue.use(SideBar);
        Vue.use(Notifications);
        Vue.use(VueCookies);
        Vue.use(VueClipboard);
        Vue.use(VueLoading, {
            color: 'blue',
            height: 128,
            width: 128
        });
        configure({
            classes: {
                valid: 'is-valid',
                invalid: 'is-invalid',
                dirty: ['is-dirty', 'is-dirty'], // multiple classes per flag!
            }
        })
    }
};
