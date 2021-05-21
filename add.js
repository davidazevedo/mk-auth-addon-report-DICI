/**
* ABAIXO EXEMPLO DE COMO INCLUIR ITEM NO MENU PRINCIPAL DO SISTEMA
* DESCOMENTE AS LINHAS ABAIXO E LIMPE O CACHE DO NAVEGADOR QUE NO
* MENU PROVEDOR SERA INCLUSO UM LINK PARA ADDON TESTE DE EXEMPLO
*
* app_menu_provedor, app_menu_opcoes, app_menu_clientes,
* app_menu_financeiro, app_menu_estoque, app_menu_suporte,
* app_menu_central, app_menu_hotsite e app_menu_relatorios.
*/

var minha_url = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port: '') + "/admin/";
app_menu_provedor.itens.push({plink: minha_url + 'addons/dici/', ptext: 'Gerador DICI' });
