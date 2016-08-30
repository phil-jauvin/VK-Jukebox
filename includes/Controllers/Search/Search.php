<?php
namespace Controllers\Search;

use \Origin\Utilities\Layout;
use \Origin\Utilities\Settings;
use \Origin\Utilities\Utilities;
use \Jukebox\Integration\Discogs;

class Search {
  
  public function Main(){
    if( isset($_REQUEST['query']) ){
      header("Location: /search/".$_REQUEST['query']);
      exit();
    }
    else{
      $this->Query('');
    }
  }
  
  public function Query($query){
    $client = new Discogs();
    $client->Populate();
    echo $client->Query($query);
  }
  
}