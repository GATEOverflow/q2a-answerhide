<?php

class qa_html_theme_layer extends qa_html_theme_base {
	function head_css(){
		if($this->template == 'question') {
			$this->output('<style type="text/css">'. qa_opt('answerhide-plugin-css') .'</style>');
			$this->output('<script type="text/javascript">
					$( "#viewbutton" ).click(function() {
						$( "#a_list" ).toggle();
						});</script>');
		}
		qa_html_theme_base::head_css();
	}
	function doctype()
	{
		if($this->template == 'account') {
			// add answerhide form
			$answerhide_form = $this->answerhide_form();
			if($answerhide_form) {

				$this->content['form_2'] = $answerhide_form;
			}

		}
		qa_html_theme_base::doctype();
	}
	function a_list($a_list){
		if (!empty($a_list)) {
			$userid=qa_get_logged_in_userid();
			if (isset($userid)){
				require_once QA_INCLUDE_DIR . 'db/metas.php';
				if(qa_db_usermeta_get($userid, 'answerhide') == "1") {	
					$this->output('<div class="answerhide row"><button id="viewbutton" class="answerhide-button">View/Hide Answers</button></div>');
					qa_html_theme_base::a_list($a_list);
					$this->output('<script>$(function(){$(\'#a_list\').hide();}) </script>');
				}
				else {
					qa_html_theme_base::a_list($a_list);
				}
			}

		}

	}


	function answerhide_form() {
		if($handle = qa_get_logged_in_handle()) {
			require_once QA_INCLUDE_DIR . 'db/metas.php';
			$userid = qa_get_logged_in_userid();
			if (qa_clicked('answerhide_save')) {
				if(qa_post_text('answerhide')){
					qa_db_usermeta_set($userid, 'answerhide', qa_post_text('answerhide')) ;
				}
				else {
					qa_db_usermeta_set($userid, 'answerhide', "0") ;
				}

				qa_redirect($this->request,array('ok'=>qa_lang_html('admin/options_saved')));
			}

			$ok = qa_get('ok')?qa_get('ok'):null;

			$fields = array();
			$fields['answerhide'] = array(
					'label' => qa_opt('answerhide-plugin-text'),
					'tags' => 'NAME="answerhide"',
					'type' => 'checkbox',
					'value' =>  qa_db_usermeta_get($userid, 'answerhide'),
					);
			$form=array(

					'ok' => ($ok && !isset($error)) ? $ok : null,

					'style' => 'tall',

					'title' => '<a name="answerhide_text"></a>'.qa_opt('answerhide-plugin-title'),

					'tags' =>  'action="'.qa_self_html().'#answerhide_text" method="POST"',

					'fields' => $fields,

					'buttons' => array(
						array(
							'label' => qa_lang_html('main/save_button'),
							'tags' => 'NAME="answerhide_save"',
						     ),
						),
				   );
			return $form;

		}
	}

}
?>
