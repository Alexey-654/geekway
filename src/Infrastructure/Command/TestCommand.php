<?php

namespace App\Infrastructure\Command;

use App\Infrastructure\Repository\ProductRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:test', description: 'Custom manual tests')]
class TestCommand extends Command
{
    private ProductRepository $repo;

    /**
     * @param $repo
     */
    public function __construct(ProductRepository $repo)
    {
        $this->repo = $repo;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $product = $this->repo->find(9)->getDiscount();

        return Command::SUCCESS;
    }
}
