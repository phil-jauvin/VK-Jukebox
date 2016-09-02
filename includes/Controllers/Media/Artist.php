<?php
namespace Controllers\Media;

use \Origin\Utilities\Layout;
use \Jukebox\Integration\Discogs;

class Artist {
  
	public function Main($id){
		$client = new Discogs();
    $client->Populate();
    var_dump($client->GetArtist($id)['music']);
	}
	
  
}