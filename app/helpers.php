<?php
  use Jenssegers\Blade\Blade;
  
  $blade = new Blade('views', 'cache');

  function dd(){ // DUMP DIE
    $style = "background: #333; color: #bbd; border-radius: .4rem; padding: .8rem; overflow: auto; margin: 1rem 0;";
    foreach(func_get_args() as $arg){
      echo "<pre style='$style'>";
      var_dump($arg);
      echo "</pre>";
    }
    die;
  }
  function jd(){ // JSON DIE
    $style = "background: #333; color: #bbd; border-radius: .4rem; padding: .8rem; overflow: auto; margin: 1rem 0;";
    echo "<pre style='$style'>";
    echo json_encode(func_get_args());
    echo "</pre>";
    die;
  }
  function asset($path, $referer_cms = false){
    global $cms_url;
    $app_url = getenv('APP_URL');

    if($referer_cms) return $cms_url.$path;
    return $app_url."/"."public/".$path;
  }
  function getContent($content){
    if(preg_match( "/\/[a-z]*>/i",$content) != 0) return $content;
    return nl2br($content);
  }
  function handleNullIfArrayOrObject($data, $verify = true){
    // $verify = false anula a verifcação da função
    if($verify && (is_array($data) || is_object($data))) return null;
    return $data;
  }
  function handleVerifyAttrs($obj, $attrs, $nullIfArrayOrObject = true){
    if(is_array($obj)){
      if(is_array($attrs)){
        if(count($attrs) > 0){
          if(
            isset($obj[$attrs[0]]) &&
            $obj[$attrs[0]]
          ) return count($attrs) > 1 ? handleVerifyAttrs(
            $obj[$attrs[0]],
            array_splice($attrs, 1)
          ) : handleNullIfArrayOrObject($obj[$attrs[0]], $nullIfArrayOrObject);
        }
        return null;
      }
      else if(isset($obj[$attrs]) && $obj[$attrs]) return handleNullIfArrayOrObject($obj[$attrs], $nullIfArrayOrObject);
    }else{
      if(is_array($attrs)){
        if(count($attrs) > 0){
          $key = $attrs[0];
          if(isset($obj->$key) && $obj->$key){
            return count($attrs) > 1 ? handleVerifyAttrs(
              $obj->$key,
              array_splice($attrs, 1)
            ) : handleNullIfArrayOrObject($obj->$key, $nullIfArrayOrObject);
          }
        }
        return null;
      }
      else if(isset($obj->$attrs) && $obj->$attrs) return handleNullIfArrayOrObject($obj->$attrs, $nullIfArrayOrObject);
    }
    return null;
  }
  function innerStyleIssetAttr($prop, $obj, $attr, $default = null, $valeuFormatted = null, $is_important = false){
    $value = handleVerifyAttrs($obj, $attr);
    
    if($value) return innerStyle(
      $prop, $value, $default, $valeuFormatted, $is_important
    );

    if($default) return innerStyle(
      $prop, null, $default, $valeuFormatted, $is_important
    );

    return "";
  }
  function innerStyle($prop, $value = null, $default = null, $valeuFormatted = null, $is_important = false){
    if(isset($value) && $value) return handleStyleValueFormatted(
      $prop, $value, $valeuFormatted, $is_important
    );
    else if($default) return "$prop: $default". ($is_important ? ' !important ':'') .";";
    return "";
  }
  function handleStyleValueFormatted($prop, $value, $valeuFormatted, $is_important = false){
    if($valeuFormatted) return "$prop: $valeuFormatted". ($is_important ? ' !important ':'') .";";
    if(in_array($prop,['background-image','font-size'])){
      switch($prop){
        case 'background-image': return "$prop: url('$value')". ($is_important ? ' !important ':'') .";";
        case 'font-size': return "$prop: {$value}px". ($is_important ? ' !important ':'') .";";
      }
    }
    return "$prop: $value". ($is_important ? ' !important ':'') .";";
  }
  function view($name, $params = []){
    global $blade;
    return $blade->make($name, $params);
  }
  function frac_url($url){
    #region HANDLE QUERY PARAMS
    $indexStartQueryParams = strpos($url, '?');
    $hasQueryParams = $indexStartQueryParams !== false;
    $queryParams = null;
    if($hasQueryParams){
      $queryParams = substr($url, $indexStartQueryParams + 1);
      $url = substr($url, 0, $indexStartQueryParams);
      if(strlen($queryParams) === 0) $queryParams = null;
      else{
        $frac_params = explode('&', $queryParams);
        $queryParams = [];
        foreach($frac_params as $param){
          $divider = strpos($param, '=');
          if($divider === false) $queryParams[] = $param;
          else{
            $key = substr($param, 0, $divider);
            $value = substr($param, $divider + 1);
            $queryParams[$key] = $value;
          }
        }
      }
    }
    #endregion HANDLE QUERY PARAMS

    $frac_url = [...array_filter(explode("/",$url), function($frac){
      return !!$frac;
    })];

    return [$frac_url, $queryParams];
  }
  function numberPhoneRemoveSpacialsChars($phone){
    return str_replace(' ','',
      str_replace('-','',
        str_replace('(','',
          str_replace(')','',
            str_replace('+','',$phone)
          )
        )
      )
    );
  }
  function numberWhatsappFormat($phone){
    $phone = numberPhoneRemoveSpacialsChars($phone);

    if(strlen($phone) <= 11 && strlen($phone) > 9) $phone = "55" . $phone;
    return $phone;
  }
  function numberPhoneFormat($phone){
    if(!$phone) return;

    $phone = numberPhoneRemoveSpacialsChars($phone);
    
    $country  = null;
    $ddd = null;
    $number = [];

    if(strlen($phone) > 13) $phone = substr($phone, -13);
    if(strlen($phone) >= 12){ // 12 or 13
      $country = substr($phone,0,2);
      $phone = substr($phone, 2);
    }
    if(strlen($phone) >= 10){ // 10 or 11
      $ddd = substr($phone,0,2);
      $phone = substr($phone, 2);
    }
    $number = [substr($phone,0, -4), substr($phone,-4)];

    $phone_formatted = "";
    if($country) $phone_formatted.= "+$country ";
    if($ddd) $phone_formatted.= "($ddd) ";
    $phone_formatted.= implode('-',$number);

    return $phone_formatted;
  }
  function recursiveArrayJsonParsed(&$array){
    foreach($array as $key => &$item){
      if(is_string($item) && 
        $jsonParsed = json_decode($item)
      ) $item = $jsonParsed;

      if(!is_string($item) && (is_array($item) || is_object($item))){
        recursiveArrayJsonParsed($item);
      }
    }
  }
  function formatMoney($price){
    $price_formatted = str_replace(',','', $price);
    $price_formatted = str_replace('.',',', $price_formatted);
    $arr_price = explode(',', $price_formatted);
    if(count($arr_price) < 2) $arr_price[] = '00';
    $arr_price[1] = str_pad($arr_price[1],2,"0",STR_PAD_RIGHT);

    return 'R$ ' . implode(',', $arr_price);
  }
  function handleIncrementOrder(&$order, $existingOrders){
    do{ $order++; }while(in_array($order, $existingOrders));
    return $order;
  }