<?php

namespace IMDb\Command;

use Cilex\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use IMDb\Client\Client as IMDbClient;

class FetchCommand extends Command
{
    /**
     * @var IMDbClient $IMDb
     */
    var $IMDb;
    var $logger;

    public function __construct($name = null)
    {
        $this->IMDb     = new IMDbClient;
        $this->logger   = $this->getApplication()['monolog'];

        return parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setName('imdb:fetch')
            ->setDescription('fetch all userlists');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = $this->IMDb;
        $id = 'MVUwZ28TV6A';

        var_dump($client->getList($id));
    }
}
