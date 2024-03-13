<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Services\CRM\Duplicates\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;
use Bitrix24\SDK\Services\CRM\Duplicates\Service\EntityType;

/**
 * Class DuplicateResult
 * Handles the results for CRM duplicate checks.
 */
class DuplicateResult extends AbstractResult
{
    /**
     * Private helper method to check for the existence of items of a given type.
     * @param EntityType $entityType The type of entity to check.
     * @param int $count The number of items to check for.
     * @return bool True if the number of items is greater than or equal to the specified count.
     */
    private function hasItems(EntityType $entityType, int $count = 1): bool
    {
        $entityTypeValue = $entityType->value;
        $items = $this->getCoreResponse()->getResponseData()->getResult()[$entityTypeValue] ?? [];
        return count($items) >= $count;
    }

    /**
     * Checks if there is exactly one match for a given entity type.
     * @param EntityType $entityType The entity type to check.
     * @return bool True if there is only one match.
     */
    public function hasOne(EntityType $entityType): bool
    {
        return $this->hasItems($entityType, 1) && count($this->getCoreResponse()->getResponseData()->getResult()[$entityType ->value]) === 1;
    }

     /**
     * Checks if there is more than one match for a given entity type.
     * @param EntityType $entityType The entity type to check.
     * @return bool True if 2 or more duplicates.
     */
    public function hasDuplicates(EntityType $entityType): bool
    {
        return $this->hasItems($entityType, 2);
    }

    /**
     * Checks if there are any matches for a given entity type.
     * @param EntityType $entityType The entity type to check
     * @return bool True if there are any matches.
     */
    public function hasMatches(EntityType $entityType): bool
    {
        return $this->hasItems($entityType, 1);
    }

    /**
     * Checks if there are any matches across all entity types.
     * @return bool True if there are matches for any entity type.
     */
    public function hasAnyMatches(): bool
    {
        foreach (EntityType::cases() as $entityType) {
            if ($this->hasMatches($entityType)) {
                return true;
            }
        }
    
        return false;
    }

    // Backward compatible methods
    public function hasDuplicateContacts(): bool
    {
        return $this->hasDuplicates(EntityType::Contact);
    }

    public function hasOneContact(): bool
    {
        return $this->hasOne(EntityType::Contact);
    }

    /**
     * Retrieves the IDs of a specific entity type.
     *
     * @param EntityType $entityType The entity type for which to retrieve IDs.
     * @return array<int> The array of IDs.
     * @throws BaseException If an error occurs during the API call.
     */
    public function getEntityIds(EntityType $entityType): array
    {
        $entityTypeValue = $entityType->value;

        if (!array_key_exists($entityTypeValue, $this->getCoreResponse()->getResponseData()->getResult())) {
            return [];
        }

        return $this->getCoreResponse()->getResponseData()->getResult()[$entityTypeValue];
    }

    public function getContactsId(): array //backward-compatibility name
    {
        return $this->getEntityIds(EntityType::Contact);
    }

    public function getCompanyIds(): array
    {
        return $this->getEntityIds(EntityType::Company);
    }

    public function getLeadIds(): array
    {
        return $this->getEntityIds(EntityType::Lead);
    }


    /**
     * Returns the ID of a match for a given entity type, with optional sorting to return either the first or last ID.
     *
     * @param EntityType $entityType The entity type for which to retrieve a match ID.
     * @param string $sortOrder Optional sorting order, 'asc' return older entity, 'desc' for the newest. Default is 'desc'.
     * @return int|null ID of the match, or null if no matches found.
     */
    public function getMatchId(EntityType $entityType, string $sortOrder = 'desc'): ?int
    {
        $entityIds = $this->getEntityIds($entityType);
        
        if (empty($entityIds)) {
            return null;
        }
        
        return $sortOrder === 'desc' ? end($entityIds) :reset($entityIds);
    }
    

    /**
     * Returns the ID and EntityType of the first match found based on the provided priority order.
     *
     * @param array $entityTypesOrder Array of EntityType objects in the order of priority. (Defaults Lead > Contact > Company)
     * @param string $sortOrder Optional sorting order, 'asc' return older entity, 'desc' for the newest. Default is 'desc'.
     * @return array|null ID of the first match or null if no matches found.
     */
    public function getMatchIdByPriority(array $entityTypesOrder = [EntityType::Lead, EntityType::Contact, EntityType::Company], string $sortOrder = 'desc'): ?array
    {
        foreach ($entityTypesOrder as $entityType) {
            // Используем getMatchId для получения ID с учетом сортировки
            $matchId = $this->getMatchId($entityType, $sortOrder);
            if ($matchId !== null) {
                return [
                    'id' => $matchId,
                    'entityType' => $entityType,
                    'entityTypeValue' => $entityType->value,
                ];
            }
        }
    
        return null;
    }    
}