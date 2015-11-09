<?php

namespace MagentoEse\ProductBadge\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * Init
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $connection = $setup->getConnection();
        try {
            $connection->beginTransaction();

            /** @var EavSetup $eavSetup */
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

            /**
             * Add attributes to the eav/attribute
             */

            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'badge',
                [
                    'type' => 'varchar',
                    'label' => 'Product Badge',
                    'input' => 'multiselect',
                    'required' => false,
                    'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
                    'global' => \Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_GLOBAL,
                    'visible' => true,
                    'user_defined' => false,
                    'searchable' => false,
                    'filterable' => true,
                    'filterable_in_search' => true,
                    'comparable' => false,
                    'visible_on_front' => false,
                    'unique' => false,
                    'used_in_product_listing' => true,
                    'group' => 'Product Details',
                    'is_used_in_grid' => true,
                    'is_visible_in_grid' => true,
                    'is_filterable_in_grid' => true,
                    'option' => [
                        'values' => [
                            'Sale',
                            'New',
                            'In-Store Pickup',
                            'Best Seller',
                            'Most Shared',
                            'Custom Example (Pink)'
                        ]
                    ]
                ]
            );
            $connection->commit();
        } catch (\Exception $e) {

            // If an error occured rollback the database changes as if they never happened
            $connection->rollback();
            throw $e;
        }
    }
}
