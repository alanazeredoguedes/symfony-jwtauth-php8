
$( document ).ready(function() {

    const Toast = Swal.mixin({
        toast: false,
        position: 'top-end',
        showConfirmButton: false,
        timer: 6000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    // --------------------------------------------------- /

    let url = window.location.href
    let baseUrl = window.location.origin

    if( ( url.includes('admin/group') ||  url.includes('admin/user') ) && ( url.includes('edit') || url.includes('create') ) ) {

        const roles = { adminRoles: [], apiRoles: [],}

        /** Get All Admin Roles  */
        let getRoles = $.get(baseUrl+"/admin/group/listAllRoles", function( data ) {
            roles['adminRoles'] = data['adminRoles']
            roles['apiRoles'] = data['apiRoles']
        })

        getRoles.done(function() {

            initChanges(roles);

            $(function () { $('[data-toggle="popover"]').popover() })

        }).fail(function() {
            Toast.fire({
                icon: 'error',
                title: 'Erro ao Carregar Permissões',
                html: '<h5>Recarregue a página, caso o erro persista contate o administrador!</h5>'
            })
        })

    }


});

const initChanges = (roles)=> {

    let selectAdmin = $('.div-select-admin-roles')
    let selectApi = $('.div-select-api-roles')

    /** Oculta Div Select*/
    selectAdmin.parent().css('display', 'none')
    selectApi.parent().css('display', 'none')

    let adminTemplate = '';
    let apiTemplate = '';

    roles['adminRoles'].forEach((value, index)=>{
        adminTemplate += generateTemplate(value)
    })

    roles['apiRoles'].forEach((value, index)=>{
        apiTemplate += generateTemplate(value)
    })

    selectAdmin.parent().parent().append( "<div class='box-body row' style='margin-top: -40px;'>" + adminTemplate + "</div>" )
    selectApi.parent().parent().append( "<div class='box-body row' style='margin-top: -40px;'>" + apiTemplate + "</div>" )

    /** Registra alterações dos inputs no select */
    $('.roleCheckBox').on("click", function () {
        let id = this.id
        if ($(this).is(':checked') === true) {
            $(`[value="${id}"]`).prop("selected", "selected");
        } else {
            $(`[value="${id}"]`).removeAttr('selected');
        }
    })

    /** Registar alterações do select nos inputs */
    $('select option').each(function (index, element) {
        let id = this.value
        if ($(this).is(':selected') === true) {
            $(`#${id}`).trigger('click')
        }
    })

    /** Caso tadas as opcoes de um Modulo estivem selecionadas - seleciona o input todas as opcoes */
    $('.div_opcoes').each(function () {

        let id = $(this).attr('id')

        let divInputs = $(`#${id} input`)
        let opcoesCount = 0;
        let numberInputs = divInputs.length -1

        divInputs.each(function () {
            ( $(this).is(':checked') === true ) ? opcoesCount +=1 : '';

            if($(this).attr('class').includes('todas_opcoes')){
                if(numberInputs === opcoesCount){
                    $(this).click()
                }
            }
        })

    })


    $('.todas_opcoes').on("click", function () {
        let id = this.id
        let group = id.replace('TODAS_OPCOES_', '');

        if ($(this).is(':checked') === true) {
            changeAllOptionsGroup(group, true)
        }else{
            changeAllOptionsGroup(group, false)
        }
    })

}

const changeAllOptionsGroup = (group, status) => {

    $(`#OPCOES_${group} input`).each(function (index, element) {
        if(status){
            if ($(this).is(':checked') === false) {
                $(this).click()
            }
        }else{
            if ($(this).is(':checked') === true) {
                $(this).click()
            }
        }


    })
}



const generateTemplate = (group) => {

    //console.log(group)

    let routes = '';

    group['routes'].forEach((route, index)=>{

        routes += `
    <div>
        <input class="icheckbox_square-blue roleCheckBox" type="checkbox" id="${ route['role'] }">
        <span data-trigger="hover" data-toggle="popover" title="${ route['title'] }" data-content="${ route['description']? route['description'] : '' }" style="margin-left: 5px; margin-right: 5px;">
            <i class="fa fa-solid fa-info-circle"></i>
            <label class="form-check-label" for="${ route['role'] }">${ route['title'] }</label>
        </span>
    </div>
`
    })

    routes += `
    <div>
        <input class="icheckbox_square-blue todas_opcoes" type="checkbox" id="TODAS_OPCOES_${group['groupName']}">
        <span data-trigger="hover" data-toggle="popover" title="Todas Opções" data-content="Seleciona todas as Permissões do Módulo" style="margin-left: 5px; margin-right: 5px;">
            <i class="fa fa-solid fa-info-circle"></i>
            <label class="form-check-label" for="TODAS_OPCOES_${group['groupName']}">Todas Opções</label>
        </span>
    </div>
`



    return `
    <div class="col-sm-auto col-md-6 col-lg-3 col-lg-3">
        <div style="padding:20px;">
            <span data-trigger="hover" data-toggle="popover" title="${group['groupName']}" data-content="${ group['description']? group['description'] : '' }" >
                <label class="control-label">Módulo ${group['groupName']}</label>
                <i class="fa fa-solid fa-info-circle"></i>
            </span>
            <input type="text" readonly="readonly" class="form-control" value="${group['groupName']}">
            <label class="control-label" style="padding-top: 10px;">Permissões</label>
            <div class="div_opcoes" id="OPCOES_${group['groupName']}">
                ${routes}
            </div>
        </div>
    </div>
`;

}


