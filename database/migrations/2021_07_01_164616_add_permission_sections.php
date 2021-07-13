<?php

use App\Models\PermissionSection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPermissionSections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->seed();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }

    private function seed()
    {
        $data = [
            [
                'code' => 'main',
                'module' => 'economic'
            ],
            [
                'code' => 'main',
                'module' => 'podborGno'
            ],
            [
                'code' => 'main',
                'module' => 'paegtm'
            ],
            [
                'code' => 'main',
                'module' => 'bigdata'
            ],
            [
                'code' => 'main',
                'module' => 'bigdata'
            ],
            [
                'code' => 'load_las',
                'module' => 'bigdata'
            ],
            [
                'code' => 'file_status',
                'title_trans' => 'bd.forms.file_status.title',
                'module' => 'bigdata'
            ],
            [
                'code' => 'file_type',
                'title_trans' => 'bd.forms.file_type.title',
                'module' => 'bigdata'
            ],
            [
                'code' => 'recording_method',
                'title_trans' => 'bd.forms.recording_method.title',
                'module' => 'bigdata'
            ],
            [
                'code' => 'recording_state',
                'title_trans' => 'bd.forms.recording_state.title',
                'module' => 'bigdata'
            ],
            [
                'code' => 'stem_section',
                'title_trans' => 'bd.forms.stem_section.title',
                'module' => 'bigdata'
            ],
            [
                'code' => 'stem_type',
                'title_trans' => 'bd.forms.stem_type.title',
                'module' => 'bigdata'
            ],
            [
                'code' => 'main',
                'module' => 'tr'
            ],
            [
                'code' => '',
                'module' => 'tr'
            ],
            [
                'code' => 'main',
                'module' => 'visualcenter'
            ],
        ];

        foreach ($data as $row) {
            PermissionSection::firstOrCreate($row);
        }
    }
}
