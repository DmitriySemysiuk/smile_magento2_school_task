<?php

namespace Smile\Customer\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements  UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if(version_compare($context->getVersion(), "0.0.2", "<"))
        {
            $table = $setup->getConnection()->newTable(
                $setup->getTable('customer_price_request')
            )->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true
                ],
                'Price request id'
            )->addColumn(
                'name',
                Table::TYPE_TEXT,
                255,
                [
                    'nullable' => false
                ],
                'Price request name'
            )->addColumn(
                "email",
                Table::TYPE_TEXT,
                "30",
                [
                    'nullable' => false
                ],
                "Price request email"
            )->addColumn(
                "comment",
                Table::TYPE_TEXT,
                "2M",
                [
                    'nullable' => false
                ],
                "Price request comment"
            )->addColumn(
                'created_at',
                Table::TYPE_TIMESTAMP,
                null,
                [
                    'nullable' => false,
                    'default' => Table::TIMESTAMP_INIT
                ],
                'Price request creation time'
            )->addColumn(
                "status",
                Table::TYPE_SMALLINT,
                null,
                [
                    "nullable" => false,
                    "default" => "1"
                ],
                "Price request status"
            )->addColumn(
                "answer",
                Table::TYPE_TEXT,
                "2M",
                [],
                "Price request answer"
            )->addColumn(
                "product_sku",
                Table::TYPE_TEXT,
                "64",
                [
                    "nullable" => false
                ],
                "Price request product stock keeping unit"
            )->addForeignKey(
                $setup->getFkName("customer_price_request", "product_sku", "catalog_product_entity", "sku"),
                "product_sku",
                $setup->getTable("catalog_product_entity"),
                "sku",
                Table::ACTION_CASCADE
            )->setComment(
                'Price request table'
            );

            $setup->getConnection()->createTable($table);
        }

        $setup->endSetup();
    }
}
