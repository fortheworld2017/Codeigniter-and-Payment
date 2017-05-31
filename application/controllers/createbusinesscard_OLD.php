<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Createbusinesscard extends CI_Controller {
	  
	public function index()
		{
			$this->load->library('header');
			$this->header->index();
			if(!$this->header->logged())
				{
					redirect(site_url('log_in'), 'refresh');
				}
			
			$data['username'] = "Welcome ".ucfirst(html_escape($this->session->userdata['logged_data']['username']));
			$data['log_out_button'] = LOG_OUT;
			$data['bread_crumb_title']="Create Business Card";


			$data['fkUserId'] = $this->session->userdata['logged_data']['member_id'];
			
			$this->load->model('model_auth');
			$data['user_domains'] = $this->model_auth->user_domains($this->session->userdata['logged_data']['member_id']);
			$this->load->view('header_view', $data);
			$this->load->view('left_menu_view');
			$this->load->view('sub_menu_two_view');
			$this->load->view('create_businesscard_view', $data);
			$this->load->view('footer_view');
		}
	public function insert()
		{
			
			$output_dir = "uploads/";
			
			
			if(isset($_FILES["logo"]))
			{
				//
				$config['upload_path'] = 'uploads/';
				$config['allowed_types'] = 'png';
				$config['max_size']	= '1000';
				$config['max_width']  = '600';
				$config['max_height']  = '600';
				$config['file_name']  = time().'.png';
				
				$this->load->library('upload', $config);
				
				if ( ! $this->upload->do_upload('logo'))
					{
						$error = array('error' => $this->upload->display_errors());
						print_r($error);
					}
				else
					{
						$data = array('upload_data' => $this->upload->data());
						echo 'success<br />';
					}
				//
				$data['photo'] = "<img id=\"target\" src = '".base_url('uploads/'.$config['file_name'])."'>";
				//$this->load->view('crop_view', $data);
				?>

				<script src="<?php echo base_url('components/js/crop.js');?>"></script>
<script type="text/javascript">

  jQuery(function($){

    var jcrop_api;

    $('#target').Jcrop({
      onChange:   showCoords,
      onSelect:   showCoords,
      onRelease:  clearCoords
    },function(){
      jcrop_api = this;
    });

    $('#coords').on('change','input',function(e){
      var x1 = $('#x1').val(),
          x2 = $('#x2').val(),
          y1 = $('#y1').val(),
          y2 = $('#y2').val();
      jcrop_api.setSelect([x1,y1,x2,y2]);
    });

  });

  // Simple event handler, called from onChange and onSelect
  // event handlers, as per the Jcrop invocation above
  function showCoords(c)
  {
    $('#x1').val(c.x);
    $('#y1').val(c.y);
    $('#x2').val(c.x2);
    $('#y2').val(c.y2);
    $('#w').val(c.w);
    $('#h').val(c.h);
  };

  function clearCoords()
  {
    $('#coords input').val('');
  };



</script>
 <!-- This is the image we're attaching Jcrop to -->
  <?php echo $data['photo'];?>

  <!-- This is the form that our event handler fills -->


    <div class="inline-labels">
	    <label>X1 <input type="text" size="4" id="x1" name="x1" /></label>
	    <label>Y1 <input type="text" size="4" id="y1" name="y1" /></label>
	    <label>X2 <input type="text" size="4" id="x2" name="x2" /></label>
	    <label>Y2 <input type="text" size="4" id="y2" name="y2" /></label>
	    <label>W <input type="text" size="4" id="w" name="w" /></label>
	    <label>H <input type="text" size="4" id="h" name="h" /></label>
	    <input type = "submit" type = "submit" id ="save_now">
    </div>

				
				<?php 
				/*
				 * 
				exit();
				//Filter the file types , if you want.
				if ($_FILES["logo"]["error"] > 0)
				{
					echo "Error: " . $_FILES["file"]["error"] . "<br>";
				}
				else
				{
					//move the uploaded file to uploads folder;
					move_uploaded_file($_FILES["logo"]["tmp_name"],$output_dir. $_FILES["logo"]["name"]);
			
					echo "Uploaded File :".$_FILES["logo"]["name"];
					echo "<img src = '".base_url($output_dir. $_FILES["logo"]["name"])."'>";
					echo base_url($output_dir. $_FILES["logo"]["name"]);
				}
				*/
			
			}
			exit();
			
			$config['image_library'] = 'gd2';
			$this->load->library('image_lib');
			
			$img = 'test.png';
			
			list($width, $height, $type, $attr) = getimagesize($img);
			
			echo $width;
			
			$config['image_library'] = 'gd2';
			$config['source_image'] = $img;
			$config['new_image'] = 'test2.png';
			$config['x_axis'] = '110';
			$config['y_axis'] = '40';
			$config['maintain_ratio'] = FALSE;
			$config['width'] = $width-$config['x_axis'];
			$config['height'] = $height-$config['y_axis'];
			$this->image_lib->initialize($config);
			
			
			if ( ! $this->image_lib->crop())
				{
					echo $this->image_lib->display_errors();
				}
			echo "<img src = \"".base_url('test2.png')."\">";
			exit();
			phpinfo();
			if($this->session->userdata['logged_data']['member_id']!=$this->input->post('fkUserId'))
				{
					echo "Error. Poster id and campaign owner do not match!"; Exit();
				}
			$posted_data = array();
			
			foreach($_POST as $val =>$row)
				{
					if($val=="buttonFormat_DB")
						{
							$val = "buttonFormat";
						}
					if($val=="buttonStyle_DB")
						{
							$val = "buttonStyle";
						}	
						
					if($val!='domain')
						{
							$posted_data[$val] = $row;
						}
				}	
				
			$this->db->insert('TACTIFY_cardTemplate', $posted_data);
			
			print_r($posted_data);
			exit();
			$this->load->library('header');
			$this->header->index();
			if(!$this->header->logged())
				{
					redirect(site_url('log_in'), 'refresh');
				}
			$data['username'] = $this->session->userdata['logged_data']['username'];
			$data['log_out_button'] = LOG_OUT;
			$this->load->view('header_view', $data);
			$this->load->view('left_menu_view');
			$this->load->view('sub_menu_two_view');
			$this->load->view('create_businesscard_view');
			$this->load->view('footer_view');
		}	
}
