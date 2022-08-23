<?php
  use Jenssegers\Blade\Blade;

  include_once __DIR__."/vendor/autoload.php";
  
  $dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
  $dotenv->load();
  
  $app_url = getenv('APP_URL');
  $app_path = getenv('APP_PATH');
  $cms_url = getenv('CMS_URL');
  $cms_theme_slug = getenv('CMS_THEME_SLUG');
  $mode_dynamic_slug = (bool) getenv('MODE_DYNAMIC_SLUG');
  $cms_page_slug = null;
  $cms_page_token = $mode_dynamic_slug ? null : getenv('CMS_ACCESS_TOKEN');

  include_once __DIR__."/app/helpers.php";
  include_once __DIR__."/app/services/CmsService.php";

  $uri = str_replace($app_path, '', $_SERVER['REQUEST_URI']);
  $cms = new CmsService();

  #region HANDLE MODE DYNAMIC SLUG
  if($mode_dynamic_slug){
    [$frac_url] = frac_url($uri);
    if(count($frac_url) == 0){
      echo view('welcome',[
        'cms_url' => $cms_url
      ]);
      die;
    }
    $cms_page_slug = $frac_url[0];
    $app_url = $app_url . "/" . $cms_page_slug;
    array_shift($frac_url);
    $uri = "/".implode('/',$frac_url);
    $data = $cms->getPageToken($cms_page_slug);
    if(!$data->result){
      echo view('error-500',[
        'message' => $data->response
      ]);
      die;
    }else $cms_page_token = $data->response;
  }
  #endregion HANDLE MODE DYNAMIC SLUG

  include(__DIR__."/routes.php");
  
  function render($url){
    global $blade;
    global $cms;
    global $cms_theme_slug;

    [$frac_url, $query_params] = frac_url($url);
    
    if(count($frac_url) == 0){
      include_once __DIR__."/app/controllers/HomeController.php";
      $controller = new HomeController($cms, $cms_theme_slug);

      return $controller->index();
    }
    else{
      if($frac_url[0] == 'blog'){
        include_once __DIR__."/app/controllers/PostController.php";
        $controller = new PostController($cms, $cms_theme_slug);

        if(count($frac_url) == 1) return $controller->index();
        else if(count($frac_url) == 2) return $controller->show($frac_url[1]);
      }
      if($frac_url[0] == 'politica-privacidade'){
        include_once __DIR__."/app/controllers/HomeController.php";
        $controller = new HomeController($cms, $cms_theme_slug);

        return $controller->policy();
      }
      if($frac_url[0] == 'links'){
        include_once __DIR__."/app/controllers/HomeController.php";
        $controller = new HomeController($cms, $cms_theme_slug);

        return $controller->links();
      }
      if($frac_url[0] == 'produto'){
        include_once __DIR__."/app/controllers/HomeController.php";
        $controller = new HomeController($cms, $cms_theme_slug);

        return $controller->product($frac_url[1] ?? null);
      }
    }

    return view('error-404');
  }

  echo render($uri);