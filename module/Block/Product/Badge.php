<?php

namespace MagentoEse\ProductBadge\Block\Product;

/**
 * @method string getBadgeExists()
 * @method string getBadgeClass()
 * @method string getBadgeLabel()
 */
class Badge extends \Magento\Framework\View\Element\Template
{
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        if (isset($data['template'])) {
            $this->setTemplate($data['template']);
            unset($data['template']);
        }
        parent::__construct($context, $data);
    }

}