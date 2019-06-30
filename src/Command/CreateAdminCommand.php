<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateAdminCommand extends Command
{
    protected static $defaultName = 'app:create:admin';

    private $entityManager;
    private $userPasswordEncoder;

    public function __construct(string $name = null, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $this->entityManager = $manager;
        $this->userPasswordEncoder = $encoder;

        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setDescription('Create an administrator user')
            ->setHelp('This command allow you to create a new admin user for the application');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        QuestionHelper::disableStty();

        $usernameQuestion = new Question("<info>Choose your username:</info>".PHP_EOL);
        $username = $helper->ask($input, $output, $usernameQuestion);

        $passwordQuestion = new Question("<info>Enter your password:</info>".PHP_EOL);
        $passwordQuestion
            ->setHidden(true)
            ->setHiddenFallback(false);
        $password = $helper->ask($input, $output, $passwordQuestion);

        $user = new User();
        $user
            ->setUsername(trim($username))
            ->setPassword($this->userPasswordEncoder->encodePassword($user, trim($password)))
            ->setRoles(['ROLE_ADMIN'])
        ;

        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $output->writeln("The user $username was created successfully, you can now logging in /login route");
        } catch (\Exception $e) {
            $output->writeln("<error>Unable to create user, try again: ".$e->getMessage()."</error>");
        }
    }
}
