<?php
namespace App\GraphQL;
use App\GraphQL\Type\Console;
use App\GraphQL\Type\ConsoleVersion;
use App\GraphQL\Type\Game;
use App\GraphQL\Type\GameEditor;
use App\GraphQL\Type\GameMedia;
use App\GraphQL\Type\GamePlatform;
use App\GraphQL\Type\GameRom;
use App\GraphQL\Type\GameTag;
use App\GraphQL\Type\Post;
use App\GraphQL\Type\Scalar\DateTime;
use App\GraphQL\Type\Scalar\FloatType;
use App\GraphQL\Type\Scalar\NonEmpty;
use App\GraphQL\Type\Scalar\Url;
use App\GraphQL\Type\ShopCategory;
use App\GraphQL\Type\ShopImage;
use App\GraphQL\Type\ShopItem;
use App\GraphQL\Type\ShopOrder;
use App\GraphQL\Type\User;

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
    private static $dateTime;
    private static $nonEmpty;
    private static $game;
    private static $gamePlatform;
    private static $gamePlatformWithDepth;
    private static $gameEditor;
    private static $gameEditorWithDepth;
    private static $gameTag;
    private static $gameTagWithDepth;
    private static $gameMedia;
    private static $gameRom;
    private static $post;
	private static $shopItem;
	private static $shopCategory;
	private static $shopCategoryWithDepth;
	private static $shopItemWithDepth;
    private static $shopImage;
    private static $user;
    private static $url;
    private static $float;
    private static $shopOrderWithDepth;
    private static $shopOrder;
    private static $console;
    private static $consoleVersion;

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
     * @return Console
     */
    public static function console()
    {
        return self::$console ?: (self::$console = new Console());
    }

	/**
	 * @return Game
	 */
	public static function game()
	{
		return self::$game ?: (self::$game = new Game());
	}

	/**
	 * @return GamePlatform
	 */
	public static function gamePlatform()
	{
		return self::$gamePlatform ?: (self::$gamePlatform = new GamePlatform());
	}

    /**
     * @return GamePlatform
     */
    public static function gamePlatformWithDepth()
    {
        return self::$gamePlatformWithDepth ?: (self::$gamePlatformWithDepth = new GamePlatform(true));
    }

	/**
	 * @return GameEditor
	 */
	public static function gameEditor()
	{
		return self::$gameEditor ?: (self::$gameEditor = new GameEditor());
	}

    /**
     * @return GameEditor
     */
    public static function gameEditorWithDepth()
    {
        return self::$gameEditorWithDepth ?: (self::$gameEditorWithDepth = new GameEditor(true));
    }

	/**
	 * @return GameTag
	 */
	public static function gameTag()
	{
		return self::$gameTag ?: (self::$gameTag = new GameTag());
	}


    /**
     * @return GameTag
     */
    public static function gameTagWithDepth()
    {
        return self::$gameTagWithDepth ?: (self::$gameTagWithDepth = new GameTag(true));
    }

    /**
     * @return GameMedia
     */
    public static function gameMedia()
    {
        return self::$gameMedia ?: (self::$gameMedia = new GameMedia());
    }

    /**
     * @return GameRom
     */
    public static function gameRom()
    {
        return self::$gameRom ?: (self::$gameRom = new GameRom());
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
		return self::$shopCategory ?: (self::$shopCategory = new ShopCategory(false));
	}

	/**
	 * @return ShopCategory
	 */
	public static function shopCategoryWithDepth()
	{
		return self::$shopCategoryWithDepth ?: (self::$shopCategoryWithDepth = new ShopCategory(true));
	}

	/**
	 * @return ShopImage
	 */
	public static function shopImage()
	{
		return self::$shopImage ?: (self::$shopImage = new ShopImage());
	}

	public static function shopOrder()
    {
        return self::$shopOrder ?: (self::$shopOrder = new ShopOrder());
    }

    public static function shopOrderWithDepth()
    {
        return self::$shopOrderWithDepth ?: (self::$shopOrderWithDepth = new ShopOrder(1));
    }

    public static function user()
    {
        return self::$user ?: (self::$user = new User());
    }

    public static function consoleVersion()
    {
        return self::$consoleVersion ?: (self::$consoleVersion = new ConsoleVersion());
    }

    public static function url()
    {
        return self::$url ?: (self::$url = new Url());
    }

    public static function float()
    {
        return self::$float ?: (self::$float = new FloatType());
    }

}
