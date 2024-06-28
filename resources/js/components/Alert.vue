<template>
    <div :class="estilo">
        <h4>{{ titulo }}</h4>
        <p v-if="tipo == 'success'">{{ detalhes }}</p>
        <ul v-if="tipo == 'danger'">
            <li v-for="e, key in detalhes" :key="key"> {{ e[0] }}</li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['tipo', 'titulo', 'detalhes'],
        computed: {
            estilo() {
                return 'alert alert-'+this.tipo
            }
        }
    }
</script>