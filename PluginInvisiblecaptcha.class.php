<?php
/* 
 * Plugin InvisibleCaptcha
 * Author: Stanislav Nevolin, stanislav@nevolin.info
 */

if (!class_exists('Plugin')) {
	die('Hacking attemp!');
}

class PluginInvisiblecaptcha extends Plugin {
	public function Activate() {
		$this->Lang_AddMessages(include(dirname(__FILE__) . '/templates/language/' . $this->Lang_GetLang() . '.php'));
		Config::Set('plugin.' . dirname(__FILE__), include(dirname(__FILE__) . '/config/config.php'));
		$bOk = true;
		/*$sitekey = Config::Get('plugin.invisiblecaptcha.sitekey');
		$secretkey = Config::Get('plugin.invisiblecaptcha.secretkey');
		if (empty($sitekey)) {
			$this->Message_AddNotice('You should fill out sitekey field in plugin configuration before activation');
			$bOk = false;
		}
		if (empty($secretkey)) {
			//$this->Message_AddError($this->Lang_Get('plugin.invisiblecaptcha.must_set_secretkey'));
			$bOk = false;
		}*/
		return $bOk;
	}
	
	public function Deactivate() {
		return true;
	}
	
	public function Init() {
		$aPaths=glob(Plugin::GetPath(__CLASS__).'templates/skin/*',GLOB_ONLYDIR);
		if (!($aPaths and in_array(Config::Get('view.skin'),array_map('basename',$aPaths))) && !$this->User_GetUserCurrent()) {
			Config::Set('head.rules.invisiblecaptcha', array(
				'path'	=> '___path.root.web___',
				'js'		=> array(
					'include' => array(
						Plugin::GetTemplateWebPath(__CLASS__)."js/captcha.js",
						'https://www.google.com/recaptcha/api.js',
					),
				),
			));
		}
		
	}
}
