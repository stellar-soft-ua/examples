<?php

declare(strict_types=1);

namespace AL\AmastyMultipleWishlist\ViewModel;

use Amasty\MWishlist\Model\Networks;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Amasty\MWishlist\Api\WishlistProviderInterface;
use Amasty\MWishlist\Block\Account\Wishlist\WishlistList\Tab;

class ExtractAvailableSocialMedia implements ArgumentInterface
{
    /**
     * @param WishlistProviderInterface $wishlistProvider
     * @param Tab $wishlistTab
     * @param Networks $networks
     */
    public function __construct(
        private SerializerInterface $serializer,
        private Networks $networks
    ) {}

    /**
     * @return string
     */
    public function getActiveSocialMedia()
    {
        $socialMediaNames = [];

        foreach ($this->networks->getNetworks() as $network) {
            $socialMediaNames[] = $network->getValue();
        }

        return $this->serializer->serialize($socialMediaNames);
    }
}
