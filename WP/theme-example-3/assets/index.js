// Import polyfills
import './js/polyfills';
import './js/plugins';
import './js/alpine'
import './js/vue';

// Import styles
import './sass/style.scss';

// Enable hot reloading for standard javascript files
if (module.hot) {
    module.hot.accept();
}
