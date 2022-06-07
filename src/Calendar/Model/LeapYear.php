<?php

namespace Calendar\Model;

/**
 * Class LeapYear
 * @package Calendar\Model
 */
class LeapYear
{
    /**
     * @param $year
     * @return bool
     */
    public function isLeapYear($year = null)
    {
        if (null === $year) {
            $year = date('Y');
        }

        return 0 === $year % 400 || (0 === $year % 4 && 0 !== $year % 100);
    }
}
