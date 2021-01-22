<template>

    <div>
        <text-input :value="value" @input="update" />
    </div>

</template>

<script>
/**
 * Register this component with:
 * Vue.component('statamic_twitter-fieldtype', require('./path/to/StatamicTwitter.vue'))
 */
export default {

    mixins: [Fieldtype],

    data() {
        return {
            //
        };
    }

};
</script>
