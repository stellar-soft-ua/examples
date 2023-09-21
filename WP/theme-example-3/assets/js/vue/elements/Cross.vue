<template functional>
    <button class="cross-button" type="button">
        <span class="bar top"></span>
        <span class="bar bottom"></span>
    </button>
</template>

<style lang="scss">
    $thickness: 1px;
    $size: 30px;

    .cross-button {
        outline: none;
        border: none;
        padding: 0;
        transition: all .3s;
        width: $size;
        height: $size;
        position: relative;
        overflow: hidden;
        background: transparent;

        &, &:focus {
            outline: none;
        }

        &:hover {
            opacity: 0.6;
        }

        .bar {
            position: absolute;
            width: 140%;
            height: $thickness;
            display: block;
            transition: all .3s;
            background-color: $body-color;
            left: 0;
            transform-origin: left;

            &.top {
                transform: rotate(45deg);
                top: 0;
            }

            &.bottom {
                transform: rotate(-45deg);
                bottom: 0;
            }
        }
    }

</style>
