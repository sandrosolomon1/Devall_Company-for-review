<?php

namespace Devall\Company\Controller\Company;

class Edit extends \Magento\Framework\App\Action\Action {
    public function execute() {
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}
