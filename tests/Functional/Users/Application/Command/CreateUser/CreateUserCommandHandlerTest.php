<?php

namespace App\Tests\Functional\Users\Application\Command\CreateUser;

use App\Shared\Application\Command\CommandBusInterface;
use App\Users\Application\Command\CreateUser\CreateUserCommand;
use App\Users\Domain\Repository\UserRepositoryInterface;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateUserCommandHandlerTest extends WebTestCase
{
    private Generator $faker;
    private CommandBusInterface $commandBus;
    private UserRepositoryInterface $userRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
        $this->commandBus = $this::getContainer()->get(CommandBusInterface::class);
        $this->userRepository = $this::getContainer()->get(UserRepositoryInterface::class);
    }

    public function testUserCreated(): void
    {
        $command = new CreateUserCommand($this->faker->email(), $this->faker->password());

        // act
        $userUlid = $this->commandBus->execute($command);

        // assert
        $user = $this->userRepository->findByUlid($userUlid);
        $this->assertNotEmpty($user);
    }
}