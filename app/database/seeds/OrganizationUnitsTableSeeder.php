<?php

class OrganizationUnitsTableSeeder extends Seeder
{

    public function run()
    {

        OrganizationUnit::truncate();

        $datas = [
            [
                'name'    => 'root',
                'user_id' => 1
            ]
        ];

        foreach ($datas as $data) {
            OrganizationUnit::create($data);
        }
    }

}
