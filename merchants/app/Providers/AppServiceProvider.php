<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\GeneralSetting;
use App\Models\Contact;
use App\Models\SocialMediaLink;

use App\Models\StaticPage;
use Session;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {

        $this->aclStatus = GeneralSetting::where('url_key', 'acl')->first()->status;
        $this->loyaltyStatus = GeneralSetting::where('url_key', 'loyalty')->first()->status;
        $this->referralStatus = GeneralSetting::where('url_key', 'referral')->first()->status;
        $this->ebsStatus = GeneralSetting::where('url_key', 'ebs')->first()->status;

        $this->notificationStatus = GeneralSetting::where('url_key', 'notification')->first()->status;
        $this->socialmedialinks = SocialMediaLink::where('status', '1')->get();
        $this->contacts = Contact::where('status', '1')->get();
        $this->staticpages = StaticPage::where('status', '1')->get();
        $this->isstock = GeneralSetting::where('url_key', 'stock')->first()->status;
        
        if($this->isstock == 1){
            $stock = json_decode(GeneralSetting::where('url_key', 'stock')->first()->details);
      //  dd($stock);
        $this->stocklimit = $stock->stocklimit;
        }

        $this->pincode = GeneralSetting::where('url_key', 'pincode')->first();
        $this->pincodeStatus = GeneralSetting::where('url_key', 'pincode')->first()->status;
       $activeEmailOpt= $this->getActiveEmail();
       
      
      
        if (!empty($activeEmailOpt)) {
            if ($activeEmailOpt->name == 'Mandrill') {
                $args = json_decode($activeEmailOpt->details);
                config([ 'mail.driver' => 'mandrill']);
                //  config()
                config([ 'service.mandrill.secret' => $args->key]);
                config([ 'mail.from.address' => $args->from]);
                config([ 'mail.from.name' => $args->name]);
            } else if ($activeEmailOpt->name == 'SMTP') {
                $args = json_decode($activeEmailOpt->details);
                config([ 'mail.driver' => 'smtp']);
                config([ 'mail.host' => $args->host]);
                config([ 'mail.port' => $args->port]);
                config([ 'mail.from.address' => $args->from]);
                config([ 'mail.from.name' => $args->name]);
                config([ 'mail.encryption' => $args->encryption]);
                config([ 'mail.username' => $args->username]);
                config([ 'mail.password' => $args->password]);
            }
        }
        //email module end
    
        view()->share('aclStatus', $this->aclStatus);
        view()->share('loyaltyStatus', $this->loyaltyStatus);
        view()->share('referralStatus', $this->referralStatus);
        view()->share('ebsStatus', $this->ebsStatus);


        view()->share('notificationStatus', $this->notificationStatus);
        view()->share('socialmedialinks', $this->socialmedialinks);
        view()->share('contacts', $this->contacts);
        view()->share('staticpages', $this->staticpages);
        view()->share('isstock', $this->isstock);
        if($this->isstock==1)
        view()->share('stocklimit', $this->stocklimit);

        view()->share('pincodeStatus', $this->pincode);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

    public function getActiveEmail() {
        $activeEmailOpt = GeneralSetting::where('type', 4)->where('status', 1)->first();
      
        return $activeEmailOpt;
    }

//
}
