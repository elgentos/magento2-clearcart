<?php

namespace Elgentos\ClearCart\Controller\Cart;

use Magento\Checkout\Model\Session;
use Magento\Framework\Controller\ResultInterface;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Clear extends Action
{
    public function __construct(
        Context $context,
        protected Session $checkoutSession,
        protected CartRepositoryInterface $cartRepository
    ) {
        parent::__construct($context);
    }

    public function execute(): ?ResultInterface
    {
        $cart = $this->checkoutSession->getQuote();
        $items = $cart->getItemsCollection();
        foreach ($items as $item) {
            $cart->removeItem($item->getId());
        }
        $this->cartRepository->save($cart);

        $this->_redirect('/');
        return null;
    }
}
