<script>
//Validation  
 $( document ).ready(function() {  
$('#save_button').click(function() {
var value = $('#template_name').val();
var errors = false;
if( value.length < 2 || value.length > 35  )
    {
        alert('Please select a name between 2 and 35 characters for this template');
        var errors = true;
    }
else
	{
		$( "#template_form" ).submit();
	}    
});

});
//
</script>

<div class="container-c">
    <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 buffer-bottom-md">
            <div class="row">
              <div class="col-md-12 section-header">
                <h1>Error</h1>
				<div class="row">
				  <div class="col-md-12 text-center">
				    <p><?php echo $error_message;?></p>
				    <p>Please select a name for this new template and click save:</p>
				    <?php
                		$attributes = array('name' => 'template_form', 'id' => 'template_form', 'enctype' => 'multipart/form-data');
                		echo form_open('createtemplateupdategroup/edit/'.$group_id, $attributes);
		            ?>
		            <input class="form-control" type="text" name="templateName" id ="template_name" placeholder="New Template Name"><br /><br />
					<span class="btn btn-primary btn-block btn-lg" id = "save_button">
					‌	Save and Continue...<i class="fa fa-arrow-circle-right"></i>
					‌</span>
              </form>
				    <hr>
				  </div>
				</div>
			</div>	
        </div> 
    </div>
</div>
</div></div>

