<?php

namespace chemezov\yii2\yandex\cloud\handlers;

use chemezov\yii2\yandex\cloud\commands\UploadCommand;
use chemezov\yii2\yandex\cloud\base\handlers\Handler;
use GuzzleHttp\Psr7;
use Psr\Http\Message\StreamInterface;

/**
 * Class UploadCommandHandler
 *
 * @package chemezov\yii2\yandex\cloud\handlers
 */
final class UploadCommandHandler extends Handler
{
    /**
     * @param \chemezov\yii2\yandex\cloud\commands\UploadCommand $command
     *
     * @return \Aws\ResultInterface|\GuzzleHttp\Promise\PromiseInterface
     */
    public function handle(UploadCommand $command)
    {
        $source = $this->sourceToStream($command->getSource());
        $options = array_filter($command->getOptions());

        $promise = $this->s3Client->uploadAsync(
            $command->getBucket(),
            $command->getFilename(),
            $source,
            $command->getAcl(),
            $options
        );

        return $command->isAsync() ? $promise : $promise->wait();
    }

    /**
     * Create a new stream based on the input type.
     *
     * @param resource|string|StreamInterface $source path to a local file, resource or stream
     *
     * @return StreamInterface
     */
    protected function sourceToStream($source): StreamInterface
    {
        if (is_string($source)) {
            $source = Psr7\Utils::tryFopen($source, 'r+');
        }

        return Psr7\Utils::streamFor($source);
    }
}
