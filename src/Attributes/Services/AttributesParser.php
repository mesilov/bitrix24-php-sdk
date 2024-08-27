<?php

/**
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Maksim Mesilov <mesilov.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the MIT-LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Bitrix24\SDK\Attributes\Services;


use Bitrix24\SDK\Attributes\ApiBatchMethodMetadata;
use Bitrix24\SDK\Attributes\ApiBatchServiceMetadata;
use Bitrix24\SDK\Attributes\ApiEndpointMetadata;
use Bitrix24\SDK\Attributes\ApiServiceMetadata;
use ReflectionClass;
use Symfony\Component\Filesystem\Filesystem;
use Typhoon\Reflection\TyphoonReflector;
use function Typhoon\Type\stringify;

readonly class AttributesParser
{
    public function __construct(
        private TyphoonReflector $typhoonReflector,
        private Filesystem       $filesystem,
    )
    {
    }

    /**
     * @param class-string[] $sdkClassNames
     * @return array<string, mixed>
     */
    public function getSupportedInSdkApiMethods(array $sdkClassNames, string $sdkBaseDir): array
    {
        $supportedInSdkMethods = [];
        foreach ($sdkClassNames as $className) {
            $reflectionServiceClass = new ReflectionClass($className);
            $apiServiceAttribute = $reflectionServiceClass->getAttributes(ApiServiceMetadata::class);
            if ($apiServiceAttribute === []) {
                continue;
            }
            $apiServiceAttribute = $apiServiceAttribute[0];
            /**
             * @var ApiServiceMetadata $apiServiceAttrInstance
             */
            $apiServiceAttrInstance = $apiServiceAttribute->newInstance();
            // process api service
            $serviceMethods = $reflectionServiceClass->getMethods();
            foreach ($serviceMethods as $method) {
                $attributes = $method->getAttributes(ApiEndpointMetadata::class);
                foreach ($attributes as $attribute) {
                    /**
                     * @var ApiEndpointMetadata $instance
                     */
                    $instance = $attribute->newInstance();

                    // find return type file name
                    $returnTypeFileName = null;
                    if ($method->getReturnType() !== null) {
                        /** @var @phpstan-ignore-next-line */
                        $returnTypeName = $method->getReturnType()->getName();
                        if (class_exists($returnTypeName)) {
                            $reflectionReturnType = new ReflectionClass($returnTypeName);
                            $returnTypeFileName = substr($this->filesystem->makePathRelative($reflectionReturnType->getFileName(), $sdkBaseDir), 0, -1);
                        }
                    }

                    $supportedInSdkMethods[$instance->name] = [
                        'sdk_scope' => $apiServiceAttrInstance->scope->getScopeCodes() === [] ? '' : $apiServiceAttrInstance->scope->getScopeCodes()[0],
                        'name' => $instance->name,
                        'documentation_url' => $instance->documentationUrl,
                        'description' => $instance->description,
                        'is_deprecated' => $instance->isDeprecated,
                        'deprecation_message' => $instance->deprecationMessage,
                        'sdk_method_name' => $method->getName(),
                        'sdk_method_file_name' => substr($this->filesystem->makePathRelative($method->getFileName(), $sdkBaseDir), 0, -1),
                        'sdk_method_file_start_line' => $method->getStartLine(),
                        'sdk_method_file_end_line' => $method->getEndLine(),
                        'sdk_class_name' => $className,
                        /** @var @phpstan-ignore-next-line */
                        'sdk_return_type_class' => $method->getReturnType()?->getName(),
                        'sdk_return_type_file_name' => $returnTypeFileName
                    ];
                }
            }
        }
        return $supportedInSdkMethods;
    }

    /**
     * @param class-string[] $sdkClassNames
     * @return array<string, mixed>
     */
    public function getSupportedInSdkBatchMethods(array $sdkClassNames): array
    {
        $supportedInSdkMethods = [];
        foreach ($sdkClassNames as $className) {
            $reflectionServiceClass = new ReflectionClass($className);
            $apiServiceAttribute = $reflectionServiceClass->getAttributes(ApiBatchServiceMetadata::class);
            if ($apiServiceAttribute === []) {
                continue;
            }
            //try to get type information from phpdoc annotations
            $typhoonClassMeta = $this->typhoonReflector->reflectClass($className);
            /**
             * @var ApiBatchServiceMetadata $apiServiceAttrInstance
             */
            $apiServiceAttribute = $apiServiceAttribute[0];
            $apiServiceAttrInstance = $apiServiceAttribute->newInstance();
            // process api service
            $serviceMethods = $reflectionServiceClass->getMethods();
            foreach ($serviceMethods as $method) {
                $attributes = $method->getAttributes(ApiBatchMethodMetadata::class);
                foreach ($attributes as $attribute) {
                    /**
                     * @var ApiBatchMethodMetadata $instance
                     */
                    $instance = $attribute->newInstance();
                    $sdkReturnTypeTyphoon = null;
                    if ($method->getReturnType() !== null) {
                        // get return type from phpdoc annotation
                        $sdkReturnTypeTyphoon = stringify($typhoonClassMeta->methods()[$method->getName()]->returnType());
                    }

                    $supportedInSdkMethods[$instance->name][] = [
                        'sdk_scope' => $apiServiceAttrInstance->scope->getScopeCodes()[0],
                        'name' => $instance->name,
                        'documentation_url' => $instance->documentationUrl,
                        'description' => $instance->description,
                        'is_deprecated' => $instance->isDeprecated,
                        'deprecation_message' => $instance->deprecationMessage,
                        'sdk_method_name' => $method->getName(),
                        'sdk_method_file_name' => $method->getFileName(),
                        'sdk_method_file_start_line' => $method->getStartLine(),
                        'sdk_method_file_end_line' => $method->getEndLine(),
                        'sdk_method_return_type_typhoon' => $sdkReturnTypeTyphoon,
                        'sdk_class_name' => $className,
                    ];
                }
            }
        }
        return $supportedInSdkMethods;
    }
}