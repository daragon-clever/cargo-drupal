<?php

namespace Drupal\offres_prestataires\Helper;


class Operator
{
    const EQUAL = "\$eq:";
    const DIFFERENT = "\$nq:";
    const CONTAIN = "\$co:";
    const START_BY = "\$sw:";
    const END_BY = "\$ew:";
    const GREATER_OR_EQUAL = "\$ge:";
    const GREATER = "\$gt:";
    const SMALLER_OR_EQUAL = "\$le:";
    const SMALLER = "\$lt:";

    const OR = "\$or\$";
    const AND = "\$and\$";
}