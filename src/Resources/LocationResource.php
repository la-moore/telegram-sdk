<?php
namespace LaMoore\Tg\Resources;

class LocationResource extends BaseResource
{
    public float $latitude;
    public float $longitude;
    public float $horizontal_accuracy;
    public int $live_period;
    public int $heading;
    public int $proximity_alert_radius;
}
