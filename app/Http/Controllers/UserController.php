<?php
namespace App\Http\Controllers;
use App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client; 
// use Google_Service_Drive;

class UserController extends Controller {
    public function show()
    {
        //Step 1: Enter you google account credentials

        $g_client = new Google_Client();

        $g_client->setClientId("951252944123-1rf5k2sv0u5trf2ldrl92fv0ld49b433.apps.googleusercontent.com");
        $g_client->setClientSecret("B_ea0zcpf5z0Qjg5-2oExRyg");
        $g_client->setRedirectUri("http://localhost:8000");
        $g_client->setScopes("email");

        //Step 2 : Create the url
        $auth_url = $g_client->createAuthUrl();
        echo "<a href='$auth_url'>Login Through Google </a>";

        //Step 3 : Get the authorization  code
        $code = isset($_GET['code']) ? $_GET['code'] : NULL;

        //Step 4: Get access token
        if(isset($code)) {

            try {

                $token = $g_client->fetchAccessTokenWithAuthCode($code);
                $g_client->setAccessToken($token);

            }catch (Exception $e){
                echo $e->getMessage();
            }




            try {
                $pay_load = $g_client->verifyIdToken();


            }catch (Exception $e) {
                echo $e->getMessage();
            }

        } else{
            $pay_load = null;
        }

        if(isset($pay_load)){

            // return view('pizza', ['authUrl' => $auth_url, 'payload' => $pay_load]);

        }


        // $data = [
        //     'something1',
        //     'something2',
        //     'something3',
        // ]
        return view('welcome', ['authUrl' => $auth_url, 'payload' => $pay_load]);
    }
};
