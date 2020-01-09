<?php


class TimePrController
{
    public function actionIndex()
    {
        require_once(ROOT.'/main/reservation-time/time-processing.php');
        return true;
    }

}