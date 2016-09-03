<?php
namespace Controllers\Search;

use \Origin\Utilities\Layout;
use \Origin\Utilities\Settings;
use \Origin\Utilities\Utilities;
use \Jukebox\Integration\Discogs;

class Search {
  
  public function Main(){
    if( isset($_REQUEST['query']) ){
      header("Location: /search/".$this->Encode($_REQUEST['query']) );
      exit();
    }
    else{
      $this->Query('');
    }
  }
  
  public function Query($query){
    $query = urlencode($this->Decode($query));
    $client = new Discogs();
    $client->Populate();
    Layout::Get()->Assign('response', json_decode($client->Search($query), true) );
    Layout::Get()->Display('search.tpl');
  }
  
  // Custom encoding because I'm having issues with the framework's router
  private function Encode($string = null){
    return str_replace(' ', '20', $string);
  }
  
  private function Decode($string = null){
    return str_replace('20', ' ', $string);
  }
  
}