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
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="<?=BASE_URL?>app/assets/css/jquery.mCustomScrollbar.min.css">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">

    <script src="<?=BASE_URL?>app/assets/js/jquery.js"></script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
</head>

<body>
    <div id="app">
        <div class="container container-fluid">
            <div class="row">
                <div class="col-12 py-4 my-4">
                    <h1>Studio Maria Flor 🌷</h1>
                    <h4 class="text-muted">{{sistema.endereco.logradouro}}, {{sistema.endereco.numero}}</h4>
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
