<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require 'general.php';
class CArticle extends General {

    function __construct()
    {
        parent::__construct();
    }

    public function pages($page = 1)
    {
        if (!is_numeric($page)) {
            $this->doView('404');
            return;
        }

        $data['id'] = $this->input->get('id');
        $this->load->model('article');
        if ($data['id']) {
            $this->article->setId($data['id']);
            $article = (Array)$this->article->doSearch();
            if (!$article) {
                $this->doView('404');
                return;
            }
            $data['page'] = $article[0];
            $data['title'] = $article[0]->s_name;
            $this->doView('article',$data);
        } else {
            $data['list'] = 'article';
            $data['page'] = $this->input->post('page');
            if (!is_numeric($data['page']) || $data['page'] == '' || $data['page'] < 1) $data['page'] = 1;
            $this->article->setPage($data['page']);
            $data['article'] = (Array)$this->article->doSearch();
            $data['title'] = 'Article';
            if (IS_AJAX) {
                $this->load->view('catalog/list', $data);
            } else {
                $this->doView('article',$data);
            }
        }


    }

}
?>