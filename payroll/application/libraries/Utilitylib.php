<?php
 class Utilitylib {
 
    protected $CI;
    
    public function __construct($rules = array())
    {
        $this->CI =& get_instance();
    }
    
    
    
    function showMsg()
     {
         if($this->CI->session->userdata('msg'))
         {
         echo '<div style="clear:both;"></div><div class="'.$this->CI->session->userdata('class').'">'.$this->CI->session->userdata('msg').'</div><div style="height:10px;">&nbsp;</div>';
         $this->CI->session->unset_userdata('msg');
             $this->CI->session->unset_userdata('class');
         }
         
     }
     
    function sendMail($to,$subject,$mail_contnt)
	{
	  	
		$this->CI->load->library('email');
		
		//echo $send_body;exit;
		$cont="

		         $mail_contnt<br> 
		         Regards <br>
		         Faiz Facilities Management System <br> 
		         Support Team.";
		//echo $cont;exit;
		
    		$this->CI->email->set_mailtype("html");
    		$this->CI->email->from('complain@faizfms.net.in');
    		$this->CI->email->cc('info@faizfms.in,shadab@faizfms.in,adminsupport@faizfms.in,adminassistant@faizfms.in,complain@faizfms.in,shaukat@faizfms.in,moin@faizfms.in');

		    $this->CI->email->to($to); 
	    	$this->CI->email->subject($subject);					
    		$this->CI->email->message($cont);
    		$this->CI->email->send();
		/*************SMTP MAIL**************/
	}
	
	  
    function sendMail1($to,$subject,$mail_contnt)
	{
	  	
		$this->CI->load->library('email');
		
		//echo $send_body;exit;
		$cont="

		         $mail_contnt<br> 
		         Regards <br>
		         Faiz Facilities Management System <br> 
		         Support Team.";
		//echo $cont;exit;
		
    		$this->CI->email->set_mailtype("html");
    		$this->CI->email->from('info@faizfms.in');
    		$this->CI->email->cc('');

		    $this->CI->email->to($to); 
	    	$this->CI->email->subject($subject);					
    		$this->CI->email->message($cont);
    		$this->CI->email->send();
		/*************SMTP MAIL**************/
	}
	
	
	
	
	
	
     //pagination used in admin
     function pagination($target,$total_rows,$per_page,$uri=3,$search=null)
     {
        $this->CI->load->library('pagination');
        $config['base_url'] = $target;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page; 
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
        $config['uri_segment'] = $uri;
        $this->CI->pagination->initialize($config); 
        return $this->CI->pagination->create_links($search);
     }
	 function pagination1($target,$total_rows,$per_page,$uri=4,$search=null)
     {
        $this->CI->load->library('pagination');
        $config['base_url'] = $target;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page; 
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
        $config['uri_segment'] = $uri;
        $this->CI->pagination->initialize($config); 
        return $this->CI->pagination->create_links($search);
     }
   function delTree($dir)
    {
        $files = array_diff(scandir($dir), array('.','..')); 

        foreach ($files as $file) { 
            (is_dir("$dir/$file")) ? $this->delTree("$dir/$file") : unlink("$dir/$file"); 
        }

        return rmdir($dir); 
    }

function facebookLogout(){
    $config =array(
        'appId'  => '768432563199112',
        'secret' => '1a7ebdccc5923f014ffaa79e00e2b757',
        );
    $this->CI->load->library('Facebook',$config);
    $this->CI->facebook->destroySession();
    }

public function time_elapsed_string($ptime)
	{
		$etime = time() - $ptime;
		if ($etime < 1)
		{
			return '0 seconds';
		}
		$a = array( 365 * 24 * 60 * 60  =>  'year',
					 30 * 24 * 60 * 60  =>  'month',
						  24 * 60 * 60  =>  'day',
							   60 * 60  =>  'hour',
									60  =>  'minute',
									 1  =>  'second'
					);
		$a_plural = array( 'year'   => 'years',
						   'month'  => 'months',
						   'day'    => 'days',
						   'hour'   => 'hours',
						   'minute' => 'minutes',
						   'second' => 'seconds'
					);

		foreach ($a as $secs => $str)
		{
			$d = $etime / $secs;
			if ($d >= 1)
			{
				$r = round($d);
				return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
			}
		}
	}
	
	
	
function sendsmsGET($mobileNumber,$senderId,$routeId,$message,$serverUrl,$authKey)
{
	$senderId1='eHSPTO';$routeId1=1;
    $getData = 'mobileNos='.$mobileNumber.'&message='.urlencode($message).'&senderId='.$senderId1.'&routeId='.$routeId1;

    //API URL
	$serverUrl1='msg.msgclub.net';
	$authKey1='a1625bbce66e437a1d6bb6bf15fd8dd';
    $url="http://".$serverUrl1."/rest/services/sendSMS/sendGroupSms?AUTH_KEY=".$authKey1."&".$getData;
    // init the resource
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0

    ));


    //get response
    $output = curl_exec($ch);

    //Print error if any
    if(curl_errno($ch))
    {
        echo 'error:' . curl_error($ch);
    }

    curl_close($ch);

    return $output;
}	
	
	
 function send_sms($body='',$number='')
     {
		//echo "HHH"."<br>"; //exit;//https://bulksms.vsms.net/eapi/submission/send_sms/2/2.0
		//echo $number.$body; 
     		// ob_start();
	//https://bulksms.vsms.net/eapi/submission/send_sms/2/2.0   -user->infosol37; pass-123456789 
	//https://www.bulksms.co.uk/eapi/submission/send_sms/2/2.0 username=sajankhowaja&password=Abcd1234
	
	$url='username=sajankhowaja&password=Abcd1234&message='.$body.'&msisdn='.$number;
	//echo $url; exit;
	$curl = curl_init('https://www.bulksms.co.uk/eapi/submission/send_sms/2/2.0');
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$auth = curl_exec($curl);
	
	curl_close($curl);
	//echo "HHH"; exit;
    return $auth;   
	 
     }	
	
	
	
	


 }