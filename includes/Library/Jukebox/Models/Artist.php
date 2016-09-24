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
    Hash as Pagination;
  }
  
  public function __construct($id, $auto_populate = true){
    $this->ID($id);
    if($auto_populate === true){
      $this->Populate();
    }
  }
  
  public function Populate(){
    $client = new Discogs();
    $client->Populate();
    
    // Get artist information
    $info = $client->Query( array(), 'artists/'.$this->ID() );
    $info = json_decode( $info, true );
    $this->Profile($info['profile']);
    $this->Thumb($info['images'][0]['uri']);
    
    // Get artist releases
    $releases = $client->Query( array('sort_order' => 'desc'), 'artists/'.$this->ID().'/releases' );
    $releases = json_decode($releases, true);
    $this->Releases($releases['releases']);
    $this->Pagination($releases['pagination']);
  }
  
  
  // Remove anything that isn't a master release
  // Don't really need this for now, but might later
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