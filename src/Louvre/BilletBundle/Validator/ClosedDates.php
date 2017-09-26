<?php

namespace Louvre\BilletBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ClosedDates extends Constraint
{
    public $message = "Date invalide";
}