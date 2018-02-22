<?php

namespace Vadiasov\ArtistsAdmin\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArtistRequest extends FormRequest
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
            'name' => ['required', 'regex:/^[a-zA-Z\-\' ]+$/u'],
            'url' => ['required', 'regex:/^[a-z\-]+$/u'],
            'location' => ['required', 'regex:/^[a-zA-Z\-\'\, ]+$/u'],
            'genre_id' => ['required'],
            'tags' => ['required'],
            'editor1' => ['required'],
            'email' => ['required', 'email'],
        ];
    }
}
