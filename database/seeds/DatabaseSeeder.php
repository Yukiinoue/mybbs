<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Faker\Factory as Faker;
use Carbon\Carbon;
use App\Post;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('PostsTableSeeder');
    }
}


class PostsTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('posts')->delete();

		$faker = Faker::create('ja_JP');

		for($i=0; $i < 20; $i++)
		{
			Post::create([
				'name' => $faker->name(),
				'reply_id' => 0,
				'body'=> $faker->paragraph(),
				'password' => $faker->password(),
				'posted_at' => Carbon::today()
			]);
		}

		
	}
}
