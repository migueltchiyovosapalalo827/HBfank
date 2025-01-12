<template>
    <div class="page">
        <main>
            <nav class="navbar menu navbar-expand-lg navbar-dark fixed-top" aria-label="Tenth navbar example">
                <div class="container-fluid">

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarsExample08" aria-controls="navbarsExample08" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <i class="bi bi-menu-up btn-icone"></i>
                    </button>

                    <div class="collapse navbar-collapse justify-content-md-center" id="navbarsExample08">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <router-link to="/" class="nav-link">INICIO</router-link>
                            </li>

                            <li class="nav-item">
                                <router-link to="/publicidade/promossoes" class="nav-link"> Publicidades</router-link>

                            </li>



                        </ul>
                    </div>
                </div>
            </nav>

        </main>
        <slot></slot>
        <div class="col-md-12 myfooter">
            <div class="container">
                <footer class="d-flex flex-wrap justify-content-between align-items-center py-3">


                    <ul class="nav col-md-12 justify-content-end list-unstyled d-flex">
                        <li class="ms-2"><a class="text-muted" href="#"><i class="bi bi-facebook"
                                    style="color: rgb(177, 177, 177); font-size: 15pt;"></i></a></li>
                        <li class="ms-2"><a class="text-muted" href="#"><i class="bi bi-whatsapp"
                                    style="color: rgb(177, 177, 177); font-size: 15pt;"></i></a></li>
                        <li class="ms-2"><a class="text-muted" href="#"><i class="bi bi-instagram"
                                    style="color: rgb(177, 177, 177); font-size: 15pt;"></i></a></li>
                        <li class="ms-4"><a class="text-muted" href="#"><i class="bi bi-geo-alt"
                                    style="color: rgb(177, 177, 177); font-size: 15pt;"></i> Bairro do Alto-Liro
                                /Lobito-Benguela-Angola</a></li>

                    </ul>
                </footer>
            </div>
        </div>

    </div>
</template>

<script>
import { computed } from 'vue'
export default {
    setup() {
        const user = computed(() => store.getters['auth/user'])
        return { user }
    }
}
</script>
