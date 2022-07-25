<?php

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Unit\Services\TestPerson;

class Person
{
    private string $name;
    private string $lastName;

    // Getters
    public function getName()
    {
        return $this->name;
    }

    public function getLastName()
    {
        return $this->lastName;
    }


    // Setters
    public function setName($name)
    {
        $this->name = $name;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

}