<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Model;

/**
 * @internal
 */
class TimesheetCountedStatistic implements \JsonSerializable
{
    private int $counter = 0;
    private int $recordDuration = 0;
    private float $recordRate = 0.0;
    private float $internalRate = 0.0;

    private int $counterBillable = 0;
    private int $recordDurationBillable = 0;
    private float $recordRateBillable = 0.0;
    private float $internalRateBillable = 0.0;

    /**
     * For unified access, used in frontend.
     *
     * @return int
     */
    public function getCounter(): int
    {
        return $this->counter;
    }

    public function setCounter(int $counter): void
    {
        $this->counter = $counter;
    }

    public function getCounterBillable(): int
    {
        return $this->counterBillable;
    }

    public function setCounterBillable(int $counter): void
    {
        $this->counterBillable = $counter;
    }

    /**
     * For unified access, used in frontend.
     *
     * @return int
     */
    public function getValue(): int
    {
        return $this->getDuration();
    }

    public function setDuration(int $duration): void
    {
        $this->recordDuration = $duration;
    }

    /**
     * For unified access, used in frontend.
     *
     * @return int
     */
    public function getDuration(): int
    {
        return $this->recordDuration;
    }

    /**
     * For unified access, used in frontend.
     *
     * @return float
     */
    public function getRate(): float
    {
        return $this->recordRate;
    }

    public function setRate(float $rate): void
    {
        $this->recordRate = $rate;
    }

    /**
     * Returns the total internal rate of all included timesheet records.
     *
     * @return float
     */
    public function getInternalRate(): float
    {
        return $this->internalRate;
    }

    public function getInternalRateBillable(): float
    {
        return $this->internalRateBillable;
    }

    public function setInternalRateBillable(float $internalRateBillable): void
    {
        $this->internalRateBillable = $internalRateBillable;
    }

    public function setInternalRate(float $internalRate): void
    {
        $this->internalRate = $internalRate;
    }

    public function getDurationBillable(): int
    {
        return $this->recordDurationBillable;
    }

    public function setDurationBillable(int $recordDuration): void
    {
        $this->recordDurationBillable = $recordDuration;
    }

    public function getRateBillable(): float
    {
        return $this->recordRateBillable;
    }

    public function setRateBillable(float $recordRate): void
    {
        $this->recordRateBillable = $recordRate;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'duration' => $this->recordDuration,
            'duration_billable' => $this->recordDurationBillable,
            'rate' => $this->recordRate,
            'rate_billable' => $this->recordRateBillable,
            'rate_internal' => $this->internalRate,
            'amount' => $this->counter,
            'amount_billable' => $this->counterBillable,
        ];
    }
}
