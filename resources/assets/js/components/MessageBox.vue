<!-- MessageBox Component -->
<template>
    <transition name="modal">
        <div class="modal-mask" @click="$emit('close')">
            <div class="modal-wrapper" @click.stop>
                <div class="modal-container">
                    <div class="modal-body">
                        <slot name="body"></slot>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" @click="$emit('close')">閉じる</button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        name: "MessageBox",
        data() {
            return {
                showModal: false
            }
        }
    }
</script>

<style scoped>
    .modal-mask {
        background: rgba(0, 0, 0, 0.5);
        position: fixed;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        z-index: 9998;
        transition: all .5s ease;
    }

    .modal-container {
        width: 300px;
        background: #ffffff;
        padding: 20px;
        position: absolute;
        left: 50%;
        top: 50%;
        margin-left: -150px;
        margin-top: -100px;
        transition: all .3s ease;
        border-radius: 10px;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        top: -200px;
    }
</style>