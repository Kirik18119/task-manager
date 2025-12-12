<?php

namespace App\Core;

use Random\RandomException;

class Faker
{
    private array $valuesQueue = [];

    private array $uniqueValues = [];

    private static ?Faker $faker = null;

    /**
     * @throws RandomException
     */
    public function randomString(int $length = 10): static
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for($i = 0; $i < $length; $i++)
        {
            $randomIndex = random_int(0, $charactersLength - 1);
            $randomString .= $characters[$randomIndex];
        }

        $this->valuesQueue[] = $randomString;

        return $this;
    }

    /**
     * @throws RandomException
     */
    public function randomInt(int $min = 1, int $max = 100000): static
    {
        $this->valuesQueue[] = random_int($min, $max);

        return $this;
    }

    /**
     * @throws RandomException
     */
    public function email(int $length): static
    {
        $this->randomString($length);
        $this->valuesQueue[array_key_last($this->valuesQueue)] = $this->valuesQueue[array_key_last($this->valuesQueue)] . "@gmail.com";

        return $this;
    }

    /**
     * @throws RandomException
     */
    public function randomArrayElement(array $values): static
    {
        $this->valuesQueue []= $values[random_int(0, count($values) - 1)];

        return $this;
    }

    /**
     * @param class-string $enumClass
     * @return $this
     * @throws RandomException
     */
    public function randomEnum(string $enumClass): static
    {
        $this->randomArrayElement($enumClass::cases());

        return $this;
    }

    public function unique(): Faker
    {
        $this->uniqueValues []= $this->valuesQueue[array_key_last($this->valuesQueue)];

        return $this;
    }

    public function get()
    {
        return array_pop($this->valuesQueue);
    }

    public static function getInstance(): Faker
    {
        return static::$faker ?? static::$faker = new Faker();
    }
}