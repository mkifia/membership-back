<?php
declare(strict_types=1);

namespace App\Command;

use App\Entity\Admin;
use App\Entity\Fee;
use App\Factory\AddressFactory;
use App\Factory\FeeFactory;
use App\Factory\MemberFactory;
use App\Factory\PaymentFactory;
use App\Factory\TeamFactory;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:import:payments',
    description: 'Import payments from xls file with creating members and teams',
    aliases: ['app:read-contrib', 'app:import:member-payments'],
    hidden: false
)]
class ImportPaymentsCommand extends Command
{
    /**
     * @param EntityManagerInterface $manager
     * @param string|null $name
     */
    public function __construct(
        private readonly EntityManagerInterface $manager,
        string $name = null
    ) {
        parent::__construct($name);
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->setDescription(
                'Reads a XLSX file and retrieves members who paid their contribution fee from 2007 to now.'
            )
            ->addArgument('path', InputArgument::REQUIRED, 'The path to the XLSX file');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $path = $input->getArgument('path');

        $spreadsheet = IOFactory::load($path);

        $sheet = $spreadsheet->getActiveSheet();
        $head = [];

        $output->writeln(
            'STARTING...'
        );
        $index = 1;
        foreach ($sheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            $memberData = [];
            foreach ($cellIterator as $cell) {
                if ($cell->getColumn() === 'U' && $cell->getValue() === '2025') {
                    break;
                }

                $memberData[] = $cell->getValue();
            }

            if (1 === $row->getRowIndex()) {
                $head = $memberData;

                continue;
            }

            $paymentYears = array_combine($head, $memberData);

            // Process member data
            $this->importPayments($paymentYears, $index, $output);

            ++$index;
            if (623 === $row->getRowIndex()) {
                break;
            }
        }
        $output->writeln(
            'FINISHED!'
        );

        return Command::SUCCESS;
    }

    /**
     * @param array<string> $paymentYears
     */
    private function importPayments(array $paymentYears, int $index, OutputInterface $output): void
    {
        $teamNumber = $paymentYears['team_number'];
        $firstName = $paymentYears['first_name'];
        $lastName = $paymentYears['last_name'];

        FeeFactory::createSequence(function () {
            return [
                ['year' => 2007, 'amount' => 50, 'discount' => 50, 'currency' => 'EUR'],
                ['year' => 2008, 'amount' => 50, 'discount' => 50, 'currency' => 'EUR'],
                ['year' => 2009, 'amount' => 50, 'discount' => 50, 'currency' => 'EUR'],
                ['year' => 2010, 'amount' => 50, 'discount' => 50, 'currency' => 'EUR'],
                ['year' => 2011, 'amount' => 25, 'discount' => 50, 'currency' => 'EUR'],
                ['year' => 2012, 'amount' => 50, 'discount' => 50, 'currency' => 'EUR'],
                ['year' => 2013, 'amount' => 50, 'discount' => 50, 'currency' => 'EUR'],
                ['year' => 2014, 'amount' => 50, 'discount' => 50, 'currency' => 'EUR'],
                ['year' => 2015, 'amount' => 50, 'discount' => 50, 'currency' => 'EUR'],
                ['year' => 2016, 'amount' => 50, 'discount' => 50, 'currency' => 'EUR'],
                ['year' => 2017, 'amount' => 0, 'discount' => 50, 'currency' => 'EUR'],
                ['year' => 2018, 'amount' => 50, 'discount' => 50, 'currency' => 'EUR'],
                ['year' => 2019, 'amount' => 50, 'discount' => 50, 'currency' => 'EUR'],
                ['year' => 2020, 'amount' => 50, 'discount' => 50, 'currency' => 'EUR'],
                ['year' => 2021, 'amount' => 50, 'discount' => 50, 'currency' => 'EUR'],
                ['year' => 2022, 'amount' => 50, 'discount' => 50, 'currency' => 'EUR'],
                ['year' => 2023, 'amount' => 50, 'discount' => 50, 'currency' => 'EUR'],
                ['year' => 2024, 'amount' => 50, 'discount' => 50, 'currency' => 'EUR'],
            ];
        });

        $team = TeamFactory::findOrCreate([
            'number' => "isd_team_$teamNumber",
            'name' => "ISD FAMILY #$teamNumber",
        ]);

        $member = MemberFactory::findOrCreate([
            'number' => "isd_member_$index",
            'firstName' => $firstName,
            'lastName' => $lastName,
            'address' => AddressFactory::new(),
            'team' => $team,
        ]);

        $admin = $this->manager->getRepository(Admin::class)->findAll()[0];

        $feeRepo = $this->manager->getRepository(Fee::class);
        foreach ($paymentYears as $year => $paymentYear) {
            $fee = $feeRepo->findOneBy(['year' => (int) $year]);
            if ($paymentYear && $fee) {
                $amount = $fee->getAmount();

                if (str_contains('25', $paymentYear)) {
                    $amount = $amount * (1 - $fee->getDiscount() / 100);
                }

                if (str_contains('√', $paymentYear) || str_contains('25', $paymentYear)) {
                    PaymentFactory::createOne([
                        'amount' => $amount,
                        'createdAt' => new \DateTimeImmutable(),
                        'member' => $member,
                        'updatedAt' => new \DateTimeImmutable(),
                        'year' => $year,
                        'addedBy' => $admin,
                        'validatedBy' => $admin,
                        'comment' => 'Imported from XLSX file',
                    ]);
                }
            }
        }

        $output->writeln(
            "Member {$member->getFullName()} {$member->getNumber()} from {$team->getNumber()} has checked."
        );
        $this->manager->flush();
    }
}
