<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Unit\Services\TestPerson;

use Bitrix24\SDK\Tests\Unit\Services\TestPerson\Person;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class PersonNormalizer implements NormalizerInterface, ContextAwareNormalizerInterface
{
    private ObjectNormalizer $normalizer;

    public function __construct( ObjectNormalizer $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    /**
     * @param Person $object
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function normalize($object, string $format = null, array $context = []):array
    {
        $data = $this->normalizer->normalize($object,$format,$context);
        return [
            'name' => 'new_name',
            'lastname' => 'new_lastname',
        ];
    }

    public function supportsNormalization($data, string $format = null, array $context = []):bool
    {
        return $data instanceof Person;
    }


}