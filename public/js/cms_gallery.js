const gallery_control = { len: 0 };
function loadGallery(){
  $('#container-gallery').parent().removeClass('gallery-filled');
  let wrapper = $('#container-gallery').parent();

  let mode = wrapper.hasClass('mosaic-gallery') ? 'mosaic' : wrapper.hasClass('netflix-gallery') ? 'netflix' : 'carousel';
  let rows = Number(wrapper[0].dataset.rows);

  let url = cms_gallery.url;
  $.ajax({
    url, headers: {
      "access-token": cms_gallery.token,
      "take": cms_gallery.take
    },
    method: "GET"
  }).done(data => {
    if(data.result){
      $('#container-gallery').html('');

      let images = data.response.images;
      gallery_control.len = images.length;
      if(images.length === 0) $('#container-gallery').html(`
        <p class="text-loading">Nenhuma imagem encontrada!</p>
      `);
      else{
        $('#container-gallery').parent().addClass('gallery-filled');
        images.forEach((image, i) => {
          if(mode === 'mosaic'){
            if(i % (rows * 3) === 0) $('#container-gallery').append('<div class="row"></div>');
            
            $('#container-gallery').children().last().append(
              renderImageFromGallery(image, i)
            );
          }else{
            if((
              rows === 1 && i === 0
            ) || (
              rows !== 1 && (
                i === 0 || (
                  i === Math.ceil(images.length / rows)
                ) || (
                  rows === 3 && i === (Math.ceil(images.length / rows) * 2)
                )
              )
            )) $('#container-gallery').append('<div class="row"></div>');
            
            $('#container-gallery').children().last().append(
              renderImageFromGallery(image, i)
            );
          }
        });

        handleImageOnerrorInScope('#container-gallery');
      } 
    }
  }).fail(err => {
    $('#container-gallery').html(`
      <p class="text-loading">Houve um erro ao carregar a galeria!</p>
    `);
  });;
}
function renderImageFromGallery(image, index){
  return `
    <img src="${image.name}" alt="${image.alt}" data-index="${index}" class="gallery-image" onclick="openZoomImage(this,${index})"/>
  `;
}

//#region HANDLE ZOOM
let interactionZoomImage = {
  scale: 1,
  isDragging: false,
  startX: undefined,
  startY: undefined,
  offsetX: 0,
  offsetY: 0,
  modal: document.getElementById("modal-zoom-gallery-image"),
  modalImg: document.getElementById("modal-zoom-img")
}

function openZoomImage(img, index){
  interactionZoomImage.modal.style.display = "flex";
  interactionZoomImage.modalImg.src = img.src;
  interactionZoomImage.modalImg.dataset.index = index;
  interactionZoomImage.scale = 1;
  interactionZoomImage.offsetX = 0;
  interactionZoomImage.offsetY = 0;
  interactionZoomImage.modalImg.style.transform = `scale(${interactionZoomImage.scale}) translate(0px, 0px)`;

  document.addEventListener("keydown", closeZoomImageOnEsc);
}
function closeZoomImage(){
  document.getElementById("modal-zoom-gallery-image").style.display = "none";
  document.removeEventListener("keydown", closeZoomImageOnEsc);
}
function closeZoomImageOnEsc(event) {
  if (event.key === "Escape") {
    closeZoomImage();
  }
}

document.querySelector('#modal-zoom-gallery-image .btn-left').addEventListener("click", function(event) { 
  event.stopPropagation();

  let index = interactionZoomImage.modalImg.dataset.index === '0' ? (
    gallery_control.len - 1
  ) : Number(interactionZoomImage.modalImg.dataset.index) - 1;
  
  const el = document.querySelector(`#container-gallery .gallery-image[data-index="${index}"]`)

  if(el) el.click();
  else console.log(`[element-not-found] #container-gallery .gallery-image[data-index="${index}"]`);
});
document.querySelector('#modal-zoom-gallery-image .btn-right').addEventListener("click", function(event) {
  event.stopPropagation();

  let index = interactionZoomImage.modalImg.dataset.index === String(
    gallery_control.len - 1
  ) ? 0 : Number(interactionZoomImage.modalImg.dataset.index) + 1;

  const el = document.querySelector(`#container-gallery .gallery-image[data-index="${index}"]`)

  if(el) el.click();
  else console.log(`[element-not-found] #container-gallery .gallery-image[data-index="${index}"]`);
});

interactionZoomImage.modalImg.addEventListener("click", function(event) {
  event.stopPropagation();
});
interactionZoomImage.modalImg.addEventListener("wheel", function(event) {
  event.preventDefault();
  
  if (event.deltaY < 0) {
    interactionZoomImage.scale += 0.1; // Aumenta o zoom
  } else if (event.deltaY > 0 && interactionZoomImage.scale > 1) {
    interactionZoomImage.scale -= 0.1; // Diminui o zoom, sem ficar menor que 1
  }

  this.style.transform = `scale(${interactionZoomImage.scale}) translate(${interactionZoomImage.offsetX}px, ${interactionZoomImage.offsetY}px)`;
});
interactionZoomImage.modalImg.addEventListener("mousedown", (event) => {
  if (interactionZoomImage.scale > 1) { // Só arrasta se estiver ampliado
    interactionZoomImage.isDragging = true;
    interactionZoomImage.startX = event.clientX - interactionZoomImage.offsetX;
    interactionZoomImage.startY = event.clientY - interactionZoomImage.offsetY;
    interactionZoomImage.modalImg.style.cursor = "grabbing";
  }
});
// Movimentação ao arrastar
interactionZoomImage.modal.addEventListener("mousemove", (event) => {
  if (interactionZoomImage.isDragging) {
    interactionZoomImage.offsetX = event.clientX - interactionZoomImage.startX;
    interactionZoomImage.offsetY = event.clientY - interactionZoomImage.startY;
    interactionZoomImage.modalImg.style.transform = `scale(${interactionZoomImage.scale}) translate(${interactionZoomImage.offsetX}px, ${interactionZoomImage.offsetY}px)`;
  }
});
// Parar o arrasto
interactionZoomImage.modal.addEventListener("mouseup", () => {
  interactionZoomImage.isDragging = false;
  interactionZoomImage.modalImg.style.cursor = "grab";
});
// Também para o arrasto ao sair do modal
interactionZoomImage.modal.addEventListener("mouseleave", () => {
  interactionZoomImage.isDragging = false;
  interactionZoomImage.modalImg.style.cursor = "grab";
});
//#endregion HANDLE ZOOM

$(function(){ loadGallery(); });