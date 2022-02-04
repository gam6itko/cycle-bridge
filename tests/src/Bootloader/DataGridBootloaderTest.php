<?php

declare(strict_types=1);

namespace Spiral\Tests\Bootloader;

use Spiral\Cycle\DataGrid\GridInput;
use Spiral\Cycle\DataGrid\Response\GridResponse;
use Spiral\Cycle\DataGrid\Response\GridResponseInterface;
use Spiral\DataGrid\Compiler;
use Spiral\DataGrid\Grid;
use Spiral\DataGrid\GridFactory;
use Spiral\DataGrid\GridFactoryInterface;
use Spiral\DataGrid\GridInterface;
use Spiral\DataGrid\InputInterface;
use Spiral\DataGrid\WriterInterface;
use Spiral\Tests\BaseTest;

final class DataGridBootloaderTest extends BaseTest
{
    public function testGetsGridInput(): void
    {
        $this->assertContainerBound(InputInterface::class, GridInput::class);
    }

    public function testGetsGrid(): void
    {
        $this->assertContainerBound(GridInterface::class, Grid::class);
    }

    public function testGetsGridFactory(): void
    {
        $this->assertContainerBound(GridFactoryInterface::class, GridFactory::class);
        $this->assertContainerBound(GridFactory::class);
    }

    public function testGetsCompilerWithDefaultWriters(): void
    {
        $this->assertInstanceOf(
            Compiler::class,
            $compiler = $this->getContainer()->get(Compiler::class)
        );

        $writers = $this->accessProtected($compiler, 'writers');

        $this->assertCount(2, $writers);
        $this->assertContainsOnlyInstancesOf(WriterInterface::class, $writers);
    }

    public function testGetsCompilerWithWritersFromConfig(): void
    {
        $this->updateConfig('dataGrid.writers', []);
        $this->assertInstanceOf(
            Compiler::class,
            $compiler = $this->getContainer()->get(Compiler::class)
        );

        $writers = $this->accessProtected($compiler, 'writers');

        $this->assertCount(0, $writers);
    }

    public function testGetsGridResponse(): void
    {
        $this->assertContainerBound(GridResponseInterface::class, GridResponse::class);
    }
}
