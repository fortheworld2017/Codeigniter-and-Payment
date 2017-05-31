<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_auth extends CI_Model {

	public function check_password_reset_auth($email, $token)
		{
			$sql = "SELECT *
					FROM user 
					WHERE  sha1(email) = ?
					AND temp_pass_key = ? ";
			$query = $this->db->query($sql, array($email, $token));
			return $query->result();
		}	
	
	public function temp_pass_key($email, $temp_key, $temp_pass_key_expiry)
		{
			$data = array(
					'temp_pass_key' => $temp_key,
					'temp_pass_key_expiry' => $temp_pass_key_expiry
			);
			
			$this->db->where('email', $email);
			$this->db->update('user', $data);
		}		
	public function check_credentials($username)
		{
			$this->db->select('*');
			$this->db->from('user');
			$this->db->where('username', $username);
			$query = $this->db->get();
			return $query->result();
		}	
	public function check_email($email)
		{
			$this->db->select('email');
			$this->db->from('user');
			$this->db->where('email', $email);
			$query = $this->db->get();
			return $query->result();
		}

	public function member_details($id)
		{
			$this->db->select('*');
			$this->db->from('user');
			$this->db->where('id', $id);
			$query = $this->db->get();
			return $query->result();
		}	
	public function user_domains($id)
		{
			$sql = "
			SELECT 
				domain.name AS DOMAIN,
				domain.id AS DID
					FROM   domain
						INNER JOIN userDomains
							ON domain.id = userDomains.fkDomainId
						WHERE  userDomains.fkuserid = ?";
			$query = $this->db->query($sql, array($id));
			return $query->result();
		}

	public function user_templates($id)
		{
			$sql = "
				SELECT id, templateName
				FROM TACTIFY_cardTemplate
				WHERE TACTIFY_cardTemplate.fkUserId = ? 
				AND cardType = 1 
				GROUP BY TACTIFY_cardTemplate.id
				ORDER BY templateName
				";
				$query = $this->db->query($sql, array($id));
				return $query->result_array();

		}	
		
	public function template_details($id, $member_id)
		{
			$sql = "
			SELECT
				* 
					FROM  TACTIFY_cardTemplate
						WHERE TACTIFY_cardTemplate.id = ? 
					AND fkUserId = ?";
			$query = $this->db->query($sql, array($id, $member_id));
			return $query->result();
		}

	public function list_templates($member_id)
		{
			$sql = "
			SELECT
				* 
					FROM  TACTIFY_cardTemplate
						WHERE fkUserId = ?";
			$query = $this->db->query($sql, array($member_id));
			return $query->result();
		}

		public function list_groups($member_id)
			{
				$sql = "
				SELECT
					* 
						FROM  TACTIFY_groups
							WHERE fkUserId = ?
						ORDER BY name";
				$query = $this->db->query($sql, array($member_id));
				return $query->result();
			}	
		

	public function list_cards($member_id)
		{
			$sql = "
			SELECT
				* 
					FROM  TACTIFY_cardDetails
						WHERE fkUserId = ?";
			$query = $this->db->query($sql, array($member_id));
			return $query->result();
		}

	public function list_cards_with_no_group($member_id)
		{
			$sql = "
			SELECT
				* 
					FROM  TACTIFY_cardDetails
						WHERE fkUserId = ?
							AND fkGroupId IS NULL";
			$query = $this->db->query($sql, array($member_id));
			return $query->result();
		}

	public function group_details($member_id, $id)
		{
			$sql = "
			SELECT
				* 
					FROM  TACTIFY_groups
						WHERE fkUserId = ?
						AND 
							  id = ?
							";
			$query = $this->db->query($sql, array($member_id, $id));
			return $query->result();
		}			

			
		


		
		
}