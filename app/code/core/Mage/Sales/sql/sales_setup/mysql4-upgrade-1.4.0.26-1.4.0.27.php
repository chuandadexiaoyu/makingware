<?php
$installer = $this;
$installer->startSetup();

/**
 * 购物车增加  `namespace` 字段
 */
$installer->getConnection()
->addColumn(
	$installer->getTable('sales_flat_quote'),
    'namespace',
    'varchar(255) default NULL'
);

$installer->endSetup();