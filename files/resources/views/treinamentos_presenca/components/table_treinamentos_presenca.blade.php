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
          <i class='bx bx-message-square-check'></i>
          <h3>{{ $id }} : {{ $treinamento->m_treinamento_descricao}}</h3>
      </div>
  </div>
  {{-- <div class="header">
      <div class="sub-header">
          <div class="clearable-input">
              <input class="form-input filtro-nome-treinamentos" type="text" placeholder="Filtrar por nome">
              <span class="clear-icon">&#10006;</span>
          </div>
          <button class="button button-transparent botao-filtrar-treinamentos">
              <i class='bx bx-search'></i>
              <span class="text">{{ __('Search') }}</span>
          </button>
      </div>
  </div> --}}
  <table class="tabela-registros-presencas">
        <thead>
            <tr>
                    <th class="sortable sortable-treinamentos">Colaborador</th>
                    <th class="sortable sortable-treinamentos">Setor</th>
                    <th class="sortable sortable-treinamentos">Cargo</th>
                    <th class="sortable sortable-treinamentos">Presença</th>
            </tr>
        </thead>
        <tbody>
            <form id="formCheckboxes" method="POST" action="{{ route('treinamento_presenca.update') }}">
                @csrf
                <input type="hidden" name="id" value="{{ $id }}">
                @foreach ($array as $dados)
                    <tr class="alterar-switch select-none">
                        <td>{{ $dados['colaborador_nome'] }}</td>
                        <td>{{ $dados['setor_descricao'] }}</td>
                        <td>{{ $dados['cargo_descricao'] }}</td>
                        <td class="botao-switch">
                            @foreach ($dados['registro_colaboradores'] as $registro)
                            <input id="switch_{{ $registro->id }}" type="checkbox" name="checkboxes[]" value="{{ $dados['id']}}"
                            @if($registro->treinamento_realizado === 'SIM') checked @endif>
                            <label for="switch_{{ $registro->id }}">{{ $registro->treinamento_realizado }}</label>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </form>
            {{-- <tr class="sem-registro-treinamentos" style="display: none;">
                <td colspan="5" style="width: 100%; text-align: center;">Nenhum registro encontrado.</td>
            </tr> --}}
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        // Função de pesquisa
        function realizarPesquisa() {
            var filtro = $(".filtro-nome-treinamentos").val().toLowerCase();

            // Oculta a linha de "Nenhum registro encontrado" por padrão
            $(".sem-registros-treinamentos").hide();

            var registrosEncontrados = false;

            // Itera pelas linhas da tabela, exceto pelo cabeçalho
            $(".tabela-registros-presencas tbody tr").each(function() {
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

    $('.alterar-switch').click(function() {
        var checkbox = $(this).find('input[type="checkbox"]');
        checkbox.prop('checked', !checkbox.prop('checked'));
    });


      // Função de ordenação
      function realizarOrdenacao(colIndex, order) {
          var $tbody = $(".tabela-registros-presencas tbody");
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
    });

</script>
