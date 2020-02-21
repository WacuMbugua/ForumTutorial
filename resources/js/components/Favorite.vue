<template>
    <button type="submit" :class="classes" @click="toggle">
    <button type="submit" class="btn btn-default">
        <span class="glyphicon glyphicon-heart"></span>
        <span v-text="count"></span>
    </button>
</template>

<script>
    export default {
        props: ['reply'],
        data() {
            return {
                count: this.reply.favoritesCount
            }
        },
        computed: {
            classes() {
                return ['btn', this.active ? 'btn-primary' : 'btn-default'];
            }
        },
        methods: {
            toggle() {
                if (this.isFavorited) {
                    axios.delete('/replies/' + this.reply.id + '/favorites');
                } else {
                    axios.post('/replies/' + this.reply.id + '/favorites');
                }
            }
        }
    }
</script>
