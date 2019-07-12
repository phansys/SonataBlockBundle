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

use Sonata\BlockBundle\Block\BlockServiceManagerInterface;
use Symfony\Component\Console\Command\Command;

/**
 * @deprecated since sonata-project/block-bundle 3.x, to be removed in 4.0
 */
abstract class BaseCommand extends Command
{
    /**
     * @var BlockServiceManagerInterface
     */
    protected $blockManager;

    public function __construct(?string $name, BlockServiceManagerInterface $blockManager)
    {
        $this->blockManager = $blockManager;

        parent::__construct($name);
    }
}
