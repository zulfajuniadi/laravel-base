<?php

class ReportGroupingsTableSeeder extends Seeder {

	public function run()
	{

    ReportGrouping::truncate();

		$datas = [
            [
                'name' => 'example'
            ]
        ];

		foreach($datas as $data)
		{
			ReportGrouping::create($data);
		}
	}

}