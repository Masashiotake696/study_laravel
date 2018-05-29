<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
  protected $fillable = ['stock'];

  /*
  * ProductモデルとStockモデルを一対一とする
  * @return Productモデルに関連したStockモデル
  */
  public function product() {
    return $this->belongsTo('App\Product');
  }
}
