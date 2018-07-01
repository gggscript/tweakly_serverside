<?php
  require_once('coinhive-api.php');
  $config = parse_ini_file('config.ini');
  $coinhive = new CoinHiveAPI($config['secretkey']);

  //get action
  $action = getallheaders()['action'];

  if ($action == "balance") {
    //get username
    $userName = getHeader('username');
    $user = $coinhive->get('/user/balance', ['name' => $userName]);
    //success?
    if ($user->success == 1) {
      echo "{\"success\":true,\"name\":\"$user->name\",\"total\":$user->total,\"withdrawn\":$user->withdrawn,\"balance\":$user->balance}";
    } else {
      echo "{\"success\":false,\"error\":\"$users->error\"}";
    }
  } elseif ($action == "withdraw") {
    //get username + amount
    $userName = getHeader('username');
    $amount = getHeader('amount');
    $w = $coinhive->post('/user/withdraw', ['name' => $userName, 'amount' => $amount]);
    if ($w->success == 1) {
      echo "{\"success\":true,\"name\":\"$w->name\",\"amount\":$w->amount}";
    } else {
      echo "{\"success\":false,\"error\":\"$w->error\"}";
    }
  } elseif ($action == "stats") {
    $stats = $coinhive->get('/stats/site');
    if ($stats->success == 1) {
      echo "{\"success\":true,\"totalhashrate\":$stats->hashesPerSecond}";
    } else {
      echo "{\"success\":false,\"error\":\"$stats->error\"}";
    }
  }

  function getHeader($headerName){
    foreach (getallheaders() as $key => $value) {
      if ($key == $headerName) {
        return $value;
      }
    }
  }
?>
