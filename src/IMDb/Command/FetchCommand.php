<?php

namespace IMDb\Command;

use Cilex\Application;
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

    /**
     * @var
     */
    var $logger;

    /**
     * @var \Doctrine\DBAL\Connection $db
     */
    var $db;

    /**
     * @var array $lists
     */
    var $lists = array();

    /**
     * @param null|string $name
     * @param Application $app
     */
    public function __construct($name, Application $app)
    {
        $this->IMDb     = new IMDbClient;
        $this->logger   = $app['monolog'];
        $this->db       = $app['db'];
        $this->lists    = $app['lists'];

        if (!file_exists((string) $this->db->getDatabase())) {
            $this->createDb();
        }

        return parent::__construct($name);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('imdb:fetch')
            ->setDescription('fetch all userlists');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = $this->IMDb;

        foreach ($this->lists as $list) {
            $this->logger->info($list);
            $lists[$list] = $client->getList($list);
        }

        var_dump($lists);
    }

    /**
     * @param array $data
     * @return int
     */
    protected function insertIntoDB(array $data = array())
    {
        return $this->db->insert('test', $data);
    }

    /**
     * @return \Doctrine\DBAL\Doctrine\DBAL\Driver\Statement
     */
    protected function createDb()
    {
       return $this->db->executeQuery('CREATE TABLE IF NOT EXISTS test (id INTEGER PRIMARY KEY AUTOINCREMENT, list INTEGER NOT NULL, title CHAR(256), UNIQUE (id))');

    }
}
