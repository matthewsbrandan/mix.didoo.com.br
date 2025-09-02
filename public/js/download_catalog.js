$('#form-download-catalog').on('submit', handleSendRequestCatalog);
async function handleSendRequestCatalog(event){
  event.preventDefault();

  let name = $('#download_catalog-name').val();
  let whatsapp = $('#download_catalog-whatsapp').val();
  let email = $('#download_catalog-email').val();

  const error = [
    [!name, 'É obrigatório inserir o nome!'],
    [!whatsapp, 'É obrigatório inserir o whatsapp!'],
    [!email, 'É obrigatório inserir o email!'],
  ].find(([hasError]) => hasError)?.[1];

  if(error){
    showMessage(error,'Baixar Catálogo');
    return;
  }

  let pdf_catalog_url = download_catalog.selected_variation === '1' ? download_catalog.pdf_catalog_url : (
    download_catalog.variations[download_catalog.selected_variation].url
  );

  if(!pdf_catalog_url){
    showMessage('Não foi possível identificar o link do catálogo', 'Baixar Catálogo');
    return;
  }
  
  let message = `Solicitação de download do ${download_catalog.selected_variation}º catálogo pelo usuário ${name}<br/><br/>`;
  if(whatsapp) message+= `Whatsapp: ${whatsapp}<br/>`;
  if(email) message+= `Email: ${email}`;

  let data = {
    name, email, message, phone: whatsapp,
    page_id: download_catalog.page_id,
    page_owner_id: download_catalog.page_owner_id,
    variation: download_catalog.selected_variation
  };

  showMessage('Solicitando catálogo...', 'Baixar Catálogo');
  $.ajax({
    url: download_catalog.url, data,
    headers: {"access-token": download_catalog.token },
    method: "POST"
  }).then(data => {
    $('#modalMessage').hide();
    if(data.result){
      window.open(pdf_catalog_url);
      $('#download_catalog-name').val('');
      $('#download_catalog-whatsapp').val('');
      $('#download_catalog-email').val('');
    }
    else showMessage(data.response, 'Baixar Catálogo')
  }).fail(err => {
    showMessage('Houve um erro ao solicitar o download do catálogo', 'Baixar Catálogo');
  });
}
function toggleCatalogToDownload(variation){
  let src = variation === '1' ? download_catalog.pdf_image : download_catalog.variations[variation]?.src;
  if(!src) return;

  download_catalog.selected_variation = variation;

  $(`#download_catalog .catalog_option`).removeClass('active');
  $(`#download_catalog .catalog_option[data-variation=${variation}]`).addClass('active');

  $(`#catalog_wallpaper`).attr('src', src);
}