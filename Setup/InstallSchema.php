<?php

namespace OuterEdge\Page\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $setup->getConnection()->addColumn(
            $setup->getTable('cms_page'),
            'secondary_heading',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' > true,
                'comment' => 'Secondary Heading'
            ]
        );

        $setup->getConnection()->addColumn(
            $setup->getTable('cms_page'),
            'tertiary_heading',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' > true,
                'comment' => 'Tertiary Heading'
            ]
        );

        $setup->getConnection()->addColumn(
            $setup->getTable('cms_page'),
            'secondary_content',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' > true,
                'comment' => 'Secondary Content'
            ]
        );

        $setup->getConnection()->addColumn(
            $setup->getTable('cms_page'),
            'primary_image',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 500,
                'nullable' > true,
                'comment' => 'Primary Image'
            ]
        );

        $setup->getConnection()->addColumn(
            $setup->getTable('cms_page'),
            'secondary_image',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 500,
                'nullable' > true,
                'comment' => 'Secondary Image'
            ]
        );

        $setup->getConnection()->addColumn(
            $setup->getTable('cms_page'),
            'tertiary_image',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 500,
                'nullable' > true,
                'comment' => 'Tertiary Image'
            ]
        );

        $setup->endSetup();
    }
}
