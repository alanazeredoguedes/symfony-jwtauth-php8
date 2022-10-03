$( document ).ready(function() {

    /** Remove Icone Mosaic da pagina [LIST] do Sonata Admin */
    let icoMosaic = $('.fa-th-large').parent()
    if(icoMosaic.attr('href').includes('mosaic')){
        icoMosaic.remove()
    }



})