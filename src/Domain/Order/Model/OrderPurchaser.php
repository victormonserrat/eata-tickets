<?php

/*
 * This file is part of the EATA Dev Test package.
 *
 * (c) Victor Monserrat
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace EataDevTest\Domain\Order\Model;

use EataDevTest\Domain\Order\Exception\InvalidOrderPurchaser;
use EataDevTest\Domain\ValueObject;

final class OrderPurchaser implements ValueObject
{
    /** @var OrderPurchaserDocumentId */
    private $documentId;

    /** @var OrderPurchaserEmail */
    private $email;

    /** @var OrderPurchaserName */
    private $name;

    /** @var OrderPurchaserLastName */
    private $lastName;

    /** @var OrderPurchaserZipCode */
    private $zipCode;

    public static function fromArray(array $purchaser): self
    {
        if (!array_key_exists('documentId', $purchaser)) {
            throw InvalidOrderPurchaser::causeUndefinedAttribute('Purchaser document id');
        }
        if (!is_string($purchaser['documentId'])) {
            throw InvalidOrderPurchaser::causeUnexpectedAttributeType('Purchaser document id', 'string');
        }
        if (!array_key_exists('email', $purchaser)) {
            throw InvalidOrderPurchaser::causeUndefinedAttribute('Purchaser email');
        }
        if (!is_string($purchaser['email'])) {
            throw InvalidOrderPurchaser::causeUnexpectedAttributeType('Purchaser email', 'string');
        }
        if (!array_key_exists('name', $purchaser)) {
            throw InvalidOrderPurchaser::causeUndefinedAttribute('Purchaser name');
        }
        if (!is_string($purchaser['name'])) {
            throw InvalidOrderPurchaser::causeUnexpectedAttributeType('Purchaser name', 'string');
        }
        if (!array_key_exists('lastName', $purchaser)) {
            throw InvalidOrderPurchaser::causeUndefinedAttribute('Purchaser last name');
        }
        if (!is_string($purchaser['lastName'])) {
            throw InvalidOrderPurchaser::causeUnexpectedAttributeType('Purchaser last name', 'string');
        }
        if (!array_key_exists('zipCode', $purchaser)) {
            throw InvalidOrderPurchaser::causeUndefinedAttribute('Purchaser ZIP code');
        }
        if (!is_string($purchaser['zipCode'])) {
            throw InvalidOrderPurchaser::causeUnexpectedAttributeType('Purchaser ZIP code', 'string');
        }

        return new self(
            OrderPurchaserDocumentId::fromString($purchaser['documentId']),
            OrderPurchaserEmail::fromString($purchaser['email']),
            OrderPurchaserName::fromString($purchaser['name']),
            OrderPurchaserLastName::fromString($purchaser['lastName']),
            OrderPurchaserZipCode::fromString($purchaser['zipCode'])
        );
    }

    private function __construct(
        OrderPurchaserDocumentId $documentId,
        OrderPurchaserEmail $email,
        OrderPurchaserName $name,
        OrderPurchaserLastName $lastName,
        OrderPurchaserZipCode $zipCode
    ) {
        $this->documentId = $documentId;
        $this->email = $email;
        $this->name = $name;
        $this->lastName = $lastName;
        $this->zipCode = $zipCode;
    }

    public function toArray(): array
    {
        return [
            'documentId' => $this->documentId()->toString(),
            'email' => $this->email()->toString(),
            'name' => $this->name()->toString(),
            'lastName' => $this->lastName()->toString(),
            'zipCode' => $this->zipCode()->toString(),
        ];
    }

    public function documentId(): OrderPurchaserDocumentId
    {
        return $this->documentId;
    }

    public function email(): OrderPurchaserEmail
    {
        return $this->email;
    }

    public function name(): OrderPurchaserName
    {
        return $this->name;
    }

    public function lastName(): OrderPurchaserLastName
    {
        return $this->lastName;
    }

    public function zipCode(): OrderPurchaserZipCode
    {
        return $this->zipCode;
    }

    public function hasSameValueAs(ValueObject $valueObject): bool
    {
        /** @var self $valueObject */
        return
            get_class($this) === get_class($valueObject) &&
            $this->documentId()->hasSameValueAs($valueObject->documentId()) &&
            $this->email()->hasSameValueAs($valueObject->email()) &&
            $this->name()->hasSameValueAs($valueObject->name()) &&
            $this->lastName()->hasSameValueAs($valueObject->lastName()) &&
            $this->zipCode()->hasSameValueAs($valueObject->zipCode())
        ;
    }
}
