<?php
namespace Controllers\Media;

use \Origin\Utilities\Layout;
use \Jukebox\Integration\Discogs;
use \Jukebox\Models\Artist;

class Artist_CTRL {
  
	public function Main($id){
		$artist = new Artist($id);
		Layout::Get()->Assign('artist', $artist);
		Layout::Get()->Display('artist.tpl');
	}
	
  
}