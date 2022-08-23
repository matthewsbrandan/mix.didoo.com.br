<?php
  function route($route_name, $params = []){
    global $app_url;
    global $cms_url;
    switch ($route_name){
      case 'home':            return $app_url; break;
      case 'cms':             return $cms_url; break;
      case 'links':           return $app_url."/links"; break;
      case 'privacy.policy':  return $app_url."/politica-privacidade"; break;
      case 'product.show':    return $app_url."/produto"."/".($params['slug'] ?? ''); break;
      #region BLOG
      case 'blog.feed.index': return $app_url."/"."blog"; break;
      case 'blog.feed.show':  return $app_url."/"."blog/".$params['slug']; break;
      case 'blog.feed.more':  return $cms_url."api/post/feed/".($params['skip'] ?? ''); break;
      #endregion BLOG
      #region API ROUTES
      case 'api.comment.show':
        $parsedParams = [$params['post_id']];
        if(isset($params['lead_id']) && $params['lead_id']){
          $parsedParams[]= $params['lead_id'];
          if(isset($params['skip']) && $params['skip']) $parsedParams[]= $params['skip'];
        }else
        if(isset($params['skip']) && $params['skip']){
          $parsedParams[]= 0;
          $parsedParams[]= $params['skip'];
        }
        
        return $cms_url."api/post/comment/show/".implode('&', $parsedParams);
        break;
      case 'api.comment.answers':
        $parsedParams = [$params['post_id'], $params['comment_id']];
        if(isset($params['lead_id']) && $params['lead_id']){
          $parsedParams[]= $params['lead_id'];
          if(isset($params['skip']) && $params['skip']) $parsedParams[]= $params['skip'];
        }else
        if(isset($params['skip']) && $params['skip']){
          $parsedParams[]= 0;
          $parsedParams[]= $params['skip'];
        }

        return $cms_url."api/post/comment/answers/".implode('&', $parsedParams);
        break;
      case 'api.comment.delete':
        $parsedParams = [$params['post_id'], $params['comment_id'], $params['lead_id']];

        return $cms_url."api/post/comment/delete/".implode('&', $parsedParams);
        break;
      case 'api.comment.store':  return $cms_url."api/post/comment/store"; break;

      case 'api.postlead.like':  return $cms_url."api/post-lead/like"; break;
      case 'api.postlead.store': return $cms_url."api/post-lead/store"; break;
      case 'api.postlead.login': return $cms_url."api/post-lead/login";  break;

      case 'api.gallery.show':
        $parsedParams = [$params['slug']];
        if(isset($params['skip'])) $parsedParams[] = $params['skip'];

        return $cms_url."api/gallery/show/".implode('/', $parsedParams);
        break;

      case 'api.contact.send': return $cms_url."api/contact/send"; break;
      #endregion API ROUTES
    }
    throw new Error("Route $route_name don't exists");
  }