<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Unit\Services\TestPerson;

use Bitrix24\SDK\Tests\Unit\Services\TestPerson\Person;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class PersonNormalizer implements ContextAwareNormalizerInterface
{
    private UrlGeneratorInterface $router;
    private ObjectNormalizer $normalizer;
    protected Person $person;

    public function __construct(UrlGeneratorInterface $router, ObjectNormalizer $normalizer)
    {
        $this->router = $router;
        $this->normalizer = $normalizer;
    }

    public function normalize($person, string $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($person, $format, $context);
        var_dump($data);
        // Здесь, добавьте, измените или удалите некоторые данные:
        return $this->router->generate('topic_show', [
            'name' => $person->getName(),
        ], UrlGeneratorInterface::ABSOLUTE_URL);
    }

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Person;
    }

}