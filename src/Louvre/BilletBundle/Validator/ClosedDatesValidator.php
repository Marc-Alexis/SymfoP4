<?php

namespace Louvre\BilletBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ClosedDatesValidator extends ConstraintValidator
{
    public function validate($date, Constraint $constraint)
    {
        $yesterday = new \DateTime('- 1 day');
        $array = ['01-11-17', '11-11-17', '25-12-17', '01-01-18', '02-04-18', '01-05-18', '10-05-18', '21-05-18', '14-07-18', '15-08-18'];
        $dateClosed = false;
        if (isset($date) && !empty($date)):
            if ($date->format('D') == 'Sun' || $date->format('D') == 'Tue') {
                $dateClosed = true;
            } elseif ($date <= $yesterday){
                $dateClosed = true;
            } if (in_array($date->format('d-m-y'), $array)){
                $dateClosed = true;
            }
            if ($dateClosed == true) {
                $this->context->addViolation($constraint->message);
            }
        endif;
    }
}