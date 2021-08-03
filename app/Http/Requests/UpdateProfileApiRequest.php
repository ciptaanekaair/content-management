<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileApiRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => 'required',
            'profile_photo' => 'image|mimes:jpg,png,bmp,svg|max:3084'
        ];
    }

    public function message()
    {
        return [
            'name.string'         => 'field nama harus di isi',
            'profile_photo.image' => 'extensi hanya boleh: jpg/jpeg/png',
            'profile_photo.mimes' => 'extensi hanya boleh: jpg/jpeg/png',
            'profile_photo.max'   => 'maximal file berukuran 3MB'
        ];
    }
}
