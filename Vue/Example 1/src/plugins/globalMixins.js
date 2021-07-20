import VueLoading from '@/mixins/VueLoading';

const GlobalMixins = {
    install(Vue) {
        Vue.mixin(VueLoading);
    }
};

export default GlobalMixins;
