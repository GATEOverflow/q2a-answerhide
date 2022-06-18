<?php

class qa_html_theme_layer extends qa_html_theme_base {

	public function q_view_buttons($q_view)
	{
		if($this -> template == 'question' and qa_is_logged_in())
		{

			$q_view['form']['buttons']['answer_hide'] = array("tags" => 'id="answer_hide" name="answer_hide"', "label" => "Hide Answers", "popup" => "Hide or Show the Answers");

			$this->output('
<script type="text/javascript">

function answertoggle() {
	$(\'#a_list\').toggle();
	var AH = document.getElementById("answer_hide");
	//alert(AH.innerHTML);
	if(AH.value=="Show Answers" || AH.innerHTML=="Show Answers"){
		AH.value="Hide Answers";
		AH.innerHTML="Hide Answers";
	}
	else{
		AH.value="Show Answers";
		AH.innerHTML="Show Answers";
	}
}


$(document).ready(function()
{	
	var Answers_Count = document.querySelector("[itemprop=answerCount]").textContent;		
	$("#answer_hide").attr("type", "button"); 
	$("#answer_hide").click( function Click(){answertoggle();}	);
	
	if(Answers_Count==0)
		document.getElementById("answer_hide").remove();
});

</script>');	

		require_once QA_INCLUDE_DIR . 'db/metas.php';
		$userid = qa_get_logged_in_userid();
		if(qa_db_usermeta_get($userid, 'answerhide')=="1")
		{
			$this->output('
<script type="text/javascript">
$(document).ready(function()
{
answertoggle();
});
</script>');	
		
		}
		
		}
		qa_html_theme_base::q_view_buttons($q_view);

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
