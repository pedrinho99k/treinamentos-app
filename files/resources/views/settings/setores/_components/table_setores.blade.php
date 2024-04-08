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
            <i class='bx bx-map'></i>
            <h3>{{ __('Registered Sectors') }}</h3>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Descrição</th>
                <th>Ativo</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($setores as $setor)
                <tr>
                    <td>{{ $setor->id }}</td>
                    <td>{{ $setor->setor_descricao }}</td>
                    <td>{{ $setor->setor_ativo }}</td>
                    <td class="td-option"><button class="button button-transparent"
                            onclick="window.location.href ='{{ route('setores.show', $setor->id) }}'"><i
                                class='bx bx-edit-alt'></i><span class="text">{{ __('Update') }}</span></button>

                        <form action="{{ route('setores.destroy', $setor->id) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="button button-transparent hover-danger"><i
                                    class='bx bx-x'></i><span class="text">{{ __('Delete') }}</span></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
