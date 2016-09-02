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
  
  // Build payload and query Discogs API Search
  public function Search($subject, $route = 'database/search'){
    $parameters = $this->PreformAuth();
    $parameters['q'] = $subject;
    $data = Utilities::GetRequest($this->baseurl.$route, $parameters);
    return $this->CleanResults($data);
  }
  
  // Retrieve artist bio and releases
  public function GetArtist($id){
    $artist = array();
    $parameters = $this->PreformAuth();
    $data = Utilities::GetRequest($this->baseurl.'/artists/'.$id, $parameters);
    $artist['bio'] = $data;
    $data = Utilities::GetRequest($this->baseurl.'/artists/'.$id.'/releases', $parameters);
    $artist['music'] = $this->CleanReleases($data);
    return $artist;
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
  
  private function CleanReleases($data = null){
    $data = json_decode($data, true);
    $clean = array();
    
    foreach( $data['releases'] as $result ){
      if( $result['type'] == 'master' ){
        array_push($clean, $result);
      }
    }
    
    $data['releases'] = $clean;
    return json_encode($data);
  }
  
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