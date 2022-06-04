<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Twig;

use App\Repository\BookmarkRepository;
use App\Twig\DatatableExtensions;
use PHPUnit\Framework\TestCase;
use Twig\TwigFunction;

/**
 * @covers \App\Twig\DatatableExtensions
 */
class DatatableExtensionsTest extends TestCase
{
    protected function getSut(string $locale): DatatableExtensions
    {
        $repository = $this->createMock(BookmarkRepository::class);

        return new DatatableExtensions($repository);
    }

    public function testGetFunctions()
    {
        $functions = ['initialize_datatable', 'datatable_column_class'];
        $sut = $this->getSut('de');
        $twigFunctions = $sut->getFunctions();
        $this->assertCount(\count($functions), $twigFunctions);
        $i = 0;
        foreach ($twigFunctions as $function) {
            $this->assertInstanceOf(TwigFunction::class, $function);
            $this->assertEquals($functions[$i++], $function->getName());
        }
    }
}
