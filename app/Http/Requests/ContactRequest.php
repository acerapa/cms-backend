<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
        $id = $this->contact ? $this->contact->id : null;
        $routeName = $this->route()->getName();

        $rules = [
            'name'           => 'required',
            'address'        => 'required',
            'contact-number' => 'required|size:11|unique:contacts,contact-number,' . $id,
            'email'          => 'required|email|unique:contacts,email,' . $id,
        ];

        if ($routeName === 'contacts.update') {
            $rules = [
                'contact-number' => 'size:11|unique:contacts,contact-number,' . $id,
                'email'          => 'email|unique:contacts,email,' . $id,
            ];
        }

        return $rules;
    }
}
