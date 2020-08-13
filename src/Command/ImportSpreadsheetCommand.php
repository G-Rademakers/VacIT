<?php

namespace App\Command;

use PhpOffice\PhpSpreadsheet\Reader\xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportSpreadsheetCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('app:import-spreadsheet')
            ->setDescription('Import Excel Spreadsheet')
            ->setHelp('This command allows you to import a spreadsheet')
            ->addArgument('file', InputArgument::REQUIRED, 'Spreadsheet')
        ;
    }

    protected function execute(InputInterface $input,
                               OutputInterface $output)
    {
        $inputFileName = $input->getArgument('file');

        $spreadsheet = IOFactory::load($inputFileName);

        $s = $spreadsheet->getActiveSheet();

        $   

    }
}