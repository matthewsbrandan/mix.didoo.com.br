<style>
  /* BEGIN:: FORM COMMENTS*/    
  .comments-group-title{
    display: flex;
    gap: .6rem;
    align-items: center;
    margin-top: 1.2rem;
    margin-bottom: .8rem;
  }
  .comments-group-title h2{
    margin: 0;
    display: flex;
    gap: .4rem;
    align-items: center;
  }
  #badge-count-comments{
    background: var(--primary-500);
    color: var(--gray-100);
    border-radius: 99rem;
    padding: .2rem .6rem;
    font-size: .8rem;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  #answer-to{
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .5rem;
    border: 1px solid var(--gray-400);
    background: var(--gray-100);
    color: var(--gray-700);
    border-radius: 99rem;
    padding: .8rem;
    height: 2rem;

    cursor: pointer;

    transition: .3s;
  }
  #answer-to:hover{ background: var(--primary-500); }
  #answer-to:hover > span{ color: var(--gray-100); }
  #answer-to span:hover{
    text-decoration: underline;
  }
  #answer-to button{
    background: var(--primary-500);
    color: var(--gray-100);
    border-radius: 99rem;
    display: flex;
    align-items: center;
    justify-content: center;

    transition: .3s;
  }
  #answer-to button:hover, .comment-trash:hover{
    background: var(--gray-200);
    color: var(--dark-500);
    font-weight: bold;
  }
  #answer-to #hover-answer{
    position: absolute;
    display: none;
    padding: 1rem;
    border-radius: 0.5rem;
    border: 1px solid #eef;
    box-shadow: 0 0 10px #0001;
    background-color: #fff;
    bottom: 2.7rem;
  }
  #answer-to:hover #hover-answer{
    display: block;
  }
  .form-group{
    position: relative;
    display: flex;
    border: 1px solid var(--gray-100);
    border-radius: 4px;
    padding-left: .6rem;
  }
  .form-group:focus-within{
    outline: 2px solid var(--gray-200);
  }
  .form-group.has-error{
    border: 2px solid #f347;
    margin-bottom: 2rem;
  }
  .form-group.has-success{
    border: 2px solid var(--green-100);
    margin-bottom: 2rem;
  }
  .error-message, .success-message{
    display: none;
    position: absolute;
    bottom: -1.3rem;
    font-size: .7rem;
    color: var(--gray-500);
  }
  .form-group.has-error .error-message{ display: block; }
  .form-group.has-success .success-message{ display: block; }
  .custom-textarea .form-control{
    min-width: 14rem;
    flex: 1;
    outline: none;
    height: auto;
    padding-top: .6rem;
    padding-bottom: .6rem;
    color: var(--gray-700);
  }
  .custom-textarea button{
    position: absolute;
    bottom: .5rem;
    right: .5rem;
    background: var(--primary-500);
    color: var(--gray-200);
    border-radius: 6px;
    padding: .2rem .4rem;

    transition: .2s;
  }
  .custom-textarea button:hover{
    background: var(--gray-200);
    color: var(--dark-500);
    font-weight: bold;
  }
  /* END:: FORM COMMENTS | BEGIN:: COMMENTS */
  .container-comments{
    margin-top: 1rem;
    display: flex;
    flex-direction: column;
    overflow-x: auto;
  }
  .content-comment{
    display: grid;
    grid-template-columns: 3.2rem auto;
    border-radius: .5rem;
    transition: .2s;
    padding: .5rem;
  }
  .content-comment:hover{ 
    background: #00000005;
    
  }
  .content-comment .comment-tag-user{
    height: 2.4rem;
    width: 2.4rem;
    padding: 0;
    border-radius: 99rem;
    
    display: flex;
    align-items: center;
    justify-content: center;
    
    color: var(--gray-100);
    background: var(--primary-500);
  }
  .content-comment .comment-info{
    position: relative;
    display: flex;
    flex-direction: column;
  }
  .content-comment .comment-info .comment-timestamp,#hover-answer .comment-timestamp{
    font-size: .7rem;
    color: var(--gray-500);
    display: block;
  }
  .content-comment .comment-info .comment-body{
    color: var(--gray-700);
  }
  .content-comment .comment-info .comment-actions{
    margin: .6rem 0 0;
    display: flex;
    gap: .6rem;

    color: var(--gray-700);
    font-weight: bold;
    font-size: .85rem;
  }
  .comment-answer:hover{ text-decoration: underline; }
  .comment-like{
    display: flex;
    align-items: flex-top;
    gap: .2rem;
  }
  .comment-unlike{
    display: flex;
    align-items: flex-top;
    gap: .2rem;
  }
  .comment-responses{
    margin: .8rem 0;
    border-left: 1px dotted #dde;
    padding: 0 .4rem;
  }
  .comment-trash{
    position: absolute;
    top: 0;
    right: 0;
    border-radius: 99rem;
    font-size: 0;
    padding: .3rem;
  }
  #more-comments, .more-answers{
    display: block;
    text-align: center;
    font-size: .8rem;
    color: var(--gray-700);
  }
  #more-comments:hover, .more-answers:hover{
    text-decoration: underline;
    color: var(--dark-500);
  }
  /* END:: COMMENTS */
