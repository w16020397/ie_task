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

use Symfony\Component\HttpKernel\KernelInterface;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

use App\Classes\Staff\PaymentDates;

class GenerateCSV extends Command
{
    protected static $defaultName = "app:generate-csv";
    private string $outputDirectory;
    private PaymentDates $paymentDates;
    private KernelInterface $kernel;
    private Serializer $serializer;
    private Filesystem $filesystem;

    public function __construct(KernelInterface $kernel)
    {
        parent::__construct();

        $this->kernel = $kernel;
        $this->serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
        $this->filesystem = new Filesystem();
        $this->paymentDates = new PaymentDates();
    }

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
        /* If an output directory location is not specified, we will write the csv file
        to the var/ directory.*/
        $this->outputDirectory = ($input->getArgument('output_directory')) ? $input->getArgument('output_directory') : $this->kernel->getProjectDir() . '/var/';

        if(!is_dir($this->outputDirectory))
        {
            $output->writeln("<error>Output directory ({$this->outputDirectory}) does not exist.</error>");

            return Command::FAILURE;
        }

        $paymentDates = $this->serializer->encode($this->paymentDates->generate(), 'csv', [
            CsvEncoder::NO_HEADERS_KEY => 'no_headers'
        ]);

        try {
            $fileName = $this->outputDirectory . "dates.csv";

            if($this->filesystem->exists($fileName))
            {
                $this->filesystem->remove($fileName);
            }

            $this->filesystem->dumpFile($fileName, $paymentDates);
        } catch (IOExceptionInterface $exception) {
            echo "An error occurred while creating your directory at " . $exception->getPath();
        }

        return Command::SUCCESS;
    }
}