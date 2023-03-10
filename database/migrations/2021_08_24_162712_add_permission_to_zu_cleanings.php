<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\PermissionSection;

class AddPermissionToZuCleanings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $ids[] = DB::table('permissions')->insertGetId(
            [
                'name' => 'monitoring list zu-cleanings',
                'guard_name' => 'web'
            ]
        );

        $ids[] = DB::table('permissions')->insertGetId(
            [
                'name' => 'monitoring create zu-cleanings',
                'guard_name' => 'web'
            ]
        );

        $ids[] = DB::table('permissions')->insertGetId(
            [
                'name' => 'monitoring read zu-cleanings',
                'guard_name' => 'web'
            ]
        );

        $ids[] = DB::table('permissions')->insertGetId(
            [
                'name' => 'monitoring update zu-cleanings',
                'guard_name' => 'web'
            ]
        );

        $ids[] = DB::table('permissions')->insertGetId(
            [
                'name' => 'monitoring export zu-cleanings',
                'guard_name' => 'web'
            ]
        );

        $ids[] = DB::table('permissions')->insertGetId(
            [
                'name' => 'monitoring delete zu-cleanings',
                'guard_name' => 'web'
            ]
        );

        foreach ($ids as $id) {

            DB::table('role_has_permissions')->insert(
                [
                    'permission_id' => $id,
                    'role_id' => 1
                ]
            );
        }

        PermissionSection::firstOrCreate(
            [
                'code' => 'zu-cleanings',
                'title_trans' => 'monitoring.zu-cleanings.section-name',
                'module' => 'monitoring'
            ]
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $peermissionIds = DB::table('permissions')->where('name', 'like', '%zu-cleanings%')->pluck('id')->toArray();
        DB::table('permissions')->whereIn('id', $peermissionIds)->delete();
        
        PermissionSection::delete(
            [
                'code' => 'zu-cleanings',
                'title_trans' => 'monitoring.zu-cleanings.section-name',
                'module' => 'monitoring'
            ]
        );
    }
}
