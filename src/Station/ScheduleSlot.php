<?php

namespace App\Station;

final readonly class ScheduleSlot
{
    /**
     * @param list<int> $weekdays ISO-8601 weekdays (1 = Monday, 7 = Sunday)
     */
    public function __construct(
        public string $title,
        public string $host,
        public string $genre,
        public int $startHour,
        public int $endHour,
        public array $weekdays,
    ) {
    }

    public function airsOn(int $weekday): bool
    {
        return \in_array($weekday, $this->weekdays, true);
    }

    public function isLiveAt(\DateTimeImmutable $time): bool
    {
        if (!$this->airsOn((int) $time->format('N'))) {
            return false;
        }

        $hour = (int) $time->format('G');

        if ($this->endHour > $this->startHour) {
            return $hour >= $this->startHour && $hour < $this->endHour;
        }

        return $hour >= $this->startHour || $hour < $this->endHour;
    }

    public function windowLabel(): string
    {
        return sprintf('%s – %s', $this->formatHour($this->startHour), $this->formatHour($this->endHour));
    }

    private function formatHour(int $hour): string
    {
        $normalized = $hour % 24;
        $period = $normalized >= 12 ? 'PM' : 'AM';
        $twelve = $normalized % 12;

        if (0 === $twelve) {
            $twelve = 12;
        }

        return sprintf('%d %s', $twelve, $period);
    }
}