</style>
<section>
  <div class="comments-group-title">
    <h2><span id="badge-count-comments">0</span>Comentários</h2>
    <div id="answer-to" class="d-none">
      <span></span>
      <button type="button" onclick="handleClearAnswer()">x</button>
      <div id="hover-answer"></div>
    </div>
  </div>
  <form onsubmit="return handleSendComment(event);">
    <input type="hidden" id="answer-id"/>
    <div class="form-group custom-textarea" id="div-comment">
      <textarea class="form-control" id="comment" rows="5" placeholder="Adicione um comentário..." required></textarea>
      <button type="submit">Comentar</button>
      <span class="error-message">Não foi possível enviar seu comentário...</span>
      <span class="success-message">Comentário enviado com sucesso</span>
    </div>
    <div id="logged-with"></div>
  </form>
  <div class="container-comments">
    <p class="empty">Sem comentários...</p>
  </div>
  <a href="javascript: moreComments();" id="more-comments">carregar mais...</a>
  @include('blog.partials.modalLoginLead')
  @include('utils.modalMessage')
</section>
<script>
  // BEGIN:: API URLS
  const commentsApiUrl = "{!! route('api.comment.show',['post_id' => $post->id]) !!}";
  let tempAnswersApiUrl = "{!! route('api.comment.answers',['post_id' => $post->id,'comment_id' => 0]) !!}";
  const answersApiUrl = tempAnswersApiUrl.substr(0, tempAnswersApiUrl.length - 2);
  const likeApiUrl = "{{ route('api.postlead.like') }}";
  let tempDeleteCommentApiUrl = "{!! route('api.comment.delete',['post_id' => $post->id,'comment_id' => 0,'lead_id' => 0]) !!}";
  const deleteCommentApiUrl = tempDeleteCommentApiUrl.substr(0, tempDeleteCommentApiUrl.length - 4);
  // END:: API URLS | BEGIN:: ICONS
  const outlineLikeSvg = `<svg xmlns='http://www.w3.org/2000/svg'  viewBox='0 0 24 24' fill='#747480' width='18' height='18'><path d="M20 8h-5.612l1.123-3.367c.202-.608.1-1.282-.275-1.802S14.253 2 13.612 2H12c-.297 0-.578.132-.769.36L6.531 8H4c-1.103 0-2 .897-2 2v9c0 1.103.897 2 2 2h13.307a2.01 2.01 0 0 0 1.873-1.298l2.757-7.351A1 1 0 0 0 22 12v-2c0-1.103-.897-2-2-2zM4 10h2v9H4v-9zm16 1.819L17.307 19H8V9.362L12.468 4h1.146l-1.562 4.683A.998.998 0 0 0 13 10h7v1.819z"></path></svg>`;
  const outlineUnlikeSvg = `<svg xmlns='http://www.w3.org/2000/svg'  viewBox='0 0 24 24' fill='#747480' width='18' height='18'><path d="M20 3H6.693A2.01 2.01 0 0 0 4.82 4.298l-2.757 7.351A1 1 0 0 0 2 12v2c0 1.103.897 2 2 2h5.612L8.49 19.367a2.004 2.004 0 0 0 .274 1.802c.376.52.982.831 1.624.831H12c.297 0 .578-.132.769-.36l4.7-5.64H20c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2zm-8.469 17h-1.145l1.562-4.684A1 1 0 0 0 11 14H4v-1.819L6.693 5H16v9.638L11.531 20zM18 14V5h2l.001 9H18z"></path></svg>`;
  const solidLikeSvg = `<svg xmlns='http://www.w3.org/2000/svg'  viewBox='0 0 24 24' fill='#747480' width='18' height='18'><path d="M4 21h1V8H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2zM20 8h-7l1.122-3.368A2 2 0 0 0 12.225 2H12L7 7.438V21h11l3.912-8.596L22 12v-2a2 2 0 0 0-2-2z"></path></svg>`;
  const solidUnlikeSvg = `<svg xmlns='http://www.w3.org/2000/svg'  viewBox='0 0 24 24' fill='#747480' width='18' height='18'><path d="M20 3h-1v13h1a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zM4 16h7l-1.122 3.368A2 2 0 0 0 11.775 22H12l5-5.438V3H6l-3.937 8.649-.063.293V14a2 2 0 0 0 2 2z"></path></svg>`;
  const trashSvg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" style="fill: #dc3545;transform: ;msFilter:;"><path d="M5 20a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8h2V6h-4V4a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v2H3v2h2zM9 4h6v2H9zM8 8h9v12H7V8z"></path><path d="M9 10h2v8H9zm4 0h2v8h-2z"></path></svg>`;
  // END:: ICONS
  function handleAnswerTo(id, author){
    $('#answer-id').val(id);
    $('#answer-to span').html(author);
    $('#answer-to').removeClass('d-none');
    $('#hover-answer').html(`
      <strong class="comment-author">${ $(`#comment-${id} .comment-author`).html() }</strong>
      <time class="comment-timestamp">
        ${$(`#comment-${id} .comment-timestamp`).html()}
      </time>
      <div class="comment-body">
        ${$(`#comment-${id} .comment-body`).html()}
      </div>
    `);
  }
  function handleClearAnswer(){
    $('#answer-id').val('');
    $('#answer-to span').html('');
    $('#answer-to').addClass('d-none');
  }
  function handleSendComment(event){
    event.preventDefault();

    if(!postLead){
      $('#modalLoginLead').show();
      return;
    }
    let data = {
      content: $('#comment').val(),
      post_id: '{{$post->id}}',
      answer_id: $('#answer-id').val() ?? null,
      post_lead_id: postLead.id,
      author: postLead.name,
      thumbnail: postLead.thumbnail ?? null,
    };

    $.post("{{ route('api.comment.store') }}", data).done(function(response){
      if(response.result){
        $('#div-comment').removeClass('has-error');
        handleAddComment(response.response);
        $('#comment').val('');
        $('#div-comment').addClass('has-success');
        setTimeout(function(){
          $('#div-comment').removeClass('has-success');
        },1000);
        handleClearAnswer();
      }
      else{
        $('#div-comment').addClass('has-error');
        $('#div-comment .error-message').html(response.response);

        setTimeout(function(){
          $('#div-comment').removeClass('has-error');
          $('#div-comment .error-message').html("Não foi possível enviar seu comentário...");
        },1000);
      }

    }).fail(function(){ $('#div-comment').addClass('has-error'); });
  }
  function handleAddComment(comment, type= 'prepend') {
    if(type === 'prepend'){
      let total = Number($('#badge-count-comments').html());
      $('#badge-count-comments').html(total + 1);
      
      if(comment.answer_id){
        let amount = Number($(`#comment-${comment.answer_id} .see-answers a span`).html());
        $(`#comment-${comment.answer_id} .see-answers a span`).html(amount+1);
      }
    }
    if($('.container-comments .empty')) $('.container-comments .empty').remove();

    let breadcrumbs = comment.id;
    if(comment.breadcrumbs){
      breadcrumbs = `${comment.breadcrumbs}-${comment.id}`;
    }

    let isLiked = comment.ratings && comment.ratings.length > 0 && comment.ratings[0].like == '1';
    let isUnliked = comment.ratings && comment.ratings.length > 0 && comment.ratings[0].like == '-1';
    
    let actionsHtml = `
      <div class="comment-actions" id="comment-actions-${comment.id}">
        <a
          href="#answer-to"
          class="comment-answer"
          onclick="handleAnswerTo(${ comment.id },'${ comment.author }')"
        >Responder</a>
        <a
          href="javascript:;"
          onclick="handleLike($(this),${ comment.id })"
          data-value="${ isLiked ? '':'1'}"
          data-amount="${ comment.num_likes }"
          class="comment-like" title="Curtir"
        >
          ${ comment.num_likes }
          ${ isLiked ? solidLikeSvg : outlineLikeSvg }
        </a>
        <a
          href="javascript:;"
          onclick="handleLike($(this),${ comment.id })"
          data-value="${ isUnliked ? '' : '-1' }"
          data-amount="${ comment.num_unlikes }"
          class="comment-unlike" title="Descurtir"
        >
          ${ comment.num_unlikes }
          ${ isUnliked ? solidUnlikeSvg : outlineUnlikeSvg }
        </a>
        ${ postLead && postLead.id == comment.post_lead_id ? `
          <a
            href="javascript:;"
            class="comment-trash"
            onclick="handleDeleteComment('${deleteCommentApiUrl}&${comment.id}&${postLead.id}')"
          >${trashSvg}
          </a>
        `: ''}
        <span style="flex: 1; text-align: right;" class="see-answers">
          <a href="javascript:;" onclick="loadAnswers(${ comment.id })">Ver Respostas(<span>${ comment.num_answers }</span>)</a>
        </span>
      </div>
    `;
    let html = `
      <div class="content-comment" id="comment-${comment.id}">
        <span class="comment-tag-user">${comment.author.substr(0,2) }</span>
        <div class="comment-info">
          <strong class="comment-author">${ comment.author }</strong>
          <time class="comment-timestamp">
            ${comment.date_formatted}
          </time>
          <div class="comment-body">
            ${comment.content}
          </div>
          ${ actionsHtml }
          <div class="comment-responses" id="responses-comment-${breadcrumbs}"></div>
        </div>
      </div>
    `;

    if(type === 'append'){
      if(comment.breadcrumbs) $(`#responses-comment-${comment.breadcrumbs}`).append(html);
      else $('.container-comments').append(html);
    }else
    if(type === 'prepend'){
      if(comment.breadcrumbs) $('#responses-comment-'+comment.breadcrumbs).prepend(html);
      else $('.container-comments').prepend(html);
    }
  }
  function loadAnswers(id){
    let params = `${id}& &`;
    if(postLead) params = `${id}&${postLead.id}&`;
    $.get(`${answersApiUrl}&${params}`).done(function(data){
      if(data.result){
        if(data.response.comments.length > 0){
          $(`#responses-comment-${data.response.comments[0].breadcrumbs}`).html('');
          data.response.comments.forEach(comment => {
            handleAddComment(comment,'append');
          });
          $(`#responses-comment-${data.response.comments[0].breadcrumbs}`).append(`
            <a
              href="javascript:;"
              onclick="moreAnswers(${id},'${data.response.comments[0].breadcrumbs}')"
              class="more-answers"
              id="more-answers-${id}"
            >carregar mais...</a>
          `);
        }
        $(`#comment-${comment.id} .see-answers span`).html(data.response.total);
      }
    });
  }
  function moreAnswers(id, breadcrumbs){
    let skip = $(`#responses-comment-${breadcrumbs} > .content-comment`).length;

    let params = `${id}& &${skip}`;
    if(postLead) params = `${id}&${postLead.id}&${skip}`;
    $.get(`${answersApiUrl}&${params}`).done(function(data){
      if(data.result){
        $(`#responses-comment-${breadcrumbs} > .more-answers`).remove();
        if(data.response.comments.length > 0){
          data.response.comments.forEach(comment => {
            handleAddComment(comment,'append');
          });
          $(`#responses-comment-${breadcrumbs}`).append(`
            <a
              href="javascript:;"
              onclick="moreAnswers(${id},'${breadcrumbs}')"
              class="more-answers"
              id="more-answers-${id}"
            >carregar mais...</a>
          `);
        }
        $(`#comment-${comment.id} .see-answers span`).html(data.response.total);
      }
    });
  }
  function loadComments(){
    let params = "& &";
    if(postLead) params = `&${postLead.id}&`;
    $.get(commentsApiUrl + params).done(function(response){
      if(response.result){
        response.response.comments.forEach(comment => {
          handleAddComment(comment,'append');
        });
        $('#badge-count-comments').html(response.response.total);
      }
    });
  }
  function moreComments(){
    let skip = $('.container-comments > .content-comment').length;

    let params = "& ";
    if(postLead) params = `&${postLead.id}`;
    params+= `&${skip}`;

    $.get(commentsApiUrl + params).done(function(response){
      if(response.result){
        if(response.response.comments.length === 0) $('#more-comments').remove();
        else response.response.comments.forEach(comment => {
          handleAddComment(comment,'append');
        });
        $('#badge-count-comments').html(response.response.total);
      }
    });
  }
  function handleLike(elem, comment_post_id){
    if(!postLead){
      $('#modalLoginLead').show();
      return;
    }

    let data = {
      comment_post_id: comment_post_id,
      post_lead_id: postLead.id,
      like: elem.attr('data-value'),
    };

    $.post(likeApiUrl,data).done(function(data){
      if(data.result){
        if(elem.attr('data-value') == '1' || elem.attr('data-value') == '-1'){
          if(elem.attr('data-value') == '1'){
            let opposite = `#comment-${comment_post_id} .comment-unlike`;
            if($(opposite).attr('data-value') !== '-1') handleRemoveLike($(opposite));
          }else
          if(elem.attr('data-value') == '-1'){
            let opposite = `#comment-${comment_post_id} .comment-like`;
            if($(opposite).attr('data-value') !== '1') handleRemoveLike($(opposite));
          }

          let amount = Number(elem.attr('data-amount'));
          elem.attr('data-amount',amount+1).attr('data-value','').html(`
            ${amount+1}
            ${ elem.attr('title') == 'Curtir' ? solidLikeSvg : solidUnlikeSvg }
          `);
        }
        else handleRemoveLike(elem);
      }
    });
  }
  function handleRemoveLike(elem){
    let amount = Number(elem.attr('data-amount'));
    elem.attr('data-amount',amount-1).attr('data-value',
      elem.attr('title') == 'Curtir' ? '1' : '-1'
    ).html(`
      ${amount-1}
      ${ elem.attr('title') == 'Curtir' ? outlineLikeSvg : outlineUnlikeSvg }
    `);
  }
  function handleDeleteComment(url){
    if(window.confirm('Tem certeza que deseja excluir esse comentário?')){
      $.get(url).done(function(data){
        if(data.result){
          $('.container-comments').html(`<p class="empty">Sem comentários...</p>`);
          loadComments();
        }
        else showMessage(data.response);
      }).catch(function(){
        showMessage("Houve um erro ao tentar excluir este comentário");
      });
    }
  }
  $(function(){ loadComments(); });
</script>