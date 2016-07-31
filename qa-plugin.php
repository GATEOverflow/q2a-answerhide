<?php



	if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
			header('Location: ../../');
			exit;
	}
	
	qa_register_plugin_layer('qa-answerhide-layer.php', 'Answer Hide Layer');	
	


	qa_register_plugin_module('module', 'qa-answerhide-admin.php', 'qa_answerhide_admin', 'Answer Hide Admin');

/*
	Omit PHP closing tag to help avoid accidental output
*/
