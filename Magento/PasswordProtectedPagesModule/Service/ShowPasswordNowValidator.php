<?php

declare(strict_types=1);

namespace AL\ProductPassword\Service;

use AL\ProductPassword\Api\ValidatorInterface;

/**
 * Class ShowPasswordNowValidator
 */
class ShowPasswordNowValidator
{
    private array $validators;

    /**
     * ShowPasswordNowValidator constructor.
     *
     * @param ValidatorInterface[] $validators
     */
    public function __construct(
        array $validators = []
    ) {
        $this->validators = $validators;
    }

    /**
     * @return bool
     */
    public function validate(): bool
    {
        foreach ($this->validators as $validator) {
            $isValid = $validator->validate();

            if (!$isValid) {
                return false;
            }
        }

        return true;
    }
}
