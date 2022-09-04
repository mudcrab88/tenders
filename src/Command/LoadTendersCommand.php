<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\TenderService;
use App\DataTransferObject\TenderDTO;

class LoadTendersCommand extends Command
{
    protected static $defaultName = 'app:load-tenders';

    protected static $defaultDescription = 'Add a short description for your command';

    protected TenderService $service;

    public function __construct(TenderService $service)
    {
        $this->service = $service;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('filename', InputArgument::REQUIRED, 'CSV file name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg = $input->getArgument('filename');

        if ($arg) {
            $csv = fopen($arg, "r");

            if ($csv) {
                try {
                    $this->parseFile($csv, $output);
                } catch (\Throwable $e) {
                    $io->error(sprintf("Произошла ошибка во время разбора файла: %s", $e->getMessage()));

                    return Command::FAILURE;
                }
            } else {
                $io->error(sprintf("Ошибка при открытии файла %s!", $arg));

                return Command::FAILURE;
            }
        }

        $io->success(sprintf("Файл %s успешно обработан.", $arg));

        return Command::SUCCESS;
    }

    protected function parseFile($file, OutputInterface $output): void
    {
        $i = 0;

        while (($data = fgetcsv($file)) !== false) {
            if ($i > 0) {
                $dto = TenderDTO::fromArray($data);

                $this->service->createFromDto($dto);
            }

            $i++;
        }

        fclose($file);
    }
}
