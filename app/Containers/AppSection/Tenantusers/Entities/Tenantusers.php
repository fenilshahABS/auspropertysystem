<?php

namespace App\Containers\AppSection\Tenantusers\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="jp_tenantusers")
 */
class Tenantusers
{
    protected $user_id;
    protected $id_proof;
    protected $mobile_otp;
    protected $email_otp;
    protected $role_id;
    protected $role_id_encode;
    protected $first_name;
    protected $middle_name;
    protected $last_name;
    protected $mother_name;
    protected $profile_image_encode;
    protected $profile_image;
    protected $father_professional;
    protected $father_professional_type;
    protected $dob;
    protected $dobformat;
    protected $gender;
    protected $email;
    protected $user_email;
    protected $qrcode_url_image;
    protected $alternate_id;
    protected $mobile;
    protected $address;
    protected $country;
    protected $state;
    protected $city;
    protected $zipcode;
    protected $is_active;
    protected $oldpassword;
    protected $password;
    protected $newpassword;
    protected $newrepassword;
    protected $keyword;
    protected $notes;
    protected $user_encode_id;
    protected $useremail;
    protected $tpin;
    protected $search_val;
    protected $field_db;
    protected $per_page;

    public function __construct($request = null)
    {
        $this->id_proof             = isset($request['id_proof']) ? $request['id_proof'] : null;
        $this->user_id             = isset($request['user_id']) ? $request['user_id'] : null;
        $this->mobile_otp             = isset($request['mobile_otp']) ? $request['mobile_otp'] : null;
        $this->email_otp             = isset($request['email_otp']) ? $request['email_otp'] : null;
        $this->role_id             = isset($request['role_id']) ? $request['role_id'] : null;
        $this->role_id_encode             = isset($request['role_id_encode']) ? $request['role_id_encode'] : null;
        $this->first_name          = isset($request['first_name']) ? $request['first_name'] : null;
        $this->middle_name          = isset($request['middle_name']) ? $request['middle_name'] : null;
        $this->last_name          = isset($request['last_name']) ? $request['last_name'] : null;
        $this->mother_name          = isset($request['mother_name']) ? $request['mother_name'] : null;
        $this->profile_image          = isset($request['profile_image']) ? $request['profile_image'] : null;
        $this->profile_image_encode          = isset($request['profile_image_encode']) ? $request['profile_image_encode'] : null;
        $this->dob          = isset($request['dob']) ? $request['dob'] : null;
        $this->dobformat          = isset($request['dobformat']) ? $request['dobformat'] : null;
        $this->gender          = isset($request['gender']) ? $request['gender'] : null;
        $this->email          = isset($request['email']) ? $request['email'] : null;
        $this->useremail          = isset($request['useremail']) ? $request['useremail'] : null;
        $this->user_email          = isset($request['user_email']) ? $request['user_email'] : null;
        $this->qrcode_url_image          = isset($request['qrcode_url_image']) ? $request['qrcode_url_image'] : null;
        $this->alternate_id          = isset($request['alternate_id']) ? $request['alternate_id'] : null;
        $this->mobile          = isset($request['mobile']) ? $request['mobile'] : null;
        $this->address          = isset($request['address']) ? $request['address'] : null;
        $this->country          = isset($request['country']) ? $request['country'] : null;
        $this->state          = isset($request['state']) ? $request['state'] : null;
        $this->city          = isset($request['city']) ? $request['city'] : null;
        $this->zipcode          = isset($request['zipcode']) ? $request['zipcode'] : null;
        $this->is_active          = isset($request['is_active']) ? $request['is_active'] : null;
        $this->password          = isset($request['password']) ? $request['password'] : null;
        $this->oldpassword          = isset($request['oldpassword']) ? $request['oldpassword'] : null;
        $this->newpassword          = isset($request['newpassword']) ? $request['newpassword'] : null;
        $this->newrepassword          = isset($request['newrepassword']) ? $request['newrepassword'] : null;
        $this->father_professional          = isset($request['father_professional']) ? $request['father_professional'] : null;
        $this->father_professional_type          = isset($request['father_professional_type']) ? $request['father_professional_type'] : null;
        $this->keyword          = isset($request['keyword']) ? $request['keyword'] : null;
        $this->notes          = isset($request['notes']) ? $request['notes'] : null;
        $this->user_encode_id          = isset($request['user_encode_id']) ? $request['user_encode_id'] : null;
        $this->tpin          = isset($request['tpin']) ? $request['tpin'] : null;
        $this->search_val =  isset($request['search_val']) ? $request['search_val'] : null;
        $this->field_db =   isset($request['field_db']) ? $request['field_db'] : null;
        $this->per_page = isset($request['per_page']) ? $request['per_page'] : null;
    }

    public function getIdProof()
    {
        return $this->id_proof;
    }

    public function getTPIN()
    {
        return $this->tpin;
    }
    public function getUserEncodeID()
    {
        return $this->user_encode_id;
    }
    public function getNotes()
    {
        return $this->notes;
    }

    public function getMobileOtp()
    {
        return $this->mobile_otp;
    }

    public function getEmailOtp()
    {
        return $this->email_otp;
    }
    public function getFatherProfessionalType()
    {
        return $this->father_professional_type;
    }
    public function getFatherProfessional()
    {
        return $this->father_professional;
    }
    public function getUserID()
    {
        return $this->user_id;
    }
    public function getNewRePassword()
    {
        return $this->newrepassword;
    }
    public function getNewPassword()
    {
        return $this->newpassword;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getOldPassword()
    {
        return $this->oldpassword;
    }
    public function getRoleID()
    {
        return $this->role_id;
    }
    public function getRoleIDEncode()
    {
        return $this->role_id_encode;
    }
    public function getFirstName()
    {
        return $this->first_name;
    }
    public function getMiddleName()
    {
        return $this->middle_name;
    }
    public function getAlternateID()
    {
        return $this->alternate_id;
    }
    public function getLastName()
    {
        return $this->last_name;
    }
    public function getMotherName()
    {
        return $this->mother_name;
    }
    public function getProfileImage()
    {
        return $this->profile_image;
    }
    public function getProfileImageEncode()
    {
        return $this->profile_image_encode;
    }

    public function getDOB()
    {
        return $this->dob;
    }
    public function getDOBFormat()
    {
        return $this->dobformat;
    }
    public function getGender()
    {
        return $this->gender;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getUserEmail()
    {
        return $this->user_email;
    }
    public function getUsersemail()
    {
        return $this->useremail;
    }
    public function getQRCodeURLImage()
    {
        return $this->qrcode_url_image;
    }
    public function getMobile()
    {
        return $this->mobile;
    }
    public function getAddress()
    {
        return $this->address;
    }
    public function getCountry()
    {
        return $this->country;
    }
    public function getState()
    {
        return $this->state;
    }
    public function getCity()
    {
        return $this->city;
    }
    public function getZipcode()
    {
        return $this->zipcode;
    }
    public function getIsActive()
    {
        return $this->is_active;
    }
    public function getKeyword()
    {
        return $this->keyword;
    }

    public function getSearchVal()
    {
        return $this->search_val;
    }

    public function getFieldDB()
    {
        return $this->field_db;
    }

    public function getPerPage()
    {
        return $this->per_page;
    }
}
