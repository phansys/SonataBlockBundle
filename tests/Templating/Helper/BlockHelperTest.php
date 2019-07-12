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

namespace Sonata\BlockBundle\Tests\Templating\Helper;

use PHPUnit\Framework\TestCase;
use Sonata\BlockBundle\Block\BlockContextManagerInterface;
use Sonata\BlockBundle\Block\BlockRendererInterface;
use Sonata\BlockBundle\Block\BlockServiceManagerInterface;
use Sonata\BlockBundle\Event\BlockEvent;
use Sonata\BlockBundle\Templating\Helper\BlockHelper;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

final class BlockHelperTest extends TestCase
{
    public function testRenderEventWithNoListener(): void
    {
        $blockServiceManager = $this->createMock(BlockServiceManagerInterface::class);
        $blockRenderer = $this->createMock(BlockRendererInterface::class);
        $blockContextManager = $this->createMock(BlockContextManagerInterface::class);
        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $eventDispatcher->expects($this->once())->method('dispatch')->willReturnCallback(static function ($name, BlockEvent $event) {
            return $event;
        });

        $helper = new BlockHelper($blockServiceManager, [], $blockRenderer, $blockContextManager, $eventDispatcher);

        $this->assertSame('', $helper->renderEvent('my.event'));
    }
}
