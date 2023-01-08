<template>
    <div class="card text-center">
        <div class="card-header">
            {{ title }}
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Name: {{ userInfo.name }} </li>
                <li class="list-group-item">Email: {{ userInfo.email }}</li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    setup: () => ({
        title: 'Profile information'
    }),
    data() {
        return {
            userInfo: {
                id: '',
                name: '',
                email: '',
            },
        }
    },
    mounted() {
        this.getUserInfo();
    },
    methods: {
        getUserInfo() {
            axios.get(window.url + 'api/getUserInfo').then(response => {
                console.log(response.data);
                this.userInfo = response.data;
                console.log(this.userInfo);
            }).catch(errors => {
                console.log(errors);
            });
        },
    }
}
</script>