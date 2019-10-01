<?php

/*
 * This file is part of the API Platform project.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ApiPlatform\Core\Bridge\RamseyUuid\Identifier\Normalizer;

use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Denormalizes an UUID string to an instance of Ramsey\Uuid.
 *
 * @author Antoine Bluchet <soyuka@gmail.com>
 */
final class UuidNormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     *
     * @throws NotNormalizableValueException Occurs when the identifier format is invalid
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        try {
            return Uuid::fromString($data);
        } catch (InvalidUuidStringException $e) {
            throw new NotNormalizableValueException('Not found, because of an invalid identifier format', $e->getCode(), $e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null): bool
    {
        return is_a($type, UuidInterface::class, true);
    }
}
