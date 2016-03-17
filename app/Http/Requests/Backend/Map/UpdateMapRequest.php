<?php

namespace App\Http\Requests\Backend\Map;

use App\Http\Requests\Request;

/**
 * Class UpdateMapRequest
 * @package App\Http\Requests\Backend\Map
 */
class UpdateMapRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('edit-maps');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => 'required|file',
            'name'  => 'required',
        ];
    }
}
