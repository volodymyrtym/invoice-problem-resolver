<?php

declare(strict_types=1);

namespace App\User\UseCase\ResetPassword;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Uid\UuidV6;

#[AsCommand(
    name: 'app:user:reset-password',
    description: 'Generates a password hash using the configured password hasher.',
)]
class ResetPasswordConsole extends Command
{
    public function __construct(private readonly ResetPasswordHandler $handler)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('password', InputArgument::REQUIRED, 'The plain password to hash')
            ->addArgument('user', InputArgument::REQUIRED, 'user id')
            ->setHelp('app:user:reset-password 123456 2120b87d-449b-41ae-8526-1e50b3dd060b');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->handler->handle(
            new ResetPasswordCommand(
                newPassword: $input->getArgument('password'),
                userId: $input->getArgument('user'),
            ),
        );

        $output->writeln('password changed');

        return Command::SUCCESS;
    }
}
