<?php


namespace SoftUniBlogBundle\Command;


use SoftUniBlogBundle\Entity\Hero;
use SoftUniBlogBundle\Service\Heroes\HeroServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Tests\Input\InputDefinitionTest;

class HealthRegenCommand extends Command
{

    /**
     * @var HeroServiceInterface $heroService
     */
    private $heroService;

    /**
     * HealthRegenCommand constructor.
     * @param HeroServiceInterface $heroService
     */
    public function __construct(HeroServiceInterface $heroService)
    {

        parent::__construct();
        $this->heroService = $heroService;
    }



    protected function configure()
    {

       $this->setDefinition(
           [
                new InputArgument('is-cron',InputArgument::OPTIONAL,'Cron for update current health', true)
           ]
       );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {


        $heroes  = $this->heroService->findAllDamagedHeroes();

        foreach ($heroes as $heroArr) {
            /**
             * @var Hero $hero
             */
            $hero = $this->heroService->findOneById($heroArr['id']);
            $hero->setCurrentHealth($hero->getCurrentHealth()+10);

            if ($this->heroService->edit($hero)){
                $output->writeln('The heroes are updated!');
            };
        }



    }


    public function getName()
    {
        return 'update:currentHealth';
    }


}
