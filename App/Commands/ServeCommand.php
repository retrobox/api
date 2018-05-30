<?php

namespace App\Commands;

use Exception;
use \Symfony\Component\Console\Command\Command;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Component\Console\Output\OutputInterface;
use \Symfony\Component\Console\Input\InputArgument;


class ServeCommand extends Command
{
	protected function configure()
	{
		$this->setName('serve')
			->setDescription('Run a php built in it development server on 8000 port')
			->addArgument('port', InputArgument::OPTIONAL, 'Listen port of your dev server')
			->addArgument('path', InputArgument::OPTIONAL, 'Root path of your dev server');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		if ($input->getArgument('path')) {
			$path = $input->getArgument('path');
		} else {
			$path = 'public/';
		}

		if ($input->getArgument('port')) {
			$port = $input->getArgument('port');
		} else {
			$port = 8000;
		}

		try {
			$output->writeln('Server listen on 127.0.0.1:' . $port);

			shell_exec('php -S localhost:' . $port . ' -d display_errors=1 -t ' . $path);

			$output->writeln('End of server!');
		} catch (\Exception $e) {
			$output->writeln('Error : ', $e->getMessage(), "\n");
		}

	}
}