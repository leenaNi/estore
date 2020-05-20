<?php
$adminConstants = [
    'AdminBootstrapCssPath' => 'public/admin/bootstrap/css/',
    'AdminBootstrapJsPath' => 'public/admin/bootstrap/js/',
    'AdminBootstrapFontsPath' => 'public/admin/bootstrap/fonts/',
    'AdminBuildPath' => 'public/admin/build/',
    'AdminDistCssPath' => 'public/admin/dist/css/',
    'AdminDistJsPath' => 'public/admin/dist/js/',
    'AdminDistImgPath' => 'public/admin/dist/img/',
    'AdminPluginPath' => 'public/admin/plugins/',
    'AdminUploadPath' => 'public/admin/uploads/',
    'notificationImgPath' => 'public/admin/uploads/notification/',
    'companyImgPath' => 'public/admin/uploads/company/',
    'brandImgPath' => 'public/admin/uploads/brand/',
    'AdminPages' => 'Admin.Pages',
    
    'AdminPagesBank' => 'Admin.Pages.Bank',
    'AdminPagesMerchant' => 'Admin.Pages.Merchants',
    'AdminPagesDistributors' => 'Admin.Pages.Distributors',
    'AdminPagesPaymentettlement' => 'Admin.Pages.paymentSettlement',
    'AdminPagesStores' => 'Admin.Pages.Stores',
    'AdminPagesAnalytic' => 'Admin.Pages.Analytic',
    'AdminPagesUpdatesCode' => 'Admin.Pages.Updates.CodeUpdate',
    'AdminPagesUpdatesDB' => 'Admin.Pages.Updates.DatabaseUpdate',
    'AdminPagesNotification' => 'Admin.Pages.notification',
    'AdminPagesSettings' => 'Admin.Pages.Settings',
    
    'AdminPagesReports' => 'Admin.Pages.Reports',
    'AdminStoreLogo' => 'public/admin/uploads/logos/',
    'adminCategoryMasterView' => 'Admin.Pages.Category',
    'AdminPagesMastersCategory' => 'Admin.Pages.Masters.Category',
    'AdminPagesMastersTheme' => 'Admin.Pages.Masters.Themes',
    'AdminPagesMastersLanguage' => 'Admin.Pages.Masters.Language',
    'AdminPagesMastersTranslation' => 'Admin.Pages.Masters.Translation',
    "AdminPagesMastersCountry" => 'Admin.Pages.Masters.Country',
    "AdminPagesMastersCurrency" => 'Admin.Pages.Masters.Currency',
    "AdminPagesMastersCompany" => 'Admin.Pages.Masters.Company',
    "AdminPagesMastersBrand" => 'Admin.Pages.Masters.Brand',
    
    'AdminPagesSystemUsersRoles' => 'Admin.Pages.SystemUsers.Roles',
    'AdminPagesSystemUsersUsers' => 'Admin.Pages.SystemUsers.Users',
    
    'AdminPagesBankUsersRoles' => 'Admin.Pages.BankUsers.Roles',
    'AdminPagesBankUsersUsers' => 'Admin.Pages.BankUsers.Users',
    'AdminPagesTemplates' => 'Admin.Pages.Templates',
    'AdminPagesCourier' => 'Admin.Pages.Courier',
    
     'AdminPaginateNo' => '10',
     
];


$frontendConstants = [
    'frontendView' => 'Frontend.pages',
    'frontendPaginateNo' => 10,
    'frontendPublicJsPath' => 'public/Frontend/js/',
    'frontendPublicEstorifiJsPath' => 'public/Frontend/js-estorifi/',
    'frontendMyAccView' => 'Frontend.pages.myacc',
    'frontendCatlogCategory' => 'Frontend.pages.catalog.category',
    'frontendCatlogProducts' => 'Frontend.pages.catalog.products',
    'frontCartView' => 'Frontend.pages.cart',
    'frontCheckoutView' => 'Frontend.pages.checkout',
    'frontendPublicImgPath' => 'public/Frontend/images/',
    'frontendPublicEstorifiImgPath' => 'public/Frontend/images-estorifi/',
    'frontviewEmailTemplatesPath' => 'Frontend/emails/',
    'frontendPublicCSSPath' => 'public/Frontend/css/',
    'frontendPublicEstorifiCSSPath' => 'public/Frontend/css-estorifi/',
    'domainURL'=> 'https://api.godaddy.com/v1/domains/'

];

return array_merge($frontendConstants, $adminConstants);
?>