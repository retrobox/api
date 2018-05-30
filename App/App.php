<?php
namespace App;

use DI\ContainerBuilder;

class App extends \DI\Bridge\Slim\App
{
	protected $bundles = [];
	protected $hasBundles = false;
	protected $twigPaths= ['../App/views'];

	protected function configureContainer(ContainerBuilder $builder)
	{
		$builder->addDefinitions(__DIR__ . '/config/app.php');
		$builder->addDefinitions(__DIR__ . '/config/api.php');
		$builder->addDefinitions(__DIR__ . '/config/database.php');
		$builder->addDefinitions(__DIR__ . '/config/containers.php');
	}

	public function getBundles(){
		return [
			//\App\AdminBundle\AdminBundle::class,
		];
	}
}
