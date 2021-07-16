<?php

namespace Devall\Company\Model;

use Devall\Company\Api\Data\CompanyInterface;

class Company extends \Magento\Framework\Model\AbstractModel implements CompanyInterface {
    const COMPANY_ATTRIBUTE_CODE = 'company_attr';
    const ENTITY_ID = 'entity_id';
    const NAME = 'name';
    const COUNTRY = 'country';
    const STREET = 'srteet';
    const NUMBER = 'street_number';
    const COMPANY_SIZE = 'size';

    protected function _construct()
    {
        $this->_init('Devall\Company\Model\ResourceModel\Company');
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return $this->_getData(self::NAME);
    }

    /**
     * @inheritdoc
     */
    public function setName($name): void
    {
        $this->setData(self::NAME);
    }

    /**
     * @inheritdoc
     */
    public function getId(): int
    {
        return $this->_getData(self::ENTITY_ID);
    }

    /**
     * @inheritdoc
     */
    public function setId($id): void
    {
        $this->setData(self::ENTITY_ID);
    }

    /**
     * @inheritdoc
     */
    public function getCountry(): string
    {
        return $this->_getData(self::COUNTRY);
    }

    /**
     * @inheritdoc
     */
    public function setCountry(string $country): void
    {
        $this->setData(self::COUNTRY);
    }

    /**
     * @inheritdoc
     */
    public function getStreet(): string
    {
        return $this->_getData(self::STREET);
    }

    /**
     * @inheritdoc
     */
    public function setStreet(string $street): void
    {
        $this->setData(self::STREET);
    }

    /**
     * @inheritdoc
     */
    public function getNumber(): string
    {
        return $this->_getData(self::NUMBER);
    }

    /**
     * @inheritdoc
     */
    public function setNumber(string $number): void
    {
        $this->setData(self::NUMBER);
    }

    /**
     * @inheritdoc
     */
    public function getSize(): int {
        return $this->_getData(self::COMPANY_SIZE);
    }

    /**
     * @inheritdoc
     */
    public function setSize(int $size): void {
        $this->setData(self::COMPANY_SIZE);
    }
}
