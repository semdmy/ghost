<?php declare(strict_types=1);

namespace Ghost\Movie\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Ghost\Movie\Api\Data\MovieInterface;

class Movie extends AbstractDb
{

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(MovieInterface::TABLE_NAME, 'movie_id');
    }
}
