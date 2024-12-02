<?php

declare(strict_types=1);

namespace App\User\UseCase\CreateUser;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

#[AsCommand(
    name: 'app:user:create',
    description: 'Creates user',
)]
class CreateConsole extends Command
{
    public function __construct(private readonly CreateHandler $handler)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');
        $emailQuestion = new Question('User email: ');
        $email = $helper->ask($input, $output, $emailQuestion);
        $passwordQuestion = new Question('User password: ');
        $password = $helper->ask($input, $output, $passwordQuestion);

        $createdId = $this->handler->handle(
            new CreateCommand(
                password: $password,
                email: $email,
            ),
        );

        $output->writeln('User created. ID: '.$createdId);

        return Command::SUCCESS;
    }
}
