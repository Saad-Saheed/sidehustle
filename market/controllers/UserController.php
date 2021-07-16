<?php

include_once('./models/User.php');


class UserController extends User{

    public function index()
    {
        $this->connect();

        $res = $this->read();

        $this->disconnect();

        return $res;

    }

    public function c_create($request)
    {
        $message = array();

        $this->connect();
        $res = false;
        
        // validations
        $data = [
            'name' => FILTER_SANITIZE_STRING,
            'email' => FILTER_SANITIZE_EMAIL,
            'phone' => FILTER_SANITIZE_STRING,
            'gender' => FILTER_SANITIZE_STRING,
            'password' => FILTER_SANITIZE_STRING
        ];

        $clean_data = filter_input_array(INPUT_POST, $data, false);
                 
        // Testing each input
        foreach ($clean_data as $key => $input) {

            if (empty($input))
                $message[$key] = "Invalid input, Your $key is required";
        }
        // end validations

        if(empty($message)){

            $this->name = $clean_data['name'];
            $this->email = $clean_data['email'];
            $this->phone = $clean_data['phone'];
            $this->gender = $clean_data['gender'];
            $this->password = md5($clean_data['password']);

            $res = $this->create();

            if($res)
                $message['general'] = "User registered Successfully";
            else 
                $message['general'] = "registration failed! avoid using existing phone number or email";

            return [$clean_data, $message];

        }else{
            return [$clean_data, $message];
        } 

    }

    public function c_show($id)
    {
        $this->connect();

        $this->id = $id;
        $res = $this->read_single();

        $this->disconnect();

        return $res;
    }
    

    /**
     * update user data
    * @param {$request, $id} params 
    */
    public function c_update($request, $id)
    {
       $this->connect();
        
        $this->id = $id;

        $data = [
            'name' => FILTER_SANITIZE_STRING,
            'email' => FILTER_SANITIZE_EMAIL,
            'phone' => FILTER_SANITIZE_STRING,
            'gender' => FILTER_SANITIZE_STRING,
        ];

        $clean_data = filter_input_array(INPUT_POST, $data, false);
        
        // Testing each input
        foreach ($clean_data as $key => $input) {

            if (empty($input))
                $message[$key] = "Invalid input, Your $key is required";
        }

        $this->name = $clean_data['name'];
        $this->email = $clean_data['email'];
        $this->phone = $clean_data['phone'];
        $this->gender = $clean_data['gender'];

        $res = $this->update();
            

        $this->disconnect();

        if($res){
            $message['general'] = "User Updated Successfully";
            return [$clean_data, $message];
        }
        else{
            $message['general'] = "unable to update user or no change made!";
            return [$clean_data, $message];
        }
    }
    
    public function c_delete($id)
    {
        $message = [];
        
        $this->connect();

        $this->id = $id;
        $res = $this->delete();

        $this->disconnect();

        if ($res) {
            $message['success'] = "User deleted Successfully";
            return $message;
        } else {
            $message['general'] =  "unable to delete user!";
            return $message;
        }
    }

    /**
     * User Login 
     * @param {$request} Form Post Resquest
     */
    public function c_login($request)
    {
        $message = [];
        $res = null;

        $this->connect();

        $data = [
            'email' => FILTER_SANITIZE_EMAIL,
            'password' => FILTER_SANITIZE_STRING
        ];

        $clean_data = filter_input_array(INPUT_POST, $data);

         // Testing each input
         foreach ($clean_data as $key => $input) {

            if (empty($input))
                $message[$key] = "Invalid input, Your $key is required";
        }

        $this->email = $clean_data['email'];
        $this->password = md5($clean_data['password']);

       // if their is no error message
       if(empty($message)) {
            $res = $this->login();
        }else{
            return [$clean_data, $message, $res];
        }

        $this->disconnect();

        if($res){
            $message['general'] = "Login Successfully";
            return [$clean_data, $message, $res];
        }
        else{
            $message['general'] = "Invalid Credentials Supplied!";
            return [$clean_data, $message, $res];
        }
    }


    /**
     * Reset User Password
     * @param {$request}
     * Post request that contains email and password
     */
    public function c_passwordReset($request)
    {
        $message = [];
        $res = null;

        $this->connect();

        $data = [
            'email' => FILTER_SANITIZE_EMAIL,
            'password' => FILTER_SANITIZE_STRING
        ];

        $clean_data = filter_input_array(INPUT_POST, $data);

         // Testing each input
         foreach ($clean_data as $key => $input) {

            if (empty($input))
                $message[$key] = "Invalid input, Your $key is required";
        }

        $this->email = $clean_data['email'];
        $this->password = md5($clean_data['password']);

        // if their is no error message
        if(empty($message)) {
            $res = $this->password_reset();
         }else{
            return [$clean_data, $message];
         }

        $this->disconnect();

        if($res){
            $message['general'] = "Password Updated Successfully";
            return [$clean_data, $message];
        }
        else{
            $message['general'] = "Invalid Credentials Supplied or no change made!";
            return [$clean_data, $message];
        }
    }


}
