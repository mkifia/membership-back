<?php

namespace App\Command;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception as ReaderException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Exception\RuntimeException;

#[AsCommand(
    name: 'app:read-contributions',
    description: 'Add a short description for your command',
    aliases: ['app:read-contrib'],
    hidden: false
)]
class ReadContributionsCommand extends Command
{
    protected function configure()
    {
        $this
            ->setDescription('Reads a XLSX file and retrieves members who paid their contribution fee from 2007 to now.')
            ->addArgument('path', InputArgument::REQUIRED, 'The path to the XLSX file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $path = $input->getArgument('path');

        try {
            $spreadsheet = IOFactory::load($path);
        } catch (ReaderException $e) {
            throw new RuntimeException("Error reading the XLSX file: " . $e->getMessage());
        }

        $sheet = $spreadsheet->getActiveSheet();
        $head = [];
        $paymentYears = [];

        foreach ($sheet->getRowIterator() as $row) {

            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            $memberData = [];
            foreach ($cellIterator as $cell) {
                $memberData[] = $cell->getValue();
            }

            if ($row->getRowIndex() === 1) {
                $head = $memberData;

                continue;
            }

            $paymentYears = array_combine($head, $memberData);

            // Process member data
            if ($this->hasPaidContribution($paymentYears)) {
                // Output or store the member data
                $output->writeln("Member {$paymentYears['lastname']} {$paymentYears['firstname']} has paid their contributions.");
            }

            if ($row->getRowIndex() === 35) {
                break;
            }
        }

        return Command::SUCCESS;
    }

    private function hasPaidContribution(array $paymentYears): bool
    {
        // Assuming payments data start from column index 4 (column E)
        foreach ($paymentYears as $year => $paymentYear) {
            dump($year);
            if ($paymentYear) {
                if (str_contains('√', $paymentYear)) {
                    return true;
                }
            }
        }
        return false;
    }
}
