
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

    if(url.includes('admin/group') && ( url.includes('edit') || url.includes('create') ) ) {

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
        <span data-trigger="hover" data-toggle="popover" title="${ route['title'] }" data-content="${ route['description'] }" style="margin-left: 5px; margin-right: 5px;">
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
            <span data-trigger="hover" data-toggle="popover" title="${group['groupName']}" data-content="${group['description']}" >
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


/*
$( document ).ready(function() {

    // --------------------------------------------------- //
    //jQuery(".logo").children().css({"max-width": "140px",});

    let page = window.location.href

    if(page.includes('admin/group/create') && ( page.includes('edit') || page.includes('create') ) ) {

        /!** ************************************************************************************************ *!/
        /!** ************************************************************************************************ *!/

        let removeBundles = [
            'ROLE_SONATA_USER_ADMIN_USER',
            'ROLE_SONATA_USER_ADMIN_GROUP',
            'ROLE_SONATA_MEDIA_ADMIN_MEDIA',
            'ROLE_SONATA_MEDIA_ADMIN_GALLERY',
            'ROLE_SONATA_MEDIA_ADMIN_GALLERY_HAS_MEDIA',
            'ROLE_USER',
            'ROLE_SONATA_ADMIN',
            'ROLE_ADMIN',
            'ROLE_SUPER_ADMIN',
            'ROLE_ALLOWED_TO_SWITCH',
            'SONATA',
            'ROLE_SONATA_PAGE_ADMIN_PAGE',
            'ROLE_SONATA_PAGE_ADMIN_PAGE_EDIT',
        ]

        let removeOptions = [
            'CREATE',
            'EDIT',
            'LIST',
            'DELETE',
            'EXPORT',
            'VIEW',
            'ALL',
        ]

        let allRoles = []
        $('.div-select-admin-roles option').each(function (index, element) {

            let value = element.value

            console.log(element)

            // removeBundles.forEach(function (name) {
            //
            //     if (value.includes(name)) {
            //         value = ''
            //     }
            //
            // })
            // if (value !== '') {
            //
            //     removeOptions.forEach(function (name) {
            //
            //         if (value.includes('_' + name)) {
            //             value = value.split('_' + name)
            //             value = value[0]
            //         }
            //     })
            //
            //     allRoles.push(value)
            // }

        })
        allRoles = [...new Set(allRoles)]

        /!** ************************************************************************************************ *!/
        /!** ************************************************************************************************ *!/

            //console.log(allRoles)

        let options = {
                'CREATE': 'Criar',
                'EDIT': 'Editar',
                'LIST': 'Listar',
                'DELETE': 'Excluir',
                'EXPORT': 'Exportar',
                'VIEW': 'Visualizar',
                'ALL': 'Todas Opções',
            }

        let defaultBundles = {
            'ROLE_SONATA_USER_ADMIN_USER': 'Usuário',
            'ROLE_SONATA_USER_ADMIN_GROUP': 'Grupo de Usuários',
            'ROLE_SONATA_MEDIA_ADMIN_MEDIA': 'Mídia',
            'ROLE_SONATA_MEDIA_ADMIN_GALLERY': 'Galeria',
            'ROLE_SONATA_MEDIA_ADMIN_GALLERY_HAS_MEDIA': 'Mídia Em Galeria',
        }

        let adminOptions = {
            //'ROLE_USER': 'Role User',
            //'ROLE_SONATA_ADMIN': 'Role Sonata Admin',
            //'ROLE_ADMIN': 'Role Admin',
            'ROLE_SUPER_ADMIN': 'Super Admin',
            //'ROLE_ALLOWED_TO_SWITCH': 'Role Allowed To Switch',
            //'SONATA': 'Sonata',
            //'ROLE_SONATA_PAGE_ADMIN_PAGE_EDIT': 'Role Sonata Page Admin Page',
        }

        let box = ''

        /!** ************************************************************************************************ *!/
        /!** ********************************* Admin Bundles ************************************* *!/

        let option = ''
        Object.entries(adminOptions).forEach(([key, value]) => {

            option += `
             <div>
                <input class="icheckbox_square-blue roleCheckBox" type="checkbox" id="${key}">
                <label class="form-check-label" for="${key}">${value}</label>
             </div>
`

        })

        box += `
           <div class="col-md-3 shadow p-3 mb-5 bg-body rounded" >

                <div class="" style=" padding:20px;">
    
                    <label class=" control-label">Permissões Administrativas</label>
                    <input type="text" readonly="readonly" class="form-control" value="Permissões Administrativas">
                    <label class="control-label" style="padding-top: 10px;">Permissões</label>
    
                    ${option}

                </div>

            </div>         
`

        /!** ************************************************************************************************ *!/
        /!** ************************************************************************************************ *!/


        /!** ************************************************************************************************ *!/
        /!** ********************************** Default Bundles ********************************************* *!/
        Object.entries(defaultBundles).forEach(([key, value]) => {

            let option = ''
            Object.entries(options).forEach(([optionsKey, optionsValue]) => {

                option += `
             <div>
                <input class="icheckbox_square-blue roleCheckBox" type="checkbox" id="${key}_${optionsKey}">
                <label class="form-check-label" for="${key}_${optionsKey}">${optionsValue}</label>
             </div>
`

            })

            box += `
           <div class="col-md-3 shadow p-3 mb-5 bg-body rounded" >

                <div class="" style=" padding:20px;">
    
                    <label class=" control-label">Módulo ${value}</label>
                    <input type="text" readonly="readonly" class="form-control" value="${value}">
                    <label class="control-label" style="padding-top: 10px;">Permissões</label>
    
                    ${option}

                </div>

            </div>         
`
        });
        /!** ************************************************************************************************ *!/
        /!** ************************************************************************************************ *!/


        /!** ************************************************************************************************ *!/
        /!** ********************************** Default Bundles ********************************************* *!/
        Object.entries(allRoles).forEach(([key, value]) => {

            let option = ''
            Object.entries(options).forEach(([optionsKey, optionsValue]) => {

                option += `
             <div>
                <input class="icheckbox_square-blue roleCheckBox" type="checkbox" id="${value}_${optionsKey}">
                <label class="form-check-label" for="${value}_${optionsKey}">${optionsValue}</label>
             </div>
`

            })

            box += `
           <div class="col-md-3 shadow p-3 mb-5 bg-body rounded" >

                <div class="" style=" padding:20px;">
    
                    <label class=" control-label">Módulo ${value.split("_").pop()}</label>
                    <input type="text" readonly="readonly" class="form-control" value="${value.split("_").pop()}">
                    <label class="control-label" style="padding-top: 10px;">Permissões</label>
    
                    ${option}

                </div>

            </div>         
`
        });
        /!** ************************************************************************************************ *!/
        /!** ************************************************************************************************ *!/


        $('.div-roles').children('div.box-primary').children('div.box-header').append('<br><br><div class="row">' + box + '</div>')
        $('.div-roles').children('div.box-primary').children('div.box-body').css('display', 'none')


        /!**
         * Faz a seleção no Select
         *!/
        $('.roleCheckBox').on("click", function () {
            let id = this.id
            if ($(this).is(':checked') == true) {
                $("[value='" + id + "']").prop("selected", "selected");
            } else {
                $("[value='" + id + "']").removeAttr('selected');
            }
        })

        /!**
         * Faz a seleção no Input
         *!/
        $('select option').each(function (index, element) {

            let id = this.value

            if ($(this).is(':selected') == true) {
                $("#" + id).trigger('click')
            }

        })


    }






    const alterRolesPage = false;



});*/
