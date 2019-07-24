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

namespace Sonata\BlockBundle\Block;

use Sonata\BlockBundle\Exception\BlockNotFoundException;
use Sonata\BlockBundle\Model\BlockInterface;

final class BlockLoaderChain implements BlockLoaderInterface
{
    /**
     * @var BlockLoaderInterface[]
     */
    private $loaders;

    /**
     * @param BlockLoaderInterface[] $loaders
     */
    public function __construct(array $loaders)
    {
        $this->loaders = $loaders;
    }

    /**
     * Check if a given block type exists.
     *
     * @param string $type Block type to check for
     */
    public function exists(string $type): bool
    {
        foreach ($this->loaders as $loader) {
            if ($loader->exists($type)) {
                return true;
            }
        }

        return false;
    }

    public function load($block): BlockInterface
    {
        foreach ($this->loaders as $loader) {
            if ($loader->support($block)) {
                return $loader->load($block);
            }
        }

        throw new BlockNotFoundException();
    }

    public function support($name): bool
    {
        return true;
    }
}
