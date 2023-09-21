<script>
    import PostsLoader from './PostsLoader';
    import cssVars from 'css-vars-ponyfill';

    export default {
        mixins: [
            PostsLoader
        ],
        props: {
            postType: {
                default: () => 'deposits'
            }
        },
        watch: {
            posts() {
              this.$nextTick(() => this.updateCoverSize());
              this.$nextTick(() => cssVars());
            }
        },
        mounted() {
            window.addEventListener('resize', () => this.updateCoverSize());
        },
        methods: {
            updateCoverSize() {
                document.querySelectorAll('.cover-content').forEach(cover => {
                    cover.style.minHeight = cover.clientWidth + 'px';
                })
            }
        }
    };
</script>
