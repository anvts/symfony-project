<?php

namespace App\Users\Application\Command\CreateUser;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Users\Domain\Factory\UserFactory;
use App\Users\Domain\Repository\UserRepositoryInterface;

class CreateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    /**
     * @return string User ID
     */
    public function __invoke(CreateUserCommand $createUserCommand): string
    {
        $user = (new UserFactory())->create($createUserCommand->email, $createUserCommand->password);
        $this->userRepository->add($user);

        return $user->getUlid();
    }
}