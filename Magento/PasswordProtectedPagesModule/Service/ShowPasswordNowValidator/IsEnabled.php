<?php
declare(strict_types=1);

namespace AL\ProductPassword\Service\ShowPasswordNowValidator;

use AL\ProductPassword\Api\ValidatorInterface;
use AL\ProductPassword\Service\Config;

/**
 * Class IsEnabled
 */
class IsEnabled implements ValidatorInterface
{
    private Config $config;

    /**
     * IsEnabled constructor.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @return bool
     */
    public function validate(): bool
    {
        return $this->config->getStatus() && !empty($this->config->getPassword());
    }
}
