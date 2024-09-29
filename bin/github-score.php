<?php

declare(strict_types=1);

use RevoTest\GitHub\DataProviders\FileGetContentsGitHubEventsDataProvider;
use RevoTest\GitHub\GitHubScoreCalculator;
use RevoTest\GitHub\GitHubScorePrinter;

require __DIR__ . '/../vendor/autoload.php';

$user = readline('Input a Github account: ');
$scorePrinter = new GitHubScorePrinter(new GitHubScoreCalculator(new FileGetContentsGitHubEventsDataProvider()));

echo $scorePrinter->print($user);
