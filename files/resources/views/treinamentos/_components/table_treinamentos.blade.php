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




            {{-- <form action="{{ route('treinamentos.filtro')}}" method="post">
                @csrf
                <input type="checkbox" name="botao-ativo" >
                <button value="true" name="botao-ativo">teste</button>
            </form> --}}


            {{-- <form id="filtroForm" action="{{ route('treinamentos.filtro') }}" method="POST">
                @csrf
                <div class="botao-switch">
                    <span>Filtrar ativos</span>
                    <input type="checkbox" id="checkboxFiltro" name="checkboxFiltro" value="false" checked>
                    <label for="checkboxFiltro"></label>    
                </div>
            </form> --}}



            {{-- <button value="true" name="botao-ativo">DESATIVAR FILTRO</button> --}}





            {{-- <div class="botao-switch">
                <input type="checkbox" name="filtro-ativo" id="filtro">
                <label for="filtro"></label>
            </div> --}}
            
            
            




            <div class="clearable-input">
                <input class="form-input filtro-nome-treinamentos" type="text" placeholder="Filtrar por nome">
                <span class="clear-icon">&#10006;</span>
            </div>
            <button class="button button-transparent botao-filtrar-treinamentos">
                <i class='bx bx-search'></i>
                <span class="text">{{ __('Search') }}</span>
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
                        <button class="button button-transparent mt-2" onclick="imprimirLista({{ $treinamento->id }},'{{ $treinamento->MatrizTreinamento->m_treinamento_descricao }}','{{ \Carbon\Carbon::parse($treinamento->treinamento_data)->format('d/m/Y') }}','{{ $treinamento->professor->professor_nome }}','{{ $treinamento->treinamento_carga_horaria }}')">
                            <i class='bx bx-printer'></i>
                            <span class="text">Imprimir</span>
                        </button>

                        <button class="button button-transparent mt-2"
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
            <div class="row-y-0">
                <div class="p-2 col-12 border border-dark text-center treinamento_descricao">
                </div>
                <div class="p-1 col-6 border border-dark text-center ">
                    <span>Professor: </span>
                    <span class="treinamento_professor"></span>
                </div>
                <div class="p-1 col-3 border border-dark text-center">
                    <span>Data: </span>
                    <span class="treinamento_data"></span>
                </div>
                <div class="p-1 col-3 border border-dark text-center">
                    <span>Duração: </span>
                    <span class="treinamento_carga_horaria"></span>
                </div>
            </div>
                <table id="tabela" class="bg-white w-100" style="font-size: 10px !important">
                    <thead>
                        <tr>
                            <th class="p-1 border border-dark">Colaborador</th>
                            <th class="p-1 border border-dark">Cargo</th>
                            <th class="p-1 border border-dark">Setor</th>
                            <th class="p-1 border border-dark">Assinatura</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            
        </div>
    </div>
</div>
<script>
    // Event listener para o botão de impressão
    function imprimirLista(treinamento_id,treinamento_descricao,treinamento_data,treinamento_professor,treinamento_carga_horaria) {
        $(".treinamento_descricao").text(treinamento_descricao);
        $(".treinamento_data").text(treinamento_data);
        $(".treinamento_professor").text(treinamento_professor);
        $(".treinamento_carga_horaria").text(treinamento_carga_horaria);
        carregarColaboradores(treinamento_id);
    }
 
    //Função de imprimir lista de presença

    // Função para carregar os colaboradores via AJAX
    function carregarColaboradores(treinamento_id) {
        $.ajax({
            url: "{{ route('lista_colaboradores_treinamento') }}",
            type: "GET",
            data: {
                treinamento_id
            },
            dataType: "json",
            success: function(colaboradores) {
                console.log(colaboradores);
                exibirColaboradores(colaboradores);
                imprimirTabela();
            },
            error: function() {
                console.error("Erro ao carregar colaboradores");
            }
        });
    }

    // Função para exibir os colaboradores na tabela
    function exibirColaboradores(colaboradores) {
        const colaboradoresTable = $("#tabela tbody");
        colaboradoresTable.empty();

        $.each(colaboradores, function(index, colaborador) {
            const row = $(`<tr>`);
            row.html(`
                <td class="border border-dark my-8 text-xs w-10">${colaborador.colaborador_nome}</td>
                <td class="border border-dark my-8 text-xs w-10">${colaborador.cargo_descricao}</td>
                <td class="border border-dark my-8 text-xs w-10">${colaborador.setor_descricao}</td>
                <td class="border border-dark my-8 text-xs w-25"></td>
            `);
            colaboradoresTable.append(row);
        });
    }

    // Função para imprimir somente a tabela
    function imprimirTabela() {
        const tabelaParaImprimir = document.getElementById("colaboradoresTable");
        // Obtém a largura e a altura da tela do usuário
        const largura = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
        const altura = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
        // Abre a tela do impressão
        const janelaImprimir = window.open('', '', `width=${largura},height=${altura}`);

        janelaImprimir.document.open();
        janelaImprimir.document.write(
            `<html>
                <head>
                <link rel="stylesheet" href="{{ asset('css/style.css') }}">
                <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
                <style>
                    /* Estilos para impressão */
                    body {
                        font-size: 10px; /* Tamanho da fonte */
                        font-weight: bold; /* Negrito */
                    }
                </style>
                <title>Imprimir Tabela</title>
                </head>
                <body>`
        );
        janelaImprimir.document.write(tabelaParaImprimir.outerHTML);
        janelaImprimir.document.write('</body></html>');
        janelaImprimir.document.close();
        janelaImprimir.print();
        janelaImprimir.close();
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

                linha.find("td:nth-child(2)").each(function() {
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

        // function verificarCheckbox() {
        //     var isChecked = $('#filtro').is(':checked');
        //     var csrfToken = $('meta[name="csrf-token"]').attr('content');

        //     console.log(isChecked);


        // $('.botao-switch').change(function() {
        //     var isChecked = $(this).is(':checked');

        //     console.log(isChecked);

        //     $.ajax({
        //         url: '{{ route("treinamentos.filtro") }}',
        //         type: 'POST',
        //         data: {
        //             isChecked: isChecked,
        //             _token: '{{ csrf_token() }}'
        //         }
        //         success: function(response) {
        //             console.log(response);
        //         }
        //     })
        // })

        $('#checkboxFiltro').click(function() {
            var checkbox = $('#checkboxFiltro').val();
            console.log(checkbox);
        })

    });
</script>
