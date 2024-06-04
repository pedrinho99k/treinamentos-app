<div class="orders">
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
            <i class='bx bx-group'></i>
            <h3>{{ __('Registered Teachers') }}</h3>
        </div>
        <div class="sub-header">
            <div class="clearable-input">
                <input class="form-input filtro-nome-professores" type="text" placeholder="Filtrar por nome">
                <span class="clear-icon">&#10006;</span>
            </div>
            <button class="button button-transparent botao-filtrar-professores">
                <i class='bx bx-search'></i>
                <span class="text">{{ __('Search') }}</span>
            </button>
        </div>
    </div>
    <table class="tabela-registros-professores">
        <thead>
            <tr>
                <th class="sortable sortable-professores">Id</th>
                <th class="sortable sortable-professores">Nome Professor</th>
                <th class="sortable sortable-professores">Interno / Externo</th>
                <th class="sortable sortable-professores">Ativo</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($professores as $professor)
                <tr>
                    <td>{{ $professor->id }}</td>
                    <td>{{ $professor->professor_nome }}</td>
                    <td>
                        @if ($professor->professor_colaborador_id === null)
                            EXTERNO
                        @else
                            INTERNO
                        @endif
                    </td>
                    <td>{{ $professor->professor_ativo }}</td>
                    <td class="td-option">
                        @if ($professor->professor_colaborador_id === null)
                            <button class="button button-transparent"
                                onclick="window.location.href ='{{ route('professores.show', $professor->id) }}'">
                                <i class='bx bx-edit-alt'></i><span class="text">{{ __('Update') }}</span></button>
                        @endif
                        <form
                            action="{{ route('professores.destroy', ['id' => $professor->id, 'professor_ativo' => $professor->professor_ativo]) }}"
                            method="POST">
                            @csrf
                            @method('delete')
                            @if ($professor->professor_ativo === 'SIM')
                                <button type="submit" class="button button-transparent hover-danger">
                                    <i class='bx bx-x'></i><span class="text">{{ __('Disable') }}</span></button>
                            @else
                                <button type="submit" class="button button-transparent">
                                    <i class='bx bx-check'></i><span class="text">{{ __('Activate') }}</span></button>
                            @endif

                        </form>
                    </td>
                </tr>
            @endforeach
            <tr class="sem-registro-professores" style="display: none;">
                <td colspan="5" style="width: 100%; text-align: center;">Nenhum registro encontrado.</td>
            </tr>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        // Função de pesquisa
        function realizarPesquisa() {
            var filtro = $(".filtro-nome-professores").val().toLowerCase();

            // Oculta a linha de "Nenhum registro encontrado" por padrão
            $(".sem-registros-professores").hide();

            var registrosEncontrados = false;

            // Itera pelas linhas da tabela, exceto pelo cabeçalho
            $(".tabela-registros-professores tbody tr").each(function() {
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
                $(".sem-registro-professores").show();
            }
        }

        // Pesquisa
        $(".botao-filtrar-professores").click(function() {
            realizarPesquisa();
        });

        // Limpa o valor do campo quando o ícone X é clicado
        $(".clear-icon").hide();
        $(".clear-icon").click(function() {

            $(".filtro-nome-professores").val("");
            $(this).hide();
            $(".botao-filtrar-professores").trigger('click');
        });

        // Mostra ou esconde o ícone de limpar com base no conteúdo do campo
        $(".filtro-nome-professores").on("input", function() {

            var inputValue = $(this).val();
            if (inputValue.length > 0) {
                $(".clear-icon").show();
            } else {
                $(".clear-icon").hide();
            }
        });


        // Função de ordenação
        function realizarOrdenacao(colIndex, order) {
            var $tbody = $(".tabela-registros-professores tbody");
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
            $(".sortable-professores").removeClass("asc desc");
            $(".sortable-professores:eq(" + colIndex + ")").addClass(order);
        }


        // Ordenação
        $(".sortable-professores").click(function() {
            var colIndex = $(this).index();
            var order = $(this).hasClass("asc") ? "desc" : "asc";
            realizarOrdenacao(colIndex, order);
        });


    });
</script>
