<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\User;
use App\Setting;
use GuzzleHttp\Client;
use App\State;
use App\Role;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProfessionalLicenseValidationMail;
use App\Mail\ProfessionalLicenseInvalidationMail;

class ProfessionalLicenseValidation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $sepServicesAreDown = false;
    public $firstname, $middlename, $lastname, $professional_license, $user_id;
    public $release_time; 

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($firstname, $middlename, $lastname, $professional_license, $user_id)
    {
        $this->firstname = $firstname;
        $this->middlename = $middlename;
        $this->lastname = $lastname;
        $this->professional_license = $professional_license;
        $this->user_id = $user_id;
        $this->release_time = 300; // 5 minutes.
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::find($this->user_id);
        if($user == null){
            return;
        }
        if($user->enabled && $user->is_validated ){
            return;
        }
        if($this->verifyProfessionalLicense($this->professional_license, $this->firstname, $this->middlename, $this->lastname)){
            $user->enabled = true;
            $user->is_validated = true;
            $user->save();
            Mail::to($user->email)->send(new ProfessionalLicenseValidationMail());
            // send email professional license validated
            return;
        }else{
            if($this->sepServicesAreDown){ // Try in some minutes
                $this->dispatch($this->delay($this->release_time));
                return;
            }
            $user->enabled = false;
            $user->is_validated = false;
            $user->professional_license = null;
            $user->save();
            Mail::to($user->email)->send(new ProfessionalLicenseInvalidationMail());
            // Email professional license not validated
            // User::destroy($this->user_id);
            return;
        }
    }

    public function verifyProfessionalLicense($license, $firstname, $middlename, $lastname){
        $this->sepServicesAreDown = false;
        try{
            $client = new Client();
            $setting = Setting::first();
            $serviceUrl = $setting->professional_license_service;
            if($serviceUrl == ''){
                $serviceUrl = "https://dev.academia.nurun.com.mx/cedula/cedula/";
            }
            $response = $client->request('POST', $serviceUrl, [
                'form_params' => [
                    'name' => $firstname,
                    'mid_name' => $middlename,
                    'last_name' => $lastname,
                    'cedula' => $license
                ]
            ]);
            $responseString = $response->getBody()->getContents();
            $jsonResponse = json_decode($responseString);
            if($jsonResponse == false){
                $this->sepServicesAreDown = true;
                return false;
            }
            $status = $jsonResponse->{'status'};
            $message = $jsonResponse->{'message'};
            $this->sepServicesAreDown = false;
            switch ($status) {
                case '406': // User found, but with not a valid profession
                    return false;
                    break;
                case '500': // unavailable service
                    $this->sepServicesAreDown = true;
                    return false;
                    break;
                case '404': // No data found or not valid
                    return false;
                    break;
                case '200':
                    $professional_license = $jsonResponse->{'cedula'};
                    if($license == $professional_license){
                        return true;
                    }
                    break;
                default:
                    return false;
                    break;
            }
            return false;
        } catch (\Exception $ex) { // In this case, service returns a no valid response (not a json)
            $this->sepServicesAreDown = true;
            return false;
        } catch (\Throwable $ex) {
            $this->sepServicesAreDown = true;
            return false;
        }
    }
}
