<style>
  #modalSearchBox{
    display: none;
    z-index: 99999;
    padding: 0 1rem;
  }
  #modalSearchBox .container{
    position: fixed;
    top: 3.2rem;
    left: 0;
    right: 0;
    z-index: 99999;


    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;

    
    width: 100%;
    max-width: 30rem;
    padding-right: 1rem;
    margin: auto;

    border-radius: 5px;
    box-shadow: 0 0 60px #0024;
    background: #fff;
  }    
  #modalSearchBox .container input{
    flex: 1;
    height: 4rem;
    padding-left: 1.8rem;
    border-radius: 5px;
  }
  #modalSearchBox .container button.closeModal{
    background: transparent;
    border: 0;
    font-size: 1.2rem;
    cursor: pointer;
  }
</style>
<div id="modalSearchBox">
  <div class="container">
    <input
      type="search"
      id="input-search"
      placeholder="Digite para pesquisar..."
      onkeyup="handleSearch($(this))"
    />
    <button class="closeModal" type="button" onclick="$('#modalSearchBox').hide();">
      @include('utils.icons.close')
    </button>
  </div>
</div>
<script>
  var controlSearchBox = null;
  function callSearchBoxMultiPhotos(placeholder = null){
    controlSearchBox = {
      search_in: 'multi_photo'
    };

    if(placeholder) $('#input-search').attr('placeholder', placeholder);

    $('#modalSearchBox').show();
    $('#input-search').focus();
  }
  function handleSearch(el){
    if(!controlSearchBox) return;
    switch(controlSearchBox.search_in){
      case 'multi_photo': searchInMultiPhotos(el); break;
    }
  }
  function searchInMultiPhotos(el){
    let search = el.val();
    $(`#multi_photo .container-multi_photos .multi_photo`).each(function(){
      let hide = true;
      
      if($(this).attr('data-slug').indexOf(search) > -1) hide = false;
      if($(this).attr('data-title').indexOf(search) > -1) hide = false;
      if($(this).attr('data-description').indexOf(search) > -1) hide = false;

      if(hide) $(this).hide();
      else $(this).show('slow');
    });
  }
</script>