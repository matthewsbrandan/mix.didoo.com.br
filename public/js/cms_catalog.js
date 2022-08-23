function loadCatalog(){
  $('#container-products').parent().removeClass('products-filled');
  let url = `${cms_catalog.api_url}/${cms_catalog.take}`;
  $.ajax({
    url,
    headers: {"store-token": cms_catalog.token},
    method: "GET"
  }).done((data) => {
    if(data.result){
      $('#container-products').html('');
      let products = data.response.map(product => {
        let name = product.name
        try {
          if (name.indexOf('"pt"') != -1 && JSON.parse(product.name)){
            name = JSON.parse(product.name).pt
          }
        } catch { name = product.name }
        return {
          id: product.id,
          image: `${cms_catalog.origin}${product.logom}`,
          name: name,
          price: Number(product.price),
        }
      });

      if(products.length === 0) $('#container-products').html(`
        <p class="text-loading">Nenhum produto encontrado!</p>
      `);
      else{
        $('#container-products').parent().addClass('products-filled');
        products.forEach((product) => {
          $('#container-products').append(
            renderProduct(product)
          );
        });
        handleImageOnerrorInScope('#container-products');
      }
    }
  }).fail(err => {
    $('#container-products').html(`
      <p class="text-loading">Houve um erro ao carregar os produtos!</p>
    `);
  });
}
function renderProduct(product){
  let price = (new Intl.NumberFormat('pt-BR', {
    style: 'currency',
    currency: 'BRL'
  }).format(product.price)).replace('R$','');
  let [integer, decimal] = price.split(',');

  return `
    <div class="content-product">
      <img src="${product.image}" alt="${product.name}"/>
      <strong>${product.name}</strong>
      <p class="price">
        <small>R$</small>${integer}<small>,${decimal}</small>
        </p>
    </div>
  `;
}      
$(function(){ loadCatalog(); });