<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Validator\Constraints;

use Doctrine\Common\Annotations\Annotation\Target;

/**
 * @Annotation
 * @Target({"CLASS", "PROPERTY", "METHOD", "ANNOTATION"})
 */
class TimesheetBasic extends TimesheetConstraint
{
    public const MISSING_BEGIN_ERROR = 'kimai-timesheet-81';
    public const END_BEFORE_BEGIN_ERROR = 'kimai-timesheet-82';
    public const MISSING_ACTIVITY_ERROR = 'kimai-timesheet-84';
    public const MISSING_PROJECT_ERROR = 'kimai-timesheet-85';
    public const ACTIVITY_PROJECT_MISMATCH_ERROR = 'kimai-timesheet-86';
    public const DISABLED_ACTIVITY_ERROR = 'kimai-timesheet-87';
    public const DISABLED_PROJECT_ERROR = 'kimai-timesheet-88';
    public const DISABLED_CUSTOMER_ERROR = 'kimai-timesheet-89';
    public const PROJECT_NOT_STARTED = 'kimai-timesheet-91';
    public const PROJECT_ALREADY_ENDED = 'kimai-timesheet-92';

    protected static $errorNames = [
        self::MISSING_BEGIN_ERROR => 'You must submit a begin date.',
        self::END_BEFORE_BEGIN_ERROR => 'End date must not be earlier then start date.',
        self::MISSING_ACTIVITY_ERROR => 'An activity needs to be selected.',
        self::MISSING_PROJECT_ERROR => 'A project needs to be selected.',
        self::ACTIVITY_PROJECT_MISMATCH_ERROR => 'Project mismatch, project specific activity and timesheet project are different.',
        self::DISABLED_ACTIVITY_ERROR => 'Cannot start a disabled activity.',
        self::DISABLED_PROJECT_ERROR => 'Cannot start a disabled project.',
        self::DISABLED_CUSTOMER_ERROR => 'Cannot start a disabled customer.',
        self::PROJECT_NOT_STARTED => 'The project has not started at that time.',
        self::PROJECT_ALREADY_ENDED => 'The project is finished at that time.',
    ];

    public $message = 'This timesheet has invalid settings.';

    public function getTargets(): string|array
    {
        return self::CLASS_CONSTRAINT;
    }
}
