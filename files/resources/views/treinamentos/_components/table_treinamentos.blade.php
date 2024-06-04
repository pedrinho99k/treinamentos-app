<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    var check
</script>
<div class="orders orders-grande">
    @if (session('mensagem'))
        <h6 class="msg-error">{{ session('mensagem') }}</h6>
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <h6 class="msg-error">{{ $error }}</h6>
        @endforeach
    @endif
    <div class="header">
        <div class="sub-header">
            <button class="button button-transparent add-new">
                <i class='bx bx-plus'></i>
                <span class="text">{{ __('Add New') }}</span>
            </button>
        </div>
        <div class="sub-header">
            <i class='bx bx-book-bookmark'></i>
            <h3>{{ __('Conducted trainings') }}</h3>
        </div>
        <div class="sub-header">

            <form action="{{ route('treinamentos.index') }}" method="POST">
                @csrf
                @if ($valor === "false")
                    <button class="button button-transparent" name="valor" value="true">MOSTRAR ATIVOS</button>
                @else
                    <button class="button button-transparent" name="valor" value="false">MOSTRAR TODOS</button>
                @endif
            </form>


            <div class="clearable-input">
                <input class="form-input filtro-nome-treinamentos" id="search-input" type="text" placeholder="Filtrar por nome">
                <span class="clear-icon">&#10006;</span>
            </div>
            <button class="button button-transparent botao-filtrar-treinamentos">
                <i class='bx bx-search'></i>
                {{-- <span class="text">{{ __('Search') }}</span> --}}
            </button>
        </div>
    </div>
    <table class="tabela-registros-treinamentos">
        <thead>
            <tr>
                <th class="sortable sortable-treinamentos">Id</th>
                <th class="sortable sortable-treinamentos">Descrição Treinamento</th>
                <th class="sortable sortable-treinamentos">Professor</th>
                <th class="sortable sortable-treinamentos">Data</th>
                <th class="sortable sortable-treinamentos">Tempo</th>
                <th class="sortable sortable-treinamentos">Ativo</th>
                <th class="sortable sortable-treinamentos"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($treinamentos->sortByDesc('id') as $treinamento)
                <tr> 
                    <td>{{ $treinamento->id }}</td>
                    <td>{{ $treinamento->MatrizTreinamento->m_treinamento_descricao }}</td>
                    <td>{{ $treinamento->professor->professor_nome }}</td>
                    <td>{{ \Carbon\Carbon::parse($treinamento->treinamento_data)->format('d/m/Y') }}</td>
                    <td>{{ $treinamento->treinamento_carga_horaria }}</td>
                    <td>{{ $treinamento->treinamento_ativo }}</td>
                    <td class="td-option">
                        <button class="button button-transparent"
                            onclick="window.location.href ='{{ route('treinamentos.show', $treinamento->id) }}'">
                            <i class='bx bx-edit-alt'></i><span class="text">{{ __('Update') }}</span></button>
                        <form
                            action="{{ route('treinamentos.destroy', ['id' => $treinamento->id, 'treinamento_ativo' => $treinamento->treinamento_ativo]) }}"
                            method="POST">
                            @csrf
                            @method('delete')
                            @if ($treinamento->treinamento_ativo === 'SIM')
                                <button type="submit" class="button button-transparent hover-danger">
                                    <i class='bx bx-x'></i><span class="text">{{ __('Disable') }}</span></button>
                            @else
                                <button type="submit" class="button button-transparent">
                                    <i class="bx bx-check"></i>
                                    <span class="text">{{ __('Activate') }}</span>
                                </button>
                            @endif
                        </form>
                        <button class="button button-transparent" onclick="imprimirTabela({{ $treinamento->id }},'{{ $treinamento->MatrizTreinamento->m_treinamento_descricao }}','{{ \Carbon\Carbon::parse($treinamento->treinamento_data)->format('d/m/Y') }}','{{ $treinamento->professor->professor_nome }}','{{ $treinamento->treinamento_carga_horaria }}','{{ $treinamento->treinamento_observacoes}} ')">
                            <i class='bx bx-printer'></i>
                            <span class="text">Imprimir</span>
                        </button>

                        <button class="button button-transparent"
                        onclick="window.location.href ='{{ route('treinamento_presenca.index', $treinamento->id) }}'">
                            <i class="bx bx-clipboard"></i>
                            <span class="text">Presença</span>
                        </button>
                    </td>
                </tr>
            @endforeach
            <tr class="sem-registro-treinamentos" style="display: none;">
                <td colspan="5" style="width: 100%; text-align: center;">Nenhum registro encontrado.</td>
            </tr>
        </tbody>
    </table>


    <div class="d-none">
        <div id="colaboradoresTable">
            <table id="tabela" class="bg-white w-100" style="font-size: 10px !important">
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    // Função para imprimir somente a tabela
    function carregarColaboradores(treinamento_id, callback) {
        $.ajax({
            url: "{{ route('lista_colaboradores_treinamento') }}",
            type: "GET",
            data: { treinamento_id },
            dataType: "json",
            success: function(colaboradores) {
                console.log(colaboradores);
                callback(colaboradores);
            },
            error: function() {
                console.error("Erro ao carregar colaboradores");
            }
        });
    }

    function imprimirTabela(treinamento_id, treinamento_descricao, treinamento_data, treinamento_professor, treinamento_carga_horaria, treinamento_observacoes) {
        // Atualiza os textos do cabeçalho
        $(".treinamento_descricao").text(treinamento_descricao);
        $(".treinamento_data").text(treinamento_data);
        $(".treinamento_professor").text(treinamento_professor);
        $(".treinamento_carga_horaria").text(treinamento_carga_horaria);
        $(".treinamento_observacao").text(treinamento_observacoes);

        carregarColaboradores(treinamento_id, function(colaboradores) {
            // Obtém a largura e a altura da tela do usuário
            const largura = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
            const altura = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;

            // Abre a tela do impressão
            const janelaImprimir = window.open('', '', `width=${largura},height=${altura}`);
            janelaImprimir.document.open();
            janelaImprimir.document.write(`
                <html>
                    <head>
                        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
                        <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
                        <title>Lista de Presença</title>
                        <style>
                            body {
                                font-size: 10px;
                                font-weight: bold;
                            }
                            @media print {
                                .header {
                                    display: table-header-group;
                                }
                                .content {
                                    display: table-row-group;
                                    margin-top: 20cm;
                                }
                                table {
                                    width: 100%;
                                    border-collapse: collapse;
                                }
                                th, td {
                                    border: 1px solid black;
                                    padding: 5px;
                                    text-align: left;
                                }
                            }
                        </style>
                    </head>
                    <body>
                        <div>
                            <table class="bg-white w-100" style="font-size: 10px !important">
                                <thead>
                                    <tr>
                                        <th colspan="4" style="border: none;">
                                            <svg class="text-center" width="50" height="50">
                                                <image href="{{ asset('img/LOGO HR.png') }}" width="50" height="50"/>
                                            </svg>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="p-2 col-12 border border-dark text-center" colspan="4">${treinamento_descricao}</th>
                                    </tr>
                                    <tr>
                                        <th class="p-1 border border-dark text-left" colspan="2">PROFESSOR: ${treinamento_professor}</th>
                                        <th class="p-1 border border-dark text-left">DATA: ${treinamento_data}</th>
                                        <th class="p-1 border border-dark text-left">DURAÇÃO: ${treinamento_carga_horaria}</th>
                                    </tr>
                                    <tr>
                                        <th class="p-1 border border-dark text-left" colspan="4">OBSERVAÇÕES: ${treinamento_observacoes}</th>
                                    </tr>
                                    <tr>
                                        <th class="p-1 border border-dark text-center" colspan="1">COLABORADOR</th>
                                        <th class="p-1 border border-dark text-center" colspan="1">CARGO</th>
                                        <th class="p-1 border border-dark text-center" colspan="1">SETOR</th>
                                        <th class="p-1 border border-dark text-center" colspan="1">ASSINATURA</th>
                                    </tr>
                                </thead>
                                <tbody>
            `);

            // Iteração para adicionar os <td>
            colaboradores.forEach(function(colaborador) {
                janelaImprimir.document.write(`
                    <tr>
                        <td class="p-1 border border-dark">${colaborador.colaborador_nome}</td>
                        <td class="p-1 border border-dark">${colaborador.cargo_descricao}</td>
                        <td class="p-1 border border-dark">${colaborador.setor_descricao}</td>
                        <td class="p-1 border border-dark"></td>
                    </tr>
                `);
            });

            janelaImprimir.document.write(`
                                </tbody>
                            </table>
                        </div>
                    </body>
                </html>
            `);

            janelaImprimir.print();
            janelaImprimir.close();
        });
    }



    $(document).ready(function() {

        // Função de pesquisa
        function realizarPesquisa() {
            var filtro = $(".filtro-nome-treinamentos").val().toLowerCase();

            // Oculta a linha de "Nenhum registro encontrado" por padrão
            $(".sem-registros-treinamentos").hide();

            var registrosEncontrados = false;

            // Itera pelas linhas da tabela, exceto pelo cabeçalho
            $(".tabela-registros-treinamentos tbody tr").each(function() {
                var linha = $(this);
                var encontrou = false;

                linha.find("td:nth-child(1), td:nth-child(2), td:nth-child(3), td:nth-child(4)").each(function() {
                    var conteudoCelula = $(this).text().toLowerCase();

                    if (conteudoCelula.includes(filtro)) {
                        encontrou = true;
                        registrosEncontrados = true;
                        return false; // Sai do loop das células se encontrar correspondência
                    }
                });

                if (encontrou) {
                    linha.show(); // Mostra a linha se encontrar correspondência
                } else {
                    linha.hide(); // Esconde a linha se não encontrar correspondência
                }
            });

            // Mostra a linha de "Nenhum registro encontrado" se nenhum registro for encontrado
            if (!registrosEncontrados) {
                $(".sem-registro-treinamentos").show();
            } else {
                $(".sem-registro-treinamentos").hide();
            }
        }


        // Pesquisa
        $(".botao-filtrar-treinamentos").click(function() {
            realizarPesquisa();
        });


        // Limpa o valor do campo quando o ícone X é clicado
        $(".clear-icon").hide();
        $(".clear-icon").click(function() {

            $(".filtro-nome-treinamentos").val("");
            $(this).hide();
            $(".botao-filtrar-treinamentos").trigger('click');
        });


        // Mostra ou esconde o ícone de limpar com base no conteúdo do campo
        $(".filtro-nome-treinamentos").on("input", function() {
            var inputValue = $(this).val();
            if (inputValue.length > 0) {
                $(".clear-icon").show();
            } else {
                $(".clear-icon").hide();
            }
        });


        // Função de ordenação
        function realizarOrdenacao(colIndex, order) {
            var $tbody = $(".tabela-registros-treinamentos tbody");
            var rows = $tbody.find("tr").toArray();

            rows.sort(function(a, b) {
                var aValue = $(a).find("td").eq(colIndex).text();
                var bValue = $(b).find("td").eq(colIndex).text();

                if (colIndex === 0) {
                    aValue = parseInt(aValue);
                    bValue = parseInt(bValue);
                } else {
                    aValue = aValue.toLowerCase();
                    bValue = bValue.toLowerCase();
                }

                if (aValue < bValue) {
                    return order === "asc" ? -1 : 1;
                } else if (aValue > bValue) {
                    return order === "asc" ? 1 : -1;
                } else {
                    return 0;
                }
            });

            $tbody.empty().append(rows);
            $(".sortable-treinamentos").removeClass("asc desc");
            $(".sortable-treinamentos:eq(" + colIndex + ")").addClass(order);
        }


        // Ordenação
        $(".sortable-treinamentos").click(function() {
            var colIndex = $(this).index();
            var order = $(this).hasClass("asc") ? "desc" : "asc";
            realizarOrdenacao(colIndex, order);
        });

        // Função de pesquisar com o Enter
        document.getElementById('search-input').addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                realizarPesquisa();
            }
        })

        $('#checkboxFiltro').click(function() {
            var checkbox = $('#checkboxFiltro').val();
            console.log(checkbox);
        })

    });
</script>