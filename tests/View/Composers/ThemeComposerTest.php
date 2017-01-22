<?php

namespace REBELinBLUE\Deployer\Tests\Views\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use REBELinBLUE\Deployer\Tests\TestCase;
use REBELinBLUE\Deployer\View\Composers\ThemeComposer;

class ThemeComposerTest extends TestCase
{
    public function testCompose()
    {
        $expected_theme = config('deployer.theme');

        $view = $this->getMockBuilder(View::class)
                     ->disableOriginalConstructor()
                     ->getMock();

        $view->expects($this->any())
             ->method('with')
             ->withConsecutive(
                 [$this->equalTo('theme'), $this->equalTo($expected_theme)],
                 [$this->equalTo('theme'), $this->equalTo('pink')]
             );

        $composer = new ThemeComposer;
        $composer->compose($view);

        Auth::shouldReceive('user')
            ->once()
            ->andReturn((object) ['skin' => 'pink']);

        $composer->compose($view);
    }
}