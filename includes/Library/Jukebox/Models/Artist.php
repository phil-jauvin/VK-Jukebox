<?php
namespace Jukebox\Models;

use \Origin\Utilities\Settings;
use \Origin\Utilities\Utilities;
use \Origin\Utilities\Bucket\Bucket;
use \Origin\Utilities\Bucket\Common;
use \Jukebox\Integration\Discogs;

class Artist {
  
  use Bucket, Common{
    Number as ID;
    String as Profile;
    String as Thumb;
    Hash as Releases;
  }
  
  public function __construct($id, $auto_populate = true){
    $this->ID($id);
  }
  
  
  public function Populate(){
    $id = $this->ID();
    $meta = json_decode( $this->GetInfo($id), true );
    
    foreach($meta as $attribute => $data){
      switch($attribute){
        case 'profile':
          $this->Profile($data);
          break;
        case 'images':
          $this->Thumb($data[0]['uri']);
          break;
      }
    }
    
    $releases = $this->GetReleases();
    $releases = json_decode($releases, true);
    $this->Releases($releases);
  }
  
  // Retrieve artist information
  public function GetInfo(){
    $id = $this->ID();
    $client = new Discogs();
    $client->Populate();
    return $client->Query( array(), 'artists/'.$id );
  }
  
  // Retrieve artist releases
  public function GetReleases(){
    $id = $this->ID();
    $client = new Discogs();
    $client->Populate();
    $data = $client->Query( array(), 'artists/'.$id.'/releases' );
    return $this->CleanReleases($data);
  }
  
  // Remove anything that isn't a master release
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
  
 
  
}