<?php

class CmsService{
  protected $base_url;
  protected $access_token;
  protected $page_token;

  function __construct($page_token = null){
    $this->base_url = getenv('CMS_URL');
    $this->access_token = getenv('CMS_ACCESS_TOKEN');
    $this->page_token = $page_token ?? $this->access_token;
  }

  public function get($url, $is_page_token = true){
    $curl = curl_init();
    curl_setopt_array($curl, [
      CURLOPT_URL => $this->base_url."api/".$url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_POSTFIELDS => "",
      CURLOPT_HTTPHEADER => [
        "access_token: ".(
          $is_page_token ? $this->page_token : $this->access_token
        )
      ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);
    
    $response = json_decode($response);
    return [$response, $err];
  }

  public function getPageToken($page_slug = null){
    if(!$page_slug)  return $this->page_token;
    
    [$data, $err] = $this->get("page/token/".$page_slug."/".getenv('CMS_THEME_SLUG'), false);
    
    if($err) return (object)[
      'result' => false,
      'response' => 'Houve um erro inesperado a solicitar os dados da página'
    ];

    if($data->result){
      $this->setPageToken($data->response->access_token);
      return (object)[
        'result' => true,
        'response' => $data->response->access_token
      ];
    }
    return $data;
  }

  public function setPageToken($token){
    $this->page_token = $token;
  }
}