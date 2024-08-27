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

namespace Bitrix24\SDK\Services\CRM\Activity\Result\WebForm;

class WebFormProviderParams
{
    private array $fields;
    private WebFormMetadata $webForm;
    private array $visitedPages;

    /**
     * @param array                                                              $fields
     * @param \Bitrix24\SDK\Services\CRM\Activity\Result\WebForm\WebFormMetadata $webForm
     * @param array                                                              $visitedPages
     */
    public function __construct(array $fields, WebFormMetadata $webForm, array $visitedPages)
    {
        $this->fields = $fields;
        $this->webForm = $webForm;
        $this->visitedPages = $visitedPages;
    }

    /**
     * @return WebFormFieldItem[]
     */
    public function getFields(): array
    {
        $res = [];
        foreach ($this->fields as $field) {
            $res[] = new WebFormFieldItem($field);
        }

        return $res;
    }

    /**
     * @return \Bitrix24\SDK\Services\CRM\Activity\Result\WebForm\WebFormMetadata
     */
    public function getWebForm(): WebFormMetadata
    {
        return $this->webForm;
    }

    /**
     * @return VisitedPageItem[]
     */
    public function getVisitedPages(): array
    {
        $res = [];
        foreach ($this->visitedPages as $page) {
            $res[] = new VisitedPageItem($page);
        }

        return $res;
    }
}