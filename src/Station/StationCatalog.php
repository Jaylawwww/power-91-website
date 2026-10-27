<?php

namespace App\Station;

final class StationCatalog
{
    /**
     * Studio location. Change these four lines (and TIMEZONE) if the station moves.
     * CITY is the short name on the homepage and footer.
     * STUDIO_ADDRESS is the full line under "Our Station Address".
     */
    public const TIMEZONE = 'Asia/Manila';
    public const TIMEZONE_LABEL = 'Philippine time';
    public const NAME = 'Power 91';
    public const FREQUENCY = '91';
    public const CITY = 'Dumaguete City, Philippines';
    public const TAGLINE = 'Sibya anang balanse og kadangpanan sa tanan';
    public const STUDIO_LINE = '(035) 555-0191';
    public const STUDIO_ADDRESS = 'Broadcast studio, Dumaguete City, Negros Oriental, Philippines';
    public const STUDIO_HOURS = 'Weekdays 6 AM – midnight Philippine time';

    /**
     * @return list<Show>
     */
    public function featuredShows(): array
    {
        return [
            new Show(
                'Morning Power',
                'Wake up with the mix',
                'Dumaguete mornings with traffic, talk, and a playlist that jumps decades without losing the groove.',
                'John Navarro',
                'Weekdays 6 – 10 AM',
            ),
            new Show(
                'Midday Variety',
                'Decades mix',
                'Dions keeps the afternoon honest: gold, currents, and the records that still work on a bright Dumaguete lunch hour.',
                'Dions Manaban',
                'Weekdays 10 AM – 2 PM',
            ),
            new Show(
                'The Drive Home',
                'Gold, new, and everything between',
                'Ms. Jo and Anthony ride the commute with requests, shout-outs, and the songs that still fill a parking lot.',
                'Ms. Jo & Anthony',
                'Weekdays 2 – 7 PM',
            ),
            new Show(
                'Night Frequency',
                'After dark, no format',
                'Deep cuts, late dedications, and a slower pulse once the city lights up.',
                'Charlie',
                'Nights 7 PM – 12 AM',
            ),
            new Show(
                'Weekend Flashback',
                'The long mix',
                'Saturday mornings built for yards, boats, and every chorus you still know by heart.',
                'Dions Manaban',
                'Saturdays 8 AM – 12 PM',
            ),
            new Show(
                'Club 91',
                'Saturday after dark',
                'Dance records, groove edits, and a longer mix once the Dumaguete weekend is underway.',
                'Charlie',
                'Saturdays 6 PM – 12 AM',
            ),
            new Show(
                'Sunday Soft',
                'Easy favorites',
                'A calmer first half of Sunday: ballads, familiar choruses, and room to let a record finish.',
                'John Navarro',
                'Sundays 8 AM – 12 PM',
            ),
            new Show(
                'Request Hour',
                'Listener picks',
                'Ms. Jo opens the board for dedications, shout-outs, and the track you need before Monday.',
                'Ms. Jo',
                'Sundays 12 – 6 PM',
            ),
        ];
    }

    /**
     * @return list<array{name: string, note: string}>
     */
    public function coastSpots(): array
    {
        return [
            ['name' => 'Rizal Boulevard', 'note' => 'Walk-up weekends'],
            ['name' => 'Silliman', 'note' => 'Campus hours'],
            ['name' => 'Hibbard Avenue', 'note' => 'The Drive Home'],
            ['name' => 'Bajumpandan', 'note' => 'Afternoon requests'],
            ['name' => 'Valencia', 'note' => 'Weekend flashbacks'],
            ['name' => 'Dauin', 'note' => 'Overnight mix'],
        ];
    }

    /**
     * @return list<array{name: string, note: string}>
     */
    public function listenWays(): array
    {
        return [
            ['name' => 'Live stream', 'note' => 'Player on every page'],
            ['name' => 'Studio clock', 'note' => 'Philippine time, all day'],
            ['name' => 'Song requests', 'note' => 'Read on air when it fits'],
            ['name' => 'Weekend board', 'note' => 'Flashback to Club 91'],
        ];
    }

