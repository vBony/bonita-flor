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
                                            <div :id="'flushCollapse_'+index" class="accordion-collapse collapse" :aria-labelledby="'flushHeader_'+index">
                                                <div class="accordion-body">
                                                    <div class="form-check py-2 servicos" v-for="(servico, index) in reg.servicos" :key="index">
                                                        <input class="form-check-input" type="checkbox" v-model="agendamento.servicos" :value="servico" :id="'servico_'+servico.id">
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
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="m-0 p-0 modal-title">Agendar</h3>
                        <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="row p-lg-4 p-md-4 p-sm-0 p-xs-0">
                            <div class="col-12">
                                <div id='calendar'></div>
                                <div class="col-12 alert alert-secondary mt-2" v-if="agendamento.data">
                                    <h4 class="m-0 p-0 text-center">
                                        Para <b class="m-0 p-0 text-underline"> {{dataComDiaSemana(agendamento.data)}} </b>
                                    </h4>
                                </div>
                                <div v-else class="col-12 alert alert-danger mt-2 text-center text-bolder">
                                    <i class="fa-solid fa-triangle-exclamation me-2"></i> Selecione uma data válida
                                </div>

                                <hr class="divider mb-2">

                                <div class="col-12" v-if="agendamento.data">
                                    <div class="col-12" v-for="(servicoAgendamento, index) in agendamento.servicos" :key="index">
                                        <div class="col-12 d-flex justify-content-between align-items-center">
                                            <h5 class="text-bolder p-0 m-0">{{servicoAgendamento.nome}}</h5>
                                            <i class="fas fa-trash text-danger cursor-pointer px-2"></i>
                                        </div>
                                        <div class="col-12 d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="fas fa-clock me-1"></i>
                                                Duração: {{servicoAgendamento.duracao}}h
                                            </div>
                                            <div><h3 class="text-bolder">{{floatParaReal(servicoAgendamento.preco)}}</h3></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-9 col-md-9 col-sm-12">
                                                <div class="form-group">
                                                    <label for="categoriaCadastro">Profissional</label>
                                                    <select class="form-control form-control-sm">
                                                        <option selected :value="null">Selecione um Profissional</option>
                                                        <option v-for="(admin, index) in servicoAgendamento.admins" :value="admin.id">{{admin.nome}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label for="categoriaCadastro">Horário</label>
                                                    <select class="form-control form-control-sm">
                                                        <option selected :value="null"></option>
                                                        <option>13:30</option>
                                                        <option>14:30</option>
                                                        <option>15:30</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="divider mb-2">
                                    </div>

                                    <div class="text-end">
                                        <h3 class="text-bolder">Total: R$9999</h3>
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
                        servicos: [],
                        data: null
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
                        },
                        error: (error) => {
                            alert("Falha ao excluir o serviço, tente novamente mais tarde")
                            this.adminServicos.push(obj);
                        }
                    });
                },

                criarAgendamento() {
                    this.initCalendar()
                    $("#agendamento").modal("show")
                },

                initCalendar(){

                    let min = this.toDate(this.sistema.regras.minDate)
                    let max = this.toDate(this.sistema.regras.maxDate)
                    let diasFolga = this.daysOfWeekDisabled()

                    // Só renderiza o calendário uma vez
                    if(this.calendar == null){
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

                        elem.addEventListener("changeDate", (e)=>{
                            let dataSelecionada = this.calendar.getDate("yyyy/mm/dd")
                            this.selecionouData(dataSelecionada)
                        })

                        // Iniciando o calendário com a data atual selecionada
                        this.calendar.setDate(this.getDataAtual())
                    }else{

                        /** 
                         * Caso o calendário já tenha sido renderizado, apenas realiza a busca da 
                         * disponibilidade dos profissionais
                         */
                        if(this.agendamento.data !== null){
                            this.selecionouData(this.agendamento.data)
                        }
                    }
                },

                selecionouData(data){
                    this.agendamento.data = data

                    console.log(this.agendamento.data)

                    $.ajax({
                        type: "POST",
                        url: `${this.BASE_URL}api/agendamento/disponibilidade`,
                        data: {agendamento: this.agendamento},
                        dataType: 'json',
                        success: (data) => {
                            this.agendamento.servicos = data
                        },
                        error: (error) => {
                            
                        }
                    });
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

                getDataAtual() {
                    const data = new Date();
                    const dia = String(data.getDate()).padStart(2, '0');
                    const mes = String(data.getMonth() + 1).padStart(2, '0'); // Os meses começam em 0, então adicionamos 1.
                    const ano = data.getFullYear();

                    return `${dia}/${mes}/${ano}`;
                },

                dataComDiaSemana(dataString) {
                    const diasDaSemana = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];
                    const partesData = dataString.split('/'); // Supõe-se que a data de entrada esteja no formato "yyyy/mm/dd".
                    const ano = partesData[0];
                    const mes = partesData[1] - 1; // Os meses começam em 0, então subtrai 1.
                    const dia = partesData[2];

                    const data = new Date(ano, mes, dia);
                    const diaSemana = diasDaSemana[data.getDay()];
                    const dataFormatada = `${diaSemana}, ${dia.padStart(2, '0')}/${(mes + 1).toString().padStart(2, '0')}/${ano}`;

                    return dataFormatada;
                },

                floatParaReal(num){
                    //Tirando a reatividade da propriedade
                    let float = JSON.stringify(num)
                    float = JSON.parse(float)

                    float = parseFloat(float)
                    return float.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})
                }
            },

        }

        createApp(app).mount('#app')
    </script>
</body>

</html>
