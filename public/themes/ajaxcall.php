 
<?php function abc(){
  $store= $_POST['storeName'];
     $storePath="/var/www/html/".$store."/storage";
      $path = $storePath . "/json/storeSetting.json";
      
        $str = file_get_contents($path);
         
        $settings = json_decode($str, true);


        return  json_encode($settings);
   //  return $path;
 } 
echo abc();
 ?>