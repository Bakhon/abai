<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'org_id' => 'nullable|exists:orgs,id',
            'roles' => 'nullable|array',
            'roles.*' => 'nullable|exists:roles,id'
        ];
    }
}
