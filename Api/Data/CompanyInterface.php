<?php
declare(strict_types=1);
namespace Devall\Company\Api\Data;

/**
 * Interface CompanyInterface
 * @package Devall\Company\Api\Data
 */
interface CompanyInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name): void;

    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @param $id
     * @return void
     */
    public function setId($id): void;

    /**
     * @return string
     */
    public function getCountry(): string;

    /**
     * @param string $country
     * @return void
     */
    public function setCountry(string $country): void;

    /**
     * @return string
     */
    public function getStreet(): string;

    /**
     * @param string $street
     * @return void
     */
    public function setStreet(string $street): void;

    /**
     * @return string
     */
    public function getNumber(): string;

    /**
     * @param string $number
     * @return void
     */
    public function setNumber(string $number): void;

    /**
     * @return int
     */
    public function getSize(): int;

    /**
     * @param int $size
     * @return void
     */
    public function setSize(int $size): void;
}
