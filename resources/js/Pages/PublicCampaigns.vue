<template>
    <div class="bg-gray-200 min-vh-100">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <router-link to="/" class="nav-link">INICIO</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/publicidade/promossoes" class="nav-link">Publicidades</router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Campaigns Section -->
        <div class="container my-5">
            <div class="row">
                <div class="col-md-4 mb-4" v-for="campaign in campaigns" :key="campaign.id">
                    <div class="card h-100 shadow-sm" v-if="campaign.is_active==1">
                        <img :src="campaign.image_url" class="card-img-top" alt="Imagem da campanha">
                        <div class="card-body">
                            <h5 class="card-title"> <small class="text-muted">{{ campaign.title }}</small></h5>
                            <p class="card-text"><small class="text-muted">{{ campaign.description }}</small></p>
                            <p class="card-text" v-if="campaign.price > 0">
                                <small class="text-muted">{{ campaign.price | currency }}</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            campaigns: []
        };
    },
    methods: {
        fetchCampaigns() {
            axios.get('/api/campaigns')
                .then(({ data }) => {
                    this.campaigns = data.data.data;
                });
        }
    },
    mounted() {
        this.fetchCampaigns();
    }
};
</script>

<style scoped>
.bg-gray-200 {
    background-color: #e2e2e2;
    /* Cor de fundo cinza */
}

.navbar-dark .navbar-nav .nav-link {
    font-size: 1.2em;
}

.card-img-top {
    height: 200px;
    object-fit: cover;
}
</style>
