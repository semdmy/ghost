<?php declare(strict_types=1);

namespace Ghost\Setup\Setup;

use Exception;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\SampleData\FixtureManager;
use Magento\Framework\File\Csv;
use Magento\Framework\Filesystem\Driver\File;
use Symfony\Component\Console\Output\StreamOutput;

/**
 * Class FileManager, setup file manager
 */
class FileManager
{
    /** @var StreamOutput */
    protected StreamOutput $output;

    /** @var File */
    protected File $file;

    /** @var FixtureManager */
    protected FixtureManager $fixtureManager;

    /** @var Csv */
    protected Csv $csv;

    /**
     * AbstractPatch constructor.
     *
     * @param File $file
     * @param FixtureManager $fixtureManager
     * @param Csv $csv
     *
     * @throws FileSystemException
     */
    public function __construct(
        File           $file,
        FixtureManager $fixtureManager,
        Csv            $csv
    )
    {
        $this->output = new StreamOutput($file->fileOpen('php://stdout', 'w'));
        $this->fixtureManager = $fixtureManager;
        $this->csv = $csv;
    }

    /**
     * Get parsed fixtures data
     *
     * @param string $fixture
     *
     * @return array
     *
     * @throws LocalizedException
     * @throws Exception
     */
    public function getParsedFixtureData(string $fixture): array
    {
        $rows = $this->csv->getData($this->fixtureManager->getFixture($fixture));
        $rowsHeader = array_shift($rows);
        foreach ($rows as &$row) {
            $row = array_combine($rowsHeader, $row);
        }
        return $rows;
    }

    /**
     * Get output stream
     *
     * @return StreamOutput
     */
    public function getOutputStream(): StreamOutput
    {
        return $this->output;
    }
}
