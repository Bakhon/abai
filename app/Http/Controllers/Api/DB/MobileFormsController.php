<?php

namespace App\Http\Controllers\Api\DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MobileFormsController extends Controller
{

    protected $file;

    public function __construct()
    {
        $this->file = storage_path() . '/mobile_form.json';
    }

    public function saveMobileForm(Request $request): void
    {
        $values = $this->getMobileFormValues();
        $values[$request->get('code')] = $request->get('value');
        File::put($this->file, json_encode($values));
    }

    public function getMobileFormValues(): array
    {
        if (!File::exists($this->file)) {
            $values = [
                'casing_pressure' => 1.12,
                'wellhead_pressure' => 1,
                'casing_pressure1' => 1.12,
                'wellhead_pressure1' => 1.12,
                'casing_pressure2' => 1.12,
                'wellhead_pressure2' => 1.12,
            ];
            File::put($this->file, json_encode($values));
        }

        return json_decode(File::get($this->file), 1);
    }
}
