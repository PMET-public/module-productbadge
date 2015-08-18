<?php

namespace MagentoEse\ProductBadge\Block\Plugin\Product;

class Image extends \Magento\Framework\View\Element\Template
{
    /**
     * Template image with html frame border
     *
     * @var string
     */
    protected $_templateBadge = 'MagentoEse_ProductBadge::product/image.phtml';

    /**
     * @var \MagentoEse\ProductBadge\Model\Badge
     */
    protected $_badge;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \MagentoEse\ProductBadge\Model\Badge $badgeView
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \MagentoEse\ProductBadge\Model\Badge $badge,
        array $data = []
    ) {
        $this->_badge = $badge;
        parent::__construct($context, $data);
    }

    /**
     * Initialize model
     *
     * @param \Magento\Catalog\Block\Product\Image $subject
     * @param \Magento\Catalog\Block\Product\Image $return
     * @return \Magento\Catalog\Block\Product\Image
     */
    public function beforeInit(\Magento\Catalog\Block\Product\Image $subject, $product, $location, $module = 'MagentoEse_ProductBadge')
    {
        $this->_badge->init($product);

        if (null === $this->getTemplate()) {
            $this->setTemplate($this->_templateBadge);
        }

        if ($module === 'MagentoEse_ProductBadge')
        {
            return [$product, $location];
        } else {
            return [$product, $location, $module];
        }
    }

    /**
     * Getter Badge Label
     *
     * @return string
     */
    public function getBadgeLabel()
    {
        return $this->_badge->getLabel();
    }

    /**
     * Getter Badge Label
     *
     * @return string
     */
    public function getBadgeClass()
    {
        return $this->_badge->getClassName();
    }

    /**
     * Returns status if the product has a badge or not
     *
     * @return boolean
     */
    public function hasBadge()
    {
        return $this->_badge->hasBadge();
    }

    /**
     * Initialize model
     *
     * @param \Magento\Catalog\Block\Product\Image $subject
     * @param \Magento\Catalog\Block\Product\Image $result
     * @return string
     */
    public function afterToHtml(\Magento\Catalog\Block\Product\Image $subject, $result)
    {
        $badgeHtml = $this->toHtml();

        return $result . $badgeHtml;
    }

}