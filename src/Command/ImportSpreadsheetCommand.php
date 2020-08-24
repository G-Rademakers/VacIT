<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\ArrayInput;

use App\Service\UserService;

use PhpOffice\PhpSpreadsheet\Reader\xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportSpreadsheetCommand extends Command
{
    private $us;

    public function __construct(UserService $us)
    {
        parent:: __construct();
        $this->us = $us;
    }

    protected function configure()
    {
        $this
            ->setName('app:import-spreadsheet')
            ->setDescription('Import Excel Spreadsheet containing employer data')
            ->setHelp('This command allows you to import a spreadsheet')
            ->addArgument('file', InputArgument::REQUIRED, 'Spreadsheet');
    }

    protected function execute(InputInterface $input,
                               OutputInterface $output)
    {
        $inputFileName = $input->getArgument('file');
        $spreadsheet = IOFactory::load($inputFileName);
        
        for($row=2; $row<5 ; $row++)
        {  
            $s = $spreadsheet->getActiveSheet();

            $username = $s->getCell('A' . $row)->getValue();
            $email = $s->getCell('B' . $row)->getValue();
            $password = $s->getCell('C' . $row)->getValue();
            $roles = $s->getCell('D' . $row)->getValue();
                
            $params[] = array(
                "username" => $username,
                "email" => $email,
                "password" => $password,
                "roles" => $roles
            );
        }
      
        $users = $this->us->createUser($params);
        dump($users);
        die();
    }   
}