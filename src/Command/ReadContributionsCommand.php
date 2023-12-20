<?php

namespace App\Command;

use App\Entity\Fee;
use App\Entity\Member;
use App\Factory\MemberFactory;
use App\Factory\PaymentFactory;
use App\Factory\TeamFactory;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception as ReaderException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Symfony\Component\Uid\Factory\UuidFactory;

#[AsCommand(
    name: 'app:read-contributions',
    description: 'Add a short description for your command',
    aliases: ['app:read-contrib'],
    hidden: false
)]
class ReadContributionsCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $manager,
        private PasswordHasherFactoryInterface $passwordHasherFactory,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setDescription(
                'Reads a XLSX file and retrieves members who paid their contribution fee from 2007 to now.'
            )
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

        $index = 1;

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
            $this->hasPaidContribution($paymentYears, $index, $output);

            $index++;
            if ($row->getRowIndex() === 623) {
                break;
            }
        }

        return Command::SUCCESS;
    }

    private function hasPaidContribution(array $paymentYears, $index, $output): void
    {
        $teamNumber = $paymentYears['team_number'];
        $firstName = $paymentYears['firstname'];
        $lastName = $paymentYears['lastname'];

        $team = TeamFactory::findOrCreate([
            'number' =>  "isd_team_$teamNumber",
        ]);

        $member = MemberFactory::findOrCreate([
            'number' => "isd_member_$index",
            'firstName' => $firstName,
            'lastName' => $lastName,
            'team' => $team
        ]);

        $feeRepo = $this->manager->getRepository(Fee::class);
        // Assuming payments data start from column index 4 (column E)
        foreach ($paymentYears as $year => $paymentYear) {
            /** @var Fee $fee */
            $fee = $feeRepo->findOneBy(['year' => (int) $year]);

            if ($paymentYear && $fee) {
                if (str_contains('√', $paymentYear) || str_contains('25', $paymentYear)) {
                    PaymentFactory::createOne([
                        'amount' => str_contains('25', $paymentYear) ? $fee->getAmount() / 2 : $fee->getAmount(),
                        'member' => $member
                    ]);
                }
            }
        }

        $output->writeln(
            "Member {$member->getLastName()} {$member->getFirstName()} {$member->getNumber()} team  {$team->getNumber()} has checked}."
        );
        $this->manager->flush();
    }
}
