<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tests3 extends CI_Controller {
	  
	public function index()
		{
			//Load library
			$this->load->library('s3');

			// List Buckets
			var_dump($this->s3->listBuckets());
			//var_dump($this->s3->getBucket("tactify-images"));
			
			/**
		        * Put an object
		        *
		        * @param mixed $input Input data (local file name)
		        * @param string $bucket Bucket name
		        * @param string $uri Object URI (filename on S3)
			*
			* url of example should be: http://d3ec3txkdh9tcy.cloudfront.net/test2.png
			*/
			
			if($this->s3->putObject(S3::inputFile("test2.png"),"tactify-images","test2.png",S3::ACL_PUBLIC_READ))
				echo "Successfuly uploaded.";
			else
				echo "Something wrong.";
		}
}
