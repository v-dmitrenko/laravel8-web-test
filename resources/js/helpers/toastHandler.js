import Vue from "vue";

export const toast = {
    error: (errorMsg) => {
        Vue.toasted.show(errorMsg, { position: 'bottom-right', duration: 2500 });
    },
}
