<?php

class ReportEagersTableSeeder extends Seeder {

	public function run()
	{

    ReportEager::truncate();

		$datas = [
            [
                'name' => 'example'
            ]
        ];

		foreach($datas as $data)
		{
			ReportEager::create($data);
		}
	}

}