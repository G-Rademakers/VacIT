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
       
        
        for($row = 2; $row < 6 ; $row++)
        {   
            $s = $spreadsheet->getActiveSheet();
            $username = $s->getCell('A' . $row)->getValue();
            $email = $s->getCell('B' . $row)->getValue();
            $password = $s->getCell('C' . $row)->getValue();
            $roles = $s->getCell('D' . $row)->getValue();
            $firstname = $s->getCell('E' . $row)->getValue();
            $lastname = $s->getCell('F' .$row)->getValue();
            $companyname = $s->getCell('G' . $row)->getValue();
            $address = $s->getCell('H' . $row)->getValue();
            $zipcode = $s->getCell('I' . $row)->getValue();
            $city = $s->getCell('J' . $row)->getValue();
            $phone = $s->getCell('K' . $row)->getValue();
            $description = $s->getCell('L' . $row)->getValue();
            $profilepicture = $s->getCell('M' . $row)->getValue();
            $type = $s->getCell('N' . $row)->getValue();
                           
            $params[] = array(
                "username" => $username,
                "email" => $email,
                "password" => $password,
                "roles" => $roles,
                "first_name" => $firstname,
                "last_name" => $lastname,
                "company_name" => $companyname,
                "address" => $address,
                "zipcode" => $zipcode,
                "city" => $city,
                "phone_number" => $phone,
                "description" => $description,
                "profile_picture_url" => $profilepicture,
                "type" => $type
            ); 
            
            $users = $this->us->createUser($params);
            dump($users);
            die();
        }
      
       
    }   
}