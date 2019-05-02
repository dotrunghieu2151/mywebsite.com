<?php
class View {
    protected $viewName = '';
    protected $viewData = [];
    public function __construct($viewName,$viewData) {
        $this->viewName = $viewName;
        $this->viewData = $viewData;
    }
    public function render(){
        if (file_exists(VIEW . $this->viewName . ".phtml")) {
            if (filter_has_var(INPUT_POST, "getData")) {
                ob_start();
                require VIEW . $this->viewName . ".phtml";
                $response = ob_get_clean();
                echo json_encode([
                   "pageTitle" => $this->viewData["pageTitle"],
                    "html" => $response
                ]);
                die();
            } else {
                require_once VIEW . "header.phtml";
                require_once VIEW . $this->viewName . ".phtml";
                require_once VIEW . "loading.phtml";
                require_once VIEW . "footer.phtml";
            }
        } 
        else {
            new errorHandler(404);
        }
    }
    public static function paginate($totalPages,$currPage,$link){
            ob_start();
            require VIEW.DS."pagination.phtml";
            $pagination = ob_get_clean();
            return $pagination;
        }
}
