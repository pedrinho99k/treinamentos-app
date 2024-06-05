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
            <h3>{{ __('Registered Positions') }}</h3>
            <i class='bx bxs-user-badge'></i>
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
            @foreach ($cargos as $cargo)
                <tr>
                    <td>{{ $cargo->id }}</td>
                    <td>{{ $cargo->cargo_descricao }}</td>
                    <td>{{ $cargo->cargo_ativo }}</td>
                    <td class="td-option"><button class="button button-transparent"
                            onclick="window.location.href ='{{ route('cargos.show', $cargo->id) }}'"><i
                                class='bx bx-edit-alt'></i><span class="text">{{ __('Update') }}</span></button>

                        <form action="{{ route('cargos.destroy', $cargo->id) }}" method="POST">
                            @csrf
                            @method('delete')
                            @if($cargo->cargo_ativo === 'SIM')
                                <button type="submit" class="button button-transparent hover-danger"><i
                                    class='bx bx-x'></i><span class="text">{{ __('Disable') }}</span></button>
                            @else
                                <button type="submit" class="button button-transparent hover-danger"><i
                                    class="bx bx-check"></i><span class="text">{{ __('Activate') }}</span></button>
                            @endif
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
