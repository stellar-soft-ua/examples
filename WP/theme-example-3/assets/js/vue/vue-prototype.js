import Vue from 'vue';

import {i18n} from './translation';

if (process.env === 'development') {
    Vue.config.devtools = true;
} else {
    Vue.config.productionTip = false;
}

Vue.prototype.$bus = new Vue();
Vue.prototype.$wp = window.wp_data || {};

Vue.mixin({
    data: () => ({
        // Make i18n available in custom elements, since they are not initialized with the custom vue options beneath
        i18n
    }),
    methods: {
        ellipsis(value, length) {
            return value.length > length ? `${value.substring(0, length)}...` : value;
        }
    }
});

export {Vue};
