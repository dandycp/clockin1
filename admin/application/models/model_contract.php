<?php 

class Model_Contract extends MY_Bean
{
	public function update()
	{
		$this->bean->updated_at = NULL;	
	}
	public function get_client()
	{
		$client = false;
		$party = $this->get_client_party();		
		if ($party) $client = $party->account;
		return $client;
	}
	
	public function get_provider()
	{
		$provider = false;
		$party = $this->get_provider_party();
		if ($party) $provider = $party->account;
		return $provider;
	}
	
	public function get_client_party()
	{
		$party = reset($this->bean->withCondition("role='client'")->ownParty);
		return $party;
	}
	
	public function get_provider_party()
	{
		$party = reset($this->bean->withCondition("role='provider'")->ownParty);
		return $party;
	}
}
