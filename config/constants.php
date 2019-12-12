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
    'AdminPages' => 'Admin.Pages',
    
    'AdminPagesBank' => 'Admin.Pages.Bank',
    'AdminPagesMerchant' => 'Admin.Pages.Merchants',
    'AdminPagesPaymentettlement' => 'Admin.Pages.paymentSettlement',
    'AdminPagesStores' => 'Admin.Pages.Stores',
    'AdminPagesAnalytic' => 'Admin.Pages.Analytic',
    'AdminPagesUpdatesCode' => 'Admin.Pages.Updates.CodeUpdate',
    'AdminPagesUpdatesDB' => 'Admin.Pages.Updates.DatabaseUpdate',
    'AdminPagesNotification' => 'Admin.Pages.notification',
    'AdminPagesSettings' => 'Admin.Pages.Settings',
    
      'AdminStoreLogo' => 'public/admin/uploads/logos/',
    'AdminPagesMastersCategory' => 'Admin.Pages.Masters.Category',
      'AdminPagesMastersTheme' => 'Admin.Pages.Masters.Themes',
    'AdminPagesMastersLanguage' => 'Admin.Pages.Masters.Language',
    'AdminPagesMastersTranslation' => 'Admin.Pages.Masters.Translation',
    
    'AdminPagesSystemUsersRoles' => 'Admin.Pages.SystemUsers.Roles',
    'AdminPagesSystemUsersUsers' => 'Admin.Pages.SystemUsers.Users',
    
    'AdminPagesBankUsersRoles' => 'Admin.Pages.BankUsers.Roles',
    'AdminPagesBankUsersUsers' => 'Admin.Pages.BankUsers.Users',
    'AdminPagesTemplates' => 'Admin.Pages.Templates',
    'AdminPagesCourier' => 'Admin.Pages.Courier',
    
     'AdminPaginateNo' => '10'
];


$frontendConstants = [
    'frontendView' => 'Frontend.pages',
    'frontendPaginateNo' => 10,
    'frontendPublicJsPath' => 'public/Frontend/js/',
    'frontendMyAccView' => 'Frontend.pages.myacc',
    'frontendCatlogCategory' => 'Frontend.pages.catalog.category',
    'frontendCatlogProducts' => 'Frontend.pages.catalog.products',
    'frontCartView' => 'Frontend.pages.cart',
    'frontCheckoutView' => 'Frontend.pages.checkout',
    'frontendPublicImgPath' => 'public/Frontend/images/',
    'frontviewEmailTemplatesPath' => 'Frontend/emails/',
    'frontendPublicCSSPath' => 'public/Frontend/css/',
    'domainURL'=> 'https://api.godaddy.com/v1/domains/' . env('APP_URL') . '/records'

];

return array_merge($frontendConstants, $adminConstants);
?>