<?php

namespace Terraformers\KeysForCache\Tests\Extensions;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Dev\SapphireTest;
use Terraformers\KeysForCache\Extensions\FluentExtension;
use Terraformers\KeysForCache\Tests\Mocks\Pages\CachePage;
use TractorCow\Fluent\Model\Locale;
use TractorCow\Fluent\State\FluentState;

class FluentExtensionTest extends SapphireTest
{

    protected static $required_extensions = [
        SiteTree::class => [
            FluentExtension::class,
        ],
    ];

    protected static $fixture_file = 'FluentExtensionTest.yml';

    public function testUpdateCacheKey(): void
    {
        FluentState::singleton()->withState(function (FluentState $state): void {
            $state->setLocale('en_NZ');

            $locale = $this->objFromFixture(Locale::class, 'nz');
            $page = $this->objFromFixture(CachePage::class, 'page1');

            $this->assertContains($locale->Locale, $page->getCacheKey());
        });
    }

    public function testUpdateCacheKeyNoLocale(): void
    {
        FluentState::singleton()->withState(function (FluentState $state): void {
            $state->setLocale(null);

            $locale = $this->objFromFixture(Locale::class, 'nz');
            $page = $this->objFromFixture(CachePage::class, 'page1');

            $this->assertNotContains($locale->Locale, $page->getCacheKey());
        });
    }

}
