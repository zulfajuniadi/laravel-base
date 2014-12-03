<?php

class ReportFieldsTableSeeder extends Seeder {

	public function run()
	{

    ReportField::truncate();

		$datas = [
            [
                'name' => 'example'
            ]
        ];

		foreach($datas as $data)
		{
			ReportField::create($data);
		}
	}

}