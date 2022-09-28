$('#form-download-catalog').on('submit', handleSendRequestCatalog);
async function handleSendRequestCatalog(event){
  event.preventDefault();

  let email = $('#download_catalog-email').val();
  if(!email){
    showMessage('É obrigatório inserir o email!','Baixar Catálogo');
    return;
  }
  let name = (email.split('@'))[0] ?? '-- não identificado --';
  let whatsapp = null;
  // let name = $('#download_catalog-name').val();
  // let whatsapp = $('#download_catalog-whatsapp').val();

  let message = `Solicitação de download do catálogo pelo usuário ${name}<br/><br/>`;
  // if(whatsapp) message+= `Whatsapp: ${whatsapp}<br/>`;
  if(email) message+= `Email: ${email}`;

  let data = {
    name, email, message, phone: whatsapp,
    page_id: download_catalog.page_id,
    page_owner_id: download_catalog.page_owner_id
  };

  showMessage('Solicitando catálogo...', 'Baixar Catálogo');
  $.ajax({
    url: download_catalog.url, data,
    headers: {"access-token": download_catalog.token},
    method: "POST"
  }).then(data => {
    $('#modalMessage').hide();
    if(data.result) window.open(download_catalog.pdf_catalog_url);
    else showMessage(data.response, 'Baixar Catálogo')
  }).fail(err => {
    showMessage('Houve um erro ao solicitar o download do catálogo', 'Baixar Catálogo');
  });
}