<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillLogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'type' => 'required',
            'amount' => 'required|numeric',
            'logdate' => 'required|date',
            'logtime' => 'date_format:H:i:s',
            'remarks' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'type.required' => 'Type is required',
            'amount.required' => 'Amount is required',
            'amount.numeric' => 'Amount must be a number',
            'logdate.required' => 'Log date is required',
            'logdate.date' => 'Log date is invalid',
            'logtime.required' => 'Log time is required',
            'logtime.date_format' => 'Log time is invalid',
        ];
    }
}
