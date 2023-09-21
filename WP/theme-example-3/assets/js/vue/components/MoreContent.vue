<template>
    <div class="v--more-content">
        <div ref="slot" class="slot" :class="{ expanded, collapsed: exceedsHeight && !expanded }"
             :style="{overflowY: 'hidden', maxHeight: currentHeight + 'px'}">
            <slot/>
        </div>

        <template v-if="exceedsHeight">
            <slot name="expand" v-bind="{ expanded, toggle: this.toggleExpanded }">EXPAND ME</slot>
        </template>
    </div>
</template>

<script>
    export default {
        props: {
            maxHeight: {
                type: Number,
                required: true
            }
        },
        data: () => ({
            expanded: false,
            scrollHeight: 0,
            exceedsHeight: false
        }),
        computed: {
            currentHeight() {
                return this.expanded ? this.$refs.slot.scrollHeight : this.maxHeight;
            }
        },
        mounted() {
            this.exceedsHeight = this.$refs.slot.scrollHeight > this.maxHeight;
        },
        methods: {
            toggleExpanded() {
                this.expanded = !this.expanded;
            }
        }
    };
</script>

<style lang="scss" scoped>
    .v--more-content {
      max-width: 100%;

      .slot {
        max-width: 100%;
        transition: $transition-base;
        position: relative;

        &:after {
          content: '';
          display: block;
          position: absolute;
          bottom: 0;
          left: 0;
          right: 0;
          height: 30px;
          background: linear-gradient(#ffffff00, #ffffffff);
          transition: $transition-base;
          opacity: 1;
        }

        &.expanded:after {
          opacity: 0;
        }
      }
    }
</style>
