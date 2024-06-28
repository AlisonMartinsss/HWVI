<template>
    <div class="container">
        <section id="tarefa">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Inicial</li>
                    <li class="breadcrumb-item active" aria-current="page">Usuários</li>
                </ol>
            </nav>
            <div class="content">
                <div class="card mb-4">
                    <div class="card-header">Usuários</div>
                    <div class="card-body mt-0 pt-0">
                        <div class="row pt-2">
                            <div class="col table-responsive">
                                <table id="user-table" class="table table-striped text-center table-bordered table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Nome</th>
                                            <th>E-mail</th>
                                            <th>Admin</th>
                                            <th>Criado</th>
                                            <th class="no-print">Opções</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer clearfix">
                        <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#criar-user" @click="limparStatus()">Criar Usuário</button>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="modal fade" id="criar-user">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title ">Criar Usuário</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <alert tipo="success" titulo="Cadastro realizado" :detalhes="transacaoDetalhes" v-if="transacaoStatus == 'sucesso'"></alert>
                    <alert tipo="danger" titulo="Erro ao cadastrar" :detalhes="transacaoDetalhes" v-if="transacaoStatus == 'erro'"></alert>
                    <div v-if="transacaoStatus != 'sucesso'">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" for="name">Nome</label>
                                <input id="name" placeholder="Digite o nome" type="text" class="form-control" name="name" v-model="name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="email">E-mail</label>
                                <input id="email" placeholder="Digite o e-mail" type="email" class="form-control" name="email" v-model="email">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="form-label" for="password">Senha</label>
                                <input id="password" placeholder="Digite a senha" type="password" class="form-control" name="password" v-model="password">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="admin">Função</label>
                                <select class="form-select" name="admin" id="admin" v-model="admin">
                                    <option value="">Selecione a função</option>
                                    <option value="0">Usuário</option>
                                    <option value="1">Admin</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" v-if="transacaoStatus != 'sucesso'">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-success" @click="salvar()">Criar Usuário</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="visualizar-user">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title ">Visualizar Usuário</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control" placeholder="Nome" id="name" name="name" disabled :value="$store.state.item.name">
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-12">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" placeholder="E-mail" id="email" name="email" disabled :value="$store.state.item.email">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <label for="admin" class="form-label">Nome</label>
                            <select class="form-select" name="admin" id="admin" disabled :value="$store.state.item.admin">
                                <option value="">Selecione a função</option>
                                <option value="0">Usuário</option>
                                <option value="1">Admin</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editar-user">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title ">Editar Usuário</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <alert tipo="success" titulo="Edição realizada" :detalhes="$store.state.transacao.mensagem" v-if="$store.state.transacao.status == 'sucesso'"></alert>
                    <alert tipo="danger" titulo="Erro ao editar" :detalhes="$store.state.transacao.mensagem" v-if="$store.state.transacao.status == 'erro'"></alert>
                    <div v-if="$store.state.transacao.status != 'sucesso'">
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="name" class="form-label">Nome</label>
                                <input type="text" class="form-control" placeholder="Nome" id="name" name="name" v-model="$store.state.item.name">
                            </div>
                            <div class="col-6">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" placeholder="E-mail" id="email" name="email" v-model="$store.state.item.email">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <label for="password" class="form-label">Senha</label>
                                <input type="password" class="form-control" placeholder="Senha" id="password" name="password" v-model="$store.state.item.password">
                            </div>
                            <div class="col-6">
                                <label for="admin" class="form-label">Nome</label>
                                <select class="form-select" name="admin" id="admin" v-model="$store.state.item.admin">
                                    <option value="">Selecione a função</option>
                                    <option value="0">Usuário</option>
                                    <option value="1">Admin</option>
                                </select>
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
    <div class="modal fade" id="remover-user">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title ">Remover Usuário</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <alert tipo="success" titulo="Registro removido" :detalhes="$store.state.transacao.mensagem" v-if="$store.state.transacao.status == 'sucesso'"></alert>
                    <alert tipo="danger" titulo="Erro ao remover" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert>
                    <div v-if="$store.state.transacao.status != 'sucesso'">
                        <p v-if="$store.state.item.id != auth.id">Tem certeza que deseja remover o registro?</p>
                        <p v-else>Você não pode remover o seu próprio usuário!</p>
                        <div class="row mb-3">
                        <div class="col-12">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control" placeholder="Nome" id="name" name="name" disabled :value="$store.state.item.name">
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-12">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" placeholder="E-mail" id="email" name="email" disabled :value="$store.state.item.email">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <label for="admin" class="form-label">Nome</label>
                            <select class="form-select" name="admin" id="admin" disabled :value="$store.state.item.admin">
                                <option value="">Selecione a função</option>
                                <option value="0">Usuário</option>
                                <option value="1">Admin</option>
                            </select>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="modal-footer" v-if="$store.state.transacao.status != 'sucesso' && $store.state.item.id != auth.id">
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
                name: '',
                email: '',
                password: '',
                password: '',
                admin: '',
                users: [],
                transacaoStatus: '',
                transacaoDetalhes: {},
                table: ''
            };
        },
        props: ['auth'],
        methods: {
            limparStatus() {
                this.name = ''
                this.email = ''
                this.password = ''
                this.admin = ''
                this.transacaoStatus = ''
                this.transacaoDetalhes = {}
            },
            carregarLista() {
                axios.get('/api/user')
                    .then(response => {
                        this.users = response.data;

                        if ($.fn.DataTable.isDataTable('#user-table')) {
                            $('#user-table').DataTable().clear().destroy();
                        }

                        this.table = $('#user-table').DataTable({
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
                                    filename: 'Usuários',
                                    exportOptions: {
                                        columns: ':not(.no-print)'
                                    }
                                }
                            ],
                            data: this.users,
                            columns: [
                                { data: 'id' },
                                { data: 'name' },
                                { data: 'email' },
                                { 
                                    data: 'admin',
                                    render: function(data, type, row) {
                                        return data ? 'Admin' : 'Usuário';
                                    }
                                },
                                { 
                                    data: 'created_at',
                                    render: function(data, type, row) {
                                        if (data) {
                                            const date = new Date(data);
                                            const day = String(date.getDate()).padStart(2, '0');
                                            const month = String(date.getMonth() + 1).padStart(2, '0');
                                            const year = date.getFullYear();
                                            const hours = String(date.getHours()).padStart(2, '0');
                                            const minutes = String(date.getMinutes()).padStart(2, '0');
                                            return `${day}/${month}/${year} ${hours}:${minutes}`;
                                        }
                                        return data;
                                    }
                                },
                                {
                                    orderable: false,
                                    data: null,
                                    defaultContent: 
                                    `<div class="d-flex justify-content-center gap-1">
                                        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#visualizar-user" @click="setStore(data)">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editar-user" @click="setStore(data)">
                                            <i class="fa-solid fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#remover-user" @click="setStore(data)">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>`,
                                    className: 'no-print'
                                }
                            ],
                            initComplete: function() {
                                var label = $('<label>Exportar:</label>');
                                $('.dt-buttons').prepend(label);
                                $('.dt-buttons button').wrapAll('<div class="d-flex gap-1"></div>');
                            }
                        });

                        this.table.on('click', 'button', (e) => {
                            let rowData = this.table.row($(e.target).closest('tr')).data();
                            if (rowData) {
                                this.setStore(rowData);
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Ocorreu um erro:', error);
                    });
            },
            salvar() {
                let url = '/api/user';

                let formData = new FormData();
                formData.append('name', this.name);
                formData.append('email', this.email);
                formData.append('admin', this.admin);
                formData.append('password', this.password);

                let config = {
                    headers: {
                        'Accept': 'application/json',
                    }
                }
                axios.post(url, formData, config)
                    .then(response => {
                        this.transacaoStatus = 'sucesso'
                        this.transacaoDetalhes = 'Usuário cadastrado com sucesso'
                        this.carregarLista()
                    })
                    .catch(errors => {
                        this.transacaoStatus = 'erro'
                        this.transacaoDetalhes = errors
                    })
            },
            editar() {
                let url = '/api/user/' + this.$store.state.item.id

                let formData = new FormData();
                formData.append('_method', 'patch')
                formData.append('name', this.$store.state.item.name);
                formData.append('email', this.$store.state.item.email);
                formData.append('admin', this.$store.state.item.admin);
                formData.append('password', this.$store.state.item.password);
                
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
                        console.log(errors)
                    })
            },
            remover() {
                let formData = new FormData();
                formData.append('_method', 'delete')

                let url_tarefas = '/api/tarefa?filtro=user_id:=:'+ this.$store.state.item.id
                let url = '/api/user/' + this.$store.state.item.id

                axios.post(url, formData)
                    .then(response => {                        
                        this.$store.state.transacao.status = 'sucesso'
                        this.$store.state.transacao.mensagem = 'Registro removido com sucesso'
                        this.carregarLista()
                    })
                    .catch(errors => {
                        this.$store.state.transacao.status = 'erro'
                        this.$store.state.transacao.mensagem = errors
                        console.log(errors)
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
