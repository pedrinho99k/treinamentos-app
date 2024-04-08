<?php

namespace App\Http\Requests;

use App\Models\Professor;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateProfessor extends FormRequest
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
            'professor_nome' => [
                'required',       //É um campo requerido
                'min:10',          //Tem que conter no minimo 3 caracteres
                'max:255'        //Não pode conter mais de 255 caracteres
            ],

            'professor_colaborador_id' => [
                Rule::unique('professores') // Não permite duplicar professores internos
            ],

            'professor_ativo' => [
                'required',
                'min:3',
                'max:3'
            ]

        ];
        if ($this->method() === 'PUT') { //Se caso for um metódo do tipo PUT que é o method de UPDATE
            $rules['professor_nome'] = [
                'required',
                'min:3',
                'max:255'
            ];
        }

        return $rules;
    }
}
