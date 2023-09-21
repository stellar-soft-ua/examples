<div id="global-modal"
     x-data="modal"
     x-on:keydown.escape.window="hide()"
     x-on:show="show()"
     x-cloak>
    <div
            x-show="open"
            x-transition:enter="modal-transition"
            x-transition:enter-start="modal-leave-to"
            x-transition:leave="modal-transition"
            x-transition:leave-end="modal-leave-to"
            class="modal fullscreen"
            tabindex="-1"
            role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header filled">
                    <div class="{{ $container }}">
                        <theme-cross class="float-right" @click="hide()"></theme-cross>
                        <template x-if="post">
                            <div class="modal-title h1" x-text="post.title"></div>
                        </template>
                    </div>
                </div>
                <div class="modal-body filled">
                    <div class="{{$container}}">
                        <div class="row">
                            <div class="{{ $columns }}">
                                <template x-if="post">
                                    <div x-html="post.content" x-ref="content"></div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
