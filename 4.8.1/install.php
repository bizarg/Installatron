<?php

class i_newword_4_8_1_install extends i_action_install
{
    public function step2_init()
    {
        $this->setStepLabel('_step_progress_extracting');
    }

    public function step2_process()
    {
        $this->extract('main');
        $this->extract('zeebizzcard', "wordpress/wp-content/themes");
        $this->extract("wp_supercache", "wordpress/wp-content/plugins");
    }

    public function step3_init()
    {
        $this->setStepLabel('_step_progress_processing');
    }

    public function step3_process()
    {
        $this->mv('wordpress/*');

        $this->rm("wordpress");
		
		//$this->cp("wp-config-sample.php", "wp-config.php");
        //
        //$this->sr("wp-config.php", array(
        //    "#'localhost'#" => var_export($this->db_host, true),
        //    "#'database_name_here'#" => var_export($this->db_name, true),
        //    "#'username_here'#" => var_export($this->db_user, true),
        //    "#'password_here'#" => var_export($this->db_pass, true),
        //
        //));
		
		$info =  "systime => " . $this->systime."\r\n";
		$info .= "url_path => " . $this->url_path."\r\n";
		$info .= "url_domain => " . $this->url_domain."\r\n";
		$info .= "url => " . $this->url."\r\n";
		$info .= "path => " . $this->path."\r\n";
		$info .= "db_pass => " . $this->db_pass."\r\n";
		$info .= "db_name => " . $this->db_name."\r\n";
		$info .= "db_prefix => " . $this->db_prefix."\r\n";
		$info .= "db_user => " . $this->db_user."\r\n";
		$info .= "db_host => " . $this->db_host."\r\n";
		$info .= "wp-admin/install => " . $this->url_path. "wp-admin/install.php"."\r\n";
		
		if(isset($this->input['field_vf_4x8x1_login'])) $info .= "admin_name => " . $this->input['field_vf_4x8x1_login'] ."\r\n";
		if(isset($this->input['field_vf_4x8x1_passwd'])) $info .= "admin_pass => " . $this->input['field_vf_4x8x1_passwd'] ."\r\n";
		if(isset($this->input['field_vf_4x8x1_language'])) $info .= "language => " . $this->input['field_vf_4x8x1_language'] ."\r\n";
		
		if(isset($this->input['field_db_prefix'])) $info .= "field_db_prefix => " . $this->input['field_db_prefix'] ."\r\n";
		if(isset($this->input['field_db_user'])) $info .= "field_db_user => " . $this->input['field_db_user'] ."\r\n";
		if(isset($this->input['field_db_pass'])) $info .= "field_db_pass => " . $this->input['field_db_pass'] ."\r\n";
		if(isset($this->input['field_db_name'])) $info .= "field_db_name => " . $this->input['field_db_name'] ."\r\n";
		
		$this->write("info.txt", $info);

        
		$this->fetch("wp-admin/setup-config.php?step=2", array(
			"dbname" => $this->db_name,
			"uname" => $this->db_user,
			"pwd" => $this->db_pass,
			"dbhost" => $this->db_host,
			"prefix" => $this->db_prefix,
		));
		
		//$this->fetch("wp-admin/install.php?step=2",array( 
		//	"language" => $this->input['field_vf_4x8x1_language'],
		//	"weblog_title" => 'Zeebizzcard',
		//	"user_name" => $this->input['field_vf_4x8x1_login'],
		//	"admin_password" => $this->input['field_vf_4x8x1_passwd'],
		//	"admin_password2" => $this->input['field_vf_4x8x1_passwd'],
		//	"admin_email" => $this->input['field_vf_4x8x1_email'],
		//));
		
		$this->fetch("wp-admin/install.php?step=2",array( 
			//"language" => $this->input['field_vf_4x8x1_language'],
			"weblog_title" => 'Zeebizzcard',
			"user_name" => $this->input['field_login'],
			"admin_password" => $this->input['field_passwd'],
			"admin_password2" => $this->input['field_passwd'],
			"admin_email" => $this->input['field_email'],
		));

        $this->db_query("UPDATE {$this->db_prefix}options SET option_value = 'zeebizzcard' WHERE option_name = 'template' LIMIT 1");
        $this->db_query("UPDATE {$this->db_prefix}options SET option_value = 'zeebizzcard' WHERE option_name = 'stylesheet' LIMIT 1");
        $this->db_query("UPDATE {$this->db_prefix}options SET option_value = 'zeebizzcard' WHERE option_name = 'current_theme' LIMIT 1");
        

    }
}