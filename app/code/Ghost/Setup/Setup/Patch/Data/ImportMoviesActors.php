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
class ImportMoviesActors implements DataPatchInterface
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
        $output->writeln('<info>Start Import Movies Actors</info>');
        $start = microtime(true);
        $moviesActors = $this->fileManager->getParsedFixtureData('Ghost_Setup::Setup/fixtures/movies_actors.csv');
        $this->dataHelper->importData(
            'movie_actor',
            $this->getMoviesActorsData($moviesActors)
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
        return [ImportMovies::class, ImportActors::class];
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * Get movies actors data
     *
     * @param array $moviesActors
     * @return array
     */
    protected function getMoviesActorsData(array $moviesActors): array
    {
        $movies = $this->dataHelper->getData('movie', 'name');
        $actors = $this->dataHelper->getData('actor', 'name');
        $result = [];
        foreach ($moviesActors as $data => $datum) {
            $result[] = [
                'movie_id' => $movies[$datum['movie_name']],
                'actor_id' => $actors[$datum['actor']]
            ];
        }
        return $result;
    }
}
