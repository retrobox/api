<?php


use Phinx\Seed\AbstractSeed;

class PostSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
		$this->table('posts')->truncate();
		$faker = Faker\Factory::create('FR_fr');

		$markdown = "
			## hello world
			
			Sunt bromiumes anhelare clemens, festus aususes.Primus impositio saepe convertams adelphis est.This pattern has only been attacked by a final sensor.
			Sunt bromiumes anhelare clemens, festus aususes.Primus impositio saepe convertams adelphis est.This pattern has only been attacked by a final sensor.
			Sunt bromiumes anhelare clemens, festus aususes.Primus impositio saepe convertams adelphis est.This pattern has only been attacked by a final sensor.
			
			- Ferox, flavum onuss aliquando anhelare de alter, bi-color urbs.
			- Unprepared fears loves most thoughts.
			- Why does the crewmate meet?
			- Captains are the cosmonauts of the virtual resistance.
			
			Sunt bromiumes anhelare clemens, festus aususes.Primus impositio saepe convertams adelphis est.This pattern has only been attacked by a final sensor.
			Sunt bromiumes anhelare clemens, festus aususes.Primus impositio saepe convertams adelphis est.This pattern has only been attacked by a final sensor.
			Sunt bromiumes anhelare clemens, festus aususes.Primus impositio saepe convertams adelphis est.This pattern has only been attacked by a final sensor.
			
			## helo world			
	
			Sunt bromiumes anhelare clemens, festus aususes.Primus impositio saepe convertams adelphis est.This pattern has only been attacked by a final sensor.
			Sunt bromiumes anhelare clemens, festus aususes.Primus impositio saepe convertams adelphis est.
			
			### This pattern has only been attacked by a final sensor.
		
			Sunt bromiumes anhelare clemens, festus aususes.Primus impositio saepe convertams adelphis est.This pattern has only been attacked by a final sensor.
			Sunt bromiumes anhelare clemens, festus aususes.Primus impositio saepe convertams adelphis est.This pattern has only been attacked by a final sensor.
			Sunt bromiumes anhelare clemens, festus aususes.Primus impositio saepe convertams adelphis est.This pattern has only been attacked by a final sensor.
		";
		//posts
		$posts = [];
		for ($i = 0; $i < 10; $i++) {
			$posts[] = [
				'id' => uniqid(),
				'title' => $faker->sentence(),
				'slug' => $faker->slug(5),
				'description' => $faker->text(190),
				'image' => "https://lorempixel.com/800/800/",
				//markdown faker ?
				'content' => $markdown,
				'created_at' => $faker->dateTime->format('Y-m-d H:i:s'),
				'updated_at' => $faker->dateTime->format('Y-m-d H:i:s')
			];
		}
		$this->insert('posts', $posts);
    }
}
