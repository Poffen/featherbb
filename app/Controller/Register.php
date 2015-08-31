<?php

/**
 * Copyright (C) 2015 FeatherBB
 * based on code by (C) 2008-2012 FluxBB
 * and Rickard Andersson (C) 2002-2008 PunBB
 * License: http://www.gnu.org/licenses/gpl.html GPL version 2 or higher
 */

namespace App\Controller;

class Register
{
    public function __construct()
    {
        $this->feather = \Slim\Slim::getInstance();
        $this->start = $this->feather->start;
        $this->config = $this->feather->config;
        $this->user = $this->feather->user;
        $this->request = $this->feather->request;
        $this->model = new \App\Model\Register();
        load_textdomain('featherbb', FEATHER_ROOT.'app/lang/'.$this->user->language.'/register.mo');
        load_textdomain('featherbb', FEATHER_ROOT.'app/lang/'.$this->user->language.'/prof_reg.mo');
        load_textdomain('featherbb', FEATHER_ROOT.'app/lang/'.$this->user->language.'/antispam.mo');
    }

    public function __autoload($class_name)
    {
        require FEATHER_ROOT . $class_name . '.php';
    }

    public function display()
    {
        if (!$this->user->is_guest) {
            header('Location: '.$this->feather->url->base());
            exit;
        }

        // Antispam feature
        require FEATHER_ROOT.'app/lang/'.$this->user->language.'/antispam.php';
        $index_questions = rand(0, count($lang_antispam_questions)-1);

        // Display an error message if new registrations are disabled
        // If $_REQUEST['username'] or $_REQUEST['password'] are filled, we are facing a bot
        if ($this->config['o_regs_allow'] == '0' || $this->request->post('username') || $this->request->post('password')) {
            throw new \FeatherBB\Error(__('No new regs'), 403);
        }

        $user['timezone'] = isset($user['timezone']) ? $user['timezone'] : $this->config['o_default_timezone'];
        $user['dst'] = isset($user['dst']) ? $user['dst'] : $this->config['o_default_dst'];
        $user['email_setting'] = isset($user['email_setting']) ? $user['email_setting'] : $this->config['o_default_email_setting'];
        $user['errors'] = '';

        if ($this->feather->request()->isPost()) {
            $user = $this->model->check_for_errors();

            // Did everything go according to plan? Insert the user
            if (empty($user['errors'])) {
                $this->model->insert_user($user);
            }
        }

            $this->feather->view2->setPageInfo(array(
                        'title' => array($this->feather->utils->escape($this->config['o_board_title']), __('Register')),
                        'focus_element' => array('register', 'req_user'),
                        'required_fields' => array('req_user' => __('Username'), 'req_password1' => __('Password'), 'req_password2' => __('Confirm pass'), 'req_email1' => __('Email'), 'req_email2' => __('Email').' 2', 'captcha' => __('Robot title')),
                        'active_page' => 'register',
                        'is_indexed' => true,
                        'errors' => $user['errors'],
                        'index_questions'    =>    $index_questions,
                        'languages' => \FeatherBB\Lister::getLangs(),
                        'question' => array_keys($lang_antispam_questions),
                        'qencoded' => md5(array_keys($lang_antispam_questions)[$index_questions]),
                            )
                    )->addTemplate('register/form.php')->display();
    }

    public function cancel()
    {
        redirect($this->feather->url->base());
    }

    public function rules()
    {
        // TODO: fix $_GET w/ URL rewriting

        // If we are logged in, we shouldn't be here
        if (!$this->user->is_guest) {
            header('Location: '.$this->feather->url->base());
            exit;
        }

        // Display an error message if new registrations are disabled
        if ($this->config['o_regs_allow'] == '0') {
            throw new \FeatherBB\Error(__('No new regs'), 403);
        }

        if ($this->config['o_rules'] != '1') {
            redirect($this->feather->url->get('register/agree/'));
        }

        $this->feather->view2->setPageInfo(array(
                            'title' => array($this->feather->utils->escape($this->config['o_board_title']), __('Register'), __('Forum rules')),
                            'active_page' => 'register',
                            )
                    )->addTemplate('register/rules.php')->display();
    }
}