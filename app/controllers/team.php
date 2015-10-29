<?php
namespace Controllers;
use \Curl\Curl;

class Team {
	public function getMembers()
	{
		if (!\Cache::instance()->exists('members')) {
			try {
				$curl = new Curl;
				$members = $curl->get('https://api.github.com/orgs/inexor-game/members');
				
				if ($curl->error) throw(new \Exception($curl->errorMessage));
			} catch (\Exception $e) {
				// TODO: Add error handling
			}

			\Cache::instance()->set('members', $members, 3600); //TTL = 1h
		} else {
			$members = \Cache::instance()->get('members');
		}
		
		return $members;
	}
	
	public function getAliases() {
		if (!\Cache::instance()->exists('aliases')) {
			$aliases = \Helpers\Team::instance()->config;
			\Cache::instance()->set('aliases', $aliases, 3600); //TTL = 1h		
		} else {
			$aliases = \Cache::instance()->get('aliases');
		}
		
		return $aliases;
	}
}