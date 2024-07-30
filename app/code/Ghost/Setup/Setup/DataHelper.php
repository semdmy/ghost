<?php declare(strict_types=1);

namespace Ghost\Setup\Setup;

use Ghost\Movie\Model\ResourceModel\Movie;
use Magento\Framework\App\ResourceConnection;

class DataHelper
{
    /**
     * Constructor.
     *
     * @param Movie $movieResourceModel
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        protected Movie              $movieResourceModel,
        protected ResourceConnection $resourceConnection
    )
    {
    }

    /**
     * ImportData
     *
     * @param string $table
     * @param array $rows
     * @return void
     */
    public function importData(string $table, array $rows): void
    {
        $connection = $this->movieResourceModel->getConnection();
        $connection->insertMultiple($table, $rows);
    }

    /**
     * Get data
     *
     * @param string $tableName
     * @param string $columnName
     * @return array
     */
    public function getData(string $tableName, string $columnName): array
    {
        $connection = $this->resourceConnection->getConnection();
        $tableName = $this->resourceConnection->getTableName($tableName);
        $sql = $connection->select()->from($tableName);
        $data = $connection->fetchAll($sql);
        $result = [];
        foreach ($data as $datum) {
            $result[$datum[$columnName]] = $datum[$tableName . '_id'];
        }
        return $result;
    }
}
