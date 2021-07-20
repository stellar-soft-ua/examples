<?php

namespace ApiBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ContainsReportTimeGroupModeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!isset(ContainsReportTimeGroupMode::$modes[$value])) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }
}