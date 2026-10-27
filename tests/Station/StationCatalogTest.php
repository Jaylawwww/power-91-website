<?php

namespace App\Tests\Station;

use App\Station\StationCatalog;
use PHPUnit\Framework\TestCase;

final class StationCatalogTest extends TestCase
{
    public function testWeekdayMorningShowIsOnAir(): void
    {
        $catalog = new StationCatalog();
        $slot = $catalog->onAir(new \DateTimeImmutable('2026-10-20 07:15:00', new \DateTimeZone(StationCatalog::TIMEZONE)));

        self::assertSame('Morning Power', $slot->title);
        self::assertSame('John Navarro', $slot->host);
    }

    public function testSaturdayNightClubShowIsOnAir(): void
    {
        $catalog = new StationCatalog();
        $slot = $catalog->onAir(new \DateTimeImmutable('2026-10-24 21:00:00', new \DateTimeZone(StationCatalog::TIMEZONE)));

        self::assertSame('Club 91', $slot->title);
    }

    public function testFeaturedShowsFillTheProgramGrid(): void
    {
        $catalog = new StationCatalog();

        self::assertCount(8, $catalog->featuredShows());
        self::assertNotSame([], $catalog->coastSpots());
        self::assertNotSame([], $catalog->listenWays());
        self::assertSame('Dumaguete City, Philippines', StationCatalog::CITY);
        self::assertStringContainsString('Dumaguete', StationCatalog::STUDIO_ADDRESS);
        self::assertSame(
            ['John Navarro', 'Dions Manaban', 'Ms. Jo', 'Anthony', 'Charlie'],
            array_map(static fn ($host): string => $host->name, $catalog->hosts()),
        );
    }

    public function testEveryHourHasAShow(): void
    {
        $catalog = new StationCatalog();
        $start = new \DateTimeImmutable('2026-10-19 00:30:00', new \DateTimeZone(StationCatalog::TIMEZONE));

        for ($hour = 0; $hour < 168; ++$hour) {
            $slot = $catalog->onAir($start->modify(sprintf('+%d hours', $hour)));
            self::assertNotSame('', $slot->title);
        }
    }
}
