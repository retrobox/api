<?php
namespace App\GraphQL;
use App\GraphQL\Type\Scalar\DateTime;
use App\GraphQL\Type\Editor;
use App\GraphQL\Type\Game;
use App\GraphQL\Type\Genre;
use App\GraphQL\Type\Platform;
use App\GraphQL\Type\Scalar\NonEmpty;

/**
 * Class Types
 *
 * Acts as a registry and factory for your types.
 *
 * As simplistic as possible for the sake of clarity of this example.
 * Your own may be more dynamic (or even code-generated).
 *
 * @package GraphQL\Examples\Blog
 */
class Types
{
	private static $game;
	private static $platform;
	private static $editor;
	private static $genre;
	private static $dateTime;
	private static $nonEmpty;

	/**
	 * @return Game
	 */
	public static function game()
	{
		return self::$game ?: (self::$game = new Game());
	}

	/**
	 * @return Platform
	 */
	public static function platform()
	{
		return self::$platform ?: (self::$platform = new Platform());
	}

	/**
	 * @return Editor
	 */
	public static function editor()
	{
		return self::$nonEmpty ?: (self::$editor = new Editor());
	}


	/**
	 * @return Genre
	 */
	public static function genre()
	{
		return self::$genre ?: (self::$genre = new Genre());
	}

	/**
	 * @return DateTime
	 */
	public static function dateTime()
	{
		return self::$dateTime ?: (self::$dateTime = new DateTime());
	}

	public static function nonEmpty()
	{
		return self::$nonEmpty ?: (self::$nonEmpty = new NonEmpty());
	}
}
