<?php declare(strict_types=1);

namespace Tuli\Tuli;

Class Tuli {

  public function run(){
    return print('Tuli running...');
  }

}

$tuli = new Tuli();
$tuli->run();
