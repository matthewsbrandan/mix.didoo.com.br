<?php

class DeployController{
  public static function execute(){
    $githubPayload = json_encode($_POST);
    $githubHash = $_SERVER['HTTP_X_HUB_SIGNATURE'];
    $localToken = getenv('DEPLOY_SECRET');
    $localHash = 'sha1=' . hash_hmac('sha1', $githubPayload, $localToken, false);
    if(hash_equals($githubHash, $localHash)){
      $output = shell_exec("git pull");
      return is_string($output) ? $output : json_encode($output);
    }
    else return http_response_code(403);
  }
}