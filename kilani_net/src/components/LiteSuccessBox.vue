<template>
    <div class="p-4" style="display: inline-block;position: fixed;right: 0px; top: 50px">
        <transition name="slide-right">
            <div v-if="success"  @after-enter="startTimeout()" class="bg-green-100 border border-green-300 text-green-700 p-4 rounded mb-4">
                <p>Item successfully deleted!</p>
            </div>
        </transition>
    </div>
</template>
<script>
export default {
    data() {
        return {

            success: this.done,
        }
    },
    props:{
        done: {
            type: Boolean,
            // default: false,
        },    },
    methods:{
        startTimeout() {
            // Hide the message after 2 seconds
            setTimeout(() => {
                this.success = false;
            }, 1000);
            this.success = true;

        },

    },
    mounted(){
        this.startTimeout()
    }
}
</script>
<style scoped>
/* Slide-in from the right and slide-out to the right */
.slide-right-enter-active,
.slide-right-leave-active {
    transition: transform 2s ease;
}

.slide-right-enter {
    transform: translateX(100%);
}

.slide-right-leave-to {
    transform: translateX(100%);
}
</style>