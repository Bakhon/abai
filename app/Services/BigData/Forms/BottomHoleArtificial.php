<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

class BottomHoleArtificial extends BottomHole
{
    protected $configurationFileName = 'bottom_hole_artificial';
    protected $bottomHoleType = 'HUD';
    protected $dateValidationField = 'drill_end_date';
    protected $dateValidationErrorKey = 'bd.validation.end_date';

}
