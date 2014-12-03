<?php

class ReportsTableSeeder extends Seeder {

	public function run()
	{

    Report::truncate();

		$datas = [
            [
                'name' => 'example'
            ]
        ];

		foreach($datas as $data)
		{
			Report::create($data);
		}
	}

}