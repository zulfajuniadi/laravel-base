<?php

class UploadsTableSeeder extends Seeder {

	public function run()
	{

    Upload::truncate();

		$datas = [
      [
        'name' => 'example'
      ]
    ];

		foreach($datas as $data)
		{
			Upload::create($data);
		}
	}

}