@include('slider_multifotos.banner.' . $banner_variations->model->model_type,[
  'banner' => $banner_variations->model->$variation
])