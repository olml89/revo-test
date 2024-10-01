<?php

declare(strict_types=1);

namespace Tests\GitHub;

use Faker\Factory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use RevoTest\GitHub\DataProviders\GitHubEventsDataProvider;
use RevoTest\GitHub\GitHubEventScore;
use RevoTest\GitHub\GitHubScoreCalculator;
use RevoTest\GitHub\ScoredGitHubEventType;

#[CoversClass(GitHubScoreCalculator::class)]
#[CoversClass(GitHubEventScore::class)]
#[CoversClass(ScoredGitHubEventType::class)]
final class GitHubScoreCalculatorTest extends TestCase
{
    public static function provideGithubEventsDataProviderAndExpectedScore(): array
    {
        $faker = Factory::create();

        return [
            [
                new FakeGitHubEventsDataProvider([]),
                0,
            ],
            [
                new FakeGitHubEventsDataProvider([
                    [
                        $faker->word() => $faker->word(),
                    ],
                ]),
                0,
            ],
            [
                new FakeGitHubEventsDataProvider([
                    [
                        'type' => ScoredGitHubEventType::PushEvent->value,
                    ],
                ]),
                5,
            ],
            [
                new FakeGitHubEventsDataProvider([
                    [
                        'type' => ScoredGitHubEventType::CreateEvent->value,
                    ],
                ]),
                4,
            ],
            [
                new FakeGitHubEventsDataProvider([
                    [
                        'type' => ScoredGitHubEventType::IssuesEvent->value,
                    ],
                ]),
                3,
            ],
            [
                new FakeGitHubEventsDataProvider([
                    [
                        'type' => ScoredGitHubEventType::CommitCommentEvent->value,
                    ],
                ]),
                2,
            ],
            [
                new FakeGitHubEventsDataProvider([
                    [
                        'type' => $faker->word(),
                    ],
                ]),
                1,
            ],
            [
                new FakeGitHubEventsDataProvider([
                    [
                        'type' => ScoredGitHubEventType::PushEvent->value,
                    ],
                    [
                        'type' => ScoredGitHubEventType::CreateEvent->value,
                    ],
                    [
                        'type' => ScoredGitHubEventType::IssuesEvent->value,
                    ],
                    [
                        'type' => ScoredGitHubEventType::CommitCommentEvent->value,
                    ],
                    [
                        'type' => $faker->word(),
                    ],
                ]),
                5 + 4 + 3 + 2 + 1,
            ],
        ];
    }

    #[DataProvider('provideGithubEventsDataProviderAndExpectedScore')]
    public function testItReturnsExpectedScore(GitHubEventsDataProvider $dataProvider, int $expectedScore): void
    {
        $githubScoreCalculator = new GitHubScoreCalculator($dataProvider);
        $faker = Factory::create();

        $this->assertEquals($expectedScore, $githubScoreCalculator->calculate($faker->word()));
    }
}