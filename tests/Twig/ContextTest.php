<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Twig;

use App\Configuration\SystemConfiguration;
use App\Tests\Configuration\TestConfigLoader;
use App\Twig\Context;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @covers \App\Twig\Context
 * @covers \App\Configuration\SystemConfiguration
 */
class ContextTest extends TestCase
{
    protected function getSut(array $settings, array $headers = []): Context
    {
        $loader = new TestConfigLoader([]);
        $config = new SystemConfiguration($loader, ['theme' => $settings]);

        $stack = new RequestStack();
        $request = new Request();
        foreach ($headers as $name => $value) {
            $request->headers->set($name, $value);
        }
        $stack->push($request);

        return new Context($config, $stack);
    }

    /**
     * @return array
     */
    protected function getDefaultSettings()
    {
        return [
            'show_about' => true,
            'chart' => [
                'background_color' => 'rgba(0,115,183,0.7)',
                'border_color' => '#3b8bba',
                'grid_color' => 'rgba(0,0,0,.05)',
                'height' => '200'
            ],
            'branding' => [
                'logo' => 'Logooooo',
                'mini' => 'Mini2',
                'company' => 'Super Kimai',
                'title' => null,
            ],
        ];
    }

    public function testBranding()
    {
        $sut = $this->getSut($this->getDefaultSettings());
        $this->assertEquals('Super Kimai', $sut->getBranding('company'));
        $this->assertEquals('Logooooo', $sut->getBranding('logo'));
        $this->assertEquals('Mini2', $sut->getBranding('mini'));
    }

    public function testIsModalRequest()
    {
        $sut = $this->getSut($this->getDefaultSettings());
        self::assertFalse($sut->isModalRequest());

        $sut = $this->getSut($this->getDefaultSettings(), ['X-Requested-With' => 'XMLHttpRequest']);
        self::assertTrue($sut->isModalRequest());

        $sut = $this->getSut($this->getDefaultSettings(), ['X-Requested-With' => 'Kimai-Modal']);
        self::assertTrue($sut->isModalRequest());
    }
}
