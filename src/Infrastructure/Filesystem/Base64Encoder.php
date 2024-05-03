<?php

namespace Bitrix24\SDK\Infrastructure\Filesystem;

use Bitrix24\SDK\Core\Exceptions\FileNotFoundException;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Filesystem;

readonly class Base64Encoder
{
    public function __construct(
        private Filesystem                                    $filesystem,
        private \Symfony\Component\Mime\Encoder\Base64Encoder $base64Encoder,
        private LoggerInterface                               $log
    )
    {
    }

    /**
     * @throws FileNotFoundException|InvalidArgumentException
     */
    public function encodeFile(string $filename): string
    {
        $this->log->debug('encodeFile.start', ['filename' => $filename]);

        if (!$this->filesystem->exists($filename)) {
            throw new FileNotFoundException(sprintf('file %s not found', $filename));
        }

        $fileBody = file_get_contents($filename);
        if (false === $fileBody) {
            throw new InvalidArgumentException(sprintf('cannot read file %s', $filename));
        }

        $fileBody = $this->base64Encoder->encodeString($fileBody);

        $this->log->debug('encodeFile.finish¨');
        return $fileBody;
    }
}