<?php
require_once(  dirname(dirname(__FILE__)).'/funcoes.php' );
function __autoload($classe){
    $classe = str_replace('..', '', $classe);
    require_once( dirname(__FILE__)."/$classe.class.php" );
}