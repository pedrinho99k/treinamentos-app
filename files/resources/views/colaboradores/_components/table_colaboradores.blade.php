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
        <form class="sub-header" id="search-form" action="{{ route('colaboradores.index') }}">
            <div class="clearable-input">
                <input id="filtro_nome" name="nome" value="{{ request('nome') }}" class="form-input search-input" type="text" placeholder="Filtrar por nome">
                <span class="clear-icon">&#10006;</span>
            </div>
            <div class="clearable-input">
                <input id="setor" name="setor" value="{{ request('setor') }}" class="form-input search-input" type="text" placeholder="Filtrar por setor">
                <span class="clear-icon">&#10006;</span>
            </div>
            <div class="clearable-input">
                <input id="cargo" name="cargo" value="{{ request('cargo') }}" class="form-input search-input" type="text" placeholder="Filtrar por cargo">
                <span class="clear-icon">&#10006;</span>
            </div>
            <button class="button button-transparent botao-filtrar-colaboradores">
                <i class='bx bx-search'></i>
                <span class="text">{{ __('Search') }}</span>
            </button>
        </form>
    </div>
    <table class="tabela-registros-colaboradores">
        <thead>
            <tr>
                <th class="sortable sortable-colaboradores">Id</th>
                <th class="sortable sortable-colaboradores">Nome Colaborador</th>
                <th class="sortable sortable-colaboradores">eSocial</th>
                <th class="sortable sortable-colaboradores">Setor</th>
                <th class="sortable sortable-colaboradores">Cargo</th>
                <th class="sortable sortable-colaboradores">Ativo</th>
                <th class="sortable sortable-colaboradores">Opções</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($colaboradores as $colaborador)
                <tr>
                    <td>{{ $colaborador->id }}</td>
                    <td>{{ $colaborador->colaborador_nome }}</td>
                    <td>{{ $colaborador->colaborador_codigo_esocial }}</td>
                    <td>{{ $colaborador->setor->setor_descricao }}</td>
                    <td>{{ $colaborador->cargo->cargo_descricao }}</td>
                    <td>{{ $colaborador->colaborador_ativo }}</td>
                    <td class="td-option"><button class="button button-transparent"
                            onclick="window.location.href ='{{ route('colaboradores.show', $colaborador->id) }}'"><i
                                class='bx bx-edit-alt'></i><span class="text">{{ __('Update') }}</span></button>

                        <form
                            action="{{ route('colaboradores.destroy', ['id' => $colaborador->id, 'colaborador_ativo' => $colaborador->colaborador_ativo]) }}"
                            method="POST">
                            @csrf
                            @method('delete')
                            @if ($colaborador->colaborador_ativo === 'SIM')
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
            <tr class="sem-registro-colaboradores" style="display: none;">
                <td colspan="5" style="width: 100%; text-align: center;">Nenhum registro encontrado.</td>
            </tr>
        </tbody>
    </table>
    <!-- Links de Paginação -->
    <div>
        {{ $colaboradores->appends(request()->input())->links() }}
    </div>
</div>
<script>
    $(document).ready(function() {
        // Função de pesquisa
        function realizarPesquisa() {
            var filtro = $(".search-input").val().toLowerCase();

            // Oculta a linha de "Nenhum registro encontrado" por padrão
            $(".sem-registros-colaboradores").hide();

            var registrosEncontrados = false;

            // Itera pelas linhas da tabela, exceto pelo cabeçalho
            $(".tabela-registros-colaboradores tbody tr").each(function() {
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
                $(".sem-registro-colaboradores").show();
            }
        }

        // Pesquisa
        $(".botao-filtrar-colaboradores").click(function() {
            realizarPesquisa();
        });

        // Limpa o valor do campo quando o ícone X é clicado
        $(".clear-icon").hide();
        $(".clear-icon").click(function() {

            $(this).prev("input").val("");
            $(this).hide();
            $(".botao-filtrar-colaboradores").trigger('click');
        });

        // Mostra ou esconde o ícone de limpar com base no conteúdo do campo
        $(".search-input").on("input", function() {

            var inputValue = $(this).val();

            $(this).next(".clear-icon").toggle(inputValue.length > 0);
        });


        // Função de ordenação
        function realizarOrdenacao(colIndex, order) {
            var $tbody = $(".tabela-registros-colaboradores tbody");
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
            $(".sortable-colaboradores").removeClass("asc desc");
            $(".sortable-colaboradores:eq(" + colIndex + ")").addClass(order);
        }


        // Ordenação
        $(".sortable-colaboradores").click(function() {
            var colIndex = $(this).index();
            var order = $(this).hasClass("asc") ? "desc" : "asc";
            realizarOrdenacao(colIndex, order);
        });

        // Função de pesquisar com Enter
        var searchInputs = document.querySelectorAll('.search-input');

        searchInputs.forEach(function(input) {
            input.addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    document.getElementById('search-form').submit();
                }
            })
        })
    });
</script>
