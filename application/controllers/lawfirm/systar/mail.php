<?php
class Mail extends SS_Controller{
	function __construct() {
		$this->default_method='sendexpress';
		parent::__construct();
		$this->load->model('mail_model','mail');
	}
	
	function sendExpress(){
		$this->load->model('client_model','client');
		$client_emails=$this->client->getAllEmails();

		//$this->session->set_userdata('mail/express/receivers',$client_emails);
		$this->user->setConfig('mail/express/send_progress',0);
		
		//$this->load->addViewData('client_emails', $client_emails);

		$this->load->view('mail/send_express');
	}
	
	function submit($submit){
		try{
		
			if($submit=='generate_express'){
				$article_ids=preg_split('/,[\s]*/',$this->input->post('articles'));
				
				if(!is_array($article_ids)){
					$this->output->message('文章id解析错误');
					throw new Exception;
				}
				
				$config['upload_path'] = './images/mail/express';
				$config['encrypt_name'] = true;
				$config['allowed_types'] = 'jpg';

				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('header')){
					$this->output->message($this->upload->display_errors(),'warning');
					throw new Exception;
				}
				
				$header=$this->upload->data();
				
				$config['allowed_types'] = 'pdf';
				$config['encrypt_name'] = false;
				
				$Attachment=new CI_Upload($config);

				if (!$Attachment->do_upload('attachment')){
					$this->output->message($Attachment->display_errors(),'warning');
					//throw new Exception;
				}
				
				//$attachment=$Attachment->data();
				
				$articles=$this->mail->getArticles('star',$article_ids);
				
				$this->load->addViewData('title', $this->input->post('title'));
				$this->load->addViewData('articles', $articles);
				$this->load->addViewData('header_img', $header['file_name']);
				
				$mail_html=$this->load->view('mail/express_template',true);

				$this->user->setConfig('mail/express/mail_html',$mail_html);
				$this->user->setConfig('mail/express/title','星瀚律师 - '.$this->input->post('title'));
				//$this->session->set_userdata('mail/express/attachment','./images/mail/express/'.$attachment['file_name']);
				
				$this->output->setData($mail_html, 'preview', 'html','#express-preview');
			}
			
			if($submit=='send_express'){
				if(!$this->config->user_item('mail/express/mail_html')){
					$this->output->message('还没有生成期刊');
					throw new Exception;
				}
				
				if(!$this->input->post('client-emails')){
					$client_emails=$this->config->user_item('mail/express/receivers');
				}else{
					$client_emails=preg_split('/,[\s]*/', $this->input->post('client-emails'));
					$this->user->setConfig('mail/express/receivers',json_encode($client_emails));
				}
								
				$this->load->library('email');
				$config=array(
					'protocol'=>'smtp',
					'smtp_host'=>'smtp.exmail.qq.com',
					'smtp_user'=>'lawyer@lawyerstars.com',
					'smtp_pass'=>'1218xinghan',
					'mailtype'=>'html',
					'crlf'=>"\r\n",
					'newline'=>"\r\n"
				);

				$this->email->initialize($config);

				$this->email->from('lawyer@lawyerstars.com', '星瀚律师');

				$this->email->subject($this->config->user_item('mail/express/title'));
				$this->email->message($this->config->user_item('mail/express/mail_html')); 
				//$this->email->attach($this->session->userdata('mail/express/attachment'));

				if($this->config->user_item('mail/express/send_progress')<count($this->config->user_item('mail/express/receivers'))){
					$receivers=$this->config->user_item('mail/express/receivers');
					$receiver=$receivers[$this->config->user_item('mail/express/send_progress')];
					if($this->email->to($receiver)){
						$delivery_status='';
					}else{
						$delivery_status='(x)';
					}
					$this->output->setData($receiver.' ','receiver','html','#delivery-status','append');

					$this->email->send();
					sleep(3);

					$this->user->setConfig('mail/express/send_progress',$this->config->user_item('mail/express/send_progress')+1);
					$this->output->setData('$(\'[name="submit[send_express]"]:first\').trigger(\'click\')','script','script');
				}else{
					$this->output->message('发送完毕');
				}
			}
			
			if($submit=='download'){
				$this->output->as_ajax=false;
				$this->load->model('document_model','document');
				$this->document->exportHead('express.html');
				$this->output->set_output($this->config->user_item('mail/express/mail_html'));
			}
			
			$this->output->status='success';
			
		}catch(Exception $e){
			$this->output->status='fail';
		}
	}
}
?>
