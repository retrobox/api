# GraphQL Schema Types for the RetroBox API

<details>
  <summary><strong>Table of Contents</strong></summary>

  * [Query](#query)
  * [Mutation](#mutation)
  * [Objects](#objects)
    * [Console](#console)
    * [ConsoleImage](#consoleimage)
    * [ConsoleImageStoreOutput](#consoleimagestoreoutput)
    * [ConsoleResetTokenOutput](#consoleresettokenoutput)
    * [ConsoleStoreOutput](#consolestoreoutput)
    * [ConsoleVersion](#consoleversion)
    * [Game](#game)
    * [GameEditor](#gameeditor)
    * [GameEditorStoreOutput](#gameeditorstoreoutput)
    * [GameEditorWithDepth](#gameeditorwithdepth)
    * [GameMedia](#gamemedia)
    * [GameMediaStoreOutput](#gamemediastoreoutput)
    * [GamePlatform](#gameplatform)
    * [GamePlatformStoreOutput](#gameplatformstoreoutput)
    * [GamePlatformWithDepth](#gameplatformwithdepth)
    * [GameRom](#gamerom)
    * [GameRomStoreOutput](#gameromstoreoutput)
    * [GameStoreOutput](#gamestoreoutput)
    * [GameTag](#gametag)
    * [GameTagStoreOutput](#gametagstoreoutput)
    * [GameTagWithDepth](#gametagwithdepth)
    * [PivotOutput](#pivotoutput)
    * [Post](#post)
    * [ShopCategory](#shopcategory)
    * [ShopCategoryStoreOutput](#shopcategorystoreoutput)
    * [ShopImage](#shopimage)
    * [ShopItem](#shopitem)
    * [ShopItemStoreOutput](#shopitemstoreoutput)
    * [ShopItemWithDepth](#shopitemwithdepth)
    * [ShopOrder](#shoporder)
    * [ShopOrderWithDepth](#shoporderwithdepth)
    * [User](#user)
  * [Inputs](#inputs)
    * [ConsoleImageStoreInput](#consoleimagestoreinput)
    * [ConsoleImageUpdateInput](#consoleimageupdateinput)
    * [ConsoleStoreInput](#consolestoreinput)
    * [ConsoleUpdateInput](#consoleupdateinput)
    * [GameEditorStoreInput](#gameeditorstoreinput)
    * [GameEditorUpdateInput](#gameeditorupdateinput)
    * [GameMediaStoreInput](#gamemediastoreinput)
    * [GameMediaUpdateInput](#gamemediaupdateinput)
    * [GamePlatformStoreInput](#gameplatformstoreinput)
    * [GamePlatformUpdateInput](#gameplatformupdateinput)
    * [GameRomStoreInput](#gameromstoreinput)
    * [GameRomUpdateInput](#gameromupdateinput)
    * [GameStoreInput](#gamestoreinput)
    * [GameTagStoreInput](#gametagstoreinput)
    * [GameTagUpdateInput](#gametagupdateinput)
    * [GameUpdateInput](#gameupdateinput)
    * [PostInput](#postinput)
    * [ShopCategoryStoreInput](#shopcategorystoreinput)
    * [ShopCategoryUpdateInput](#shopcategoryupdateinput)
    * [ShopCategoryUpdateOrderInput](#shopcategoryupdateorderinput)
    * [ShopImageStoreInput](#shopimagestoreinput)
    * [ShopImageUpdateInput](#shopimageupdateinput)
    * [ShopItemStoreInput](#shopitemstoreinput)
    * [ShopItemUpdateInput](#shopitemupdateinput)
    * [ShopOrderUpdateInput](#shoporderupdateinput)
    * [UserUpdateInput](#userupdateinput)
  * [Scalars](#scalars)
    * [Boolean](#boolean)
    * [Float](#float)
    * [ID](#id)
    * [Int](#int)
    * [String](#string)

</details>

## Query

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>getManyGames</strong></td>
            <td valign="top">[<a href="#game">Game</a>]</td>
            <td>

                Get many games

            </td>

        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">limit</td>
            <td valign="top"><a href="#int">Int</a></td>
            <td>

                Number of items to get

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">orderBy</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Order by a field

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">orderDir</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Direction of the order

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>getOneGame</strong></td>
            <td valign="top"><a href="#game">Game</a></td>
            <td>

                Get a game by id

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">id</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                The Id of the game

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>getManyGameEditors</strong></td>
            <td valign="top">[<a href="#gameeditor">GameEditor</a>]</td>
            <td>

                Get many GameEditors

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">limit</td>
            <td valign="top"><a href="#int">Int</a></td>
            <td>

                Number of items to get

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">orderBy</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Order by a field

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">orderDir</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Direction of the order

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>getOneGameEditor</strong></td>
            <td valign="top"><a href="#gameeditorwithdepth">GameEditorWithDepth</a></td>
            <td>

                Get a game editor by id

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">id</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                The Id of the game editor

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>getManyGamePlatforms</strong></td>
            <td valign="top">[<a href="#gameplatform">GamePlatform</a>]</td>
            <td>

                Get many GamePlatform

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">limit</td>
            <td valign="top"><a href="#int">Int</a></td>
            <td>

                Number of items to get

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">orderBy</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Order by a field

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">orderDir</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Direction of the order

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>getOneGamePlatform</strong></td>
            <td valign="top"><a href="#gameplatformwithdepth">GamePlatformWithDepth</a></td>
            <td>

                Get a platform by id

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">id</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                The Id of the game platform

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>getManyGameMedias</strong></td>
            <td valign="top">[<a href="#gamemedia">GameMedia</a>]</td>
            <td>

                Get many GameMedias

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">limit</td>
            <td valign="top"><a href="#int">Int</a></td>
            <td>

                Number of items to get

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">orderBy</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Order by a field

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">orderDir</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Direction of the order

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>getOneGameMedia</strong></td>
            <td valign="top"><a href="#gamemedia">GameMedia</a></td>
            <td>

                Get a game media by id

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">id</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                The Id of the game media

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>getManyGameRoms</strong></td>
            <td valign="top">[<a href="#gamerom">GameRom</a>]</td>
            <td>

                Get many GameRom

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">limit</td>
            <td valign="top"><a href="#int">Int</a></td>
            <td>

                Number of items to get

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">orderBy</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Order by a field

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">orderDir</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Direction of the order

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>getOneGameRom</strong></td>
            <td valign="top"><a href="#gamerom">GameRom</a></td>
            <td>

                Get a game rom by id

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">id</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                The Id of the game rom

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>getManyGameTags</strong></td>
            <td valign="top">[<a href="#gametagwithdepth">GameTagWithDepth</a>]</td>
            <td>

                Get many GameTags

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">limit</td>
            <td valign="top"><a href="#int">Int</a></td>
            <td>

                Number of items to get

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">orderBy</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Order by a field

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">orderDir</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Direction of the order

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>getOneGameTag</strong></td>
            <td valign="top"><a href="#gametagwithdepth">GameTagWithDepth</a></td>
            <td>

                Get a game tag by id

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">id</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                The Id of the game editor

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>getManyPosts</strong></td>
            <td valign="top">[<a href="#post">Post</a>]</td>
            <td>

                Get many posts

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">limit</td>
            <td valign="top"><a href="#int">Int</a></td>
            <td>

                Number of items to get

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">orderBy</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Order by a field

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">orderDir</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Direction of the order

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>getOnePost</strong></td>
            <td valign="top"><a href="#post">Post</a></td>
            <td>

                Get a post by id

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">id</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                The Id of the post

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>getManyShopItems</strong></td>
            <td valign="top">[<a href="#shopitem">ShopItem</a>]</td>
            <td>

                Get many shop item

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">limit</td>
            <td valign="top"><a href="#int">Int</a></td>
            <td>

                Number of items to get

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">orderBy</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Order by a field

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">orderDir</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Direction of the order

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">locale</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Filter by locales

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>getOneShopItem</strong></td>
            <td valign="top"><a href="#shopitemwithdepth">ShopItemWithDepth</a></td>
            <td>

                Get a shop item by id

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">id</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                The Id of the shop item

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">slug</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                The Slug of the shop item

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>getManyShopCategories</strong></td>
            <td valign="top">[<a href="#shopcategory">ShopCategory</a>]</td>
            <td>

                Get many shop category

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">limit</td>
            <td valign="top"><a href="#int">Int</a></td>
            <td>

                Number of items to get

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">orderBy</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Order by a field

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">orderDir</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Direction of the order

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">locale</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Filter by locales

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>getOneShopCategory</strong></td>
            <td valign="top"><a href="#shopcategory">ShopCategory</a></td>
            <td>

                Get a shop category by id

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">id</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                The Id of the shop category

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>getManyShopOrders</strong></td>
            <td valign="top">[<a href="#shoporderwithdepth">ShopOrderWithDepth</a>]</td>
            <td>

                Get many shop order

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">limit</td>
            <td valign="top"><a href="#int">Int</a></td>
            <td>

                Number of items to get

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">orderBy</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Order by a field

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">orderDir</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Direction of the order

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">all</td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td>

                True to get all orders

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>getOneShopOrder</strong></td>
            <td valign="top"><a href="#shoporderwithdepth">ShopOrderWithDepth</a></td>
            <td>

                Get a shop order

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">id</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                The Id of the shop order

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>getManyUsers</strong></td>
            <td valign="top">[<a href="#user">User</a>]</td>
            <td>

                Get many users

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">limit</td>
            <td valign="top"><a href="#int">Int</a></td>
            <td>

                Number of items to get

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">orderBy</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Order by a field

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">orderDir</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Direction of the order

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>getOneUser</strong></td>
            <td valign="top"><a href="#user">User</a></td>
            <td>

                Get a user by id

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">id</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                The STAIL.EU uuid of the user account

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>getManyConsoles</strong></td>
            <td valign="top">[<a href="#console">Console</a>]</td>
            <td>

                Get many consoles

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">limit</td>
            <td valign="top"><a href="#int">Int</a></td>
            <td>

                Number of items to get

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">orderBy</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Order by a field

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">orderDir</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Direction of the order

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">all</td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td>

                Fetch all consoles

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>getOneConsole</strong></td>
            <td valign="top"><a href="#console">Console</a></td>
            <td>

                Get a console

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">id</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                The Id of the console

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">with_status</td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td>

                Flag to retrieve console status thought web socket server and overlay

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>getConsoleVersions</strong></td>
            <td valign="top">[<a href="#consoleversion">ConsoleVersion</a>]</td>
            <td>

                Get all the console versions

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>openConsoleTerminalSession</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td>

                Open a remote terminal session on a console

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">id</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                The Id of the console

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">webSessionId</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                The id of the websocket session opened by a web client

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>getManyConsoleImages</strong></td>
            <td valign="top">[<a href="#consoleimage">ConsoleImage</a>]</td>
            <td>

                Get many console image

            </td>
        </tr>
    </tbody>
</table>

## Mutation (Mutations)  

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>storeGame</strong></td>
            <td valign="top"><a href="#gamestoreoutput">GameStoreOutput</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">game</td>
            <td valign="top"><a href="#gamestoreinput">GameStoreInput</a>!</td>
            <td>

                Game to store

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>updateGame</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">game</td>
            <td valign="top"><a href="#gameupdateinput">GameUpdateInput</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>destroyGame</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">id</td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>storeGameEditor</strong></td>
            <td valign="top"><a href="#gameeditorstoreoutput">GameEditorStoreOutput</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">editor</td>
            <td valign="top"><a href="#gameeditorstoreinput">GameEditorStoreInput</a>!</td>
            <td>

                GameEditor to store

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>updateGameEditor</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">editor</td>
            <td valign="top"><a href="#gameeditorupdateinput">GameEditorUpdateInput</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>destroyGameEditor</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">id</td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>storeGamePlatform</strong></td>
            <td valign="top"><a href="#gameplatformstoreoutput">GamePlatformStoreOutput</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">platform</td>
            <td valign="top"><a href="#gameplatformstoreinput">GamePlatformStoreInput</a>!</td>
            <td>

                GamePlatform to store

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>updateGamePlatform</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">platform</td>
            <td valign="top"><a href="#gameplatformupdateinput">GamePlatformUpdateInput</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>destroyGamePlatform</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">id</td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>storeGameMedia</strong></td>
            <td valign="top"><a href="#gamemediastoreoutput">GameMediaStoreOutput</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">media</td>
            <td valign="top"><a href="#gamemediastoreinput">GameMediaStoreInput</a>!</td>
            <td>

                GameMedia to store

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>updateGameMedia</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">media</td>
            <td valign="top"><a href="#gamemediaupdateinput">GameMediaUpdateInput</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>destroyGameMedia</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">id</td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>storeGameRom</strong></td>
            <td valign="top"><a href="#gameromstoreoutput">GameRomStoreOutput</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">rom</td>
            <td valign="top"><a href="#gameromstoreinput">GameRomStoreInput</a>!</td>
            <td>

                GameRom to store

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>updateGameRom</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">rom</td>
            <td valign="top"><a href="#gameromupdateinput">GameRomUpdateInput</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>destroyGameRom</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">id</td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>storeGameTag</strong></td>
            <td valign="top"><a href="#gametagstoreoutput">GameTagStoreOutput</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">tag</td>
            <td valign="top"><a href="#gametagstoreinput">GameTagStoreInput</a>!</td>
            <td>

                GameTag to store

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>updateGameTag</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">tag</td>
            <td valign="top"><a href="#gametagupdateinput">GameTagUpdateInput</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>destroyGameTag</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">id</td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>storePost</strong></td>
            <td valign="top"><a href="#post">Post</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">post</td>
            <td valign="top"><a href="#postinput">PostInput</a></td>
            <td>

                Post to store

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>updateUser</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">user</td>
            <td valign="top"><a href="#userupdateinput">UserUpdateInput</a></td>
            <td>

                User to update

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>destroyUser</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">id</td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>storeShopItem</strong></td>
            <td valign="top"><a href="#shopitemstoreoutput">ShopItemStoreOutput</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">item</td>
            <td valign="top"><a href="#shopitemstoreinput">ShopItemStoreInput</a></td>
            <td>

                Item to store

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>updateShopItem</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">item</td>
            <td valign="top"><a href="#shopitemupdateinput">ShopItemUpdateInput</a></td>
            <td>

                Item to update

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>destroyShopItem</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td>

                Destroy a shop item

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">id</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                The Id of the shop item to destroy

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>storeShopCategory</strong></td>
            <td valign="top"><a href="#shopcategorystoreoutput">ShopCategoryStoreOutput</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">category</td>
            <td valign="top"><a href="#shopcategorystoreinput">ShopCategoryStoreInput</a></td>
            <td>

                Category to store

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>updateShopCategory</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">category</td>
            <td valign="top"><a href="#shopcategoryupdateinput">ShopCategoryUpdateInput</a></td>
            <td>

                Category to update

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>updateShopCategoriesOrder</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td>

                Update the shop categories order

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">categories</td>
            <td valign="top">[<a href="#shopcategoryupdateorderinput">ShopCategoryUpdateOrderInput</a>]</td>
            <td>

                List of categories

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>destroyShopCategory</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td>

                Destroy a shop category

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">id</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                The Id of the shop category to destroy

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>destroyShopImage</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td>

                Destroy a shop image

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">id</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                The Id of the shop image to destroy

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>updateShopOrder</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">order</td>
            <td valign="top"><a href="#shoporderupdateinput">ShopOrderUpdateInput</a></td>
            <td>

                Order to update

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>destroyShopOrder</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">id</td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>storeConsole</strong></td>
            <td valign="top"><a href="#consolestoreoutput">ConsoleStoreOutput</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">console</td>
            <td valign="top"><a href="#consolestoreinput">ConsoleStoreInput</a>!</td>
            <td>

                Console to store

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>updateConsole</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td>

                Update a console

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">console</td>
            <td valign="top"><a href="#consoleupdateinput">ConsoleUpdateInput</a>!</td>
            <td>

                Console to update

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>destroyConsole</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">id</td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>shutdownConsole</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td>

                Shutdown a console

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">id</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                The Id of the console

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>rebootConsole</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td>

                Reboot a console

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">id</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                The Id of the console

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>resetConsoleToken</strong></td>
            <td valign="top"><a href="#consoleresettokenoutput">ConsoleResetTokenOutput</a></td>
            <td>

                Reset a console token

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">id</td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                The Id of the console

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>storeConsoleImage</strong></td>
            <td valign="top"><a href="#consoleimagestoreoutput">ConsoleImageStoreOutput</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">image</td>
            <td valign="top"><a href="#consoleimagestoreinput">ConsoleImageStoreInput</a>!</td>
            <td>

                Image to store

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>updateConsoleImage</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td>

                Update a console image

            </td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">image</td>
            <td valign="top"><a href="#consoleimageupdateinput">ConsoleImageUpdateInput</a>!</td>
            <td>

                Console image to update

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>destroyConsoleImage</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="right" valign="top">id</td>
            <td valign="top"><a href="#id">ID</a>!</td>
            <td></td>
        </tr>
    </tbody>
</table>

## Objects ### Console A user's console  

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>user</strong></td>
            <td valign="top"><a href="#user">User</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>order</strong></td>
            <td valign="top"><a href="#shoporder">ShopOrder</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>token</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Authentication token for the console overlay

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>version</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>storage</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>color</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>first_boot_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>created_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>updated_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>is_online</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>up_time</strong></td>
            <td valign="top"><a href="#int">Int</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>used_disk_space</strong></td>
            <td valign="top"><a href="#float">Float</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>free_disk_space</strong></td>
            <td valign="top"><a href="#float">Float</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>disk_usage</strong></td>
            <td valign="top"><a href="#float">Float</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>disk_size</strong></td>
            <td valign="top"><a href="#float">Float</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>cpu_temp</strong></td>
            <td valign="top"><a href="#float">Float</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>gpu_temp</strong></td>
            <td valign="top"><a href="#float">Float</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>ip</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>wifi</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                The wifi network SSID that the console is connected to

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>free_memory</strong></td>
            <td valign="top"><a href="#int">Int</a></td>
            <td>

                The amount of free memory, in bytes

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>total_memory</strong></td>
            <td valign="top"><a href="#int">Int</a></td>
            <td>

                The total amount of memory, in bytes

            </td>
        </tr>
    </tbody>
</table>

### ConsoleImage A SD-Card image specific version  

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>console_version</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                The console hardware (or PCB) version

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>software_version</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                A new software version represent for example a update in linux kernel or others new version of integrated software all packed up inside a single image release

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>version</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                The full version string with the console and the software version

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>description</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Can serve as a changelog field for this version of the image

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>size</strong></td>
            <td valign="top"><a href="#int">Int</a></td>
            <td>

                The size of the zip file

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>created_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>updated_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### ConsoleImageStoreOutput  

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>saved</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### ConsoleResetTokenOutput  

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>token</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>overlay_killed</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### ConsoleStoreOutput  

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>saved</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### ConsoleVersion A console version  

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                A class version string format

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>image_url</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                The url to download the image of this console version to flash the sd card with

            </td>
        </tr>
    </tbody>
</table>

### Game The retrogame  

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>name</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>esrb_level</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                The Entertainment Software Rating Board level of the game

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>locale</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                A comma list of locale supported by this game

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>players</strong></td>
            <td valign="top"><a href="#int">Int</a></td>
            <td>

                Numbers of maximum players that the game allow to play with

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>thegamesdb_rating</strong></td>
            <td valign="top"><a href="#float">Float</a></td>
            <td>

                Average rating of TheGamesDB

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>igdb_rating</strong></td>
            <td valign="top"><a href="#float">Float</a></td>
            <td>

                Average rating of IGDB users

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>description</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>created_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>updated_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>released_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>original_file_name</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                The original file name used when the rom file was uploaded by a user

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>user</strong></td>
            <td valign="top"><a href="#user">User</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>platform</strong></td>
            <td valign="top"><a href="#gameplatform">GamePlatform</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>editor</strong></td>
            <td valign="top"><a href="#gameeditor">GameEditor</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>tags</strong></td>
            <td valign="top">[<a href="#gametag">GameTag</a>]</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>medias</strong></td>
            <td valign="top">[<a href="#gamemedia">GameMedia</a>]</td>
            <td></td>
        </tr>
    </tbody>
</table>

### GameEditor The editor of the game  

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>name</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>description</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>games_count</strong></td>
            <td valign="top"><a href="#int">Int</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>created_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>updated_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### GameEditorStoreOutput  

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>saved</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### GameEditorWithDepth The editor of the game  

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>name</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>description</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>games_count</strong></td>
            <td valign="top"><a href="#int">Int</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>created_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>updated_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>games</strong></td>
            <td valign="top">[<a href="#game">Game</a>]</td>
            <td></td>
        </tr>
    </tbody>
</table>

### GameMedia A media of a game or a platform (image/video)  

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>type</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>url</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>is_main</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>created_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>updated_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### GameMediaStoreOutput  

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>saved</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### GamePlatform The platform of the game  

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>name</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>description</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>short</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>manufacturer</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>cpu</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>memory</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>graphics</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>sound</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>display</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>max_controllers</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>thegamesdb_rating</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>medias</strong></td>
            <td valign="top">[<a href="#gamemedia">GameMedia</a>]</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>released_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>created_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>updated_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### GamePlatformStoreOutput

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>saved</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### GamePlatformWithDepth The platform of the game  

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>name</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>description</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>short</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>manufacturer</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>cpu</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>memory</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>graphics</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>sound</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>display</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>max_controllers</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>thegamesdb_rating</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>medias</strong></td>
            <td valign="top">[<a href="#gamemedia">GameMedia</a>]</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>released_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>created_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>updated_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>games</strong></td>
            <td valign="top">[<a href="#game">Game</a>]</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>games_count</strong></td>
            <td valign="top"><a href="#int">Int</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### GameRom A game rom file  

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>size</strong></td>
            <td valign="top"><a href="#int">Int</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>url</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>sha1_hash</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>last_checked_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>created_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>updated_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### GameRomStoreOutput  

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>saved</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### GameStoreOutput  

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>saved</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### GameTag The tag of the game  

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>name</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>description</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>icon</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>created_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>updated_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### GameTagStoreOutput  

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>saved</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### GameTagWithDepth The tag of the game  

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>name</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>description</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>icon</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>created_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>updated_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>games</strong></td>
            <td valign="top">[<a href="#game">Game</a>]</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>games_count</strong></td>
            <td valign="top"><a href="#int">Int</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### PivotOutput  

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>shop_item_custom_option_storage</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>shop_item_custom_option_color</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### Post A post in the blog  

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>title</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>image</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>description</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                The post description, written in plain text, showed on preview

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>content</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                The post body, written in markdown

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>created_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>updated_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### ShopCategory A category of item in the shop  

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>title</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>order</strong></td>
            <td valign="top"><a href="#int">Int</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>is_customizable</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>locale</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>created_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>updated_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>items</strong></td>
            <td valign="top">[<a href="#shopitem">ShopItem</a>]</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>items_count</strong></td>
            <td valign="top"><a href="#int">Int</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### ShopCategoryStoreOutput  

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>saved</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### ShopImage A image belong to a shop item  

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>url</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>is_main</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>name</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>created_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>updated_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### ShopItem A item in the shop  

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>title</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>image</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>identifier</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Identifier is used to identify the same product in two different locale

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>slug</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Generated on identifier

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>weight</strong></td>
            <td valign="top"><a href="#float">Float</a></td>
            <td>

                Weight of the item in g SI

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>images</strong></td>
            <td valign="top">[<a href="#shopimage">ShopImage</a>]</td>
            <td>

                Images belongs to this shop item

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>description_short</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>description_long</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Written in markdown

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>price</strong></td>
            <td valign="top"><a href="#float">Float</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>version</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>locale</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>show_version</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>allow_indexing</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td>

                If true, the item should be indexed by robots

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>created_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>updated_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### ShopItemStoreOutput  

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>saved</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### ShopItemWithDepth A item in the shop  

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>title</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>image</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>identifier</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Identifier is used to identify the same product in two different locale

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>slug</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Generated on identifier

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>weight</strong></td>
            <td valign="top"><a href="#float">Float</a></td>
            <td>

                Weight of the item in g SI

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>images</strong></td>
            <td valign="top">[<a href="#shopimage">ShopImage</a>]</td>
            <td>

                Images belongs to this shop item

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>description_short</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>description_long</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                Written in markdown

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>price</strong></td>
            <td valign="top"><a href="#float">Float</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>version</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>locale</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>show_version</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>allow_indexing</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td>

                If true, the item should be indexed by robots

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>created_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>updated_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>category</strong></td>
            <td valign="top"><a href="#shopcategory">ShopCategory</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>pivot</strong></td>
            <td valign="top"><a href="#pivotoutput">PivotOutput</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### ShopOrder A user's order  

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>user</strong></td>
            <td valign="top"><a href="#user">User</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>shipping_method</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>shipping_id</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>on_way_id</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>total_price</strong></td>
            <td valign="top"><a href="#float">Float</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>sub_total_price</strong></td>
            <td valign="top"><a href="#float">Float</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>total_shipping_price</strong></td>
            <td valign="top"><a href="#float">Float</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>status</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>way</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>bill_url</strong></td>
            <td valign="top"><a href="#url">url</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>note</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                A message left by customer at checkout to specify instructions to the order agent (or preparator)

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>created_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>updated_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### ShopOrderWithDepth A user's order  

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>user</strong></td>
            <td valign="top"><a href="#user">User</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>shipping_method</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>shipping_id</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>on_way_id</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>total_price</strong></td>
            <td valign="top"><a href="#float">Float</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>sub_total_price</strong></td>
            <td valign="top"><a href="#float">Float</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>total_shipping_price</strong></td>
            <td valign="top"><a href="#float">Float</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>status</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>way</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>bill_url</strong></td>
            <td valign="top"><a href="#url">url</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>note</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                A message left by customer at checkout to specify instructions to the order agent (or preparator)

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>created_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>updated_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>items</strong></td>
            <td valign="top">[<a href="#shopitemwithdepth">ShopItemWithDepth</a>]</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>items_count</strong></td>
            <td valign="top"><a href="#int">Int</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### User A user account  

<table>
    <thead>
        <tr>
            <th align="left">Field</th>
            <th align="right">Argument</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td>

                The user STAIL.EU uuid

            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>first_name</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>last_name</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>last_locale</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>address_first_line</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>address_second_line</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>address_postal_code</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>address_city</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>address_country</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>last_username</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>last_email</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>last_avatar</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>last_ip</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>last_user_agent</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>last_login_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>is_admin</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>created_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>updated_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

## Inputs ### ConsoleImageStoreInput  

<table>
    <thead>
        <tr>
            <th colspan="2" align="left">Field</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>console_version</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>software_version</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>description</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### ConsoleImageUpdateInput  

<table>
    <thead>
        <tr>
            <th colspan="2" align="left">Field</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>software_version</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>description</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### ConsoleStoreInput  

<table>
    <thead>
        <tr>
            <th colspan="2" align="left">Field</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>version</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>order_id</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>user_id</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>color</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>storage</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
    </tbody>
</table>

### ConsoleUpdateInput  

<table>
    <thead>
        <tr>
            <th colspan="2" align="left">Field</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>version</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>order_id</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>user_id</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>color</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>storage</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
    </tbody>
</table>

### GameEditorStoreInput  

<table>
    <thead>
        <tr>
            <th colspan="2" align="left">Field</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>name</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>description</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
    </tbody>
</table>

### GameEditorUpdateInput  

<table>
    <thead>
        <tr>
            <th colspan="2" align="left">Field</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>name</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>description</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
    </tbody>
</table>

### GameMediaStoreInput  

<table>
    <thead>
        <tr>
            <th colspan="2" align="left">Field</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>url</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>type</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>is_main</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### GameMediaUpdateInput  

<table>
    <thead>
        <tr>
            <th colspan="2" align="left">Field</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>url</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>type</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>is_main</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### GamePlatformStoreInput  

<table>
    <thead>
        <tr>
            <th colspan="2" align="left">Field</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>name</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>description</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>short</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>manufacturer</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>cpu</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>memory</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>graphics</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>sound</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>display</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>max_controllers</strong></td>
            <td valign="top"><a href="#int">Int</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>thegamesdb_rating</strong></td>
            <td valign="top"><a href="#float">Float</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>released_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>medias</strong></td>
            <td valign="top">[<a href="#id">ID</a>]</td>
            <td></td>
        </tr>
    </tbody>
</table>

### GamePlatformUpdateInput  

<table>
    <thead>
        <tr>
            <th colspan="2" align="left">Field</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>name</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>description</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>short</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>manufacturer</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>cpu</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>memory</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>graphics</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>sound</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>display</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>max_controllers</strong></td>
            <td valign="top"><a href="#int">Int</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>thegamesdb_rating</strong></td>
            <td valign="top"><a href="#float">Float</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>released_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>medias</strong></td>
            <td valign="top">[<a href="#id">ID</a>]</td>
            <td></td>
        </tr>
    </tbody>
</table>

### GameRomStoreInput  

<table>
    <thead>
        <tr>
            <th colspan="2" align="left">Field</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>url</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>size</strong></td>
            <td valign="top"><a href="#int">Int</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>sha1_hash</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### GameRomUpdateInput  

<table>
    <thead>
        <tr>
            <th colspan="2" align="left">Field</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>url</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>size</strong></td>
            <td valign="top"><a href="#int">Int</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>sha1_hash</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### GameStoreInput  

<table>
    <thead>
        <tr>
            <th colspan="2" align="left">Field</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>name</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>description</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>esrb_level</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>locales</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>players</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>thegamesdb_rating</strong></td>
            <td valign="top"><a href="#float">Float</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>rom_url</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>editor_id</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>platform_id</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>released_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>tags</strong></td>
            <td valign="top">[<a href="#id">ID</a>]</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>medias</strong></td>
            <td valign="top">[<a href="#id">ID</a>]</td>
            <td></td>
        </tr>
    </tbody>
</table>

### GameTagStoreInput  

<table>
    <thead>
        <tr>
            <th colspan="2" align="left">Field</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>name</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>icon</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>description</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### GameTagUpdateInput  

<table>
    <thead>
        <tr>
            <th colspan="2" align="left">Field</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>name</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>description</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
    </tbody>
</table>

### GameUpdateInput  

<table>
    <thead>
        <tr>
            <th colspan="2" align="left">Field</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#id">ID</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>name</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>description</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>esrb_level</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>locales</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>players</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>thegamesdb_rating</strong></td>
            <td valign="top"><a href="#float">Float</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>rom_url</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>editor_id</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>platform_id</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>released_at</strong></td>
            <td valign="top"><a href="#datetime">datetime</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>tags</strong></td>
            <td valign="top">[<a href="#id">ID</a>]</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>medias</strong></td>
            <td valign="top">[<a href="#id">ID</a>]</td>
            <td></td>
        </tr>
    </tbody>
</table>

### PostInput  

<table>
    <thead>
        <tr>
            <th colspan="2" align="left">Field</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>name</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>description</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>content</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>image</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
    </tbody>
</table>

### ShopCategoryStoreInput  

<table>
    <thead>
        <tr>
            <th colspan="2" align="left">Field</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>title</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>is_customizable</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>locale</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
    </tbody>
</table>

### ShopCategoryUpdateInput  

<table>
    <thead>
        <tr>
            <th colspan="2" align="left">Field</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>title</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>is_customizable</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>locale</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>order</strong></td>
            <td valign="top"><a href="#int">Int</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### ShopCategoryUpdateOrderInput  

<table>
    <thead>
        <tr>
            <th colspan="2" align="left">Field</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>order</strong></td>
            <td valign="top"><a href="#int">Int</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### ShopImageStoreInput  

<table>
    <thead>
        <tr>
            <th colspan="2" align="left">Field</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>url</strong></td>
            <td valign="top"><a href="#url">url</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>is_main</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a>!</td>
            <td></td>
        </tr>
    </tbody>
</table>

### ShopImageUpdateInput  

<table>
    <thead>
        <tr>
            <th colspan="2" align="left">Field</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>url</strong></td>
            <td valign="top"><a href="#url">url</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>is_main</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a>!</td>
            <td></td>
        </tr>
    </tbody>
</table>

### ShopItemStoreInput  

<table>
    <thead>
        <tr>
            <th colspan="2" align="left">Field</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>title</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>identifier</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>description_short</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>description_long</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>show_version</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>price</strong></td>
            <td valign="top"><a href="#float">float</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>weight</strong></td>
            <td valign="top"><a href="#float">float</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>image</strong></td>
            <td valign="top"><a href="#url">url</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>version</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>allow_indexing</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>category_id</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>images</strong></td>
            <td valign="top">[<a href="#shopimagestoreinput">ShopImageStoreInput</a>]</td>
            <td></td>
        </tr>
    </tbody>
</table>

### ShopItemUpdateInput  

<table>
    <thead>
        <tr>
            <th colspan="2" align="left">Field</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>title</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>description_short</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>description_long</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>show_version</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>price</strong></td>
            <td valign="top"><a href="#float">float</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>identifier</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>weight</strong></td>
            <td valign="top"><a href="#float">float</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>image</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>version</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>allow_indexing</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>category_id</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>images</strong></td>
            <td valign="top">[<a href="#shopimageupdateinput">ShopImageUpdateInput</a>]</td>
            <td></td>
        </tr>
    </tbody>
</table>

### ShopOrderUpdateInput  

<table>
    <thead>
        <tr>
            <th colspan="2" align="left">Field</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>shipping_id</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>status</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>bill_url</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

### UserUpdateInput  

<table>
    <thead>
        <tr>
            <th colspan="2" align="left">Field</th>
            <th align="left">Type</th>
            <th align="left">Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" valign="top"><strong>id</strong></td>
            <td valign="top"><a href="#string">String</a>!</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>is_admin</strong></td>
            <td valign="top"><a href="#boolean">Boolean</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>first_name</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>last_name</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>address_first_line</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>address_second_line</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>address_postal_code</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>address_city</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" valign="top"><strong>address_country</strong></td>
            <td valign="top"><a href="#string">String</a></td>
            <td></td>
        </tr>
    </tbody>
</table>

## Scalars  

### Boolean  

The `Boolean` scalar type represents `true` or `false`.

### Float  

The `Float` scalar type represents signed double-precision fractional
values as specified by
[IEEE 754](http://en.wikipedia.org/wiki/IEEE_floating_point). 

### ID  

The `ID` scalar type represents a unique identifier, often used to
refetch an object or as key for a cache. The ID type appears in a JSON
response as a String; however, it is not intended to be human-readable.
When expected as an input type, any string (such as `"4"`) or integer
(such as `4`) input value will be accepted as an ID.

### Int  

The `Int` scalar type represents non-fractional signed whole numeric
values. Int can represent values between -(2^31) and 2^31 - 1. 

### String  

The `String` scalar type represents textual data, represented as UTF-8
character sequences. The String type is most often used by GraphQL to
represent free-form human-readable text.