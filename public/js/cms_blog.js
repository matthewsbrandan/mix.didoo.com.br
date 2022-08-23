function loadBlog(){
  $('#container-blog').parent().removeClass('blog-filled');
  let url = cms_blog.url;
  
  $.ajax({
    url,
    headers: {
      "access-token": cms_blog.token,
      "take": cms_blog.take
    },
    method: "GET"
  }).done(data => {
    if(data.result){
      $('#container-blog').html('');
      let blog = data.response.posts.map(post => {
        return {
          ...post
        }
      });

      if(blog.length === 0) $('#container-blog').html(`
        <p class="text-loading">Nenhum post encontrado!</p>
      `);
      else{
        $('#container-blog').parent().addClass('blog-filled');
        blog.forEach(post => {
          $('#container-blog').append(
            renderBlog(post)
          );
        });
        handleImageOnerrorInScope('#container-blog');
      }
    }
  }).fail(err => {
    $('#container-blog').html(`
      <p class="text-loading">Houve um erro ao carregar os posts!</p>
    `);
  });
}
function renderBlog(post){
  return `
    <div class="content-post">
      <img src="${post.image}" alt="${post.title}"/>
      <div>
        <a href="${cms_blog.show}${post.slug}" target="_blank">
          <strong>${post.title}</strong>
          <time>${post.date_formatted}</time>
        </a>
        <p>${post.excerpt}</p>
      </div>
    </div>
  `;
}      
$(function(){ loadBlog(); });