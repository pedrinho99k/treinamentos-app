<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateSetor extends FormRequest
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
            'setor_descricao' => [
                'required',       //É um campo requerido
                'min:3',          //Tem que conter no minimo 3 caracteres
                'max:255',        //Não pode conter mais de 255 caracteres
                'unique:setores'  //É de descrição única,ou seja, não pode conter nenhum outro setor com a mesma descrição, para não haver duplicidade
            ],
            'setor_ativo' => [
                'required',
                'min:3',
                'max:3'
            ]
        ];
        if ($this->method() === 'PUT') { //Se caso for um metódo do tipo PUT que é o method de UPDATE
            $rules['setor_descricao'] = [
                'required',
                'min:3',
                'max:255',
                Rule::unique('setores')->ignore($this->id) //Ele é de descrição única porém ignora quando o id for o mesmo do objeto em atualização
            ];
        }

        return $rules;
    }
}
