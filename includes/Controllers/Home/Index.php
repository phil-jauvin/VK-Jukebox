<?php
namespace Controllers\Home;

use \Origin\Utilities\Layout;
use \Jukebox\Integration\Vkontakte;

class Index {
	public function Main(){
		Layout::Get()->Display('index.tpl');
	}
}