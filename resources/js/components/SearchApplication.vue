<template>
   <search-component  />
</template>

<script>
    import SearchComponent from './SearchComponent.vue'

    export default {
        components : {
            'search-component': SearchComponent
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
