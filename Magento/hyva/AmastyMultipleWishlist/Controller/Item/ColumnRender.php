<?php

declare(strict_types=1);

namespace AL\AmastyMultipleWishlist\Controller\Item;

use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\Request\InvalidRequestException;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Json\Helper\Data;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Wishlist\Model\ItemFactory;

class ColumnRender implements HttpPostActionInterface, CsrfAwareActionInterface
{
    /**
     * @param ResultFactory $resultFactory
     * @param Validator $formKeyValidator
     * @param Data $helper
     * @param RequestInterface $request
     * @param RedirectFactory $resultRedirectFactory
     * @param ItemFactory $wishlistItemFactory
     * @param $layout
     * @param $wishlistItemEntity
     */
    public function __construct(
        private ResultFactory $resultFactory,
        private Validator $formKeyValidator,
        private Data $helper,
        private RequestInterface $request,
        private RedirectFactory $resultRedirectFactory,
        private ItemFactory $wishlistItemFactory,
        private $layout = null,
        private $wishlistItemEntity = null,
    ) {}

    public function execute()
    {
        $page = $this->resultFactory->create(ResultFactory::TYPE_PAGE, [false, ['isIsolated' => true]]);
        $this->layout = $page->addHandle('mwishlist_wishlist_index')->getLayout();
        $blockParams = $this->request->getParam('blocks');
        $wishlistItem = $this->request->getParam('item');

        if (!$wishlistItem || !$blockParams || !$this->layout) {
            return $this->resultFactory->create(ResultFactory::TYPE_RAW);
        }

        $this->buildWishlistItem($wishlistItem);
        $result = $this->prepareResponseView($blockParams);

        return $this->resultFactory->create(ResultFactory::TYPE_RAW)
            ->setContents(\implode($result));
    }

    /**
     * @inheritDoc
     */
    public function createCsrfValidationException(RequestInterface $request): ?InvalidRequestException
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/');

        throw new LocalizedException(__('Invalid Form Key. Please refresh the page and try again.'));
    }

    /**
     * @inheritDoc
     */
    public function validateForCsrf(RequestInterface $request): ?bool
    {
        $params = $request->getParams();

        if (empty($params) && $this->request->getContent()) {
            $params = $this->helper->jsonDecode($this->request->getContent());
            $request->setParams($params);
        }

        if (!$this->formKeyValidator->validate($request)) {
            throw new LocalizedException(__('Something went wrong. Please refresh the page and try again.'));
        }

        return true;
    }

    /**
     * @param array $blocks
     *
     * @return array
     */
    private function prepareResponseView(array $blocks)
    {
        $renderResultArray = [];

        foreach ($blocks as $blockName) {
            $renderResultArray[] = $this->renderItemColumnBlock($blockName);
        }

        return $renderResultArray;
    }

    /**
     * @param string $blockName
     *
     * @return string|null
     */
    private function renderItemColumnBlock(string $blockName): ?string
    {
        return $this->layout->getBlock('customer.wishlist.items')
            ->getChildBlock($blockName)
            ->setItem($this->wishlistItemEntity)
            ->toHtml();
    }

    /**
     * @param array $itemData
     *
     * @return void
     */
    private function buildWishlistItem(array $itemData): void
    {
        $this->wishlistItemEntity = $this->wishlistItemFactory->create(['data' => $itemData]);
    }
}
