import Alpine from 'alpinejs';
import axios from 'axios';
import {initForms} from "../plugins/form";

Alpine.data('modal', () => ({
    open: false,
    post: null,
    init() {
        window.showModal = window.showModal || ((id) => {
            this.show(id);
        });

        document.querySelectorAll('[data-show-modal]').forEach((item) => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                this.show(item.getAttribute('data-show-modal'));

                return false;
            });
        });
    },
    show(id) {
        this.open = true;
        document.body.classList.add('modal-open');
        this.load(id);
    },
    hide() {
        if (this.open) {
            this.open = false;
            document.body.classList.remove('modal-open');
            this.post = null;
        }
    },
    runScripts() {
        Array.from(this.$refs.content.querySelectorAll("script")).forEach(item => {
            const script = document.createElement("script");

            Array.from(item.attributes).forEach(attr => script.setAttribute(attr.name, attr.value));
            script.appendChild(document.createTextNode(item.innerHTML));
            item.parentNode.replaceChild(script, item);
        });

        this.$refs.content.querySelectorAll('.g-recaptcha').forEach(item => {
            if (window.grecaptcha) {
                window.grecaptcha.render(item)
            }
        })
    },
    load(id) {
        axios.get('/modals/' + id, {
            params: {
                lang: document.documentElement.lang || null
            }
        }).then(res => {
            this.post = res.data;

            this.$nextTick(() => {
                initForms();
                this.runScripts();
            })
        }, err => {
            this.hide();
        })
    }
}));
