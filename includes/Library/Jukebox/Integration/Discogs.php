<?php
namespace Jukebox\Integration;

use \Origin\Utilities\Settings;
use \Origin\Utilities\Utilities;
use \Origin\Utilities\Bucket\Bucket;
use \Origin\Utilities\Bucket\Common;

class Discogs {
  
  private $baseurl = 'https://api.discogs.com/';
  
  use Bucket, Common{
    String as Key;
    String as Secret;
    String as Token;
  }
  
  public function __construct($key = null, $secret = null, $token = null){
    $this->Key( $key );
    $this->Secret( $secret );
    $this->Token( $token );
  }
  
  // Populate Credentials from settings.json
  public function Populate(){
    $credentials = Settings::Get('settings')->Values(['discogs']);
    
    foreach( $credentials as $name => $value ){
      switch($name){
        case 'key':
          $this->Key($value);
          break;
        case 'secret':
          $this->Secret($value);
          break;
        case 'token':
          $this->Token($value);
          break;
      }
    }
  }
  
  // Generic API query
  public function Query($parameters, $route){
    foreach( $this->PreformAuth() as $key => $value ){
      $parameters[$key] = $value;
    }
    return Utilities::GetRequest($this->baseurl.$route, $parameters);
  }
  
  // Build payload and query Discogs API Search
  public function Search($subject){
    $parameters = array('q' => $subject);
    $data = $this->Query($parameters, 'database/search');
    return $this->CleanResults($data);
  }
  
  // Remove anything that isn't a Master release or Arist
  private function CleanResults($data = null){
    $data = json_decode($data, true);
    $clean = array();
    
    foreach( $data['results'] as $result ){
      if( $result['type'] == 'master' || $result['type'] == 'artist' ){
        array_push($clean, $result);
      }
    }
    
    $data['results'] = $clean;
    return json_encode($data);
  }
  
  // Return an array that already contains Auth parameters for request
  private function PreformAuth(){
    if( $this->Token() !== null ){
      $parameters = array(
        'token' => $this->Token(),
      );
    }
    else{
      $parameters = array(
        'key' => $this->Key(),
        'secret' => $this->Secret(),
      );
    }
    
    return $parameters;
  }
  
  
}