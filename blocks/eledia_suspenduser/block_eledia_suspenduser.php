<?php
class block_eledia_suspenduser extends block_base {

    function init() {
        $this->title   = get_string('title', 'block_eledia_suspenduser');
        $this->version = 2012051601;//Format yyyymmddvv
        $this->cron = 1; 
    }

    function applicable_formats() {
        return array('site'=>true);
    }
    
    function get_content() {
        global $USER, $CFG, $COURSE;
        if ($this->content !== NULL) {
            return $this->content;
        }
	
        $this->content =  new object();
        $this->content->text = '';
        $this->content->footer = '';
    
        if(has_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM))) {

            $this->content->text .= '<ul>';
            $this->content->text .= '<li>';
            $this->content->text .= '<a href="'.$CFG->wwwroot.'/blocks/eledia_suspenduser/config_suspenduser.php" >';
            $this->content->text .= get_string('el_header', 'block_eledia_suspenduser');
            $this->content->text .= '</a>';
            $this->content->text .= '</li>';
            $this->content->text .= '</ul>';
        }
        return $this->content;
    }
    
    function has_config() {
        return true;
    }

    function cron() {

        global $CFG;
        error_reporting(E_ALL);

        require_once("$CFG->dirroot/local/eledialib/lib.php");
        $eledia = new eledia_lib();
        
        //get filepath & name
        if(!isset($CFG->eledia_suspenduserpath)){
            set_config('eledia_suspenduserpath', '/temp/');
        }
        $path = $CFG->eledia_suspenduserpath;

        if(!isset($CFG->eledia_suspenduserfile)){
            set_config('eledia_suspenduserfile', 'suspend_users.csv');
        }
        $name = $CFG->eledia_suspenduserfile;

        //read file
        $user_mails = $eledia->get_csv_content_as_array($CFG->dataroot.$path.$name, ';');

        //get user and suspend user
        if($user_mails){
           $this->suspend_user_in_list($user_mails);
        }
    }

    function suspend_user_in_list(array $users_mails){
        global $CFG, $DB;
        foreach ($users_mails as $user_mail) {
            //get user
            if(!$u = $DB->get_record('user', array('email' => $user_mail[0], 'deleted' => 0, 'mnethostid' => $CFG->mnet_localhost_id))) {
                continue;
            }
            //suspend user
            $DB->set_field('user', 'suspended', '1', array('id' => $u->id));
        }
    }
}
