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
            ORDER BY added_at DESC
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
        $notification->import($data, 'content,ref,account_id,email_frequency,status');
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

    /**
     * Find any notifications that are due for an email
     *
     * @return RedBean_OODBBean[]
     */
    public function find_notifications_due_for_email()
    {
        $notifications = array();
        $intervals = array(
            'daily' => 24 * 60 * 60,
            'weekly' => 7 * 24 * 60 * 60,
            'annually' => 365 * 24 * 60 * 60
        );
        $current_timestamp = time();
        // for simplicity, we'll get all notifications that match loose conditions,
        // then loop through them to check that they actually are due for an email
        $all_notifications = R::find('message', 'email_frequency IS NOT NULL');
        if (!empty($all_notifications)) {
            foreach ($all_notifications as $notification) {
                $last_sent = ($notification->email_sent_at) ? $notification->email_sent_at : $notification->added_at;
                $last_sent = strtotime($last_sent);
                $interval = $intervals[$notification->email_frequency];
                $next_email_time = $last_sent + $interval;
                if ($next_email_time <= $current_timestamp || $notification->email_sent_at == null) {
                    $notifications[] = $notification;
                }
            }
        }
        return $notifications;
    }

    /**
     * Send the actual notification email
     *
     * @param RedBean_OODBBean $notification
     */
    public function send_notification_email(RedBean_OODBBean $notification)
    {
        // Email the user
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;

        $this->email->initialize($config);

        $name  = $notification->account->user->name;
        $email = $notification->account->user->email;
        $email = 'andycoatz@gmail.com';
        $logo  = base_url().'images/logo-mpdf.png';
        $today = date("j F Y");


        $message = "<img src='$logo' /><br /><br />
						Hello $name,<br /><br/>
						You have a new notification in your Clock In Point account with the following message:<br /><br /><hr>
						<strong>" . htmlentities($notification->content) . "</strong><hr>
						<br>Please click <a href='http://www.clockinpoint.com/admin/clients'>here</a> to login to your account.<br /><br />
						<em>Generated by Clock In Point - $today</em>
						<br />
						<a href='http://www.clockinpoint.com'>www.clockinpoint.com</a>
						";

        $this->email->from('info@clockinpoint.com');
        $this->email->to($email);
        $this->email->subject('Clock In Point - You have new notifications');

        $this->email->message($message);

        $this->email->send();
        $this->email->clear();
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
		$sql = "DELETE FROM `message` WHERE `status` = '0' AND `added_at` < ($time - INTERVAL 2 MINUTE) AND `id` = $id";
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
