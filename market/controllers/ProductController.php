<?php

include_once('./models/Product.php');

class ProductController extends Product
{

    /**
     * Get all products
     */
    public function index()
    {
        $this->connect();

        $res = $this->read();

        $this->disconnect();

        return $res;
    }

    /**
     * Get all products
     */
    public function my_product()
    {
        session_write_close();
        session_start();
        $auth_user = (isset($_SESSION['current_user'])) ? $_SESSION['current_user'] : null;
        $auth_user = (object) json_decode(base64_decode($auth_user));


        $this->connect();

        $res = $this->get_myproduct($auth_user->id);

        $this->disconnect();

        return $res;
    }

    public function c_create($request)
    {
        session_write_close();
        session_start();
        $auth_user = (isset($_SESSION['current_user'])) ? $_SESSION['current_user'] : null;
        $auth_user = (object) json_decode(base64_decode($auth_user));


        $message = array();
        $image_name = "";
         
        $this->connect();
        $res = false;

        // validations
        $data = [
            'name' => FILTER_SANITIZE_STRING,
            'description' => FILTER_SANITIZE_STRING,
            'image' => FILTER_SANITIZE_STRING,
            'price' => FILTER_SANITIZE_NUMBER_FLOAT
        ];

        $clean_data = filter_input_array(INPUT_POST, $data, false);

        // Testing each input
        foreach ($clean_data as $key => $input) {

            if (empty($input))
                $message[$key] = "Invalid input, Product $key is required";
        }

        $this->validate_Image($message, $image_name);
      

        // end validations

        if (empty($message)) {

            $this->name = $clean_data['name'];
            $this->description = $clean_data['description'];
            $this->image = $image_name;
            $this->price = $clean_data['price'];
            $this->user_id = $auth_user->id;

            $res = $this->create();
            $this->disconnect();

            if ($res)
                $message['success'] = "Product created Successfully";
            else
                $message['general'] = "unable to create product!";

            return [$clean_data, $message];
        } else {
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
    public function c_update($request, $this_product)
    {
        session_write_close();
        session_start();
        $auth_user = (isset($_SESSION['current_user'])) ? $_SESSION['current_user'] : null;
        $auth_user = (object) json_decode(base64_decode($auth_user));




        $message = [];
        $image_name = "";
        $old_image =  $this_product->image;

        $this->id = $this_product->id;

        $data = [
            'name' => FILTER_SANITIZE_STRING,
            'description' => FILTER_SANITIZE_STRING,
            'price' => FILTER_SANITIZE_NUMBER_FLOAT,
        ];

        $clean_data = filter_input_array(INPUT_POST, $data, false);

        // Testing each input
        foreach ($clean_data as $key => $input) {

            if (empty($input))
                $message[$key] = "Invalid input, Product $key is required";
        }

        //if they update their photo or if photo field is empty
        if(isset($_FILES['image']) && !empty($_FILES['image']['name']))
            $this->validate_Image($message, $image_name);
        else
            $image_name = "";
    
        // end validations

        if (empty($message)) {

            $this->name = $clean_data['name'];
            $this->description = $clean_data['description'];
            $this->image = $image_name;
            $this->price = $clean_data['price'];


            $this->connect();

            //if you are the creator of this product
            if($auth_user->id == $this_product->user_id){
                $res = $this->update();
            }else{
                $message['general'] =  "you can't update someone else product!";
                return [$clean_data, $message];
            }
    
            $this->disconnect();

            if ($res){
                //delete old image if exist
                if(isset($_FILES['image']) && !empty($_FILES['image']['name'])){
                    if(is_file('./assets/images/products/'.$old_image))
                        unlink('./assets/images/products/'.$old_image);
                }
                $message['general'] = "Product Updated Successfully";
            }else
                $message['general'] = "unable to update product or no change made!";

            return [$clean_data, $message];

        } else {
            
            return [$clean_data, $message];
        }
    }

    public function c_delete($id)
    {
        session_write_close();
        session_start();
        $auth_user = (isset($_SESSION['current_user'])) ? $_SESSION['current_user'] : null;
        $auth_user = (object) json_decode(base64_decode($auth_user));

        $message = [];
       

        $this->id = $id;

        $this_product = (object)$this->c_show($id);

        $this->connect();
        //if you are the creator of this product
        if($auth_user->id == $this_product->user_id){
            $res = $this->delete();
        }else{
            $message['general'] =  "you can't delete someone else product!";
            return $message;
        }

        $this->disconnect();

        if ($res) {
            $message['success'] = "Product deleted Successfully";
            return $message;
        } else {
            $message['general'] =  "unable to delete product!";
            return $message;
        }
    }

    /**
     * Validate Image -
     * validate image uploaded by user
     */
    private function validate_Image(&$message, &$image_name)
    {

          //validate image input
          $format_allowed = ["jpg", "jpeg", "png"];
          //  get the image name
          $image_name = isset($_FILES['image']) ? basename($_FILES['image']['name']) : "";

          //  let create image directory if not exist
          if (!file_exists("./assets/images/products")) {
              mkdir("./assets/images", 0766);
              mkdir("./assets/images/products", 0766);
          }

          if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
              // if the image type is allowed
              $ext = strtolower(pathinfo(basename($image_name), PATHINFO_EXTENSION));
              if (!in_array($ext, $format_allowed)) {
                  $message['image'] = 'Only jpeg, png and jpg format are supported';
              }
              // if the file uploaded is not an original image 
              elseif (!getimagesize($_FILES['image']['tmp_name'])) {
                $message['image'] = 'This file is not an image';
              } 
              elseif ($_FILES['image']['size'] > 1000000) {
                //set the maximum size for an image
                $message['image'] = 'This image is greater than 1MB';
              }
               // if the file uploaded is exist in the image folder 
              elseif (file_exists("./assets/images/products/" . $image_name)) {
                $message['image'] = 'This image alreeady exist in your folder';
              }             
              // if the image was moved successfuly to the desire folder
              else{
                $image_name = time().$image_name; 
                if(!move_uploaded_file($_FILES['image']['tmp_name'], "./assets/images/products/" . $image_name)) { 
                    $message['image'] = 'unable to upload image' . $_FILES['product_image']['error'];
                }
              }
          } else {
              // if error occur while uploading image to the temporary storage in the server
                switch ($_FILES['image']['error']) {
                    case UPLOAD_ERR_INI_SIZE:
                        $message['image'] = 'the image size is larger than the server allows';
                        break;

                    case UPLOAD_ERR_FORM_SIZE:
                        $message['image'] = "This image is greater than 1MB";
                        break;

                    case UPLOAD_ERR_NO_FILE:
                        $message['image'] = 'No file uploaded, make sure you choose an image to upload';
                        break;

                    default:
                        $message['image'] = 'Contact your server Administrator for help';
              }
          }
       
    }
}
