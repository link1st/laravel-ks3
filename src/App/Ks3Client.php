<?php

namespace link1st\Ks3\App;

class Ks3Client
{

    public function __construct()
    {
        $ksc_config = Config::get('ks3');
        dump($ksc_config);
    }


    public function index()
    {
        return 1;
    }

}