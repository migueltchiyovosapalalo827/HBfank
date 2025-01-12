<!-- src/components/AdminCampaigns.vue -->

<template>
    <Main>

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Gerenciar Campanhas Publicitárias</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Lista de Campanhas</h3>
                                <button class="btn btn-primary float-right" @click="newModal">Adicionar Nova
                                    Campanha</button>
                            </div>
                            <div class="card-body">
                                <div class="card-body table-responsive p-0">
                                    <Table :fields="fields">



                                        <tr v-for="(campaign, index) in campaigns" :key="campaign.id">
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ campaign.title }}</td>
                                            <td>{{ campaign.price }}</td>
                                            <td>{{ campaign.is_active ? 'sim' : 'não' }}</td>
                                            <td>
                                                <a href="#" @click="editCampaign(campaign)">
                                                    <i class="fa fa-edit blue"></i>
                                                </a>
                                                /
                                                <a href="#" @click="deleteCampaign(campaign.id)">
                                                    <i class="fa fa-trash red"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </Table>

                                </div>
                            </div>
                            <div class="card-footer">
                                <pagination :data="campaigns" @pagination-change-page="getResults"></pagination>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" v-show="!editmode">Adicionar Nova Campanha</h5>
                                <h5 class="modal-title" v-show="editmode">actualizar Campanha</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>


                            <form @submit.prevent="submitForm()" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="title">Título:</label>
                                        <input v-model="form.title" type="text" class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('title') }" id="title">
                                        <div v-if="form.errors.has('title')" v-html="form.errors.get('title')" />

                                    </div>
                                    <div class="form-group">
                                        <label for="description">Descrição:</label>
                                        <textarea v-model="form.description" class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('description') }"
                                            id="description"></textarea>

                                        <div v-if="form.errors.has('description')"
                                            v-html="form.errors.get('description')" />

                                    </div>

                                    <div class="form-group">
                                        <label for="imagens">Imagem:</label>
                                        <input type="file" name="imagens[]" multiple @change="handleFile"
                                            class="form-control" id="imagens"
                                            :class="{ 'is-invalid': form.errors.has('imagens') }">

                                        <div v-if="form.errors.has('imagens')" v-html="form.errors.get('imagens')" />

                                    </div>

                                    <div class="form-group">
                                        <label for="price">Preço:</label>
                                        <input v-model="form.price" type="number" step="0.01" class="form-control"
                                            id="price" :class="{ 'is-invalid': form.errors.has('price') }">


                                        <div v-if="form.errors.has('price')" v-html="form.errors.get('price')" />

                                    </div>
                                    <div class="form-group form-check">
                                        <input name="is_active" type="checkbox" class="form-check-input"
                                            id="is_active" :class="{ 'is-invalid': form.errors.has('is_active') }" @change="checkActive">
                                        <label class="form-check-label" for="is_active">Ativo</label>
                                    </div>


                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Cancelar</button>
                                    <button v-show="editmode" type="submit" class="btn btn-success">actualizar</button>
                                    <button v-show="!editmode" type="submit" class="btn btn-primary">Salvar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </Main>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            form: new Form({
                id: '',
                title: '',
                description: '',
                price: 0,
                is_active: 1,
                imagens: [],
            }),
            campaigns: [],
            fields: ['Título', 'Preço', 'Ativo'],
            editmode: false,
        };
    },
    methods: {
        handleFile(event) {
            for (let index = 0; index < event.target.files.length; index++) {
                const file = event.target.files[index];
                this.form.imagens.push(file);
            }


        },
        getResults(page = 1) {

            this.$Progress.start();

            axios.get('api/advertisements?page=' + page).then(({ data }) => (this.campaigns = data.data))
                .catch((error) => {
                    if (error.response.status === 401 && error.response.statusText === "Unauthorized" ||
                        error.response.status === 419 && error.response.statusText === "Unauthorized") { this.$store.dispatch('auth/logout'); }
                });

            this.$Progress.finish();
        },
        checkActive() {
            this.form.is_active = this.form.is_active ? 1 : 0;


        },

        editCampaign(campaign) {
            this.editmode = true;
            this.form.reset();

            this.form.title = campaign.title;
            this.form.description = campaign.description;
            this.form.price = campaign.price;
            this.form.is_active = campaign.is_active;
            this.form.id = campaign.id;
            $('#addNew').modal('show');
        },
        newModal() {
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },
        fetchCampaigns() {
            axios.get('/api/advertisements')
                .then( ({ data }) => (
                    this.campaigns = data.data.data
                ));
        },
        getFormData(object, method) {
            const formdata = new FormData();
            Object.keys(object).forEach(key => {
                if (Array.isArray(object[key])) {
                    for (const index of Object.keys(object[key])) {
                        formdata.append(key + '[' + index + ']', object[key][index])
                    }
                } else {
                    formdata.append(key, object[key])
                }
            });
            formdata.append('_method', method);
            return formdata;
        },
        async submitForm() {
            try {
                let response = {};
                const url = this.form.id ? `/api/advertisements/${this.form.id}` : '/api/advertisements';
                this.form.id ?
                    response = await axios.post(url, this.getFormData(this.form, 'PUT'), { headers: { 'Content-Type': 'multipart/form-data' } })
                    : response = await this.form.post(url, { headers: { 'Content-Type': 'multipart/form-data' } });

                Toast.fire({
                    icon: 'success',
                    title: response.data.message
                });

                await this.fetchCampaigns();
                $('#addNew').modal('hide');
                this.form.reset();
            } catch (error) {
                console.error('Error submitting form:', error);

                if (error.response && (error.response.status === 401 || error.response.status === 419) && error.response.statusText === "Unauthorized") {
                    await this.$store.dispatch('auth/logout');
                }

                Toast.fire({
                    icon: 'error',
                    title: error.response?.data?.message || 'An error occurred'
                });
            }
        },

        deleteCampaign(id) {
            axios.delete(`/api/advertisements/${id}`)
                .then(this.fetchCampaigns);
        }

    },
    mounted() {
        this.fetchCampaigns();
    }
};
</script>
