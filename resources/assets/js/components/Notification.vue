<template>
    <div>

    </div>
</template>

<script>
    export default {
        mounted(){
            this.listen()
            console.log("In mounted() id = " + this.id)
        },
        props: ['id'],

        methods: {
            listen() {
                console.log("In listen() id = " + this.id)
                Echo.private('App.User.' + this.id)
                    .notification( (notification) => {
                        alert('new notification')
                        console.log(notification)

                    })

            }
        }
    }
</script>