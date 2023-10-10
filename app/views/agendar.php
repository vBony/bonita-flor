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
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>

    <!-- Date picker -->
    <link rel="stylesheet" href="<?=BASE_URL?>app/assets/libs/datepicker.min.css">
    <script src="<?=BASE_URL?>app/assets/libs/datepicker-full.min.js"></script>
    <link rel="stylesheet" href="<?=BASE_URL?>app/assets/libs/datepicker-bs5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/locales/pt-BR.js"></script>
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
                                        <div class="accordion-item" v-for="(reg, index) in categorias" :key="index">
                                            <h2 class="accordion-header" :id="'flushHeader_'+index">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" :data-bs-target="'#flushCollapse_'+index" aria-expanded="false" :aria-controls="'flushCollapse_'+index">
                                                {{reg.descricao}}
                                                </button>
                                            </h2>
                                            <div :id="'flushCollapse_'+index" class="accordion-collapse collapse" :aria-labelledby="'flushHeader_'+index" data-bs-parent="#categorias">
                                                <div class="accordion-body">
                                                    <div class="form-check py-2 servicos" v-for="(servico, index) in reg.servicos" :key="index">
                                                        <input class="form-check-input" type="checkbox" @change="adicionarServico(servico.id)" v-model="agendamento.servicos" :value="servico.id" :id="'servico_'+servico.id">
                                                        <label class="form-check-label" :for="'servico_'+servico.id">
                                                            {{servico.nome}}
                                                        </label>
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
        <div class="row px-3 fixed-bottom d-flex justify-content-center" v-if="agendamento.servicos.length > 0">
            <div class="p-3 col-lg-4 col-md-6 col-sm-12 d-flex flex-row align-items-center card mb-2">
                <div class="col-6">
                    <h5 class="m-0">{{agendamento.servicos.length}} Serviços</h5>
                    <a href="#" class="text-muted p-0" @click="agendamento.servicos = []"><i class="fa-regular fa-circle-xmark"></i> Limpar Serviços</a>
                </div>
                <div class="d-flex col-6">
                    <button class="btn btn-primary ms-auto" @click="criarAgendamento()">Agendar <i class="fa-solid fa-right-long"></i></button>
                </div>
            </div>
        </div>
        <div class="modal fade" id="agendamento" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-between align-items-center">
                                <h3 class="m-0 p-0">Agendar</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                        </div>

                        <div class="row p-lg-4 p-md-4 p-sm-0 p-xs-0">
                            <div class="col-12">
                                <div id='calendar' data-date="09/10/2023"></div>
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
                    calendar: null,
                    sistema: {
                        endereco: {
                            cep: null,
                            logradouro: null,
                            numero: null,
                            complemento: null,
                            bairro: null,
                            cidade: null,
                            estado: null,
                        },

                        regras: {
                            minDate: null,
                            maxDate: null
                        },

                        diasAtendimento: {
                            domingo: false,
                            segunda: false,
                            terca: false,
                            quarta: false,
                            quinta: false,
                            sexta: false,
                            sabado: false,
                        }
                    },

                    categorias: [],

                    agendamento: {
                        admin: [],
                        servicos: []
                    },

                    agenda: []
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
                            if(data.sistema.regras != undefined && data.sistema.regras != null){
                                this.sistema.regras = data.sistema.regras
                            }

                            if(data.sistema.endereco != null && data.sistema.endereco != undefined){
                                this.sistema.endereco = data.sistema.endereco
                            }

                            if(data.sistema.diasAtendimento != null && data.sistema.diasAtendimento != undefined){
                                this.sistema.diasAtendimento = data.sistema.diasAtendimento
                            }
                            
                            if(data.categorias !== undefined && data.categorias !== null){
                                this.categorias = data.categorias
                            }

                            this.initCalendar()
                        },
                        error: (error) => {
                            alert("Falha ao excluir o serviço, tente novamente mais tarde")
                            this.adminServicos.push(obj);
                        }
                    });
                },

                adicionarServico(id){
                    let element = $('#servico_'+id)
                    

                    console.log(this.agendamento.servicos)
                },

                criarAgendamento() {
                    $("#agendamento").modal("show")
                },

                initCalendar(){
                    let min = this.toDate(this.sistema.regras.minDate)
                    let max = this.toDate(this.sistema.regras.maxDate)
                    let diasFolga = this.daysOfWeekDisabled()

                    const elem = document.getElementById('calendar');
                    this.calendar = new Datepicker(elem, {
                        pickLevel: 0,
                        maxView: 0,
                        language: 'pt-BR',
                        todayHighlight: true,
                        todayButtonMode: 'select',
                        minDate: min,
                        maxDate: max,
                        daysOfWeekDisabled: diasFolga
                    }); 

                    elem.addEventListener('changeDate', (e) => {
                        let dataSelecionada = this.calendar.getDate('yyyy/mm/dd')
                        this.selecionouData(dataSelecionada);
                    })
                },

                toDate(date){
                    // Sua data no formato 'YYYY/MM/DD'
                    var dataString = date;

                    // Divida a string da data em ano, mês e dia
                    var partesData = dataString.split('/');
                    var ano = partesData[0];
                    var mes = partesData[1];
                    var dia = partesData[2];

                    // Crie uma nova string de data no formato 'DD/MM/YYYY'
                    return dia + '/' + mes + '/' + ano;
                },

                daysOfWeekDisabled(){
                    let semana = this.sistema.diasAtendimento
                    let dias = []

                    if(semana.domingo == false){
                        dias.push(0)
                    }

                    if(semana.segunda == false){
                        dias.push(1)
                    }

                    if(semana.terca == false){
                        dias.push(2)
                    }

                    if(semana.quarta == false){
                        dias.push(3)
                    }

                    if(semana.quinta == false){
                        dias.push(4)
                    }

                    if(semana.sexta == false){
                        dias.push(5)
                    }

                    if(semana.sabado == false){
                        dias.push(6)
                    }

                    return dias
                },

                selecionouData(data){
                    alert(data)
                }
            },

        }

        createApp(app).mount('#app')
    </script>
</body>

</html>
