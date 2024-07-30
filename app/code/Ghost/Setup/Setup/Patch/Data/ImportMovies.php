<?php declare(strict_types=1);

namespace Ghost\Setup\Setup\Patch\Data;

use Ghost\Setup\Setup\DataHelper;
use Ghost\Setup\Setup\FileManager;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\App\ResourceConnection;

/**
 * Patch is mechanism, that allows to do atomic upgrade data changes
 */
class ImportMovies implements DataPatchInterface
{
    /**
     * Constructor
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param FileManager $fileManager
     * @param DataHelper $dataHelper
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        protected ModuleDataSetupInterface $moduleDataSetup,
        protected FileManager              $fileManager,
        protected DataHelper               $dataHelper,
        protected ResourceConnection       $resourceConnection
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
        $output->writeln('<info>Start Import Movies</info>');
        $start = microtime(true);
        $movies = $this->fileManager->getParsedFixtureData('Ghost_Setup::Setup/fixtures/movies.csv');
        $this->dataHelper->importData(
            'movie',
            $this->getMoviesData($movies)
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
        return [ImportDirectors::class, ImportActors::class];
    }

    /**
     * Get movies data
     *
     * @param array $movies
     * @return array
     */
    protected function getMoviesData(array $movies): array
    {
        $directors = $this->dataHelper->getData('director', 'name');
        foreach ($movies as &$movie) {
            $movie['director_id'] = $directors[$movie['director']];
            unset($movie['director']);
        }
        return $movies;
    }
}
