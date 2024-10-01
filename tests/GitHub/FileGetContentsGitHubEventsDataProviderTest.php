<?php

declare(strict_types=1);

namespace Tests\GitHub;

use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use RevoTest\GitHub\DataProviders\FileGetContentsGitHubEventsDataProvider;
use RevoTest\GitHub\DataProviders\UnreachableGitHubEventsException;

#[CoversClass(FileGetContentsGitHubEventsDataProvider::class)]
#[CoversClass(UnreachableGitHubEventsException::class)]
final class FileGetContentsGitHubEventsDataProviderTest extends TestCase
{
    private Generator $faker;
    private FileGetContentsGitHubEventsDataProvider $dataProvider;

    protected function setUp(): void
    {
        $this->faker = Factory::create();
        $this->dataProvider = new FileGetContentsGitHubEventsDataProvider();
    }

    /**
     * Because the FileGetContentsGitHubEventsDataProvider register its own errorHandler, it overrides the one
     * registered by PHPUnit, so we must restore it back before exiting the test.
     */
    protected function tearDown(): void
    {
        restore_error_handler();
    }

    public function testItThrowsUnreachableGitHubEventsExceptionForInvalidUsers(): void
    {
        $unavailableUser = $this->faker->word() . $this->faker->numberBetween() . $this->faker->word();

        $this->expectExceptionObject(
            UnreachableGitHubEventsException::unavailableUser($unavailableUser)
        );

        $this->dataProvider->getData($unavailableUser);
    }

    public function testItReturnsDataForValidUsers(): void
    {
        $validUser = 'badchoice';

        $this->assertNotEmpty($this->dataProvider->getData($validUser));
    }
}