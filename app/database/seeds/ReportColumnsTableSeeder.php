<?php

class ReportColumnsTableSeeder extends Seeder {

	public function run()
	{

    ReportColumn::truncate();

		$datas = [
            [
                'name' => 'example'
            ]
        ];

		foreach($datas as $data)
		{
			ReportColumn::create($data);
		}
	}

}