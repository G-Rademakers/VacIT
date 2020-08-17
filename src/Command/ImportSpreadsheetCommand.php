<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\ArrayInput;
use App\Service\ImportSpreadsheetService;

use PhpOffice\PhpSpreadsheet\Reader\xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportSpreadsheetCommand extends Command
{
    private $spreadsheet;

    public function __construct(ImportSpreadsheetService $spreadsheet)
    {
        parent::__construct();
        $this->spreadsheet = $spreadsheet;
    }

    protected function configure()
    {
        $this
            ->setName('app:import-spreadsheet')
            ->setDescription('Import Excel Spreadsheet containing employer data')
            ->setHelp('This command allows you to import a spreadsheet')
            ->addArgument('file', InputArgument::REQUIRED, 'Spreadsheet')
        ;
    }

    protected function execute(InputInterface $input,
                               OutputInterface $output)
    {
        $inputFileName = $input->getArgument('file');

        $spreadsheet = IOFactory::load($inputFileName);

        for ($row = 2; $row < 6; $row++)
        {
                $s = $spreadsheet->getActiveSheet();

                $params[] = array(
                    "username" => $s->getCell('A'.$row)->getValue(),
                    "email" => $s->getCell('B'.$row)->getValue(),
                    "password" => $s->getCell('C'.$row)->getValue(),
                    "roles" => $s->getCell('D'.$row)->getValue(),
                    "first_name" => $s->getCell('E'.$row)->getValue(),
                    "last_name" => $s->getCell('F'.$row)->getValue(),
                    "company_name" => $s->getCell('G'.$row)->getValue(),
                    "address" => $s->getCell('H'.$row)->getValue(),
                    "zipcode" => $s->getCell('I'.$row)->getValue(),
                    "city" => $s->getCell('J'.$row)->getValue(),
                    "phone_number" => $s->getCell('K'.$row)->getValue(),
                    "description" => $s->getCell('L'.$row)->getValue(),
                    "profile_picture" => $s->getCell('M'.$row)->getValue(),
                    "type" => $s->getCell('N'.$row)->getValue()
                );

        }

        $users = $this->spreadsheet->ImportSpreadsheet($params);
    }
}