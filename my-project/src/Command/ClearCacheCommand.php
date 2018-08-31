<?php

namespace App\Command;

use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class ClearCacheCommand extends ContainerAwareCommand
{
    private $filesystem;

    public function __construct(Filesystem $filesystem = null)
    {
        parent::__construct();

        $this->filesystem = $filesystem ?: new Filesystem();
    }

    protected function configure()
    {
        $this
            ->setName('cmd:clear_cache')
            ->setDescription('Очитска кеша')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $realCacheDir = $this->getContainer()->getParameter('kernel.cache_dir');

        if (!is_writable($realCacheDir)) {
            throw new RuntimeException(sprintf('Unable to write in the "%s" directory', $realCacheDir));
        }

        // Вариант 1
        $this->getContainer()->get('cache_clearer')->clear($this->getContainer()->getParameter('kernel.cache_dir'));

        // Вариант 2
        exec("php bin/console cache:clear --env=prod");

        // Можно еще попробывать просто чистить папку с кешем. Но что-то мне здается что это плохое решение ибо можно лишнего наудалять
    }
}