import {Vue} from '../vue-prototype';

import CustomElement from 'vue-custom-element';
import SearchIcon from './icons/Search';

import Search from './Search';
import Cross from './Cross';
import Spinner from './Spinner';
import CleverReach from './CleverReach';

Vue.use(CustomElement);

Vue.customElement('theme-cross', Cross);
Vue.customElement('theme-spinner', Spinner);
Vue.customElement('theme-icon-search', SearchIcon);
Vue.customElement('theme-search', Search);
Vue.customElement('clever-reach', CleverReach);
