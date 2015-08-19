<?php

namespace MagentoEse\ProductBadge\Helper;

use Magento\Framework\App\Area;
use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Product Badge helper
 * @SuppressWarnings(PHPMD.TooManyFields)
 */
class Badge extends AbstractHelper
{
    /**
     * @var []
     */
    protected $_badgeList;

    /**
     * @var []
     */
    protected $_badgeListDefaults;

    /**
     * Reset all previous data
     *
     * @return $this
     */
    protected function _reset()
    {
        $this->_badgeList = null;
        $this->_badgeListDefaults = null;
        return $this;
    }

    /**
     * Initialize Helper to work with Badge
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return $this
     */
    public function init($product)
    {
        $this->_reset();

        $this->_badgeList = $product->getAttributeText('badge');
        $this->_badgeListDefaults = $this->getDefaultAttributeText($product, 'badge');

        return $this;
    }

    /**
     * Returns the default attribute text value/s for a product
     *
     * @param \Magento\Catalog\Model\Product $product
     * @param string $attributeCode
     * @return string
     */
    private function getDefaultAttributeText($product, $attributeCode)
    {
        $value = $product->getData($attributeCode);

        // Reference:
        //      Magento\Eav\Model\Entity\Attribute\Source
        //          getOptionText()
        $isMultiple = false;
        if (strpos($value, ',')) {
            $isMultiple = true;
            $value = explode(',', $value);
        }

        // get the default (Admin store_id=0) values for the options
        // Reference:
        //      Magento\Catalog\Model\Product
        //          getAttributeText()
        //      Magento\Eav\Model\Entity\Attribute\Source
        //          getAllOptions()
        //          getOptionText()
        $options = $product->getResource()->getAttribute($attributeCode)->getSource()->getAllOptions(false, true);

        if ($isMultiple) {
            $values = [];
            foreach ($options as $item) {
                if (in_array($item['value'], $value)) {
                    $values[] = $item['label'];
                }
            }
            return $values;
        }

        foreach ($options as $item) {
            if ($item['value'] == $value) {
                return $item['label'];
            }
        }
        return '';
    }

    /**
     * Return product badge formatted class name
     *
     * @return string
     */
    public function getClassName()
    {
        if ($this->hasBadge()) {
            preg_match("/.+\(([\w-]+)\)+/", $this->getSingleBadge($this->_badgeListDefaults), $regexArrayResults);
            if (empty($regexArrayResults[1])) {
                $className = strtolower(preg_replace("/\W/", "-", $this->getSingleBadge($this->_badgeListDefaults)));
            } else {
                $className = strtolower(preg_replace("/\W/", "-", $regexArrayResults[1]));
            }
            return $className;
        } else {
            return '';
        }
    }

    /**
     * Return product badge label
     *
     * @return string
     */
    public function getLabel()
    {
        if ($this->hasBadge()) {
            return $this->getSingleBadge();
        } else {
            return '';
        }
    }

    /**
     * Returns status if the product has a badge or not
     *
     * @return boolean
     */
    public function hasBadge()
    {
        if (empty($this->_badgeList))
        {
            return false;
        } else
        {
            return true;
        }
    }

    /**
     * Return a single badge from the list of badges
     *
     * @param array $badgeList
     * @return string
     */
    private function getSingleBadge($badgeList = null)
    {
        if ($badgeList === null) {
            $badgeList = $this->_badgeList;
        }

        if (is_array($badgeList))
        {
            return $badgeList[0];
        } else {
            return $badgeList;
        }
    }
}
