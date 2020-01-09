<?php


class AdminController
{
    public function actionIndex()
    {
        require_once (ROOT.'/admin/index.php');
        return true;
    }
}