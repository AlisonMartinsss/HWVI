<template>
    <div class="container">
        <section id="tarefa">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Inicial</li>
                    <li class="breadcrumb-item active" aria-current="page">Tarefas</li>
                </ol>
            </nav>
            <div class="content">
                <div class="card mb-4">
                    <div class="card-header">Tarefas</div>
                    <div class="card-body mt-0 pt-0">
                        <div class="row pt-2">
                            <div class="col table-responsive">
                                <table id="tarefa-table" class="table table-striped text-center table-bordered table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Usuário</th>
                                            <th>Data de Abertura</th>
                                            <th>Assunto</th>
                                            <th>Status</th>
                                            <th>Data de Fechamento</th>
                                            <th class="no-print">Opções</th>
                                            <th class="print-only">Descrição</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer clearfix">
                        <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#criar-tarefa" @click="limparStatus()">Criar Tarefa</button>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="modal fade" id="criar-tarefa">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title ">Criar Tarefa</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <alert tipo="success" titulo="Cadastro realizado" :detalhes="transacaoDetalhes" v-if="transacaoStatus == 'sucesso'"></alert>
                    <alert tipo="danger" titulo="Erro ao cadastrar" :detalhes="transacaoDetalhes" v-if="transacaoStatus == 'erro'"></alert>
                    <div v-if="transacaoStatus != 'sucesso'">
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="assunto" class="form-label ">Assunto</label>
                                <input type="text" class="form-control" placeholder="Assunto" id="assunto" name="assunto" v-model="assunto">
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-4">
                                <label for="prioridade" class="form-label ">Prioridade</label>
                                <select class="form-select" name="prioridade" id="prioridade" v-model="prioridade">
                                    <option value="">Selecione</option>
                                    <option value="Miníma">Miníma</option>
                                    <option value="Baixa">Baixa</option>
                                    <option value="Normal">Normal</option>
                                    <option value="Alta">Alta</option>
                                    <option value="Urgente">Urgente</option>
                                    <option value="Crítica">Crítica</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label for="data_abertura" class="form-label">Data de Abertura</label>
                                <input type="text" class="form-control" placeholder="Data de Abertura" id="data_abertura" name="data_abertura" v-model="data_abertura" v-mask="'##/##/####'">
                            </div>
                            <div class="col-4">
                                <label for="data_fechamento" class="form-label">Data de Fechamento</label>
                                <input type="text" class="form-control" placeholder="Data de Abertura" id="data_fechamento" name="data_fechamento" v-model="data_fechamento" v-mask="'##/##/####'">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <label for="descricao" class="form-label">Descrição</label>
                                <textarea class="form-control" name="descricao" id="descricao" placeholder="Descrição" rows="5" v-model="descricao"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" v-if="transacaoStatus != 'sucesso'">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-success" @click="salvar()">Criar Agendamento</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="visualizar-tarefa">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title ">Visualizar Tarefa</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="assunto" class="form-label ">Assunto</label>
                            <input type="text" class="form-control" placeholder="Assunto" id="assunto" name="assunto" disabled :value="$store.state.item.assunto">
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-4">
                            <label for="prioridade" class="form-label ">Prioridade</label>
                            <select class="form-select" name="prioridade" id="prioridade" disabled :value="$store.state.item.prioridade">
                                <option value="">Selecione</option>
                                <option value="Miníma">Miníma</option>
                                <option value="Baixa">Baixa</option>
                                <option value="Normal">Normal</option>
                                <option value="Alta">Alta</option>
                                <option value="Urgente">Urgente</option>
                                <option value="Crítica">Crítica</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="data_abertura" class="form-label">Data de Abertura</label>
                            <input type="text" class="form-control" placeholder="Data de Abertura" id="data_abertura" name="data_abertura" disabled :value="$store.state.item.data_abertura" v-mask="'##/##/####'">
                        </div>
                        <div class="col-4">
                            <label for="data_fechamento" class="form-label">Data de Fechamento</label>
                            <input type="text" class="form-control" placeholder="Data de Abertura" id="data_fechamento" name="data_fechamento" disabled :value="$store.state.item.data_fechamento" v-mask="'##/##/####'">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" name="descricao" id="descricao" placeholder="Descrição" rows="5" disabled :value="$store.state.item.descricao"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editar-tarefa">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title ">Editar Tarefa</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <alert tipo="success" titulo="Edição realizada" :detalhes="$store.state.transacao.mensagem" v-if="$store.state.transacao.status == 'sucesso'"></alert>
                    <alert tipo="danger" titulo="Erro ao editar" :detalhes="$store.state.transacao.mensagem" v-if="$store.state.transacao.status == 'erro'"></alert>
                    <div v-if="$store.state.transacao.status != 'sucesso'">
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="assunto" class="form-label ">Assunto</label>
                                <input type="text" class="form-control" placeholder="Assunto" id="assunto" name="assunto" v-model="$store.state.item.assunto">
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-4">
                                <label for="prioridade" class="form-label ">Prioridade</label>
                                <select class="form-select" name="prioridade" id="prioridade" v-model="$store.state.item.prioridade">
                                    <option value="">Selecione</option>
                                    <option value="Miníma">Miníma</option>
                                    <option value="Baixa">Baixa</option>
                                    <option value="Normal">Normal</option>
                                    <option value="Alta">Alta</option>
                                    <option value="Urgente">Urgente</option>
                                    <option value="Crítica">Crítica</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label for="data_abertura" class="form-label">Data de Abertura</label>
                                <input type="text" class="form-control" placeholder="Data de Abertura" id="data_abertura" name="data_abertura" v-model="$store.state.item.data_abertura" v-mask="'##/##/####'">
                            </div>
                            <div class="col-4">
                                <label for="data_fechamento" class="form-label">Data de Fechamento</label>
                                <input type="text" class="form-control" placeholder="Data de Abertura" id="data_fechamento" name="data_fechamento" v-model="$store.state.item.data_fechamento" v-mask="'##/##/####'">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <label for="descricao" class="form-label">Descrição</label>
                                <textarea class="form-control" name="descricao" id="descricao" placeholder="Descrição" rows="5" v-model="$store.state.item.descricao"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" v-if="$store.state.transacao.status != 'sucesso'">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary" @click="editar()">Editar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="remover-tarefa">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title ">Remover Tarefa</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <alert tipo="success" titulo="Registro removido" :detalhes="$store.state.transacao.mensagem" v-if="$store.state.transacao.status == 'sucesso'"></alert>
                    <alert tipo="danger" titulo="Erro ao remover" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert>
                    <div v-if="$store.state.transacao.status != 'sucesso'">
                        <p>Tem certeza que deseja remover o registro?</p>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="assunto" class="form-label ">Assunto</label>
                                <input type="text" class="form-control" placeholder="Assunto" id="assunto" name="assunto" disabled :value="$store.state.item.assunto">
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-4">
                                <label for="prioridade" class="form-label ">Prioridade</label>
                                <select class="form-select" name="prioridade" id="prioridade" disabled :value="$store.state.item.prioridade">
                                    <option value="">Selecione</option>
                                    <option value="Miníma">Miníma</option>
                                    <option value="Baixa">Baixa</option>
                                    <option value="Normal">Normal</option>
                                    <option value="Alta">Alta</option>
                                    <option value="Urgente">Urgente</option>
                                    <option value="Crítica">Crítica</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label for="data_abertura" class="form-label">Data de Abertura</label>
                                <input type="text" class="form-control" placeholder="Data de Abertura" id="data_abertura" name="data_abertura" disabled :value="$store.state.item.data_abertura" v-mask="'##/##/####'">
                            </div>
                            <div class="col-4">
                                <label for="data_fechamento" class="form-label">Data de Fechamento</label>
                                <input type="text" class="form-control" placeholder="Data de Abertura" id="data_fechamento" name="data_fechamento" disabled :value="$store.state.item.data_fechamento" v-mask="'##/##/####'">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <label for="descricao" class="form-label">Descrição</label>
                                <textarea class="form-control" name="descricao" id="descricao" placeholder="Descrição" rows="5" disabled :value="$store.state.item.descricao"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" v-if="$store.state.transacao.status != 'sucesso'">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-danger" @click="remover()">Remover</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import DataTable from 'datatables.net-bs5';
    import $ from 'jquery';
    import 'datatables.net-buttons/js/buttons.html5';
    import 'datatables.net-buttons/js/buttons.print';
    import 'datatables.net-buttons/js/dataTables.buttons';
    export default {
        data() {
            return {
                user_id: '',
                prioridade: '',
                assunto: '',
                descricao: '',
                data_abertura: '',
                data_fechamento: '',
                tarefas: [],
                transacaoStatus: '',
                transacaoDetalhes: {},
                table: ''
            };
        },
        props: ['auth'],
        methods: {
            limparStatus() {
                this.user_id = ''
                this.prioridade = ''
                this.assunto = ''
                this.descricao = ''
                this.data_abertura = ''
                this.data_fechamento = ''
                this.transacaoStatus = ''
                this.transacaoDetalhes = {}
            },
            carregarLista() {
                if (this.auth.admin == 0) {
                    axios.get('http://localhost:8000/api/tarefa?filtro=user_id:=:'+ this.auth.id)
                    .then(response => {
                        this.tarefas = response.data;
                        this.table = $('#tarefa-table').DataTable({
                            dom: '<"row d-flex align-items-end justify-content-between gap-2 my-2"<"col-md-2"l><"col-md-8"f><"col-md-1"B>>rt<"d-flex flex-column gap-1"<"d-flex justify-content-center"i><"d-flex justify-content-center"p>>',
                            createdRow: function( nRow, aData ) {
                                $(nRow).attr('handle', aData["HANDLE"]);
                            },
                            language: {
                                lengthMenu: "Resultados p/ página _MENU_",
                                url: 'https://cdn.datatables.net/plug-ins/2.0.3/i18n/pt-BR.json',
                            },
                            buttons: [
                                {
                                    extend: 'csv',
                                    className: 'btn btn-success',
                                    charset: 'utf-8',
                                    fieldSeparator: ';',
                                    fieldBoundary: '',
                                    bom: true,
                                    filename: 'Tarefas',
                                    exportOptions: {
                                        columns: ':not(.no-print)'
                                    }
                                }
                            ],
                            data: [],
                            columns: [
                                { data: 'id' },
                                { data: 'data_abertura' },
                                { data: 'assunto' },
                                { data: 'prioridade' },
                                { data: 'data_fechamento' },
                                {
                                    orderable: false,
                                    data: null,
                                    defaultContent: 
                                    `<div class="d-flex justify-content-center gap-1">
                                        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#visualizar-tarefa" @click="setStore(data)">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editar-tarefa" @click="setStore(data)">
                                            <i class="fa-solid fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#remover-tarefa" @click="setStore(data)">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>`,
                                    className: 'no-print'
                                },
                                { data: 'descricao', className: 'print-only', visible: false }
                            ]
                        });
                        this.table.on('click', 'button', (e) => {
                            let rowData = this.table.row($(e.target).closest('tr')).data();
                            if (rowData) {
                                this.setStore(rowData);
                            }
                        });
                        this.table.clear().rows.add(this.tarefas).draw();
                        
                    })
                    .catch(error => {
                        console.error('Ocorreu um erro:', error);
                    })
                } else {
                    axios.get('http://localhost:8000/api/tarefa')
                    .then(response => {
                        this.tarefas = response.data;
                        this.table = $('#tarefa-table').DataTable({
                            dom: '<"row d-flex align-items-end justify-content-between gap-2 my-2"<"col-md-2"l><"col-md-8"f><"col-md-1"B>>rt<"d-flex flex-column gap-1"<"d-flex justify-content-center"i><"d-flex justify-content-center"p>>',
                            createdRow: function( nRow, aData ) {
                                $(nRow).attr('handle', aData["HANDLE"]);
                            },
                            language: {
                                lengthMenu: "Resultados p/ página _MENU_",
                                url: 'https://cdn.datatables.net/plug-ins/2.0.3/i18n/pt-BR.json',
                            },
                            buttons: [
                                {
                                    extend: 'csv',
                                    className: 'btn btn-success',
                                    charset: 'utf-8',
                                    fieldSeparator: ';',
                                    fieldBoundary: '',
                                    bom: true,
                                    filename: 'Tarefas',
                                    exportOptions: {
                                        columns: ':not(.no-print)'
                                    }
                                }
                            ],
                            data: [],
                            columns: [
                                { data: 'id' },
                                { data: 'user.name' },
                                { data: 'data_abertura' },
                                { data: 'assunto' },
                                { data: 'prioridade' },
                                { data: 'data_fechamento' },
                                {
                                    orderable: false,
                                    data: null,
                                    defaultContent: 
                                    `<div class="d-flex justify-content-center gap-1">
                                        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#visualizar-tarefa" @click="setStore(data)">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editar-tarefa" @click="setStore(data)">
                                            <i class="fa-solid fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#remover-tarefa" @click="setStore(data)">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>`,
                                    className: 'no-print'
                                },
                                { data: 'descricao', className: 'print-only', visible: false }
                            ]
                        });
                        this.table.on('click', 'button', (e) => {
                            let rowData = this.table.row($(e.target).closest('tr')).data();
                            if (rowData) {
                                this.setStore(rowData);
                            }
                        });
                        this.table.clear().rows.add(this.tarefas).draw();
                        
                    })
                    .catch(error => {
                        console.error('Ocorreu um erro:', error);
                    })
                }
                
            },
            salvar() {
                let formData = new FormData();
                formData.append('user_id', this.auth.id);
                formData.append('prioridade', this.prioridade);
                formData.append('assunto', this.assunto);
                formData.append('descricao', this.descricao);
                formData.append('data_abertura', this.data_abertura);
                formData.append('data_fechamento', this.data_fechamento);

                let config = {
                    headers: {
                        'Accept': 'application/json',
                    }
                }
                axios.post('http://localhost:8000/api/tarefa', formData, config)
                    .then(response => {
                        this.transacaoStatus = 'sucesso'
                        this.transacaoDetalhes = 'Tarefa cadastrada com sucesso'
                        this.carregarLista()
                    })
                    .catch(errors => {
                        this.transacaoStatus = 'erro'
                        this.transacaoDetalhes = errors
                        console.log(errors)
                    })
            },
            editar() {
                let url = 'http://localhost:8000/api/tarefa/' + this.$store.state.item.id

                let formData = new FormData();
                formData.append('_method', 'patch')
                formData.append('user_id', this.$store.state.item.user_id);
                formData.append('prioridade', this.$store.state.item.prioridade);
                formData.append('assunto', this.$store.state.item.assunto);
                formData.append('descricao', this.$store.state.item.descricao);
                formData.append('data_abertura', this.$store.state.item.data_abertura);
                formData.append('data_fechamento', this.$store.state.item.data_fechamento);
                
                let config = {
                    headers: {
                        'Accept': 'application/json',
                    }
                }

                axios.post(url, formData, config)
                    .then(response => {
                        this.$store.state.transacao.status = 'sucesso'
                        this.$store.state.transacao.mensagem = 'Edição realizada com sucesso'
                        this.carregarLista()
                        console.log(response)
                    })
                    .catch(errors => {
                        this.$store.state.transacao.status = 'erro'
                        this.$store.state.transacao.mensagem = errors
                    })
            },
            remover() {
                let formData = new FormData();
                formData.append('_method', 'delete')

                let url = 'http://localhost:8000/api/tarefa/' + this.$store.state.item.id

                axios.post(url, formData)
                    .then(response => {                        
                        this.$store.state.transacao.status = 'sucesso'
                        this.$store.state.transacao.mensagem = 'Registro removido com sucesso'
                        this.carregarLista()
                    })
                    .catch(errors => {
                        this.$store.state.transacao.status = 'erro'
                        this.$store.state.transacao.mensagem = errors
                    })
            },
            setStore(dados) {
                this.$store.state.item = dados
                this.$store.state.transacao.status = ''
                this.$store.state.transacao.mensagem = ''
            }
        },
        mounted() {
            this.carregarLista();
        }
    }
</script>