<?php

include_once __DIR__."/Controller.php";

class PostController extends Controller{
  public function index(){
    [$data, $err] = $this->cms->get("page/data-select/".$this->theme_slug."&navbar");

    if(!$data || !$data->result || $err) return view('error-404');

    $page_config = $data->response->datas[0];
    $elements = $data->response->elements;
    
    $parsedElements = [];
    foreach($elements as $element){
      $data = $element->datas ? $element->datas[0] : null;
      if($data){
        if($data->active){
          $data = json_decode($data->data);
          if($data) foreach($data as &$item){
            if(is_string($item) && $jsonParsed = json_decode($item)) $item = $jsonParsed;
          }
        }
        else $data = null;
      }
      $parsedElements[$element->class_name] = $data;
    }

    [$data, $err] = $this->cms->get("post/feed/more");

    if($data->result){
      $posts = $data->response->posts;

      return view('blog.index',[
        'posts' => $posts,
        'page_config' => $page_config,
        'elements' => $parsedElements,
        'cms_page_token' => $this->cms->getPageToken()
      ]);
    }
    return view('error-404');
  }

  public function show($slug){
    [$data, $err] = $this->cms->get("post/show/".$slug);
    if($data->result){
      $response = $data->response;
      
      return view('blog.show',[
        'post' => $response->post,
        'prevPost' => $response->prevPost,
        'nextPost' => $response->nextPost,
        'outhers' => $response->outhers
      ]);
    }
    return view('error-404');
  }
}