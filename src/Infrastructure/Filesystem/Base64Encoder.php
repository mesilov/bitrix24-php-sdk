<?php

/**
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Maksim Mesilov <mesilov.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the MIT-LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Bitrix24\SDK\Infrastructure\Filesystem;

use Bitrix24\SDK\Core\Exceptions\FileNotFoundException;
use Bitrix24\SDK\Core\Exceptions\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Filesystem;

readonly class Base64Encoder
{
    private array $allowedRecordFileExtensions;

    public function __construct(
        private Filesystem                                    $filesystem,
        private \Symfony\Component\Mime\Encoder\Base64Encoder $base64Encoder,
        private LoggerInterface                               $log
    )
    {
        $this->allowedRecordFileExtensions = ['wav', 'mp3'];
    }

    /**
     * @param non-empty-string $filename
     * @throws InvalidArgumentException
     * @throws FileNotFoundException
     */
    public function encodeCallRecord(string $filename): string
    {
        if (!$this->filesystem->exists($filename)) {
            throw new FileNotFoundException(sprintf('file %s not found', $filename));
        }

        $fileExt = pathinfo($filename, PATHINFO_EXTENSION);
        if (!in_array($fileExt, $this->allowedRecordFileExtensions, true)) {
            throw new InvalidArgumentException(sprintf('wrong record file extension %s, allowed types %s',
                $fileExt, implode(',', $this->allowedRecordFileExtensions)));
        }

        $fileBody = file_get_contents($filename);
        if (false === $fileBody) {
            throw new InvalidArgumentException(sprintf('cannot read file %s', $filename));
        }

        $fileBody = $this->base64Encoder->encodeString($fileBody);

        $this->log->debug('encodeFile.finish');
        return $fileBody;
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

        $this->log->debug('encodeFile.finish');
        return $fileBody;
    }
}