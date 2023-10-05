<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Agendar | Maria Flor</title>

    <!-- Custom fonts for this template-->
    <link href="<?=BASE_URL?>app/assets/libs/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- bootstrap css -->
    <link rel="stylesheet" href="<?=BASE_URL?>app/assets/css/bootstrap.css">
    <!-- style css -->
    <link rel="stylesheet" href="<?=BASE_URL?>app/assets/css/home.css">
    <!-- Responsive-->
    <link rel="stylesheet" href="<?=BASE_URL?>app/assets/css/responsive.css">
    <!-- fevicon -->
    <link rel="icon" href="images/fevicon.png" type="image/gif" />

    <!-- style css -->
    <link rel="stylesheet" href="<?=BASE_URL?>app/assets/css/home.css">
    <link rel="stylesheet" href="<?=BASE_URL?>app/assets/css/agendar.css">


    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="<?=BASE_URL?>app/assets/css/jquery.mCustomScrollbar.min.css">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">


    <script src="<?=BASE_URL?>app/assets/js/bootstrap.js"></script>

    <script src="<?=BASE_URL?>app/assets/js/jquery.js"></script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
</head>

<body>
    <div id="app">
        <div class="container container-fluid">
            <div class="row py-4 my-4">
                <div class="col-12">
                    <h2>Maria Flor 🌷</h2>
                    <h4 class="text-muted">
                        {{sistema.endereco.logradouro}}, 
                        {{sistema.endereco.complemento + ','}} 
                        nº{{sistema.endereco.numero}} 
                        {{sistema.endereco.bairro}},
                        {{sistema.endereco.cidade}} - {{sistema.endereco.estado}}
                    </h4>
                    <div class="btn btn-light" role="button">
                        <div class="fw-bold d-flex align-items-center">
                            <i class="fa-solid fa-star text-gold mb-1 me-1"></i> 
                            5,0
                            <div class="ms-4 text-muted">10 avaliações</div>
                        </div>
                    </div>

                    <hr class="divider mt-3 mb-2">
                </div>


                <div class="col-12">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-menu">
                            <i class="fa-solid fa-circle-info"></i>
                            Informações
                        </button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12"><h1>Agendamento</h1></div>
                <div class="col-12">
                    <div class="card card-margin">
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-search">
                                        <i class="fa fa-search"></i>
                                        <input type="text" class="form-control search-element" placeholder="Buscar Serviço">
                                    </div>
                                </div>

                                <div class="col-12 mt-4">
                                    <h2>Categorias</h2>

                                    <div class="accordion accordion-flush" id="categorias">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                                    Accordion Item #1
                                                </button>
                                            </h2>
                                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                                                <div class="accordion-body">
                                                    <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?=BASE_URL?>app/assets/js/bootstrap.bundle.min.js"></script>    

    <script src="<?=BASE_URL?>app/assets/libs/maskMoney.js"></script>    
    <script src="<?=BASE_URL?>app/assets/libs/jquery.mask.js"></script>  
    <input type="hidden" id="burl" value="<?=BASE_URL?>">

    <script>
        const { createApp } = Vue

        const app = {
            data() {
                return {
                    BASE_URL: $('#burl').val(),
                    sistema: {
                        endereco: {
                            cep: null,
                            logradouro: null,
                            numero: null,
                            complemento: null,
                            bairro: null,
                            cidade: null,
                            estado: null,
                        }
                    }
                }
            },
            
            mounted(){
                this.buscarDados()
            },

            methods:{
                buscarDados(){
                    $.ajax({
                        type: "POST",
                        url: `${this.BASE_URL}api/agendamento`,
                        dataType: 'json',
                        success: (data) => {
                            if(data.endereco != null){
                                this.sistema.endereco = data.endereco
                            }
                        },
                        error: (error) => {
                            alert("Falha ao excluir o serviço, tente novamente mais tarde")
                            this.adminServicos.push(obj);
                        }
                    });
                }
            }
        }

        createApp(app).mount('#app')
    </script>
</body>

</html>
