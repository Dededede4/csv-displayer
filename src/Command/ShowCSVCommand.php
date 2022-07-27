<?php

namespace App\Command;

use Dededede4\CsvDisplayer\Downloader\Downloader;
use Dededede4\CsvDisplayer\Providers\ProductsProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ShowCSVCommand extends Command
{
    private Downloader $downloader;
    private ProductsProvider $productsProvider;

    public function __construct(string $name = null)
    {
        parent::__construct($name);
    }

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'csvdisplayer:display';

    protected function configure(): void
    {
        $this
            ->setDescription('Montre les datas du CSV.')
            ->setHelp('Cette commande montre les datas du CSV')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $downloader = new Downloader(new ProductsProvider());
        $table = new Table($output);
        $table
            ->setHeaders($downloader->getHeaders())
            ->setRows($downloader->getRows())
        ;
        $table->render();

        return 0;
    }
}