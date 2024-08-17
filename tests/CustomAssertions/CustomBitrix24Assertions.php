<?php
declare(strict_types=1);

namespace Bitrix24\SDK\Tests\CustomAssertions;

use Bitrix24\SDK\Services\CRM\Contact\Result\ContactItemResult;
use Typhoon\Reflection\TyphoonReflector;

trait CustomBitrix24Assertions
{
    /**
     * @param array<int, non-empty-string> $fieldCodesFromApi
     * @param class-string $resultItemClassName
     * @return void
     */
    protected function assertBitrix24AllResultItemFieldsAnnotated(array $fieldCodesFromApi, string $resultItemClassName): void
    {
        sort($fieldCodesFromApi);

        // parse keys from phpdoc annotation
        $props = TyphoonReflector::build()->reflectClass($resultItemClassName)->properties();
        $propsFromAnnotations = [];
        foreach ($props as $meta) {
            if ($meta->isAnnotated() && !$meta->isNative()) {
                $propsFromAnnotations[] = $meta->id->name;
            }
        }
        sort($propsFromAnnotations);

        $this->assertEquals($fieldCodesFromApi, $propsFromAnnotations,
            sprintf('in phpdocs annotations for class %s we not found fields from actual api response: %s',
                $resultItemClassName,
                implode(', ', array_values(array_diff($fieldCodesFromApi, $propsFromAnnotations)))
            ));
    }
}