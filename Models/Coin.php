<?php

namespace App\Models;

use App\Models\CoinPrice;

class Coin extends BaseModel {
    protected $table = 'coins';  
    protected $pk = 'coin_id';

    public function getPrices() {
        $coinPriceModel = new CoinPrice(); 
        return $coinPriceModel->findByCoinId($this->coin_id); 
    }
}
