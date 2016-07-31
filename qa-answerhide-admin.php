<?php
class qa_answerhide_admin {

	function allow_template($template)
	{
		return ($template!='admin');
	}

	function option_default($option) {

		switch($option) {
			case 'answerhide-plugin-text':
				return 'Hide Answers by Default';
			case 'answerhide-plugin-title':
				return 'Hide Answer';
			case 'answerhide-plugin-css':
				return '.answerhide { text-align:center;}';
			default:
				return null;

		}
	}
	function admin_form(&$qa_content)
	{

		//	Process form input

		$ok = null;
		if (qa_clicked('answerhide_save_button')) {
			foreach($_POST as $i => $v) {

				qa_opt($i,$v);
			}

			$ok = qa_lang('admin/options_saved');
		}
		else if (qa_clicked('answerhide_reset_button')) {
			foreach($_POST as $i => $v) {
				$def = $this->option_default($i);
				if($def !== null) qa_opt($i,$def);
			}
			$ok = qa_lang('admin/options_reset');
		}			
		//	Create the form for display


		$fields = array();
		$fields[] = array(
				'label' => 'Answer Hide Title',
				'tags' => 'NAME="answerhide-plugin-title"',
				'value' => qa_opt('answerhide-plugin-title'),
				'type' => 'text',
				);
		$fields[] = array(
				'label' => 'Answer Hide Text',
				'tags' => 'NAME="answerhide-plugin-text"',
				'value' => qa_opt('answerhide-plugin-text'),
				'type' => 'text',
				);


		$fields[] = array(
				'label' => 'Answer Hide custom css',
				'tags' => 'NAME="answerhide-plugin-css"',
				'value' => qa_opt('answerhide-plugin-css'),
				'type' => 'textarea',
				'rows' => 20
				);


		return array(
				'ok' => ($ok && !isset($error)) ? $ok : null,

				'fields' => $fields,

				'buttons' => array(
					array(
						'label' => qa_lang_html('main/save_button'),
						'tags' => 'NAME="answerhide_save_button"',
					     ),
					array(
						'label' => qa_lang_html('admin/reset_options_button'),
						'tags' => 'NAME="answerhide_reset_button"',
					     ),
					),
			    );
	}


}
