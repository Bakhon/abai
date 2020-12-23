<?php

use App\Models\Refs\Org;
use Illuminate\Database\Seeder;

class OrgTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orgs = [
            [
                'name' => 'НК КазМунайГаз',
                'druid_id' => '',
                'druid_name' => '',
                'children' => [
                    [
                        'name' => 'АО «ОзенМунайГаз»',
                        'druid_id' => '2.0',
                        'druid_name' => 'АО ОМГ',
                    ],
                    [
                        'name' => 'АО «Каражанбасмунай»',
                        'druid_id' => '5.000001017E9',
                        'druid_name' => 'КБМ',
                    ],
                    [
                        'name' => 'ТОО «КазГерМунай»',
                        'druid_id' => '5.00000202E9',
                        'druid_name' => 'КазГерМунай',
                    ],
                    [
                        'name' => 'АО «ЭмбаМунайГаз»',
                        'druid_id' => '3.0',
                        'druid_name' => 'АО ЭМГ',
                    ],
                    [
                        'name' => 'АО «Мангистаумунайгаз»',
                        'druid_id' => '2.000000000004E12',
                        'druid_name' => 'ММГ',
                    ],
                ]
            ]
        ];

        $this->createOrg($orgs);

    }

    public function createOrg($orgs, $parentId = null)
    {
        foreach ($orgs as $orgData) {
            if ($parentId) {
                $orgData['parent_id'] = $parentId;
            }

            if (!empty($orgData['children'])) {
                $children = $orgData['children'];
                unset($orgData['children']);
            }

            $org = Org::create($orgData);

            if (!empty($children)) {
                $this->createOrg($children, $org->id);
            }
        }
    }

}
