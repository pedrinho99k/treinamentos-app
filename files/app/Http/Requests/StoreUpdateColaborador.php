<?php

namespace App\Http\Requests;

use App\Models\Colaborador;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateColaborador extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'colaborador_nome' => [
                'required',       //É um campo requerido
                'min:10',          //Tem que conter no minimo 3 caracteres
                'max:255'        //Não pode conter mais de 255 caracteres
            ],

            'colaborador_codigo_esocial' => [
                'nullable', // Permite que o campo seja nulo
                Rule::unique('colaboradores', 'colaborador_codigo_esocial')
                    ->ignore($this->id, 'id') // Ignora o registro atual ao atualizar
            ],

            'colaborador_cargo_id' => [
                'required',      //É um campo requerido
            ],

            'colaborador_setor_id' => [
                'required',      //É um campo requerido
            ],

            'colaborador_ativo' => [
                'required',
                'min:3',
                'max:3'
            ]
        ];
        /*if ($this->method() === 'PUT') { //Se caso for um metódo do tipo PUT que é o method de UPDATE
            $rules['colaborador_nome'] = [
                'required',
                'min:3',
                'max:255',
            ];

            $rules['colaborador_codigo_esocial'] = [
                Rule::unique('colaboradores')->ignore($this->id)//Ele é de descrição única porém ignora quando o id for o mesmo do objeto em atualização
            ];

            $rules['colaborador_codigo_secundario'] = [
                Rule::unique('colaboradores')->ignore($this->id)->ignore('') //Ele é de descrição única porém ignora quando o id for o mesmo do objeto em atualização
            ];
        }*/

        return $rules;
    }
}
