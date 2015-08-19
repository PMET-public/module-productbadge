<?php

namespace MagentoEse\ProductBadge\Block\Product;

use MagentoEse\ProductBadge\Helper\BadgeFactory as HelperFactory;

class BadgeBuilder
{
    /**
     * @var BadgeFactory
     */
    protected $badgeFactory;

    /**
     * @var HelperFactory
     */
    protected $helperFactory;

    /**
     * @var \Magento\Catalog\Model\Product
     */
    protected $product;

    /**
     * @param HelperFactory $helperFactory
     * @param BadgeFactory $badgeFactory
     */
    public function __construct(
        HelperFactory $helperFactory,
        BadgeFactory $badgeFactory
    ) {
        $this->helperFactory = $helperFactory;
        $this->badgeFactory = $badgeFactory;
    }

    /**
     * Set product
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return $this
     */
    public function setProduct(\Magento\Catalog\Model\Product $product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * Create badge block
     *
     * @return \MagentoEse\ProductBadge\Block\Product\Badge
     */
    public function create()
    {
        /** @var \MagentoEse\ProductBadge\Helper\Badge $helper */
        $helper = $this->helperFactory->create()
            ->init($this->product);

        $data = [
            'data' => [
                'template' => 'MagentoEse_ProductBadge::product/badge.phtml',
                'badge_exists' => $helper->hasBadge(),
                'badge_class' => $helper->getClassName(),
                'badge_label' => $helper->getLabel()
            ],
        ];

        return $this->badgeFactory->create($data);
    }
}
