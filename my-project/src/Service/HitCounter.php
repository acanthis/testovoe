<?php
namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;

class HitCounter
{
    private const LOG_FILE = 'hits.txt';

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @return string
     */
    public function execute(): string
    {
        if (!$this->filesystem->exists(self::LOG_FILE)) {
            $this->filesystem->dumpFile(self::LOG_FILE, '');
        }

        $currentHitCount = file_get_contents(self::LOG_FILE);

        if (!$currentHitCount) {
            $currentHitCount = 0;
        }
        $this->filesystem->dumpFile(self::LOG_FILE, ++$currentHitCount);

        return $currentHitCount;
    }
}