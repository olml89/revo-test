<?php

declare(strict_types=1);

namespace RevoTest\GitHub\DataProviders;

use ErrorException;
use JsonException;
use Throwable;

final class FileGetContentsGitHubEventsDataProvider implements GitHubEventsDataProvider
{
    private const string URL = 'https://api.github.com/users/%s/events';

    public function __construct()
    {
        /**
         * Prevent file_get_contents failing silently with a Warning and returning false.
         */
        set_error_handler(
        /**
         * @throws ErrorException
         */
            function (int $errno, string $errstr, string $errfile, int $errline) {
                throw new ErrorException(
                    message: $errstr,
                    code: 0,
                    severity: $errno,
                    filename: $errfile,
                    line: $errline,
                );
            }
        );
    }

    /**
     * @throws UnreachableGitHubEventsException
     */
    public function getData(string $user): array
    {
        try {
            /**
             * https://stackoverflow.com/questions/37141315/file-get-contents-gets-403-from-api-github-com-every-time
             *
             * GitHub API requires UserAgent header to be sent.
             */
            $json = file_get_contents(sprintf(self::URL, $user), context: stream_context_create([
                'http' => [
                    'method' => 'GET',
                    'header' => [
                        'User-Agent: Revo test ' . self::class,
                    ],
                ],
            ]));

            return json_decode($json, associative: true, flags: JSON_THROW_ON_ERROR);
        }
        catch (JsonException) {
            throw UnreachableGitHubEventsException::corruptJson($user);
        }
        catch (Throwable) {
            throw UnreachableGitHubEventsException::unavailableUser($user);
        }
    }
}