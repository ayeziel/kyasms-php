<?php
namespace kyasms\App;
use Propaganistas\LaravelPhone\PhoneNumber;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Exception;

class ClassKyasms {


     public function SendSms($from, $to, $message, $type, $clientid , $apikey)
     {

        $from_check = strlen($from);

         if($from_check >= 2 && $from_check <=11 ){


         	$phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();

         	  try {

                   $phoneNumberObject = $phoneUtil->parse($to, null);


                      if($type == 1 OR $type == 0){

                      	if(!empty($message)){

                      	$client = new Client();

                      	$request = new Request('POST', 'https://route.kyasms.net/api/v1/sms/send');

                      	// Send Request
                           $response = $client->send($request, [
                              'headers' => [
                                 'Content-Type' => 'application/x-www-form-urlencoded',
                                 'CLIENTID' => $clientid, 
                                  'APIKEY' => $apikey
                                ],
                               'form_params' => [
                                  'from'   => $from,
                                   'to'    => $to,
                                   'message' => $message,
                                   'type' => $type
                                ]
                            ]);

                           $response_body = (string)$response->getBody();
                             return $response_body;

                     // $request = new Request('POST', 'https://route.kyasms.net/api/v1/sms/send', ['CLIENTID' => $clientid, 'APIKEY' => $apikey, 'Content-Type' => 'application/json']);

                       }else{
                       	 throw new Exception('no message');
                       }


                      }else{
                      	throw new Exception('Type invalid sms, use 0 or 1');
                      }

         	      
         	       }catch (\libphonenumber\NumberParseException $e) {
                    
                        var_dump($e);            
                   }
         

         }else{
         	throw new Exception('Invalid sender format');
         }
        
     }

      /* Send builk sms*/

      public function SendBuilkSms($from, $to, $message, $type, $clientid , $apikey){


         $from_check = strlen($from);

         if($from_check >= 2 && $from_check <=11 ){

            if(!empty($to)){

            	if($type == 1 OR $type == 0){

                    if(!empty($message)){


                     $client = new Client();

                      	$request = new Request('POST', 'https://route.kyasms.net/api/v1/sms/builk');

                      	// Send Request
                           $response = $client->send($request, [
                              'headers' => [
                                 'Content-Type' => 'application/x-www-form-urlencoded',
                                 'CLIENTID' => $clientid, 
                                  'APIKEY' => $apikey
                                ],
                               'form_params' => [
                                  'from'   => $from,
                                   'to'    => $to,
                                   'message' => $message,
                                   'type' => $type
                                ]
                            ]);

                           $response_body = (string)$response->getBody();
                             return $response_body;



                     }else{
                       	 
                       throw new Exception('no message');
                     }


                }else{
                    throw new Exception('Type invalid sms, use 0 or 1');
                }

            }else{
             throw new Exception('No recipients found or invalid format. e.g (+22966XXXX, +22998XXXXX)');
            }
          
           }else{
         	throw new Exception('Invalid sender format');
         }

      }

}