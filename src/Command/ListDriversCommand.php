<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'app:list-drivers',
    description: 'List all drivers',
)]
final class ListDriversCommand extends Command
{
    public function __construct(
        private readonly HttpClientInterface $openF1Client,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        dd($this->openF1Client->request('GET', '/v1/drivers?session_key=9158')->toArray());

        return Command::SUCCESS;
    }
}
