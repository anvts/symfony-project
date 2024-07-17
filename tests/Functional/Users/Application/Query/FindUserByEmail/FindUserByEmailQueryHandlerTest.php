<?php

namespace App\Tests\Functional\Users\Application\Query\FindUserByEmail;

use App\Shared\Application\Query\QueryBusInterface;
use App\Tests\Resource\Fixture\UserFixture;
use App\Users\Application\DTO\UserDTO;
use App\Users\Application\Query\FindUserByEmail\FindUserByEmailQuery;
use App\Users\Domain\Entity\User;
use App\Users\Domain\Repository\UserRepositoryInterface;
use Faker\Factory;
use Faker\Generator;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FindUserByEmailQueryHandlerTest extends WebTestCase
{
    private Generator $faker;
    private QueryBusInterface $queryBus;
    private UserRepositoryInterface $userRepository;
    private AbstractDatabaseTool $databaseTool;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
        $this->queryBus = $this::getContainer()->get(QueryBusInterface::class);
        $this->userRepository = $this::getContainer()->get(UserRepositoryInterface::class);
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
    }

    public function testUserCreatedWhenCommandExecuted(): void
    {
        // arrange
        $referenceRepository = $this->databaseTool->loadFixtures([UserFixture::class])->getReferenceRepository();
        /** @var User $user */
        $user = $referenceRepository->getReference(UserFixture::REFERENCE);
        $query = new FindUserByEmailQuery($user->getEmail());

        // act
        $userDTO = $this->queryBus->execute($query);

        // assert
        $this->assertInstanceOf(UserDTO::class, $userDTO);
    }
}