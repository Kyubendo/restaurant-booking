<?php


class MainController
{
    public function actionIndex()
    {
        require_once (ROOT.'/main/index.php');
        return true;
    }
}