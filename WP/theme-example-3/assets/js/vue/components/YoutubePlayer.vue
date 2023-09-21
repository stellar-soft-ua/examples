<template>
    <div class="vue--youtube-player" v-bind:class="{ playing, loading }">
        <div class="theme-youtube-video__player-wrapper">
            <div class="theme-youtube-video__player-inside">
                <div class="theme-youtube-video__player-video">
                    <div ref="player"></div>
                </div>
            </div>
        </div>

        <div class="vue--youtube-player__preview" @click="play" v-show="!started">
            <slot name="preview" :play="play" :stop="stop"></slot>
        </div>
    </div>
</template>

<script>
    import YoutubePlayer from 'youtube-player';

    const EVENT_VIDEO_STOP_OTHERS = 'video/stop-others';

    export default {
        data: () => ({
            player: null,
            playing: false,
            // Whether the overlay is currently shown
            open: false,
            // Whether the video has been started once
            started: false,
            // Whether the player is loading
            loading: false
        }),
        props: {
            // The ID of the YouTube Video
            id: {
                type: String,
                required: true
            },
            // The iFrame showinfo attribute
            showinfo: {
                type: Boolean,
                default: () => true
            },
            // Whether the video should be pre-loaded or when clicking the play button
            // in the preview screen
            preload: {
                type: Boolean,
                default: () => false
            }
        },
        created() {
            this.$bus.$on(EVENT_VIDEO_STOP_OTHERS, component => {
                if (component !== this && !!this.player) {
                    this.player.pauseVideo();
                }
            });
        },
        mounted() {
            if (this.preload) {
                this.initYoutubePlayer();
            }

            document.addEventListener('keydown', e => {
                if (e.key === 'Escape' && this.open) {
                    this.close();
                }
            });
        },
        methods: {
            initYoutubePlayer() {
                if (this.player) {
                    return;
                }

                this.loading = true;

                this.player = YoutubePlayer(this.$refs.player, {
                    playerVars: {
                        rel: 0,
                        showinfo: +this.showinfo,
                        modestbranding: 1,
                        autoplay: 0
                    }
                });

                this.player.cueVideoById(this.id);

                this.player.on('stateChange', event => {
                    if (event.data === 1 || event.data === 3) {
                        this.$bus.$emit(EVENT_VIDEO_STOP_OTHERS, this);

                        this.$nextTick(() => {
                            this.open = true;
                            this.started = true;
                        });
                    }

                    this.playing = event.data === 1;
                });

                this.loading = false;
            },
            play() {
                this.open = true;

                if (!this.preload && !this.player) {
                    this.initYoutubePlayer();
                }

                this.player.playVideo();
            },
            stop() {
                this.player.pauseVideo();
            },
            close() {
                this.open = false;
                this.stop();
            }
        }
    };
</script>

<style lang="scss">
    .vue--youtube-player > .theme-youtube-video__player-wrapper {
        display: flex;
    }
</style>
