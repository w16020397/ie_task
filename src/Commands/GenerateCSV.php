<?php

/**
 * A command to generate a csv file containing dates for when basic salary and salary bonus' are paid.
 * 
 * @author Michael Sumner <michaelchrissumner@gmail.com>
 * @version 0.1 
 */

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCSV extends Command
{
    protected static $defaultName = "app:generate-csv";
    private string | null $outputDirectory;

    /**
     * Configure basic information about the generate-csv command.
     */
    protected function configure(): void
    {
        $this
            ->setDescription('Generates a CSV file detailing staff payment dates.')
            ->setHelp('This command allows you to generate a CSV file detailing the payment dates for the next 12 month period.')
            ->addArgument('output_directory', InputArgument::OPTIONAL, 'Do you want to output to a specific directory?');
    }

    /**
     * Creates a csv file containing payment dates for the next 12 months.
     * 
     * @param InputInterface $input An interface to the input provided to the command.
     * @param OutputInterface $output An interface for providing an output from our function.
     * 
     * @return int 0 if successful 1 if unsuccessful.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->outputDirectory = $input->getArgument('output_directory');

        return Command::SUCCESS;
    }
}