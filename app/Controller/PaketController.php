<?php

namespace Mahatech\AlindoExpress\Controller;

use Mahatech\AlindoExpress\App\View;

class PaketController{
    public function tambahPaket(){
        View::render('Paket/registerPaket');
    }
}