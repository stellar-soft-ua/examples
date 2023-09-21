import CreateVue from './vue';

const nodes = document.querySelectorAll('[data-vue-instance]');

for (const node of nodes) {
    CreateVue(node);
}
