const gallery_control = { len: 0 };
const gallery_control_variation = { '2': { len: 0 }, '3': { len: 0 } };
function loadGallery(variation = undefined){
  let containerGalleryId = variation ? `#container-gallery-${variation}` : '#container-gallery';

  let url = cms_gallery?.url;
  let access_token = cms_gallery?.token;
  let take = cms_gallery?.take;

  if(variation){
    if(!outhers_cms_galleries || !outhers_cms_galleries[variation]) return;
    
    url = outhers_cms_galleries[variation].url;
    access_token = outhers_cms_galleries[variation].token;
    take = outhers_cms_galleries[variation].take;
  }
  if(!url || !access_token) return;

  $(containerGalleryId).parent().removeClass('gallery-filled');
  let wrapper = $(containerGalleryId).parent();

  let mode = wrapper.hasClass('mosaic-gallery') ? 'mosaic' : wrapper.hasClass('netflix-gallery') ? 'netflix' : 'carousel';
  let rows = Number(wrapper[0].dataset.rows);
  
  $.ajax({
    url, headers: { "access-token": access_token, "take": take },
    method: "GET"
  }).done(data => {
    if(data.result){
      $(containerGalleryId).html('');

      let images = data.response.images;
      
      if(variation){
        if(gallery_control_variation[variation]) gallery_control_variation[variation].len = images.length;
      } 
      else gallery_control.len = images.length;
      
      if(images.length === 0) $(containerGalleryId).html(`
        <p class="text-loading">Nenhuma imagem encontrada!</p>
      `);
      else{
        $(containerGalleryId).parent().addClass('gallery-filled');
        images.forEach((image, i) => {
          if(mode === 'mosaic'){
            if(i % (rows * 3) === 0) $(containerGalleryId).append('<div class="gallery-row"></div>');
            
            $(containerGalleryId).children().last().append(
              renderImageFromGallery(image, i, variation)
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
            )) $(containerGalleryId).append('<div class="gallery-row"></div>');
            
            $(containerGalleryId).children().last().append(
              renderImageFromGallery(image, i, variation)
            );
          }
        });

        handleImageOnerrorInScope(containerGalleryId);
      } 
    }
  }).fail(err => {
    $(containerGalleryId).html(`
      <p class="text-loading">Houve um erro ao carregar a galeria!</p>
    `);
  });;
}
function renderImageFromGallery(image, index, variation = undefined){
  return `
    <img src="${image.name}" alt="${image.alt}" data-index="${index}" data-variation="${variation ?? ''}" class="gallery-image" onclick="openZoomImage(this,${index})"/>
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
  interactionZoomImage.modalImg.dataset.variation = img.dataset.variation;

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

  let variation = interactionZoomImage.modalImg.dataset.variation ?? undefined;
  let containerGalleryId = variation ? `#container-gallery-${variation}` : '#container-gallery';
  let controlLen = variation ? gallery_control_variation[variation]?.len ?? 0 : gallery_control.len;

  let index = interactionZoomImage.modalImg.dataset.index === '0' ? (
    controlLen - 1
  ) : Number(interactionZoomImage.modalImg.dataset.index) - 1;
  
  const el = document.querySelector(`${containerGalleryId} .gallery-image[data-index="${index}"]`)

  if(el) el.click();
  else console.log(`[element-not-found] ${containerGalleryId} .gallery-image[data-index="${index}"]`);
});
document.querySelector('#modal-zoom-gallery-image .btn-right').addEventListener("click", function(event) {
  event.stopPropagation();

  let variation = interactionZoomImage.modalImg.dataset.variation ?? undefined;
  let containerGalleryId = variation ? `#container-gallery-${variation}` : '#container-gallery';
  let controlLen = variation ? gallery_control_variation[variation]?.len ?? 0 : gallery_control.len;

  let index = interactionZoomImage.modalImg.dataset.index === String(
    controlLen - 1
  ) ? 0 : Number(interactionZoomImage.modalImg.dataset.index) + 1;

  const el = document.querySelector(`${containerGalleryId} .gallery-image[data-index="${index}"]`)

  if(el) el.click();
  else console.log(`[element-not-found] ${containerGalleryId} .gallery-image[data-index="${index}"]`);
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

$(function(){
  if(cms_gallery) loadGallery();
  if(outhers_cms_galleries){
    if(outhers_cms_galleries['2']) loadGallery('2')
    if(outhers_cms_galleries['3']) loadGallery('3')
  }
});