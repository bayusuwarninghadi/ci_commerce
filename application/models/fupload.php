<?php
class Fupload extends CI_Model
{

    public $gallery_path;
    public $gallery_path_url;

    function __construct($_config = array())
    {
        $this->table = 't_category';
        $path = isset($_config['path']) ? $_config['path'] : 'images';
        $this->gallery_path = realpath(APPPATH . '../' . $path);
        $this->gallery_path_url = base_url() . $path . '/';
        $this->gallery_real_url = $path . '/';
    }

    function do_upload($fileName = null , $fieldName = 'userfile', $width = 500, $height = 400)
    {
        $config = array(
            'allowed_types' => 'jpg|jpeg|gif|png',
            'upload_path' => $this->gallery_path,
            'max_size' => 0
        );

        if ($fileName != null) {
            $config['file_name'] = $fileName;
            $config['overwrite'] = true;
        }
        $this->load->library('upload', $config);
        $return = $this->upload->do_upload($fieldName);
        $image_data = $this->upload->data();
        $config = array(
            'source_image' => $image_data['full_path'],
            'new_image' => $this->gallery_path . '/thumbs',
            'maintain_ration' => true,
            'width' => $width,
            'height' => $height
        );

        if ($fileName != null) {
            $config['file_name'] = $fileName;
            $config['overwrite'] = true;
        }

        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        return $return ? $this->upload->data() : false;
    }

    function delete_file($file_name){
        $files = array($this->gallery_real_url, $this->gallery_real_url.'/thumbs/');
        foreach ($files as $file){
            unlink($file.$file_name);
        }
    }

    function get_images()
    {
        $files = scandir($this->gallery_path);
        $files = array_diff($files, array('.', '..', 'thumbs'));

        $images = array();

        foreach ($files as $file) {
            $images [] = array(
                'url' => $this->gallery_path_url . $file,
                'thumb_url' => $this->gallery_path_url . 'thumbs/' . $file
            );
        }

        return $images;
    }


}

?>