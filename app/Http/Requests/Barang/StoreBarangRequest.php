<?php

namespace App\Http\Requests\Barang;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreBarangRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'kategori_id' => 'required',
            'sub_kategori_id' => 'required',
            'asal_barang' => 'required|string|max:200',
            'no_surat' => 'nullable|string|max:200',
            'lampiran' => 'nullable|file|mimes:doc,docx,zip',
            'nama_barang' => 'required|array',
            'harga' => 'required|array',
            'jumlah' => 'required|array',
            'satuan' => 'required|array',
            'expired' => 'array',
            'expired.*' => 'nullable|date_format:Y-m-d',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            redirect()->back()
                ->withErrors($validator)
                ->withInput()
        );
    }
    
}
