<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\ObjectType;

class Mutations extends ObjectType {
	public function __construct()
	{
		$config = [
			'name' => 'Mutations',
			'fields' => [
				'storeGame' => \App\GraphQL\Query\Game::store(),
                'updateGame' => \App\GraphQL\Query\Game::update(),
                'destroyGame' => \App\GraphQL\Query\Game::destroy(),

                // game editor
				'storeGameEditor' => \App\GraphQL\Query\GameEditor::store(),
				'updateGameEditor' => \App\GraphQL\Query\GameEditor::update(),
				'destroyGameEditor' => \App\GraphQL\Query\GameEditor::destroy(),

                // game platform
                'storeGamePlatform' => \App\GraphQL\Query\GamePlatform::store(),
                'updateGamePlatform' => \App\GraphQL\Query\GamePlatform::update(),
                'destroyGamePlatform' => \App\GraphQL\Query\GamePlatform::destroy(),

                // game media
                'storeGameMedia' => \App\GraphQL\Query\GameMedia::store(),
                'updateGameMedia' => \App\GraphQL\Query\GameMedia::update(),
                'destroyGameMedia' => \App\GraphQL\Query\GameMedia::destroy(),

                // game rom
                'storeGameRom' => \App\GraphQL\Query\GameRom::store(),
                'updateGameRom' => \App\GraphQL\Query\GameRom::update(),
                'destroyGameRom' => \App\GraphQL\Query\GameRom::destroy(),

                // game tags
                'storeGameTag' => \App\GraphQL\Query\GameTag::store(),
                'updateGameTag' => \App\GraphQL\Query\GameTag::update(),
                'destroyGameTag' => \App\GraphQL\Query\GameTag::destroy(),

				//post
				'storePost' => \App\GraphQL\Query\Post::store(),

                //user
                'updateUser' => \App\GraphQL\Query\User::update(),
                'destroyUser' => \App\GraphQL\Query\User::destroy(),

                //shop item
                'storeShopItem' => \App\GraphQL\Query\ShopItem::store(),
                'updateShopItem' => \App\GraphQL\Query\ShopItem::update(),
                'destroyShopItem' => \App\GraphQL\Query\ShopItem::destroy(),

                //shop category
                'storeShopCategory' => \App\GraphQL\Query\ShopCategory::store(),
                'updateShopCategory' => \App\GraphQL\Query\ShopCategory::update(),
                'updateShopCategoriesOrder' => \App\GraphQL\Query\ShopCategory::updateOrder(),
                'destroyShopCategory' => \App\GraphQL\Query\ShopCategory::destroy(),

                //shop image
                'destroyShopImage' => \App\GraphQL\Query\ShopImage::destroy(),

                //shop order
                'updateShopOrder' => \App\GraphQL\Query\ShopOrder::update(),
                'destroyShopOrder' => \App\GraphQL\Query\ShopOrder::destroy(),

                //console
                'storeConsole' => \App\GraphQL\Query\Console::store(),
                'updateConsole' => \App\GraphQL\Query\Console::update(),
                'destroyConsole' => \App\GraphQL\Query\Console::destroy(),
                'shutdownConsole' => \App\GraphQL\Query\Console::shutdown(),
                'rebootConsole' => \App\GraphQL\Query\Console::reboot(),
                'resetConsoleToken' => \App\GraphQL\Query\Console::resetToken(),

                //console images
                'storeConsoleImage' => \App\GraphQL\Query\ConsoleImage::store(),
                'updateConsoleImage' => \App\GraphQL\Query\ConsoleImage::update(),
                'destroyConsoleImage' => \App\GraphQL\Query\ConsoleImage::destroy()
			]
		];

		parent::__construct($config);
	}
}
