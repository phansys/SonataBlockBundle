<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\BlockBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class DebugBlocksCommand extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    protected static $defaultName = 'debug:sonata:block';

    /**
     * {@inheritdoc}
     */
    public function configure(): void
    {
        $this->setName(static::$defaultName); // BC for symfony/console < 3.4.0
        $this->setDescription('Debug all blocks available, show default settings of each block');

        $this->addOption('context', 'c', InputOption::VALUE_REQUIRED, 'display service for the specified context');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output): void
    {
        if ($input->getOption('context')) {
            $services = $this->blockManager->getServicesByContext($input->getOption('context'));
        } else {
            $services = $this->blockManager->getServices();
        }

        foreach ($services as $code => $service) {
            $output->writeln('');
            $output->writeln(sprintf('<info>>> %s</info> (<comment>%s</comment>)', $service->getName(), $code));

            $resolver = new OptionsResolver();
            $service->configureSettings($resolver);

            try {
                foreach ($resolver->resolve() as $key => $val) {
                    $output->writeln(sprintf('    %-30s%s', $key, json_encode($val)));
                }
            } catch (MissingOptionsException $e) {
                foreach ($resolver->getDefinedOptions() as $option) {
                    $output->writeln(sprintf('    %s', $option));
                }
            }
        }

        $output->writeln('done!');
    }
}
