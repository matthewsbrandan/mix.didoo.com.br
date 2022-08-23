$('#form-download-catalog').on('submit', handleSendRequestCatalog);
async function handleSendRequestCatalog(event){
  event.preventDefault();

  let name = $('#download_catalog-name').val();
  let email = $('#download_catalog-email').val();
  let whatsapp = $('#download_catalog-whatsapp').val();

  let message = `Solicitação de download do catálogo pelo usuário ${name}<br/><br/>`;
  if(whatsapp) message+= `Whatsapp: ${whatsapp}<br/>`;
  if(email) message+= `Email: ${email}`;

  let data = {
    name, email, message, phone: whatsapp,
    page_id: download_catalog.page_id,
    page_owner_id: download_catalog.page_owner_id
  };

  showMessage('Solicitando catálogo...', 'Baixar Catálogo');
  $.ajax({
    url: schedule.url, data,
    headers: {"access-token": schedule.token},
    method: "POST"
  }).then(data => {
    $('#modalMessage').hide();
    if(data.result) window.open(download_catalog.pdf_catalog_url);
    else showMessage(data.response, 'Baixar Catálogo')
  }).fail(err => {
    showMessage('Houve um erro ao solicitar o download do catálogo', 'Baixar Catálogo');
  });
}