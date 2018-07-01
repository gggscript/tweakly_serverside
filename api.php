<?php
  require_once('coinhive-api.php');
  $coinhive = new CoinHiveAPI('fEQzhqzuGmjLAALli7FpQq5MQN3wR1gX');
//Replace this token with your own ^^^^^^^^^^^^^^^^^^^^^^^^^

  //get action
  $action = $_GET['action'];

  if ($action == "balance") {
    //get username
    $userName = getHeader('username');
    $user = $coinhive->get('/user/balance', ['name' => $userName]);
    //success?
    if ($user->success == 1) {
      echo "{\"success\":true,\"name\":\"$user->name\",\"total\":$user->total,\"withdrawn\":$user->withdrawn,\"balance\":$user->balance}";
    } else {
      echo "{\"success\":false,\"error\":\"$user->error\"}";
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
  } else {
    echo "{\"success\":false,\"error\":\"unknown_action\"}";
  }

  function getHeader($headerName){
    foreach ($_GET as $key => $value) {
      if ($key == $headerName) {
        return $value;
      }
    }
  }
?>
