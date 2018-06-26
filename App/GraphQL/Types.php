<?php
namespace App\GraphQL;
use App\GraphQL\Type\Post;
use App\GraphQL\Type\Scalar\DateTime;
use App\GraphQL\Type\Editor;
use App\GraphQL\Type\Game;
use App\GraphQL\Type\Genre;
use App\GraphQL\Type\Platform;
use App\GraphQL\Type\Scalar\NonEmpty;
use App\GraphQL\Type\ShopCategory;
use App\GraphQL\Type\ShopItem;
use App\GraphQL\Type\ShopLink;

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
	private static $post;
	private static $shopItem;
	private static $shopLink;
	private static $shopCategory;
	private static $shopCategoryWithDepth;
	private static $shopItemWithDepth;


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
		return self::$editor ?: (self::$editor = new Editor());
	}


	/**
	 * @return Genre
	 */
	public static function genre()
	{
		return self::$genre ?: (self::$genre = new Genre());
	}

	/**
	 * @return Post
	 */
	public static function post()
	{
		return self::$post ?: (self::$post = new Post());
	}

	/**
	 * @return ShopItem
	 */
	public static function shopItem()
	{
		return self::$shopItem ?: (self::$shopItem = new ShopItem());
	}

	/**
	 * @return ShopItem
	 */
	public static function shopItemWithDepth()
	{
		return self::$shopItemWithDepth ?: (self::$shopItemWithDepth = new ShopItem(true));
	}

	/**
	 * @return ShopCategory
	 */
	public static function shopCategory()
	{
		return self::$shopCategory ?: (self::$shopCategory = new ShopCategory());
	}
	
	/**
	 * @return ShopCategory
	 */
	public static function shopCategoryWithDepth()
	{
		return self::$shopCategoryWithDepth ?: (self::$shopCategoryWithDepth = new ShopCategory(true));
	}

	/**
	 * @return ShopLink
	 */
	public static function shopLink()
	{
		return self::$shopLink ?: (self::$shopLink = new ShopLink());
	}

}
