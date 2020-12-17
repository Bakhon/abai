<?php


namespace App\Services;


class MapService
{
    public function calculateCenterOfCoordinates(array $coordinates)
    {
        $num_coords = count($coordinates);

        $X = 0.0;
        $Y = 0.0;
        $Z = 0.0;

        foreach ($coordinates as $coord) {
            $lat = $coord[0] * pi() / 180;
            $lon = $coord[1] * pi() / 180;

            $a = cos($lat) * cos($lon);
            $b = cos($lat) * sin($lon);
            $c = sin($lat);

            $X += $a;
            $Y += $b;
            $Z += $c;
        }

        $X /= $num_coords;
        $Y /= $num_coords;
        $Z /= $num_coords;

        $lon = atan2($Y, $X);
        $hyp = sqrt($X * $X + $Y * $Y);
        $lat = atan2($Z, $hyp);

        return [
            $lat * 180 / pi(),
            $lon * 180 / pi()
        ];
    }
}
