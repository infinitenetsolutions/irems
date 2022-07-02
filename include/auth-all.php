<script>
	$(function(){
		setTimeout(function(){
			$("#aside-loader").remove();
			$("[data-page=page_no_0").removeClass("display-none");
			<?php
				if(isset($auth)):
					if($auth->admin_auth != "all"):
						foreach($auth->admin_auth as $menus_key => $menus_val):
						?>
							$("[data-page=<?= $menus_key ?>]").removeClass("display-none");
						<?php
							foreach($menus_val as $submenus_key => $submenus_val):
							?>
								$("[data-page=<?= $submenus_key ?>]").removeClass("display-none");
							<?php
							endforeach;
						endforeach;
					else:
						?>
						$(".data-page-class").removeClass("display-none");
						<?php
					endif;
				endif;
			?>
			apply_auth();
		}, 500);
	});
	function apply_auth(){
		<?php
		if(isset($auth)):
		    if($auth->page_check == true):
		    	// print_r($auth->page_no_inside);
		    	if($auth->page_no_inside->add == "no"):
		    	?>
		    		$(".add-button").remove();
		    		$("#add-button").remove();
		    		$("#add-modal").remove();
		    	<?php
		    	endif;
		    	if($auth->page_no_inside->see == "no"):
		    	?>
		    		$(".see-button").remove();
		    		$("#see-button").remove();
		    		$("#see-modal").remove();
		    	<?php
		    	endif;
		    	if($auth->page_no_inside->update == "no"):
		    	?>
		    		$(".edit-button").remove();
		    		$("#edit-button").remove();
		    		$("#edit-modal").remove();
		    	<?php
		    	endif;
		    	if($auth->page_no_inside->delete == "no"):
		    	?>
		    		$(".delete-button").remove();
		    		$("#delete-button").remove();
		    		$("#delete-modal").remove();
		    	<?php
		    	endif;
		    	if($auth->page_no_inside->import == "no"):
		    	?>
		    		$(".import-button").remove();
		    		$("#import-button").remove();
		    		$("#import-modal").remove();
		    	<?php
		    	endif;
		    	if($auth->page_no_inside->export == "no"):
		    	?>
		    		$(".export-button").remove();
		    		$("#export-button").remove();
		    		$("#export-modal").remove();
		    	<?php
		    	endif;
		    	if($auth->page_no_inside->information == "no"):
		    	?>
		    		$(".information-button").remove();
		    		$("#information-button").remove();
		    		$("#information-modal").remove();
		    	<?php
		    	endif;
			endif;
		endif;
		?>
	}
	$(document).ajaxComplete(function(){
	  	apply_auth();
	});
</script>