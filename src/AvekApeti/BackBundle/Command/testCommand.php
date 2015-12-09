<?php

namespace AvekApeti\BackBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;
use AvekApeti\BackBundle\Entity\Groupe;
use AvekApeti\BackBundle\Entity\Utilisateur;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Application;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sylius\Bundle\CoreBundle\Kernel\Kernel;
use Symfony\Component\Process\Exception\RuntimeException;

class Command2 extends ContainerAwareCommand
{


    private $isErrored = false;

    protected function configure()
    {
        $this->setName('test:exe')
            ->setDescription('Creation de la base de données et des presrequis');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $this->getContainer->setParameter('maintenance', 'true');

    }


}