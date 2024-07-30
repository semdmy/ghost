<?php declare(strict_types=1);

namespace Ghost\Setup\Setup\Patch\Data;

use Ghost\Setup\Setup\DataHelper;
use Ghost\Setup\Setup\FileManager;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

/**
 * Patch is mechanism, that allows to do atomic upgrade data changes
 */
class ImportDirectors implements DataPatchInterface
{
    /**
     * Constructor.
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param FileManager $fileManager
     * @param DataHelper $dataHelper
     */
    public function __construct(
        protected ModuleDataSetupInterface $moduleDataSetup,
        protected FileManager              $fileManager,
        protected DataHelper               $dataHelper
    )
    {
    }

    /**
     * Do Upgrade
     *
     * @return void
     * @throws LocalizedException
     */
    public function apply(): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $output = $this->fileManager->getOutputStream();
        $output->writeln('<info>Start Import Directors</info>');
        $start = microtime(true);
        $this->dataHelper->importData(
            'director',
            $this->fileManager->getParsedFixtureData('Ghost_Setup::Setup/fixtures/directors.csv')
        );
        $output->writeln('<info>Finish</info>');
        $timeSpent = round((microtime(true) - $start) / 60, 2);
        $output->writeln('<info>Import done in: ' . $timeSpent . ' min.</info>');
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * @inheritdoc
     */
    public function getAliases(): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies(): array
    {
        return [];
    }
}
