<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notify_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

    /**
     * Return a list of messages for a particular account
     *
     * @param int $account_id
     * @return array
     */
    public function get_messages($account_id)
	{
        $messages = R::find('message', '
            account_id = ? AND `status` = 1
            ORDER BY created DESC
            ',
            array($account_id)
        );

    	return $messages;
	}

    /**
     * Creates a new notification
     *
     * @param array $data
     */
    public function create(array $data)
    {
        // if a notification with this ref already exists, remove it first
        $this->remove_by_ref($data['ref'], $data['account_id']);
        $notification = R::dispense('message');
        $notification->import($data, 'content,ref,account_id,status');
        R::store($notification);
    }

    public function remove_by_ref($ref, $account_id)
    {
        $notification = $this->find($ref, $account_id);
        if ($notification) {
            R::trash($notification);
        }
    }

    public function find($ref, $account_id)
    {
        $result = R::findOne('message', 'account_id = ? AND ref = ?', array($account_id, $ref));
        return $result;
    }

	function read_message($id)
	{
		$data = array(
               'status' => '0',
               'txt' => 'read'

        );
		$this->db->where('id', $id);
		$this->db->update('messages', $data); 
	}

	function remove_after($id)
	{
		$this->load->helper('date');
		$time = date("Y-m-d H:i:s");
		$sql = "DELETE FROM `messages` WHERE `status` = '0' AND `created` < ($time - INTERVAL 2 MINUTE) AND `id` = $id";
		$this->db->query($sql);
	}

	function device_count()
    {
    	$this->db->where('account_id', $this->session->userdata('account_number'));
    	return $this->db->count_all_results('device');
        //echo $this->db->count_all_results('device');
        //return $this;
    }
	

}

/* End of file  */
