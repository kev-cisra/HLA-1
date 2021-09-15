<?php

namespace App\Http\Requests\Compras\Requisiciones;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RequisicionesRequest extends FormRequest
{

    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'IdUser' => ['required'],
            'IdEmp' => ['required'],
            'Fecha' => ['required'],
            'Departamento_id' => ['required'],
            'NumReq' => ['numeric','required','digits_between:4,5',Rule::unique('requisiciones')->ignore($this->id)],
            'Codigo' => ['required'],
            'Maquina' => ['required'],
            'Marca' => ['required'],
            'Tipo' => ['required'],
            'Nombre' => ['required'],
            'Marca' => ['required'],
            'Observaciones' => ['required'],
        ];
    }

    public function messages(){
        return [
            'Fecha.required' => 'Selecciona una Fecha',

            'NumReq.numeric' => 'El Número de requisición solo admite números',
            'NumReq.digits_between' => 'El Número de requisición debe estar compuesto por 4 o 5 digitos',
            'NumReq.required' => 'El número de requisición es obligatorio',
            'NumReq.required' => 'El número de requisición ya ha sido registrado con Anterioridad',
        ];
    }

    public function attributes(){
        return [

        ];
    }
}
