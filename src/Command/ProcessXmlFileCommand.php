<?php

namespace App\Command;

use App\Entity\XmlData;
use App\Repository\XmlDataRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;

#[AsCommand(
    name: 'app:processXmlFile',
    description: 'This Command processes local XML files to the database.',
)]
class ProcessXmlFileCommand extends Command
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly SerializerInterface $serializer,
        private readonly EntityManagerInterface $em,
        private readonly XmlDataRepository $xmlDataRepository
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('filePath',
        InputArgument::OPTIONAL, 'Please enter a valid relative path or uri to the xml file, that should be stored to the database');
        $this->addOption('truncate');
        $this->setHelp('Local paths are always assigned from the root level of the project. A uri has to be linked to a valid xml file in the following structure: schema://host/path/filename.xml');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Process a local xml file to your database');

        if(empty($input->getArgument('filePath'))) {
            $pathToFile = $io->ask('Please enter a valid relative path or an uri to the xml file, that should be stored to the database');
        } else {
            $pathToFile = $input->getArgument('filePath');
        }
        
        if(filter_var($pathToFile, FILTER_VALIDATE_URL)) {
            try {
                $fileContent = file_get_contents($pathToFile);
            } catch (\Exception $e) {
                $this->logger->error("The xml file couldn't be downloaded with the given uri path: $pathToFile.");
                $io->error('The xml file could not be downloaded. The requested file was not found.');
                return Command::FAILURE;
            }

            if(empty($fileContent)) {
                $this->logger->error("The xml file couldn't be downloaded with the given uri path: $pathToFile.");
                $io->error('The xml file could not be downloaded. The requested file was not found.');
                return Command::FAILURE;
            }
        } else {
            $filesystem = new Filesystem();
            if(!$filesystem->exists($pathToFile)) {
                $this->logger->error("The xml file couldn't be found with the given relative local path: $pathToFile");
                $io->error('The xml file could not be downloaded. The requested file was not found.');
                return Command::FAILURE;
            }
            $fileContent = $filesystem->readFile($pathToFile);
        }

        // Check, if XML-Content is valid
        try {
            $data = $this->serializer->decode($fileContent, 'xml');
        } catch (NotEncodableValueException $e) {
            $this->logger->error(
                'The xml file could not be loaded, because of the following error in the xml file: ' . $e->getMessage()
            );
            $io->error('The xml file could not be processed to the database, because of an error of the xml file structure.');
            return Command::FAILURE;
        }

        if($input->getOption('truncate')) {
            $io->writeln('Truncating existing database entries.');
            $this->xmlDataRepository->truncateEntries();

            $relevantData = $data['item'];
        } else {
            $storedXmLDataIds = $this->xmlDataRepository->getEntityIds();
            $dataIds = array_map(fn($id) => intval($id) ,array_column($data['item'], 'entity_id'));

            $relevantIds = array_diff($dataIds, $storedXmLDataIds);

            if(empty($relevantIds)) {
                $this->logger->error(
                    'The xml file was not processed to your database because of duplicated content. The processed xml file has already been uploaded to your database.'
                );
                $io->error('The xml file was not processed to your database because of duplicated content.');
                return Command::FAILURE;
            }

            if(count($relevantIds) === count($data['item'])) {
                $relevantData = $data['item'];
            } else {
                $relevantData = array_filter($data['item'], fn($item) => in_array($item['entity_id'], $relevantIds));
            }
        }

        $dataItemsNum = count($relevantData);

        $io->writeln("$dataItemsNum relevant items detected in the xml file. Trying to store the data to database.");
        $io->progressStart($dataItemsNum);

        foreach ($relevantData as $item) {
            try {
                $xmlDataItem = new XmlData();
                $xmlDataItem->setEntityId($item['entity_id']);
                $xmlDataItem->setCategoryName($item['name']);
                $xmlDataItem->setSku($item['sku']);
                $xmlDataItem->setName($item['name']);
                $xmlDataItem->setDescription($item['description']);
                $xmlDataItem->setShortdesc($item['shortdesc']);
                $xmlDataItem->setPrice($item['price']);
                $xmlDataItem->setLink($item['link']);
                $xmlDataItem->setImage($item['image']);
                $xmlDataItem->setBrand($item['Brand']);
                $xmlDataItem->setRating($item['Rating']);
                $xmlDataItem->setCaffeineType($item['CaffeineType']);
                $xmlDataItem->setCount($item['Count']);
                $xmlDataItem->setFlavored($item['Flavored']);
                $xmlDataItem->setSeasonal($item['Seasonal']);
                $xmlDataItem->setInstock($item['Instock']);
                $xmlDataItem->setFacebook($item['Facebook']);
                $xmlDataItem->setIsCup($item['IsKCup']);
            } catch(\Exception $e) {
                $this->logger->error('Some data was not processed to the database, because of the following error:' . $e->getMessage());
                $io->error('Some data was not processed to the database');
                return Command::FAILURE;
            }

            $this->em->persist($xmlDataItem);
            $io->progressAdvance();
        }

        $io->progressFinish();
        $this->em->flush();

        $io->success("Your xml data has successfully been stored to the database. $dataItemsNum have been uploaded.");

        return Command::SUCCESS;
    }
}
