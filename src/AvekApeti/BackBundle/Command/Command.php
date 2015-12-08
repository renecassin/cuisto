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

class Command extends ContainerAwareCommand
{
private $commandes = array(
        array('command' => 'doctrine:database:create'),
         //   'message' => 'Creation base de données'),
        array('command' => 'doctrine:schema:update',
         //   'message' => 'Mise a jour base de données',
        '--force' => true),
        array('command' => 'assets:install'),
         //   'message' => 'Installation des assets'),
        array('command' => 'cache:clear',
        //    'message' => 'Suppresion cache dev',
        ' --env'=>'dev'),
        array('command' => 'cache:clear',
        //    'message' => 'Creation base de données',
        '--env'=>'prod --no-debug')
        );

    private $isErrored = false;

    protected function configure()
    {
        $this->setName('avekapeti:install')
            ->setDescription('Creation de la base de données et des presrequis');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $output->writeln('<info>Installing Avekapeti...</info>');
        $output->writeln('');

       // $this->ensureDirectoryExistsAndIsWritable(self::APP_CACHE, $output);
        $app = $this->getApplication();
        $app->setAutoExit(false);
        foreach ($this->commandes as $step => $command) {
            try {
                $output->writeln(sprintf('<comment>Step %d of %d.</comment> <info>%s</info>', $step+1, count($this->commandes), $step));
                //$this->commandExecutor->runCommand('avekapeti:install:'.$command['command'], array(), $output);
                //$app->add();
               // $app->run(new ArrayInput($command),$output);
                $returnCode = $app->run(new ArrayInput($command),$output);
                //$output->writeln($output);
            } catch (RuntimeException $exception) {
                $this->isErrored = true;

                continue;
            }
        }


        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $groupe = $em->getRepository("AvekApetiBackBundle:Groupe")
            ->findOneByRole('ROLE_GOURMET');
        if(!ISSET($groupe))
        {
            $output->writeln(sprintf("Creation des droits"));
            $groupe = new Groupe();
            $groupe1 = new Groupe();
            $groupe2 = new Groupe();
            $groupe->setName('gourmet');
            $groupe1->setName('chef');
            $groupe2->setName('admin');
            $groupe->setRole('ROLE_GOURMET');
            $groupe1->setRole('ROLE_CHEF');
            $groupe2->setRole('ROLE_SUPER_ADMIN');

            $em->persist($groupe);
            $em->persist($groupe1);
            $em->persist($groupe2);
            $em->flush();

            $output->writeln(sprintf("Creation des admin"));

            $Groupe =$em->getRepository("AvekApetiBackBundle:Groupe")
                ->findOneByRole('ROLE_SUPER_ADMIN');

            $user = new Utilisateur();
            $user->setPassword('admin');
            $user->setEmail('admin@admin');
            $user->setLogin('Admin');
            $user->setPhone('Admin');
            $user->setGroupe($Groupe);

            $factory = $this->getContainer()->get('security.encoder_factory');

            $hash = $factory->getEncoder($user)->encodePassword($user->getPassword(),$user->getSalt());

            $user->setPassword($hash);
            $em->persist($user);
            $em->flush();
        }



        $output->writeln($this->getProperFinalMessage());
    }

    /**
     * @return string
     */
    private function getProperFinalMessage()
    {
        if ($this->isErrored) {
            return '<info>Avekapeti has been installed, but some error occurred.</info>';
        }

        return '<info>Avekapeti has been successfully installed.</info>';
    }

}