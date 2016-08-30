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
  
  public function Query($subject, $route = 'database/search'){
    if( $this->Token() !== null ){
      $parameters = array(
        'token' => $this->Token(),
        'q' => $subject
      );
    }
    else{
      $parameters = array(
        'key' => $this->Key(),
        'secret' => $this->Secret(),
        'q' => $subject
      );
    }
    
    return Utilities::GetRequest($this->baseurl.$route, $parameters);
  }
  
  
}