    /**
     * On-air team. Edit a Host() to rename someone. Copy a Host() block to add someone.
     * The On-air Team page lists everyone here automatically — no extra files.
     *
     * @return list<Host>
     */
    public function hosts(): array
    {
        return [
            new Host(
                'John Navarro',
                'Morning host',
                'Morning Power',
                'John opens Dumaguete mornings with local notes, no-skip records, and a clock that respects your first cup of coffee.',
                'JN',
                '#f5c518',
            ),
            new Host(
                'Dions Manaban',
                'Music director',
                'Midday Variety',
                'If it earned a chorus between 1972 and this week, Dions has a reason it belongs on Power 91.',
                'DM',
                '#e10600',
            ),
            new Host(
                'Ms. Jo',
                'Afternoon host',
                'The Drive Home',
                'Ms. Jo runs the phones, the requests, and the kind of energy that makes Hibbard feel shorter.',
                'MJ',
                '#ff7a18',
            ),
            new Host(
                'Anthony',
                'Afternoon co-host',
                'The Drive Home',
                'Anthony brings the deep cuts and the sports desk, then gets out of the way when the record is hot.',
                'AN',
                '#7ad7ff',
            ),
            new Host(
                'Charlie',
                'Night host',
                'Night Frequency',
                'Charlie treats late night like a club with the lights down: longer mixes, quieter talk, bigger records.',
                'CH',
                '#c084fc',
            ),
        ];
    }

    /**
     * @return list<ScheduleSlot>
     */
    public function schedule(): array
    {
        $weekdays = [1, 2, 3, 4, 5];

        return [
            new ScheduleSlot('After Hours Mix', 'Power 91 Automation', 'Variety', 0, 6, $weekdays),
            new ScheduleSlot('Morning Power', 'John Navarro', 'Hits & talk', 6, 10, $weekdays),
            new ScheduleSlot('Midday Variety', 'Dions Manaban', 'Decades mix', 10, 14, $weekdays),
            new ScheduleSlot('The Drive Home', 'Ms. Jo & Anthony', 'Requests', 14, 19, $weekdays),
            new ScheduleSlot('Night Frequency', 'Charlie', 'After dark', 19, 24, $weekdays),
            new ScheduleSlot('After Hours Mix', 'Power 91 Automation', 'Variety', 0, 8, [6, 7]),
            new ScheduleSlot('Weekend Flashback', 'Dions Manaban', '70s–90s', 8, 12, [6]),
            new ScheduleSlot('Saturday Variety', 'Power 91 Mix', 'Multi-genre', 12, 18, [6]),
            new ScheduleSlot('Club 91', 'Charlie', 'Dance & groove', 18, 24, [6]),
            new ScheduleSlot('Sunday Soft', 'John Navarro', 'Easy favorites', 8, 12, [7]),
            new ScheduleSlot('Request Hour', 'Ms. Jo', 'Listener picks', 12, 18, [7]),
            new ScheduleSlot('The Long Play', 'Dions Manaban', 'Album hours', 18, 22, [7]),
            new ScheduleSlot('After Hours Mix', 'Power 91 Automation', 'Variety', 22, 24, [7]),
        ];
    }

    public function now(?\DateTimeImmutable $at = null): \DateTimeImmutable
    {
        $timezone = new \DateTimeZone(self::TIMEZONE);
        $at ??= new \DateTimeImmutable('now', $timezone);

        return $at->setTimezone($timezone);
    }

    public function onAir(?\DateTimeImmutable $at = null): ScheduleSlot
    {
        $time = $this->now($at);

        foreach ($this->schedule() as $slot) {
            if ($slot->isLiveAt($time)) {
                return $slot;
            }
        }

        return new ScheduleSlot('Power 91 Mix', 'The station', 'Variety', 0, 24, [1, 2, 3, 4, 5, 6, 7]);
    }

    /**
     * @return list<ScheduleSlot>
     */
    public function slotsForWeekday(int $weekday): array
    {
        $slots = array_values(array_filter(
            $this->schedule(),
            static fn (ScheduleSlot $slot): bool => $slot->airsOn($weekday),
        ));

        usort($slots, static fn (ScheduleSlot $a, ScheduleSlot $b): int => $a->startHour <=> $b->startHour);

        return $slots;
    }

    /**
     * @return list<array{name: string, weekday: int, slots: list<ScheduleSlot>}>
     */
    public function weeklyGrid(): array
    {
        $names = [1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday', 7 => 'Sunday'];
        $grid = [];

        foreach ($names as $weekday => $name) {
            $grid[] = [
                'name' => $name,
                'weekday' => $weekday,
                'slots' => $this->slotsForWeekday($weekday),
            ];
        }

        return $grid;
    }
}
