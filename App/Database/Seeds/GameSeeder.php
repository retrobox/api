<?php


use Phinx\Seed\AbstractSeed;

class GameSeeder extends AbstractSeed
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
		$this->table('games')->truncate();
		$this->table('game_editors')->truncate();
		$this->table('game_medias')->truncate();
		$this->table('game_platforms')->truncate();
		$this->table('genres')->truncate();
		$this->table('game_genre')->truncate();
		$faker = Faker\Factory::create('FR_fr');

		//Editors
		$editors = [];
		for ($i = 0; $i < 10; $i++) {
			$editors[] = [
				'id' => uniqid(),
				'name' => $faker->company,
				'description' => $faker->text,
				'created_at' => $faker->dateTime->format('Y-m-d H:i:s'),
				'updated_at' => $faker->dateTime->format('Y-m-d H:i:s')
			];
		}
		$this->insert('editors', $editors);

		//For the editors
		$medias = [];
		for ($i = 0; $i < 10; $i++) {
			$medias[] = [
				'id' => uniqid(),
				'url' => $faker->imageUrl(400, 400),
				'type' => 'logo',
				'parent_id' => $editors[$i]['id'],
				'parent_type' => 'App\Models\GameEditor',
				'created_at' => $faker->dateTime->format('Y-m-d H:i:s'),
				'updated_at' => $faker->dateTime->format('Y-m-d H:i:s')
			];
		}
		$this->insert('medias', $medias);

		//Platforms
		$platforms = [];
		for ($i = 0; $i < 10; $i++) {
			$platforms[] = [
				'id' => uniqid(),
				'name' => $faker->sentence(rand(2, 5)),
				'short' => $faker->word,
				'manufacturer' => $faker->company,
				'description' => $faker->text,
				'created_at' => $faker->dateTime->format('Y-m-d H:i:s'),
				'updated_at' => $faker->dateTime->format('Y-m-d H:i:s')
			];
		}
		$this->insert('platforms', $platforms);


		//For the platforms
		$medias = [];
		for ($i = 0; $i < 10; $i++) {
			$medias[] = [
				'id' => uniqid(),
				'url' => $faker->imageUrl(),
				'type' => 'image',
				'parent_id' => $editors[$i]['id'],
				'parent_type' => 'App\Models\GameEditor',
				'created_at' => $faker->dateTime->format('Y-m-d H:i:s'),
				'updated_at' => $faker->dateTime->format('Y-m-d H:i:s')
			];
			$medias[] = [
				'id' => uniqid(),
				'url' => $faker->imageUrl(400, 400),
				'type' => 'image',
				'parent_id' => $editors[$i]['id'],
				'parent_type' => 'App\Models\GameEditor',
				'created_at' => $faker->dateTime->format('Y-m-d H:i:s'),
				'updated_at' => $faker->dateTime->format('Y-m-d H:i:s')
			];
		}
		$this->insert('medias', $medias);

		//GAMES
		$esrbLevel = [
			'RP - Rating Pending',
			'EC - Early Childhood',
			'E - Everyone',
			'E10+ - Everyone 10+',
			'T - Teen',
			'M - Mature',
			'AO - Adults Only'
		];
		$games = [];
		for ($i = 0; $i < 50; $i++) {
			$games[] = [
				'id' => uniqid(),
				'name' => $faker->sentence(rand(2, 5)),
				'esrb_level' => $esrbLevel[rand(0, 6)],
				'rom_url' => $faker->url,
				'locale' => $faker->locale,
				'players' => rand(1, 3),
				'thegamesdb_rating' => $faker->randomFloat(4, 1, 10),
				'description' => $faker->text,
				'editor_id' => $editors[rand(0, 9)]['id'],
				'platform_id' => $platforms[rand(0, 9)]['id'],
				'created_at' => $faker->dateTime->format('Y-m-d H:i:s'),
				'updated_at' => $faker->dateTime->format('Y-m-d H:i:s'),
				'released_at' => $faker->dateTime->format('Y-m-d'),
			];

		}
		$this->insert('games', $games);

		//FOR THE GAMES
		$medias = [];
		for ($i = 0; $i < 50; $i++) {
			$medias[] = [
				'id' => uniqid(),
				'url' => $faker->imageUrl(),
				'type' => 'image',
				'parent_id' => $games[$i]['id'],
				'parent_type' => 'App\Models\GameEditor',
				'created_at' => $faker->dateTime->format('Y-m-d H:i:s'),
				'updated_at' => $faker->dateTime->format('Y-m-d H:i:s')
			];
		}
		$this->insert('medias', $medias);

		//INSERT genres/tag
		$genres = [];
		for ($i = 0; $i < 4; $i++) {
			$genres[] = [
				'id' => uniqid(),
				'name' => $faker->sentence(rand(2, 5)),
				'created_at' => $faker->dateTime->format('Y-m-d H:i:s'),
				'updated_at' => $faker->dateTime->format('Y-m-d H:i:s')
			];
		}
		$this->insert('genres', $genres);

		//INSERT genre game
		$genreGame = [];
		for ($i = 0; $i < 50; $i++) {
			$genreGame[] = [
				'genre_id' => $genres[rand(0,3)]['id'],
				'game_id' => $games[$i]['id']
			];
		}
		$this->insert('game_genre', $genreGame);

	}
}
