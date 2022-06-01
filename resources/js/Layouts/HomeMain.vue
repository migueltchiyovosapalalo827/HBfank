<template>
   <div class="page">
        <main>
            <nav class="navbar menu navbar-expand-lg navbar-dark fixed-top" aria-label="Tenth navbar example">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Never expand</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarsExample08" aria-controls="navbarsExample08" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <i class="bi bi-menu-up btn-icone"></i>
                    </button>

                    <div class="collapse navbar-collapse justify-content-md-center" id="navbarsExample08">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="#">INICIO</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">MENU</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">SOBRE</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">CONTACTOS</a>
                            </li>

                            <li class="nav-item nav-items dropdown menu-perfil">
                                <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-bs-toggle="dropdown"
                                    aria-expanded="false"><i class="bi bi-person-circle"></i></a>
                                <ul class="dropdown-menu" aria-labelledby="dropdown01">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
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
                    <ul class="nav col-md-6 justify-content-start">
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Home</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Features</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Pricing</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">FAQs</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">About</a></li>
                    </ul>

                    <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                        <li class="ms-3"><a class="text-muted" href="#"><i class="bi bi-facebook"
                                    style="color: rgb(177, 177, 177); font-size: 15pt;"></i></a></li>
                        <li class="ms-3"><a class="text-muted" href="#"><i class="bi bi-whatsapp"
                                    style="color: rgb(177, 177, 177); font-size: 15pt;"></i></a></li>
                        <li class="ms-3"><a class="text-muted" href="#"><i class="bi bi-instagram"
                                    style="color: rgb(177, 177, 177); font-size: 15pt;"></i></a></li>
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
    const user =  computed(() => store.getters['auth/user'])
    return { user }
  }
}
</script>


