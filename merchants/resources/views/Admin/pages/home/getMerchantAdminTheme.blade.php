<?php
/*echo "<pre>";
print_r($cats);
exit;*/
$basePath = base_path();
$basePathUrl = implode("/", explode('\\', $basePath, -1));
//echo "base path url::".$basePathUrl;
$basePathUrl = $basePathUrl . '/public/public/admin/themes/';

$html = "";
$html .= '<section id="page-title" class=" page-title-center" style=" padding: 50px 0;" data-stellar-background-ratio="0.3">';
$html .= '<div class="clearfix">';
$html .= '<h1 class="">Themes for your online store </h1>';
$html .= '<span class="">Easily customizable and mobile friendly themes to match your brand</span>';
$html .= '</div>';
$html .= '</section>';
$html .= '<section id="content">';
$html .= '<div class="content-wrap">';
$html .= '<div class="clearfix">';
$html .= '<ul id="portfolio-filter" class="portfolio-filter  style-4 clearfix " data-container="#portfolio">';
if (empty(Session::get('merchantid'))) {
    $html .= '<li class="activeFilter"><a href="#" data-filter=".tab0" data-filter="*">All</a></li>';
}
foreach ($cats as $c) {
    $categoryName = $c[0]->category;
    $categoryId = $c[0]->id;

    $html .= '<li><a href="#" data-filter="' . $categoryId . '">' . $categoryName . '</a></li>';
}
$html .= '</ul>';
$html .= '<div class="clear"></div>';
/* Portfolio Items */
$html .= '<div id="portfolio" class="portfolio  grid-container clearfix">';
foreach ($cats as $c) {
    $catID = $c[0]->id;
    foreach (App\Models\StoreTheme::where("cat_id", $catID)->where("status", 1)->get() as $theme) {
        $themimg = ($theme->image) ? $theme->image : 'default-theme.png';
        $serveHost = substr($_SERVER['HTTP_HOST'], (strpos($_SERVER['HTTP_HOST'], '.') + 1));
        $imagePathUrl = "https://" . $serveHost . '/public/admin/themes/' . $themimg;
        $path = $basePathUrl . $themimg;
        $themeVal = "https://" . $serveHost . '/themes/' . strtolower($theme->name) . "_home.php";
        $themeId = $theme->id;
        $themeName = $theme->name;
        $html .= '<article class="portfolio-item tab{{$c->id}} tab0">';
        $html .= '<div class="portfolio-image port-img-outline">';
        //$html .= '<img src="{{ asset('.$path.') }}" alt="'.$themeName.'">';
        $html .= '<img height="50%" width="50%" src="' . $imagePathUrl . '" alt="' . $themeName . '">';
        $html .= '</a>';
        $html .= '<div class="portfolio-overlay">';
        $html .= '<div class="center-text" >';
        $html .= '<h3 class="nobottommargin white-text">' . $themeName . '</h3>';
        $html .= '<a type="button" href="' . route("admin.home.applyMerchantTheme", ["cateId" => $catID, "themeId" => $themeId]) . '" class="btn btn-default noAllMargin updateTheme mobileSpecialfullBTN ">Appy Theme</a>';
        //$html .= '<a type="button" href="javascript:;" onClick="applyMerchantTheme('.$catID.','.$themeId.')" target="_blank" class="btn btn-default noAllMargin updateTheme mobileSpecialfullBTN">Appy Theme</a>';
        // $html .= '<a type="button" href="'.$themeVal.'?theme='.$theme->name.'" target="_blank" class="btn btn-default noAllMargin updateTheme mobileSpecialfullBTN">View Theme</a>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</article>';
    }
}
$html .= '</div>';
$html .= '</div>';
$html .= '</div>';
$html .= '</section>';
echo $html;
