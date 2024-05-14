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
            <div class="clearable-input">
                <input class="form-input filtro-nome-matriz-treinamentos search-input" type="text" placeholder="Filtrar">
                <span class="clear-icon">&#10006;</span>
            </div>
            <button class="button button-transparent botao-filtrar-matriz-treinamentos">
                <i class='bx bx-search'></i>
                <span class="text">{{ __('Search') }}</span>
            </button>
        </div>
    </div>
    <table class="tabela-registros-matriz-treinamentos">
        <thead>
            <tr>
                <th class="sortable sortable-matriz-treinamentos">Id</th>
                <th class="sortable sortable-matriz-treinamentos">Descrição</th>
                <th class="sortable sortable-matriz-treinamentos">Tempo</th>
                <th class="sortable sortable-matriz-treinamentos">Obrigatório</th>
                <th class="sortable sortable-matriz-treinamentos">Avaliação de Eficácia</th>
                <th class="sortable sortable-matriz-treinamentos">Setor</th>
                <th class="sortable sortable-matriz-treinamentos">Cargos</th>
                <th class="sortable sortable-matriz-treinamentos">Ativo</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($matriz_treinamentos as $matriz_treinamento)
                <tr>
                    <td>{{ $matriz_treinamento->id }}</td>
                    <td>{{ $matriz_treinamento->m_treinamento_descricao }}</td>
                    <td>{{ $matriz_treinamento->m_treinamento_tempo }}</td>
                    <td>
                        @if ($matriz_treinamento->m_treinamento_obrigatorio === null)
                            {{ __('No') }}
                        @else
                            {{ $matriz_treinamento->m_treinamento_obrigatorio }}
                        @endif
                    </td>
                    <td>
                        @if ($matriz_treinamento->m_treinamento_obrigatorio_avaliacao_eficacia === null)
                            {{ __('No') }}
                        @else
                            {{ $matriz_treinamento->m_treinamento_obrigatorio_avaliacao_eficacia }}
                        @endif
                    </td>
                    <td>{{ ($matriz_treinamento->setor->setor_descricao )}}</td>
                    <td class="td-lista">
                        @foreach ($matriz_treinamento->cargos as $matrizTreinamentoCargo)
                           <div>{{ $matrizTreinamentoCargo->cargo->cargo_descricao }}</div>
                        @endforeach
                    </td>
                    <td>{{ $matriz_treinamento->m_treinamento_ativo }}</td>
                    <td class="td-option">
                        <button class="button button-transparent"
                            onclick="window.location.href ='{{ route('matriz_treinamentos.show', $matriz_treinamento->id) }}'">
                            <i class='bx bx-edit-alt'></i><span class="text">{{ __('Update') }}</span></button>
                        <form
                            action="{{ route('matriz_treinamentos.destroy', ['id' => $matriz_treinamento->id, 'matriz_treinamento_ativo' => $matriz_treinamento->m_treinamento_ativo]) }}"
                            method="POST">
                            @csrf
                            @method('delete')
                            @if ($matriz_treinamento->m_treinamento_ativo === 'SIM')
                                <button type="submit" class="mt-2 button button-transparent hover-danger">
                                    <i class='bx bx-x'></i><span class="text">{{ __('Inactivate') }}</span></button>
                            @else
                                <button type="submit" class="button button-transparent">
                                    <i class='bx bx-x'></i><span class="text">{{ __('Activate') }}</span></button>
                            @endif

                        </form>
                    </td>
                </tr>
            @endforeach
            <tr class="sem-registro-matriz-treinamentos" style="display: none;">
                <td colspan="5" style="width: 100%; text-align: center;">Nenhum registro encontrado.</td>
            </tr>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        // Função de pesquisa
        function realizarPesquisa() {
            var filtro = $(".filtro-nome-matriz-treinamentos").val().toLowerCase();

            // Oculta a linha de "Nenhum registro encontrado" por padrão
            $(".sem-registros-matriz-treinamentos").hide();

            var registrosEncontrados = false;

            // Itera pelas linhas da tabela, exceto pelo cabeçalho
            $(".tabela-registros-matriz-treinamentos tbody tr").each(function() {
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
	        $(".sem-registro-matriz-treinamentos").toggle(!registrosEncontrados);
        }

        // Pesquisa
        $(".botao-filtrar-matriz-treinamentos").click(function() {
            realizarPesquisa();
        });

        // Limpa o valor do campo quando o ícone X é clicado
        $(".clear-icon").hide();
        $(".clear-icon").click(function() {

            $(".filtro-nome-matriz-treinamentos").val("");
            $(this).hide();
            $(".botao-filtrar-matriz-treinamentos").trigger('click');
        });

        // Mostra ou esconde o ícone de limpar com base no conteúdo do campo
        $(".filtro-nome-matriz-treinamentos").on("input", function() {

            var inputValue = $(this).val();
            if (inputValue.length > 0) {
                $(".clear-icon").show();
            } else {
                $(".clear-icon").hide();
            }
        });


        // Função de ordenação
        function realizarOrdenacao(colIndex, order) {
            var $tbody = $(".tabela-registros-matriz-treinamentos tbody");
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
            $(".sortable-matriz-treinamentos").removeClass("asc desc");
            $(".sortable-matriz-treinamentos:eq(" + colIndex + ")").addClass(order);
        }


        // Ordenação
        $(".sortable-matriz-treinamentos").click(function() {
            var colIndex = $(this).index();
            var order = $(this).hasClass("asc") ? "desc" : "asc";
            realizarOrdenacao(colIndex, order);
        });


        // Função de pesquisar com Enter
        var searchInputs = document.querySelectorAll('.search-input');

        searchInputs.forEach(function(input) {
            input.addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault;
                    console.log('teste');
                    realizarPesquisa();
                }
            })
        })
    });
</script>
